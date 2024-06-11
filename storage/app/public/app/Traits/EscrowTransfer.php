<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\Config;
use \MangoPay\MangoPayApi as MangoPay;

trait EscrowTransfer
{
    protected function getMangopayConfig()
    {
        return Config::get('helpers.mango_pay_config');
    }
    protected function getMangopayApi()
    {
        $data =  Config::get('helpers.mango_pay');
        $mangoPayApi = new MangoPay();
        $mangoPayApi->Config->ClientId = $data['client_id'];
        $mangoPayApi->Config->ClientPassword = $data['client_password'];
        $mangoPayApi->Config->TemporaryFolder = '../../';
        $mangoPayApi->Config->BaseUrl = $data['base_url'];

        return $mangoPayApi;
    }

    public function transferToUser($debit , $credit, $amount, $description , $fee , $type , $ref_amount , $refree_credit , $kyc_return)
    {
        try {
            $seller_amount = (float)$amount - (float)$fee;
            $api = $this->getMangopayApi();
            $data = $this->getMangopayConfig();
            $Transfer = new \MangoPay\Transfer();
            $Transfer->AuthorId =  $debit->store->mango_id;
            $Transfer->CreditedUserId = $credit->store->mango_id;
            $Transfer->DebitedFunds = new \MangoPay\Money();
            $Transfer->DebitedFunds->Currency = $data['currency'];
            $Transfer->DebitedFunds->Amount = $amount*100;
            $Transfer->Fees = new \MangoPay\Money();
            $Transfer->Fees->Currency = $data['currency'];
            $Transfer->Fees->Amount = $fee*100;
            $Transfer->DebitedWalletId = $debit->default_wallet->wallet_id;
            $Transfer->CreditedWalletId = $credit->default_wallet->wallet_id;
            $Transfer->Tag = $description;
            $Result = $api->Transfers->Create($Transfer);
                            
            transactionRecord($credit->id ,$debit->id , null, $Result->Id , $type ,$amount , $seller_amount , $fee ,0 ,null , $ref_amount , $refree_credit ,$kyc_return );
            return $Result->Status == "SUCCEEDED" ? $Result->Id : null;
        } catch (\Exception $e)
        {
        }
    }
    public function transferOldAmountTONewWallet($credit_user , $debit_user , $total , $description , $order_id = null)
    {
        $debit_user =(object)$debit_user;
        $credit_user =(object)$credit_user;
        try {
            $api = $this->getMangopayApi();

            $data = $this->getMangopayConfig();


            $Transfer = new \MangoPay\Transfer();
            $Transfer->AuthorId = $debit_user->id;
            $Transfer->CreditedUserId = $credit_user->id;
            $Transfer->DebitedFunds = new \MangoPay\Money();
            $Transfer->DebitedFunds->Currency = $data['currency'];
            $Transfer->DebitedFunds->Amount = $total;
            $Transfer->Fees = new \MangoPay\Money();
            $Transfer->Fees->Currency = $data['currency'];
            $Transfer->Fees->Amount = 0;
            $Transfer->DebitedWalletId = $debit_user->wallet_id;
            $Transfer->CreditedWalletId = $credit_user->wallet_id;
            $Transfer->Tag = $description;
            $Result = $api->Transfers->Create($Transfer);
            $total = $total/100;
            transactionRecord(auth()->user()->id ,auth()->user()->id , null, $Result->Id , "credit" ,$total , 0 ,0 ,0 ,null , 0,0 ,0);

            return $Result->Id;
        } catch (\Exception $e) {
        }
    }
    public function refund($debit,$credit, $description , $type , $transaction , $vfs_fee , $amount)
    {
        try{
            $api = $this->getMangopayApi();
            $data = $this->getMangopayConfig();
            $transferId = $transaction->transaction_id;
            $fee = $vfs_fee*100;

            $refund = new \MangoPay\Refund();
            $refund->AuthorId = $credit->store->mango_id;
            $refund->DebitedFunds = new \MangoPay\Money();
            $refund->DebitedFunds->Amount = $amount*100;
            $refund->DebitedFunds->Currency = $data['currency'];
            $refund->Fees = new \MangoPay\Money();
            $refund->Fees->Amount = $fee > 0 ? (-$fee) : 0 ;
            $refund->Fees->Currency = $data['currency'];
            $refund->Tag = $description;
            
            $Result = $api->Transfers->CreateRefund($transferId, $refund);

            transactionRecord($credit->id,
                                $debit->id , 
                                null,
                                $Result->Id ,
                                $type ,
                                ($amount+$vfs_fee) ,
                                (-$amount) ,
                                ($vfs_fee == 0 ?  0 :-$transaction->fee) ,
                                0 ,
                                null ,
                                ($vfs_fee == 0 ?  0 : $transaction->buyer_referal_debit) ,
                                ($vfs_fee == 0 ?  0 : -$transaction->referee_credit) ,
                                ($vfs_fee == 0 ?  0 : -$transaction->seller_kyc_return)
                            );

            return $Result->Id;
        }
        catch(Exception $e)
        {
        }
    }
}

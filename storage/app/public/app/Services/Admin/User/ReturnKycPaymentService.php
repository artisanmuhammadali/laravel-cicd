<?php

namespace App\Services\Admin\User;

use App\Models\Order;
use App\Models\Postage;
use App\Models\User;
use App\Models\UserStore;
use Carbon\Carbon;
use Exception;
use \MangoPay\MangoPayApi as MangoPay;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class ReturnKycPaymentService {

    private $mangoPayApi;

    public function __construct()
    {
        $data = Config::get('helpers.mango_pay');
        $this->mangoPayApi = new MangoPay();
        $this->mangoPayApi->Config->ClientId = $data['client_id'];
        $this->mangoPayApi->Config->ClientPassword = $data['client_password'];
        $this->mangoPayApi->Config->TemporaryFolder = '../../';
        $this->mangoPayApi->Config->BaseUrl = $data['base_url'];
        // $this->mangoPayApi->Config->BasGBPl = 'https://api.sandbox.mangopay.com';
    }

    public function returnPayment($id)
    {
        $user = User::where('id',$id)
                    ->whereHas('store',function($q){
                        $q->where('return_kyc_payment',0)
                            ->where('kyc_payment_id','!=',null)
                            ->where('kyc_payment',true);
                    })
                    ->first();
        if($user && $user->sellingOrders->count() >= 1)
        {
            $data =  Config::get('helpers.mango_pay_config');
            $saleRevenue  = userVfsRevenue($id , 'sale');
            // $purchaseRevenue = userVfsRevenue($id , 'purchase');
            $revenue = $saleRevenue;
            try{
                $transaction = $this->mangoPayApi->PayIns->Get($user->store->kyc_payment_id);
                $pagination = new \MangoPay\Pagination(1 ,50);
                $filter = new \MangoPay\FilterRefunds();
                $filter->Status = "SUCCEEDED";
                $already = $this->mangoPayApi->PayIns->GetRefunds($user->store->kyc_payment_id ,$pagination, $filter);
                $amt = $transaction->Fees->Amount/100;
                if($revenue >= $amt && count($already) == 0 && $amt != 0)
                {
                    $transferId = $transaction->Id;
                    $fee = ($transaction->Fees->Amount);
                    
                    $refund = new \MangoPay\Refund();
                    $refund->AuthorId = $user->store->mango_id;
                    $refund->DebitedFunds = new \MangoPay\Money();
                    $refund->DebitedFunds->Amount = 0.1*100;
                    $refund->DebitedFunds->Currency = $data['currency'];
                    $refund->Fees = new \MangoPay\Money();
                    $refund->Fees->Amount = (-$fee);
                    $refund->Fees->Currency = $data['currency'];
                    $refund->Tag = 'Return User kyc payment';
                    
                    $Result = $this->mangoPayApi->PayIns->CreateRefund($transferId, $refund);
                    $return_amt = $transaction->CreditedFunds->Amount/100;
                    $return_fee = $fee/100;
                    if($Result->Status != "FAILED")
                    {
                        UserStore::where('user_id',$user->id)->update(['return_kyc_payment'=>1]);
                        $sub = $user->role == "seller" ? 'KYC PAYMENT REFUNDED - VERY FRIENDLY SHARKS' : 'KYB PAYMENT REFUNDED - VERY FRIENDLY SHARKS';
                        transactionRecord($user->id ,null , null, $Result->Id , 'refund' ,$return_amt , 0 , (-$return_fee) ,0 ,null , 0 , 0 ,0);
                        sendMail([
                            'view' => 'email.account.return-kyc-payment',
                            'to' => $user->email,
                            'subject' => $sub,
                            'data' => [
                                'user'=>$user,
                                'amount'=>$return_amt+$return_fee,
                            ]
                        ]);
                    }
                    // return $Result->Id;
                }
                if($amt == 0)
                {
                    
                }
            }
            catch(Exception $e)
            {
                Log::info($e);
            }    
        }
        return true;
    }
}
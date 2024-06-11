<?php

namespace App\Http\Controllers\Admin\Accounts;

use App\DataTables\Admin\Accounts\UserWithdrawDataTable;
use App\DataTables\Admin\User\UserTransactionDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PayoutRequest;
use App\Models\Transaction;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use \MangoPay\MangoPayApi as MangoPay;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class WithdrawController extends Controller
{
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
    public function index(UserWithdrawDataTable $dataTable)
    {
        $assets = ['data-table'];
        return $dataTable->with('order',1)->render('admin.accounts.withdraw.index', get_defined_vars());
    }
    public function detail($id , UserTransactionDataTable $dataTable)
    {
        $item = PayoutRequest::findOrFail($id);
        $user = User::find($item->user_id);
        if($user->store->mangopay_account_id)
        {
            $userId = $user->store->mango_id;
            $bankAccountId = $user->store->mangopay_account_id;
            $bank = $this->mangoPayApi->Users->GetBankAccount($userId, $bankAccountId);
        }
        $wallet = $this->mangoPayApi->Wallets->Get($user->default_wallet->wallet_id);
        $walletAmount =$wallet->Balance->Amount/100;
        $statuses = withdrawStatus();
        $bg = $statuses[$item->status];
        return $dataTable->with('id',$item->user_id)->render('admin.accounts.withdraw.detail', get_defined_vars());
    }
    public function modal($id = null)
    {
        $item = PayoutRequest::findOrFail($id);
        $html = view('admin.accounts.withdraw.modal',get_defined_vars())->render();
        return response()->json(['html'=>$html]);
    }
    public function update(Request $request)
    {
        if($request->status == "rejected" && !$request->reason)
        {
            return redirect()->back()->with('error','Reason is required.');
        }
        $item = PayoutRequest::findOrFail($request->id);
        $item->updated_by = auth()->user()->id;
        $item->status = $request->status;
        $item->reason = $request->reason ?? null;
        $item->save();
        if($request->status == "approved")
        {
            $id = $this->payoutForAdmin($item);
            $item->transaction_id = $id;
            $item->save();
        }
        $user = User::find($item->user_id);
        sendMail([
            'view' => 'email.account.widthdraw-request',
            'to' => $user->email,
            'subject' => 'WITHDRAWAL REQUEST '. strtoupper($request->status),
            'data' => [
                'subject'=>'WITHDRAWAL REQUEST '. strtoupper($request->status),
                'user'=>$user,
                'item'=>$item,
                'date'=>$item->created_at->format('Y/m/d')
            ]
        ]);
        return redirect()->back()->with('success','Payout request process successfully.');
    }
    public function payoutForAdmin($item)
    {
        $user = User::find($item->user_id);

        if($this->checkFunds($item->amount , $user))
        {
            try {
                $store = $user->store;

                $bank = $this->mangoPayApi->Users->GetBankAccount($store->mango_id, $store->mangopay_account_id);
                $iban = $bank->Details->IBAN;
                $country = substr($iban, 0, 2);
                $fee = $country == "GB" ? 45 : 200;
                 
                $PayOut = new \MangoPay\PayOut();
                $PayOut->AuthorId = $store->mango_id;
                $PayOut->CreditedUserId = $store->mango_id;
                $PayOut->DebitedWalletID = $user->default_wallet->wallet_id;

                $PayOut->DebitedFunds = new \MangoPay\Money();
                $PayOut->DebitedFunds->Currency = "GBP";
                $PayOut->DebitedFunds->Amount = $item->amount*100;

                $PayOut->Fees = new \MangoPay\Money();
                $PayOut->Fees->Currency = "GBP";
                $PayOut->Fees->Amount = $fee;
                $PayOut->PaymentType = "BANK_WIRE";

                $PayOut->MeanOfPaymentDetails = new \MangoPay\PayOutPaymentDetailsBankWire();
                $PayOut->MeanOfPaymentDetails->BankAccountId = $store->mangopay_account_id;
                $result = $this->mangoPayApi->PayOuts->Create($PayOut);

                transactionRecord($user->id , null , null , $result->Id , "payout" ,$item->amount , 0,0,0,null,0,0 , 0);
                return $result->Id;
            } catch (\Exception $e) {
                Log::info('Error while payout.....');
                Log::info($e);
                return response()->json(['error'=> 'Something went wrong.']);
                
            }
            return response()->json(['success' => 'Your transaction is being processed!']);
        }
        else{
            return response()->json(['error'=>'Withdrawal amount greater then available funds of user.']);
        }
    }
    public function checkFunds($total , $user)
    {
        $total = (float) $total;
        try {
            $balance = $this->userWallet($user);
            $response = $balance >= $total ? true : false;
            return $response;
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function userWallet($user)
    {
        try {
            $wallet = $user->default_wallet;
            $clearence = userClearenceAmount();
            if($wallet)
            {
                $wallet = $this->mangoPayApi->Wallets->Get($wallet->wallet_id);
                $balance = $wallet->Balance->Amount/100;
                $amount =  $balance < $clearence ? 0:$balance-$clearence;
                return abs($amount) < 1e-10 ? 0.00 : number_format($amount, 2, '.', '');
            }
            return 0.00;
        } catch (Exception $e) {
            return 0.00;
        }
    }
    public function userClearenceAmount($id)
    {
        $user = User::find($id);
        $status = ["completed","cancelled" ,"refunded"];
        $transaction_types = ['order-transfer','extra'];
        $order_ids = Order::where('seller_id',$user->id)->whereNotIn('status',$status)->pluck('id')->toArray();
        $totalAmount = Transaction::whereIn('order_id',$order_ids)->whereIn('type',$transaction_types)->sum('seller_amount');
        $referalAmount = $user->store->vfs_wallet ?? 0;
        return $totalAmount +$referalAmount;
    }
}

<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\DataTables\User\TransactionDataTable;
use App\Models\PaymentCard;
use App\Models\PayoutRequest;
use App\Models\User;
use App\Services\User\MangoPayService;
use \MangoPay\MangoPayApi as MangoPay;
use Illuminate\Support\Facades\Config;

class TransactionController extends Controller
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
    public function list(TransactionDataTable $dataTable , MangoPayService $mangoPayService)
    {
        $user = User::find(auth()->user()->id);
        $id = $user->store->mango_id;
        try {
            $store = auth()->user()->store;
            $wallet = null;
            if(request()->transactionId)
            {
                $payin = $mangoPayService->checkKycPayment(request()->transactionId);
                if($payin->Status == "SUCCEEDED")
                {
                    sendMail([
                        'view' => 'email.account.payin-success',
                        'to' => $user->email,
                        'subject' => 'VERY FRIENDLY SHARKS WALLET CREDIT SUCCESSFULLY',
                        'data' => [
                            'subject'=>'VERY FRIENDLY SHARKS WALLET CREDIT SUCCESSFULLY',
                            'user'=>$user,
                            'amount'=>$payin->CreditedFunds->Amount/100,
                            'transaction_id'=>request()->transactionId,
                            'date'=>now()->format('Y/m/d'),
                        ]
                    ]);
                    return redirect()->route('user.transaction.list');
                }
            }
            if($user->store->kyc_payment == 0)
            {
                checkUseKYCPayment();
            }
            if(!$user->default_wallet)
            {
                $mangoPayService->createWallet($store->mango_id , $user->id);
            }
            $user->refresh();
            $wallet = $this->mangoPayApi->Wallets->Get($user->default_wallet->wallet_id);
            $bank = null;
            if($store->mangopay_account_id)
            {
                $userId = $store->mango_id;
                $bankAccountId = $store->mangopay_account_id;
                $bank = $this->mangoPayApi->Users->GetBankAccount($userId, $bankAccountId);
                $iban = $bank->Details->IBAN;
                $country = substr($iban, 0, 2);
                $payout_fee_msg = $country == "GB" ? 0.45 : 2;
            }
            $walletId = $user->default_wallet->wallet_id;

            $pagination = new \MangoPay\Pagination(1 ,50);
            $sorting = new \MangoPay\Sorting();
            $sorting->AddField("CreationDate",\MangoPay\SortDirection::DESC);
            // $transactions = $this->mangoPayApi->Wallets->GetTransactions($walletId ,$pagination ,$filter = null, $sorting);
            $withdraw_request = PayoutRequest::where('user_id',$user->id)->orderBy('created_at','desc')->get();
            $count =PayoutRequest::where('user_id',$user->id)->where('status','pending')->count();
            // $cards =  $this->mangoPayApi->Users->GetCards($store->mango_id ,$pagination ,$filter = null, $sorting);
            return view('user.transaction.list', get_defined_vars());

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }

    }
    public function detail(Request $request)
    {
        $id = $request->id;
        $item = Transaction::find($id);
        return view('user.transaction.detail',get_defined_vars());
    }
}

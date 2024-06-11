<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PayoutRequest;
use Illuminate\Http\Request;
use \MangoPay\MangoPayApi as MangoPay;
use Illuminate\Support\Facades\Config;


class PaymentSettingController extends Controller
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
    public function payin(Request $request)
    {
        if((float)$request->amount > 1900)
        {
            return redirect()->back()->with('error','Payin Amount Cannot be greater then £1900');
        }
        try {
           
            $user = auth()->user();

            $mangoId = $user->store->mango_id;
            $walletId = $user->default_wallet->wallet_id;

            $serviceCharges = calculatePayinServiceCharges((float)$request->amount);

            $fee = $request->has('fee') ? (float)$request->fee*100 : $serviceCharges*100;

            $payinAmount = ($request->amount*100)+$fee;
            $url = $request->has('fee') ? route('user.mangopay.upload.kyc'): route('user.transaction.list');
            $url = $request->has('address_id') ? route('checkout.payment',$request->address_id) : $url;

            $PayIn = new \MangoPay\PayIn();
            $PayIn->CreditedWalletId = $walletId;
            $PayIn->AuthorId = $mangoId;
            $PayIn->PaymentType = "CARD";

            $PayIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsCard();
            $PayIn->PaymentDetails->CardType = "CB_VISA_MASTERCARD";

            $PayIn->DebitedFunds = new \MangoPay\Money();
            $PayIn->DebitedFunds->Currency = "GBP";
            $PayIn->DebitedFunds->Amount = $payinAmount;

            $PayIn->Fees = new \MangoPay\Money();
            $PayIn->Fees->Currency = "GBP";
            $PayIn->Fees->Amount = $fee;

            $PayIn->ExecutionType = "WEB";
            $PayIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsWeb();
            $PayIn->ExecutionDetails->ReturnURL = $url;
            $PayIn->ExecutionDetails->Culture = "EN";
            $PayIn->ExecutionDetails->SecureMode = "FORCE";

            $result = $this->mangoPayApi->PayIns->Create($PayIn);
            transactionRecord($user->id ,null , null, $result->Id , "payin" ,$request->amount , 0,0,0,null,0,0 ,0);
            if($result->ExecutionDetails->RedirectURL)
            {
                return redirect($result->ExecutionDetails->RedirectURL);
            }
            return redirect()->back()->with('error', 'Something went wrong.');

        } catch (\Exception $th) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }

    }
    public function payout(Request $request)
    {
        $user = auth()->user();
        $count =PayoutRequest::where('user_id',$user->id)->where('status','pending')->count();
        if($count >= 1)
        {
            return redirect()->back()->with('error','You already have one pending request.');
        }
        if((float)$request->amount < 10)
        {
            return redirect()->back()->with('error','Minimum Widthraw amount is £10.');
        }
        if($this->checkFunds($request->amount))
        {
            PayoutRequest::create([
                'user_id'=>$user->id,
                'amount'=>$request->amount,
            ]);
            sendMail([
                'view' => 'email.admin.widthdraw-request',
                'to' => 'admin@veryfriendlysharks.co.uk',
                'subject' => 'Action Required: USER WITHDRAWAL REQUEST',
                'data' => [
                    'subject'=>'Action Required: USER WITHDRAWAL REQUEST',
                    'name'=>$user->user_name,
                    'amount'=>$request->amount,
                    'date'=>now()->format('Y/m/d')
                ]
            ]);
            return redirect()->back()->with('success','Withdrawal request sent, You will be informed via email once it approved.');

        }
        return redirect()->back()->with('error','You Cannot withdraw amount greater then your available funds.');

    }
    public function checkFunds($total)
    {
        $total = (float) $total;
        try {
            $balance = getUserWallet();
            $response = $balance >= $total ? true : false;
            return $response;
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function bank(Request $request)
    {
        // dd($req);
        try {
         
            $user = auth()->user();
            $address = $user->seller_address;
            $name = $user->full_name;
            $UserId = $user->store->mango_id;

            $mangoAddress = [
                'AddressLine1'=>$address->street_number,  
                'AddressLine2'=>$address->street_number,  
                'City'=>$address->city, 
                'Region'=>$address->city, 
                'PostalCode'=>$address->postal_code, 
                'Country'=>'GB',
            ];

            $BankAccount = new \MangoPay\BankAccount();
            $BankAccount->UserId = $UserId;
            $BankAccount->Type = "IBAN";
            $BankAccount->Details = new \MangoPay\BankAccountDetailsIBAN();
            $BankAccount->Details->IBAN = $request->iban;
            $BankAccount->Details->BIC = $request->bic;
            $BankAccount->Tag = "Creating Bank Account";
            $BankAccount->Active = 1;
            $BankAccount->OwnerName = $name;
            $BankAccount->OwnerAddress = $mangoAddress;
            $result = $this->mangoPayApi->Users->CreateBankAccount($UserId, $BankAccount);
            $account = $user->store;
            $account->mangopay_account_id = $result->Id;
            $account->save();
        } catch (\Exception $th) {
            return redirect()->back()->with('error', 'Please provide correct information.');

        }
        return redirect()->back()->with('success' , 'Bank Account Attached Successfully!');
    }
}
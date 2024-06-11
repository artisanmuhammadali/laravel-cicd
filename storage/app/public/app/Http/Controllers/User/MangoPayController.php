<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\User\SellerAccountRequest;
use App\Models\Message;
use App\Models\MTG\MtgUserCollection;
use App\Models\Order;
use App\Models\User;
use App\Models\UserStore;
use App\Models\UserAddress;
use App\Models\UserKyc;
use App\Services\User\MangoPayService;
use Exception;
use GuzzleHttp\Client;
use \MangoPay\MangoPayApi as MangoPay;
use Illuminate\Support\Facades\Config;

class MangoPayController extends Controller
{
    private $mangopay;
    public function __construct(MangoPayService $mangopay)
    {
        $this->mangopay = $mangopay;
    }
    public function interest()
    {
        $user = auth()->user();
        $status = ['completed','refunded','cancelled'];
        $sell = $user->sellingOrders->whereNotIn('status',$status)->count();
        $buy = $user->buyingOrders->whereNotIn('status',$status)->count();
        $orders = $buy + $sell;
        return view('user.mangopay.interest' , get_defined_vars());
    }
    public function getDetails(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'role' => 'required',
        ]);
        if($request->role == $user->role)
        {
            $msg = "Your account type is already ".$user->role.".";
            return redirect()->back()->with('error',$msg);
        }
        return view('user.mangopay.get-details', get_defined_vars());
    }
    public function createUser(SellerAccountRequest $request)
    {   
        $user = auth()->user();
        if(!$request->address_id)
        {
            UserAddress::where('user_id',$user->id)->update(['type'=>'secondary']);
            $request->merge(['user_id'=>$user->id]);
            UserAddress::create([
                'name'=>'Home',
                'street_number'=> $request->street_number,
                'user_id'=> $user->id,
                'city'=> $request->city,
                'postal_code'=>$request->postal_code,
                'type'=>'primary',
                'country'=> 'UK'
            ]);
        }
        $route = route('user.account');
        if($request->update_user != "1")
        {
            if($request->role == "business")
            {
                $user->store->update([
                    'company_name'=>$request->company_name ,
                    'company_no'=>$request->company_no ,
                    'kyc_payment'=>0,
                    'kyc_payment_id'=>null
                    ]);
                $mngoid = $this->mangopay->createMangoPayUser($user , $request->role , $request);
                $this->mangopay->createWallet($mngoid , $user->id);
                $person = User::find($user->id);
                $person->update(['kyc_verify'=>0,'verified'=>0,'ubo_verify'=>0]);
                MtgUserCollection::where('user_id',auth()->user()->id)->update(['publish'=>0]);
                UserStore::where('user_id',auth()->user()->id)
                            ->update([
                                'telephone'=>$request->telephone,
                                'mango_id' => $mngoid , 
                                'mangopay_account_id'=>null,
                                'role_change'=>true , 
                                'kyc_payment'=>false
                            ]);
                UserKyc::where('user_id',auth()->user()->id)->delete();
                if($user->old_wallet)
                {
                    $this->mangopay->tranferWalletAmount($user->old_wallet , $user->default_wallet);            
                }
            }
            else
            {   
                $this->mangopay->updateNaturalUser($request);
                UserStore::where('user_id',auth()->user()->id)->update([
                    'role_change'=>false ,
                    'telephone'=>$request->telephone
                ]);
            }
        }
        else
        {
            $this->mangopay->updateUbo($request);
            UserStore::where('user_id',auth()->user()->id)->update([
                'role_change'=>false ,
                'telephone'=>$request->telephone
            ]);
        }
        User::find(auth()->user()->id)->update(['role'=> $request->role,'current_role'=>$request->role]);
        

        return response()->json(['redirect'=>$route,'success' => 'Account Updated Successfully!']);
    }
    public function getKycPayment()
    {
        $user = User::find(auth()->user()->id);
        if($user->store->kyc_payment == 0)
        {
            checkUseKYCPayment();
            $user->refresh();
        }
        return view('user.mangopay.kyc-detail');
    }
    public function uploadKyc()
    {
        $request = request();
        $user = auth()->user();
        if($request->transactionId)
        {
            $payin = $this->mangopay->checkKycPayment($request->transactionId);
            $pay = $payin->Status == "SUCCEEDED" ? 1 : 0;
            $paid = $payin->Fees->Amount > 500 ? 5 : 1;
            UserStore::where('user_id',auth()->user()->id)->update([
                'kyc_payment'=>$pay,
                'kyc_amount'=>$paid,
                'kyc_payment_id'=>$request->transactionId
            ]);
            $msg = $pay == 1 ? "Payment Successfully Processed." : "Please wait your payment is processing.";
            $msgType = $pay == 1 ? "success" : "info";
            if($pay == 1)
            {
                $m = new Message();
                sendNotification($user->id,1 , 'message','Payment for KYC/KYB Successfully received.' ,$m , route('user.mangopay.kyc.detail'));
                sendMail([
                    'view' => 'email.account.receive-kyc-payment',
                    'to' => $user->email,
                    'subject' => 'Payment for KYC/KYB Successfully received!',
                    'data' => [
                        'subject'=>'Payment for KYC/KYB Successfully received! ',
                        'name'=>$user->user_name,
                        'email'=>$user->email,
                    ]
                ]);
            }
            return redirect()->route('user.collection.index')->with($msgType , $msg);
        }
        return view('user.mangopay.upload-kyc');
    }
    public function reUploadKyc()
    {
        return view('user.mangopay.re-upload-kyc');
    }
    public function submitKyc(Request $request)
    {
        set_time_limit(0);
        $user = auth()->user();
        $store = $user->store;
        list($p , $Pcheck)=getFailedKyc('photo_id_scan');
        list($r , $Rcheck)=getFailedKyc('registration_proof');
        list($a , $Acheck)=getFailedKyc('article_of_association');
        if($user->role == "seller" && $p && !$Pcheck)
        {
            return response()->json(['redirect'=>route('user.account'),'error' => 'You have already submitted the KYC/KYB.']);        
        }
        $businessCheck = (!$Pcheck && $p) && (!$Rcheck && $r) && (!$Acheck && $a);
        if($user->role == "business" && $businessCheck)
        {
            return response()->json(['redirect'=>route('user.account'),'error' => 'You have already submitted the KYC/KYB.']);        
        }
        $request->validate([
            'file' => 'required',
            'type' => 'required',
        ]);
        $user->store->update(['kyc_payment'=>0,'role_change'=>0]);
        foreach($request->file as $key => $value)
        {
            $file = $value;
            $name = $file->getClientOriginalName();
            $store->update([$key => $name]);
            $kyc= $this->mangopay->createKyc($store->mango_id , $file, $request->type[$key]);
            $data = [
                'key'=>$key,
                'kyc_id'=>$kyc->Id,
                'user_id'=>auth()->user()->id,
                'mangopay_response'=>null,
                'created_at'=>now(),
                'updated_at'=>now(),
            ];
            $query = ['key'=>$key,'user_id'=>auth()->user()->id];
            UserKyc::updateOrCreate($query , $data);
            
        }
        if($request->nationality){
            if($user->role == "seller")
            {
                $this->mangopay->updateNaturalUser($request);
            }
            else
            {
                $this->mangopay->updateLegalUser($user ,$request);
            }
        }
        $m = new Message();
        sendNotification($user->id,1 , 'message','Your '.ucfirst($user->role).' Application has been received.' ,$m , route('user.mangopay.kyc.detail'));
        sendMail([
            'view' => 'email.account.receive-kyc-request',
            'to' => $user->email,
            'subject' => strtoupper($user->role).' APPLICATION RECEIVED - VERY FRIENDLY SHARKS',
            'data' => [
                'subject'=>strtoupper($user->role).' APPLICATION RECEIVED - VERY FRIENDLY SHARKS ',
                'name'=>$user->user_name,
                'email'=>$user->email,
            ]
        ]);
        return response()->json(['redirect'=>route('user.account'),'success' => 'Kyc Submit Successfully!']);        
    }
    public function kycDetail()
    {
        try{
            $user = auth()->user();
                $api = (object)[];
                $data = Config::get('helpers.mango_pay');
                $api->mangoPayApi = new MangoPay();
                $api->mangoPayApi->Config->ClientId = $data['client_id'];
                $api->mangoPayApi->Config->ClientPassword = $data['client_password'];
                $api->mangoPayApi->Config->TemporaryFolder = '../../';
                $api->mangoPayApi->Config->BaseUrl = $data['base_url'];
                $kycs = $api->mangoPayApi->Users->GetKycDocuments($user->store->mango_id);
                return view('user.mangopay.kyc-detail',get_defined_vars());
        }
        catch(Exception $e)
        {
            return redirect()->back();
        }
        // dd($kycs);
    }

}

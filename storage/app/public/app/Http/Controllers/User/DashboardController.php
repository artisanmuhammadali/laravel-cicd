<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Cart;
use App\Models\UserStore;
use App\Models\FavUser;
use App\Models\UserKyc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use \MangoPay\MangoPayApi as MangoPay;
use Illuminate\Support\Facades\Config;
use App\Models\Message;
use App\Services\User\MangoPayService;
use Exception;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
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
    public function index(MangoPayService $mangopay)
    {
        $user = auth()->user();
        if(!$user->dob)
        {
            $url = route('social.complete.registration' ,$user->email);
            return redirect($url);
        }
        try{
            if($user->store->mango_id)
            {
                $person = User::find($user->id);
                if($user->role != "buyer" && $user->verified == 0)
                {
                    $mangopayUser = $this->mangoPayApi->Users->Get($user->store->mango_id);
                    $v = $mangopayUser->KYCLevel == "REGULAR" ? 1 : 0;
                    if($v == 1)
                    {
                        $m = new Message();
                        sendNotification($user->id,1 , 'message','Your Kyc Has Been Approved.' ,$m , route('user.mangopay.kyc.detail'));
                        sendMail([
                            'view' => 'email.approved_kyc',
                            'to' => $user->email,
                            'subject' => 'Your VFS Account is KYC / KYB Approved!',
                            'data' => [
                                'subject'=>'Your VFS Account is KYC / KYB Approved! ',
                                'name'=>$user->user_name,
                                'email'=>$user->email,
                            ]
                        ]);
                    }
                    $person->update(['verified'=>$v , 'kyc_verify'=>$v]);
                    if($user->role == "business")
                    {
                        $person->update(['ubo_verify'=>$v]);
                    }
                }
            }
        }catch(Exception $e)
        {
            return view('user.index');
        }
        return view('user.index');
    }
    public function changePassword()
    {
        return view('user.change-password');
    }

    public function sellerInfo()
    {
        return view('user.seller-info');
    }

    public function referralUser()
    {
        $list = User::where('referr_by',auth()->user()->id)->get();
        $count = count($list);
        return view('user.referral-user' , get_defined_vars());
    }


    public function destroy($id)
    {
        // Cart::where('seller_id',$id)->orWhere('user_id',$id)->delete();
        // $user = User::findOrFail($id);
        // $user->status='deleted';
        // $user->deleted_at=now();
        // $user->save();
        // Auth::logout();
        Cart::where('seller_id',$id)->orWhere('user_id',$id)->delete();
        User::findOrFail($id)->delete();
        return redirect()->route('index')->with('success','Account Deleted Successfully!');
    }
    public function changeStatus($status)
    {
        if($status == "alert_inactive")
        {
            UserStore::where('user_id',auth()->user()->id)->update(['active_acc_alert'=>0]);
            return redirect()->route('user.account')->with('success','Your setting has updated successfully!');
        }
        User::find(auth()->user()->id)->update(['status'=> $status]);
        $user = auth()->user();
        $status_email = auth()->user()->status == 'active' ? 'account activated' : 'account on holiday';
        if(auth()->user()->status == 'active'){
            sendMail([
                'view' => 'email.account.on-holiday',
                'to' => $user->email ?? $user['email'],
                'subject' => 'ACCOUNT ON HOLIDAY - VERY FRIENDLY SHARKS',
                'data' => [
                    'user_name' => $user->user_name ?? $user['user_name'],
                    'date' => now()
                ]
            ]);
        }
        else{
            sendMail([
                'view' => 'email.account.activated',
                'to' => $user->email ?? $user['email'],
                'subject' => 'ACCOUNT IS ACTIVATED - VERY FRIENDLY SHARKS',
                'data' => [
                    'user_name' => $user->user_name ?? $user['user_name'],
                    'date' => now()
                ]
            ]);
        }

        return redirect()->route('user.account')->with('success','Status has changed successfully!');
    }
}

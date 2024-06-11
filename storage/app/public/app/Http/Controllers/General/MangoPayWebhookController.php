<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use App\Models\UserKyc;
use Exception;
use Illuminate\Http\Request;
use \MangoPay\MangoPayApi as MangoPay;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class MangoPayWebhookController extends Controller
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
    public function kycSuccess(Request $request)
    {
        DB::table('user_kycs')->where('kyc_id',$request->RessourceId)->update([
            'verified'=>1,
            'mangopay_response'=>"Success"
        ]);
        $user_id = DB::table('user_kycs')->where('kyc_id',$request->RessourceId)->value('user_id');
        $kycCount =DB::table('user_kycs')->where('user_id',$user_id)->where('verified',1)->count();
        $user_role =  DB::table('users')->where('id',$user_id)->value('role');
        if($user_role== "business" && $kycCount == 3 || $user_role == "seller" && $kycCount == 1)
        {
            $this->verifyUser($user_id);
            DB::table('users')->where('id',$user_id)->update(['kyc_verify'=>1]);
        }
        return true;
    }
    public function kycFailed(Request $request)
    {
        DB::table('user_kycs')->where('kyc_id',$request->RessourceId)->update([
            'verified'=>0,
            'mangopay_response'=>"Failed"
        ]);
        $user_id = DB::table('user_kycs')->where('kyc_id',$request->RessourceId)->value('user_id');
        $user = User::where('id',$user_id)->first();
        if($user)
        {
            sendMail([
                'view' => 'email.failed_kyc',
                'to' => $user->email,
                'subject' => 'Action Required: KYC/KYB Verification Update',
                'data' => [
                    'subject'=>'Action Required: KYC/KYB Verification Update',
                    'name'=>$user->user_name,
                    'email'=>$user->email,
                ]
            ]);
        }
      

        DB::table('users')->where('id',$user_id)->update(['kyc_verify'=>0]);
        return true;
    }
    public function UboSuccess(Request $request)
    {
        DB::table('user_kycs')->where('kyc_id',$request->RessourceId)->update([
            'verified'=>1,
            'mangopay_response'=>"Success"
        ]);
        $user_id = DB::table('user_kycs')->where('kyc_id',$request->RessourceId)->value('user_id');
        DB::table('users')->where('id',$user_id)->update(['ubo_verify'=>1]);
        $this->verifyUser($user_id);
        return true;
    }
    public function UboFailed(Request $request)
    {
        DB::table('user_kycs')->where('kyc_id',$request->RessourceId)->update([
            'verified'=>0,
            'mangopay_response'=>"Failed"
        ]);
        $user_id = DB::table('user_kycs')->where('kyc_id',$request->RessourceId)->value('user_id');
        DB::table('users')->where('id',$user_id)->update(['ubo_verify'=>0]);
        return true;
    }
    public function verifyUser($user_id)
    {
        $user =  User::find($user_id);
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
    }
}

<?php

namespace App\Services\Auth;

use App\Models\Message;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserStore;
use App\Models\UserWallet;
use Illuminate\Support\Facades\Hash;
use \MangoPay\MangoPayApi as MangoPay;
use Illuminate\Support\Facades\Config;

class RegisterServices {
 
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
    public function createUser($request)
    {
        if($request->has('referel')){
            $user = User::where('user_name',$request->referel)->first();
            $referr_by = $user != null ? $user->id : null;
            $request->merge(['referr_by'=>$referr_by]);
            $m = new Message();
            $notify = $request->user_name.' joined through your referral link!';
            sendNotification($user->id,1 , 'message',$notify ,$m , route('user.referral'));
            sendMail([
                'view' => 'email.referal-success',
                'to' => $user->email,
                'subject' => 'SUCCESSFULLY REFERRAL - VERY FRIENDLY SHARKS',
                'data' => [
                    'referee' => $user->user_name,
                    'user_name' => $request->user_name,
                ]
            ]);
       
        }
        $request->merge(['password' => Hash::make($request->password), 'role' => 'buyer', 'current_role' => 'buyer']);
        
        return User::create($request->all());
    }

     public function userStore($request)
     {
        $pspConfig = vsfPspConfig();
        $data = ['user_id'=>$request->user_id,'newsletter'=>$request->newsletter ?? null , 'hear_about_us'=>$request->hear_about_us , 'referal_limit'=>$pspConfig->referal_limit , 'referal_percentage'=>$pspConfig->referal_percentage];

        return  UserStore::create($data);
     }
     public function userAddress($request)
     {
        return UserAddress::create($request->all());
     }
     public function createNaturalUser($user)
    {
        $dateString = str_replace('/', '-', $user->dob);
        $dob = strtotime($dateString);
        try {
            $mangoUser = new \MangoPay\UserNatural();
            $mangoUser->Email = $user->email;
            $mangoUser->FirstName = $user->first_name;
            $mangoUser->LastName = $user->last_name;
            $mangoUser->UserCategory = "PAYER";
            $mangoUser->Nationality = null;
            $mangoUser->Birthday = $user->dob ? $dob : mktime(0, 0, 0, 12, 21, 1975);
            $mangoUser->CountryOfResidence = null;
            $mangoUser->TermsAndConditionsAccepted = true;
            $mangoUser= $this->mangoPayApi->Users->Create($mangoUser);

            $this->createWallet($mangoUser->Id , $user->id);
            $user->store->update(['mango_id'=>$mangoUser->Id]);

            $mangoUser = (object)$mangoUser;
            return $mangoUser->Id;
        } catch (\Exception $e) {
        }
    }
    public function createWallet($id , $user_id)
    {
        try {
            UserWallet::where('user_id',$user_id)->update(['active'=>0]);
            $wallet = new \MangoPay\Wallet();

            $wallet->Owners = [$id];
            $wallet->Currency = 'GBP';
            $wallet->Description = 'GBP General Wallet';
            $wallet->Tag = 'General Wallet For Managing Users e-money';

            $response = $this->mangoPayApi->Wallets->Create($wallet);
            UserWallet::create([
                'wallet_id'=>$response->Id,
                'user_id'=>$user_id,
                'type'=>'normal',
                'user_mangopay_id'=>$id
            ]);
            return $response->Id;
        } catch (\Throwable $th) {

        }
    }
}
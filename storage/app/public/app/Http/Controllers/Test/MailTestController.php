<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use DB;

class MailTestController extends Controller
{
    public function mailTest()
    {
        $user = auth()->user();
        sendMail([
            'view' => 'email.failed_kyc',
            'to' => $user->email ?? 'test@gmail.com',
            'subject' => 'Action Required: KYC/KYB Verification Update',
            'data' => [
                'subject'=>'Action Required: KYC/KYB Verification Update',
                'name'=>$user->user_name,
                'email'=>$user->email,
            ]
        ]);
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
        return 1;
        if(route('index') == 'https://www.veryfriendlysharks.co.uk')
        {
            $emails = User::pluck('email')->toArray();
        }
        else{
            $emails = ['alibinsarwar2001@gmail.com','deviotechshahzad@gmail.com'];
        }
        set_time_limit(0);
        foreach($emails as $email)
        {
            sendMail([
                'view' => 'email.launch',
                'to' => $email,
                'subject' => 'Dive In: VFS Sales System is Live! Sharks!',
                'data' => [
                ]
            ]);
        }
    }
    public function mailConfiguration()
    {


        dd(config('mail'), env('MAIL_USERNAME'));
    }
    public function purchase()
    {
        sendMail([
                    'view' => 'email.order-shipped',
                    'to' => 'ahmed123@gmail.com',
                    'subject' => 'SUCCESSFUL SALE - VERY FRIENDLY SHARKS',
                    'data' => [
                        'order_id'=>'45',
                        'user_name'=> 'Zain Abbas',
                        'order_quantity'=> '2',
                        'order_price'=> '2',
                        'seller_name'=> 'Ahmed',
                        'buyer_name'=> 'Zain Abbas',
                    ]
                ]);
    }

}

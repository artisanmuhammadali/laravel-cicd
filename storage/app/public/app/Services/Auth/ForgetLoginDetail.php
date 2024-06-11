<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;

class ForgetLoginDetail {
 
    public function forgetEmail($request)
    {
        $user = User::where('user_name',$request->username)->where('status','!=','deleted')->first();
        if ($user != null) {
            sendMail([
                'view' => 'email.email-reminder',
                'to' => $user->email,
                'subject' => 'FORGOTTEN EMAIL - VERY FRIENDLY SHARKS',
                'data' => [
                    'user_name' => $user->user_name,
                    'email' => $user->email
                ]
            ]);
            return response()->json(['success'=>'An email reminder sent to your associated email!']);
        }
        else{
            return response()->json(['error'=>'Please Enter Correct Username.']);
        }
    }
    public function forgetPassword($request)
    {
        $user = User::where('email',$request->email)->where('status','!=','deleted')->first();
        if ($user) {
            $status = Password::sendResetLink(
                $request->only('email')
            );

            $response =  $status == Password::RESET_LINK_SENT
                        ? ['success'=>'An email reminder sent to your associated email!']  
                        : ['error' => __($status)];

            return response()->json($response);
        }
        else{
            return response()->json(['error'=>'Please Enter Correct Email Address.']);
        }

    }
}
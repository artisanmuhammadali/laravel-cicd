<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SocialRegistration;
use App\Models\User;
use App\Models\UserStore;
use App\Services\Auth\RegisterServices;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class SocialAuthController extends Controller
{
    private $registerServices;
    public function __construct(RegisterServices $registerServices)
    {
        $this->registerServices = $registerServices;
    }
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

   public function handleProviderCallback($provider)
   {
       
       try {
            $googleUser = Socialite::driver($provider)->stateless()->user();
            $user = $googleUser->user;
            return $this->findOrCreateUser($user, $provider);
       } catch (\Exception $e) {
            // dd($e);
           return redirect('/');
       }
    }
    public function completeRegistration($email)
    {
        $user = User::where('email',$email)->firstOrFail();
        return view('auth.social-registration', get_defined_vars());
    }
    public function saveRegistration(SocialRegistration $request)
    {
        $request->merge([ 'role' => 'buyer', 'current_role' => 'buyer']);
        $user = User::find($request->id);
        $user->update($request->except('_token'));
        $user->refresh();
        $this->registerServices->createNaturalUser($user);
        UserStore::where('user_id',$request->id)->update([
            'hear_about_us'=>$request->hear_about_us,
            'newsletter'=>$request->newsletter ?? null
        ]);
        Auth::login($user, true);
        return redirect('/');
    }
   public function findOrCreateUser($providerUser, $provider)
   {
        if(!array_key_exists('email' , $providerUser))
        {
            return redirect('/');
        }
        $user = User::where('email',$providerUser['email'])->first();
    

        if (!$user || !$user->dob) {
            if(!$user)
            {
                $uniqueIdentifier = time();
                $uniqueUsername = $providerUser['given_name'] . $uniqueIdentifier;
                $user = User::create([
                    'user_name'=>$uniqueUsername,
                    'email' => $providerUser['email'],
                    'first_name'  => $providerUser['given_name'],
                    'last_name'  => $providerUser['family_name'],
                    'password'=> bcrypt(Str::random(10)),
                    'email_verified_at'=>now(),
                    'auth_type'=> 'google',
                ]);
                $pspConfig = vsfPspConfig();
                $data = ['user_id'=>$user->id,'newsletter'=>null , 'hear_about_us'=>null , 'referal_limit'=>$pspConfig->referal_limit , 'referal_percentage'=>$pspConfig->referal_percentage ,'hear_about_us'=>"join through google"];
                UserStore::create($data);
            }
            $url = route('social.complete.registration' ,$providerUser['email']);
            return redirect($url);
        }
        else
        {
            Auth::login($user, true);
            return redirect('/')->with('success','Logged in successfully!');
        }
   }
}

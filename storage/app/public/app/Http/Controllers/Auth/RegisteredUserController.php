<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserStore;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Http\Requests\Auth\RegisterRequest;
use App\Notifications\WelcomeEmailNotification;
use Illuminate\Support\Facades\DB;
use App\Services\Auth\RegisterServices;
use Carbon\Carbon;

class RegisteredUserController extends Controller
{
    private $registerServices;
    public function __construct(RegisterServices $registerServices)
    {
        $this->registerServices = $registerServices;
    }


    /**
     * Display the registration view.
     */
    public function create()
    {
        return redirect()->route('index');
        // return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $request)
    {   
        $date = Carbon::now();
        $request->merge(['created_at' => $date, 'updated_at' => $date]);
        $user = $this->registerServices->createUser($request);
        $request->merge(['user_id'=>$user->id]);
        
        $this->registerServices->userStore($request);
        
        $mngoid = $this->registerServices->createNaturalUser($user);
        // sendMail([
        //         'view' => 'email.welcome-email',
        //         'to' => $user->email,
        //         'subject' => 'WELCOME EMAIL - VERY FRIENDLY SHARKS',
        //         'data' => [
        //             'user_name' => $user->user_name,
        //         ]
        //     ]);
       
        event(new Registered($user));
        Auth::login($user);

        return response()->json(['redirect'=>route('register.success'),'success' => 'Registered Successfully!']);
    }
    
}

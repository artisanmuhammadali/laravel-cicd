<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\ForgetLoginDetail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ForgetLoginDetailController extends Controller
{
    private $forgetDetail;
    public function __construct(ForgetLoginDetail $forgetDetail)
    {
        $this->forgetDetail = $forgetDetail;
    }
    public function create()
    {
       return view('auth.forget-login-detail'); 
    }

    public function store(Request $request)
    {
        if ($request->type == "email") {
            $request->validate([
                'username' => 'required',
                'g-recaptcha-response' => 'required',
            ]);
            return $this->forgetDetail->forgetEmail($request);
        }
        else{
            $request->validate([
                'email' => ['required', 'email'],
                'g-recaptcha-response' => 'required',
            ]);
            return $this->forgetDetail->forgetPassword($request);
        }
    }
}

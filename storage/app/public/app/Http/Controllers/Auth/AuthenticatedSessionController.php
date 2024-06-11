<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $remember_me = $request->has('remember_me') ? true : false;
        $request->merge(['remember'=>$remember_me]);
        $request->authenticate();

        $request->session()->regenerate();
        
        $user = auth()->user();
        if(($user->status != "active") && ($user->status != "on-holiday") && ($user->role != 'admin'))
        {
            $msg = $user->status== "deleted" ? 'Account Does not exist.' : 'Your Account is '.$user->status.' by the admin.';
            Auth::logout();
            return response()->json(['error' => $msg]);
        }
        if($request->ajax())
        {
            return response()->json(['success' => 'Logged in successfully!']);
        }
        return redirect()->route('admin.dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        try {

            Auth::guard('web')->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();
            if($request->ajax())
            {
                return response()->json(true);
            }
            return redirect('/');

        } catch (\Exception $e) {
            return redirect('/');
        }
    }
}

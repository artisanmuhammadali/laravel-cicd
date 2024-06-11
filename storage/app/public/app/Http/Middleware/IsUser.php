<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        
        if($user->role != 'admin')
        {
            if($user->status != 'active' && $user->status != 'on-holiday' ){
                Auth::logout();
                return redirect()->route('index');
            }
            return $next($request);
        }
        return redirect()->route('admin.dashboard');
    }
}

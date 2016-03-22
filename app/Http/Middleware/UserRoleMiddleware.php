<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserRoleMiddleware
{
    /**
     * Handle an incoming request.
     * Return users who have not specified their user role to setup page
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //if signed and has not selected user role, redirect to setup page
        if(Auth::user()->user_role == null){
            return redirect()->route('setup');
        }

        return $next($request);
    }
}

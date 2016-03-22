<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ShieldFromStaffMiddleware
{
    /**
     * Handle an incoming request.
     * Prevent staff from visiting student pages
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        //if signed in as staff redirect to staff home page
        if(Auth::user()->user_role == 'Staff'){
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}

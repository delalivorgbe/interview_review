<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;


class ShieldFromStudentMiddleware
{
    /**
     * Handle an incoming request.
     * Prevent student from visiting staff pages
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        //if signed in as staff redirect to staff home page

        if(Auth::user()->user_role == 'Student'){
            return redirect()->route('sdocreq');
        }

        return $next($request);
    }
}

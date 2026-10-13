<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckForLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         if($request->url('admin/login') ) {
            if(isset(Auth::guard('admin')->user()->name)) {
                return redirect()->route('admins.dashboard');
            } 
        }


        return $next($request);
    }
}

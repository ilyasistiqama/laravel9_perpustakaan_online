<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OnlyRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->session()->exists('user_login')){
            return $next($request);
        }else{
            return redirect('/login');
        }
    }
}

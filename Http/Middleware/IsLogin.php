<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsLogin
{
    public function handle(Request $request, Closure $next)
    {
        if(auth()->guard('admin')->check() || auth()->guard('seller')->check() || auth()->guard('buyer')->check()){
            return $next($request);
        }
        return redirect()->route('form_login');
    }
}

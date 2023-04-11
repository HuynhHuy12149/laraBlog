<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckLoggedIn
{
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::check()) {
            return redirect('/');
        }
    
        return $next($request);
    }
}


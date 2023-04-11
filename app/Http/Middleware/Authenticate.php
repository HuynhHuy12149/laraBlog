<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URl;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     * @return string|null
     * @param \Illuminate\Http\Request $request
     */
    
    protected function redirectTo(Request $request): ?string
    {
        // return $request->expectsJson() ? null : route('login');
        if(!$request->expectsJson() ){
            if($request->routeIs('author.*')){
                session()->flash('fail','You must sign in first');
                return route('author.login',['fail'=>true,'returnUrl'=>URL::current()]);
            }
            if($request->routeIs('*')){
                session()->flash('fail','You must sign in first');
                return route('login',['fail'=>true,'returnUrl'=>URL::current()]);
            }
        }
        return null;
       
    }
}

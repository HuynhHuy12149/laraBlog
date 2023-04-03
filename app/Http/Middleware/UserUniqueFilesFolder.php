<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
class UserUniqueFilesFolder
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // luu tru tap tap cho nguoi dung dang nhap
        // kiem tra nguoi dung dang nhap
        if(Auth::check()){
            //unique foldder name => myfile folder duoc create voi id nguoi dung lam ten
            $folder_name = 'my'.Auth::user()->id.'file';
            // kiem tra thu muc co ton tai chua. chua tif nos tu dong create
            if(!Storage::disk('public')->exists($folder_name)){
                Storage::disk('public')->makeDirectory($folder_name, 0755, true, true);

            }

            //  quan ly tap tin luu tru tren elfinder
            config::set('elfinder.dir',["storage/$folder_name"]);
        }
        return $next($request);
    }
}

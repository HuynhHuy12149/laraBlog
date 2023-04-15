<?php

namespace App\Http\Controllers;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //

    //google
    public function redirectToGoogle(){
        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback(){
    
        try {
            //code...
            $usergoogle = Socialite::driver('google')->user();
            $user = User::where('id_login',$usergoogle->getId())->first();
            $type = 3;
            if(!$user){
                $new_user = User::create([
                    'name'=> $usergoogle->getName(),
                    'email'=>$usergoogle->getEmail(),
                    'id_login'=>$usergoogle->getId(),
                    'username'=>$usergoogle->getNickname(),
                    'picture' =>$usergoogle->getAvatar(),
                    'type' => $type,
                ]);
                if($new_user){
                    session()->put('user', [
                        'name' => $new_user->name,
                        'username' => $new_user->username,
                        'email' => $new_user->email,
                        'picture' => $new_user->picture,
                        'biography' => $new_user->biography
                    ]);
                    session()->put('login_success', true);
                
                    return redirect('/');
                } else{
                    
                    session()->flash('fail', 'Incorrect email or password');
                }
                
                
            }else{

                session()->put('user', [
                    'name' => $usergoogle->name,
                    'username' => $usergoogle->username,
                    'email' => $usergoogle->email,
                    'picture' => $usergoogle->picture,
                    'biography' => $usergoogle->biography
                ]);
                    session()->put('login_success', true);
                return  redirect('/');
            }
        } catch (\Throwable $th) {
           session()->flash('fail', 'Incorrect email or password');
        }
    }


    // facebook
    public function redirectToFacebook(){
        return Socialite::driver('facebook')->redirect();
    }
    public function handleFacebookCallback(){
        $user = Socialite::driver('facebook')->user();
        dd($user);
    }
}

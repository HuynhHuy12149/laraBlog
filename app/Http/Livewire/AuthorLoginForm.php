<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use App\Models\User; 
use Livewire\Component;

class AuthorLoginForm extends Component
{
    public $login_id,$password,$returnUrl;

    public function mount(){
        $this->returnUrl=request()->returnUrl;
    }

    


    public function LoginHandler(){
        
        $fieldType = filter_var($this->login_id, FILTER_VALIDATE_EMAIL)?'email':'username';
        if($fieldType == 'email'){
            $this->validate([
                'login_id'=>'Required|email|exists:users,email',
                'password'=>'Required|min:5'
            ],[
                'login_id.required'=>'Enter your email address',
                'login_id.email'=>'Invalid email address',
                'login_id.exists'=>'This email is not register',
                'password.required'=>'Password is required'
            ]);
        }else{
            $this->validate([
                'login_id'=>'Required|exists:users,username',
                'password'=>'Required|min:5'
            ],[
                'login_id.required'=>'Enter your email address',
                'login_id.exists'=>'This email is not register',
                'login_id.required'=>'Password is required'
            ]);

        }

        $creds=array($fieldType=>$this->login_id,'password'=>$this->password);
        if(Auth::guard('web')->attempt($creds)){
            $checkuser = User::where($fieldType,$this->login_id)->first();
            // dd($checkuser);
            if($checkuser->blocked == 1){
                Auth::guard('web')->logout();
                return redirect()->route('author.login')->with('fail','Your account had been blocked.');

            }else {
                // return redirect()->route('author.home');
                if($this->returnUrl != null){
                    return redirect()->to($this->returnUrl);
                }else{
                    redirect()->route('author.home');
                }
            }
        } else{
            session()->flash('fail','Incorrect email or password');
        }
        // $this->validate([
        //     'email'=>'Required | email | exists:users,email',
        //     'password'=>'Required|min:5'
        // ],[
        //  'email.required'=>'Enter your email address',
        //  'email.email'=>'Invalid email address',
        //  'email.exists'=>'This email is not registered ',
        //  'password.required'=>'Password is required'   
        // ]);

        // $creds = array('email'=>$this->email, 'password'=>$this->password);
        // if(Auth::guard('web')->attempt($creds)){
        //     $checkuser = User::where('email',$this->email)->first();
        //     dd($checkuser);
        //     if($checkuser->blocked == 1){
        //         Auth::guard('web')->logout();
        //         return redirect()->route('author.login')->with('fail','Your account had been blocked.');

        //     }else {
        //         return redirect()->route('author.home');
        //     }
        // } else{
        //     session()->flash('fail','Incorrect email or password');
        // }
    }
    public function render()
    {
        return view('livewire.author-login-form');
    }
}

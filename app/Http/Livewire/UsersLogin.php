<?php

namespace App\Http\Livewire;

use Livewire\Component;

class UsersLogin extends Component
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
                'login_id.password'=>'Password is required'
            ]);

        }

        

        
    }

    public function render()
    {
        return view('livewire.users-login');
    }
}

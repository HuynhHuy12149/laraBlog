<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User; 
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthorResetForm extends Component
{
    public function render()
    {
        return view('livewire.author-reset-form');
    }
    public $email,$token,$new_password,$confirm_password;
    public function mount(){
        $this->email=request()->email;
        $this->token=request()->token;
    }
    public function ResetHandler(){
        $this->validate([
            'email'=>'Required|email|exists:users,email',
            'new_password'=>'required|min:5',
            'confirm_password'=>'same:new_password'
            
        ],[
            'new_password.required'=>'The password is required',
            'new_password.min'=>'Minium characters must be 5',
            'confirm_password'=>'Confirm new password and new password must match',
            'email.required'=>'Enter your email address',
            'email.email'=>'Invalid email address',
            'email.exists'=>'This email is not register',
        ]);

        $checktoken = DB::table('password_reset_tokens')->where(
            [
                'email'=>$this->email,
                'token'=>$this -> token,
            ]
        )->first();
        if(!$checktoken){
            session()->flash('fail','Invail Token');

        }else { 
            User::where('email',$this->email)->update([
                'password'=>Hash::make($this->new_password)
            ]);
            DB::table('password_reset_tokens')->where([
                'email'=>$this->email
            ])->delete();
            $success_token= Str::random(64);
            session()->flash('success','Your password has been updated successfully.');
            $this->redirectRoute('author.login',['tkn'=>$success_token,'UEmail'=>$this->email]);
        }
        
    }
}

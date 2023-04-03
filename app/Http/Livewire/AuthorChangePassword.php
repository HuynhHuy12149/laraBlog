<?php

namespace App\Http\Livewire;    

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthorChangePassword extends Component
{
    public $author,$current_password,$new_password,$confirm_password;
    public function render()
    {
        return view('livewire.author-change-password');
    }

    // public function mount(){
    //     $this->author=User::find(auth('web')->id());
    //     $this->current_password = $this->author->current_password;
        
       
    // }

    public function UpdatePassword(){
        $this->validate([
            'current_password'=>[
                'required',function($attribute,$value,$fail){
                    if(!Hash::check($value,User::find(auth('web')->id())->password)){
                        return $fail(__('The current password is incorrect'));
                    }
                },
            ],
            'new_password'=>'required|min:5|max:25',
            'confirm_password'=>'same:new_password'

        ],[
            'current_password.required'=>'Enter your current password',
            'new_password.required'=>'Enter your new password',
            'cofirm_password.same'=>'The confirm password must be equal to the new password'
        ]);

        $string_query=User::find( auth('web')->id())->update([
            'password'=>Hash::make($this->new_password)
        ]);

        if($string_query){
            $this->showToastr('Your password have been successfuly update','success');
            $this->current_password=$this->new_password=$this->confirm_password=null;

        }else{
            $this->showToastr('Something went wrong','error');
        }
        
    }

    public function showToastr($message,$type){
        return $this->dispatchBrowserEvent('showToastr',[
            'type'=>$type,
            'message'=>$message
        ]);
    }
    
}

<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;

class AuthorProfileHeader extends Component
{
    public $author;
    public function render()
    {
        return view('livewire.author-profile-header');
    }
    public function mount(){
        $this -> author = User::find(auth('web')->id());
    }

    protected $listeners = [
        'updateAuthorProfileHeader'=>'$refresh'
    ];
}

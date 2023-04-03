<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Nette\Utils\Random;
use Illuminate\Support\Facades\Mail;
use Livewire\WithPagination;
use Illuminate\Support\Facades\File;


class Authors extends Component
{
    use WithPagination; 
    public $name, $username,$email, $direct_publisher, $author_type,$search;
    public $perPage =4;
    public $selected_author_id,$blocked=0;
    protected $listeners=[
        'resetForm',
        'deleteAuthorAction'
    ];

    public function mount(){
        $this->resetPage();
    }

    // reset from add author khi close tra ve null
    public function resetForm(){
        $this->name=$this->email=$this->username=$this->direct_publisher=$this->author_type=null;
        $this->resetErrorBag();
    }
    public function updatingSearch(){
        $this->resetPage();
    }

    // add user vao bang
    public function addAuthor(){
        
        $this->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users,email',
            'username'=>'required|unique:users,username|min:6|max:20',
            'author_type'=>'required',
            'direct_publisher'=>'required'
        ],[
            'author_type.required'=>'Choose author type',
            'direct_publisher.required'=>'Specify author publication access',
        ]);

        if($this->isOnline()){
            $defaul_password = Random::generate(8);
            $author= new User();
            $author->name = $this->name;
            $author->username = $this->username;
            $author->email = $this->email;
            $author->password = Hash::make($defaul_password);
            $author->type = $this->author_type;
            $author->direct_publish = $this->direct_publisher;
            $saved = $author->save();
            $data = array(
                'name'=>$this->name,
                'username'=>$this->username,
                'email'=>$this->email,
                'password'=>$defaul_password,
                'url'=>route('author.profile'),

            );

            $author_email= $this->email;
            $author_name =$this->name;
            if($saved){
                Mail::send('new-author-email-template',$data,function($message) use ($author_email,$author_name){
                    $message->from('huynhhuy12149@gmail.com','LaraBlog');
                    $message->to($author_email,$author_name)
                            ->subject('Account Creation');
                });
                $this->name=$this->email=$this->username=$this->direct_publisher=$this->author_type=null;
                
                $this->showToastr('New author has been added to blog','success');
                $this -> dispatchBrowserEvent('hideSdd_author_modal');
            }else{
                $this->showToastr('Something went wrong','error');
            }


            
        }else{
            $this->showToastr('You are offline, check connection network','error');
        }
    }

    // edit cac user hien modal user
    public function editAuthor($author){
        // dd('test',$author.id);
        // thong qua script authors.blade.php ddeer show modal
        $this->dispatchBrowserEvent('showEditAuthorModal');
        $this->selected_author_id = $author['id'];
        $this->name = $author['name'];
        $this->username = $author['username'];
        $this->email = $author['email'];
        $this->author_type = $author['type'];
        $this->direct_publisher = $author['direct_publish'];
        $this->blocked = $author['blocked'];
       

    }
   
    // lenh khi bam nut thi update profile user
    public function updateAuthor(){
         

        if($this->selected_author_id){
            $author=User::find($this->selected_author_id);
            $author->update([
                'name' => $this->name,
                'email' => $this->email,
                'username' => $this->username,
                'type' => $this->author_type,
                'blocked' => $this->blocked,
                'direct_publish' => $this->direct_publisher,
            ]);
            $this->showToastr('Author has been successfully updated','success');
            $this->dispatchBrowserEvent('hideEditAuthorModal');

        }
    }

    // delete cac user
    public function deleteAuthor($author){
        // dd('test',$author);
        // // thong qua script authors.blade.php ddeer show modal
        // $this->dispatchBrowserEvent('showEditAuthorModal');
        // $this->selected_author_id = $author['id'];
        // $this->name = $author['name'];
        // $this->username = $author['username'];
        // $this->email = $author['email'];
        // $this->author_type = $author['type'];
        // $this->direct_publisher = $author['direct_publish'];
        // $this->blocked = $author['blocked'];
       $this->dispatchBrowserEvent('deleteAuthor',[
            'title'=>'Are you Sure ?',
            'html'=>'You want to delete Author : <br><b>'.$author['name'].'</b>',
            'id'=>$author['id'],
       ]);

    }

    public function deleteAuthorAction($id){
        // dd('test');
        $author = User::find($id);
        // dd($author);
        $path ='back/dist/img/author/';
        $author_picture = $author -> getAttributes()['picture'];
        // dd($author_picture);
        $picture_path = $path.$author_picture; 
        if($author_picture != null && File::exists(public_path($picture_path))){
            File::delete(public_path($picture_path));
        }
        $author->delete();
        $this->showToastr('Author has been successfull deleted','info');
    }
    // kiem tra trang thai xem co mang hay khong
    public function isOnline($site = "https://youtube.com"){
        if(@fopen($site,"r")){
            return true;
        }else{
            return false;
        }
    }

    // hien thi cac trang thai thanh cong tren mang hinh
    public function showToastr($message,$type){
        $this->dispatchBrowserEvent('showToastr',[
            'type'=>$type,
            'message'=>$message
        ]);
    }
    public function render()
    {
       
         
        return view('livewire.authors',[
            'authors'=>User::search(trim($this->search))
                            ->where('id','!=',auth()->id())->paginate($this->perPage),
        ]);
    }
}

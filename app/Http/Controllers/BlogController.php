<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB; 
use Carbon\Carbon;

class BlogController extends Controller
{

    // public function showLoginForm()
    // {
    //     return view('front.pages.user.login');
    // }

    public function categoryPosts(Request $request, $slug)
    {
        if (!$slug) {
            return abort(404);
        } else {
            $subcategory = SubCategory::where('slug', $slug)->first();
            if (!$subcategory) {
                return abort(404);
            } else {
                $posts = Post::where('category_id', $subcategory->id)
                    ->orderBy('created_at', 'desc')
                    ->paginate(6);
                //  truyền qua trang danh mục cuat blog 
                $data = [
                    'pageTitle' => 'Category - ' . $subcategory->subcategory_name,
                    'category' => $subcategory,
                    'posts' => $posts
                ];
                return view('front.pages.category_posts', $data);
            }
        }

    }

    public function searchBlog(Request $request)
    {
        $query = request()->query('query');
        if ($query && strlen($query) >= 2) {
            $searchValues = preg_split('/\s+/', $query, -1, PREG_SPLIT_NO_EMPTY);
            $posts = Post::query();
            $posts->where(function ($q) use ($searchValues) {
                foreach ($searchValues as $value) {
                    $q->orWhere('post_title', 'LIKE', "%{$value}");
                    $q->orWhere('post_tags', 'LIKE', "%{$value}%");
                }

            });
            $posts = $posts->with('subcategory')
                ->with('author')
                ->orderBy('created_at', 'desc')
                ->paginate(6);
            $data = [
                'pageTitle' => 'Search For :: ' . request()->query('query'),
                'posts' => $posts
            ];
            return view('front.pages.search_posts', $data);
        } else {
            return abort(404);
        }
    }

    public function readPost($slug)
    {
        if (!$slug) {
            return abort(404);
        } else {
            $post = Post::where('post_slug', $slug)
                ->with('subcategory')
                ->with('author')
                ->first();

            $post_tags = explode(',', $post->post_tags);
            $related_posts = Post::where('id', '!=', $post->id)
                ->where(function ($query) use ($post_tags, $post) {
                    foreach ($post_tags as $item) {
                        $query->orWhere('post_tags', 'like', "%$item%")
                            ->orWhere('post_title', 'like', $post->post_title);
                    }
                })
                ->inRandomOrder()
                ->take(3)
                ->get();

            $data = [
                'pageTitle' => Str::ucfirst($post->post_title),
                'post' => $post,
                'related_posts' => $related_posts
            ];
            return view('front.pages.single_post', $data);
        }
    }

    public function tagPosts(Request $request, $tag)
    {
        $posts = Post::where('post_tags', 'like', '%' . $tag . '%')
            ->with('subcategory')
            ->with('author')
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        if (!$posts)
            return abort(404);

        $data = [
            'pageTitle' => '#' . $tag,
            'posts' => $posts
        ];

        return view('front.pages.tag_posts', $data);
    }


    //  hiển thị form đăng nhập
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect('/');
        }

        if (session()->has('login_success')) {
            session()->forget('login_success');
            return redirect('/');
        }

        return view('front.pages.user.login');
    }

    // đăng nhập user
    public function login(Request $request)
    {


        $fieldType = filter_var($request->login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        if ($fieldType == 'email') {
            $request->validate([
                'login_id' => 'Required|email|exists:users,email',
                'password' => 'Required|min:5'
            ], [
                    'login_id.required' => 'Enter your email address',
                    'login_id.email' => 'Invalid email address',
                    'login_id.exists' => 'This email is not register',
                    'password.required' => 'Password is required'
                ]);
        } else {
            $request->validate([
                'login_id' => 'Required|exists:users,username',
                'password' => 'Required|min:5'
            ], [
                    'login_id.required' => 'Enter your email address',
                    'login_id.exists' => 'This email is not register',
                    'login_id.password' => 'Password is required'
                ]);

        }

        $user = User::where($fieldType, $request->login_id)->first();
        if (password_verify($request->password, $user->password)) {
            if($user->blocked == 0){
                
                $request->session()->put('user', [
                    'id'=> $user->id,
                    'name' => $user->name,
                    'username' => $user->username,
                    'email' => $user->email,
                    'picture' => $user->picture,
                    'biography' => $user->biography
                ]);
                session()->put('login_success', true);
    
    
                return redirect('/');
            }else{
                session()->forget('login_success');
                session()->forget('user');
        
                session()->flash('fail', 'Your account had been blocked.');
                return redirect()->route('login');
            }
           

        } else {
            session()->flash('fail', 'Incorrect email or password');

            return redirect()->route('login');

        }




    }
    

    // logout user
    public function logout()
    {

        session()->forget('login_success');
        session()->forget('user');
        return redirect('/');


    }

    //  register user blog
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect('/');
        }

        if (session()->has('login_success')) {
            session()->forget('login_success');
            return redirect('/');
        }

        return view('front.pages.user.register');
    }

    public function register(Request $request){
        // dd($request);
        $request->validate([
            'username'=>'required|unique:users,username|min:10',
            'email'=>'Required|email|unique:users,email',
            'password'=>'required|min:5',
            'confirm_password'=>'same:password'
            
        ],[
            'password.required'=>'The password is required',
            'password.min'=>'Minium characters must be 5',
            'confirm_password.same'=>'Confirm password and new password must match',
            'email.required'=>'Enter your email address',
            'email.email'=>'Invalid email address',
            'email.unique'=>'Email already exists',
        ]);

        
        
        
        
            $token = Str::random(10);
            $userregis= new User();
            $userregis->name = $request->fullname;
            $userregis->email = $request->email;
            $userregis->username = $request->username;
            $userregis->password = bcrypt( $request->confirm_password);
            $userregis->blocked = 1;
            $userregis->type = 3;
            $userregis->remember_token = $token;
            $save = $userregis->save();
            $data = array(
                'name'=>$request->fullname,
                'email'=>$request->email,
                'token'=>$token,
                'url'=>route('login'),

            );

            $author_email= $request->email;
            $author_name =$request->fullname;
            if($save){
                Mail::send('new-user-blog',$data,function($message) use ($author_email,$author_name){
                    $message->from('huynhhuy12149@gmail.com','LaraBlog');
                    $message->to($author_email,$author_name)
                            ->subject('Account Creation');
                });
                
            }
            session()->flash('success','Your account has been created successfully.');
                return redirect()->route('login');

    }

    public function active_account($email , $token){
        // dd($email, $token);
        $check = User::where('email', $email)
                ->where('remember_token', $token)
                ->first();
        if($check->remember_token == $token && $check->email == $email ){
           if( $check -> update(['remember_token'=>null,'blocked'=>0])){
            session()->flash('success','Your account has been actived successfully.');
                return redirect()->route('login');
           }else{
                session()->flash('fail','Your account has not been actived successfully.');
                
           }

        }
    }


    // quên mật khẩu đăng nhập

    public function showforgotuser(){
        return view('front.pages.user.reset-form');
    }

    public function forgot_user(Request $request){
        $request->validate([
            'email'=>'required|email|exists:users,email'
        ],[
            'email.required'=>'The :attribute is required ',
            'email.email'=>'Invalid :attribute address',
            'email.exists'=>'The :attribute is not registered'
        ]);

        $token = Str::random(10);
        DB::table('password_reset_tokens')->insert([
                'email'=>$request->email,
                'token'=>$token,
                'created_at'=>Carbon::now(),
        ]);
        $user =User::where('email',$request->email)->first();
        

        $data = array(
            'name'=> $user->name,
            'email'=> $user->email,
            'token'=>$token
        );
        
        Mail::send('forgot-email-template',$data, function($message) use ($user){
            $message->from('huynhhuy12149@gmail.com','Larablog');
            $message->to($user->email,$user->name)->subject('Reset Password');

        });
        
        
        
        session()->flash('success','We have e-mailed your password reset link');
        return redirect()->route('forgot-user');

    }

    public function ResetForm($token,$email){
        $checktoken = DB::table('password_reset_tokens')->where(
            [
                'email'=>$email,
                'token'=>$token,
            ]
        )->first();

        if($checktoken){
            return view('front.pages.user.forgot-user')->with([
                'token' => $token,
                'email' => $email,
            ]);
            
        }
        return abort(404);
    }

    public function changepassword( $token ,$email,Request $request){
        $request->validate([
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
                'email'=>$request->email,
                'token'=>$token,
            ]
        )->first();
        if(!$checktoken){
            session()->flash('fail','Invail Token');

        }else { 
            User::where('email',$request->email)->update([
                'password'=>bcrypt($request->new_password)
            ]);
            DB::table('password_reset_tokens')->where([
                'email'=>$request->email
            ])->delete();
            
            session()->flash('success','Your password has been updated successfully.');
           return redirect()->route('login');
        }
        return redirect()->route('login');
        
    }


    public function comment($user_id,$post_id,Request $request){
        $request->validate([
            'content'=>'required',
        ],[
            'content.required'=>'Bình luận không được để trống',
        ]);

        $data =[
            'user_id'=>$user_id,
            'post_id'=>$post_id,
            'content'=>$request->content,
            'reply_id'=>$request->reply_id ? $request->reply_id : 0,
        ];
        if ($comment = Comment::create($data)) {
            // return response()->json(['status'=>1,'msg'=>'Bình luận thành công']);
            $comments = Comment::where(['post_id'=>$post_id,'reply_id'=>0])->orderBy('created_at','DESC')->get();
            return view('front.pages.list_comment',compact('comments'));
        } else{
            return response()->json(['status'=>2,'msg'=>'Bình luận thất bại']);
        }

        
    }



}
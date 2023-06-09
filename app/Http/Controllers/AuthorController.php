<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class AuthorController extends Controller
{
    public function index(Request $request){
        return view('back.pages.home');
    }

    public function logout(){
        Auth::guard('web')->logout();
        return redirect()->route('author.login');
    }

    public function ResetForm(Request $request,$token = null){
        $data =['pageTitle'=>'Reset Password'];
        return view('back.pages.auth.reset',$data)->with(['token'=>$token,'email'=>$request->email]);
    }

    public function changeProfilePicture(Request $request){
        $user = User::find(auth('web')->id());
        $path = 'back/dist/img/author/';
        $file = $request->file('file');
        $old_picture = $user->getAttributes()['picture'];
        $file_path = $path.$old_picture;
        $new_picture_name = 'AIMG'.$user->id.time().rand(1,100000).'.jpg';
        if($old_picture!=null && File::exists(public_path($file_path))){
            File::delete(public_path($file_path));
        }

        $upload = $file->move(public_path($path),$new_picture_name);
        if($upload){
            $user->update([
                'picture'=>$new_picture_name
            ]);
            return response()->json(['status'=>1,'msg'=>'Your profile picture has been successfully updated']);

        }else{
            return response()->json(['status'=>0,$new_picture_name]);
        }
    }

    public function changeBlogLogo(Request $request){
        $settings = Setting::find(1);
        $logo_path = 'back/dist/img/logo-favicon';
        $old_logo = $settings->getAttributes()['blog_logo'];
        $file = $request->file('blog_logo');
        
       
        $filename = time().'_'.rand(1,100000).'_larablog_logo.png';
        
        if($request->hasFile('blog_logo')){
            if($old_logo !=null && File::exists(public_path($logo_path.$old_logo))){
                File::delete(public_path($logo_path.$old_logo));
            }
            $upload = $file->move(public_path($logo_path),$filename);
            if($upload){
                $settings->update([
                'blog_logo'=>$filename
                ]);
                
                return response()->json(['status'=>1,'msg'=>'Your profile picture has been successfully updated']);

            }else{
                return response()->json(['status'=>0,'Something went wrong']);
            }

        }
        

        // $upload = $file->move(public_path($path),$new_picture_name);
        // if($upload){
        //     $user->update([
        //         'picture'=>$new_picture_name
        //     ]);
        //     return response()->json(['status'=>1,'msg'=>'Your profile picture has been successfully updated']);

        // }else{
        //     return response()->json(['status'=>0,$new_picture_name]);
        // }
        
    }


    public function changeBlogFavicon(Request $request){
        
        $settings = Setting::find(1);
        $favicon_path = 'back/dist/img/logo-favicon';
        $old_favicon = $settings->getAttributes()['blog_favicon'];
        $file = $request->file('blog_favicon');
        
       
        $filename = time().'_'.rand(1,100000).'_larablog_favicon.png';
        if($request->hasFile('blog_favicon')){
            if($old_favicon !=null && File::exists(public_path($favicon_path.$old_favicon))){
                File::delete(public_path($favicon_path.$old_favicon));
            }
            $upload = $file->move(public_path($favicon_path),$filename);
            if($upload){
                $settings->update([
                'blog_favicon'=>$filename
                ]);
                
                return response()->json(['status'=>1,'msg'=>'Your profile picture has been successfully updated']);

            }else{
                return response()->json(['status'=>0,'Something went wrong']);
            }

        }
        

        // $upload = $file->move(public_path($path),$new_picture_name);
        // if($upload){
        //     $user->update([
        //         'picture'=>$new_picture_name
        //     ]);
        //     return response()->json(['status'=>1,'msg'=>'Your profile picture has been successfully updated']);

        // }else{
        //     return response()->json(['status'=>0,$new_picture_name]);
        // }
        
    }


    // public function createPost(Request $request){

       
    //     $request->validate([
    //         'post_title'=>'required|unique:posts,post_title',
    //         'post_content'=>'required',
            
    //         'featured_image'=>'required|mimes:jpeg,jpg,png|max:1024', 
    //     ]);
        
    //     dd($request->all());
        
    //     if($request->hasFile('featured_image')){

    //         $path="images/post_images/";
    //         $file = $request->file('featured_image');
    //         $filename = $file->getClientOriginalName();
    //         $new_filename = time().'_'.$filename;
    //         $upload = Storage::disk('public')->put($path.$new_filename, (string) file_get_contents($file));
            
            
    //         if($upload){
    //             $post= new Post();
    //             $post->author_id = auth()->id();
    //             $post->category_id=$request->post_category;
    //             $post->post_title = $request->post_title;
    //             $post->post_slug = Str::slug($request->post_title);
    //             $post->post_content=$request->post_content;
    //             $post->featured_image= $new_filename;
    //             $saved = $post->save();
    //             if($saved){
    //                 return response()->json(['code'=>1,'msg'=> 'New post has been successfully created']);
    //             } else {
    //                 return response()->json(['code'=>3,'msg'=> 'Something went wrong in saving post data']);
    //             }
    //         }else{
    //             return response()->json(['code'=>3,'msg'=>'Something went wrong for uploading featured image']);
    //         }
    //     }
    // }
    

    public function createPost(Request $request){
        $request->validate([
            'post_title'=>'required|unique:posts,post_title',
            'post_content'=>'required',
            'featured_image'=>'required|mimes:jpeg,jpg,png|max:1024', 
        ]);
        
        if($request->hasFile('featured_image')){
            $path="images/post_images/";
            $file = $request->file('featured_image');
            $filename = $file->getClientOriginalName();
            $new_filename = time().'_'.$filename;
            $upload = Storage::disk('public')->put($path.$new_filename, (string) file_get_contents($file));
            $image_file = "test.png";
            $post_thumbnails_path  = $path.'thumbnails';
            if(!Storage::disk('public')->exists( $post_thumbnails_path)){
                Storage::disk('public')->makeDirectory(  $post_thumbnails_path,0755, true, true);
            } 

            // tao mot square thumbnails
            Image::make( storage_path('app/public/'.$path.$new_filename))
                ->fit(200,200)
                ->save(storage_path('app/public/'.$path.'thumbnails/'.'thumb_'.$new_filename)); 

            // tao kich thuoc resize image
            Image::make(storage_path('app/public/'.$path.$new_filename))
                ->fit(500,300)
                ->save(storage_path('app/public/'.$path.'thumbnails/'.'resized_'.$new_filename));
            if($upload){
                $post= Post::create([
                    'author_id' => auth()->id(),
                    'category_id' => $request->post_category,
                    'post_title' => $request->post_title,
                    'post_slug' => Str::slug($request->post_title),
                    'post_content' => $request->post_content,
                    'post_tags'=> $request->post_tags,
                    'featured_image' => $new_filename,
                    
                ]);
                if($post){
                    return response()->json(['status'=>1,'msg'=>'New post has been successfully created']);
                } else {
                    return response()->json(['status'=>3,'msg'=> 'Something went wrong in saving post data']);
                }
                
                
    
                
            } else {
                return response()->json(['status'=>3,'msg'=> 'Something went wrong for uploading featured image']);
            }
        }
    }

    public function editPost(Request $request){
        if(!request()->post_id){
            return abort(404);

        }else{
            $post = Post::find(request()->post_id);
            $data = [
                'post'=> $post,
                'pageTitle'=> 'Edit Post'
            ];
            return view('back.pages.edit_post',$data);
        }
    }
    
    public function updatePost(Request $request){
        if($request->hasFile('featured_image')){
            $request->validate([
                'post_title'=>'required|unique:posts,post_title,'.$request->post_id,
                'post_content'=>'required',
                'post_category'=>'required|exists:sub_categories,id',
                'featured_image'=>'mimes:jpeg,jpg,png|max:1024'
            ]);

            $path = "images/post_images/";
            $file = $request->file('featured_image');
            // $filename = $file->getClientOriginalName();
            $filename = $file->getClientOriginalName();
            $new_filename = time().'_'.$filename; 
            $upload = Storage::disk('public')->put($path.$new_filename, (string) file_get_contents($file));
            $post_thumbnails_path  = $path.'thumbnails';
            if(!Storage::disk('public')->exists( $post_thumbnails_path)){
                Storage::disk('public')->makeDirectory(  $post_thumbnails_path, 0755, true, true);
            } 

            // tao mot square thumbnails
            Image::make( storage_path('app/public/'.$path.$new_filename))
                ->fit(200,200)
                ->save(storage_path('app/public/'.$path.'thumbnails/'.'thumb_'.$new_filename)); 

            // tao kich thuoc resize image
            Image::make(storage_path('app/public/'.$path.$new_filename))
                ->fit(500,300)
                ->save(storage_path('app/public/'.$path.'thumbnails/'.'resized_'.$new_filename));

            if($upload){
                $old_post_image = Post::find($request->post_id)->featured_image;
                if($old_post_image != null && Storage::disk('public')->exists($path.$old_post_image)){
                    Storage::disk('public')->delete($path.$old_post_image);
                    if(Storage::disk('public')->exists($path.'thumnails/resized_'.$old_post_image)){
                        Storage::disk('public')->delete($path.'thumnails/resized_'.$old_post_image);
                    }

                    if(Storage::disk('public')->exists($path.'thumnails/thumb_'.$old_post_image)){
                        Storage::disk('public')->delete($path.'thumnails/thumb_'.$old_post_image);
                    }
                }

                $post = Post::find($request->post_id);
             
                $post->category_id = $request->post_category;
                $post->post_slug= null;
                $post->post_content = $request->post_content;
                $post->post_title = $request->post_title;
                $post->featured_image = $new_filename;
                $post->post_tags =$request->post_tags;
                $save = $post->save();
                if($save){
                    return response()->json(['status'=>1,'msg'=>'Post has been successfully updated']);
                }else{
                    return response()->json(['status'=>3,'msg'=> 'Something went wrong for updating post.']);
                }
            }else{
                return response()->json(['status'=>3,'msg'=>'Error in uploading']);
            }
        }else{
            $request->validate([
                'post_title'=>'required|unique:posts,post_title,'.$request->post_id,
                'post_content'=>'required',
                'post_category'=>'required|exists:sub_categories,id'
            ]);
            $post = Post::find($request->post_id);
            $post->category_id = $request->post_category;
            $post->post_slug= null;
            $post->post_content = $request->post_content;
            $post->post_title = $request->post_title;
            $post-> post_tags =$request->post_tags;

            $save = $post->save();
            if($save){
                return response()->json(['status'=>1,'msg'=>'Post has been successfully updated']);
            }else{
                return response()->json(['status'=>3,'msg'=> 'Something went wrong for updating post.']);
            }

        }
    }
}

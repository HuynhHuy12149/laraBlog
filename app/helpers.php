<?php
use App\Models\Setting;
use App\Models\Post;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Carbon\Carbon;


if(!function_exists('blogInfo')){
    function blogInfo(){
        return Setting::find(1);
    }
}

// định dạng date()
if(!function_exists('date_formatter')){
    function date_formatter($date){
        return Carbon::createFromFormat('Y-m-d H:i:s',$date)->isoFormat('LL');

    }
}

// trips word
if(!function_exists('words')){
    function words($value, $words=15,$end="..."){
        return Str::words(strip_tags($value),$words,$end);

    }
}

//  kiểm tra coi user có online không
if(!function_exists('isOnline')){
    function isOnline($site="https://youtube.com"){
        if(@fopen($site,"r")){
            return true;
        }else{
            return false;
        }
    }
}

// reading article duảtion
if(!function_exists('readDuration')){
    function readDuration(...$text){
        Str::macro('timeCounter',function($text){
            $totalWords = str_word_count(implode("",$text));
            $minuteToRead = round($totalWords/200);
            return (int)max(1,$minuteToRead);
        });
        return Str::timeCounter($text);    
    }

}

// post main trong web hiển thị chính giữa trang web
if(!function_exists('single_latest_post')){
    function single_latest_post(){
        
        return Post::with('author')    
                    ->with('subcategory')
                    ->limit(1)
                    ->orderBy('created_at','desc')
                    ->first();
    
    }               
    

}


// hiển thị 6 post trên home 
if(!function_exists('latest_home_6posts')){
    function latest_home_6posts(){
        
        return Post::with('author')
                    ->with('subcategory')
                    ->skip(1)
                    ->limit(6)
                    ->orderBy('created_at','desc')
                    ->get();  
    }

}

// hiển thị post random

if(!function_exists('recommended_posts')){
    function recommended_posts(){
        
        return Post::with('author')
                    ->with('subcategory')
                    ->limit(4)
                    ->inRandomOrder()
                    ->get();  
    }




}


// so bai báo trong các danh mục

if(!function_exists('categories')){
    function categories(){
        
        return SubCategory::whereHas('posts')
                    ->with('posts')
                    ->orderBy('subcategory_name','asc')
                    ->get();  
    }




}

// lastest post

if(!function_exists('latest_sidebar_posts')){
    function latest_sidebar_posts($except = null,$limit =4){
        
        return  Post::where('id','!=',$except)
                    ->limit($limit)
                    ->orderBy('created_at','desc')
                    ->get();
    }




}
//  lấy tất cả thẻ tag
if(!function_exists('all_tags')){
    function all_tags(){
        
        return  Post::where('post_tags','!=',null)->distinct()->pluck('post_tags')->join(','); 
    }




}
?>
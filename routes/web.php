<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::middleware(['nocache'])->group(function () {
    
    Route::view('/', 'front.pages.home')->name('home');
    // Route::get('/article/{any}', [BlogController::class, 'readPost'])->name('read_post');
    Route::match(['get', 'post'], '/article/{any}', [BlogController::class, 'readPost'])->name('read_post');

    Route::get('/category', [BlogController::class, 'categoryPosts'])->name('category_posts');
    
    Route::get('/posts/tag/{any}', [BlogController::class, 'tagPosts'])->name('tag_posts');
    Route::get('/search', [BlogController::class, 'searchBlog'])->name('search_posts');
    
    
    Route::get('/logout', [BlogController::class, 'logout'])->name('logout');
    Route::get('/login', [BlogController::class, 'showLoginForm'])->name('login')->middleware('userLoggin');
    Route::post('/login', [BlogController::class, 'login'])->name('login');
    
    Route::get('/register', [BlogController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [BlogController::class, 'register'])->name('register');
    Route::get('/active-account-user/{email}/{token}',[BlogController::class,'active_account'])->name('active-account-user');
    
    
    Route::get('/forgot-user', [BlogController::class, 'showforgotuser'])->name('forgot-user');
    Route::post('/forgot-user', [BlogController::class, 'forgot_user'])->name('forgot-user');
    Route::get('/reset-form/{token}/{email}', [App\Http\Controllers\BlogController::class, 'ResetForm'])->name('reset-form');
    
    Route::post('/reset-form/{token}/{email}',[BlogController::class,'changepassword'])->name('change-password');
    
});
// Route::get('/login/facebook', [BlogController::class, 'test'])->name('loginfacebook');
Route::get('/login/google', [LoginController::class, 'redirectToGoogle'])->name('logingoogle');
Route::get('/login/google/callback', [LoginController::class, 'handleGoogleCallback']);


Route::get('/login/facebook', [LoginController::class, 'redirectToFacebook'])->name('loginfacebook');
Route::get('/login/facebook/callback', [LoginController::class, 'handleFacebookCallback']);


// comment

    Route::post('/comment/{user_id}/{post_id}',[BlogController::class,'comment'])->name('comment');




?>
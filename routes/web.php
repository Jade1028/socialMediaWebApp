<?php

use App\Http\Controllers\FriendController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/y', [PostController::class, 'index'])->name('y.index');


Auth::routes(); // This is the default authentication routes: /login, /register, /logout

Route::controller(HomeController::class)->group(function(){
    Route::get('/home', 'index')->name('home');
    Route::get('/about','about')->name('about');
    Route::get('/contact','contact')->name('contact');
    Route::get('/profile','profile')->name('profile');
});


Route::controller(MessageController::class)->group(function(){
    Route::get('/message/{id}', 'index')->name('messages.index');
    Route::post('/message/{id}', 'store')->name('message.send');
    Route::get('/message/edit/{id}', 'edit')->name('message.edit');
    Route::post('/message/update/{id}', 'update')->name('message.update');
    Route::delete('/message/delete/{id}', 'destroy')->name('message.delete');
});

Route::middleware('auth')->controller(FriendController::class)->group(function(){
    Route::get('/friends','index')->name('friends');
    Route::get('/friends/add/{id}','store')->name('friends.store');
    Route::get('/friends/accept/{id}','accept')->name('friends.accept');
    Route::get('/friends/reject/{id}','reject')->name('friends.reject');
});

Route::middleware('auth')->controller(UserController::class)->group(function(){
    Route::get('/users','userView')->name('users.view');
    Route::get('/users/search','search')->name('users.search');
});


Route::middleware(['auth'])->group(function () {
    Route::post('/posts/{postId}/toggle-like', [PostController::class, 'toggleLike'])->name('posts.toggleLike');
});
<?php

use App\Http\Controllers\FollowController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeCommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
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

// Google URL
Route::get('/login/google', [GoogleController::class, 'redirectGoogle'])->name('login.google');
Route::get('/login/google/callback', [GoogleController::class, 'handleGoogleCallback']);
Route::get('/user/{user}', [UserController::class, 'profile'])->name('profile');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {

    Route::get('/dashboard', [HomeController::class, 'home'])->name('dashboard');
});

Route::resource('/post', 'App\Http\Controllers\PostController');
Route::resource('/follow', 'App\Http\Controllers\FollowController');
Route::resource('/comment', 'App\Http\Controllers\CommentController');
Route::resource('/like', 'App\Http\Controllers\LikeController');
Route::resource('/message', 'App\Http\Controllers\MessageController');
Route::resource('/likecomment', 'App\Http\Controllers\LikeCommentController');
Route::post('/deslike', [LikeController::class, 'deslike'])->name('deslike');
Route::post('/deslikecomment', [LikeCommentController::class, 'deslikecomment'])->name('deslikecomment');
Route::get('talk/{user}', [MessageController::class, 'talk'])->name('talk');
Route::post('desfollow', [FollowController::class, 'desfollow'])->name('desfollow');

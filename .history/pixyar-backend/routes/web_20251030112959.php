<?php

use App\Http\Controllers\landing;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InstagramController;

use App\Http\Controllers\InstagramPostsController;
use App\Http\Controllers\InstagramCommentsController;

Route::get('/',[landing::class,'show'])->withoutMiddleware('web');


Route::get('/login', [AuthController::class,'index'])->withoutMiddleware('web')->name();
Route::post('/register', [AuthController::class,'register'])->withoutMiddleware('web');
Route::post('/login', [AuthController::class,'login'])->withoutMiddleware('web');
Route::post('/logout', [AuthController::class,'logout'])->withoutMiddleware('web');



Route::middleware('auth:sanctum')->withoutMiddleware('web')->group(function () {
    Route::post('/instagram/fetch', [InstagramController::class, 'fetchProfile']);
    Route::get('/instagram', [InstagramController::class, 'index']);
    Route::delete('/instagram/{id}', [InstagramController::class, 'delete']);
    Route::get('/instagram/analytics', [InstagramController::class, 'analytics']);
});


Route::post('/fetch-posts', [InstagramPostsController::class, 'fetchPosts'])->withoutMiddleware('web');



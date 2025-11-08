<?php


use App\Http\Controllers\landing;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InstagramController;

use App\Http\Controllers\InstagramPostsController;
use App\Http\Controllers\Admin\AdminPanelController;
use App\Http\Controllers\InstagramCommentsController;

Route::get('/',[landing::class,'show']);



Route::get('/login', [AuthController::class,'index'])->name('login');
Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);
Route::post('/logout', [AuthController::class,'logout']);








Route::middleware('auth:sanctum')->group(function () {
    Route::get('/AdminPanel/{id}', [AdminPanelController::class,'index'])->name('AdminPanel.Index');
    Route::get('/AdminPanel/{idprofile}/post/{idpost}', [AdminPanelController::class,'showpost'])->name('AdminPanel.Sh');
    Route::get('/AdminPanel/bestTimeHeatmap/{idprofile}', [AdminPanelController::class,'bestTimeHeatmap'])->name('AdminPanel.bestTimeHeatmap');
        Route::get('/AdminPanel/followersGrowth/{idprofile}', [AdminPanelController::class,'followersGrowth'])->name('AdminPanel.followersGrowth');
    Route::get('/select', [AdminPanelController::class,'select'])->name('AdminPanel.select');
    Route::get('/starter', [AdminPanelController::class,'starter'])->name('AdminPanel.starter');
    Route::post('/instagram/fetch', [InstagramController::class, 'fetchProfile'])->name('calldata');
    Route::get('/instagram', [InstagramController::class, 'index']);
    Route::delete('/instagram/{id}', [InstagramController::class, 'delete']);
    Route::get('/instagram/analytics', [InstagramController::class, 'analytics']);
});


Route::post('/fetch-posts', [InstagramPostsController::class, 'fetchPosts']);






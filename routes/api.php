<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::controller(BlogController::class)->group(function () {
    Route::get('/blogs', 'index');
    Route::get('/blogs/user', 'getUserBlogs');
    Route::get('/blogs/blog', 'show');
});

Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::controller(AuthController::class)->group(function(){
        Route::get("/user", 'show');
    });
    Route::controller(BlogController::class)->group(function(){
        Route::post('/blogs/create', 'store');
        Route::put('/blogs/update', 'update');
        Route::delete('/blogs/delete', 'destroy');
    });
});

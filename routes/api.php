<?php

use App\Http\Controllers\AuthControl;
use App\Http\Controllers\CommentControl;
use App\Http\Controllers\PostControl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/register', [AuthControl::class, 'register']);
Route::post('/login', [AuthControl::class, 'login']);
// Route::post('/logout', [AuthControl::class, 'logout']);
Route::group(['middleware'=> ['auth:sanctum']], function(){
    Route::get('/user',[AuthControl::class,'user']);
    Route::put('/user',[AuthControl::class,'update']);
    Route::post('/logout',[AuthControl::class,'logout']);

    Route::get('/posts', [PostControl::class,'index']);
    Route::post('/posts', [PostControl::class,'store']);
    Route::get('/posts/{id}', [PostControl::class,'show']);
    Route::put('/posts/{id}', [PostControl::class,'update']);
    Route::delete('/posts/{id}', [PostControl::class,'destroy']);

    Route::get('/posts/{id}/comments', [CommentControl::class,'index']);
    Route::post('/posts/{id}/comments', [CommentControl::class,'store']);
    Route::put('/comments/{id}', [CommentControl::class,'update']);
    Route::delete('/comments/{id}', [CommentControl::class,'destroy']);
});
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViewController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/index',[ViewController::class,'index']);
Route::get('/home',[ViewController::class,'home']);
Route::get('/about',[ViewController::class,'about']);
Route::get('/login',[ViewController::class,'login']);
Route::get('/signup',[ViewController::class,'signup']);
Route::get('/users',[ViewController::class,'users']);
Route::get('/form',[ViewController::class,'form']);
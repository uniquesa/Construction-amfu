<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViewController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/index',[ViewController::class,'index']); //admin
Route::get('/index',[ViewController::class,'index']);
Route::get('/login',[ViewController::class,'login']);
Route::get('/signup',[ViewController::class,'signup']);
Route::get('/users',[ViewController::class,'users']);
Route::get('/form',[ViewController::class,'form']);
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//pending approval route
Route::get('/no-role', function () {return view('no-role');})->name('no.role');


// Protected routes for users with roles
Route::middleware(['role:Admin'])->group(function () {
    Route::get('/admin/users', [UserManagementController::class, 'index'])->name('admin.users');
    Route::post('/admin/users/{id}/assign-role', [UserManagementController::class, 'assignRole'])->name('admin.users.assignRole');
});


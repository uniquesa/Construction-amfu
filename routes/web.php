<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/index',[ViewController::class,'index']); 
// Route::get('/index',[ViewController::class,'index']);
Route::get('/login',[ViewController::class,'login']);
Route::get('/ZUHAIB',[ViewController::class,'ZUHAIB']);
Route::get('/ZUHAIB2',[ViewController::class,'ZUHAIB2']);
Route::get('/signup',[ViewController::class,'signup']);
Route::get('/users',[ViewController::class,'users']);
Route::get('/form',[ViewController::class,'form']);

Route::get('/Admin.dashboard', [ViewController::class, 'adminDashboard'])->name('Admin.dashboard');


Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');

//pending approval route
Route::get('/no-role', function () {return view('no-role');})->name('no.role');


// Protected routes for users with roles
Route::middleware(['role:Admin'])->group(function () {
    Route::get('/Admin/user', [UserManagementController::class, 'index'])->name('Admin.user');
    Route::post('/admin/users/{id}/assign-role', [UserManagementController::class, 'assignRole'])->name('admin.users.assignRole');
});


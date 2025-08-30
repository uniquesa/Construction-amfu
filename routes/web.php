<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('auth.login');
});
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/index',[ViewController::class,'index']); 
Route::get('/login',[ViewController::class,'login']);
Route::get('/signup',[ViewController::class,'signup']);
Route::get('/users',[ViewController::class,'users']);
Route::get('/form',[ViewController::class,'form']);
Auth::routes();

// Admin Dashboard
Route::get('/admin/dashboard', [App\Http\Controllers\Auth\LoginController::class, 'dashboard'])
    ->name('admin.dashboard');
// PM Dashboard
Route::get('/pm/dashboard', [App\Http\Controllers\ViewController::class, 'pmDashboard'])
    ->name('pm.dashboard');
// FCO Dashboard
Route::get('/fco/dashboard', [App\Http\Controllers\ViewController::class, 'fcoDashboard'])
    ->name('fco.dashboard');
// PMO Dashboard
Route::get('/pmo/dashboard', [App\Http\Controllers\ViewController::class, 'pmoDashboard'])
    ->name('pmo.dashboard');
// CSO Dashboard
Route::get('/cso/dashboard', [App\Http\Controllers\ViewController::class, 'csoDashboard'])
    ->name('cso.dashboard');    
    
// User Management - Protected route for Admin only
Route::get('/admin/user-management', [App\Http\Controllers\UserManagementController::class, 'index'])
        ->name('admin.user-management');
// Assign Role to User - Protected route for Admin only
Route::put('/users/{user}/assign-role', [App\Http\Controllers\UserManagementController::class, 'assignRole'])
    ->name('users.assignRole');


//pending approval route
Route::get('/no-role', function () {return view('no-role');})->name('no.role');


// Protected routes for users with roles
Route::middleware(['role:Admin'])->group(function () {
    Route::get('/Admin/user', [UserManagementController::class, 'index'])->name('Admin.user');
    Route::post('/admin/users/{id}/assign-role', [UserManagementController::class, 'assignRole'])->name('admin.users.assignRole');
});
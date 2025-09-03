<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\ApprovalController;



Route::get('/', function () {
    return view('auth.login');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Static views
Route::get('/index',[ViewController::class,'index']); 
Route::get('/login',[ViewController::class,'login']);
Route::get('/signup',[ViewController::class,'signup']);
Route::get('/users',[ViewController::class,'users']);
Route::get('/form',[ViewController::class,'form']);
Auth::routes();

// Dashboards
Route::get('/admin/dashboard', [LoginController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/pm/dashboard', [ViewController::class, 'pmDashboard'])->name('pm.dashboard');
Route::get('/fco/dashboard', [ViewController::class, 'fcoDashboard'])->name('fco.dashboard');
Route::get('/pmo/dashboard', [ViewController::class, 'pmoDashboard'])->name('pmo.dashboard');
Route::get('/cso/dashboard', [ViewController::class, 'csoDashboard'])->name('cso.dashboard');    

// User Management
Route::get('/admin/user-management', [UserManagementController::class, 'index'])
        ->name('admin.user-management');
Route::put('/users/{user}/assign-role', [UserManagementController::class, 'assignRole'])
    ->name('users.assignRole');

// Pending approval
Route::get('/no-role', function () {
    return view('no-role');
})->name('no.role');

// Protected routes for Admin
Route::middleware(['role:Admin'])->group(function () {
    Route::get('/Admin/user', [UserManagementController::class, 'index'])->name('Admin.user');
    Route::post('/admin/users/{id}/assign-role', [UserManagementController::class, 'assignRole'])->name('admin.users.assignRole');
});

// ✅ Requests CRUD Routes (resource)
Route::resource('requests', RequestController::class);

// ✅ Default entry point to requests (agar manually jana ho)
Route::get('/all-requests', [RequestController::class, 'index'])->name('requests.all');


// ✅ Requests CRUD Routes (ONLY ONE resource)
Route::resource('requests', RequestController::class);

// ✅ Approvals Routes (nested under requests)
Route::prefix('requests/{request}')->group(function () {
    Route::post('/approve', [ApprovalController::class, 'approve'])->name('requests.approve');
    Route::post('/reject', [ApprovalController::class, 'reject'])->name('requests.reject');
});

// ✅ Attachments
Route::get('/attachments/{id}/download', [RequestController::class, 'downloadAttachment'])
    ->name('attachments.download');

// ✅ Separate Approvals routes (if needed globally)
Route::prefix('approvals')->name('approvals.')->group(function () {
    Route::post('/{id}/approve', [ApprovalController::class, 'approve'])->name('approve');
    Route::post('/{id}/reject', [ApprovalController::class, 'reject'])->name('reject');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('requests', RequestController::class);
});
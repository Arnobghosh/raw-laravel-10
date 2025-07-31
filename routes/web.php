<?php

use App\Http\Controllers\AreaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PurchaseController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
   return view('frontend.font-pages.index');
});
Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');

// ->prefix('dashboard')

// Auth Route Middleware group 
Route::middleware(['auth'])->group(function () {

   // Permission route
   Route::resource('branch', PurchaseController::class);
   Route::resource('purchase', PurchaseController::class);
   Route::resource('area', AreaController::class);

   Route::resource('permission', PermissionController::class);
   // Route::get('permission/{id}/delete', [PermissionController::class, 'destroy'])->name('permission.delete');

   // Role route
   Route::resource('role', RoleController::class);
   Route::get('role/{id}/delete', [RoleController::class, 'destroy'])->name('role.delete');
   Route::get('give-permission/{id}', [RoleController::class, 'AddPermission'])->name('add.permission');
   Route::put('give-permission/{id}', [RoleController::class, 'GivePermission'])->name('giv.permission');

   // ------- user route ------

   Route::resource('user', UserController::class);
   Route::get('/user/{id}/delete', [UserController::class, 'destroy']);
});
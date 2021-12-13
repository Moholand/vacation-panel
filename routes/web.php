<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VacationController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminVacationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::middleware(['auth'])->group(function () {
    Route::resource('/vacations', VacationController::class)->except('show');

    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::patch('/profile/{user}', [UserController::class, 'update'])->name('profile.update');
});

Route::middleware(['auth', 'admin.check'])->group(function () {
    Route::get('/admin/dashboard', [AdminVacationController::class, 'dashboard'])->name('admin.dashboard');
    Route::POST('/admin/vacations/store/{vacation}', [AdminVacationController::class, 'store'])->name('admin.vacations.store');
    
    Route::resource('/admin/users', AdminUserController::class)->only(['index', 'update']);
});

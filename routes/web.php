<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\VacationController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminVacationController;
use App\Http\Controllers\Admin\AdminDepartmentController;
use App\Http\Controllers\User\TeammateVacationController;

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
    // User routes
    Route::resource('/vacations', VacationController::class)->except('show');

    // Can be profile resource???
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::patch('/profile/{user}', [UserController::class, 'update'])->name('profile.update');

    Route::resource('/teammate-vacations', TeammateVacationController::class)->only('index', 'update');

    // Admin routes
    Route::prefix('/admin')->name('admin.')->middleware('admin.check')->group(function () {
        Route::resource('/vacations', AdminVacationController::class)->only(['index', 'update']);
        Route::resource('/users', AdminUserController::class)->only(['index', 'update']);
        Route::resource('/departments', AdminDepartmentController::class)->except('show');
    });
});

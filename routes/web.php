<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\VacationController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminProfileController;
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

Route::group(['middleware' => 'auth'], function() {
    // User routes
    Route::resource('/vacations', VacationController::class)->except('show');
    Route::get('/vacations/trashed', [VacationController::class, 'trashed'])->name('vacations.trashed');
    Route::patch('/vacations/{vacation}/restore', [VacationController::class, 'restore'])->name('vacations.restore');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile/{user}', [ProfileController::class, 'update'])->name('profile.update');

    Route::resource('/teammate-vacations', TeammateVacationController::class)->only('index', 'update');

    // Admin routes
    Route::group(['middleware' => 'admin.check', 'prefix' => '/admin', 'as' => 'admin.'], function() {
        Route::resource('/vacations', AdminVacationController::class)->only(['index', 'update']);
        Route::resource('/users', AdminUserController::class)->only(['index', 'update']);
        Route::resource('/departments', AdminDepartmentController::class)->except('show');

        // Is it posible to merge this with user profile routes???
        Route::get('/profile', [AdminProfileController::class, 'show'])->name('profile.show');
        Route::patch('/profile/{user}', [AdminProfileController::class, 'update'])->name('profile.update');
    });
});

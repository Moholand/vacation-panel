<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VacationController;
use App\Http\Controllers\admin\AdminVacationController;

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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/dashboard', [VacationController::class, 'dashboard'])->name('dashboard');
Route::get('/vacations/create', [VacationController::class, 'create'])->name('vacations.create');
Route::post('/vacations/store', [VacationController::class, 'store'])->name('vacations.store');
Route::get('/vacations/edit/{vacation}', [VacationController::class, 'edit'])->name('vacations.edit');
Route::patch('/vacations/update/{vacation}', [VacationController::class, 'update'])->name('vacations.update');
Route::delete('/vacations/delete/{vacation}', [VacationController::class, 'destroy'])->name('vacations.destroy');

Route::get('/admin/dashboard', [AdminVacationController::class, 'dashboard'])->name('admin.dashboard');
Route::POST('/admin/vacations/store/{vacation}', [AdminVacationController::class, 'store'])->name('admin.vacations.store');

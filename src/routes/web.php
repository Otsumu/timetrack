<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\AttendanceController;

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

Route::get('/register',[RegisteredUserController::class,'index'])->name('register');
Route::post('/register',[RegisteredUserController::class,'register'])->name('register.post');
Route::get('/login',[AuthenticatedSessionController::class,'index'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'login'])->name('login.post');

Route::middleware('auth')->group(function () {
  Route::get('/', [AttendanceController::class, 'index'])->name('home');
  Route::get('/attendance', [AttendanceController::class, 'dateList'])->name('index');
  Route::get('/attendance_date', [AttendanceController::class, 'attendanceDate'])->name('attendance_date');
  Route::post('/attendance', [AttendanceController::class, 'attendance'])->name('attendance'); 
  Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});




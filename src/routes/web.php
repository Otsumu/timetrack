<?php

use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\AttendanceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/register', [RegisteredUserController::class, 'index'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'register'])->name('register.post');
Route::get('/email/verify', function () {
  return view('auth.verify-email');
})->name('auth.verify-email');
Route::get('/login', [AuthenticatedSessionController::class, 'index'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'login'])->name('login.post');

Route::middleware('auth')->group(function () {
    Route::get('/', [AttendanceController::class, 'index'])->name('home');
    Route::get('/attendance', [AttendanceController::class, 'dateList'])->name('attendance.dateList');
    Route::get('/attendance/show', [AttendanceController::class, 'show'])->name('attendance.show');
    Route::get('/attendance/perDate', [AttendanceController::class, 'perDate'])->name('attendance.perDate');
    Route::post('/attendance/perDate', [AttendanceController::class, 'perDate'])->name('attendance.perDate.post');
    Route::get('/attendance_date', [AttendanceController::class, 'show'])->name('attendance_date');
    Route::post('/attendance', [AttendanceController::class, 'attendance'])->name('attendance'); 
    Route::get('/attendance/user', [AttendanceController::class, 'user'])->name('attendance_user');
    Route::post('/attendance/user', [AttendanceController::class, 'user'])->name('attendance_user.post');
    Route::get('/attendance/user/{id}', [AttendanceController::class, 'showAttendance'])->name('attendance.user.show');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
  });

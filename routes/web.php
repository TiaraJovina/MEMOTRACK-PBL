<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});
Route::get('/register', function () {
    return view('register');
});
Route::get('/dashboard', function () {
    return view('dashboard');
});
Route::get('/notes', function () {
    return view('notes');
});
Route::get('/jadwal', function () {
    return view('jadwal');
});
Route::get('/tugas', function () {
    return view('tugas');
});
Route::get('/profile', function () {
    return view('profile');
});
Route::get('/absensi', function () {
    return view('absensi');
});
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::middleware('auth')->group(function () {
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
Route::post('/logout', function () {
    Auth::logout(); // Logout user
    request()->session()->invalidate(); // Invalidate session
    request()->session()->regenerateToken(); // Regenerate CSRF token
    return redirect('/login'); // Redirect ke login
})->name('logout');


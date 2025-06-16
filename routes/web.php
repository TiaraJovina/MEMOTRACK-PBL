<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Auth;

// ======== Public Routes ========

// Halaman awal
Route::view('/', 'welcome')->name('home');

// Login & Register
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

// ======== Protected Routes (auth) ========
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 📒 Notes
    Route::get('/notes', [NoteController::class, 'index'])->name('notes');
    Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');
    Route::delete('/notes/{note}', [NoteController::class, 'destroy'])->name('notes.destroy');

    // 📆 Jadwal, Tugas, Profile
    Route::view('/jadwal', 'jadwal')->name('jadwal');
    Route::view('/tugas', 'tugas')->name('tugas');

    // 👤 Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // 📋 Absensi
    Route::get('/absensi', [AbsensiController::class, 'index']);
    Route::post('/absensi', [AbsensiController::class, 'store'])->name('absensi');
    Route::patch('/absensi/update/{id}', [AbsensiController::class, 'update']);
    Route::delete('/absensi/delete/{title}', [AbsensiController::class, 'delete'])->name('absensi.delete');
    Route::post('/absensi/{id}/mark', [AbsensiController::class, 'markAttendance']);

    // 🚪 Logout
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login');
    })->name('logout');
});
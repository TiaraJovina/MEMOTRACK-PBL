<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\JadwalController;


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
    Route::put('/notes/{note}', [NoteController::class, 'update'])->name('notes.update'); 
    Route::delete('/notes/{note}', [NoteController::class, 'destroy'])->name('notes.destroy');

    // 📆 Jadwal
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
    Route::post('/jadwal', [JadwalController::class, 'store'])->name('jadwal.store');
    Route::put('/jadwal/{jadwal}', [JadwalController::class, 'update'])->name('jadwal.update');
    Route::delete('/jadwal/{jadwal}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');
    Route::resource('jadwal', JadwalController::class);
    Route::delete('/jadwal/{id}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');

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

    Route::view('/tugas', 'tugas')->name('tugas');
});
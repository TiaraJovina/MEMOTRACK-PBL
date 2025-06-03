<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
   public function showRegisterForm()
{
    return view('register'); // Laravel cari file resources/views/auth/register.blade.php
    return redirect()->route('login')->with('success', 'Berhasil daftar. Silakan login.');
}

    public function register(Request $request)
    {
        // Validasi
        $request->validate([
            'username' => 'required|string|max:50',
            'email' => 'required|email|unique:users',
            'role' => 'required|in:dosen,mahasiswa',
            'password' => 'required|min:6',
        ]);

        // Simpan ke database
        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        // Redirect ke login
        return redirect()->route('login')->with('success', 'Berhasil daftar. Silakan login.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard'); // Pastikan kamu punya resources/views/dashboard.blade.php
    }
    public function absensi() {
        
    }
}

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;

Route::apiResource('notes', NoteController::class);

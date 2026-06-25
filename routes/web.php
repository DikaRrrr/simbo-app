<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Jalur Login
Route::get('/login', function () { return view('v_auth.login'); })->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);

// Jalur Register
Route::get('/register', function () { return view('v_auth.register'); })->middleware('guest');
Route::post('/register', [AuthController::class, 'register']);

// Jalur Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/laporan/create', function () {
    return view('v_laporan.create');
})->middleware('auth')->name('laporan.create');
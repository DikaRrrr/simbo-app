<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PetugasController;
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

Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login']);

// Group route untuk Admin agar aman
Route::middleware('auth:admin')->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });
    Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
});

Route::get('/petugas/login', [PetugasController::class, 'showLogin'])->name('petugas.login');
Route::post('/petugas/login', [PetugasController::class, 'login']);

Route::middleware('auth:petugas')->group(function () {
    Route::get('/petugas/dashboard', function () {
        return view('petugas.dashboard');
    });
    Route::post('/petugas/logout', [PetugasController::class, 'logout'])->name('petugas.logout');
});

Route::get('/laporan/create', function () {
    return view('v_laporan.create');
})->middleware('auth')->name('laporan.create');
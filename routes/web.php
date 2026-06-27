<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PetugasController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Jalur Login
Route::get('/login', function () {
    return view('v_auth.login');
})->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);

// Jalur Register
Route::get('/register', function () {
    return view('v_auth.register');
})->middleware('guest');
Route::post('/register', [AuthController::class, 'register']);

// Jalur Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Jalur Lopgin Admin dan Petugas
Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login']);

Route::get('/petugas/login', [PetugasController::class, 'showLogin'])->name('petugas.login');
Route::post('/petugas/login', [PetugasController::class, 'login']);

// Group route untuk Admin agar aman
Route::middleware('auth:admin')->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });
    Route::get('admin/identifikasi', [AdminController::class, 'identifikasiIndex'])->name('identifikasi.index');
    Route::get('/admin/detail-identifikasi', function () {
        return view('admin.v_laporan.detail', ['pageTitle' => 'Detail Laporan']);
    });
    Route::get('/admin/identifikasi/detail/{id}', [AdminController::class, 'detailIdentifikasi'])->name('admin.identifikasi.detail');
    Route::put('/admin/identifikasi/assign/{id}', [AdminController::class, 'assignPetugas'])->name('admin.identifikasi.assign');
    Route::get('/admin/pengguna', [AdminController::class, 'indexPengguna'])->name('admin.pengguna.index');
    Route::get('/admin/pengguna/tambah', function () {
        return view('admin.v_pengguna.create', ['pageTitle' => 'Tambah Pengguna']);
    });
    Route::get('/admin/pengguna/{role}/{id}/edit', [AdminController::class, 'editPengguna'])
        ->name('admin.pengguna.edit');

    Route::put('/admin/pengguna/{role}/{id}', [AdminController::class, 'updatePengguna'])
        ->name('admin.pengguna.update');
    Route::delete('/admin/pengguna/{role}/{id}', [AdminController::class, 'destroyPengguna'])->name('admin.pengguna.destroy');

    // Route untuk memproses form
    Route::post('/admin/pengguna/store', [AdminController::class, 'storePengguna'])->name('admin.pengguna.store');
    Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
});



Route::middleware('auth:petugas')->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', [PetugasController::class, 'dashboard'])->name('dashboard');
    Route::get('/laporan', [PetugasController::class, 'laporanIndex'])->name('laporan.index');

    Route::get('/berita', [PetugasController::class, 'beritaIndex'])->name('berita.index');
    Route::get('/berita/create', [PetugasController::class, 'beritaCreate'])->name('berita.create');
    Route::post('/berita', [PetugasController::class, 'beritaStore'])->name('berita.store');
    Route::get('/berita/{id}/edit', [PetugasController::class, 'beritaEdit'])->name('berita.edit');
    Route::put('/berita/{id}', [PetugasController::class, 'beritaUpdate'])->name('berita.update');
    Route::delete('/berita/{id}', [PetugasController::class, 'beritaDestroy'])->name('berita.destroy');

    Route::post('/logout', [PetugasController::class, 'logout'])->name('logout');
});

Route::get('/laporan/create', function () {
    return view('v_laporan.create');
})->middleware('auth')->name('laporan.create');

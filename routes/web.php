<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminNotifikasiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MasyarakatController;
use App\Http\Controllers\NotifikasiController;
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

Route::middleware('auth')->group(function () {

    Route::get('/laporan', [MasyarakatController::class, 'laporanIndex'])->name('laporan.index');
    Route::post('/laporan/store', [MasyarakatController::class, 'storeLaporan'])->name('laporan.store');
    Route::get('/beranda', [MasyarakatController::class, 'index'])->name('masyarakat.beranda');
    Route::get('/aktivitas', [MasyarakatController::class, 'aktivitasIndex'])->name('aktivitas.index');
    Route::get('/masyarakat/aktivitas/{id}', [MasyarakatController::class, 'aktivitasDetail'])->name('aktivitas.detail');
    Route::get('/berita', [MasyarakatController::class, 'beritaIndex'])->name('berita.index');
    Route::get('/berita/{id}', [MasyarakatController::class, 'beritaShow'])->name('berita.show');
    Route::get('/notifikasi', [MasyarakatController::class, 'notifikasiIndex'])->name('notifikasi.index');
    Route::get('/profile', [MasyarakatController::class, 'profileIndex'])->name('masyarakat.profile');
    Route::put('/profile', [MasyarakatController::class, 'updateProfile'])->name('masyarakat.profile.update');
});

// Group route untuk Admin agar aman
Route::middleware('auth:admin')->group(function () {

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('admin/identifikasi', [AdminController::class, 'identifikasiIndex'])->name('identifikasi.index');
    Route::get('/admin/detail-identifikasi', function () {
        return view('admin.v_laporan.detail', ['pageTitle' => 'Detail Laporan']);
    });
    Route::get('/admin/identifikasi/detail/{id}', [AdminController::class, 'detailIdentifikasi'])->name('admin.identifikasi.detail');
    Route::put('/admin/identifikasi/assign/{id}', [AdminController::class, 'assignPetugas'])->name('admin.identifikasi.assign');
    Route::put('/admin/identifikasi/{id}/reject', [AdminController::class, 'tolakLaporan'])->name('admin.identifikasi.tolak');
    Route::delete('/admin/laporan/{id}', [AdminController::class, 'destroyLaporan'])->name('admin.laporan.destroy');
    Route::get('/admin/pengguna', [AdminController::class, 'indexPengguna'])->name('admin.pengguna.index');
    Route::get('/admin/pengguna/tambah', function () {
        return view('admin.v_pengguna.create', ['pageTitle' => 'Tambah Pengguna']);
    });
    Route::get('/admin/pengguna/{role}/{id}/edit', [AdminController::class, 'editPengguna'])
        ->name('admin.pengguna.edit');

    Route::put('/admin/pengguna/{role}/{id}', [AdminController::class, 'updatePengguna'])
        ->name('admin.pengguna.update');
    Route::delete('/admin/pengguna/{role}/{id}', [AdminController::class, 'destroyPengguna'])->name('admin.pengguna.destroy');

    Route::get('admin/berita', [AdminController::class, 'indexBerita'])->name('admin.berita.index');
    Route::get('/admin/berita/create', [AdminController::class, 'createBerita'])->name('admin.berita.create');
    Route::get('/admin/berita/{id}/edit', [AdminController::class, 'editBerita'])->name('admin.berita.edit');
    Route::post('/admin/berita', [AdminController::class, 'storeBerita'])->name('admin.berita.store');
    Route::put('/admin/berita/{id}', [AdminController::class, 'updateBerita'])->name('admin.berita.update');
    Route::delete('/admin/berita/{id}', [AdminController::class, 'destroyBerita'])->name('admin.berita.destroy');

    // Route untuk memproses form
    Route::post('/admin/pengguna/store', [AdminController::class, 'storePengguna'])->name('admin.pengguna.store');
    Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

    Route::get('/admin/notifikasi', [AdminNotifikasiController::class, 'index'])->name('admin.notifikasi.index');
    Route::get('/admin/notifikasi/create', [AdminNotifikasiController::class, 'create'])->name('admin.notifikasi.create');
    Route::post('/admin/notifikasi', [AdminNotifikasiController::class, 'store'])->name('admin.notifikasi.store');
    Route::delete('/admin/notifikasi/{id}', [AdminNotifikasiController::class, 'destroy'])->name('admin.notifikasi.destroy');

    Route::get('/admin/kategori', [AdminController::class, 'indexKategori'])->name('admin.kategori.index');
    Route::get('/admin/kategori/create', [AdminController::class, 'createKategori'])->name('admin.kategori.create');
    Route::post('/admin/kategori', [AdminController::class, 'storeKategori'])->name('admin.kategori.store');
    Route::get('/admin/kategori/{id}/edit', [AdminController::class, 'editKategori'])->name('admin.kategori.edit');
    Route::put('/admin/kategori/{id}', [AdminController::class, 'updateKategori'])->name('admin.kategori.update');
    Route::delete('/admin/kategori/{id}', [AdminController::class, 'destroyKategori'])->name('admin.kategori.destroy');
});



Route::middleware('auth:petugas')->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', [PetugasController::class, 'dashboard'])->name('dashboard');

    Route::get('/laporan', [PetugasController::class, 'laporanIndex'])->name('laporan.index');
    Route::get('/laporan/{id}/edit', [PetugasController::class, 'laporanEdit'])->name('laporan.edit');
    Route::put('/laporan/{id}', [PetugasController::class, 'laporanUpdate'])->name('laporan.update');

    Route::get('/berita', [PetugasController::class, 'beritaIndex'])->name('berita.index');
    Route::get('/berita/create', [PetugasController::class, 'beritaCreate'])->name('berita.create');
    Route::post('/berita', [PetugasController::class, 'beritaStore'])->name('berita.store');
    Route::get('/berita/{id}/edit', [PetugasController::class, 'beritaEdit'])->name('berita.edit');
    Route::put('/berita/{id}', [PetugasController::class, 'beritaUpdate'])->name('berita.update');
    Route::delete('/berita/{id}', [PetugasController::class, 'beritaDestroy'])->name('berita.destroy');

    Route::post('/logout', [PetugasController::class, 'logout'])->name('logout');
});

Route::controller(NotifikasiController::class)->prefix('notifikasi')->name('notifikasi.')->group(function () {
    Route::get('/', 'index')->name('index');                           // Halaman List Notifikasi
    Route::get('/{id}/baca', 'markAsRead')->name('read');              // Aksi klik 1 notifikasi
    Route::post('/baca-semua', 'markAllAsRead')->name('readAll');      // Aksi tandai semua dibaca
});

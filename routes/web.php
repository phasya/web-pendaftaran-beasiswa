<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PendaftarController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BeasiswaController as AdminBeasiswaController;
use App\Http\Controllers\Admin\PendaftarController as AdminPendaftarController;

// ====================
// HALAMAN UTAMA USER
// ====================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/persyaratan', [HomeController::class, 'persyaratan'])->name('persyaratan');

// ====================
// AUTENTIKASI USER
// ====================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ====================
// PENDAFTARAN BEASISWA USER
// ====================
Route::get('/beasiswa/{beasiswa}/daftar', [PendaftarController::class, 'create'])->name('pendaftar.create');
Route::post('/beasiswa/{beasiswa}/daftar', [PendaftarController::class, 'store'])->name('pendaftar.store');

// ====================
// TEST ERROR 404
// ====================
Route::get('/test-404', function () {
    abort(404);
})->name('test.404');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('beasiswa', \App\Http\Controllers\Admin\BeasiswaController::class);
});


// ====================
// ADMIN (DENGAN MIDDLEWARE)
// ====================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Manajemen Beasiswa oleh Admin
    Route::resource('beasiswa', AdminBeasiswaController::class);

    // Manajemen Pendaftar oleh Admin
    Route::resource('pendaftar', AdminPendaftarController::class)->except(['create', 'store', 'edit', 'update']);

    // Update status pendaftar (Diterima/Ditolak)
    Route::patch('/pendaftar/{pendaftar}/status', [AdminPendaftarController::class, 'updateStatus'])->name('pendaftar.update-status');
});

// ====================
// HAPUS ROUTE BERMASALAH
// ====================
// ❌ Ini yang bikin error, jadi jangan dipakai lagi:
// Route::prefix('admin')->group(function () {
//     Route::resource('beasiswas', BeasiswaController::class); 
// });

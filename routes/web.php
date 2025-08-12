<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PendaftarController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BeasiswaController as AdminBeasiswaController;
use App\Http\Controllers\Admin\PendaftarController as AdminPendaftarController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/persyaratan', [HomeController::class, 'persyaratan'])->name('persyaratan');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Pendaftar Routes
Route::get('/beasiswa/{beasiswa}/daftar', [PendaftarController::class, 'create'])->name('pendaftar.create');
Route::post('/beasiswa/{beasiswa}/daftar', [PendaftarController::class, 'store'])->name('pendaftar.store');

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('beasiswa', AdminBeasiswaController::class);
    Route::resource('pendaftar', AdminPendaftarController::class)->except(['create', 'store', 'edit', 'update']);
    Route::patch('/pendaftar/{pendaftar}/status', [AdminPendaftarController::class, 'updateStatus'])->name('pendaftar.update-status');
    // Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // ... routes admin
    
});
});
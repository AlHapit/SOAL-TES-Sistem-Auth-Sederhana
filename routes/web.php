<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MahasiswaController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::controller(AuthController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->middleware('guest')->name('register');
    Route::post('/register', 'register')->middleware('guest');
    Route::get('/login', 'showLoginForm')->middleware('guest')->name('login');
    Route::post('/login', 'login')->middleware('guest');
    Route::post('/logout', 'logout')->middleware('auth')->name('logout');
});

Route::get('/admin/dashboard', [AdminController::class, 'index'])
    ->middleware(['auth', 'role:admin'])
    ->name('admin.dashboard');

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::post('/users/{role}', [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::patch('/users/{role}/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{role}/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
});

Route::get('/dosen/dashboard', [DosenController::class, 'index'])
    ->middleware(['auth', 'role:dosen'])
    ->name('dosen.dashboard');

Route::get('/mahasiswa/dashboard', [MahasiswaController::class, 'index'])
    ->middleware(['auth', 'role:mahasiswa'])
    ->name('mahasiswa.dashboard');

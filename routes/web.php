<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route Admin (Hanya untuk Admin)
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});

// Route User (Hanya untuk User Biasa)
Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
});

// Route::get('/admin/dashboard', fn () => view('admin.dashboard'))->name('filament.admin.pages.dashboard');
// Route::get('/user/dashboard', fn () => view('user.dashboard'))->name('filament.user.pages.dashboard');

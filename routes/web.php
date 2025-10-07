<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\SambutanController;
use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Frontend\VisiMisiController;

// Halaman depan website sekolah
Route::get('/', [HomeController::class, 'index'])->name('frontend.home');
Route::get('/sambutan', [SambutanController::class, 'index'])->name('frontend.sambutan');
Route::get('/visi-misi', [VisiMisiController::class, 'index'])->name('frontend.visi-misi');

// Halaman login CMS (akses melalui /w1s4t4)
Route::get('/test', function () {
    return 'Routing OK';
});
Route::get('/w1s4t4', [AuthController::class, 'showLoginForm'])->name('backend.login');
Route::post('/w1s4t4', [AuthController::class, 'login'])->name('backend.login.submit');

// CMS / Dashboard
Route::middleware(['auth'])->group(function () {
    Route::get('/w1s4t4/dashboard', [DashboardController::class, 'index'])->name('backend.dashboard');
});


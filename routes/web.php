<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\SambutanController;
use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Frontend\VisiMisiController;
use App\Http\Controllers\Frontend\SarprasController;
use App\Http\Controllers\Frontend\GuruStaffController;
use App\Http\Controllers\Frontend\TKJController;
use App\Http\Controllers\Frontend\PerhotelanController;
use App\Http\Controllers\Frontend\KulinerController;
use App\Http\Controllers\Frontend\KontakController;
use App\Http\Controllers\Frontend\InformasiController;
use App\Http\Controllers\Frontend\DetailInformasiController;

// Halaman depan website sekolah
Route::get('/', [HomeController::class, 'index'])->name('frontend.home');
Route::get('/sambutan', [SambutanController::class, 'index'])->name('frontend.sambutan');
Route::get('/visi-misi', [VisiMisiController::class, 'index'])->name('frontend.visi-misi');
Route::get('/sarpras', [SarprasController::class, 'index'])->name('frontend.sarpras');
Route::get('/gurustaff', [GuruStaffController::class, 'index'])->name('frontend.gurustaff');
Route::get('/kontak', [KontakController::class, 'index'])->name('frontend.kontak');
Route::get('/informasi', [InformasiController::class, 'index'])->name('frontend.informasi');
Route::get('/detail-informasi', [DetailInformasiController::class, 'index'])->name('frontend.detail-informasi');

// Halaman program keahlian
Route::get('/tkj', [TKJController::class, 'index'])->name('frontend.tkj');
Route::get('/perhotelan', [PerhotelanController::class, 'index'])->name('frontend.perhotelan');
Route::get('/kuliner', [KulinerController::class, 'index'])->name('frontend.kuliner');

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


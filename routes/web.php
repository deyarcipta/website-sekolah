<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\SambutanController;
use App\Http\Controllers\Frontend\VisiMisiController;
use App\Http\Controllers\Frontend\SarprasController;
use App\Http\Controllers\Frontend\GuruStaffController;
use App\Http\Controllers\Frontend\TKJController;
use App\Http\Controllers\Frontend\PerhotelanController;
use App\Http\Controllers\Frontend\KulinerController;
use App\Http\Controllers\Frontend\KontakController;
use App\Http\Controllers\Frontend\InformasiController;
use App\Http\Controllers\Frontend\DetailInformasiController;

use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\KeunggulanSekolahController;
use App\Http\Controllers\Backend\SambutanKepsekController;

// ================= FRONTEND ROUTES =================
Route::get('/', [HomeController::class, 'index'])->name('frontend.home');
Route::get('/sambutan', [SambutanController::class, 'index'])->name('frontend.sambutan');
Route::get('/visi-misi', [VisiMisiController::class, 'index'])->name('frontend.visi-misi');
Route::get('/sarpras', [SarprasController::class, 'index'])->name('frontend.sarpras');
Route::get('/gurustaff', [GuruStaffController::class, 'index'])->name('frontend.gurustaff');
Route::get('/kontak', [KontakController::class, 'index'])->name('frontend.kontak');
Route::get('/informasi', [InformasiController::class, 'index'])->name('frontend.informasi');
Route::get('/detail-informasi/{slug}', [DetailInformasiController::class, 'show'])->name('frontend.detail-informasi');

// Halaman program keahlian
Route::get('/tkj', [TKJController::class, 'index'])->name('frontend.tkj');
Route::get('/perhotelan', [PerhotelanController::class, 'index'])->name('frontend.perhotelan');
Route::get('/kuliner', [KulinerController::class, 'index'])->name('frontend.kuliner');

// ================= BACKEND AUTH ROUTES (PUBLIC) =================
// Login page
Route::get('/w1s4t4', [AuthController::class, 'showLoginForm'])->name('backend.login');
Route::get('/w1s4t4/login', [AuthController::class, 'showLoginForm'])->name('backend.login.form');

// Login process (POST)
Route::post('/w1s4t4/login', [AuthController::class, 'login'])->name('backend.login.submit');

// ================= BACKEND PROTECTED ROUTES =================
Route::prefix('w1s4t4')->middleware(['auth', 'role:admin,superadmin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('backend.dashboard');
    
    // Logout (POST method)
    Route::post('/logout', [AuthController::class, 'logout'])->name('backend.logout');
    
    // Settings
    Route::prefix('settings')->name('backend.settings.')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::put('/', [SettingController::class, 'update'])->name('update');
    });

    Route::post('/upload-image', [App\Http\Controllers\Backend\UploadController::class, 'tinymceUpload'])
        ->name('backend.upload.image');

    // Keunggulan Sekolah Routes
    Route::prefix('keunggulan-sekolah')->name('backend.keunggulan-sekolah.')->group(function () {
        Route::get('/', [KeunggulanSekolahController::class, 'index'])->name('index');
        Route::post('/', [KeunggulanSekolahController::class, 'store'])->name('store');
        Route::put('/{id}', [KeunggulanSekolahController::class, 'update'])->name('update');
        Route::delete('/{id}', [KeunggulanSekolahController::class, 'destroy'])->name('destroy');
        Route::post('/update-urutan', [KeunggulanSekolahController::class, 'updateUrutan'])->name('update-urutan');
    });

    // Sambutan Kepala Sekolah
    Route::prefix('sambutan-kepsek')->name('backend.sambutan-kepsek.')->group(function () {
        Route::get('/', [SambutanKepsekController::class, 'index'])->name('index');
        Route::post('/', [SambutanKepsekController::class, 'store'])->name('store');
    });
    
    // Tambahkan route backend lainnya di sini...
});

// ================= TEST ROUTE =================
Route::get('/test-route', function () {
    return 'Test route berhasil!';
});
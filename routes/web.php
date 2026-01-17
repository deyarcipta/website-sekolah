<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\SambutanController;
use App\Http\Controllers\Frontend\VisiMisiController;
use App\Http\Controllers\Frontend\SarprasController;
use App\Http\Controllers\Frontend\GuruStaffController;
use App\Http\Controllers\Frontend\MajorController;
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
use App\Http\Controllers\Backend\VisiMisiBackendController;
use App\Http\Controllers\Backend\SarprasBackendController;
use App\Http\Controllers\Backend\MouPartnerBackendController;
use App\Http\Controllers\Backend\GuruStaffBackendController;
use App\Http\Controllers\Backend\MajorBackendController;
use App\Http\Controllers\Backend\TestimoniAlumniBackendController;

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
Route::prefix('program')->group(function () {
    Route::get('/', [MajorController::class, 'index'])->name('frontend.index');
    Route::get('/{slug}', [MajorController::class, 'show'])->name('frontend.show');
});
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

    // Visi Misi
    Route::prefix('visi-misi')->name('backend.visi-misi.')->group(function () {
        // Main page (index form)
        Route::get('/', [VisiMisiBackendController::class, 'index'])->name('index');
        
        // Store/Update data
        Route::post('/', [VisiMisiBackendController::class, 'store'])->name('store');
        
        // Update data (alternatif)
        Route::post('/update', [VisiMisiBackendController::class, 'update'])->name('update');
        
        // Image Deletion Routes
        Route::delete('/remove-card-image/{cardNumber}', [VisiMisiBackendController::class, 'removeCardImage'])->name('remove-card-image');
        Route::delete('/remove-visi-image', [VisiMisiBackendController::class, 'removeVisiImage'])->name('remove-visi-image');
        Route::delete('/remove-misi-image', [VisiMisiBackendController::class, 'removeMisiImage'])->name('remove-misi-image');
        Route::delete('/remove-hero-background', [VisiMisiBackendController::class, 'removeHeroBackground'])->name('remove-hero-background');
    });

    // Backend Sarpras Routes
    Route::prefix('sarpras')->name('backend.sarpras.')->group(function () {
        Route::get('/', [SarprasBackendController::class, 'index'])->name('index');
        Route::post('/', [SarprasBackendController::class, 'store'])->name('store');
        
        // Tambahan untuk fasilitas dinamis
        Route::post('/add-facilities-item', [SarprasBackendController::class, 'addFacilitiesItem'])->name('add-facilities');
        Route::post('/add-gallery-image', [SarprasBackendController::class, 'addGalleryImage'])->name('add-gallery'); // Nama method diperbaiki
        
        // Route DELETE untuk penghapusan - SESUAIKAN DENGAN METHOD DI CONTROLLER
        Route::delete('/remove-facilities-item/{index}', [SarprasBackendController::class, 'removeFacilities'])->name('remove-facilities'); // Ganti 'removeFacilitiesItem' menjadi 'removeFacilities'
        Route::delete('/remove-hero-image', [SarprasBackendController::class, 'removeHeroImage'])->name('remove-hero');
        Route::delete('/remove-learning-image', [SarprasBackendController::class, 'removeLearningImage'])->name('remove-learning');
        
        // Route untuk gallery - SESUAIKAN DENGAN METHOD DI CONTROLLER
        Route::delete('/remove-gallery-slot/{index}', [SarprasBackendController::class, 'removeGallery'])->name('remove-gallery-slot'); // Ganti 'removeGallerySlot' menjadi 'removeGallery'
        Route::delete('/remove-gallery-image/{index}', [SarprasBackendController::class, 'removeGalleryImage'])->name('remove-gallery-image'); // Ini sudah benar
    });

    // Backend Mitra Kerjasama (MoU) Routes
    Route::prefix('mou-partners')->name('backend.mou-partners.')->group(function () {
        Route::get('/', [MouPartnerBackendController::class, 'index'])->name('index');
        Route::post('/', [MouPartnerBackendController::class, 'store'])->name('store');
        Route::get('/{id}/edit-data', [MouPartnerBackendController::class, 'editData'])->name('edit-data');
        Route::put('/{id}', [MouPartnerBackendController::class, 'update'])->name('update');
        Route::delete('/{id}', [MouPartnerBackendController::class, 'destroy'])->name('destroy');
        Route::post('/update-urutan', [MouPartnerBackendController::class, 'updateUrutan'])->name('update-urutan');
        
    });

    Route::prefix('backend/guru-staff')->name('backend.guru-staff.')->group(function () {
        Route::get('/', [GuruStaffBackendController::class, 'index'])->name('index');
        Route::post('/', [GuruStaffBackendController::class, 'store'])->name('store');
        Route::get('/{id}/edit-data', [GuruStaffBackendController::class, 'editData'])->name('edit-data');
        Route::put('/{id}', [GuruStaffBackendController::class, 'update'])->name('update');
        Route::delete('/{id}', [GuruStaffBackendController::class, 'destroy'])->name('destroy');
        Route::post('/update-urutan', [GuruStaffBackendController::class, 'updateUrutan'])->name('update-urutan');
        Route::get('/settings', [GuruStaffBackendController::class, 'getSettings'])->name('settings');
        Route::post('/update-settings', [GuruStaffBackendController::class, 'updateSettings'])->name('update-settings');
        
        // Tambahkan route untuk deskripsi
        Route::get('/deskripsi', [GuruStaffBackendController::class, 'getDeskripsi'])->name('deskripsi');
        Route::post('/deskripsi', [GuruStaffBackendController::class, 'storeDeskripsi'])->name('store.deskripsi');
    });

    // Backend Routes
    Route::prefix('majors')->name('backend.majors.')->group(function () {
        // Main CRUD
        Route::get('/', [MajorBackendController::class, 'index'])->name('index');
        Route::get('/create', [MajorBackendController::class, 'create'])->name('create');
        Route::post('/', [MajorBackendController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [MajorBackendController::class, 'edit'])->name('edit');
        Route::put('/{id}', [MajorBackendController::class, 'update'])->name('update');
        Route::delete('/{id}', [MajorBackendController::class, 'destroy'])->name('destroy');
        
        // Teachers Management
        Route::get('/{id}/teachers', [MajorBackendController::class, 'manageTeachers'])->name('teachers');
        Route::post('/{id}/teachers', [MajorBackendController::class, 'storeTeacher'])->name('store.teacher');
        Route::put('/teachers/{teacherId}', [MajorBackendController::class, 'updateTeacher'])->name('update.teacher');
        Route::delete('/teachers/{teacherId}', [MajorBackendController::class, 'destroyTeacher'])->name('destroy.teacher');
        Route::post('/{id}/teachers/reorder', [MajorBackendController::class, 'reorderTeachers'])->name('teachers.reorder');
        
        // Achievements Management
        Route::get('/{id}/achievements', [MajorBackendController::class, 'manageAchievements'])->name('achievements');
        Route::post('/{id}/achievements', [MajorBackendController::class, 'storeAchievement'])->name('store.achievement');
        Route::put('/achievements/{achievementId}', [MajorBackendController::class, 'updateAchievement'])->name('update.achievement');
        Route::delete('/achievements/{achievementId}', [MajorBackendController::class, 'destroyAchievement'])->name('destroy.achievement');
        Route::post('/{achievementId}/achievements/reorder', [MajorBackendController::class, 'reorderAchievements'])->name('achievement.reorder');
        
        // Image Deletion Routes
        Route::delete('/{id}/remove-logo', [MajorBackendController::class, 'removeLogo'])->name('remove.logo');
        Route::delete('/{id}/remove-hero-image', [MajorBackendController::class, 'removeHeroImage'])->name('remove.hero');
        Route::delete('/{id}/remove-overview-image', [MajorBackendController::class, 'removeOverviewImage'])->name('remove.overview');
        Route::delete('/{id}/remove-vision-mission-image', [MajorBackendController::class, 'removeVisionMissionImage'])->name('remove.vision-mission');
        Route::delete('/{id}/remove-learning-image', [MajorBackendController::class, 'removeLearningImage'])->name('remove.learning');
    });

    // Backend routes
        Route::prefix('testimoni-alumni')->name('backend.testimoni-alumni.')->group(function () {
            Route::get('/', [TestimoniAlumniBackendController::class, 'index'])->name('index');
            Route::post('/', [TestimoniAlumniBackendController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [TestimoniAlumniBackendController::class, 'edit'])->name('edit');
            Route::put('/{id}', [TestimoniAlumniBackendController::class, 'update'])->name('update');
            Route::delete('/{id}', [TestimoniAlumniBackendController::class, 'destroy'])->name('destroy');
            Route::post('/update-urutan', [TestimoniAlumniBackendController::class, 'updateUrutan'])->name('update-urutan');
        });
    
    // Tambahkan route backend lainnya di sini...
});

// ================= TEST ROUTE =================
Route::get('/test-route', function () {
    return 'Test route berhasil!';
});
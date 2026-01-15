@extends('layouts.backend')

@section('title', 'Sarana & Prasarana - Dashboard Admin')

@section('content')

    <!-- Header Card -->
    <div class="card shadow mb-4 border-0">
        <div class="card-body py-4">
            <div class="d-flex justify-content-between align-items-center page-header">
                <div>
                    <h1 class="h3 text-gray-800 mb-1">
                        <i class="fas fa-building me-2"></i> Kelola Sarana & Prasarana
                    </h1>
                    <p class="text-muted mb-0">Kelola konten halaman Sarana dan Prasarana sekolah</p>
                </div>
                <div>
                    <a href="{{ route('frontend.sarpras') }}" target="_blank" class="btn btn-outline-info">
                        <i class="fas fa-external-link-alt me-1"></i> Lihat di Frontend
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Card with Tabs -->
    <div class="card shadow border-0">
        <!-- Tabs Navigation -->
        <div class="card-header bg-white px-4 pt-0 pb-3 border-bottom">
            <div class="nav-tabs-wrapper">
                <ul class="nav nav-tabs" id="sarprasTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="paragraf-tab" data-bs-toggle="tab" data-bs-target="#paragraf" type="button"
                                title="Paragraf Pembuka">
                            <i class="fas fa-paragraph me-2"></i>
                            <span class="tab-text">Paragraf</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="lingkungan-tab" data-bs-toggle="tab" data-bs-target="#lingkungan" type="button"
                                title="Lingkungan Belajar">
                            <i class="fas fa-school me-2"></i>
                            <span class="tab-text">Lingkungan</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="fasilitas-tab" data-bs-toggle="tab" data-bs-target="#fasilitas" type="button"
                                title="Fasilitas Unggulan">
                            <i class="fas fa-wifi me-2"></i>
                            <span class="tab-text">Fasilitas</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="gallery-tab" data-bs-toggle="tab" data-bs-target="#gallery" type="button"
                                title="Gallery Fasilitas">
                            <i class="fas fa-images me-2"></i>
                            <span class="tab-text">Gallery</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="hero-tab" data-bs-toggle="tab" data-bs-target="#hero" type="button"
                                title="Background Hero">
                            <i class="fas fa-image me-2"></i>
                            <span class="tab-text">Hero</span>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Main Form -->
        <form action="{{ route('backend.sarpras.store') }}" method="POST" id="sarprasForm" enctype="multipart/form-data">
            @csrf
            
            <!-- Tab Content -->
            <div class="card-body bg-light p-3 p-md-4">
                <div class="tab-content" id="sarprasTabContent">
                    <!-- Tab 1: Paragraf Pembuka -->
                    <div class="tab-pane fade show active" id="paragraf" role="tabpanel">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label fw-bold mb-3">
                                        <i class="fas fa-text-height me-2"></i> Teks Paragraf Pembuka <span class="text-danger">*</span>
                                    </label>
                                    <textarea 
                                        class="form-control tinymce-editor" 
                                        name="opening_paragraph" 
                                        id="opening_paragraph"
                                        rows="4"
                                        placeholder="Masukkan paragraf pembuka..."
                                        required
                                    >{{ old('opening_paragraph', $sarpras->opening_paragraph) }}</textarea>
                                    @error('opening_paragraph')
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text mt-2">
                                        <i class="fas fa-info-circle me-1"></i> Paragraf ini akan ditampilkan di bawah judul halaman.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 2: Lingkungan Belajar -->
                    <div class="tab-pane fade" id="lingkungan" role="tabpanel">
                        <div class="row">
                            <!-- Teks -->
                            <div class="col-lg-6 mb-4">
                                <div class="card border h-100">
                                    <div class="card-header bg-info text-white d-flex align-items-center">
                                        <i class="fas fa-school me-2"></i>
                                        <h6 class="mb-0">Konten Teks Lingkungan Belajar</h6>
                                    </div>
                                    <div class="card-body">
                                        <!-- Judul -->
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-heading me-2"></i> Judul Section <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="learning_title" 
                                                   value="{{ old('learning_title', $sarpras->learning_title) }}"
                                                   placeholder="Contoh: Lingkungan Belajar Nyaman & Inspiratif"
                                                   required>
                                            @error('learning_title')
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Deskripsi -->
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-align-left me-2"></i> Deskripsi <span class="text-danger">*</span>
                                            </label>
                                            <textarea class="form-control tinymce-editor" 
                                                    name="learning_description" 
                                                    id="learning_description"
                                                    rows="4"
                                                    placeholder="Masukkan deskripsi lingkungan belajar..."
                                                    required>{{ old('learning_description', $sarpras->learning_description) }}</textarea>
                                            @error('learning_description')
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Deskripsi tentang lingkungan belajar di sekolah</div>
                                        </div>

                                        <!-- List Fitur -->
                                        <div class="form-group">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-list me-2"></i> List Fitur Lingkungan Belajar
                                            </label>
                                            <div id="learning-features-container">
                                                @php
                                                    $learningFeatures = $sarpras->learning_features ?? [
                                                        'Ruang belajar modern, nyaman, ber-AC, dan mendukung pembelajaran kolaboratif.',
                                                        'Infrastruktur digital: Wi-Fi area kampus, proyektor interaktif, dan perpustakaan digital.',
                                                        'Praktik nyata di fasilitas perhotelan dan tata boga bertaraf profesional.'
                                                    ];
                                                @endphp
                                                
                                                @foreach($learningFeatures as $index => $feature)
                                                <div class="input-group mb-2">
                                                    <span class="input-group-text bg-light border">{{ $index + 1 }}</span>
                                                    <input type="text" 
                                                           class="form-control" 
                                                           name="learning_features[]" 
                                                           value="{{ old("learning_features.$index", $feature) }}"
                                                           placeholder="Masukkan fitur lingkungan belajar..."
                                                           required>
                                                    <button type="button" 
                                                            class="btn btn-outline-danger remove-list-item" 
                                                            data-target="learning">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                                @endforeach
                                            </div>
                                            <button type="button" 
                                                    class="btn btn-outline-primary btn-sm mt-2" 
                                                    id="add-learning-feature">
                                                <i class="fas fa-plus me-1"></i> Tambah Fitur Baru
                                            </button>
                                            @error('learning_features')
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Tambahkan fitur-fitur lingkungan belajar yang tersedia</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Gambar -->
                            <div class="col-lg-6 mb-4">
                                <div class="card border h-100">
                                    <div class="card-header bg-secondary text-white d-flex align-items-center">
                                        <i class="fas fa-image me-2"></i>
                                        <h6 class="mb-0">Gambar Lingkungan Belajar</h6>
                                    </div>
                                    <div class="card-body">
                                        <!-- Current Image -->
                                        <div class="mb-4">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-image me-2"></i> Gambar Saat Ini
                                            </label>
                                            <div class="text-center">
                                                <div class="position-relative d-inline-block">
                                                    <img src="{{ $sarpras->getLearningImageUrl() }}" 
                                                         class="img-fluid rounded border shadow" 
                                                         style="max-height: 200px; width: 100%;"
                                                         id="current-learning-image"
                                                         data-original-src="{{ $sarpras->getLearningImageUrl() }}">
                                                    @if($sarpras->learning_image)
                                                    <div class="position-absolute top-0 end-0 mt-2 me-2">
                                                        <button type="button" 
                                                                class="btn btn-sm btn-danger remove-image-btn" 
                                                                data-type="learning">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Upload New Image -->
                                        <div class="form-group">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-upload me-2"></i> Upload Gambar Baru
                                            </label>
                                            <input type="file" 
                                                   class="form-control" 
                                                   name="learning_image" 
                                                   accept="image/*"
                                                   id="learning-image-input">
                                            <small class="text-muted d-block mt-2">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Rekomendasi: Rasio 1:1, min. 600x600px. Format: JPG, PNG, JPEG (Max: 2MB)
                                            </small>
                                            @error('learning_image')
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Preview -->
                                        <div class="mt-4">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-eye me-2"></i> Preview Gambar Baru
                                            </label>
                                            <div id="learning-image-preview" 
                                                 class="image-preview-placeholder">
                                                <i class="fas fa-image fa-3x text-muted mb-3"></i>
                                                <p class="text-muted mb-0">Gambar akan muncul di sini setelah dipilih</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 3: Fasilitas Unggulan -->
                    <div class="tab-pane fade" id="fasilitas" role="tabpanel">
                        <div class="row">
                            <div class="col-12">
                                <div class="card border">
                                    <div class="card-header bg-warning text-white d-flex align-items-center justify-content-between">
                                        <!-- LEFT: ICON + TITLE -->
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fas fa-wifi"></i>
                                            <h6 class="mb-0">Fasilitas Unggulan</h6>
                                        </div>

                                        <!-- RIGHT: BADGE + BUTTON -->
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge bg-light text-dark d-flex align-items-center px-3 py-2">
                                                <i class="fas fa-cube me-1"></i>
                                                <span id="facilities-counter">{{ count($sarpras->getFacilitiesItems()) }}</span> Item
                                            </span>
                                            <button 
                                                type="button" 
                                                class="btn btn-light d-flex align-items-center justify-content-center px-3 py-2"
                                                id="add-facilities-btn"
                                                title="Tambah Fasilitas"
                                                style="height: 38px; width: 38px;"
                                            >
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <!-- Judul Section -->
                                        <div class="form-group mb-4">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-heading me-2"></i> Judul Section Fasilitas <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="facilities_title" 
                                                   value="{{ old('facilities_title', $sarpras->facilities_title) }}"
                                                   placeholder="Contoh: Fasilitas Unggulan"
                                                   required>
                                            @error('facilities_title')
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Fasilitas Items -->
                                        <div class="form-group">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-list me-2"></i> Daftar Fasilitas
                                                <small class="text-muted ms-2">(Semua item yang Anda tambahkan akan ditampilkan)</small>
                                            </label>
                                            <div id="facilities-container">
                                                @php
                                                    $facilitiesItems = $sarpras->getFacilitiesItems();
                                                @endphp
                                                
                                                @foreach($facilitiesItems as $index => $item)
                                                <div class="card mb-3 border facilities-item" data-index="{{ $index }}">
                                                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                                        <h6 class="mb-0">Fasilitas {{ $index + 1 }}</h6>
                                                        @if($index >= 1)
                                                        <button type="button" 
                                                                class="btn btn-sm btn-outline-danger remove-facilities-item-btn"
                                                                data-index="{{ $index }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                        @endif
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group mb-3">
                                                                    <label class="form-label fw-bold">Judul Fasilitas <span class="text-danger">*</span></label>
                                                                    <input type="text" 
                                                                           class="form-control facility-title-input" 
                                                                           name="facility_title[]" 
                                                                           value="{{ old("facility_title.$index", $item['title']) }}"
                                                                           placeholder="Contoh: Ruang Belajar Full AC"
                                                                           data-index="{{ $index }}"
                                                                           required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group mb-3">
                                                                    <label class="form-label fw-bold">Deskripsi <span class="text-danger">*</span></label>
                                                                    <textarea class="form-control facility-desc-input" 
                                                                              name="facility_desc[]" 
                                                                              rows="2"
                                                                              placeholder="Deskripsi fasilitas..."
                                                                              data-index="{{ $index }}"
                                                                              required>{{ old("facility_desc.$index", $item['desc']) }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                            @error('facility_title')
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                            @error('facility_desc')
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">
                                                <i class="fas fa-info-circle me-1"></i> 
                                                Semua fasilitas yang Anda tambahkan akan ditampilkan di frontend.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 4: Gallery -->
                    <div class="tab-pane fade" id="gallery" role="tabpanel">
                        <div class="row">
                            <div class="col-12">
                                <div class="card border">
                                    <div class="card-header bg-success text-white d-flex align-items-center justify-content-between">
                                        <!-- LEFT: ICON + TITLE -->
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fas fa-images"></i>
                                            <h6 class="mb-0">Gallery Fasilitas</h6>
                                        </div>

                                        <!-- RIGHT: BADGE + BUTTON -->
                                        <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-light text-dark d-flex align-items-center justify-content-center px-3"
                                            style="height: 38px;">
                                            <i class="fas fa-image me-1"></i>
                                            <span id="gallery-counter">{{ count($sarpras->getGalleryImages()) }}</span> Gambar
                                        </span>

                                        <button 
                                            type="button"
                                            class="btn btn-light d-flex align-items-center justify-content-center"
                                            id="add-gallery-btn"
                                            title="Tambah Gambar"
                                            style="height: 38px; width: 38px;"
                                        >
                                            <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <!-- Judul Gallery -->
                                        <div class="form-group mb-4">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-heading me-2"></i> Judul Section Gallery <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="gallery_title" 
                                                   value="{{ old('gallery_title', $sarpras->gallery_title) }}"
                                                   placeholder="Contoh: Mengintip Fasilitas Kami"
                                                   required>
                                            @error('gallery_title')
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Gallery Images -->
                                        <div class="form-group">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-camera me-2"></i> Upload Gambar Gallery
                                                <small class="text-muted ms-2">(Semua gambar yang Anda upload akan ditampilkan)</small>
                                            </label>
                                            <div class="row" id="gallery-container">
                                                @php
                                                    $galleryImages = $sarpras->getGalleryImages();
                                                @endphp
                                                
                                                @foreach($galleryImages as $index => $image)
                                                <div class="col-md-4 mb-4 gallery-item" data-index="{{ $index }}">
                                                    <div class="card border h-100">
                                                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                                            <h6 class="mb-0">Gambar {{ $index + 1 }}</h6>
                                                            @if($index >= 1)
                                                            <button type="button" 
                                                                    class="btn btn-sm btn-outline-danger remove-gallery-item-btn"
                                                                    data-index="{{ $index }}">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                            @endif
                                                        </div>
                                                        <div class="card-body text-center">
                                                            <!-- Current Image -->
                                                            <div class="mb-3">
                                                                <div class="position-relative d-inline-block">
                                                                    @php
                                                                        $imageUrl = $image;
                                                                        if (strpos($image, 'assets/') === 0) {
                                                                            $imageUrl = asset($image);
                                                                        } elseif (strpos($image, 'storage/') === 0) {
                                                                            $imageUrl = asset($image);
                                                                        } else {
                                                                            $imageUrl = asset('assets/img/placeholder.jpg');
                                                                        }
                                                                    @endphp
                                                                    <img src="{{ $imageUrl }}" 
                                                                         class="img-fluid rounded border" 
                                                                         style="max-height: 150px; width: 100%; object-fit: cover;"
                                                                         id="current-gallery-image-{{ $index }}"
                                                                         data-original-src="{{ $imageUrl }}">
                                                                    @if(strpos($image, 'storage/') === 0)
                                                                    <div class="position-absolute top-0 end-0 mt-2 me-2">
                                                                        <button type="button" 
                                                                                class="btn btn-sm btn-danger remove-gallery-image" 
                                                                                data-index="{{ $index }}">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            
                                                            <!-- Upload New Image -->
                                                            <div class="form-group">
                                                                <input type="file" 
                                                                       class="form-control gallery-image-input" 
                                                                       name="gallery_images[]" 
                                                                       accept="image/*"
                                                                       id="gallery-image-input-{{ $index }}"
                                                                       data-index="{{ $index }}">
                                                                <small class="text-muted d-block mt-2">
                                                                    <i class="fas fa-ruler-combined me-1"></i>
                                                                    Ukuran: 400x300px (rasio 4:3)
                                                                </small>
                                                            </div>
                                                            
                                                            <!-- Hidden input untuk gambar yang sudah ada -->
                                                            <input type="hidden" 
                                                                   name="existing_gallery_images[]" 
                                                                   value="{{ $image }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                            @error('gallery_images')
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">
                                                <i class="fas fa-info-circle me-1"></i> 
                                                Semua gambar yang Anda upload akan ditampilkan di frontend.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 5: Hero Background -->
                    <div class="tab-pane fade" id="hero" role="tabpanel">
                        <div class="row">
                            <div class="col-lg-6 mb-4">
                                <div class="card border h-100">
                                    <div class="card-header bg-purple text-white d-flex align-items-center">
                                        <i class="fas fa-image me-2"></i>
                                        <h6 class="mb-0">Background Hero Section</h6>
                                    </div>
                                    <div class="card-body">
                                        <!-- Hero Title -->
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-heading me-2"></i> Judul Hero
                                            </label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="hero_title" 
                                                   value="{{ old('hero_title', $sarpras->hero_title) }}"
                                                   placeholder="Contoh: Sarana dan Prasarana">
                                            <div class="form-text">Judul yang ditampilkan di hero section</div>
                                            @error('hero_title')
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Current Image -->
                                        <div class="form-group mb-4">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-image me-2"></i> Background Saat Ini
                                            </label>
                                            <div class="text-center">
                                                <div class="position-relative d-inline-block">
                                                    <img src="{{ $sarpras->getHeroBackgroundUrl() }}" 
                                                         class="img-fluid rounded border shadow" 
                                                         style="max-height: 150px; width: 100%; object-fit: cover;"
                                                         id="current-hero-image"
                                                         data-original-src="{{ $sarpras->getHeroBackgroundUrl() }}">
                                                    @if($sarpras->hero_background)
                                                    <div class="position-absolute top-0 end-0 mt-2 me-2">
                                                        <button type="button" 
                                                                class="btn btn-sm btn-danger remove-image-btn" 
                                                                data-type="hero">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Upload New Image -->
                                        <div class="form-group">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-upload me-2"></i> Upload Background Baru
                                            </label>
                                            <input type="file" 
                                                   class="form-control" 
                                                   name="hero_background" 
                                                   accept="image/*"
                                                   id="hero-image-input">
                                            <small class="text-muted d-block mt-2">
                                                <i class="fas fa-ruler-combined me-1"></i>
                                                Ukuran optimal: 1920x400px. Format: JPG, PNG, JPEG (Max: 5MB)
                                            </small>
                                            @error('hero_background')
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-6 mb-4">
                                <div class="card border h-100">
                                    <div class="card-header bg-info text-white d-flex align-items-center">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <h6 class="mb-0">Panduan & Preview</h6>
                                    </div>
                                    <div class="card-body">
                                        <!-- Panduan -->
                                        <div class="alert alert-light border mb-3">
                                            <h6 class="fw-bold mb-3">
                                                <i class="fas fa-lightbulb me-2"></i> Panduan Hero Section
                                            </h6>
                                            <ul class="mb-0 ps-3">
                                                <li class="mb-2">Gunakan gambar dengan resolusi tinggi</li>
                                                <li class="mb-2">Pastikan gambar tidak terlalu gelap/tua</li>
                                                <li class="mb-2">Ukuran optimal: 1920x400 pixel</li>
                                                <li class="mb-2">Format: JPG, PNG, atau JPEG</li>
                                                <li>Gambar akan diberi overlay ungu transparan</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Save Button in Card Footer -->
            <div class="card-footer bg-white border-top py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted small">
                            <i class="fas fa-exclamation-circle me-2"></i> Pastikan semua data sudah benar sebelum menyimpan
                        </span>
                    </div>
                    <div>
                        <button type="reset" class="btn btn-outline-secondary px-4" id="resetFormBtn">
                            <i class="fas fa-redo me-1"></i> Reset Form
                        </button>
                        <button type="submit" class="btn btn-primary px-4" id="submitBtn">
                            <i class="fas fa-save me-1"></i> Simpan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('styles')
<style>
    .bg-purple {
        background-color: #6b02b1 !important;
    }
    
    .text-purple {
        color: #6b02b1 !important;
    }
    
    /* Nav tabs styling - DEFAULT FOR DESKTOP (CENTERED) */
    .nav-tabs-wrapper {
        position: relative;
        width: 100%;
    }

    .nav-tabs {
        border-bottom: 2px solid #dee2e6;
        display: flex !important;
        flex-wrap: nowrap !important;
        justify-content: center !important; /* PERUBAHAN: center bukan space-between */
        padding-left: 0;
        margin-bottom: 0;
        list-style: none;
        width: 100% !important;
    }

    /* Hide scrollbar on desktop */
    .nav-tabs::-webkit-scrollbar {
        display: none !important;
        width: 0 !important;
        height: 0 !important;
    }

    .nav-tabs {
        scrollbar-width: none !important;
        -ms-overflow-style: none !important;
    }

    .nav-tabs .nav-item {
        flex: 0 0 auto !important; /* PERUBAHAN: tidak stretch, ukuran auto */
        text-align: center;
    }

    .nav-tabs .nav-link {
        color: #495057;
        font-weight: 500;
        border: none;
        border-bottom: 3px solid transparent;
        padding: 12px 24px !important; /* PERUBAHAN: padding lebih besar */
        transition: all 0.3s ease;
        white-space: nowrap;
        text-align: center;
        font-size: 0.9rem !important; /* PERUBAHAN: sedikit lebih besar */
        display: flex !important;
        flex-direction: column !important;
        align-items: center;
        justify-content: center;
        height: 100%;
        background-color: transparent;
        cursor: pointer;
        min-height: 70px;
        min-width: 130px; /* PERUBAHAN: minimum width untuk desktop */
    }

    .nav-tabs .nav-link:hover {
        color: #6b02b1;
        border-bottom-color: rgba(107, 2, 177, 0.3);
        background-color: rgba(107, 2, 177, 0.05);
    }

    .nav-tabs .nav-link.active {
        color: #6b02b1;
        background-color: transparent;
        border-bottom-color: #6b02b1;
        font-weight: 600;
    }

    .nav-tabs .nav-link .tab-text {
        display: block !important;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
        white-space: nowrap;
        font-size: 0.85rem;
    }

    .nav-tabs .nav-link i {
        font-size: 1.3rem; /* PERUBAHAN: sedikit lebih besar */
        margin-bottom: 5px;
    }
    
    /* Image preview placeholder */
    .image-preview-placeholder {
        background: linear-gradient(45deg, #f8f9fa, #e9ecef);
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        padding: 1.5rem;
        text-align: center;
        color: #6c757d;
        transition: all 0.3s ease;
        min-height: 150px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }
    
    .image-preview-placeholder:hover {
        border-color: #6b02b1;
        background: linear-gradient(45deg, #f8f9fa, #f0f4ff);
    }
    
    .image-preview-placeholder img {
        max-height: 150px;
        border-radius: 5px;
    }
    
    .btn-primary {
        background-color: #6b02b1;
        border-color: #6b02b1;
    }
    
    .btn-primary:hover {
        background-color: #5a0296;
        border-color: #5a0296;
    }
    
    .form-control:focus {
        border-color: #6b02b1;
        box-shadow: 0 0 0 0.2rem rgba(107, 2, 177, 0.25);
    }
    
    /* TinyMCE container */
    .tox-tinymce {
        width: 100% !important;
        height: 300px !important;
        border-radius: 8px !important;
        border: 1px solid #ced4da !important;
    }

    /* Facilities & Gallery Controls */
    #facilities-counter, #gallery-counter {
        font-weight: bold;
        font-size: 1rem;
    }

    .facilities-item, .gallery-item {
        transition: all 0.3s ease;
    }

    .facilities-item:hover, .gallery-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .remove-facilities-item-btn, .remove-gallery-item-btn {
        opacity: 0.7;
        transition: all 0.2s ease;
    }

    .remove-facilities-item-btn:hover, .remove-gallery-item-btn:hover {
        opacity: 1;
        transform: scale(1.1);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .nav-tabs-wrapper {
            overflow-x: auto !important;
            overflow-y: hidden;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
            scrollbar-color: #6b02b1 #f8f9fa;
            padding-bottom: 5px;
        }
        
        .nav-tabs-wrapper::-webkit-scrollbar {
            height: 4px;
            display: block !important;
        }
        
        .nav-tabs-wrapper::-webkit-scrollbar-track {
            background: #f8f9fa;
            border-radius: 3px;
        }
        
        .nav-tabs-wrapper::-webkit-scrollbar-thumb {
            background-color: #6b02b1;
            border-radius: 3px;
        }
        
        .nav-tabs {
            justify-content: flex-start !important; /* Mulai dari kiri untuk mobile */
            min-width: min-content; /* Lebar minimal sesuai konten untuk scroll */
        }
        
        .nav-tabs .nav-item {
            flex: 0 0 auto !important; /* Tetap auto untuk mobile */
        }
        
        .nav-tabs .nav-link {
            padding: 10px 15px !important;
            font-size: 0.85rem !important;
            min-width: 110px; /* Lebih kecil untuk mobile */
            min-height: 65px;
        }
        
        .nav-tabs .nav-link i {
            font-size: 1.1rem;
            margin-bottom: 4px;
        }
        
        .nav-tabs .nav-link .tab-text {
            font-size: 0.8rem;
        }

        .tox-tinymce {
            height: 250px !important;
        }

        .page-header {
            flex-direction: column;
            align-items: stretch !important;
            gap: 0.5rem;
        }

        .page-header > div {
            width: 100%;
        }

        .page-header h1 {
            font-size: 1.4rem;
        }

        .page-header p {
            font-size: 0.85rem;
        }

        .page-header a.btn {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .facilities-item, .gallery-item {
            margin-bottom: 1rem;
        }
    }

    @media (max-width: 576px) {    
        .nav-tabs .nav-link {
            padding: 8px 12px !important;
            font-size: 0.8rem !important;
            min-width: 95px;
            min-height: 60px;
        }
        
        .nav-tabs .nav-link i {
            font-size: 1rem;
            margin-bottom: 3px;
        }
        
        .nav-tabs .nav-link .tab-text {
            font-size: 0.75rem;
        }

        .tox-tinymce {
            height: 200px !important;
        }

        .card-footer .d-flex {
            flex-direction: column;
            gap: 10px;
        }

        .card-footer .btn {
            width: 100%;
            margin: 5px 0;
        }

        .page-header h1 {
            font-size: 1.25rem;
        }

        .page-header p {
            font-size: 0.8rem;
        }
    }
</style>
@endpush

@push('scripts')
<script src="{{ asset('assets/js/tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script>
// Fungsi untuk menampilkan loading
function showLoading(title = 'Menyimpan...', text = 'Harap tunggu') {
    Swal.fire({
        title: title,
        text: text,
        allowOutsideClick: false,
        showConfirmButton: false,
        willOpen: () => {
            Swal.showLoading();
        }
    });
}

// Fungsi untuk menutup loading
function closeLoading() {
    Swal.close();
}

// Fungsi untuk menampilkan toast sukses
function showSuccessToast(message, timer = 1500) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: timer,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
    
    Toast.fire({
        icon: 'success',
        title: message
    });
}

// Fungsi untuk menampilkan toast error
function showErrorToast(message, timer = 3000) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: timer,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
    
    Toast.fire({
        icon: 'error',
        title: message
    });
}

// Fungsi konfirmasi
function confirmAction(title, text, confirmText = 'Ya', cancelText = 'Batal') {
    return Swal.fire({
        title: title,
        text: text,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#6b02b1',
        cancelButtonColor: '#6c757d',
        confirmButtonText: confirmText,
        cancelButtonText: cancelText,
        reverseButtons: true,
        customClass: {
            popup: 'border-radius-12'
        }
    });
}

// Inisialisasi TinyMCE
function initTinyMCE() {
    tinymce.init({
        selector: '.tinymce-editor',
        height: 300,
        menubar: true,
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'table', 'help', 'wordcount'
        ],
        toolbar: 'undo redo | blocks | ' +
            'bold italic underline | forecolor backcolor | ' +
            'alignleft aligncenter alignright alignjustify | ' +
            'bullist numlist | ' +
            'removeformat | help',
        
        language: 'id',
        language_url: '{{ asset("assets/js/tinymce/langs/id.js") }}',
        
        content_style: `
            body { 
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif; 
                font-size: 14px; 
                line-height: 1.6; 
                color: #212529;
                margin: 8px;
            }
            h1, h2, h3, h4, h5, h6 {
                margin-top: 1rem;
                margin-bottom: 0.5rem;
                font-weight: 600;
                line-height: 1.2;
            }
            p { 
                margin-bottom: 1rem;
                text-align: justify;
            }
            ul, ol {
                margin-bottom: 1rem;
                padding-left: 2rem;
            }
            blockquote {
                margin: 0 0 1rem;
                padding: 0.5rem 1rem;
                border-left: 4px solid #007bff;
                background-color: #f8f9fa;
                font-style: italic;
            }
        `,
        
        setup: function (editor) {
            editor.on('change', function () {
                editor.save();
            });
        },
        
        promotion: false,
        branding: false,
        resize: true,
        min_height: 300,
        statusbar: true
    });
}

// Image Preview Handler
const ImageHandler = {
    preview(input, previewId, currentImageId = null) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = (e) => {
                const preview = document.getElementById(previewId);
                if (preview) {
                    preview.innerHTML = `
                        <img src="${e.target.result}" class="img-fluid rounded shadow" style="max-height: 150px;">
                        <p class="text-success small mt-2">
                            <i class="fas fa-check-circle me-1"></i> Gambar siap diupload
                        </p>
                    `;
                }
                
                if (currentImageId) {
                    const currentImg = document.getElementById(currentImageId);
                    if (currentImg) {
                        currentImg.src = e.target.result;
                    }
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    },
    
    setupPreview(inputId, previewId, currentImageId = null) {
        const input = document.getElementById(inputId);
        if (input) {
            input.addEventListener('change', () => {
                this.preview(input, previewId, currentImageId);
            });
        }
    }
};

// List Item Manager
const ListItemManager = {
    addItem(containerId, placeholder = 'Masukkan fitur...') {
        const container = document.getElementById(containerId);
        const index = container.children.length;
        
        const div = document.createElement('div');
        div.className = 'input-group mb-2';
        div.innerHTML = `
            <span class="input-group-text bg-light border">${index + 1}</span>
            <input type="text" class="form-control" name="learning_features[]" 
                   placeholder="${placeholder}" required>
            <button type="button" class="btn btn-outline-danger remove-list-item">
                <i class="fas fa-trash"></i>
            </button>
        `;
        container.appendChild(div);
    },
    
    removeItem(button) {
        const inputGroup = button.closest('.input-group');
        const container = button.closest('[id$="-features-container"]');
        
        if (container.children.length > 1) {
            inputGroup.remove();
            this.renumberItems(container);
            return true;
        }
        return false;
    },
    
    renumberItems(container) {
        const items = container.querySelectorAll('.input-group');
        items.forEach((item, index) => {
            item.querySelector('.input-group-text').textContent = index + 1;
        });
    }
};

// Form Validator
const FormValidator = {
    validate(form) {
        let isValid = true;
        let firstInvalidField = null;
        
        // Validate required text fields
        const requiredFields = form.querySelectorAll('[required]:not([type="file"])');
        requiredFields.forEach(field => {
            let value = field.value.trim();
            
            // Check if it's a TinyMCE editor
            if (field.classList.contains('tinymce-editor')) {
                const editor = tinymce.get(field.id);
                if (editor) {
                    value = editor.getContent().trim();
                }
            }
            
            if (!value) {
                isValid = false;
                field.classList.add('is-invalid');
                
                if (!firstInvalidField) {
                    firstInvalidField = field;
                }
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        // Validate file sizes
        const fileInputs = form.querySelectorAll('input[type="file"]');
        fileInputs.forEach(input => {
            if (input.files.length > 0) {
                const file = input.files[0];
                const maxSize = input.name.includes('hero') ? 5 * 1024 * 1024 : 2 * 1024 * 1024; // 5MB for hero, 2MB for others
                
                if (file.size > maxSize) {
                    isValid = false;
                    input.classList.add('is-invalid');
                    showErrorToast(`File ${file.name} terlalu besar! Maksimal ${maxSize / (1024 * 1024)}MB`);
                    
                    if (!firstInvalidField) {
                        firstInvalidField = input;
                    }
                }
            }
        });
        
        // Scroll to first invalid field
        if (firstInvalidField) {
            firstInvalidField.scrollIntoView({ 
                behavior: 'smooth', 
                block: 'center' 
            });
            
            if (firstInvalidField.classList.contains('tinymce-editor')) {
                const editor = tinymce.get(firstInvalidField.id);
                if (editor) editor.focus();
            } else {
                firstInvalidField.focus();
            }
        }
        
        return isValid;
    },
    
    clearValidation(form) {
        const invalidFields = form.querySelectorAll('.is-invalid');
        invalidFields.forEach(field => field.classList.remove('is-invalid'));
    }
};

// File Removal Handler dengan AJAX
const FileRemovalHandler = {
    async remove(type, index = null) {
        let url, message;
        
        if (type === 'hero') {
            url = `/w1s4t4/sarpras/remove-hero-image`;
            message = `Apakah Anda yakin ingin menghapus gambar hero?`;
        } else if (type === 'learning') {
            url = `/w1s4t4/sarpras/remove-learning-image`;
            message = `Apakah Anda yakin ingin menghapus gambar lingkungan belajar?`;
        } else if (type === 'gallery' && index !== null) {
            url = `/w1s4t4/sarpras/remove-gallery-image/${index}`;
            message = `Apakah Anda yakin ingin mereset gambar ${parseInt(index) + 1} ke default?`;
        }
        
        const result = await confirmAction(
            'Hapus Gambar',
            message,
            'Ya, Hapus!'
        );
        
        if (result.isConfirmed) {
            showLoading('Menghapus gambar...', 'Harap tunggu');
            
            try {
                const response = await fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });
                
                const data = await response.json();
                closeLoading();
                
                if (data.success) {
                    showSuccessToast('Gambar berhasil dihapus!');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showErrorToast(data.message || 'Gagal menghapus gambar');
                }
            } catch (error) {
                closeLoading();
                showErrorToast('Terjadi kesalahan saat menghapus gambar');
            }
        }
    }
};

// AJAX Handler untuk Add/Remove Items
const AjaxHandler = {
    async addItem(type) {
        let url, message;
        
        if (type === 'facilities') {
            url = `/w1s4t4/sarpras/add-facilities-item`;
            message = 'Apakah Anda yakin ingin menambahkan fasilitas baru?';
        } else if (type === 'gallery') {
            url = '/w1s4t4/sarpras/add-gallery-image';
            message = 'Apakah Anda yakin ingin menambahkan slot gambar baru?';
        }
        
        const result = await confirmAction('Tambah Item', message, 'Ya, Tambah!');
        
        if (!result.isConfirmed) return;
        
        showLoading('Menambahkan...', 'Harap tunggu');
        
        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            });
            
            const data = await response.json();
            closeLoading();
            
            if (data.success) {
                showSuccessToast('Item berhasil ditambahkan!');
                setTimeout(() => location.reload(), 800);
            } else {
                showErrorToast(data.message || 'Gagal menambahkan item');
            }
        } catch (error) {
            closeLoading();
            showErrorToast('Terjadi kesalahan saat menambahkan item');
        }
    },
    
    async removeItem(type, index) {
        let url, message;
        
        if (type === 'facilities') {
            url = `/w1s4t4/sarpras/remove-facilities-item/${index}`;
            message = `Apakah Anda yakin ingin menghapus fasilitas ${parseInt(index) + 1}?`;
        } else if (type === 'gallery-slot') {
            url = `/w1s4t4/sarpras/remove-gallery-slot/${index}`;
            message = `Apakah Anda yakin ingin menghapus slot gambar ${parseInt(index) + 1}?`;
        }
        
        const result = await confirmAction('Hapus Item', message, 'Ya, Hapus!');
        
        if (!result.isConfirmed) return;
        
        showLoading('Menghapus...', 'Harap tunggu');
        
        try {
            const response = await fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            });
            
            const data = await response.json();
            closeLoading();
            
            if (data.success) {
                showSuccessToast('Item berhasil dihapus!');
                setTimeout(() => location.reload(), 800);
            } else {
                showErrorToast(data.message || 'Gagal menghapus item');
            }
        } catch (error) {
            closeLoading();
            showErrorToast('Terjadi kesalahan saat menghapus item');
        }
    }
};

// Gallery Preview Handler
const GalleryPreviewHandler = {
    setup() {
        document.querySelectorAll('.gallery-image-input').forEach(input => {
            input.addEventListener('change', function() {
                const index = this.dataset.index;
                const file = this.files[0];
                
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const img = document.getElementById(`current-gallery-image-${index}`);
                        if (img) img.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    }
};

// Main Application
document.addEventListener('DOMContentLoaded', () => {
    // Debug info
    console.log('CSRF Token:', '{{ csrf_token() }}');
    console.log('Base URL:', '{{ url("/") }}');
    console.log('Form action URL:', document.getElementById('sarprasForm')?.action);
    
    // Initialize TinyMCE
    setTimeout(() => {
        initTinyMCE();
    }, 300);
    
    // Setup image previews
    ImageHandler.setupPreview('learning-image-input', 'learning-image-preview', 'current-learning-image');
    
    // Setup gallery previews
    GalleryPreviewHandler.setup();
    
    // Setup hero image preview
    const heroInput = document.getElementById('hero-image-input');
    if (heroInput) {
        heroInput.addEventListener('change', (e) => {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = (event) => {
                    const currentImg = document.getElementById('current-hero-image');
                    if (currentImg) {
                        currentImg.src = event.target.result;
                    }
                };
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    }
    
    // Add learning feature button
    document.getElementById('add-learning-feature')?.addEventListener('click', () => {
        ListItemManager.addItem('learning-features-container', 'Masukkan fitur lingkungan belajar...');
        showSuccessToast('Fitur baru ditambahkan', 1000);
    });
    
    // Add facilities button
    document.getElementById('add-facilities-btn')?.addEventListener('click', () => {
        AjaxHandler.addItem('facilities');
    });
    
    // Add gallery button
    document.getElementById('add-gallery-btn')?.addEventListener('click', () => {
        AjaxHandler.addItem('gallery');
    });
    
    // Event delegation for remove buttons
    document.addEventListener('click', async (e) => {
        // Remove learning features
        if (e.target.closest('.remove-list-item')) {
            const button = e.target.closest('.remove-list-item');
            
            if (ListItemManager.removeItem(button)) {
                showSuccessToast('Fitur dihapus', 1000);
            } else {
                showErrorToast('Minimal harus ada satu fitur!');
            }
        }
        
        // Remove facilities items
        if (e.target.closest('.remove-facilities-item-btn')) {
            const button = e.target.closest('.remove-facilities-item-btn');
            const index = button.dataset.index;
            await AjaxHandler.removeItem('facilities', index);
        }
        
        // Remove gallery slots (tombol di card header)
        if (e.target.closest('.remove-gallery-item-btn')) {
            const button = e.target.closest('.remove-gallery-item-btn');
            const index = button.dataset.index;
            await AjaxHandler.removeItem('gallery-slot', index);
        }
        
        // Remove gallery images (tombol di atas gambar)
        if (e.target.closest('.remove-gallery-image')) {
            const button = e.target.closest('.remove-gallery-image');
            const index = button.dataset.index;
            await FileRemovalHandler.remove('gallery', index);
        }
        
        // Remove images (hero, learning)
        if (e.target.closest('.remove-image-btn')) {
            const button = e.target.closest('.remove-image-btn');
            const type = button.dataset.type;
            await FileRemovalHandler.remove(type);
        }
    });
    
    // Form submission dengan AJAX
    document.getElementById('sarprasForm')?.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const form = e.target;
        
        // Debug form action
        console.log('Submitting form to:', form.action);
        
        // Clear previous validation
        FormValidator.clearValidation(form);
        
        // Validate form
        if (!FormValidator.validate(form)) {
            showErrorToast('Form tidak lengkap! Harap lengkapi semua field yang wajib diisi.');
            return;
        }
        
        // Confirm submission
        const result = await confirmAction(
            'Simpan Perubahan',
            'Apakah Anda yakin ingin menyimpan semua perubahan?',
            'Ya, Simpan!'
        );
        
        if (!result.isConfirmed) return;
        
        // Show loading
        showLoading('Menyimpan...', 'Harap tunggu sebentar');
        
        try {
            // Save TinyMCE content
            if (typeof tinymce !== 'undefined') {
                tinymce.triggerSave();
            }
            
            const formData = new FormData(form);
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            });
            
            const data = await response.json();
            closeLoading();
            
            if (response.ok && data.success) {
                // Success message
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message || 'Data berhasil disimpan',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    location.reload();
                });
            } else {
                // Show error
                showErrorToast(data.message || 'Gagal menyimpan data');
                
                // Display validation errors if any
                if (data.errors) {
                    Object.keys(data.errors).forEach(field => {
                        const input = form.querySelector(`[name="${field}"]`);
                        if (input) {
                            input.classList.add('is-invalid');
                        }
                    });
                }
            }
        } catch (error) {
            closeLoading();
            console.error('Error:', error);
            showErrorToast('Terjadi kesalahan saat menyimpan data');
        }
    });
    
    // Reset form button
    document.getElementById('resetFormBtn')?.addEventListener('click', async (e) => {
        e.preventDefault();
        
        const result = await confirmAction(
            'Reset Form',
            'Apakah Anda yakin ingin mereset form? Semua perubahan yang belum disimpan akan hilang.',
            'Ya, Reset!'
        );
        
        if (!result.isConfirmed) return;
        
        const form = document.getElementById('sarprasForm');
        if (!form) return;
        
        form.reset();
        FormValidator.clearValidation(form);
        
        // Reset TinyMCE editors
        if (typeof tinymce !== 'undefined') {
            tinymce.get().forEach(editor => {
                if (editor) {
                    editor.setContent('');
                }
            });
        }
        
        // Reset image previews
        ['learning-image-preview'].forEach(previewId => {
            const preview = document.getElementById(previewId);
            if (preview) {
                preview.innerHTML = `
                    <i class="fas fa-image fa-3x text-muted mb-3"></i>
                    <p class="text-muted mb-0">Gambar akan muncul di sini setelah dipilih</p>
                `;
            }
        });
        
        // Reset current images to original
        ['current-learning-image', 'current-hero-image'].forEach(imgId => {
            const img = document.getElementById(imgId);
            if (img && img.dataset.originalSrc) {
                img.src = img.dataset.originalSrc;
            }
        });
        
        // Reset gallery images to original
        document.querySelectorAll('[id^="current-gallery-image-"]').forEach(img => {
            if (img && img.dataset.originalSrc) {
                img.src = img.dataset.originalSrc;
            }
        });
        
        // Reset file inputs
        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.value = '';
        });
        
        showSuccessToast('Form berhasil direset');
    });
    
    // Store original image sources
    document.querySelectorAll('#current-learning-image, #current-hero-image').forEach(img => {
        if (img) {
            img.dataset.originalSrc = img.src;
        }
    });
    
    // Store original gallery image sources
    document.querySelectorAll('[id^="current-gallery-image-"]').forEach(img => {
        if (img) {
            img.dataset.originalSrc = img.src;
        }
    });
});

// Tampilkan SweetAlert dari session jika ada
@if(session('success'))
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 1500
        });
    });
@endif

@if(session('error'))
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ session('error') }}',
            showConfirmButton: true
        });
    });
@endif

@if($errors->any())
    document.addEventListener('DOMContentLoaded', () => {
        showErrorToast('Mohon periksa kembali form Anda');
    });
@endif
</script>
@endpush
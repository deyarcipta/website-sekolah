@extends('layouts.backend')

@section('title', 'Kontak - Dashboard Admin')

@section('content')
    <!-- Header Card -->
    <div class="card shadow mb-4 border-0">
        <div class="card-body py-4">
            <div class="d-flex justify-content-between align-items-center page-header">
                <div>
                    <h1 class="h3 text-gray-800 mb-1">
                        <i class="fas fa-address-book me-2"></i> Kelola Kontak
                    </h1>
                    <p class="text-muted mb-0">Kelola konten halaman Kontak sekolah</p>
                </div>
                <div>
                    <a href="{{ route('frontend.kontak') }}" target="_blank" class="btn btn-outline-info">
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
                <ul class="nav nav-tabs justify-content-center" id="kontakTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button"
                                title="Informasi Kontak">
                            <i class="fas fa-info-circle me-2"></i>
                            <span class="tab-text">Info Kontak</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="staff-tab" data-bs-toggle="tab" data-bs-target="#staff" type="button"
                                title="Staff Contacts">
                            <i class="fas fa-users me-2"></i>
                            <span class="tab-text">Staff</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="sosial-tab" data-bs-toggle="tab" data-bs-target="#sosial" type="button"
                                title="Sosial Media">
                            <i class="fas fa-share-alt me-2"></i>
                            <span class="tab-text">Sosial Media</span>
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
        <form action="{{ route('backend.kontak.store') }}" method="POST" id="kontakForm" enctype="multipart/form-data">
            @csrf
            
            <!-- Tab Content -->
            <div class="card-body bg-light p-3 p-md-4">
                <div class="tab-content" id="kontakTabContent">
                    <!-- Tab 1: Informasi Kontak -->
                    <div class="tab-pane fade show active" id="info" role="tabpanel">
                        <div class="row">
                            <!-- Opening Paragraph -->
                            <div class="col-12 mb-4">
                                <div class="card border h-100">
                                    <div class="card-header bg-primary text-white d-flex align-items-center">
                                        <i class="fas fa-paragraph me-2"></i>
                                        <h6 class="mb-0">Paragraf Pembuka</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label class="form-label fw-bold mb-3">
                                                <i class="fas fa-text-height me-2"></i> Teks Paragraf Pembuka <span class="text-danger">*</span>
                                            </label>
                                            <textarea 
                                                class="form-control tinymce-editor" 
                                                name="opening_paragraph" 
                                                id="opening_paragraph"
                                                rows="6"
                                                placeholder="Masukkan paragraf pembuka..."
                                                required
                                            >{{ old('opening_paragraph', $kontak->opening_paragraph) }}</textarea>
                                            @error('opening_paragraph')
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text mt-2">
                                                <i class="fas fa-info-circle me-1"></i> Paragraf ini akan ditampilkan di bawah judul halaman. Gunakan editor untuk memformat teks.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Information -->
                            <div class="col-lg-6 mb-4">
                                <div class="card border h-100">
                                    <div class="card-header bg-success text-white d-flex align-items-center">
                                        <i class="fas fa-map-marker-alt me-2"></i>
                                        <h6 class="mb-0">Informasi Kontak</h6>
                                    </div>
                                    <div class="card-body">
                                        <!-- Address -->
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-home me-2"></i> Alamat <span class="text-danger">*</span>
                                            </label>
                                            <textarea 
                                                class="form-control" 
                                                name="address" 
                                                rows="3"
                                                placeholder="Masukkan alamat lengkap..."
                                                required
                                            >{{ old('address', $kontak->address) }}</textarea>
                                            @error('address')
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Phone -->
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-phone me-2"></i> Telepon <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="phone" 
                                                   value="{{ old('phone', $kontak->phone) }}"
                                                   placeholder="Contoh: (021) 78830761"
                                                   required>
                                            @error('phone')
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Email -->
                                        <div class="form-group">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-envelope me-2"></i> Email <span class="text-danger">*</span>
                                            </label>
                                            <input type="email" 
                                                   class="form-control" 
                                                   name="email" 
                                                   value="{{ old('email', $kontak->email) }}"
                                                   placeholder="Contoh: smkwisataindonesia01@gmail.com"
                                                   required>
                                            @error('email')
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Map & Image -->
                            <div class="col-lg-6 mb-4">
                                <div class="card border h-100">
                                    <div class="card-header bg-info text-white d-flex align-items-center">
                                        <i class="fas fa-map me-2"></i>
                                        <h6 class="mb-0">Map & Gambar</h6>
                                    </div>
                                    <div class="card-body">
                                        <!-- Map Embed URL -->
                                        <div class="form-group mb-4">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-map-pin me-2"></i> Google Maps Embed URL <span class="text-danger">*</span>
                                            </label>
                                            <input type="url" 
                                                   class="form-control" 
                                                   name="map_embed_url" 
                                                   value="{{ old('map_embed_url', $kontak->map_embed_url) }}"
                                                   placeholder="Masukkan URL embed Google Maps"
                                                   required>
                                            @error('map_embed_url')
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text mt-2">
                                                <i class="fas fa-info-circle me-1"></i> Dapatkan dari Google Maps → Share → Embed a map
                                            </div>
                                        </div>

                                        <!-- Contact Image -->
                                        <div class="form-group">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-image me-2"></i> Gambar Kontak
                                            </label>
                                            
                                            <!-- Current Image -->
                                            <div class="mb-4">
                                                <div class="text-center">
                                                    <div class="position-relative d-inline-block">
                                                        <img src="{{ $kontak->contact_image_url }}" 
                                                             class="img-fluid rounded border shadow" 
                                                             style="max-height: 200px; width: 100%;"
                                                             id="current-contact-image"
                                                             data-original-src="{{ $kontak->contact_image_url }}">
                                                        @if($kontak->contact_image)
                                                        <div class="position-absolute top-0 end-0 mt-2 me-2">
                                                            <button type="button" 
                                                                    class="btn btn-sm btn-danger remove-image-btn" 
                                                                    data-type="contact">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Upload New Image -->
                                            <input type="file" 
                                                   class="form-control" 
                                                   name="contact_image" 
                                                   accept="image/*"
                                                   id="contact-image-input">
                                            <small class="text-muted d-block mt-2">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Ukuran optimal: 300x500px. Format: JPG, PNG, JPEG (Max: 2MB)
                                            </small>
                                            @error('contact_image')
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 2: Staff Contacts -->
                    <div class="tab-pane fade" id="staff" role="tabpanel">
                        <div class="row">
                            <!-- Staff 1 -->
                            <div class="col-lg-6 mb-4">
                                <div class="card border h-100">
                                    <div class="card-header bg-warning text-white d-flex align-items-center">
                                        <i class="fas fa-user-tie me-2"></i>
                                        <h6 class="mb-0">Staff Contact 1</h6>
                                    </div>
                                    <div class="card-body">
                                        <!-- Name -->
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold">Nama <span class="text-danger">*</span></label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="staff1_name" 
                                                   value="{{ old('staff1_name', $kontak->staff1_name) }}"
                                                   placeholder="Contoh: Dewi Lestari, S.Pd."
                                                   required>
                                            @error('staff1_name')
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Position -->
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold">Jabatan <span class="text-danger">*</span></label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="staff1_position" 
                                                   value="{{ old('staff1_position', $kontak->staff1_position) }}"
                                                   placeholder="Contoh: Wakil Bid. Kesiswaan & Pembina Osis"
                                                   required>
                                            @error('staff1_position')
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Phone -->
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold">Telepon <span class="text-danger">*</span></label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="staff1_phone" 
                                                   value="{{ old('staff1_phone', $kontak->staff1_phone) }}"
                                                   placeholder="Contoh: +62 852-1815-0720"
                                                   required>
                                            @error('staff1_phone')
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Email -->
                                        <div class="form-group mb-4">
                                            <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                                            <input type="email" 
                                                   class="form-control" 
                                                   name="staff1_email" 
                                                   value="{{ old('staff1_email', $kontak->staff1_email) }}"
                                                   placeholder="Contoh: smkwisataindonesia01@gmail.com"
                                                   required>
                                            @error('staff1_email')
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Staff Image -->
                                        <div class="form-group">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-image me-2"></i> Foto Staff
                                            </label>
                                            
                                            <!-- Current Image -->
                                            <div class="mb-4">
                                                <div class="text-center">
                                                    <div class="position-relative d-inline-block">
                                                        <img src="{{ $kontak->staff1_image_url }}" 
                                                             class="img-fluid rounded border shadow" 
                                                             style="max-height: 200px; width: 100%;"
                                                             id="current-staff1-image"
                                                             data-original-src="{{ $kontak->staff1_image_url }}">
                                                        @if($kontak->staff1_image)
                                                        <div class="position-absolute top-0 end-0 mt-2 me-2">
                                                            <button type="button" 
                                                                    class="btn btn-sm btn-danger remove-staff-image" 
                                                                    data-staff="1">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Upload New Image -->
                                            <input type="file" 
                                                   class="form-control" 
                                                   name="staff1_image" 
                                                   accept="image/*"
                                                   id="staff1-image-input">
                                            <small class="text-muted d-block mt-2">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Ukuran optimal: 350x400px. Format: JPG, PNG, JPEG (Max: 2MB)
                                            </small>
                                            @error('staff1_image')
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Staff 2 -->
                            <div class="col-lg-6 mb-4">
                                <div class="card border h-100">
                                    <div class="card-header bg-warning text-white d-flex align-items-center">
                                        <i class="fas fa-user-tie me-2"></i>
                                        <h6 class="mb-0">Staff Contact 2</h6>
                                    </div>
                                    <div class="card-body">
                                        <!-- Name -->
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold">Nama <span class="text-danger">*</span></label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="staff2_name" 
                                                   value="{{ old('staff2_name', $kontak->staff2_name) }}"
                                                   placeholder="Contoh: Dewi Lestari, S.Pd."
                                                   required>
                                            @error('staff2_name')
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Position -->
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold">Jabatan <span class="text-danger">*</span></label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="staff2_position" 
                                                   value="{{ old('staff2_position', $kontak->staff2_position) }}"
                                                   placeholder="Contoh: Wakil Bid. Kesiswaan & Pembina Osis"
                                                   required>
                                            @error('staff2_position')
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Phone -->
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold">Telepon <span class="text-danger">*</span></label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="staff2_phone" 
                                                   value="{{ old('staff2_phone', $kontak->staff2_phone) }}"
                                                   placeholder="Contoh: +62 852-1815-0720"
                                                   required>
                                            @error('staff2_phone')
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Email -->
                                        <div class="form-group mb-4">
                                            <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                                            <input type="email" 
                                                   class="form-control" 
                                                   name="staff2_email" 
                                                   value="{{ old('staff2_email', $kontak->staff2_email) }}"
                                                   placeholder="Contoh: smkwisataindonesia01@gmail.com"
                                                   required>
                                            @error('staff2_email')
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Staff Image -->
                                        <div class="form-group">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-image me-2"></i> Foto Staff
                                            </label>
                                            
                                            <!-- Current Image -->
                                            <div class="mb-4">
                                                <div class="text-center">
                                                    <div class="position-relative d-inline-block">
                                                        <img src="{{ $kontak->staff2_image_url }}" 
                                                             class="img-fluid rounded border shadow" 
                                                             style="max-height: 200px; width: 100%;"
                                                             id="current-staff2-image"
                                                             data-original-src="{{ $kontak->staff2_image_url }}">
                                                        @if($kontak->staff2_image)
                                                        <div class="position-absolute top-0 end-0 mt-2 me-2">
                                                            <button type="button" 
                                                                    class="btn btn-sm btn-danger remove-staff-image" 
                                                                    data-staff="2">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Upload New Image -->
                                            <input type="file" 
                                                   class="form-control" 
                                                   name="staff2_image" 
                                                   accept="image/*"
                                                   id="staff2-image-input">
                                            <small class="text-muted d-block mt-2">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Ukuran optimal: 350x400px. Format: JPG, PNG, JPEG (Max: 2MB)
                                            </small>
                                            @error('staff2_image')
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 3: Sosial Media -->
                    <div class="tab-pane fade" id="sosial" role="tabpanel">
                        <div class="row">
                            <div class="col-lg-6 mb-4">
                                <div class="card border h-100">
                                    <div class="card-header bg-info text-white d-flex align-items-center">
                                        <i class="fab fa-facebook-f me-2"></i>
                                        <h6 class="mb-0">Facebook</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label class="form-label fw-bold">URL Facebook</label>
                                            <input type="url" 
                                                   class="form-control" 
                                                   name="facebook_url" 
                                                   value="{{ old('facebook_url', $kontak->facebook_url) }}"
                                                   placeholder="Contoh: https://facebook.com/smkwi">
                                            @error('facebook_url')
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text mt-2">
                                                <i class="fas fa-link me-1"></i> Kosongkan jika tidak ingin ditampilkan
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-4">
                                <div class="card border h-100">
                                    <div class="card-header bg-danger text-white d-flex align-items-center">
                                        <i class="fab fa-instagram me-2"></i>
                                        <h6 class="mb-0">Instagram</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label class="form-label fw-bold">URL Instagram</label>
                                            <input type="url" 
                                                   class="form-control" 
                                                   name="instagram_url" 
                                                   value="{{ old('instagram_url', $kontak->instagram_url) }}"
                                                   placeholder="Contoh: https://instagram.com/smkwi">
                                            @error('instagram_url')
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text mt-2">
                                                <i class="fas fa-link me-1"></i> Kosongkan jika tidak ingin ditampilkan
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-4">
                                <div class="card border h-100">
                                    <div class="card-header bg-danger text-white d-flex align-items-center">
                                        <i class="fab fa-youtube me-2"></i>
                                        <h6 class="mb-0">YouTube</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label class="form-label fw-bold">URL YouTube</label>
                                            <input type="url" 
                                                   class="form-control" 
                                                   name="youtube_url" 
                                                   value="{{ old('youtube_url', $kontak->youtube_url) }}"
                                                   placeholder="Contoh: https://youtube.com/@smkwi">
                                            @error('youtube_url')
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text mt-2">
                                                <i class="fas fa-link me-1"></i> Kosongkan jika tidak ingin ditampilkan
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-4">
                                <div class="card border h-100">
                                    <div class="card-header bg-secondary text-white d-flex align-items-center">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <h6 class="mb-0">Informasi Sosial Media</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="alert alert-light border">
                                            <h6 class="fw-bold mb-3">
                                                <i class="fas fa-lightbulb me-2"></i> Panduan Sosial Media
                                            </h6>
                                            <ul class="mb-0 ps-3">
                                                <li class="mb-2">Masukkan URL lengkap dengan https://</li>
                                                <li class="mb-2">Pastikan URL valid dan dapat diakses</li>
                                                <li class="mb-2">Ikon akan ditampilkan di bagian bawah halaman</li>
                                                <li>Kosongkan jika tidak ingin menampilkan ikon tertentu</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 4: Hero Background -->
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
                                                   value="{{ old('hero_title', $kontak->hero_title) }}"
                                                   placeholder="Contoh: Kontak">
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
                                                    <img src="{{ $kontak->hero_background_url }}" 
                                                         class="img-fluid rounded border shadow" 
                                                         style="max-height: 200px; width: 100%;"
                                                         id="current-hero-image"
                                                         data-original-src="{{ $kontak->hero_background_url }}">
                                                    @if($kontak->hero_background)
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
                                                <i class="fas fa-info-circle me-1"></i>
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
    
    /* ================= TABS NAVIGATION STYLE ================= */
    .nav-tabs-wrapper {
        overflow-x: auto;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
    }
    
    .nav-tabs {
        flex-wrap: nowrap;
    }
    
    .nav-tabs .nav-link {
        min-width: 140px;
        text-align: center;
        border-radius: 0;
        border-bottom: 3px solid transparent;
        padding: 12px 8px !important;
        transition: all 0.3s ease;
    }
    
    .nav-tabs .nav-link.active {
        border-bottom-color: #6b02b1;
        font-weight: 600;
        color: #6b02b1;
    }
    
    .nav-tabs .nav-link:hover {
        border-bottom-color: rgba(107, 2, 177, 0.3);
    }
    
    .nav-tabs .nav-link .tab-text {
        font-size: 0.85rem;
    }
    
    .nav-tabs .nav-link i {
        font-size: 1.2rem;
        margin-bottom: 5px;
    }
    /* ================= END TABS NAVIGATION STYLE ================= */
    
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
    
    /* Fix for TinyMCE container */
    .tox-tinymce {
        width: 100% !important;
        height: 300px !important;
        border-radius: 8px !important;
        border: 1px solid #ced4da !important;
        max-width: 100% !important;
        min-width: 100% !important;
    }

    /* ===== HEADER PAGE RESPONSIVE ===== */
    .page-header {
        gap: 0.75rem;
    }

    /* Desktop default (≥768px) */
    .page-header h1 {
        font-size: 1.75rem;
    }

    .page-header p {
        font-size: 0.9rem;
    }
    
    /* ================= RESPONSIVE ADJUSTMENTS ================= */
    /* Tablet & Mobile */
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
            justify-content: flex-start !important;
            min-width: min-content;
        }
        
        .nav-tabs .nav-item {
            flex: 0 0 auto !important;
        }
        
        .nav-tabs .nav-link {
            padding: 10px 15px !important;
            font-size: 0.85rem !important;
            min-width: 110px;
            min-height: 65px;
        }
        
        .nav-tabs .nav-link i {
            font-size: 1.1rem;
            margin-bottom: 4px;
        }
        
        .nav-tabs .nav-link .tab-text {
            font-size: 0.8rem;
        }

        /* TinyMCE */
        .tox-tinymce {
            height: 250px !important;
        }

        /* Page header */
        .page-header {
            flex-direction: column;
            align-items: stretch !important;
            justify-content: flex-start !important;
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
    }

    /* Mobile kecil */
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

        /* Footer button stack */
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
    if (typeof tinymce === 'undefined') {
        console.error('TinyMCE tidak ditemukan!');
        return;
    }
    
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
        statusbar: true,
        
        // Setup untuk form submission
        init_instance_callback: function (editor) {
            editor.on('keyup change', function () {
                editor.save();
            });
        }
    });
}

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
                const maxSize = input.name.includes('hero') ? 5 * 1024 * 1024 : 2 * 1024 * 1024;
                
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
        
        // Validate URLs
        const urlFields = form.querySelectorAll('input[type="url"]');
        urlFields.forEach(field => {
            if (field.value && !this.isValidUrl(field.value)) {
                isValid = false;
                field.classList.add('is-invalid');
                showErrorToast(`URL ${field.name} tidak valid!`);
                
                if (!firstInvalidField) {
                    firstInvalidField = field;
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
    
    isValidUrl(string) {
        try {
            new URL(string);
            return true;
        } catch (_) {
            return false;
        }
    },
    
    clearValidation(form) {
        const invalidFields = form.querySelectorAll('.is-invalid');
        invalidFields.forEach(field => field.classList.remove('is-invalid'));
    }
};

// File Removal Handler dengan AJAX
const FileRemovalHandler = {
    async remove(type, staffNumber = null) {
        let url, message;
        
        if (staffNumber) {
            url = `{{ route('backend.kontak.remove-staff-image', '') }}/${staffNumber}`;
            message = `Apakah Anda yakin ingin menghapus gambar staff ${staffNumber}?`;
        } else if (type === 'hero') {
            url = `{{ route('backend.kontak.remove-hero-background') }}`;
            message = `Apakah Anda yakin ingin menghapus background hero?`;
        } else if (type === 'contact') {
            url = `{{ route('backend.kontak.remove-contact-image') }}`;
            message = `Apakah Anda yakin ingin menghapus gambar kontak?`;
        } else {
            showErrorToast('Tipe gambar tidak dikenali');
            return;
        }
        
        const result = await confirmAction(
            'Hapus Gambar',
            message,
            'Ya, Hapus!'
        );
        
        if (!result.isConfirmed) return;
        
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
                showSuccessToast(data.message || 'Gambar berhasil dihapus!');
                setTimeout(() => location.reload(), 1500);
            } else {
                showErrorToast(data.message || 'Gagal menghapus gambar');
            }
        } catch (error) {
            closeLoading();
            showErrorToast('Terjadi kesalahan saat menghapus gambar');
        }
    }
};

// Main Application
document.addEventListener('DOMContentLoaded', () => {
    console.log('Kontak Admin Page Loaded');
    
    // Initialize TinyMCE
    setTimeout(() => {
        try {
            initTinyMCE();
        } catch (error) {
            console.error('Gagal menginisialisasi TinyMCE:', error);
        }
    }, 500);
    
    // Setup image previews for file inputs
    ['hero-image-input', 'contact-image-input', 'staff1-image-input', 'staff2-image-input'].forEach(inputId => {
        const input = document.getElementById(inputId);
        if (input) {
            input.addEventListener('change', (e) => {
                if (e.target.files && e.target.files[0]) {
                    const reader = new FileReader();
                    reader.onload = (event) => {
                        const currentImgId = 'current-' + inputId.replace('-input', '');
                        const currentImg = document.getElementById(currentImgId);
                        if (currentImg) {
                            currentImg.src = event.target.result;
                        }
                    };
                    reader.readAsDataURL(e.target.files[0]);
                }
            });
        }
    });
    
    // Form submission dengan AJAX
    const form = document.getElementById('kontakForm');
    if (form) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            console.log('Form submission started');
            
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
                
                // Create FormData
                const formData = new FormData(form);
                
                // Tambahkan CSRF token secara manual
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                if (csrfToken) {
                    formData.append('_token', csrfToken);
                }
                
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken || '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });
                
                const responseText = await response.text();
                let data;
                
                try {
                    data = JSON.parse(responseText);
                } catch (jsonError) {
                    console.log('Response bukan JSON:', responseText);
                    // Jika bukan JSON, anggap sukses dan redirect
                    closeLoading();
                    window.location.href = '{{ route("backend.kontak.index") }}';
                    return;
                }
                
                closeLoading();
                
                if (response.ok) {
                    if (data.success || data.message) {
                        // Success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message || 'Data kontak berhasil disimpan',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            location.reload();
                        });
                    } else if (data.errors) {
                        // Show validation errors
                        showErrorToast('Validasi gagal! Silakan periksa form Anda.');
                        Object.keys(data.errors).forEach(field => {
                            const input = form.querySelector(`[name="${field}"]`);
                            if (input) {
                                input.classList.add('is-invalid');
                            }
                        });
                    } else {
                        // Default success
                        showSuccessToast('Data berhasil disimpan!');
                        setTimeout(() => location.reload(), 1500);
                    }
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
                console.error('Form submission error:', error);
                closeLoading();
                showErrorToast('Terjadi kesalahan saat menyimpan data: ' + error.message);
            }
        });
    }
    
    // Reset form button
    document.getElementById('resetFormBtn')?.addEventListener('click', async (e) => {
        e.preventDefault();
        
        const result = await confirmAction(
            'Reset Form',
            'Apakah Anda yakin ingin mereset form? Semua perubahan yang belum disimpan akan hilang.',
            'Ya, Reset!'
        );
        
        if (!result.isConfirmed) return;
        
        const form = document.getElementById('kontakForm');
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
        
        // Reset images to original
        ['current-hero-image', 'current-contact-image', 'current-staff1-image', 'current-staff2-image'].forEach(imgId => {
            const img = document.getElementById(imgId);
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
    ['current-hero-image', 'current-contact-image', 'current-staff1-image', 'current-staff2-image'].forEach(imgId => {
        const img = document.getElementById(imgId);
        if (img) {
            img.dataset.originalSrc = img.src;
        }
    });
    
    // Event delegation for remove buttons
    document.addEventListener('click', async (e) => {
        // Remove hero/contact images
        if (e.target.closest('.remove-image-btn')) {
            const button = e.target.closest('.remove-image-btn');
            const type = button.dataset.type;
            if (type) {
                FileRemovalHandler.remove(type);
            }
        }
        
        // Remove staff images
        if (e.target.closest('.remove-staff-image')) {
            const button = e.target.closest('.remove-staff-image');
            const staffNumber = button.dataset.staff;
            if (staffNumber) {
                FileRemovalHandler.remove(null, staffNumber);
            }
        }
    });
});

// Tampilkan SweetAlert dari session jika ada
@if(session('success'))
    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000
            });
        }, 500);
    });
@endif

@if(session('error'))
    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ session('error') }}',
                confirmButtonText: 'OK'
            });
        }, 500);
    });
@endif

@if($errors->any())
    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
            showErrorToast('Mohon periksa kembali form Anda');
        }, 500);
    });
@endif
</script>
@endpush
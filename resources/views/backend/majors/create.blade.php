@extends('layouts.backend')

@section('title', 'Tambah Jurusan Baru - Dashboard Admin')

@section('content')
    <!-- Header Card -->
    <div class="card shadow mb-4 border-0">
        <div class="card-body py-4">
            <div class="d-flex justify-content-between align-items-center page-header">
                <div>
                    <h1 class="h3 text-gray-800 mb-1">
                        <i class="fas fa-plus-circle me-2"></i> Tambah Jurusan Baru
                    </h1>
                    <p class="text-muted mb-0">Buat kompetensi keahlian baru untuk SMK Wisata Indonesia Jakarta</p>
                </div>
                <div>
                    <a href="{{ route('backend.majors.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Form Card -->
    <div class="card shadow border-0">
        <div class="card-body">
            <!-- Progress Steps -->
            <div class="row mb-5">
                <div class="col-12">
                    <div class="steps">
                        <div class="step active">
                            <div class="step-number">1</div>
                            <div class="step-label">Informasi Dasar</div>
                        </div>
                        <div class="step-line active"></div>
                        <div class="step">
                            <div class="step-number">2</div>
                            <div class="step-label">Detail Lengkap</div>
                        </div>
                        <div class="step-line"></div>
                        <div class="step">
                            <div class="step-number">3</div>
                            <div class="step-label">Pengajar & Prestasi</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Form -->
            <form action="{{ route('backend.majors.store') }}" method="POST" id="createMajorForm" enctype="multipart/form-data">
                @csrf
                
                <!-- Step 1: Basic Information -->
                <div class="step-content active" id="step1">
                    <div class="row">
                        <div class="col-lg-8 mb-4">
                            <div class="card border">
                                <div class="card-header bg-primary text-white d-flex align-items-center">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <h6 class="mb-0">Informasi Dasar Jurusan</h6>
                                </div>
                                <div class="card-body">
                                    <!-- Nama Jurusan -->
                                    <div class="form-group mb-4">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-graduation-cap me-2"></i> Nama Jurusan <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" 
                                               class="form-control @error('name') is-invalid @enderror" 
                                               name="name" 
                                               value="{{ old('name') }}"
                                               placeholder="Contoh: Teknik Komputer dan Jaringan"
                                               required
                                               autofocus>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Nama lengkap jurusan/kompetensi keahlian</div>
                                    </div>

                                    <!-- Singkatan -->
                                    <div class="form-group mb-4">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-ab me-2"></i> Singkatan/Nama Pendek
                                        </label>
                                        <input type="text" 
                                               class="form-control @error('short_name') is-invalid @enderror" 
                                               name="short_name" 
                                               value="{{ old('short_name') }}"
                                               placeholder="Contoh: TKJ">
                                        @error('short_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Digunakan untuk tampilan yang membutuhkan ruang terbatas</div>
                                    </div>

                                    <!-- Deskripsi Singkat -->
                                    <div class="form-group mb-4">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-align-left me-2"></i> Deskripsi Singkat <span class="text-danger">*</span>
                                        </label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                                  name="description" 
                                                  rows="4"
                                                  placeholder="Deskripsi singkat tentang jurusan ini..."
                                                  required>{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Ditampilkan di card jurusan di halaman depan (maksimal 200 karakter)</div>
                                        <div class="char-count small text-muted text-end mt-1">
                                            <span id="charCount">0</span>/200 karakter
                                        </div>
                                    </div>

                                    <!-- Status dan Urutan -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">
                                                    <i class="fas fa-toggle-on me-2"></i> Status
                                                </label>
                                                <select class="form-select @error('is_active') is-invalid @enderror" name="is_active">
                                                    <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Aktif</option>
                                                    <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Nonaktif</option>
                                                </select>
                                                @error('is_active')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <div class="form-text">Nonaktif sementara jika jurusan belum siap ditampilkan</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">
                                                    <i class="fas fa-sort-numeric-down me-2"></i> Urutan
                                                </label>
                                                <input type="number" 
                                                       class="form-control @error('order') is-invalid @enderror" 
                                                       name="order" 
                                                       value="{{ old('order', 0) }}"
                                                       min="0"
                                                       placeholder="0">
                                                @error('order')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <div class="form-text">Semakin kecil angka, semakin awal ditampilkan</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 mb-4">
                            <div class="card border h-100">
                                <div class="card-header bg-info text-white d-flex align-items-center">
                                    <i class="fas fa-image me-2"></i>
                                    <h6 class="mb-0">Logo & Gambar</h6>
                                </div>
                                <div class="card-body">
                                    <!-- Logo Jurusan -->
                                    <div class="form-group mb-4">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-image me-2"></i> Logo Jurusan
                                        </label>
                                        
                                        <!-- Logo Preview -->
                                        <div class="logo-preview mb-3 text-center">
                                            <div class="preview-container mx-auto">
                                                <img src="{{ asset('assets/img/default-logo.png') }}" 
                                                     class="img-fluid rounded border shadow preview-image" 
                                                     id="logoPreview"
                                                     style="max-height: 150px; width: auto; object-fit: contain;">
                                            </div>
                                        </div>
                                        
                                        <!-- Upload Logo -->
                                        <div class="file-upload-wrapper mb-2">
                                            <input type="file" 
                                                   class="form-control file-upload @error('logo') is-invalid @enderror" 
                                                   name="logo" 
                                                   accept="image/*"
                                                   id="logoInput"
                                                   data-preview="logoPreview">
                                            @error('logo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <small class="text-muted d-block">
                                            <i class="fas fa-ruler-combined me-1"></i>
                                            Rekomendasi: 200x200px, format PNG dengan background transparan
                                        </small>
                                        <small class="text-muted">
                                            <i class="fas fa-file me-1"></i>
                                            Maksimal: 2MB
                                        </small>
                                    </div>

                                    <hr class="my-4">

                                    <!-- Contoh Jurusan yang Sudah Ada -->
                                    <div class="form-group">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-lightbulb me-2"></i> Contoh Jurusan
                                        </label>
                                        <div class="list-group">
                                            <div class="list-group-item border-0 p-2">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-3">
                                                        <i class="fas fa-utensils text-primary"></i>
                                                    </div>
                                                    <div>
                                                        <small class="fw-bold d-block">Kuliner</small>
                                                        <small class="text-muted">Mempelajari seni dan teknik memasak...</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="list-group-item border-0 p-2">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-3">
                                                        <i class="fas fa-hotel text-success"></i>
                                                    </div>
                                                    <div>
                                                        <small class="fw-bold d-block">Perhotelan</small>
                                                        <small class="text-muted">Pelayanan dan pengelolaan hotel...</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="list-group-item border-0 p-2">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-3">
                                                        <i class="fas fa-network-wired text-warning"></i>
                                                    </div>
                                                    <div>
                                                        <small class="fw-bold d-block">TKJ/TJKT</small>
                                                        <small class="text-muted">Jaringan komputer dan telekomunikasi...</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <!-- Empty for alignment -->
                                </div>
                                <div>
                                    <button type="button" class="btn btn-primary px-5" id="nextToStep2">
                                        Selanjutnya <i class="fas fa-arrow-right ms-2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Advanced Information (Hidden by default) -->
                <div class="step-content" id="step2">
                    <div class="row">
                        <div class="col-lg-6 mb-4">
                            <div class="card border">
                                <div class="card-header bg-success text-white d-flex align-items-center">
                                    <i class="fas fa-book-open me-2"></i>
                                    <h6 class="mb-0">Detail Tambahan</h6>
                                </div>
                                <div class="card-body">
                                    <!-- Hero Section -->
                                    <div class="mb-4">
                                        <h6 class="fw-bold border-bottom pb-2 mb-3">
                                            <i class="fas fa-image me-2"></i> Hero Section
                                        </h6>
                                        
                                        <!-- Hero Title -->
                                        <div class="form-group mb-3">
                                            <label class="form-label">Judul Hero</label>
                                            <input type="text" 
                                                   class="form-control @error('hero_title') is-invalid @enderror" 
                                                   name="hero_title" 
                                                   value="{{ old('hero_title') }}"
                                                   placeholder="Contoh: Teknik Komputer dan Jaringan">
                                            @error('hero_title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Judul yang ditampilkan di halaman detail jurusan</div>
                                        </div>

                                        <!-- Hero Subtitle -->
                                        <div class="form-group mb-3">
                                            <label class="form-label">Subtitle Hero</label>
                                            <textarea class="form-control @error('hero_subtitle') is-invalid @enderror" 
                                                      name="hero_subtitle" 
                                                      rows="2"
                                                      placeholder="Deskripsi singkat untuk hero section...">{{ old('hero_subtitle') }}</textarea>
                                            @error('hero_subtitle')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Hero Image -->
                                        <div class="form-group">
                                            <label class="form-label">Gambar Background Hero</label>
                                            <div class="hero-preview mb-3 text-center">
                                                <div class="preview-container mx-auto w-100">
                                                    <img src="{{ asset('assets/img/default-hero.jpg') }}" 
                                                         class="img-fluid rounded border shadow preview-image w-100" 
                                                         id="heroPreview"
                                                         style="max-height: 150px; object-fit: cover;">
                                                </div>
                                            </div>
                                            <input type="file" 
                                                   class="form-control file-upload @error('hero_image') is-invalid @enderror" 
                                                   name="hero_image" 
                                                   accept="image/*"
                                                   id="heroInput"
                                                   data-preview="heroPreview">
                                            @error('hero_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted d-block mt-2">
                                                <i class="fas fa-ruler-combined me-1"></i>
                                                Ukuran optimal: 1920x400px. Format: JPG, PNG, JPEG (Max: 5MB)
                                            </small>
                                        </div>
                                    </div>

                                    <hr class="my-4">

                                    <!-- Visi & Misi -->
                                    <div class="mb-4">
                                        <h6 class="fw-bold border-bottom pb-2 mb-3">
                                            <i class="fas fa-bullseye me-2"></i> Visi & Misi
                                        </h6>
                                        
                                        <!-- Visi -->
                                        <div class="form-group mb-3">
                                            <label class="form-label">Visi Jurusan</label>
                                            <textarea class="form-control @error('vision') is-invalid @enderror" 
                                                      name="vision" 
                                                      rows="3"
                                                      placeholder="Masukkan visi jurusan...">{{ old('vision') }}</textarea>
                                            @error('vision')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Misi -->
                                        <div class="form-group">
                                            <label class="form-label">Misi Jurusan</label>
                                            <textarea class="form-control @error('mission') is-invalid @enderror" 
                                                      name="mission" 
                                                      rows="3"
                                                      placeholder="Masukkan misi jurusan...">{{ old('mission') }}</textarea>
                                            @error('mission')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-4">
                            <div class="card border h-100">
                                <div class="card-header bg-warning text-white d-flex align-items-center">
                                    <i class="fas fa-graduation-cap me-2"></i>
                                    <h6 class="mb-0">Konten Lainnya</h6>
                                </div>
                                <div class="card-body">
                                    <!-- Overview -->
                                    <div class="mb-4">
                                        <h6 class="fw-bold border-bottom pb-2 mb-3">
                                            <i class="fas fa-info-circle me-2"></i> Overview
                                        </h6>
                                        
                                        <div class="form-group mb-3">
                                            <label class="form-label">Judul Overview</label>
                                            <input type="text" 
                                                   class="form-control @error('overview_title') is-invalid @enderror" 
                                                   name="overview_title" 
                                                   value="{{ old('overview_title') }}"
                                                   placeholder="Contoh: Teknik Jaringan Komputer & Telekomunikasi">
                                            @error('overview_title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">Konten Overview</label>
                                            <textarea class="form-control @error('overview_content') is-invalid @enderror" 
                                                      name="overview_content" 
                                                      rows="5"
                                                      placeholder="Masukkan deskripsi lengkap tentang jurusan...">{{ old('overview_content') }}</textarea>
                                            @error('overview_content')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <hr class="my-4">

                                    <!-- Accordion Items -->
                                    <div class="mb-4">
                                        <h6 class="fw-bold border-bottom pb-2 mb-3">
                                            <i class="fas fa-list-alt me-2"></i> Accordion (Homepage)
                                        </h6>
                                        
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle me-2"></i>
                                            <small>Item accordion bisa ditambahkan nanti di halaman edit jurusan. Untuk sekarang, fokus pada informasi dasar terlebih dahulu.</small>
                                        </div>
                                    </div>

                                    <!-- Quick Actions -->
                                    <div class="mt-4">
                                        <h6 class="fw-bold border-bottom pb-2 mb-3">
                                            <i class="fas fa-bolt me-2"></i> Opsi Cepat
                                        </h6>
                                        
                                        <div class="form-check form-switch mb-2">
                                            <input class="form-check-input" type="checkbox" id="useTemplate">
                                            <label class="form-check-label" for="useTemplate">
                                                Gunakan template jurusan umum
                                            </label>
                                        </div>
                                        
                                        <div class="form-check form-switch mb-2">
                                            <input class="form-check-input" type="checkbox" id="copyFromExisting">
                                            <label class="form-check-label" for="copyFromExisting">
                                                Salin struktur dari jurusan lain
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <button type="button" class="btn btn-outline-secondary px-4" id="backToStep1">
                                        <i class="fas fa-arrow-left me-2"></i> Kembali
                                    </button>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-success px-5">
                                        <i class="fas fa-save me-2"></i> Buat Jurusan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
<style>
    /* Step Progress Bar */
    .steps {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 2rem;
    }

    .step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 2;
    }

    .step-number {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #e9ecef;
        color: #6c757d;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-bottom: 8px;
        border: 3px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .step.active .step-number {
        background-color: #6b02b1;
        color: white;
        border-color: #6b02b1;
    }

    .step-label {
        font-size: 0.875rem;
        color: #6c757d;
        font-weight: 500;
        text-align: center;
        white-space: nowrap;
    }

    .step.active .step-label {
        color: #6b02b1;
        font-weight: 600;
    }

    .step-line {
        flex: 1;
        height: 3px;
        background-color: #e9ecef;
        margin: 0 20px;
        position: relative;
        top: -20px;
    }

    .step-line.active {
        background-color: #6b02b1;
    }

    /* Step Content */
    .step-content {
        display: none;
        animation: fadeIn 0.5s ease;
    }

    .step-content.active {
        display: block;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* File Upload & Preview */
    .file-upload-wrapper {
        position: relative;
    }

    .file-upload {
        padding: 0.5rem;
        border: 2px dashed #dee2e6;
        background-color: #f8f9fa;
        transition: all 0.3s ease;
    }

    .file-upload:hover {
        border-color: #6b02b1;
        background-color: #f0f4ff;
    }

    .file-upload:focus {
        border-color: #6b02b1;
        box-shadow: 0 0 0 0.2rem rgba(107, 2, 177, 0.25);
    }

    .preview-container {
        width: 200px;
        height: 150px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border-radius: 8px;
    }

    .preview-image {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    /* Character Count */
    .char-count {
        font-size: 0.75rem;
    }

    /* Form Validation */
    .is-invalid {
        border-color: #dc3545;
        padding-right: calc(1.5em + 0.75rem);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }

    .is-invalid:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }

    .invalid-feedback {
        display: block;
        font-size: 0.875rem;
        color: #dc3545;
    }

    /* Quick Actions */
    .form-check-input:checked {
        background-color: #6b02b1;
        border-color: #6b02b1;
    }

    .form-check-input:focus {
        border-color: #6b02b1;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(107, 2, 177, 0.25);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .steps {
            flex-direction: column;
            align-items: flex-start;
        }

        .step-line {
            display: none;
        }

        .step {
            flex-direction: row;
            margin-bottom: 1rem;
            width: 100%;
        }

        .step-number {
            margin-bottom: 0;
            margin-right: 12px;
            width: 36px;
            height: 36px;
        }

        .step-label {
            text-align: left;
        }

        .preview-container {
            width: 150px;
            height: 120px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const step1 = document.getElementById('step1');
    const step2 = document.getElementById('step2');
    const nextBtn = document.getElementById('nextToStep2');
    const backBtn = document.getElementById('backToStep1');
    const form = document.getElementById('createMajorForm');
    const descriptionTextarea = document.querySelector('textarea[name="description"]');
    const charCount = document.getElementById('charCount');
    
    // Character counter for description
    if (descriptionTextarea && charCount) {
        // Update count on load
        charCount.textContent = descriptionTextarea.value.length;
        
        // Update count on input
        descriptionTextarea.addEventListener('input', function() {
            charCount.textContent = this.value.length;
            
            // Optional: Add warning if approaching limit
            if (this.value.length > 180) {
                charCount.classList.add('text-warning');
            } else {
                charCount.classList.remove('text-warning');
            }
            
            if (this.value.length > 200) {
                charCount.classList.remove('text-warning');
                charCount.classList.add('text-danger');
            }
        });
    }
    
    // Step Navigation
    if (nextBtn) {
        nextBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Validate step 1
            const nameInput = document.querySelector('input[name="name"]');
            const descriptionInput = document.querySelector('textarea[name="description"]');
            let isValid = true;
            
            // Reset previous errors
            document.querySelectorAll('.is-invalid').forEach(el => {
                el.classList.remove('is-invalid');
            });
            
            // Validate name
            if (!nameInput.value.trim()) {
                nameInput.classList.add('is-invalid');
                nameInput.focus();
                isValid = false;
                
                // Create error message if not exists
                if (!nameInput.nextElementSibling || !nameInput.nextElementSibling.classList.contains('invalid-feedback')) {
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'invalid-feedback';
                    errorDiv.textContent = 'Nama jurusan wajib diisi';
                    nameInput.parentNode.insertBefore(errorDiv, nameInput.nextSibling);
                }
            }
            
            // Validate description
            if (!descriptionInput.value.trim()) {
                descriptionInput.classList.add('is-invalid');
                if (isValid) descriptionInput.focus();
                isValid = false;
                
                if (!descriptionInput.nextElementSibling || !descriptionInput.nextElementSibling.classList.contains('invalid-feedback')) {
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'invalid-feedback';
                    errorDiv.textContent = 'Deskripsi jurusan wajib diisi';
                    descriptionInput.parentNode.insertBefore(errorDiv, descriptionInput.nextSibling);
                }
            }
            
            if (isValid) {
                // Move to step 2
                step1.classList.remove('active');
                step2.classList.add('active');
                
                // Update progress steps
                document.querySelectorAll('.step')[1].classList.add('active');
                document.querySelectorAll('.step-line')[0].classList.add('active');
                
                // Scroll to top of form
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });
    }
    
    if (backBtn) {
        backBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Move back to step 1
            step2.classList.remove('active');
            step1.classList.add('active');
            
            // Update progress steps
            document.querySelectorAll('.step')[1].classList.remove('active');
            document.querySelectorAll('.step-line')[0].classList.remove('active');
            
            // Scroll to top of form
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }
    
    // Image preview functionality
    function setupImagePreview(inputId, previewId) {
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);
        
        if (input && preview) {
            input.addEventListener('change', function(e) {
                if (e.target.files && e.target.files[0]) {
                    const file = e.target.files[0];
                    
                    // Check file size
                    const maxSize = inputId.includes('hero') ? 5 * 1024 * 1024 : 2 * 1024 * 1024;
                    if (file.size > maxSize) {
                        alert(`File terlalu besar! Maksimal: ${maxSize / (1024 * 1024)}MB`);
                        input.value = '';
                        return;
                    }
                    
                    // Check file type
                    if (!file.type.match('image.*')) {
                        alert('Hanya file gambar yang diperbolehkan!');
                        input.value = '';
                        return;
                    }
                    
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        preview.src = event.target.result;
                        preview.style.objectFit = 'cover';
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    }
    
    // Setup image previews
    setupImagePreview('logoInput', 'logoPreview');
    setupImagePreview('heroInput', 'heroPreview');
    
    // Quick actions
    const useTemplateCheckbox = document.getElementById('useTemplate');
    const copyFromExistingCheckbox = document.getElementById('copyFromExisting');
    
    if (useTemplateCheckbox) {
        useTemplateCheckbox.addEventListener('change', function() {
            if (this.checked && copyFromExistingCheckbox) {
                copyFromExistingCheckbox.checked = false;
                
                // Auto-fill with template data
                const description = document.querySelector('textarea[name="description"]');
                const vision = document.querySelector('textarea[name="vision"]');
                const mission = document.querySelector('textarea[name="mission"]');
                const overviewContent = document.querySelector('textarea[name="overview_content"]');
                
                if (description && !description.value) {
                    description.value = 'Jurusan ini mempelajari... (isi deskripsi sesuai jurusan)';
                }
                
                if (vision && !vision.value) {
                    vision.value = 'Menjadi jurusan unggulan dalam bidang... yang menghasilkan lulusan berkualitas dan siap bersaing di dunia kerja.';
                }
                
                if (mission && !mission.value) {
                    mission.value = '1. Menyelenggarakan pendidikan yang berkualitas\n2. Mengembangkan kompetensi siswa sesuai kebutuhan industri\n3. Membangun karakter dan etos kerja yang baik\n4. Menjalin kerjasama dengan dunia usaha dan industri';
                }
                
                if (overviewContent && !overviewContent.value) {
                    overviewContent.value = 'Jurusan ini berfokus pada pengembangan kompetensi... Siswa akan dibekali dengan pengetahuan teoritis dan keterampilan praktis yang sesuai dengan standar industri.';
                }
            }
        });
    }
    
    if (copyFromExistingCheckbox) {
        copyFromExistingCheckbox.addEventListener('change', function() {
            if (this.checked && useTemplateCheckbox) {
                useTemplateCheckbox.checked = false;
                
                // Show modal or dropdown to select existing major
                alert('Fitur ini akan memungkinkan Anda menyalin struktur dari jurusan yang sudah ada. Untuk sekarang, gunakan template atau isi manual.');
            }
        });
    }
    
    // Form submission
    if (form) {
        form.addEventListener('submit', function(e) {
            // Validate before submit
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    if (isValid) {
                        field.focus();
                        isValid = false;
                    }
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Harap lengkapi semua field yang wajib diisi!');
                return;
            }
            
            // Show loading
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Membuat jurusan...';
            
            // Allow form to submit normally
            // Loading state will be cleared on page reload
        });
    }
    
    // Auto-generate short name from full name
    const nameInput = document.querySelector('input[name="name"]');
    const shortNameInput = document.querySelector('input[name="short_name"]');
    
    if (nameInput && shortNameInput) {
        nameInput.addEventListener('blur', function() {
            // Only auto-generate if short name is empty
            if (!shortNameInput.value.trim()) {
                const name = this.value.trim();
                let shortName = '';
                
                // Try to extract acronym from name
                if (name.includes('dan')) {
                    // For names like "Teknik Komputer dan Jaringan"
                    const words = name.split(' ');
                    for (let word of words) {
                        if (word.length > 2 && !['dan', 'dan', '&'].includes(word.toLowerCase())) {
                            shortName += word[0].toUpperCase();
                        }
                    }
                } else if (name.includes('&')) {
                    // For names with &
                    const words = name.split('&');
                    words.forEach(word => {
                        const firstWord = word.trim().split(' ')[0];
                        if (firstWord) {
                            shortName += firstWord[0].toUpperCase();
                        }
                    });
                } else {
                    // Take first letters of first two words
                    const words = name.split(' ');
                    if (words.length >= 2) {
                        shortName = (words[0][0] + words[1][0]).toUpperCase();
                    } else if (words.length === 1) {
                        shortName = words[0].substring(0, 3).toUpperCase();
                    }
                }
                
                if (shortName.length >= 2 && shortName.length <= 5) {
                    shortNameInput.value = shortName;
                }
            }
        });
    }
});
</script>
@endpush
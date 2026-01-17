@extends('layouts.backend')

@section('title', 'Edit Jurusan - Dashboard Admin')

@section('content')
    <!-- Header Card -->
    <div class="card shadow mb-4 border-0">
        <div class="card-body py-4">
            <div class="d-flex justify-content-between align-items-center page-header">
                <div>
                    <h1 class="h3 text-gray-800 mb-1">
                        <i class="fas fa-edit me-2"></i> Edit Jurusan: {{ $major->name }}
                    </h1>
                    <p class="text-muted mb-0">Kelola konten halaman jurusan secara lengkap</p>
                </div>
                <div>
                    <a href="#" target="_blank" class="btn btn-outline-info">
                        <i class="fas fa-external-link-alt me-1"></i> Lihat di Frontend
                    </a>
                    <a href="{{ route('backend.majors.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
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
                <ul class="nav nav-tabs justify-content-center" id="majorTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button"
                                title="Informasi Dasar">
                            <i class="fas fa-info-circle me-2"></i>
                            <span class="tab-text">Dasar</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button"
                                title="Overview Jurusan">
                            <i class="fas fa-book-open me-2"></i>
                            <span class="tab-text">Overview</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="vision-mission-tab" data-bs-toggle="tab" data-bs-target="#vision-mission" type="button"
                                title="Visi & Misi Jurusan">
                            <i class="fas fa-bullseye me-2"></i>
                            <span class="tab-text">Visi & Misi</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="learning-tab" data-bs-toggle="tab" data-bs-target="#learning" type="button"
                                title="Pembelajaran">
                            <i class="fas fa-graduation-cap me-2"></i>
                            <span class="tab-text">Pembelajaran</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="accordion-tab" data-bs-toggle="tab" data-bs-target="#accordion" type="button"
                                title="Accordion (Homepage)">
                            <i class="fas fa-list-alt me-2"></i>
                            <span class="tab-text">Accordion</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo" type="button"
                                title="SEO Settings">
                            <i class="fas fa-search me-2"></i>
                            <span class="tab-text">SEO</span>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Main Form -->
        <form id="majorForm" method="POST" action="{{ route('backend.majors.update', $major->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Tab Content -->
            <div class="card-body bg-light p-3 p-md-4">
                <div class="tab-content" id="majorTabContent">
                    <!-- Tab 1: Basic Information -->
                    <div class="tab-pane fade show active" id="basic" role="tabpanel">
                        <div class="row">
                            <div class="col-lg-6 mb-4">
                                <div class="card border h-100">
                                    <div class="card-header bg-primary text-white d-flex align-items-center">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <h6 class="mb-0">Informasi Dasar Jurusan</h6>
                                    </div>
                                    <div class="card-body">
                                        <!-- Nama Jurusan -->
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-graduation-cap me-2"></i> Nama Jurusan <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="name" 
                                                   value="{{ old('name', $major->name) }}"
                                                   placeholder="Contoh: Teknik Komputer dan Jaringan"
                                                   required>
                                            <div class="form-text">Nama lengkap jurusan/kompetensi keahlian</div>
                                        </div>

                                        <!-- Singkatan -->
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-ab me-2"></i> Singkatan/Nama Pendek
                                            </label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="short_name" 
                                                   value="{{ old('short_name', $major->short_name) }}"
                                                   placeholder="Contoh: TKJ">
                                            <div class="form-text">Digunakan untuk tampilan yang membutuhkan ruang terbatas</div>
                                        </div>

                                        <!-- Deskripsi Singkat -->
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-align-left me-2"></i> Deskripsi Singkat <span class="text-danger">*</span>
                                            </label>
                                            <textarea class="form-control" 
                                                      name="description" 
                                                      rows="4"
                                                      placeholder="Deskripsi singkat tentang jurusan ini..."
                                                      required>{{ old('description', $major->description) }}</textarea>
                                            <div class="form-text">Ditampilkan di card jurusan di halaman depan</div>
                                        </div>

                                        <!-- Logo -->
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-image me-2"></i> Logo Jurusan
                                            </label>
                                            
                                            <!-- Current Logo -->
                                            <div class="current-logo mb-3 text-center">
                                                <div class="position-relative d-inline-block">
                                                    <img src="{{ $major->getLogoUrl() }}" 
                                                         class="img-fluid rounded border shadow" 
                                                         style="max-height: 100px; width: auto;"
                                                         id="current-logo"
                                                         data-original-src="{{ $major->getLogoUrl() }}">
                                                    @if($major->logo)
                                                    <div class="position-absolute top-0 end-0 mt-2 me-2">
                                                        <button type="button" 
                                                                class="btn btn-sm btn-danger remove-image-btn" 
                                                                data-type="logo">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <!-- Upload New Logo -->
                                            <input type="file" 
                                                   class="form-control" 
                                                   name="logo" 
                                                   accept="image/*"
                                                   id="logo-input">
                                            <small class="text-muted d-block mt-2">
                                                <i class="fas fa-ruler-combined me-1"></i>
                                                Rekomendasi: 200x200px, format PNG dengan background transparan
                                            </small>
                                        </div>

                                        <!-- Status dan Urutan -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label fw-bold">
                                                        <i class="fas fa-toggle-on me-2"></i> Status
                                                    </label>
                                                    <select class="form-select" name="is_active">
                                                        <option value="1" {{ $major->is_active ? 'selected' : '' }}>Aktif</option>
                                                        <option value="0" {{ !$major->is_active ? 'selected' : '' }}>Nonaktif</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label fw-bold">
                                                        <i class="fas fa-sort-numeric-down me-2"></i> Urutan
                                                    </label>
                                                    <input type="number" 
                                                           class="form-control" 
                                                           name="order" 
                                                           value="{{ old('order', $major->order) }}"
                                                           min="0"
                                                           placeholder="0">
                                                    <div class="form-text">Semakin kecil angka, semakin awal ditampilkan</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-4">
                                <div class="card border h-100">
                                    <div class="card-header bg-info text-white d-flex align-items-center">
                                        <i class="fas fa-image me-2"></i>
                                        <h6 class="mb-0">Hero Section</h6>
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
                                                   value="{{ old('hero_title', $major->hero_title) }}"
                                                   placeholder="Contoh: Teknik Komputer dan Jaringan">
                                            <div class="form-text">Judul yang ditampilkan di hero section</div>
                                        </div>

                                        <!-- Hero Subtitle -->
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-align-left me-2"></i> Subtitle Hero
                                            </label>
                                            <textarea class="form-control" 
                                                      name="hero_subtitle" 
                                                      rows="3"
                                                      placeholder="Deskripsi singkat untuk hero section...">{{ old('hero_subtitle', $major->hero_subtitle) }}</textarea>
                                            <div class="form-text">Ditampilkan di bawah judul hero</div>
                                        </div>

                                        <!-- Hero Image -->
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-image me-2"></i> Gambar Background Hero
                                            </label>
                                            
                                            <!-- Current Image -->
                                            <div class="current-hero mb-3 text-center">
                                                <div class="position-relative d-inline-block">
                                                    <img src="{{ $major->getHeroImageUrl() }}" 
                                                         class="img-fluid rounded border shadow" 
                                                         style="max-height: 150px; width: 100%; object-fit: cover;"
                                                         id="current-hero-image"
                                                         data-original-src="{{ $major->getHeroImageUrl() }}">
                                                    @if($major->hero_image)
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
                                            
                                            <!-- Upload New Image -->
                                            <input type="file" 
                                                   class="form-control" 
                                                   name="hero_image" 
                                                   accept="image/*"
                                                   id="hero-image-input">
                                            <small class="text-muted d-block mt-2">
                                                <i class="fas fa-ruler-combined me-1"></i>
                                                Ukuran optimal: 1920x400px. Format: JPG, PNG, JPEG (Max: 5MB)
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 2: Overview -->
                    <div class="tab-pane fade" id="overview" role="tabpanel">
                        <div class="row">
                            <div class="col-lg-6 mb-4">
                                <div class="card border h-100">
                                    <div class="card-header bg-success text-white d-flex align-items-center">
                                        <i class="fas fa-book-open me-2"></i>
                                        <h6 class="mb-0">Konten Teks Overview</h6>
                                    </div>
                                    <div class="card-body">
                                        <!-- Judul -->
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-heading me-2"></i> Judul Section <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="overview_title" 
                                                   value="{{ old('overview_title', $major->overview_title) }}"
                                                   placeholder="Contoh: Teknik Jaringan Komputer & Telekomunikasi"
                                                   required>
                                        </div>

                                        <!-- Konten -->
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-align-left me-2"></i> Deskripsi Utama
                                            </label>
                                            <textarea class="form-control tinymce-editor" 
                                                      name="overview_content" 
                                                      id="overview_content"
                                                      rows="6"
                                                      placeholder="Masukkan deskripsi lengkap tentang jurusan...">{{ old('overview_content', $major->overview_content) }}</textarea>
                                        </div>

                                        <!-- List Items -->
                                        <div class="form-group">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-list me-2"></i> Tujuan Jurusan (List)
                                            </label>
                                            <div id="overview-list-container">
                                                @php
                                                    $defaultItems = [
                                                        'Mendidik peserta didik agar dapat bekerja baik secara mandiri atau mengisi lowongan pekerjaan yang ada di dunia usaha dan dunia industri sebagai tenaga kerja profesional.',
                                                        'Mendidik peserta didik agar mampu memilih karir, berkompetisi, dan mengembangkan sikap profesional dalam program keahlian Komputer dan Jaringan.',
                                                        'Membekali peserta didik dengan ilmu pengetahuan dan keterampilan sebagai bekal bagi yang berminat untuk melanjutkan pendidikan.'
                                                    ];
                                                    
                                                    $overviewItems = !empty($major->learning_items) ? 
                                                        (is_array($major->learning_items) ? $major->learning_items : json_decode($major->learning_items, true)) : 
                                                        $defaultItems;
                                                @endphp
                                                
                                                @foreach($overviewItems as $index => $item)
                                                <div class="input-group mb-2">
                                                    <span class="input-group-text bg-light border">{{ $index + 1 }}</span>
                                                    <input type="text" 
                                                           class="form-control" 
                                                           name="learning_items[]" 
                                                           value="{{ old("learning_items.$index", $item) }}"
                                                           placeholder="Masukkan tujuan jurusan..."
                                                           required>
                                                    <button type="button" 
                                                            class="btn btn-outline-danger remove-list-item" 
                                                            data-target="overview">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                                @endforeach
                                            </div>
                                            <button type="button" 
                                                    class="btn btn-outline-primary btn-sm mt-2" 
                                                    id="add-overview-item">
                                                <i class="fas fa-plus me-1"></i> Tambah Poin Baru
                                            </button>
                                            <div class="form-text">Tambahkan poin-poin tujuan dari jurusan ini</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-4">
                                <div class="card border h-100">
                                    <div class="card-header bg-secondary text-white d-flex align-items-center">
                                        <i class="fas fa-image me-2"></i>
                                        <h6 class="mb-0">Gambar Overview</h6>
                                    </div>
                                    <div class="card-body">
                                        <!-- Current Image -->
                                        <div class="mb-4">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-image me-2"></i> Gambar Saat Ini
                                            </label>
                                            <div class="text-center">
                                                <div class="position-relative d-inline-block">
                                                    <img src="{{ $major->getOverviewImageUrl() }}" 
                                                         class="img-fluid rounded border shadow" 
                                                         style="max-height: 200px; width: 100%; object-fit: cover;"
                                                         id="current-overview-image"
                                                         data-original-src="{{ $major->getOverviewImageUrl() }}">
                                                    @if($major->overview_image)
                                                    <div class="position-absolute top-0 end-0 mt-2 me-2">
                                                        <button type="button" 
                                                                class="btn btn-sm btn-danger remove-image-btn" 
                                                                data-type="overview">
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
                                                   name="overview_image" 
                                                   accept="image/*"
                                                   id="overview-image-input">
                                            <small class="text-muted d-block mt-2">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Rekomendasi: Rasio 1:1, min. 500x500px. Format: JPG, PNG, JPEG (Max: 2MB)
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 3: Vision & Mission -->
                    <div class="tab-pane fade" id="vision-mission" role="tabpanel">
                        <div class="row">
                            <div class="col-lg-6 mb-4">
                                <div class="card border h-100">
                                    <div class="card-header bg-warning text-white d-flex align-items-center">
                                        <i class="fas fa-bullseye me-2"></i>
                                        <h6 class="mb-0">Visi & Misi Jurusan</h6>
                                    </div>
                                    <div class="card-body">
                                        <!-- Judul Section -->
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-heading me-2"></i> Judul Section
                                            </label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="vision_mission_title" 
                                                   value="{{ old('vision_mission_title', $major->vision_mission_title) }}"
                                                   placeholder="Contoh: Visi & Misi">
                                        </div>

                                        <!-- Deskripsi -->
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-align-left me-2"></i> Deskripsi
                                            </label>
                                            <textarea class="form-control tinymce-editor" 
                                                      name="vision_mission_content" 
                                                      id="vision_mission_content"
                                                      rows="4"
                                                      placeholder="Deskripsi tentang visi dan misi jurusan...">{{ old('vision_mission_content', $major->vision_mission_content) }}</textarea>
                                        </div>

                                        <!-- Visi -->
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-eye me-2"></i> Visi Jurusan
                                            </label>
                                            <textarea class="form-control" 
                                                      name="vision" 
                                                      rows="3"
                                                      placeholder="Masukkan visi jurusan...">{{ old('vision', $major->vision) }}</textarea>
                                            <div class="form-text">Pernyataan visi jurusan yang ingin dicapai</div>
                                        </div>

                                        <!-- Misi -->
                                        <div class="form-group">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-bullseye me-2"></i> Misi Jurusan
                                            </label>
                                            <textarea class="form-control" 
                                                      name="mission" 
                                                      rows="3"
                                                      placeholder="Masukkan misi jurusan...">{{ old('mission', $major->mission) }}</textarea>
                                            <div class="form-text">Pernyataan misi atau langkah-langkah untuk mencapai visi</div>
                                        </div>

                                        <!-- Quote -->
                                        <hr class="my-4">
                                        <div class="form-group">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-quote-left me-2"></i> Kutipan Inspiratif
                                            </label>
                                            <textarea class="form-control" 
                                                      name="quote" 
                                                      rows="3"
                                                      placeholder="Masukkan kutipan inspiratif...">{{ old('quote', $major->quote) }}</textarea>
                                            <div class="row mt-2">
                                                <div class="col-md-6">
                                                    <input type="text" 
                                                           class="form-control mt-2" 
                                                           name="quote_author" 
                                                           value="{{ old('quote_author', $major->quote_author) }}"
                                                           placeholder="Nama penulis">
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" 
                                                           class="form-control mt-2" 
                                                           name="quote_position" 
                                                           value="{{ old('quote_position', $major->quote_position) }}"
                                                           placeholder="Posisi/jabatan">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-4">
                                <div class="card border h-100">
                                    <div class="card-header bg-dark text-white d-flex align-items-center">
                                        <i class="fas fa-image me-2"></i>
                                        <h6 class="mb-0">Gambar Visi & Misi</h6>
                                    </div>
                                    <div class="card-body">
                                        <!-- Current Image -->
                                        <div class="mb-4">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-image me-2"></i> Gambar Saat Ini
                                            </label>
                                            <div class="text-center">
                                                <div class="position-relative d-inline-block">
                                                    <img src="{{ $major->getVisionMissionImageUrl() }}" 
                                                         class="img-fluid rounded border shadow" 
                                                         style="max-height: 200px; width: 100%; object-fit: cover;"
                                                         id="current-vision-mission-image"
                                                         data-original-src="{{ $major->getVisionMissionImageUrl() }}">
                                                    @if($major->vision_mission_image)
                                                    <div class="position-absolute top-0 end-0 mt-2 me-2">
                                                        <button type="button" 
                                                                class="btn btn-sm btn-danger remove-image-btn" 
                                                                data-type="vision_mission">
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
                                                   name="vision_mission_image" 
                                                   accept="image/*"
                                                   id="vision-mission-image-input">
                                            <small class="text-muted d-block mt-2">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Rekomendasi: Rasio 1:1, min. 500x500px. Format: JPG, PNG, JPEG (Max: 2MB)
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 4: Learning -->
                    <div class="tab-pane fade" id="learning" role="tabpanel">
                        <div class="row">
                            <div class="col-lg-6 mb-4">
                                <div class="card border h-100">
                                    <div class="card-header bg-info text-white d-flex align-items-center">
                                        <i class="fas fa-graduation-cap me-2"></i>
                                        <h6 class="mb-0">Pembelajaran di Jurusan</h6>
                                    </div>
                                    <div class="card-body">
                                        <!-- Judul -->
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-heading me-2"></i> Judul Section
                                            </label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="learning_title" 
                                                   value="{{ old('learning_title', $major->learning_title) }}"
                                                   placeholder="Contoh: Pembelajaran di TJKT">
                                        </div>

                                        <!-- Deskripsi -->
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-align-left me-2"></i> Deskripsi
                                            </label>
                                            <textarea class="form-control tinymce-editor" 
                                                      name="learning_content" 
                                                      id="learning_content"
                                                      rows="4"
                                                      placeholder="Deskripsi tentang materi pembelajaran...">{{ old('learning_content', $major->learning_content) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-4">
                                <div class="card border h-100">
                                    <div class="card-header bg-secondary text-white d-flex align-items-center">
                                        <i class="fas fa-image me-2"></i>
                                        <h6 class="mb-0">Gambar Pembelajaran</h6>
                                    </div>
                                    <div class="card-body">
                                        <!-- Current Image -->
                                        <div class="mb-4">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-image me-2"></i> Gambar Saat Ini
                                            </label>
                                            <div class="text-center">
                                                <div class="position-relative d-inline-block">
                                                    <img src="{{ $major->getLearningImageUrl() }}" 
                                                         class="img-fluid rounded border shadow" 
                                                         style="max-height: 200px; width: 100%; object-fit: cover;"
                                                         id="current-learning-image"
                                                         data-original-src="{{ $major->getLearningImageUrl() }}">
                                                    @if($major->learning_image)
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
                                                Rekomendasi: Rasio 1:1, min. 500x500px. Format: JPG, PNG, JPEG (Max: 2MB)
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 5: Accordion (Homepage) -->
                    <div class="tab-pane fade" id="accordion" role="tabpanel">
                        <div class="row">
                            <div class="col-12">
                                <div class="card border">
                                    <div class="card-header bg-purple text-white d-flex align-items-center">
                                        <i class="fas fa-list-alt me-2"></i>
                                        <h6 class="mb-0">Accordion untuk Halaman Depan</h6>
                                    </div>
                                    <div class="card-body">
                                        <!-- Gambar untuk Accordion (Satu gambar untuk semua accordion) -->
                                        <div class="row mb-4">
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-header bg-light">
                                                        <h6 class="mb-0">Gambar untuk Tampilan Accordion</h6>
                                                        <small class="text-muted">Gambar ini akan ditampilkan di sebelah kanan accordion di halaman depan</small>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-bold">Upload Gambar Accordion</label>
                                                                    <input type="file" 
                                                                          class="form-control" 
                                                                          name="accordion_image"
                                                                          id="accordionImageInput"
                                                                          accept="image/*">
                                                                    <small class="text-muted">
                                                                        Format: JPG, PNG, GIF | Max: 2MB | Rekomendasi: 600x400px
                                                                    </small>
                                                                    
                                                                    <!-- Preview area for new image -->
                                                                    <div id="newImagePreview" class="mt-3 d-none">
                                                                        <label class="form-label fw-bold">Preview Gambar Baru</label>
                                                                        <div class="border rounded p-3 text-center">
                                                                            <img id="imagePreview" 
                                                                                class="img-fluid rounded mb-2" 
                                                                                style="max-height: 150px;"
                                                                                alt="Preview gambar baru">
                                                                            <p class="text-muted small mb-0" id="imageInfo"></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                @if($major->accordion_image)
                                                                <div class="border rounded p-3">
                                                                    <label class="form-label fw-bold">Gambar Saat Ini</label>
                                                                    <div class="text-center">
                                                                        <img src="{{ asset('storage/' . $major->accordion_image) }}" 
                                                                            class="img-fluid rounded mb-2" 
                                                                            style="max-height: 150px;"
                                                                            id="currentImage">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" 
                                                                                  type="checkbox" 
                                                                                  name="remove_accordion_image" 
                                                                                  value="1" 
                                                                                  id="removeAccordionImage">
                                                                            <label class="form-check-label text-danger" for="removeAccordionImage">
                                                                                Hapus gambar ini
                                                                            </label>
                                                                        </div>
                                                                        <small class="text-muted d-block mt-1">
                                                                            <i class="fas fa-info-circle me-1"></i> 
                                                                            <span id="currentImageInfo">{{ basename($major->accordion_image) }}</span>
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                                @else
                                                                <div class="border rounded p-3 text-center">
                                                                    <label class="form-label fw-bold">Gambar Saat Ini</label>
                                                                    <div class="py-4">
                                                                        <i class="fas fa-image fa-3x text-secondary mb-3"></i>
                                                                        <p class="text-muted mb-0">Belum ada gambar accordion</p>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Accordion Items Container -->
                                        <div class="card mt-4">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0">Item-item Accordion</h6>
                                                <small class="text-muted">Item yang akan muncul di accordion (bisa 3-5 item)</small>
                                            </div>
                                            <div class="card-body">
                                                <div id="accordion-items-container">
                                                    @php
                                                        $defaultAccordion = [
                                                            [
                                                                'title' => 'Dasar Memasak',
                                                                'icon' => 'fas fa-bowl-rice',
                                                                'content' => 'Siswa nantinya akan belajar dan dituntut untuk mampu mengolah berbagai jenis makanan dan minuman sesuai standar industri kuliner.'
                                                            ],
                                                            [
                                                                'title' => 'Manajemen Dapur Profesional',
                                                                'icon' => 'fas fa-cake-candles',
                                                                'content' => 'Siswa nantinya akan belajar dan dituntut untuk mampu mengelola dapur profesional sesuai standar industri.'
                                                            ],
                                                            [
                                                                'title' => 'Kesempatan Kerja',
                                                                'icon' => 'fas fa-briefcase',
                                                                'content' => 'Siswa nantinya akan belajar dan dituntut untuk mampu mengolah berbagai jenis makanan dan minuman sesuai standar industri kuliner.'
                                                            ]
                                                        ];
                                                        
                                                        $accordionItems = !empty($major->accordion_items) ? 
                                                            (is_array($major->accordion_items) ? $major->accordion_items : json_decode($major->accordion_items, true)) : 
                                                            $defaultAccordion;
                                                    @endphp
                                                    
                                                    @foreach($accordionItems as $index => $item)
                                                    <div class="accordion-item-card mb-4 p-4 border rounded">
                                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                                            <h6 class="mb-0">Item {{ $index + 1 }}</h6>
                                                            <button type="button" class="btn btn-sm btn-outline-danger remove-accordion-item" data-index="{{ $index }}">
                                                                <i class="fas fa-trash"></i> Hapus
                                                            </button>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label fw-bold">Judul</label>
                                                                <input type="text" 
                                                                      class="form-control" 
                                                                      name="accordion_items[{{ $index }}][title]" 
                                                                      value="{{ $item['title'] ?? '' }}"
                                                                      placeholder="Contoh: Dasar Memasak"
                                                                      required>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label fw-bold">Icon FontAwesome</label>
                                                                <input type="text" 
                                                                      class="form-control" 
                                                                      name="accordion_items[{{ $index }}][icon]" 
                                                                      value="{{ $item['icon'] ?? 'fas fa-cog' }}"
                                                                      placeholder="fas fa-icon-name">
                                                                <small class="text-muted">Gunakan class FontAwesome, contoh: fas fa-bowl-rice</small>
                                                            </div>
                                                            <div class="col-12 mb-3">
                                                                <label class="form-label fw-bold">Konten</label>
                                                                <textarea class="form-control" 
                                                                          name="accordion_items[{{ $index }}][content]" 
                                                                          rows="3"
                                                                          placeholder="Isi konten accordion..."
                                                                          required>{{ $item['content'] ?? '' }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>

                                                <!-- Add New Accordion Item Button -->
                                                <button type="button" class="btn btn-outline-primary btn-lg w-100 py-3" id="add-accordion-item">
                                                    <i class="fas fa-plus-circle me-2"></i> Tambah Item Accordion Baru
                                                </button>

                                                <!-- Hidden template for new accordion items -->
                                                <template id="accordion-item-template">
                                                    <div class="accordion-item-card mb-4 p-4 border rounded">
                                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                                            <h6 class="mb-0">Item <span class="item-number"></span></h6>
                                                            <button type="button" class="btn btn-sm btn-outline-danger remove-accordion-item">
                                                                <i class="fas fa-trash"></i> Hapus
                                                            </button>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label fw-bold">Judul</label>
                                                                <input type="text" 
                                                                      class="form-control" 
                                                                      name="accordion_items[__INDEX__][title]" 
                                                                      placeholder="Contoh: Dasar Memasak"
                                                                      required>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label fw-bold">Icon FontAwesome</label>
                                                                <input type="text" 
                                                                      class="form-control" 
                                                                      name="accordion_items[__INDEX__][icon]" 
                                                                      value="fas fa-cog"
                                                                      placeholder="fas fa-icon-name">
                                                                <small class="text-muted">Gunakan class FontAwesome, contoh: fas fa-bowl-rice</small>
                                                            </div>
                                                            <div class="col-12 mb-3">
                                                                <label class="form-label fw-bold">Konten</label>
                                                                <textarea class="form-control" 
                                                                          name="accordion_items[__INDEX__][content]" 
                                                                          rows="3"
                                                                          placeholder="Isi konten accordion..."
                                                                          required></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 6: SEO -->
                    <div class="tab-pane fade" id="seo" role="tabpanel">
                        <div class="row">
                            <div class="col-12">
                                <div class="card border">
                                    <div class="card-header bg-dark text-white d-flex align-items-center">
                                        <i class="fas fa-search me-2"></i>
                                        <h6 class="mb-0">Pengaturan SEO</h6>
                                    </div>
                                    <div class="card-body">
                                        <!-- Meta Title -->
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-heading me-2"></i> Meta Title
                                            </label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="meta_title" 
                                                   value="{{ old('meta_title', $major->meta_title) }}"
                                                   placeholder="Contoh: Jurusan Teknik Komputer dan Jaringan - SMK Wisata Indonesia Jakarta"
                                                   maxlength="60">
                                            <div class="form-text">Judul untuk SEO (maksimal 60 karakter)</div>
                                        </div>

                                        <!-- Meta Description -->
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-align-left me-2"></i> Meta Description
                                            </label>
                                            <textarea class="form-control" 
                                                      name="meta_description" 
                                                      rows="3"
                                                      placeholder="Deskripsi singkat untuk SEO..."
                                                      maxlength="160">{{ old('meta_description', $major->meta_description) }}</textarea>
                                            <div class="form-text">Deskripsi untuk SEO (maksimal 160 karakter)</div>
                                        </div>

                                        <!-- Meta Keywords -->
                                        <div class="form-group">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-tags me-2"></i> Meta Keywords
                                            </label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="meta_keywords" 
                                                   value="{{ old('meta_keywords', $major->meta_keywords) }}"
                                                   placeholder="Contoh: tkj, jaringan komputer, smk, jakarta, pendidikan">
                                            <div class="form-text">Kata kunci dipisahkan dengan koma</div>
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
                            <i class="fas fa-save me-1"></i> Simpan Perubahan
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
    }
    
    .nav-tabs .nav-link.active {
        border-bottom-color: #6b02b1;
        font-weight: 600;
    }
    
    .accordion-item-card {
        background-color: #f8f9fa;
        transition: all 0.3s ease;
    }
    
    .accordion-item-card:hover {
        background-color: #fff;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
</style>
@endpush

@push('scripts')
<script src="{{ asset('assets/js/tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize TinyMCE
    tinymce.init({
        selector: '.tinymce-editor',
        height: 300,
        menubar: true,
        plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table help wordcount',
        toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code',
        language: 'id',
        promotion: false,
        branding: false
    });
    
    // Image preview
    function setupImagePreview(inputId, previewId) {
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);
        
        if (input && preview) {
            input.addEventListener('change', function(e) {
                if (e.target.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        preview.src = event.target.result;
                    };
                    reader.readAsDataURL(e.target.files[0]);
                }
            });
        }
    }
    
    // Setup all image previews
    setupImagePreview('logo-input', 'current-logo');
    setupImagePreview('hero-image-input', 'current-hero-image');
    setupImagePreview('overview-image-input', 'current-overview-image');
    setupImagePreview('vision-mission-image-input', 'current-vision-mission-image');
    setupImagePreview('learning-image-input', 'current-learning-image');
    
    // Add accordion item
    document.getElementById('add-accordion-item')?.addEventListener('click', function() {
        const container = document.getElementById('accordion-items-container');
        const template = document.getElementById('accordion-item-template');
        const clone = template.content.cloneNode(true);
        const index = container.children.length;
        
        // Update index and item number
        clone.querySelector('.item-number').textContent = index + 1;
        const inputs = clone.querySelectorAll('input, textarea');
        inputs.forEach(input => {
            input.name = input.name.replace('__INDEX__', index);
        });
        
        container.appendChild(clone);
        
        // Scroll to new item
        setTimeout(() => {
            container.lastElementChild.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }, 100);
    });

    // Accordion Image Preview
    const accordionImageInput = document.getElementById('accordionImageInput');
    const imagePreview = document.getElementById('imagePreview');
    const imageInfo = document.getElementById('imageInfo');
    const newImagePreview = document.getElementById('newImagePreview');
    const currentImage = document.getElementById('currentImage');
    const currentImageInfo = document.getElementById('currentImageInfo');
    const removeAccordionImageCheckbox = document.getElementById('removeAccordionImage');
    
    if (accordionImageInput) {
        accordionImageInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            
            if (file) {
                // Validasi ukuran file (2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar. Maksimal 2MB.');
                    accordionImageInput.value = '';
                    newImagePreview.classList.add('d-none');
                    return;
                }
                
                // Validasi tipe file
                const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
                if (!validTypes.includes(file.type)) {
                    alert('Format file tidak didukung. Gunakan JPG, PNG, atau GIF.');
                    accordionImageInput.value = '';
                    newImagePreview.classList.add('d-none');
                    return;
                }
                
                // Tampilkan preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imageInfo.textContent = `${file.name} (${(file.size / 1024).toFixed(2)} KB)`;
                    newImagePreview.classList.remove('d-none');
                    
                    // Sembunyikan gambar lama jika ada
                    if (currentImage) {
                        currentImage.style.opacity = '0.5';
                    }
                    if (currentImageInfo) {
                        currentImageInfo.textContent = 'Gambar akan diganti';
                    }
                };
                reader.readAsDataURL(file);
            } else {
                newImagePreview.classList.add('d-none');
                
                // Kembalikan gambar lama ke normal
                if (currentImage) {
                    currentImage.style.opacity = '1';
                }
                if (currentImageInfo) {
                    currentImageInfo.textContent = '{{ $major->accordion_image ? basename($major->accordion_image) : "" }}';
                }
            }
        });
    }
    
    // Handle remove accordion image checkbox
    if (removeAccordionImageCheckbox) {
        removeAccordionImageCheckbox.addEventListener('change', function() {
            if (this.checked) {
                // Nonaktifkan input file
                if (accordionImageInput) {
                    accordionImageInput.disabled = true;
                    accordionImageInput.value = '';
                    
                    // Sembunyikan preview baru
                    newImagePreview.classList.add('d-none');
                }
                
                // Sembunyikan gambar lama
                if (currentImage) {
                    currentImage.style.opacity = '0.3';
                    currentImage.style.filter = 'grayscale(100%)';
                }
                if (currentImageInfo) {
                    currentImageInfo.innerHTML = '<span class="text-danger">Gambar akan dihapus</span>';
                }
            } else {
                // Aktifkan kembali input file
                if (accordionImageInput) {
                    accordionImageInput.disabled = false;
                }
                
                // Kembalikan gambar lama ke normal
                if (currentImage) {
                    currentImage.style.opacity = '1';
                    currentImage.style.filter = 'none';
                }
                if (currentImageInfo) {
                    currentImageInfo.textContent = '{{ $major->accordion_image ? basename($major->accordion_image) : "" }}';
                }
            }
        });
    }
    
    // Accordion items management
    const container = document.getElementById('accordion-items-container');
    const template = document.getElementById('accordion-item-template');
    const addButton = document.getElementById('add-accordion-item');
    
    // Fungsi untuk update nomor item
    function updateItemNumbers() {
        const items = container.querySelectorAll('.accordion-item-card');
        items.forEach((item, index) => {
            const numberSpan = item.querySelector('.item-number');
            if (numberSpan) {
                numberSpan.textContent = index + 1;
            }
            
            // Update input names dengan index baru
            const inputs = item.querySelectorAll('input, textarea');
            inputs.forEach(input => {
                if (input.name && input.name.includes('__INDEX__')) {
                    input.name = input.name.replace('__INDEX__', index);
                }
            });
        });
    }
    
    // Fungsi untuk menambah item baru
    if (addButton && template) {
        addButton.addEventListener('click', function() {
            const newIndex = container.querySelectorAll('.accordion-item-card').length;
            const newItem = template.content.cloneNode(true);
            
            // Update semua input dengan index baru
            newItem.querySelectorAll('input, textarea').forEach(input => {
                if (input.name) {
                    input.name = input.name.replace('__INDEX__', newIndex);
                }
            });
            
            // Update nomor item
            newItem.querySelector('.item-number').textContent = newIndex + 1;
            
            container.appendChild(newItem);
            
            // Tambahkan event listener untuk tombol hapus
            const removeBtn = container.querySelector('.accordion-item-card:last-child .remove-accordion-item');
            removeBtn.addEventListener('click', function() {
                if (confirm('Apakah Anda yakin ingin menghapus item ini?')) {
                    this.closest('.accordion-item-card').remove();
                    updateItemNumbers();
                }
            });
            
            // Scroll ke item baru
            container.lastElementChild.scrollIntoView({ behavior: 'smooth' });
        });
    }
    
    // Event listener untuk tombol hapus yang sudah ada
    if (container) {
        container.querySelectorAll('.remove-accordion-item').forEach(btn => {
            btn.addEventListener('click', function() {
                if (confirm('Apakah Anda yakin ingin menghapus item ini?')) {
                    this.closest('.accordion-item-card').remove();
                    updateItemNumbers();
                }
            });
        });
    }
    
    // Form validation untuk accordion items
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(event) {
            const accordionItems = container.querySelectorAll('.accordion-item-card');
            
            // Validasi minimal 1 item
            if (accordionItems.length === 0) {
                event.preventDefault();
                alert('Minimal harus ada 1 item accordion.');
                return false;
            }
            
            // Validasi setiap item
            let isValid = true;
            accordionItems.forEach((item, index) => {
                const title = item.querySelector('input[name*="[title]"]');
                const content = item.querySelector('textarea[name*="[content]"]');
                
                if (!title.value.trim() || !content.value.trim()) {
                    isValid = false;
                    title.style.borderColor = !title.value.trim() ? 'red' : '';
                    content.style.borderColor = !content.value.trim() ? 'red' : '';
                    
                    if (!title.value.trim()) {
                        title.focus();
                    }
                } else {
                    title.style.borderColor = '';
                    content.style.borderColor = '';
                }
            });
            
            if (!isValid) {
                event.preventDefault();
                alert('Semua item accordion harus memiliki judul dan konten.');
                return false;
            }
        });
    }
    
    // Remove accordion item
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-accordion-item')) {
            const card = e.target.closest('.accordion-item-card');
            if (card && document.querySelectorAll('.accordion-item-card').length > 1) {
                card.remove();
                // Renumber remaining items
                document.querySelectorAll('.accordion-item-card').forEach((card, index) => {
                    card.querySelector('.item-number').textContent = index + 1;
                });
            } else {
                alert('Minimal harus ada satu item accordion');
            }
        }
    });
    
    // Add list item
    document.getElementById('add-overview-item')?.addEventListener('click', function() {
        const container = document.getElementById('overview-list-container');
        const index = container.children.length;
        
        const div = document.createElement('div');
        div.className = 'input-group mb-2';
        div.innerHTML = `
            <span class="input-group-text bg-light border">${index + 1}</span>
            <input type="text" class="form-control" name="learning_items[]" 
                   placeholder="Masukkan tujuan jurusan..." required>
            <button type="button" class="btn btn-outline-danger remove-list-item">
                <i class="fas fa-trash"></i>
            </button>
        `;
        container.appendChild(div);
    });
    
    // Remove list item
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-list-item')) {
            const container = document.getElementById('overview-list-container');
            if (container.children.length > 1) {
                e.target.closest('.input-group').remove();
                // Renumber
                container.querySelectorAll('.input-group').forEach((group, index) => {
                    group.querySelector('.input-group-text').textContent = index + 1;
                });
            } else {
                alert('Minimal harus ada satu item');
            }
        }
    });
    
    // Remove image
    document.addEventListener('click', async function(e) {
        if (e.target.closest('.remove-image-btn')) {
            const button = e.target.closest('.remove-image-btn');
            const type = button.dataset.type;
            const majorId = {{ $major->id }};
            
            if (confirm('Apakah Anda yakin ingin menghapus gambar ini?')) {
                try {
                    const response = await fetch(`/backend/majors/${majorId}/remove-${type}-image`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    });
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        // Reset image to default
                        const img = document.getElementById(`current-${type.replace('_', '-')}-image`);
                        if (img) {
                            img.src = img.dataset.originalSrc;
                        }
                        
                        // Clear file input
                        const input = document.getElementById(`${type.replace('_', '-')}-input`);
                        if (input) {
                            input.value = '';
                        }
                        
                        alert('Gambar berhasil dihapus');
                    } else {
                        alert('Gagal menghapus gambar: ' + data.message);
                    }
                } catch (error) {
                    alert('Terjadi kesalahan saat menghapus gambar');
                }
            }
        }
    });
    
    // Form submission
    document.getElementById('majorForm')?.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Save TinyMCE content
        tinymce.triggerSave();
        
        const form = this;
        const submitBtn = document.getElementById('submitBtn');
        const originalText = submitBtn.innerHTML;
        
        // Disable submit button
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...';
        
        try {
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
            
            if (response.ok && data.success) {
                // Success
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        window.location.reload();
                    }
                });
            } else {
                // Error
                let errorMessage = data.message || 'Terjadi kesalahan saat menyimpan';
                
                if (data.errors) {
                    const firstError = Object.values(data.errors)[0][0];
                    errorMessage = firstError;
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: errorMessage
                });
            }
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Terjadi kesalahan jaringan. Silakan coba lagi.'
            });
        } finally {
            // Re-enable submit button
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    });
    
    // Reset form
    document.getElementById('resetFormBtn')?.addEventListener('click', function() {
        if (confirm('Apakah Anda yakin ingin mereset form? Semua perubahan yang belum disimpan akan hilang.')) {
            document.getElementById('majorForm').reset();
            tinymce.get().forEach(editor => {
                if (editor) {
                    editor.setContent('');
                }
            });
            
            // Reset images to original
            document.querySelectorAll('[data-original-src]').forEach(img => {
                img.src = img.dataset.originalSrc;
            });
            
            // Clear file inputs
            document.querySelectorAll('input[type="file"]').forEach(input => {
                input.value = '';
            });
            
            alert('Form telah direset');
        }
    });
});
</script>
@endpush
@extends('layouts.backend')

@section('title', 'Visi & Misi - Dashboard Admin')

@section('content')

    <!-- Header Card -->
    <div class="card shadow mb-4 border-0">
        <div class="card-body py-4">
            <div class="d-flex justify-content-between align-items-center page-header">
                <div>
                    <h1 class="h3 text-gray-800 mb-1">
                        <i class="fas fa-bullseye me-2"></i> Kelola Visi & Misi
                    </h1>
                    <p class="text-muted mb-0">Kelola konten halaman Visi & Misi sekolah</p>
                </div>
                <div>
                    <a href="#" target="_blank" class="btn btn-outline-info">
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
                <ul class="nav nav-tabs" id="visiMisiTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="paragraf-tab" data-bs-toggle="tab" data-bs-target="#paragraf" type="button"
                                title="Paragraf Pembuka">
                            <i class="fas fa-paragraph me-2"></i>
                            <span class="tab-text">Paragraf</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="kartu-tab" data-bs-toggle="tab" data-bs-target="#kartu" type="button"
                                title="3 Kartu Unggulan">
                            <i class="fas fa-images me-2"></i>
                            <span class="tab-text">Kartu</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="visi-tab" data-bs-toggle="tab" data-bs-target="#visi" type="button"
                                title="Visi Sekolah">
                            <i class="fas fa-eye me-2"></i>
                            <span class="tab-text">Visi</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="misi-tab" data-bs-toggle="tab" data-bs-target="#misi" type="button"
                                title="Misi Sekolah">
                            <i class="fas fa-bullseye me-2"></i>
                            <span class="tab-text">Misi</span>
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
        <form action="{{ route('backend.visi-misi.store') }}" method="POST" id="visiMisiForm" enctype="multipart/form-data">
            @csrf
            
            <!-- Tab Content -->
            <div class="card-body bg-light p-3 p-md-4">
                <div class="tab-content" id="visiMisiTabContent">
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
                                        rows="6"
                                        placeholder="Masukkan paragraf pembuka..."
                                        required
                                    >{{ old('opening_paragraph', $visiMisi->opening_paragraph) }}</textarea>
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

                    <!-- Tab 2: 3 Kartu Unggulan -->
                    <div class="tab-pane fade" id="kartu" role="tabpanel">
                        <div class="row">
                            @for($i = 1; $i <= 3; $i++)
                            @php
                                $cardLabel = "card{$i}_label";
                                $cardImage = "card{$i}_image";
                                $cardColors = ['primary', 'success', 'warning'];
                                $icons = ['lightbulb', 'star', 'heart'];
                                $descriptions = [
                                    'Kreatif - Ide dan inovasi baru',
                                    'Unggul - Berkualitas dan berprestasi', 
                                    'Berakhlak Mulia - Karakter dan moral yang baik'
                                ];
                            @endphp
                            <div class="col-lg-4 mb-4">
                                <div class="card border h-100">
                                    <div class="card-header bg-{{ $cardColors[$i-1] }} text-white d-flex align-items-center">
                                        <i class="fas fa-{{ $icons[$i-1] }} me-2"></i>
                                        <h6 class="mb-0">Kartu {{ $i }} - {{ $visiMisi->$cardLabel }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <!-- Label -->
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold">Label Teks <span class="text-danger">*</span></label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="card{{ $i }}_label" 
                                                   value="{{ old("card{$i}_label", $visiMisi->$cardLabel) }}"
                                                   placeholder="Contoh: Kreatif"
                                                   required>
                                            @error("card{$i}_label")
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">{{ $descriptions[$i-1] }}</div>
                                        </div>

                                        <!-- Gambar -->
                                        <div class="form-group">
                                            <label class="form-label fw-bold">Gambar Latar</label>
                                            
                                            <!-- Current Image -->
                                            <div class="current-image mb-3 text-center">
                                                <div class="position-relative mb-3">
                                                    <img src="{{ $visiMisi->getCardImageUrl($i) }}" 
                                                         class="img-fluid rounded border" 
                                                         style="max-height: 150px; width: 100%; object-fit: cover;"
                                                         data-original-src="{{ $visiMisi->getCardImageUrl($i) }}">
                                                    @if($visiMisi->$cardImage)
                                                    <div class="position-absolute top-0 end-0 mt-2 me-2">
                                                        <button type="button" 
                                                                class="btn btn-sm btn-danger remove-card-image" 
                                                                data-card="{{ $i }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <!-- Upload New Image -->
                                            <input type="file" 
                                                   class="form-control" 
                                                   name="card{{ $i }}_image" 
                                                   accept="image/*"
                                                   id="card{{$i}}-image-input">
                                            <small class="text-muted d-block mt-2">
                                                <i class="fas fa-ruler-combined me-1"></i>
                                                @if($i == 3)
                                                    Ukuran: 510x250px (lebar)
                                                @else
                                                    Ukuran: 250x250px (persegi)
                                                @endif
                                            </small>
                                            @error("card{$i}_image")
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endfor
                        </div>
                    </div>

                    <!-- Tab 3: Visi -->
                    <div class="tab-pane fade" id="visi" role="tabpanel">
                        <div class="row">
                            <!-- Konten Teks -->
                            <div class="col-lg-6 mb-4">
                                <div class="card border h-100">
                                    <div class="card-header bg-info text-white d-flex align-items-center">
                                        <i class="fas fa-eye me-2"></i>
                                        <h6 class="mb-0">Konten Teks Visi</h6>
                                    </div>
                                    <div class="card-body">
                                        <!-- Judul -->
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-heading me-2"></i> Judul Section <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="visi_title" 
                                                   value="{{ old('visi_title', $visiMisi->visi_title) }}"
                                                   placeholder="Contoh: Visi Kami"
                                                   required>
                                            @error('visi_title')
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Deskripsi -->
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-align-left me-2"></i> Deskripsi (Teks Tebal) <span class="text-danger">*</span>
                                            </label>
                                            <textarea class="form-control tinymce-editor" 
                                                      name="visi_description" 
                                                      id="visi_description"
                                                      rows="4"
                                                      placeholder="Masukkan deskripsi visi..."
                                                      required>{{ old('visi_description', $visiMisi->visi_description) }}</textarea>
                                            @error('visi_description')
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Teks ini akan ditampilkan dengan format tebal</div>
                                        </div>

                                        <!-- List Items -->
                                        <div class="form-group">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-list me-2"></i> List Poin Visi
                                            </label>
                                            <div id="visi-list-container">
                                                @php
                                                    $visiItems = !empty($visiMisi->visi_items) ? 
                                                        (is_array($visiMisi->visi_items) ? $visiMisi->visi_items : json_decode($visiMisi->visi_items, true)) : 
                                                        [
                                                            'Menghasilkan lulusan yang terampil, profesional, dan siap kerja.',
                                                            'Membekali siswa dengan wawasan internasional dan kemampuan bahasa asing.',
                                                            'Menanamkan karakter positif agar menjadi pribadi berintegritas.',
                                                            'Menjadi sekolah rujukan di bidang pariwisata dan perhotelan berstandar global.',
                                                            'Menjalin kemitraan luas dengan dunia usaha dan dunia industri (DUDI).'
                                                        ];
                                                @endphp
                                                
                                                @foreach($visiItems as $index => $item)
                                                <div class="input-group mb-2">
                                                    <span class="input-group-text bg-light border">{{ $index + 1 }}</span>
                                                    <input type="text" 
                                                           class="form-control" 
                                                           name="visi_items[]" 
                                                           value="{{ old("visi_items.$index", $item) }}"
                                                           placeholder="Masukkan poin visi..."
                                                           required>
                                                    <button type="button" 
                                                            class="btn btn-outline-danger remove-list-item" 
                                                            data-target="visi">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                                @endforeach
                                            </div>
                                            <button type="button" 
                                                    class="btn btn-outline-primary btn-sm mt-2" 
                                                    id="add-visi-item">
                                                <i class="fas fa-plus me-1"></i> Tambah Poin Baru
                                            </button>
                                            @error('visi_items')
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Tambahkan poin-poin penting dari visi sekolah</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Gambar -->
                            <div class="col-lg-6 mb-4">
                                <div class="card border h-100">
                                    <div class="card-header bg-secondary text-white d-flex align-items-center">
                                        <i class="fas fa-image me-2"></i>
                                        <h6 class="mb-0">Gambar Visi</h6>
                                    </div>
                                    <div class="card-body">
                                        <!-- Current Image -->
                                        <div class="mb-4">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-image me-2"></i> Gambar Saat Ini
                                            </label>
                                            <div class="text-center">
                                                <div class="position-relative d-inline-block">
                                                    <img src="{{ $visiMisi->getVisiImageUrl() }}" 
                                                         class="img-fluid rounded border shadow" 
                                                         style="max-height: 200px; width: 100%;"
                                                         id="current-visi-image"
                                                         data-original-src="{{ $visiMisi->getVisiImageUrl() }}">
                                                    @if($visiMisi->visi_image)
                                                    <div class="position-absolute top-0 end-0 mt-2 me-2">
                                                        <button type="button" 
                                                                class="btn btn-sm btn-danger remove-image-btn" 
                                                                data-type="visi">
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
                                                   name="visi_image" 
                                                   accept="image/*"
                                                   id="visi-image-input">
                                            <small class="text-muted d-block mt-2">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Rekomendasi: Rasio 1:1, min. 500x500px. Format: JPG, PNG, JPEG (Max: 2MB)
                                            </small>
                                            @error('visi_image')
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Preview -->
                                        <div class="mt-4">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-eye me-2"></i> Preview Gambar Baru
                                            </label>
                                            <div id="visi-image-preview" 
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

                    <!-- Tab 4: Misi -->
                    <div class="tab-pane fade" id="misi" role="tabpanel">
                        <div class="row">
                            <!-- Konten Teks -->
                            <div class="col-lg-6 mb-4">
                                <div class="card border h-100">
                                    <div class="card-header bg-warning text-white d-flex align-items-center">
                                        <i class="fas fa-bullseye me-2"></i>
                                        <h6 class="mb-0">Konten Teks Misi</h6>
                                    </div>
                                    <div class="card-body">
                                        <!-- Judul -->
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-heading me-2"></i> Judul Section <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="misi_title" 
                                                   value="{{ old('misi_title', $visiMisi->misi_title) }}"
                                                   placeholder="Contoh: Misi Kami"
                                                   required>
                                            @error('misi_title')
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Deskripsi -->
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-align-left me-2"></i> Deskripsi (Teks Tebal) <span class="text-danger">*</span>
                                            </label>
                                            <textarea class="form-control tinymce-editor" 
                                                      name="misi_description" 
                                                      id="misi_description"
                                                      rows="4"
                                                      placeholder="Masukkan deskripsi misi..."
                                                      required>{{ old('misi_description', $visiMisi->misi_description) }}</textarea>
                                            @error('misi_description')
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Teks ini akan ditampilkan dengan format tebal</div>
                                        </div>

                                        <!-- List Items -->
                                        <div class="form-group">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-list me-2"></i> List Poin Misi
                                            </label>
                                            <div id="misi-list-container">
                                                @php
                                                    $misiItems = !empty($visiMisi->misi_items) ? 
                                                        (is_array($visiMisi->misi_items) ? $visiMisi->misi_items : json_decode($visiMisi->misi_items, true)) : 
                                                        [
                                                            'Meningkatkan kompetensi peserta didik di bidang pariwisata dan perhotelan.',
                                                            'Mengintegrasikan kurikulum dengan kebutuhan dunia industri (DUDI).',
                                                            'Meningkatkan penguasaan bahasa asing dan teknologi informasi.',
                                                            'Membangun karakter, etos kerja, dan tanggung jawab sosial.'
                                                        ];
                                                @endphp
                                                
                                                @foreach($misiItems as $index => $item)
                                                <div class="input-group mb-2">
                                                    <span class="input-group-text bg-light border">{{ $index + 1 }}</span>
                                                    <input type="text" 
                                                           class="form-control" 
                                                           name="misi_items[]" 
                                                           value="{{ old("misi_items.$index", $item) }}"
                                                           placeholder="Masukkan poin misi..."
                                                           required>
                                                    <button type="button" 
                                                            class="btn btn-outline-danger remove-list-item" 
                                                            data-target="misi">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                                @endforeach
                                            </div>
                                            <button type="button" 
                                                    class="btn btn-outline-primary btn-sm mt-2" 
                                                    id="add-misi-item">
                                                <i class="fas fa-plus me-1"></i> Tambah Poin Baru
                                            </button>
                                            @error('misi_items')
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Tambahkan poin-poin penting dari misi sekolah</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Gambar -->
                            <div class="col-lg-6 mb-4">
                                <div class="card border h-100">
                                    <div class="card-header bg-dark text-white d-flex align-items-center">
                                        <i class="fas fa-image me-2"></i>
                                        <h6 class="mb-0">Gambar Misi</h6>
                                    </div>
                                    <div class="card-body">
                                        <!-- Current Image -->
                                        <div class="mb-4">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-image me-2"></i> Gambar Saat Ini
                                            </label>
                                            <div class="text-center">
                                                <div class="position-relative d-inline-block">
                                                    <img src="{{ $visiMisi->getMisiImageUrl() }}" 
                                                         class="img-fluid rounded border shadow" 
                                                         style="max-height: 200px; width: 100%;"
                                                         id="current-misi-image"
                                                         data-original-src="{{ $visiMisi->getMisiImageUrl() }}">
                                                    @if($visiMisi->misi_image)
                                                    <div class="position-absolute top-0 end-0 mt-2 me-2">
                                                        <button type="button" 
                                                                class="btn btn-sm btn-danger remove-image-btn" 
                                                                data-type="misi">
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
                                                   name="misi_image" 
                                                   accept="image/*"
                                                   id="misi-image-input">
                                            <small class="text-muted d-block mt-2">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Rekomendasi: Rasio 1:1, min. 500x500px. Format: JPG, PNG, JPEG (Max: 2MB)
                                            </small>
                                            @error('misi_image')
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Preview -->
                                        <div class="mt-4">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-eye me-2"></i> Preview Gambar Baru
                                            </label>
                                            <div id="misi-image-preview" 
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
                                                   value="{{ old('hero_title', $visiMisi->hero_title) }}"
                                                   placeholder="Contoh: Visi & Misi">
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
                                                    <img src="{{ $visiMisi->getHeroBackgroundUrl() }}" 
                                                         class="img-fluid rounded border shadow" 
                                                         style="max-height: 150px; width: 100%; object-fit: cover;"
                                                         id="current-hero-image"
                                                         data-original-src="{{ $visiMisi->getHeroBackgroundUrl() }}">
                                                    @if($visiMisi->hero_background)
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
    addItem(containerId, placeholder = 'Masukkan poin...') {
        const container = document.getElementById(containerId);
        const index = container.children.length;
        
        const div = document.createElement('div');
        div.className = 'input-group mb-2';
        div.innerHTML = `
            <span class="input-group-text bg-light border">${index + 1}</span>
            <input type="text" class="form-control" name="${containerId.replace('-list-container', '_items[]')}" 
                   placeholder="${placeholder}" required>
            <button type="button" class="btn btn-outline-danger remove-list-item">
                <i class="fas fa-trash"></i>
            </button>
        `;
        container.appendChild(div);
    },
    
    removeItem(button) {
        const inputGroup = button.closest('.input-group');
        const container = button.closest('[id$="-list-container"]');
        
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
    async remove(type, cardNumber = null) {
        let url = `/backend/visi-misi/remove-${type}-image`;
        let message = `Apakah Anda yakin ingin menghapus gambar ${type}?`;
        
        if (cardNumber) {
            url = `/backend/visi-misi/remove-card-image/${cardNumber}`;
            message = `Apakah Anda yakin ingin menghapus gambar kartu ${cardNumber}?`;
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

// Main Application
document.addEventListener('DOMContentLoaded', () => {
    // Initialize TinyMCE
    setTimeout(() => {
        initTinyMCE();
    }, 300);
    
    // Setup image previews
    ImageHandler.setupPreview('visi-image-input', 'visi-image-preview', 'current-visi-image');
    ImageHandler.setupPreview('misi-image-input', 'misi-image-preview', 'current-misi-image');
    
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
    
    // Setup card image previews
    for (let i = 1; i <= 3; i++) {
        const cardInput = document.getElementById(`card${i}-image-input`);
        if (cardInput) {
            cardInput.addEventListener('change', (e) => {
                const currentImg = cardInput.closest('.form-group').querySelector('.current-image img');
                if (currentImg && e.target.files[0]) {
                    const reader = new FileReader();
                    reader.onload = (event) => {
                        currentImg.src = event.target.result;
                    };
                    reader.readAsDataURL(e.target.files[0]);
                }
            });
        }
    }
    
    // Add list item buttons
    document.getElementById('add-visi-item')?.addEventListener('click', () => {
        ListItemManager.addItem('visi-list-container', 'Masukkan poin visi...');
        showSuccessToast('Poin baru ditambahkan', 1000);
    });
    
    document.getElementById('add-misi-item')?.addEventListener('click', () => {
        ListItemManager.addItem('misi-list-container', 'Masukkan poin misi...');
        showSuccessToast('Poin baru ditambahkan', 1000);
    });
    
    // Remove list item (event delegation)
    document.addEventListener('click', async (e) => {
        // Remove list items
        if (e.target.closest('.remove-list-item')) {
            const button = e.target.closest('.remove-list-item');
            
            if (ListItemManager.removeItem(button)) {
                showSuccessToast('Poin dihapus', 1000);
            } else {
                showErrorToast('Minimal harus ada satu poin!');
            }
        }
        
        // Remove images
        if (e.target.closest('.remove-image-btn')) {
            const button = e.target.closest('.remove-image-btn');
            const type = button.dataset.type;
            FileRemovalHandler.remove(type);
        }
        
        // Remove card images
        if (e.target.closest('.remove-card-image')) {
            const button = e.target.closest('.remove-card-image');
            const cardNumber = button.dataset.card;
            FileRemovalHandler.remove('card', cardNumber);
        }
    });
    
    // Form submission dengan AJAX
    document.getElementById('visiMisiForm')?.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const form = e.target;
        
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
        
        const form = document.getElementById('visiMisiForm');
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
        ['visi-image-preview', 'misi-image-preview'].forEach(previewId => {
            const preview = document.getElementById(previewId);
            if (preview) {
                preview.innerHTML = `
                    <i class="fas fa-image fa-3x text-muted mb-3"></i>
                    <p class="text-muted mb-0">Gambar akan muncul di sini setelah dipilih</p>
                `;
            }
        });
        
        // Reset current images to original
        ['current-visi-image', 'current-misi-image', 'current-hero-image'].forEach(imgId => {
            const img = document.getElementById(imgId);
            if (img && img.dataset.originalSrc) {
                img.src = img.dataset.originalSrc;
            }
        });
        
        // Reset card images
        for (let i = 1; i <= 3; i++) {
            const img = document.querySelector(`#card${i}-image-input`).closest('.form-group').querySelector('.current-image img');
            if (img && img.dataset.originalSrc) {
                img.src = img.dataset.originalSrc;
            }
        }
        
        // Reset file inputs
        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.value = '';
        });
        
        showSuccessToast('Form berhasil direset');
    });
    
    // Store original image sources
    document.querySelectorAll('#current-visi-image, #current-misi-image, #current-hero-image').forEach(img => {
        if (img) {
            img.dataset.originalSrc = img.src;
        }
    });
    
    // Store original card image sources
    document.querySelectorAll('.current-image img').forEach(img => {
        if (img) {
            img.dataset.originalSrc = img.src;
        }
    });
});

// Tampilkan SweetAlert dari session jika ada
@if(session('success'))
    $(document).ready(function() {
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
    $(document).ready(function() {
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
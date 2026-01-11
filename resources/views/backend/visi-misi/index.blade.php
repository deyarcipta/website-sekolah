@extends('layouts.backend')

@section('title', 'Visi & Misi - Dashboard Admin')

@section('content')

    <!-- Header Card -->
    <div class="card shadow mb-4 border-0">
        <div class="card-body py-4">
            <div class="d-flex justify-content-between align-items-center">
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
                                
                                <!-- Preview -->
                                <div class="mt-4">
                                    <label class="form-label fw-bold mb-3">
                                        <i class="fas fa-eye me-2"></i> Preview Frontend
                                    </label>
                                    <div class="bg-white border rounded p-3">
                                        <div class="text-center" style="font-size: 16px; line-height: 1.6;">
                                            {!! $visiMisi->opening_paragraph !!}
                                        </div>
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
                                                         style="max-height: 150px; width: 100%; object-fit: cover;">
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
                        
                        <!-- Preview Layout -->
                        <div class="mt-4">
                            <label class="form-label fw-bold mb-3">
                                <i class="fas fa-desktop me-2"></i> Preview Layout
                            </label>
                            <div class="bg-white border rounded p-3">
                                <div class="row g-3">
                                    @for($i = 1; $i <= 3; $i++)
                                    <div class="col-12 col-md-{{ $i == 3 ? '6' : '3' }}">
                                        <div class="position-relative rounded overflow-hidden shadow-sm" 
                                             style="height: 100px; background: linear-gradient(45deg, #f8f9fa, #e9ecef);">
                                            <div class="position-absolute w-100 h-100 d-flex align-items-center justify-content-center" 
                                                 style="background: rgba(107, 2, 177, 0.7);">
                                                <span class="text-white fw-bold fs-6">{{ Str::limit($visiMisi->{"card{$i}_label"}, 10) }}</span>
                                            </div>
                                            <small class="position-absolute bottom-0 start-0 m-2 badge bg-dark">Kartu {{ $i }}</small>
                                        </div>
                                    </div>
                                    @endfor
                                </div>
                                <small class="text-muted d-block mt-3">
                                    <i class="fas fa-info-circle me-1"></i> Layout responsif: 2 kartu kecil + 1 kartu lebar
                                </small>
                            </div>
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
                                                           placeholder="Masukkan poin visi...">
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
                                                         id="current-visi-image">
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
                                                           placeholder="Masukkan poin misi...">
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
                                                         id="current-misi-image">
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
                                                         id="current-hero-image">
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
                                        
                                        <!-- Preview -->
                                        <div class="mt-4">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-eye me-2"></i> Preview Hero
                                            </label>
                                            <div class="border rounded overflow-hidden shadow-sm">
                                                <div class="position-relative" style="height: 150px; overflow: hidden; background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('{{ $visiMisi->getHeroBackgroundUrl() }}'); background-size: cover; background-position: center;">
                                                    <div style="position: absolute; inset: 0; background: rgba(169, 72, 234, 0.7);"></div>
                                                    <div class="position-absolute top-50 start-50 translate-middle text-center text-white w-100 px-3">
                                                        <h4 class="mb-2 fw-bold">{{ $visiMisi->hero_title }}</h4>
                                                        <p class="mb-0 opacity-75 small">Halaman Visi & Misi</p>
                                                    </div>
                                                </div>
                                            </div>
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

<!-- Loading Overlay -->
<div class="loading-overlay">
    <div class="spinner-border text-primary mb-3" role="status" style="width: 3rem; height: 3rem;">
        <span class="visually-hidden">Loading...</span>
    </div>
    <h5 class="text-muted">Menyimpan perubahan...</h5>
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
    
    /* Nav tabs styling - NO SCROLL */
    .nav-tabs-wrapper {
        position: relative;
        overflow: hidden;
        width: 100%;
    }
    
    /* Remove all scroll behavior */
    .nav-tabs {
        border-bottom: 2px solid #dee2e6;
        display: flex !important;
        flex-wrap: nowrap !important;
        justify-content: space-between !important;
        padding-left: 0;
        margin-bottom: 0;
        list-style: none;
        width: 100% !important;
        overflow: hidden !important;
        scrollbar-width: none !important;
        -ms-overflow-style: none !important;
        min-width: 100% !important;
        max-width: 100% !important;
    }
    
    /* Hide scrollbar */
    .nav-tabs::-webkit-scrollbar {
        display: none !important;
        width: 0 !important;
        height: 0 !important;
    }
    
    .nav-tabs .nav-item {
        flex: 1 !important;
        flex-shrink: 0 !important;
        text-align: center;
        max-width: 20% !important;
        min-width: 0 !important;
    }
    
    .nav-tabs .nav-link {
        color: #495057;
        font-weight: 500;
        border: none;
        border-bottom: 3px solid transparent;
        padding: 12px 5px !important;
        transition: all 0.3s ease;
        white-space: nowrap;
        text-align: center;
        font-size: 0.85rem !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: center;
        justify-content: center;
        height: 100%;
        background-color: transparent;
        cursor: pointer;
        min-height: 70px;
        width: 100% !important;
        overflow: hidden !important;
        text-overflow: ellipsis;
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
    
    /* Tab text styling */
    .nav-tabs .nav-link .tab-text {
        display: block !important;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
        white-space: nowrap;
        font-size: 0.8rem;
    }
    
    .nav-tabs .nav-link i {
        font-size: 1.2rem;
        margin-bottom: 5px;
    }
    
    /* Loading overlay */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.95);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        flex-direction: column;
        backdrop-filter: blur(5px);
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
    
    /* Primary button */
    .btn-primary {
        background-color: #6b02b1;
        border-color: #6b02b1;
    }
    
    .btn-primary:hover {
        background-color: #5a0296;
        border-color: #5a0296;
    }
    
    /* Input focus */
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
    
    .tox-tinymce .tox-edit-area {
        width: 100% !important;
        max-width: 100% !important;
        border: none !important;
    }
    
    /* Ensure TinyMCE iframe takes full width */
    .tox-tinymce iframe {
        width: 100% !important;
        max-width: 100% !important;
        min-width: 100% !important;
    }
    
    /* Responsive adjustments untuk tabs - NO SCROLL */
    @media (max-width: 768px) {
        .nav-tabs-wrapper {
            overflow: visible !important;
        }
        
        .nav-tabs {
            display: flex !important;
            flex-wrap: nowrap !important;
            justify-content: space-between !important;
            width: 100% !important;
            overflow: visible !important;
            -webkit-overflow-scrolling: auto !important;
        }
        
        .nav-tabs .nav-item {
            flex: 1 !important;
            min-width: 0 !important;
            max-width: 20% !important;
        }
        
        .nav-tabs .nav-link {
            padding: 8px 3px !important;
            font-size: 0.75rem !important;
            min-height: 65px;
            width: 100% !important;
            overflow: hidden !important;
        }
        
        .nav-tabs .nav-link i {
            font-size: 1.1rem !important;
            margin-right: 0 !important;
            margin-bottom: 4px;
        }
        
        .nav-tabs .nav-link .tab-text {
            font-size: 0.7rem !important;
            display: block !important;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        /* Fix TinyMCE untuk mobile */
        .tox-tinymce {
            height: 250px !important;
            width: 100% !important;
            min-width: 100% !important;
            max-width: 100% !important;
        }
        
        .tox-tinymce iframe {
            width: 100% !important;
            max-width: 100% !important;
            min-width: 100% !important;
        }
        
        /* Mobile optimized TinyMCE toolbar */
        .tox .tox-toolbar__group {
            padding: 4px 6px !important;
        }
        
        .tox .tox-tbtn {
            width: 32px !important;
            height: 32px !important;
            min-width: 32px !important;
        }
        
        .card-footer .d-flex {
            flex-direction: column;
            gap: 10px;
        }
        
        .card-footer .btn {
            width: 100%;
            margin: 5px 0;
        }
    }
    
    @media (max-width: 576px) {
        .nav-tabs .nav-link {
            padding: 8px 2px !important;
            font-size: 0.65rem !important;
            min-height: 60px;
        }
        
        .nav-tabs .nav-link i {
            font-size: 1rem !important;
        }
        
        .nav-tabs .nav-link .tab-text {
            font-size: 0.65rem !important;
        }
        
        .nav-tabs .nav-item {
            min-width: 0 !important;
        }
        
        /* TinyMCE untuk screen kecil */
        .tox-tinymce {
            height: 200px !important;
            width: 100% !important;
        }
        
        .tox-tinymce iframe {
            width: 100% !important;
        }
        
        .card {
            margin-left: -10px;
            margin-right: -10px;
            border-radius: 0;
            border-left: none;
            border-right: none;
        }
        
        .card-header,
        .card-body,
        .card-footer {
            padding-left: 10px;
            padding-right: 10px;
        }
    }
    
    @media (max-width: 400px) {
        .nav-tabs .nav-link {
            padding: 8px 1px !important;
            font-size: 0.6rem !important;
            min-height: 55px;
        }
        
        .nav-tabs .nav-link i {
            font-size: 0.9rem !important;
        }
        
        .nav-tabs .nav-link .tab-text {
            font-size: 0.6rem !important;
        }
        
        /* TinyMCE untuk screen sangat kecil */
        .tox-tinymce {
            height: 180px !important;
            width: 100% !important;
        }
    }
    
    /* Fix for mobile view */
    .container-fluid {
        padding-left: 15px;
        padding-right: 15px;
    }
    
    @media (max-width: 576px) {
        .container-fluid {
            padding-left: 0;
            padding-right: 0;
        }
        
        .row {
            margin-left: 0;
            margin-right: 0;
        }
        
        .col-12, .col-lg-4, .col-lg-6, .col-md-6 {
            padding-left: 10px;
            padding-right: 10px;
        }
        
        /* Adjust spacing for mobile */
        .mb-4 {
            margin-bottom: 1rem !important;
        }
        
        .mt-4 {
            margin-top: 1rem !important;
        }
        
        /* Improve button sizing */
        .btn {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
        }
    }
    
    /* Mobile touch improvements */
    @media (hover: none) and (pointer: coarse) {
        .btn, .form-control, select, textarea {
            min-height: 44px; /* Minimum touch target size */
        }
        
        .tox-tinymce {
            min-height: 44px !important;
        }
        
        /* Better touch targets for mobile */
        .tox .tox-tbtn {
            min-width: 36px !important;
            min-height: 36px !important;
        }
        
        /* Prevent text selection on tap */
        .nav-tabs .nav-link {
            -webkit-tap-highlight-color: transparent;
            user-select: none;
        }
    }
    
    /* Prevent any scrollbars */
    html, body {
        overflow-x: hidden !important;
        max-width: 100% !important;
    }
    
    .card, .card-body {
        overflow: visible !important;
    }
</style>
@endpush

@push('scripts')
<script src="{{ asset('assets/js/tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script>
// Tunggu sampai TinyMCE siap
let tinyMCEInitialized = false;

// Notification Manager
const NotificationManager = {
    toast(icon, title, text = '', timer = 3000) {
        return Swal.fire({
            toast: true,
            position: 'top-end',
            icon: icon,
            title: title,
            text: text,
            showConfirmButton: false,
            timer: timer,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });
    },
    
    confirm(title, text, confirmText = 'Ya', cancelText = 'Tidak') {
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
    },
    
    success(title, text = '') {
        this.toast('success', title, text);
    },
    
    error(title, text = '') {
        this.toast('error', title, text, 4000);
    },
    
    warning(title, text = '') {
        this.toast('warning', title, text, 4000);
    }
};

// Loading Manager
const LoadingManager = {
    show(message = 'Menyimpan perubahan...') {
        const overlay = document.querySelector('.loading-overlay');
        const messageEl = overlay.querySelector('h5');
        if (messageEl) messageEl.textContent = message;
        overlay.style.display = 'flex';
    },
    
    hide() {
        const overlay = document.querySelector('.loading-overlay');
        overlay.style.display = 'none';
    }
};

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
                
                // Update current image preview if exists
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
                
                // Scroll to first invalid field
                if (isValid === false) {
                    const yOffset = -100;
                    const y = field.getBoundingClientRect().top + window.pageYOffset + yOffset;
                    
                    window.scrollTo({
                        top: y,
                        behavior: 'smooth'
                    });
                    
                    // Focus the field
                    if (field.classList.contains('tinymce-editor')) {
                        const editor = tinymce.get(field.id);
                        if (editor) editor.focus();
                    } else {
                        field.focus();
                    }
                }
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        return isValid;
    },
    
    clearValidation(form) {
        const invalidFields = form.querySelectorAll('.is-invalid');
        invalidFields.forEach(field => field.classList.remove('is-invalid'));
    }
};

// File Removal Handler
const FileRemovalHandler = {
    async remove(type, cardNumber = null) {
        let url = `/backend/visi-misi/remove-${type}-image`;
        let message = `Apakah Anda yakin ingin menghapus gambar ${type}?`;
        
        if (cardNumber) {
            url = `/backend/visi-misi/remove-card-image/${cardNumber}`;
            message = `Apakah Anda yakin ingin menghapus gambar kartu ${cardNumber}?`;
        }
        
        const result = await NotificationManager.confirm(
            'Hapus Gambar',
            message,
            'Ya, Hapus!'
        );
        
        if (result.isConfirmed) {
            LoadingManager.show('Menghapus gambar...');
            
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
                LoadingManager.hide();
                
                if (data.success) {
                    NotificationManager.success('Berhasil!', 'Gambar telah dihapus');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    NotificationManager.error('Gagal!', data.message || 'Gagal menghapus gambar');
                }
            } catch (error) {
                LoadingManager.hide();
                NotificationManager.error('Error!', 'Terjadi kesalahan saat menghapus gambar');
            }
        }
    }
};

// Initialize TinyMCE dengan konfigurasi yang SANGAT MINIMAL
const initTinyMCE = () => {
    if (tinyMCEInitialized) {
        console.log('TinyMCE already initialized, skipping...');
        return;
    }
    
    console.log('Initializing TinyMCE...');
    
    // Pastikan semua element editor ada
    const editorElements = document.querySelectorAll('.tinymce-editor');
    console.log('Found editor elements:', editorElements.length);
    
    if (editorElements.length === 0) {
        console.warn('No TinyMCE elements found');
        return;
    }
    
    // Deteksi jika mobile
    const isMobile = window.innerWidth <= 768;
    
    // Konfigurasi yang SANGAT MINIMAL untuk menghindari error
    const config = {
        selector: '.tinymce-editor',
        height: isMobile ? 250 : 350,
        menubar: !isMobile,
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'preview', 'anchor',
            'searchreplace', 'code', 'fullscreen', 'help', 'wordcount'
        ],
        toolbar: 'undo redo | bold italic | bullist numlist | link | removeformat | help',
        branding: false,
        promotion: false,
        content_style: `
            body { 
                font-family: Arial, sans-serif; 
                font-size: 14px; 
                line-height: 1.5; 
                color: #333; 
                margin: 8px;
                max-width: 100% !important;
            }
            p { margin: 0 0 10px; }
        `,
        setup: (editor) => {
            console.log('Setting up editor:', editor.id);
            
            // Simpan konten saat berubah
            editor.on('change', () => {
                editor.save();
            });
        }
    };
    
    // Tambahkan language config jika tersedia
    config.language = 'id';
    config.language_url = '{{ asset("assets/js/tinymce/langs/id.js") }}';
    
    // Coba inisialisasi TinyMCE hanya sekali
    try {
        tinymce.init(config);
        console.log('TinyMCE initialized successfully');
        tinyMCEInitialized = true;
    } catch (error) {
        console.error('Error initializing TinyMCE:', error);
        
        // Fallback: tampilkan textarea biasa
        editorElements.forEach(textarea => {
            textarea.style.display = 'block';
            textarea.style.width = '100%';
            textarea.style.minHeight = '200px';
            textarea.style.maxWidth = '100%';
        });
    }
};

// Function untuk setup tabs tanpa scroll
const setupTabs = () => {
    const navTabs = document.querySelector('.nav-tabs');
    if (navTabs) {
        // Pastikan tidak ada scroll
        navTabs.style.overflow = 'hidden';
        navTabs.style.overflowX = 'hidden';
        navTabs.style.overflowY = 'hidden';
        navTabs.style.flexWrap = 'nowrap';
        navTabs.style.justifyContent = 'space-between';
        
        // Atur lebar setiap item tab
        const navItems = navTabs.querySelectorAll('.nav-item');
        navItems.forEach(item => {
            item.style.flex = '1';
            item.style.minWidth = '0';
            item.style.textAlign = 'center';
        });
    }
};

// Main Application - HANYA SATU EVENT LISTENER
document.addEventListener('DOMContentLoaded', () => {
    console.log('DOM loaded, initializing...');
    
    // Setup tabs tanpa scroll
    setupTabs();
    
    // Initialize Bootstrap tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl, {
            trigger: 'hover focus',
            boundary: 'viewport'
        });
    });
    
    // Initialize image previews
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
    });
    
    document.getElementById('add-misi-item')?.addEventListener('click', () => {
        ListItemManager.addItem('misi-list-container', 'Masukkan poin misi...');
    });
    
    // Remove list item (event delegation)
    document.addEventListener('click', async (e) => {
        // Remove list items
        if (e.target.closest('.remove-list-item')) {
            const button = e.target.closest('.remove-list-item');
            const container = button.closest('[id$="-list-container"]');
            
            if (ListItemManager.removeItem(button)) {
                NotificationManager.success('Berhasil!', 'Poin telah dihapus');
            } else {
                NotificationManager.warning('Peringatan', 'Minimal harus ada satu poin!');
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
    
    // Form submission
    document.getElementById('visiMisiForm')?.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        // Clear previous validation
        FormValidator.clearValidation(e.target);
        
        // Validate form
        if (!FormValidator.validate(e.target)) {
            NotificationManager.error('Form tidak lengkap!', 'Harap lengkapi semua field yang wajib diisi.');
            return;
        }
        
        // Confirm submission
        const result = await NotificationManager.confirm(
            'Simpan Perubahan',
            'Apakah Anda yakin ingin menyimpan semua perubahan?',
            'Ya, Simpan!'
        );
        
        if (result.isConfirmed) {
            submitForm(e.target);
        }
    });
    
    // Reset form button
    document.getElementById('resetFormBtn')?.addEventListener('click', async (e) => {
        e.preventDefault();
        
        const result = await NotificationManager.confirm(
            'Reset Form',
            'Apakah Anda yakin ingin mereset form? Semua perubahan yang belum disimpan akan hilang.',
            'Ya, Reset!'
        );
        
        if (result.isConfirmed) {
            resetForm();
            NotificationManager.success('Berhasil!', 'Form telah direset');
        }
    });
    
    // Form submission function
    const submitForm = async (form) => {
        LoadingManager.show();
        
        try {
            // Save all TinyMCE content before form submission
            if (typeof tinymce !== 'undefined' && tinyMCEInitialized) {
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
            
            const result = await response.json();
            LoadingManager.hide();
            
            if (response.ok && result.success) {
                NotificationManager.success('Berhasil!', 'Data berhasil disimpan');
                setTimeout(() => location.reload(), 1500);
            } else {
                NotificationManager.error('Gagal!', result.message || 'Gagal menyimpan data');
                
                // Display validation errors if any
                if (result.errors) {
                    Object.keys(result.errors).forEach(field => {
                        const input = form.querySelector(`[name="${field}"]`);
                        if (input) {
                            input.classList.add('is-invalid');
                        }
                    });
                }
            }
        } catch (error) {
            LoadingManager.hide();
            NotificationManager.error('Error!', 'Terjadi kesalahan saat menyimpan data');
        }
    };
    
    // Form reset function
    const resetForm = () => {
        const form = document.getElementById('visiMisiForm');
        if (!form) return;
        
        form.reset();
        FormValidator.clearValidation(form);
        
        // Reset TinyMCE editors
        if (typeof tinymce !== 'undefined' && tinyMCEInitialized) {
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
        
        // Reset file inputs
        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.value = '';
        });
    };
    
    // Store original image sources
    document.querySelectorAll('#current-visi-image, #current-misi-image, #current-hero-image').forEach(img => {
        if (img) {
            img.dataset.originalSrc = img.src;
        }
    });
    
    // Initialize TinyMCE - HANYA SEKALI dengan timeout cukup
    setTimeout(() => {
        console.log('Initializing TinyMCE...');
        initTinyMCE();
    }, 300);
    
    // Re-initialize TinyMCE on window resize - tanpa flag reset
    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            console.log('Window resized, checking TinyMCE...');
            // Cek jika TinyMCE perlu di-reinit
            const editors = document.querySelectorAll('.tinymce-editor');
            const hasTinyMCE = editors.length > 0 && typeof tinymce !== 'undefined';
            
            if (hasTinyMCE && tinyMCEInitialized) {
                // TinyMCE sudah berjalan, cukup setup tabs
                setupTabs();
            } else if (hasTinyMCE) {
                // TinyMCE belum berjalan, init
                initTinyMCE();
                setupTabs();
            }
        }, 500);
    });
});

// Handle session messages
@if(session('success'))
document.addEventListener('DOMContentLoaded', () => {
    NotificationManager.success('Berhasil!', '{{ session('success') }}');
});
@endif

@if(session('error'))
document.addEventListener('DOMContentLoaded', () => {
    NotificationManager.error('Error!', '{{ session('error') }}');
});
@endif

@if($errors->any())
document.addEventListener('DOMContentLoaded', () => {
    NotificationManager.warning('Validasi Gagal', 'Mohon periksa kembali form Anda');
});
@endif

// Fallback jika TinyMCE tidak ada
document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
        if (typeof tinymce === 'undefined') {
            console.warn('TinyMCE not loaded, using textarea fallback');
            document.querySelectorAll('.tinymce-editor').forEach(textarea => {
                textarea.style.display = 'block';
                textarea.style.width = '100%';
                textarea.style.minHeight = '200px';
                textarea.style.maxWidth = '100%';
            });
        }
    }, 3000);
});
</script>
@endpush
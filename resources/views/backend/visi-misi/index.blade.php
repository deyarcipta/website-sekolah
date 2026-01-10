@extends('layouts.backend')

@section('title', 'Visi & Misi - Dashboard Admin')

@section('content')
<div class="container-fluid px-4">
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
        <!-- Tabs in Single Line -->
        <div class="card-header bg-white px-0 pt-0 pb-3 border-bottom">
            <div class="d-flex align-items-center" style="overflow-x: auto; white-space: nowrap;">
                <ul class="nav nav-tabs nav-fill flex-nowrap" id="visiMisiTab" role="tablist" style="min-width: 100%;">
                    <li class="nav-item" role="presentation" style="flex: 1;">
                        <button class="nav-link active" id="paragraf-tab" data-bs-toggle="tab" data-bs-target="#paragraf">
                            <i class="fas fa-paragraph me-2"></i> Paragraf Pembuka
                        </button>
                    </li>
                    <li class="nav-item" role="presentation" style="flex: 1;">
                        <button class="nav-link" id="kartu-tab" data-bs-toggle="tab" data-bs-target="#kartu">
                            <i class="fas fa-images me-2"></i> 3 Kartu Unggulan
                        </button>
                    </li>
                    <li class="nav-item" role="presentation" style="flex: 1;">
                        <button class="nav-link" id="visi-tab" data-bs-toggle="tab" data-bs-target="#visi">
                            <i class="fas fa-eye me-2"></i> Visi Sekolah
                        </button>
                    </li>
                    <li class="nav-item" role="presentation" style="flex: 1;">
                        <button class="nav-link" id="misi-tab" data-bs-toggle="tab" data-bs-target="#misi">
                            <i class="fas fa-bullseye me-2"></i> Misi Sekolah
                        </button>
                    </li>
                    <li class="nav-item" role="presentation" style="flex: 1;">
                        <button class="nav-link" id="hero-tab" data-bs-toggle="tab" data-bs-target="#hero">
                            <i class="fas fa-image me-2"></i> Background Hero
                        </button>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Main Form -->
        <form action="{{ route('backend.visi-misi.store') }}" method="POST" id="visiMisiForm" enctype="multipart/form-data">
            @csrf
            
            <!-- Tab Content -->
            <div class="card-body bg-light">
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
                                    <div class="bg-white border rounded p-4">
                                        <div class="text-center" style="font-size: 18px; line-height: 1.6;">
                                            {{ $visiMisi->opening_paragraph }}
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
                                        <div class="form-group mb-4">
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
                                            <div class="input-group">
                                                <input type="file" 
                                                       class="form-control" 
                                                       name="card{{ $i }}_image" 
                                                       accept="image/*">
                                                <button class="btn btn-outline-secondary" type="button">
                                                    <i class="fas fa-upload"></i>
                                                </button>
                                            </div>
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
                            <div class="bg-white border rounded p-4">
                                <div class="row g-3">
                                    @for($i = 1; $i <= 3; $i++)
                                    <div class="col-12 col-md-{{ $i == 3 ? '6' : '3' }}">
                                        <div class="position-relative rounded overflow-hidden shadow-sm" 
                                             style="height: 120px; background: linear-gradient(45deg, #f8f9fa, #e9ecef);">
                                            <div class="position-absolute w-100 h-100 d-flex align-items-center justify-content-center" 
                                                 style="background: rgba(107, 2, 177, 0.7);">
                                                <span class="text-white fw-bold">{{ $visiMisi->{"card{$i}_label"} }}</span>
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
                                        <div class="form-group mb-4">
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
                                        <div class="form-group mb-4">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-align-left me-2"></i> Deskripsi (Teks Tebal) <span class="text-danger">*</span>
                                            </label>
                                            <textarea class="form-control tinymce-editor" 
                                                      name="visi_description" 
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
                                                         style="max-height: 250px;">
                                                    @if($visiMisi->visi_image)
                                                    <div class="position-absolute top-0 end-0 mt-2 me-2">
                                                        <button type="button" 
                                                                class="btn btn-sm btn-danger" 
                                                                id="remove-visi-image">
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
                                            <div class="input-group">
                                                <input type="file" 
                                                       class="form-control" 
                                                       name="visi_image" 
                                                       accept="image/*">
                                                <button class="btn btn-outline-secondary" type="button">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
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
                                                 class="border rounded p-3 text-center" 
                                                 style="min-height: 200px; background: linear-gradient(45deg, #f8f9fa, #e9ecef); display: flex; align-items: center; justify-content: center; flex-direction: column;">
                                                <i class="fas fa-image fa-3x text-muted mb-3"></i>
                                                <p class="text-muted mb-0">Gambar akan muncul di sini setelah dipilih</p>
                                                <small class="text-muted mt-2">Drag & drop atau klik untuk memilih</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Preview Visi di Frontend -->
                        <div class="mt-4">
                            <label class="form-label fw-bold mb-3">
                                <i class="fas fa-desktop me-2"></i> Preview Frontend Visi
                            </label>
                            <div class="bg-white border rounded p-4">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <div class="position-relative p-3" style="background: #f8f9fa; border-radius: 10px;">
                                            <div style="height: 200px; background: #ddd; border-radius: 5px;"></div>
                                            <div class="position-absolute top-0 start-0 m-3 bg-success" style="width: 40px; height: 40px; border-radius: 5px;"></div>
                                            <div class="position-absolute bottom-0 end-0 m-3 bg-primary" style="width: 50px; height: 50px; border-radius: 50%;"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h4 class="text-purple">{{ $visiMisi->visi_title }}</h4>
                                        <p class="fw-bold">{{ Str::limit($visiMisi->visi_description, 100) }}</p>
                                        <ul class="list-unstyled">
                                            @foreach(array_slice($visiItems, 0, 2) as $item)
                                            <li class="mb-2">
                                                <i class="fas fa-check-circle text-success me-2"></i>
                                                {{ Str::limit($item, 50) }}
                                            </li>
                                            @endforeach
                                        </ul>
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
                                        <div class="form-group mb-4">
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
                                        <div class="form-group mb-4">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-align-left me-2"></i> Deskripsi (Teks Tebal) <span class="text-danger">*</span>
                                            </label>
                                            <textarea class="form-control tinymce-editor" 
                                                      name="misi_description" 
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
                                                         style="max-height: 250px;">
                                                    @if($visiMisi->misi_image)
                                                    <div class="position-absolute top-0 end-0 mt-2 me-2">
                                                        <button type="button" 
                                                                class="btn btn-sm btn-danger" 
                                                                id="remove-misi-image">
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
                                            <div class="input-group">
                                                <input type="file" 
                                                       class="form-control" 
                                                       name="misi_image" 
                                                       accept="image/*">
                                                <button class="btn btn-outline-secondary" type="button">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
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
                                                 class="border rounded p-3 text-center" 
                                                 style="min-height: 200px; background: linear-gradient(45deg, #f8f9fa, #e9ecef); display: flex; align-items: center; justify-content: center; flex-direction: column;">
                                                <i class="fas fa-image fa-3x text-muted mb-3"></i>
                                                <p class="text-muted mb-0">Gambar akan muncul di sini setelah dipilih</p>
                                                <small class="text-muted mt-2">Drag & drop atau klik untuk memilih</small>
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
                                        <div class="form-group mb-4">
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
                                                         style="max-height: 200px; width: 100%; object-fit: cover;">
                                                    @if($visiMisi->hero_background)
                                                    <div class="position-absolute top-0 end-0 mt-2 me-2">
                                                        <button type="button" 
                                                                class="btn btn-sm btn-danger" 
                                                                id="remove-hero-background">
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
                                            <div class="input-group">
                                                <input type="file" 
                                                       class="form-control" 
                                                       name="hero_background" 
                                                       accept="image/*">
                                                <button class="btn btn-outline-secondary" type="button">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
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
                                        <div class="alert alert-light border mb-4">
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
                                                <div class="position-relative" style="height: 180px; overflow: hidden; background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('{{ $visiMisi->getHeroBackgroundUrl() }}'); background-size: cover; background-position: center;">
                                                    <div style="position: absolute; inset: 0; background: rgba(169, 72, 234, 0.7);"></div>
                                                    <div class="position-absolute top-50 start-50 translate-middle text-center text-white w-100 px-3">
                                                        <h3 class="mb-2 fw-bold">{{ $visiMisi->hero_title }}</h3>
                                                        <p class="mb-0 opacity-75">Halaman Visi & Misi</p>
                                                    </div>
                                                </div>
                                                <div class="bg-white p-3 border-top">
                                                    <small class="text-muted">
                                                        <i class="fas fa-info-circle me-1"></i>
                                                        Ini adalah preview bagaimana hero akan ditampilkan di frontend
                                                    </small>
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
                        <span class="text-muted">
                            <i class="fas fa-exclamation-circle me-2"></i> Pastikan semua data sudah benar sebelum menyimpan
                        </span>
                    </div>
                    <div>
                        <button type="reset" class="btn btn-outline-secondary me-3" form="visiMisiForm">
                            <i class="fas fa-redo me-1"></i> Reset Form
                        </button>
                        <button type="submit" class="btn btn-primary px-4" form="visiMisiForm">
                            <i class="fas fa-save me-1"></i> Simpan Semua Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Loading Overlay -->
<div class="loading-overlay">
    <div class="text-center">
        <div class="spinner-border text-primary mb-3" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
        <h5 class="text-muted">Menyimpan perubahan...</h5>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Warna kustom */
    .bg-purple {
        background-color: #6b02b1 !important;
    }
    
    .text-purple {
        color: #6b02b1 !important;
    }
    
    /* Tabs styling untuk satu line */
    .nav-tabs {
        border-bottom: none;
        flex-wrap: nowrap;
    }
    
    .nav-tabs .nav-link {
        color: #495057;
        font-weight: 500;
        border: none;
        border-radius: 8px 8px 0 0;
        padding: 12px 16px;
        transition: all 0.3s ease;
        white-space: nowrap;
        margin: 0 2px;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-bottom: none;
    }
    
    .nav-tabs .nav-link:hover {
        color: #6b02b1;
        background-color: rgba(107, 2, 177, 0.1);
    }
    
    .nav-tabs .nav-link.active {
        color: #6b02b1;
        background-color: white;
        border-color: #dee2e6 #dee2e6 white;
        font-weight: 600;
        position: relative;
    }
    
    .nav-tabs .nav-link.active:after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        right: 0;
        height: 2px;
        background-color: #6b02b1;
    }
    
    /* Scroll horizontal untuk tabs */
    .card-header .d-flex {
        overflow-x: auto;
        -ms-overflow-style: none;
        scrollbar-width: none;
        padding-bottom: 3px;
    }
    
    .card-header .d-flex::-webkit-scrollbar {
        display: none;
    }
    
    /* Card styling */
    .card {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    
    .card-header.bg-white {
        padding: 1rem 1.5rem 0 1.5rem;
    }
    
    /* Tab content background */
    .tab-content {
        min-height: 500px;
    }
    
    .tab-pane {
        padding: 20px 0;
    }
    
    /* TinyMCE styling */
    .tox-tinymce {
        border-radius: 8px !important;
        border: 1px solid #ced4da !important;
        transition: border-color 0.3s ease;
    }
    
    .tox-tinymce:focus-within {
        border-color: #6b02b1 !important;
        box-shadow: 0 0 0 0.2rem rgba(107, 2, 177, 0.25) !important;
    }
    
    /* Loading overlay */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        display: none;
        backdrop-filter: blur(5px);
    }
    
    /* Image preview placeholder */
    .image-preview-placeholder {
        background: linear-gradient(45deg, #f8f9fa, #e9ecef);
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        padding: 2.5rem;
        text-align: center;
        color: #6c757d;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .image-preview-placeholder:hover {
        border-color: #6b02b1;
        background: linear-gradient(45deg, #f8f9fa, #f0f4ff);
    }
    
    /* Button styling */
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
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .nav-tabs .nav-link {
            padding: 10px 12px;
            font-size: 0.85rem;
        }
        
        .nav-tabs .nav-link i {
            margin-right: 5px;
        }
        
        .card-footer .d-flex {
            flex-direction: column;
            gap: 10px;
        }
        
        .card-footer .btn {
            width: 100%;
            margin: 5px 0;
        }
        
        .card-header h1 {
            font-size: 1.5rem;
        }
    }
    
    @media (max-width: 576px) {
        .nav-tabs .nav-link span {
            display: none;
        }
        
        .nav-tabs .nav-link i {
            margin-right: 0;
        }
        
        .nav-tabs .nav-link {
            padding: 10px;
        }
    }
</style>
@endpush

@push('scripts')
<script src="{{ asset('assets/js/tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script>
    // Initialize TinyMCE for all textareas with class 'tinymce-editor'
    tinymce.init({
        selector: '.tinymce-editor',
        height: 300,
        menubar: true,
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'table', 'help', 'wordcount', 'emoticons'
        ],
        toolbar: 'undo redo | formatselect | bold italic underline strikethrough | ' +
                 'alignleft aligncenter alignright alignjustify | ' +
                 'bullist numlist outdent indent | link table emoticons | ' +
                 'removeformat | help | code',
        language: 'id',
        language_url: '{{ asset("assets/js/tinymce/langs/id.js") }}',
        promotion: false,
        branding: false,
        content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; font-size: 16px; line-height: 1.6; color: #212529; }' +
                      'h1, h2, h3, h4, h5, h6 { color: #6b02b1; margin-top: 1rem; }' +
                      'p { margin-bottom: 1rem; }',
        
        setup: function (editor) {
            editor.on('change', function () {
                editor.save();
            });
        }
    });
    
    // Loading overlay function
    function showLoading(message = 'Menyimpan perubahan...') {
        const overlay = document.querySelector('.loading-overlay');
        if (overlay) {
            overlay.querySelector('h5').textContent = message;
            overlay.style.display = 'flex';
        }
    }
    
    function hideLoading() {
        const overlay = document.querySelector('.loading-overlay');
        if (overlay) {
            overlay.style.display = 'none';
        }
    }
    
    // Show SweetAlert notification
    function showSwal(icon, title, text, timer = null) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: timer || 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
        
        Toast.fire({
            icon: icon,
            title: title,
            text: text
        });
    }
    
    // Confirm dialog with SweetAlert
    function confirmDialog(title, text, confirmButtonText = 'Ya', cancelButtonText = 'Tidak') {
        return Swal.fire({
            title: title,
            text: text,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#6b02b1',
            cancelButtonColor: '#6c757d',
            confirmButtonText: confirmButtonText,
            cancelButtonText: cancelButtonText,
            reverseButtons: true
        });
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        // Function to preview image
        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewElement = document.getElementById(previewId);
                    previewElement.innerHTML = `
                        <div class="text-center">
                            <img src="${e.target.result}" class="img-fluid rounded shadow" style="max-height: 180px;">
                            <p class="text-success small mt-2">
                                <i class="fas fa-check-circle me-1"></i> Gambar siap diupload
                            </p>
                        </div>
                    `;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        // Visi image preview
        const visiImageInput = document.querySelector('input[name="visi_image"]');
        if (visiImageInput) {
            visiImageInput.addEventListener('change', function() {
                previewImage(this, 'visi-image-preview');
            });
        }
        
        // Misi image preview
        const misiImageInput = document.querySelector('input[name="misi_image"]');
        if (misiImageInput) {
            misiImageInput.addEventListener('change', function() {
                previewImage(this, 'misi-image-preview');
            });
        }
        
        // Card image previews
        for (let i = 1; i <= 3; i++) {
            const cardInput = document.querySelector(`input[name="card${i}_image"]`);
            if (cardInput) {
                cardInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const currentImageDiv = this.closest('.form-group').querySelector('.current-image img');
                            if (currentImageDiv) {
                                currentImageDiv.src = e.target.result;
                            }
                        }
                        reader.readAsDataURL(file);
                    }
                });
            }
        }
        
        // Hero background preview
        const heroBackgroundInput = document.querySelector('input[name="hero_background"]');
        if (heroBackgroundInput) {
            heroBackgroundInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const currentImageDiv = document.querySelector('.current-image img');
                        if (currentImageDiv) {
                            currentImageDiv.src = e.target.result;
                        }
                    }
                    reader.readAsDataURL(file);
                }
            });
        }
        
        // Add list item functionality for Visi
        document.getElementById('add-visi-item').addEventListener('click', function() {
            const container = document.getElementById('visi-list-container');
            const index = container.children.length;
            
            const div = document.createElement('div');
            div.className = 'input-group mb-2';
            div.innerHTML = `
                <span class="input-group-text bg-light border">${index + 1}</span>
                <input type="text" class="form-control" name="visi_items[]" placeholder="Masukkan poin visi..." required>
                <button type="button" class="btn btn-outline-danger remove-list-item" data-target="visi">
                    <i class="fas fa-trash"></i>
                </button>
            `;
            container.appendChild(div);
        });
        
        // Add list item functionality for Misi
        document.getElementById('add-misi-item').addEventListener('click', function() {
            const container = document.getElementById('misi-list-container');
            const index = container.children.length;
            
            const div = document.createElement('div');
            div.className = 'input-group mb-2';
            div.innerHTML = `
                <span class="input-group-text bg-light border">${index + 1}</span>
                <input type="text" class="form-control" name="misi_items[]" placeholder="Masukkan poin misi..." required>
                <button type="button" class="btn btn-outline-danger remove-list-item" data-target="misi">
                    <i class="fas fa-trash"></i>
                </button>
            `;
            container.appendChild(div);
        });
        
        // Remove list item functionality (delegation)
        document.addEventListener('click', async function(e) {
            if (e.target.closest('.remove-list-item')) {
                const button = e.target.closest('.remove-list-item');
                const container = button.closest('[id$="-list-container"]');
                const inputGroup = button.closest('.input-group');
                
                if (inputGroup && container.children.length > 1) {
                    const result = await confirmDialog(
                        'Hapus Poin',
                        'Apakah Anda yakin ingin menghapus poin ini?',
                        'Ya, Hapus!'
                    );
                    
                    if (result.isConfirmed) {
                        inputGroup.remove();
                        
                        // Re-number the remaining items
                        const items = container.querySelectorAll('.input-group');
                        items.forEach((item, index) => {
                            item.querySelector('.input-group-text').textContent = index + 1;
                        });
                        
                        showSwal('success', 'Berhasil!', 'Poin telah dihapus');
                    }
                } else if (container.children.length === 1) {
                    showSwal('warning', 'Peringatan', 'Minimal harus ada satu poin!', 4000);
                }
            }
        });
        
        // Remove card image with SweetAlert
        document.querySelectorAll('.remove-card-image').forEach(button => {
            button.addEventListener('click', async function() {
                const cardNumber = this.getAttribute('data-card');
                
                const result = await confirmDialog(
                    'Hapus Gambar Kartu',
                    `Apakah Anda yakin ingin menghapus gambar kartu ${cardNumber}?`,
                    'Ya, Hapus!'
                );
                
                if (result.isConfirmed) {
                    showLoading('Menghapus gambar...');
                    
                    try {
                        const response = await fetch(`/backend/visi-misi/remove-card-image/${cardNumber}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            }
                        });
                        
                        const data = await response.json();
                        hideLoading();
                        
                        if (data.success) {
                            showSwal('success', 'Berhasil!', 'Gambar kartu telah dihapus');
                            setTimeout(() => location.reload(), 1500);
                        } else {
                            showSwal('error', 'Gagal!', 'Gagal menghapus gambar');
                        }
                    } catch (error) {
                        hideLoading();
                        showSwal('error', 'Error!', 'Terjadi kesalahan saat menghapus gambar');
                    }
                }
            });
        });
        
        // Remove visi image with SweetAlert
        document.getElementById('remove-visi-image').addEventListener('click', async function() {
            const result = await confirmDialog(
                'Hapus Gambar Visi',
                'Apakah Anda yakin ingin menghapus gambar visi?',
                'Ya, Hapus!'
            );
            
            if (result.isConfirmed) {
                showLoading('Menghapus gambar...');
                
                try {
                    const response = await fetch('/backend/visi-misi/remove-visi-image', {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    });
                    
                    const data = await response.json();
                    hideLoading();
                    
                    if (data.success) {
                        showSwal('success', 'Berhasil!', 'Gambar visi telah dihapus');
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        showSwal('error', 'Gagal!', 'Gagal menghapus gambar visi');
                    }
                } catch (error) {
                    hideLoading();
                    showSwal('error', 'Error!', 'Terjadi kesalahan saat menghapus gambar');
                }
            }
        });
        
        // Remove misi image with SweetAlert
        document.getElementById('remove-misi-image').addEventListener('click', async function() {
            const result = await confirmDialog(
                'Hapus Gambar Misi',
                'Apakah Anda yakin ingin menghapus gambar misi?',
                'Ya, Hapus!'
            );
            
            if (result.isConfirmed) {
                showLoading('Menghapus gambar...');
                
                try {
                    const response = await fetch('/backend/visi-misi/remove-misi-image', {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    });
                    
                    const data = await response.json();
                    hideLoading();
                    
                    if (data.success) {
                        showSwal('success', 'Berhasil!', 'Gambar misi telah dihapus');
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        showSwal('error', 'Gagal!', 'Gagal menghapus gambar misi');
                    }
                } catch (error) {
                    hideLoading();
                    showSwal('error', 'Error!', 'Terjadi kesalahan saat menghapus gambar');
                }
            }
        });
        
        // Remove hero background with SweetAlert
        document.getElementById('remove-hero-background').addEventListener('click', async function() {
            const result = await confirmDialog(
                'Hapus Background Hero',
                'Apakah Anda yakin ingin menghapus background hero?',
                'Ya, Hapus!'
            );
            
            if (result.isConfirmed) {
                showLoading('Menghapus background...');
                
                try {
                    const response = await fetch('/backend/visi-misi/remove-hero-background', {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    });
                    
                    const data = await response.json();
                    hideLoading();
                    
                    if (data.success) {
                        showSwal('success', 'Berhasil!', 'Background hero telah dihapus');
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        showSwal('error', 'Gagal!', 'Gagal menghapus background');
                    }
                } catch (error) {
                    hideLoading();
                    showSwal('error', 'Error!', 'Terjadi kesalahan saat menghapus background');
                }
            }
        });
        
        // Form submission with validation
        document.getElementById('visiMisiForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // Basic validation
            let isValid = true;
            const requiredFields = this.querySelectorAll('[required]');
            
            requiredFields.forEach(field => {
                if (!field.value.trim() && field.type !== 'file') {
                    isValid = false;
                    field.classList.add('is-invalid');
                    
                    if (isValid === false) {
                        field.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            
            // Check TinyMCE content
            const tinymceEditors = document.querySelectorAll('.tinymce-editor');
            tinymceEditors.forEach(editor => {
                const content = tinymce.get(editor.id)?.getContent().trim();
                if (!content) {
                    isValid = false;
                }
            });
            
            if (!isValid) {
                showSwal('error', 'Form tidak lengkap!', 'Harap lengkapi semua field yang wajib diisi.', 4000);
                return false;
            }
            
            // Show confirmation dialog before submitting
            const result = await confirmDialog(
                'Simpan Perubahan',
                'Apakah Anda yakin ingin menyimpan semua perubahan?',
                'Ya, Simpan!'
            );
            
            if (result.isConfirmed) {
                showLoading('Menyimpan perubahan...');
                
                // Submit form programmatically
                const formData = new FormData(this);
                
                try {
                    const response = await fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });
                    
                    const result = await response.json();
                    hideLoading();
                    
                    if (response.ok && result.success) {
                        showSwal('success', 'Berhasil!', 'Data berhasil disimpan');
                        
                        // Reload page after success
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    } else {
                        showSwal('error', 'Gagal!', result.message || 'Gagal menyimpan data', 4000);
                    }
                } catch (error) {
                    hideLoading();
                    showSwal('error', 'Error!', 'Terjadi kesalahan saat menyimpan data', 4000);
                }
            }
        });
        
        // Form reset handler with SweetAlert
        document.querySelector('button[type="reset"]').addEventListener('click', async function(e) {
            e.preventDefault();
            
            const result = await confirmDialog(
                'Reset Form',
                'Apakah Anda yakin ingin mereset form? Semua perubahan yang belum disimpan akan hilang.',
                'Ya, Reset!'
            );
            
            if (result.isConfirmed) {
                // Reset TinyMCE editors
                const tinymceEditors = document.querySelectorAll('.tinymce-editor');
                tinymceEditors.forEach(editor => {
                    tinymce.get(editor.id).setContent('');
                });
                
                // Reset file inputs
                const fileInputs = document.querySelectorAll('input[type="file"]');
                fileInputs.forEach(input => {
                    input.value = '';
                });
                
                // Reset image previews
                const previews = document.querySelectorAll('[id$="-image-preview"]');
                previews.forEach(preview => {
                    preview.innerHTML = `
                        <div class="text-center">
                            <i class="fas fa-image fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">Gambar akan muncul di sini setelah dipilih</p>
                            <small class="text-muted mt-2">Drag & drop atau klik untuk memilih</small>
                        </div>
                    `;
                });
                
                // Reset form
                document.getElementById('visiMisiForm').reset();
                
                showSwal('success', 'Berhasil!', 'Form telah direset');
            }
        });
    });
</script>
@endpush

{{-- SESSION ALERTS --}}
@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        showConfirmButton: false,
        timer: 3000
    });
});
</script>
@endif

@if(session('error'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: '{{ session('error') }}',
        confirmButtonText: 'OK'
    });
});
</script>
@endif
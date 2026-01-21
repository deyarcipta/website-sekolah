@extends('layouts.backend')

@section('title', 'Kelola Berita - Dashboard Admin')

@section('content')
    <!-- Header Card -->
    <div class="card shadow mb-4 border-0">
        <div class="card-body py-4">
            <div class="d-flex justify-content-between align-items-center page-header">
                <div>
                    <h1 class="h3 text-gray-800 mb-1">
                        <i class="fas fa-newspaper me-2"></i> Kelola Berita
                    </h1>
                    <p class="text-muted mb-0">Kelola berita yang akan ditampilkan di website</p>
                </div>
                <div>
                    <button type="button" class="btn btn-primary" id="btnTambah">
                        <i class="fas fa-plus me-1"></i> Tambah Berita
                    </button>
                    <a href="{{ url('/berita') }}" target="_blank" class="btn btn-outline-info">
                        <i class="fas fa-external-link-alt me-1"></i> Lihat di Frontend
                    </a>
                </div>
            </div>
            
            <!-- Stats Row -->
            <div class="row mt-4">
                <div class="col-md-3 col-sm-6">
                    <div class="card border-0 bg-primary bg-opacity-10">
                        <div class="card-body py-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-newspaper fa-2x text-white"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="mb-0">{{ $totalBerita }}</h5>
                                    <small class="text-white">Total Berita</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="card border-0 bg-success bg-opacity-10">
                        <div class="card-body py-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-check-circle fa-2x text-white"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="mb-0">{{ $publishedCount }}</h5>
                                    <small class="text-white">Published</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="card border-0 bg-warning bg-opacity-10">
                        <div class="card-body py-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-edit fa-2x text-white"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="mb-0">{{ $draftCount }}</h5>
                                    <small class="text-white">Draft</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="card border-0 bg-secondary bg-opacity-10">
                        <div class="card-body py-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-archive fa-2x text-white"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="mb-0">{{ $archivedCount }}</h5>
                                    <small class="text-white">Arsip</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card shadow mb-4 border-0">
        <div class="card-body">
            <form action="{{ route('backend.berita.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Cari Berita</label>
                    <input type="text" class="form-control" name="search" placeholder="Judul, konten, atau penulis..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Kategori</label>
                    <select class="form-select" name="kategori">
                        <option value="">Semua Kategori</option>
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>
                                {{ $kat->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Status</label>
                    <select class="form-select" name="status">
                        <option value="">Semua Status</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Arsip</option>
                        <option value="featured" {{ request('status') == 'featured' ? 'selected' : '' }}>Featured</option>
                        <option value="headline" {{ request('status') == 'headline' ? 'selected' : '' }}>Headline</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Main Card -->
    <div class="card shadow-lg border-0 rounded-5 overflow-hidden">
        <div class="card-body p-0">
            @if($berita->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada berita</h5>
                    <p class="text-muted">Mulai dengan menambahkan berita baru</p>
                    <button type="button" class="btn btn-primary" id="btnTambahEmpty">
                        <i class="fas fa-plus me-1"></i> Tambah Berita Pertama
                    </button>
                </div>
            @else
                <!-- PERBAIKAN 2: Tambahkan wrapper untuk scroll horizontal yang tepat -->
                <div class="table-responsive" style="overflow-x: auto; max-height: 70vh; min-width: 100%;">
                    <table class="table table-hover mb-0" style="min-width: 1200px;">
                        <thead class="bg-light" style="position: sticky; top: 0; z-index: 10; background: #f8f9fa;">
                            <tr>
                                <th class="ps-4" width="50">#</th>
                                <th class="ps-3" width="100">Gambar</th>
                                <th width="400">Judul & Konten</th>
                                <th width="120">Kategori</th>
                                <th width="150">Status</th>
                                <th width="100">Statistik</th>
                                <th width="100" class="text-center">Urutan</th>
                                <th width="220" class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="sortable-table" id="sortableTable">
                            @foreach($berita as $item)
                                <tr data-id="{{ $item->id }}">
                                    <td class="ps-4">
                                        <i class="fas fa-arrows-alt handle text-secondary me-2"></i>
                                        {{ ($berita->currentPage() - 1) * $berita->perPage() + $loop->iteration }}
                                    </td>
                                    <td class="ps-3">
                                        <div class="image-wrapper">
                                            <img src="{{ $item->gambar_thumbnail ? asset('storage/' . $item->gambar_thumbnail) : ($item->gambar ? asset('storage/' . $item->gambar) : asset('assets/img/default-news.jpg')) }}" 
                                                 alt="{{ $item->judul }}"
                                                 class="rounded"
                                                 style="width: 80px; height: 60px; object-fit: cover;">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column" style="max-height: 100px; overflow: hidden;">
                                            <strong class="text-dark">{{ Str::limit($item->judul, 60) }}</strong>
                                            <small class="text-muted mt-1">
                                                {{ Str::limit(strip_tags($item->ringkasan ?: $item->konten), 100) }}
                                            </small>
                                            <div class="mt-2">
                                                <small class="text-muted">
                                                    <i class="fas fa-user me-1"></i> {{ $item->penulis ?? 'Admin' }}
                                                    <i class="fas fa-calendar ms-2 me-1"></i> {{ $item->tanggal_publish }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($item->kategori)
                                            <span class="badge bg-info bg-opacity-10">
                                                {{ $item->kategori->nama }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary bg-opacity-10">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column gap-1">
                                            <span class="badge bg-{{ $item->is_published ? 'success' : 'warning' }}">
                                                {{ $item->is_published ? 'Published' : 'Draft' }}
                                            </span>
                                            @if($item->is_featured)
                                                <span class="badge bg-primary">Featured</span>
                                            @endif
                                            @if($item->is_headline)
                                                <span class="badge bg-danger">Headline</span>
                                            @endif
                                            @if($item->archived_at)
                                                <span class="badge bg-secondary">Arsip</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column small">
                                            <div>
                                                <i class="fas fa-eye text-info me-1"></i> {{ $item->views }}
                                            </div>
                                            <div>
                                                <i class="fas fa-heart text-danger me-1"></i> {{ $item->likes }}
                                            </div>
                                            <div>
                                                <i class="fas fa-share text-success me-1"></i> {{ $item->shares }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-secondary">{{ $item->urutan }}</span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <!-- Tombol Edit -->
                                            <button type="button" 
                                                    class="btn btn-outline-primary btn-edit"
                                                    data-id="{{ $item->id }}"
                                                    title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            
                                            <!-- Tombol untuk berita yang dipublikasi dan tidak diarsip -->
                                            @if($item->is_published && !$item->archived_at)
                                                <!-- Tombol Featured -->
                                                @if(!$item->is_featured)
                                                    <button type="button" 
                                                            class="btn btn-outline-warning btn-status"
                                                            data-id="{{ $item->id }}"
                                                            data-status="featured"
                                                            title="Jadikan Featured">
                                                        <i class="fas fa-star"></i>
                                                    </button>
                                                @else
                                                    <button type="button" 
                                                            class="btn btn-warning btn-status"
                                                            data-id="{{ $item->id }}"
                                                            data-status="featured"
                                                            title="Hapus Featured">
                                                        <i class="fas fa-star"></i>
                                                    </button>
                                                @endif
                                                
                                                <!-- Tombol Headline -->
                                                @if(!$item->is_headline)
                                                    <button type="button" 
                                                            class="btn btn-outline-danger btn-status"
                                                            data-id="{{ $item->id }}"
                                                            data-status="headline"
                                                            title="Jadikan Headline">
                                                        <i class="fas fa-bullhorn"></i>
                                                    </button>
                                                @else
                                                    <button type="button" 
                                                            class="btn btn-danger btn-status"
                                                            data-id="{{ $item->id }}"
                                                            data-status="headline"
                                                            title="Hapus Headline">
                                                        <i class="fas fa-bullhorn"></i>
                                                    </button>
                                                @endif
                                                
                                                <!-- Tombol Archive -->
                                                <button type="button" 
                                                        class="btn btn-outline-secondary btn-archive"
                                                        data-id="{{ $item->id }}"
                                                        title="Arsipkan">
                                                    <i class="fas fa-archive"></i>
                                                </button>
                                            
                                            <!-- Tombol untuk berita yang diarsip -->
                                            @elseif($item->archived_at)
                                                <!-- Tombol Restore -->
                                                <button type="button" 
                                                        class="btn btn-outline-success btn-restore"
                                                        data-id="{{ $item->id }}"
                                                        title="Pulihkan dari Arsip">
                                                    <i class="fas fa-undo"></i>
                                                </button>
                                            
                                            <!-- Tombol untuk draft -->
                                            @else
                                                <!-- Tombol Publish -->
                                                <button type="button" 
                                                        class="btn btn-outline-success btn-status"
                                                        data-id="{{ $item->id }}"
                                                        data-status="published"
                                                        title="Publikasikan">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif
                                            
                                            <!-- Tombol Hapus -->
                                            <button type="button" 
                                                    class="btn btn-outline-danger btn-hapus"
                                                    data-id="{{ $item->id }}"
                                                    data-title="{{ $item->judul }}"
                                                    title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($berita->hasPages())
                    <div class="card-footer border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted small">
                                Menampilkan {{ $berita->firstItem() }} - {{ $berita->lastItem() }} dari {{ $berita->total() }} berita
                            </div>
                            <div>
                                {{ $berita->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>

    <!-- Modal Form -->
    <div class="modal fade" id="modalForm" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form id="formBerita" enctype="multipart/form-data" novalidate>
                    @csrf
                    <input type="hidden" id="formMethod" name="_method" value="POST">
                    <input type="hidden" id="itemId" name="id">
                    <!-- PERBAIKAN 3: Tambahkan hidden field untuk menyimpan konten asli -->
                    <input type="hidden" id="original_konten" name="original_konten">
                    
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-newspaper me-2"></i>
                            <span id="modalTitle">Tambah Berita Baru</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    
                    <div class="modal-body">
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-8">
                                <!-- Judul -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Judul Berita <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control" 
                                           name="judul" 
                                           id="judul"
                                           placeholder="Masukkan judul berita yang menarik"
                                           required>
                                    <div class="invalid-feedback" id="judul_error"></div>
                                </div>
                                
                                <!-- Slug -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        URL Slug
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">{{ url('/berita') }}/</span>
                                        <input type="text" 
                                               class="form-control" 
                                               name="slug" 
                                               id="slug"
                                               placeholder="url-slug-berita">
                                    </div>
                                    <div class="form-text">Biarkan kosong untuk generate otomatis</div>
                                    <div class="invalid-feedback" id="slug_error"></div>
                                </div>
                                
                                <!-- Ringkasan -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Ringkasan
                                    </label>
                                    <textarea class="form-control" 
                                              name="ringkasan" 
                                              id="ringkasan"
                                              rows="3"
                                              placeholder="Ringkasan singkat berita (akan ditampilkan di list berita)"></textarea>
                                    <div class="form-text">Maksimal 500 karakter</div>
                                    <div class="invalid-feedback" id="ringkasan_error"></div>
                                </div>
                                
                                <!-- Konten -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Konten Berita <span class="text-danger">*</span>
                                    </label>
                                    <textarea
                                        name="konten"
                                        id="konten"
                                        class="form-control tinymce-editor"
                                        rows="10"
                                        placeholder="Tulis konten berita lengkap di sini..."
                                    ></textarea>
                                    <div class="invalid-feedback" id="konten_error"></div>
                                    <div class="form-text">
                                        Gunakan editor untuk memformat teks. Konten ini akan ditampilkan di halaman detail berita.
                                    </div>
                                </div>
                                
                                <!-- Meta Tags -->
                                <div class="accordion mb-3" id="metaAccordion">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#metaCollapse">
                                                <i class="fas fa-search me-2"></i> Meta Tags untuk SEO
                                            </button>
                                        </h2>
                                        <div id="metaCollapse" class="accordion-collapse collapse" data-bs-parent="#metaAccordion">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label fw-bold">
                                                            Meta Title
                                                        </label>
                                                        <input type="text" 
                                                               class="form-control" 
                                                               name="meta_title" 
                                                               id="meta_title"
                                                               placeholder="Judul untuk SEO">
                                                        <div class="form-text">Maksimal 60 karakter</div>
                                                        <div class="invalid-feedback" id="meta_title_error"></div>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label fw-bold">
                                                            Meta Description
                                                        </label>
                                                        <textarea class="form-control" 
                                                                  name="meta_description" 
                                                                  id="meta_description"
                                                                  rows="2"
                                                                  placeholder="Deskripsi untuk SEO"></textarea>
                                                        <div class="form-text">Maksimal 160 karakter</div>
                                                        <div class="invalid-feedback" id="meta_description_error"></div>
                                                    </div>
                                                    <div class="col-12 mb-3">
                                                        <label class="form-label fw-bold">
                                                            Meta Keywords
                                                        </label>
                                                        <input type="text" 
                                                               class="form-control" 
                                                               name="meta_keywords" 
                                                               id="meta_keywords"
                                                               placeholder="Keyword1, Keyword2, Keyword3">
                                                        <div class="form-text">Pisahkan dengan koma</div>
                                                        <div class="invalid-feedback" id="meta_keywords_error"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Right Column -->
                            <div class="col-md-4">
                                <!-- Status & Options -->
                                <div class="card border-0 bg-light mb-3">
                                    <div class="card-body">
                                        <!-- Status Publish -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">
                                                Status Publikasi
                                            </label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       name="is_published" 
                                                       id="is_published" 
                                                       value="1" 
                                                       checked>
                                                <label class="form-check-label" for="is_published">
                                                    <span id="statusLabel">Publikasikan</span>
                                                </label>
                                            </div>
                                            <div class="form-text">
                                                Berita akan langsung tampil di website
                                            </div>
                                        </div>
                                        
                                        <!-- Tanggal Publikasi -->
                                        <div class="mb-3" id="publishedAtField">
                                            <label class="form-label fw-bold">
                                                Tanggal Publikasi
                                            </label>
                                            <input type="datetime-local" 
                                                   class="form-control" 
                                                   name="published_at" 
                                                   id="published_at">
                                            <div class="form-text">
                                                Kosongkan untuk publikasi langsung
                                            </div>
                                            <div class="invalid-feedback" id="published_at_error"></div>
                                        </div>
                                        
                                        <!-- Featured & Headline -->
                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" 
                                                           type="checkbox" 
                                                           name="is_featured" 
                                                           id="is_featured" 
                                                           value="1">
                                                    <label class="form-check-label" for="is_featured">
                                                        <i class="fas fa-star text-warning me-1"></i> Featured
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" 
                                                           type="checkbox" 
                                                           name="is_headline" 
                                                           id="is_headline" 
                                                           value="1">
                                                    <label class="form-check-label" for="is_headline">
                                                        <i class="fas fa-bullhorn text-danger me-1"></i> Headline
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Kategori -->
                                <div class="card border-0 bg-light mb-3">
                                    <div class="card-body">
                                        <label class="form-label fw-bold">
                                            Kategori Berita
                                        </label>
                                        <select class="form-select" name="kategori_id" id="kategori_id">
                                            <option value="">Pilih Kategori</option>
                                            @foreach($kategori as $kat)
                                                <option value="{{ $kat->id }}">{{ $kat->nama }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback" id="kategori_id_error"></div>
                                    </div>
                                </div>
                                
                                <!-- Informasi Penulis -->
                                <div class="card border-0 bg-light mb-3">
                                    <div class="card-body">
                                        <label class="form-label fw-bold">
                                            Informasi Penulis
                                        </label>
                                        <div class="mb-3">
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="penulis" 
                                                   id="penulis"
                                                   placeholder="Nama penulis">
                                            <div class="invalid-feedback" id="penulis_error"></div>
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="sumber" 
                                                   id="sumber"
                                                   placeholder="Sumber berita (opsional)">
                                            <div class="invalid-feedback" id="sumber_error"></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Gambar Utama -->
                                <div class="card border-0 bg-light mb-3">
                                    <div class="card-body">
                                        <label class="form-label fw-bold">
                                            Gambar Utama
                                        </label>
                                        <div class="text-center mb-3">
                                            <div class="image-preview-wrapper border rounded p-3">
                                                <img src="{{ asset('assets/img/default-news.jpg') }}" 
                                                     id="gambarPreview"
                                                     alt="Preview Gambar"
                                                     class="img-fluid rounded mb-2"
                                                     style="max-height: 150px;">
                                                <div class="mt-2 small" id="gambarName">Belum ada gambar</div>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <input type="file" 
                                                   class="form-control" 
                                                   name="gambar" 
                                                   id="gambar"
                                                   accept="image/*">
                                            <div class="form-text">
                                                Ukuran maksimal 2MB. Format: JPG, PNG, GIF, WebP
                                            </div>
                                            <div class="invalid-feedback" id="gambar_error"></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Gambar Thumbnail -->
                                <div class="card border-0 bg-light">
                                    <div class="card-body">
                                        <label class="form-label fw-bold">
                                            Gambar Thumbnail
                                        </label>
                                        <div class="text-center mb-3">
                                            <div class="image-preview-wrapper border rounded p-3">
                                                <img src="{{ asset('assets/img/default-news-thumb.jpg') }}" 
                                                     id="gambarThumbnailPreview"
                                                     alt="Preview Thumbnail"
                                                     class="img-fluid rounded mb-2"
                                                     style="max-height: 100px;">
                                                <div class="mt-2 small" id="gambarThumbnailName">Belum ada thumbnail</div>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <input type="file" 
                                                   class="form-control" 
                                                   name="gambar_thumbnail" 
                                                   id="gambar_thumbnail"
                                                   accept="image/*">
                                            <div class="form-text">
                                                Ukuran maksimal 1MB. Format: JPG, PNG, GIF, WebP
                                            </div>
                                            <div class="invalid-feedback" id="gambar_thumbnail_error"></div>
                                        </div>
                                        
                                        <div class="alert alert-info py-2">
                                            <small>
                                                <i class="fas fa-info-circle me-1"></i>
                                                Kosongkan jika ingin menggunakan versi otomatis dari gambar utama
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Urutan -->
                                <div class="mt-3">
                                    <label class="form-label fw-bold">
                                        Urutan Tampilan
                                    </label>
                                    <input type="number" 
                                           class="form-control" 
                                           name="urutan" 
                                           id="urutan"
                                           value="0"
                                           min="0">
                                    <div class="form-text">Angka kecil = tampil lebih awal</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="btnSimpan">
                            <i class="fas fa-save me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
.image-wrapper {
    width: 80px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.image-preview-wrapper {
    background-color: #f8f9fa;
    border-radius: 10px;
}

.sortable-table tr {
    cursor: move;
}

.sortable-table tr.sortable-ghost {
    opacity: 0.5;
    background: #f8f9fa;
}

.sortable-table tr.sortable-chosen {
    background-color: rgba(107, 2, 177, 0.05);
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.handle {
    cursor: move;
}

#gambarPreview, #gambarThumbnailPreview {
    max-width: 100%;
    height: auto;
}

.accordion-button:not(.collapsed) {
    background-color: rgba(107, 2, 177, 0.1);
    color: #6b02b1;
}

.tox-tinymce {
    border-radius: 8px !important;
    border: 1px solid #dee2e6 !important;
}

.tox-tinymce:focus-within {
    border-color: #6b02b1 !important;
    box-shadow: 0 0 0 0.25rem rgba(107, 2, 177, 0.25) !important;
}

/* Styling untuk tombol aksi */
.btn-group-sm > .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    border-radius: 0.25rem;
}

.btn-outline-warning:hover {
    color: #000;
}

/* PERBAIKAN 2: Tambahkan styling untuk scroll yang lebih baik */
.table-responsive::-webkit-scrollbar {
    height: 8px;
    width: 8px;
}

.table-responsive::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.table-responsive::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 4px;
}

.table-responsive::-webkit-scrollbar-thumb:hover {
    background: #a1a1a1;
}

/* Responsive untuk kolom aksi */
@media (max-width: 1400px) {
    .table-responsive {
        min-width: 1200px;
    }
}
</style>
@endpush

@push('scripts')
<script src="{{ asset('assets/js/tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script>
// Variabel global untuk menyimpan instance editor dan konten asli
let beritaEditor = null;
let originalKonten = '';

// Inisialisasi TinyMCE untuk konten berita
function initTinyMCE(callback) {
    if (beritaEditor) {
        tinymce.remove('#konten');
    }
    
    beritaEditor = tinymce.init({
        selector: '#konten',
        height: 400,
        menubar: true,
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table', 'help', 'wordcount'
        ],
        toolbar: 'undo redo | blocks | ' +
            'bold italic underline | forecolor backcolor | ' +
            'alignleft aligncenter alignright alignjustify | ' +
            'bullist numlist | ' +
            'link image media | table | ' +
            'removeformat | help',
        
        language: 'id',
        language_url: '{{ asset("assets/js/tinymce/langs/id.js") }}',
        
        // Konfigurasi untuk upload gambar
        images_upload_url: '{{ route("backend.berita.upload-image") }}',
        automatic_uploads: true,
        images_upload_credentials: true,
        images_reuse_filename: true,
        
        // Handler untuk upload gambar (versi yang benar)
        images_upload_handler: function (blobInfo) {
    return new Promise(function (resolve, reject) {
        console.log('Uploading image:', blobInfo.filename());
        
        // Buat form data
        const formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());
        formData.append('_token', '{{ csrf_token() }}');
        
        // Buat XMLHttpRequest
        const xhr = new XMLHttpRequest();
        xhr.withCredentials = true;
        xhr.open('POST', '{{ route("backend.berita.upload-image") }}');
        
        // Setup response handler
        xhr.onload = function() {
            console.log('Upload response status:', xhr.status);
            console.log('Upload response text:', xhr.responseText);
            
            if (xhr.status !== 200) {
                console.error('Upload failed:', xhr.statusText);
                reject('HTTP Error: ' + xhr.status);
                return;
            }
            
            try {
                const json = JSON.parse(xhr.responseText);
                console.log('Upload response JSON:', json);
                
                // TINY MCE MENGHARAPKAN PROPERTY 'location' LANGSUNG
                if (json.location) {
                    resolve(json.location);
                } else if (json.error) {
                    // Handle jika ada property error
                    reject(json.error.message || json.error);
                } else {
                    reject('Invalid response from server: No location field');
                }
            } catch (e) {
                console.error('Error parsing response:', e);
                reject('Invalid response from server: ' + e.message);
            }
        };
        
        // Setup error handler
        xhr.onerror = function() {
            console.error('Network error during upload');
            reject('Network error');
        };
        
        // Setup timeout
        xhr.timeout = 30000; // 30 seconds timeout
        xhr.ontimeout = function() {
            reject('Upload timeout');
        };
        
        // Kirim request
        xhr.send(formData);
    });
},
        
        content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, sans-serif; font-size: 14px; line-height: 1.6; color: #212529; margin: 8px; }' +
            'h1, h2, h3, h4, h5, h6 { margin-top: 1rem; margin-bottom: 0.5rem; font-weight: 600; line-height: 1.2; }' +
            'h1 { font-size: 2rem; }' +
            'h2 { font-size: 1.75rem; }' +
            'h3 { font-size: 1.5rem; }' +
            'h4 { font-size: 1.25rem; }' +
            'h5 { font-size: 1.125rem; }' +
            'h6 { font-size: 1rem; }' +
            'p { margin-bottom: 1rem; text-align: justify; }' +
            'ul, ol { margin-bottom: 1rem; padding-left: 2rem; }' +
            'table { border-collapse: collapse; width: 100%; margin-bottom: 1rem; }' +
            'table, th, td { border: 1px solid #dee2e6; padding: 0.75rem; }' +
            'th { background-color: #f8f9fa; font-weight: 600; }' +
            'blockquote { margin: 0 0 1rem; padding: 0.5rem 1rem; border-left: 4px solid #007bff; background-color: #f8f9fa; font-style: italic; }' +
            'a { color: #007bff; text-decoration: none; }' +
            'a:hover { text-decoration: underline; }',
        
        setup: function (editor) {
            editor.on('init', function () {
                console.log('TinyMCE initialized for berita content');
                if (callback && typeof callback === 'function') {
                    callback();
                }
            });
            
            editor.on('change', function () {
                editor.save();
            });
        },
        
        promotion: false,
        branding: false,
        resize: true,
        min_height: 400,
        max_height: 600,
        statusbar: true,
        relative_urls: false,
        remove_script_host: false,
        convert_urls: true,
        
        init_instance_callback: function(editor) {
            console.log('TinyMCE instance ready');
        }
    });
}

// Fungsi untuk menghapus TinyMCE instance
function removeTinyMCE() {
    if (beritaEditor) {
        tinymce.remove('#konten');
        beritaEditor = null;
    }
}

// Fungsi untuk mendapatkan konten dari editor dengan aman
function getEditorContent() {
    if (beritaEditor) {
        var editor = tinymce.get('konten');
        if (editor) {
            return editor.getContent().trim();
        }
    }
    return document.getElementById('konten') ? document.getElementById('konten').value.trim() : '';
}

// Fungsi untuk mengecek apakah editor siap
function isEditorReady() {
    if (beritaEditor) {
        var editor = tinymce.get('konten');
        return editor && editor.initialized;
    }
    return false;
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing berita management...');
    
    const modalElement = document.getElementById('modalForm');
    const modal = new bootstrap.Modal(modalElement, {
        backdrop: 'static',
        keyboard: false
    });
    const form = document.getElementById('formBerita');
    const gambarInput = document.getElementById('gambar');
    const gambarPreview = document.getElementById('gambarPreview');
    const gambarName = document.getElementById('gambarName');
    const gambarThumbnailInput = document.getElementById('gambar_thumbnail');
    const gambarThumbnailPreview = document.getElementById('gambarThumbnailPreview');
    const gambarThumbnailName = document.getElementById('gambarThumbnailName');
    const judulInput = document.getElementById('judul');
    const slugInput = document.getElementById('slug');
    const statusToggle = document.getElementById('is_published');
    const publishedAtField = document.getElementById('publishedAtField');
    const originalKontenField = document.getElementById('original_konten');
    
    // Flag untuk menandai apakah form sedang diproses
    let isSubmitting = false;
    
    // Event listeners untuk modal
    modalElement.addEventListener('shown.bs.modal', function () {
        // Set focus ke judul setelah modal muncul
        setTimeout(function() {
            document.getElementById('judul').focus();
        }, 300);
    });
    
    modalElement.addEventListener('hidden.bs.modal', function () {
        // Hapus TinyMCE instance ketika modal ditutup
        removeTinyMCE();
        // Reset form
        form.reset();
        clearValidationErrors();
        // Reset original konten
        originalKonten = '';
        if (originalKontenField) {
            originalKontenField.value = '';
        }
        // Reset flag submit
        isSubmitting = false;
    });
    
    // Auto-generate slug from judul
    if (judulInput && slugInput) {
        judulInput.addEventListener('blur', function() {
            if (!slugInput.value && this.value.trim() !== '') {
                fetch('{{ route("backend.berita.generate-slug") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ judul: this.value })
                })
                .then(function(response) {
                    return response.json();
                })
                .then(function(data) {
                    if (data.success) {
                        slugInput.value = data.slug;
                    }
                })
                .catch(function(error) {
                    console.error('Error generating slug:', error);
                });
            }
        });
    }
    
    // Toggle published_at field based on status
    if (statusToggle) {
        statusToggle.addEventListener('change', function() {
            publishedAtField.style.display = this.checked ? 'block' : 'none';
        });
        // Initial state
        publishedAtField.style.display = statusToggle.checked ? 'block' : 'none';
    }
    
    // Initialize Sortable
    const sortableTable = document.getElementById('sortableTable');
    if (sortableTable && typeof Sortable !== 'undefined') {
        const sortable = new Sortable(sortableTable, {
            animation: 150,
            handle: '.handle',
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            onEnd: function(evt) {
                updateUrutan();
            }
        });
    }
    
    // Update urutan
    function updateUrutan() {
        const rows = document.querySelectorAll('#sortableTable tr');
        const urutan = [];
        
        rows.forEach(function(row, index) {
            urutan.push({
                id: row.dataset.id,
                urutan: index + 1
            });
        });
        
        showLoading('Mengupdate urutan...', 'Harap tunggu');
        
        fetch('{{ route("backend.berita.update-urutan") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ urutan: urutan })
        })
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            closeLoading();
            
            if (data.success) {
                // Update row numbers
                rows.forEach(function(row, index) {
                    const numberCell = row.querySelector('td:first-child');
                    if (numberCell) {
                        const page = {{ $berita->currentPage() }};
                        const perPage = {{ $berita->perPage() }};
                        const number = (page - 1) * perPage + index + 1;
                        numberCell.innerHTML = '<i class="fas fa-arrows-alt handle text-secondary me-2"></i> ' + number;
                    }
                });
                
                showSuccessToast(data.message || 'Urutan berita berhasil diperbarui.');
            }
        })
        .catch(function(error) {
            closeLoading();
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Terjadi kesalahan saat mengupdate urutan.'
            });
        });
    }
    
    // Gambar preview
    if (gambarInput) {
        gambarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    gambarPreview.src = e.target.result;
                    gambarName.textContent = file.name;
                };
                reader.readAsDataURL(file);
            }
        });
    }
    
    // Gambar thumbnail preview
    if (gambarThumbnailInput) {
        gambarThumbnailInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    gambarThumbnailPreview.src = e.target.result;
                    gambarThumbnailName.textContent = file.name;
                };
                reader.readAsDataURL(file);
            }
        });
    }
    
    // Tambah button
    var btnTambah = document.getElementById('btnTambah');
    var btnTambahEmpty = document.getElementById('btnTambahEmpty');
    
    if (btnTambah) {
        btnTambah.addEventListener('click', openForm);
    }
    
    if (btnTambahEmpty) {
        btnTambahEmpty.addEventListener('click', openForm);
    }
    
    // Event listeners untuk tombol di tabel menggunakan event delegation
    document.addEventListener('click', function(e) {
        // Edit button
        if (e.target.classList.contains('btn-edit') || e.target.closest('.btn-edit')) {
            e.preventDefault();
            const button = e.target.classList.contains('btn-edit') ? e.target : e.target.closest('.btn-edit');
            if (button) {
                const id = button.dataset.id;
                console.log('Edit button clicked:', id);
                editData(id);
            }
        }
        
        // Status button (featured, headline, publish)
        if (e.target.classList.contains('btn-status') || e.target.closest('.btn-status')) {
            e.preventDefault();
            const button = e.target.classList.contains('btn-status') ? e.target : e.target.closest('.btn-status');
            if (button) {
                const id = button.dataset.id;
                const status = button.dataset.status;
                console.log('Status button clicked:', id, status);
                toggleStatus(id, status);
            }
        }
        
        // Archive button
        if (e.target.classList.contains('btn-archive') || e.target.closest('.btn-archive')) {
            e.preventDefault();
            const button = e.target.classList.contains('btn-archive') ? e.target : e.target.closest('.btn-archive');
            if (button) {
                const id = button.dataset.id;
                console.log('Archive button clicked:', id);
                archiveData(id);
            }
        }
        
        // Restore button
        if (e.target.classList.contains('btn-restore') || e.target.closest('.btn-restore')) {
            e.preventDefault();
            const button = e.target.classList.contains('btn-restore') ? e.target : e.target.closest('.btn-restore');
            if (button) {
                const id = button.dataset.id;
                console.log('Restore button clicked:', id);
                restoreData(id);
            }
        }
        
        // Hapus button
        if (e.target.classList.contains('btn-hapus') || e.target.closest('.btn-hapus')) {
            e.preventDefault();
            const button = e.target.classList.contains('btn-hapus') ? e.target : e.target.closest('.btn-hapus');
            if (button) {
                const id = button.dataset.id;
                const title = button.dataset.title;
                console.log('Hapus button clicked:', id, title);
                hapusData(id, title);
            }
        }
    });
    
    // Open form for create
    function openForm() {
        // Reset form
        form.reset();
        document.getElementById('formMethod').value = 'POST';
        document.getElementById('itemId').value = '';
        document.getElementById('modalTitle').textContent = 'Tambah Berita Baru';
        document.getElementById('is_published').checked = true;
        if (publishedAtField) {
            publishedAtField.style.display = 'block';
        }
        
        // Reset original konten
        originalKonten = '';
        if (originalKontenField) {
            originalKontenField.value = '';
        }
        
        // Reset gambar previews
        if (gambarPreview) {
            gambarPreview.src = '{{ asset("assets/img/default-news.jpg") }}';
        }
        if (gambarName) {
            gambarName.textContent = 'Belum ada gambar';
        }
        if (gambarThumbnailPreview) {
            gambarThumbnailPreview.src = '{{ asset("assets/img/default-news-thumb.jpg") }}';
        }
        if (gambarThumbnailName) {
            gambarThumbnailName.textContent = 'Belum ada thumbnail';
        }
        
        // Clear validation errors
        clearValidationErrors();
        
        // Show modal
        if (modal) {
            modal.show();
        }
        
        // Inisialisasi TinyMCE setelah modal muncul
        setTimeout(function() {
            initTinyMCE(function() {
                console.log('TinyMCE ready for new form');
            });
        }, 300);
    }
    
    // Open form for edit
    function editData(id) {
        if (!id) {
            console.error('No ID provided for edit');
            return;
        }
        
        showLoading('Memuat data...', 'Harap tunggu');
        
        fetch('{{ route("backend.berita.edit", ":id") }}'.replace(':id', id))
            .then(function(response) {
                return response.json();
            })
            .then(function(data) {
                closeLoading();
                
                if (data.success) {
                    var item = data.data;
                    
                    // Clear previous validation errors
                    clearValidationErrors();
                    
                    // Simpan konten asli
                    originalKonten = item.konten || '';
                    if (originalKontenField) {
                        originalKontenField.value = originalKonten;
                    }
                    
                    // Set form values
                    document.getElementById('formMethod').value = 'PUT';
                    document.getElementById('itemId').value = item.id;
                    document.getElementById('judul').value = item.judul;
                    document.getElementById('slug').value = item.slug;
                    document.getElementById('ringkasan').value = item.ringkasan || '';
                    document.getElementById('penulis').value = item.penulis || '';
                    document.getElementById('sumber').value = item.sumber || '';
                    document.getElementById('meta_title').value = item.meta_title || '';
                    document.getElementById('meta_description').value = item.meta_description || '';
                    document.getElementById('meta_keywords').value = item.meta_keywords ? JSON.parse(item.meta_keywords).join(', ') : '';
                    document.getElementById('urutan').value = item.urutan || 0;
                    document.getElementById('is_published').checked = item.is_published == 1;
                    document.getElementById('is_featured').checked = item.is_featured == 1;
                    document.getElementById('is_headline').checked = item.is_headline == 1;
                    
                    // Set kategori
                    if (item.kategori_id) {
                        document.getElementById('kategori_id').value = item.kategori_id;
                    }
                    
                    // Set published_at
                    if (item.published_at) {
                        var publishedAt = new Date(item.published_at);
                        var formattedDate = publishedAt.toISOString().slice(0, 16);
                        document.getElementById('published_at').value = formattedDate;
                    }
                    
                    // Set gambar previews
                    if (item.gambar && gambarPreview) {
                        gambarPreview.src = '{{ asset("storage") }}/' + item.gambar;
                        gambarName.textContent = 'Gambar tersedia';
                    } else if (gambarPreview) {
                        gambarPreview.src = '{{ asset("assets/img/default-news.jpg") }}';
                        gambarName.textContent = 'Belum ada gambar';
                    }
                    
                    if (item.gambar_thumbnail && gambarThumbnailPreview) {
                        gambarThumbnailPreview.src = '{{ asset("storage") }}/' + item.gambar_thumbnail;
                        gambarThumbnailName.textContent = 'Thumbnail tersedia';
                    } else if (gambarThumbnailPreview) {
                        gambarThumbnailPreview.src = '{{ asset("assets/img/default-news-thumb.jpg") }}';
                        gambarThumbnailName.textContent = 'Belum ada thumbnail';
                    }
                    
                    // Update modal title
                    document.getElementById('modalTitle').textContent = 'Edit Berita';
                    
                    // Toggle published_at field
                    if (publishedAtField) {
                        publishedAtField.style.display = item.is_published ? 'block' : 'none';
                    }
                    
                    // Show modal
                    if (modal) {
                        modal.show();
                    }
                    
                    // Inisialisasi TinyMCE dengan konten setelah modal muncul
                    setTimeout(function() {
                        initTinyMCE(function() {
                            // Set konten setelah editor siap
                            var editor = tinymce.get('konten');
                            if (editor) {
                                editor.setContent(originalKonten);
                                console.log('Konten berhasil dimuat ke editor');
                            }
                        });
                    }, 300);
                }
            })
            .catch(function(error) {
                closeLoading();
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat mengambil data.'
                });
            });
    }
    
    // Form submission dengan validasi yang lebih baik
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Cegah submit ganda
            if (isSubmitting) {
                return false;
            }
            
            // Set flag sedang submit
            isSubmitting = true;
            
            // Dapatkan konten dari editor
            var konten = getEditorContent();
            var method = document.getElementById('formMethod').value;
            var itemId = document.getElementById('itemId').value;
            
            console.log('Form submission started, method:', method, 'content length:', konten.length);
            
            // Validasi konten
            if (method === 'POST' && konten.length === 0) {
                // Mode tambah baru, konten wajib diisi
                isSubmitting = false;
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan',
                    text: 'Konten berita tidak boleh kosong!'
                });
                var editor = tinymce.get('konten');
                if (editor) {
                    editor.focus();
                }
                return false;
            }
            
            // Jika edit mode dan konten kosong, gunakan konten asli
            if (method === 'PUT' && konten.length === 0) {
                console.log('Konten kosong pada edit mode, menggunakan konten asli');
                konten = originalKonten;
                
                // Pastikan konten asli ada
                if (konten.length === 0) {
                    isSubmitting = false;
                    Swal.fire({
                        icon: 'error',
                        title: 'Kesalahan',
                        text: 'Konten berita tidak boleh kosong!'
                    });
                    return false;
                }
            }
            
            // Buat FormData
            var formData = new FormData(this);
            
            // Tambahkan konten ke FormData (jika belum ada)
            formData.set('konten', konten);
            
            // Process meta_keywords
            var metaKeywords = document.getElementById('meta_keywords');
            if (metaKeywords && metaKeywords.value) {
                var keywordsArray = metaKeywords.value.split(',').map(function(k) {
                    return k.trim();
                }).filter(function(k) {
                    return k !== '';
                });
                formData.set('meta_keywords', JSON.stringify(keywordsArray));
            } else {
                formData.set('meta_keywords', JSON.stringify([]));
            }
            
            // Set URL berdasarkan method
            var url = '{{ route("backend.berita.store") }}';
            if (method === 'PUT') {
                url = '{{ route("backend.berita.update", ":id") }}'.replace(':id', itemId);
                formData.append('_method', 'PUT');
            }
            
            console.log('Submitting to:', url);
            
            // Show loading
            showLoading('Menyimpan...', 'Harap tunggu');
            
            // Kirim request
            fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(function(response) {
                console.log('Response received:', response.status);
                return response.json();
            })
            .then(function(data) {
                closeLoading();
                isSubmitting = false;
                
                console.log('Response data:', data);
                
                if (data.success) {
                    if (modal) {
                        modal.hide();
                    }
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(function() {
                        location.reload();
                    });
                } else {
                    // Display validation errors
                    if (data.errors) {
                        Object.keys(data.errors).forEach(function(field) {
                            var input = document.querySelector('[name="' + field + '"]');
                            var errorDiv = document.getElementById(field + '_error');
                            if (input) {
                                input.classList.add('is-invalid');
                            }
                            if (errorDiv) {
                                errorDiv.textContent = data.errors[field][0];
                            }
                        });
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Validasi Gagal',
                            text: 'Harap perbaiki kesalahan pada form.'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: data.message || 'Terjadi kesalahan saat menyimpan data.'
                        });
                    }
                }
            })
            .catch(function(error) {
                closeLoading();
                isSubmitting = false;
                console.error('Fetch error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat menyimpan data.'
                });
            });
            
            return false;
        });
    }
    
    // Toggle status
    function toggleStatus(id, status) {
        if (!id || !status) {
            console.error('Missing ID or status');
            return;
        }
        
        Swal.fire({
            title: 'Ubah Status?',
            text: 'Apakah Anda yakin ingin mengubah status berita ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#6b02b1',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Ubah!',
            cancelButtonText: 'Batal'
        }).then(function(result) {
            if (result.isConfirmed) {
                showLoading('Mengubah status...', 'Harap tunggu');
                
                var url = '{{ route("backend.berita.toggle-status", ["id" => ":id", "status" => ":status"]) }}'
                    .replace(':id', id)
                    .replace(':status', status);
                
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(function(response) {
                    return response.json();
                })
                .then(function(data) {
                    closeLoading();
                    
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(function() {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: data.message || 'Gagal mengubah status.'
                        });
                    }
                })
                .catch(function(error) {
                    closeLoading();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat mengubah status.'
                    });
                });
            }
        });
    }
    
    // Archive data
    function archiveData(id) {
        if (!id) {
            console.error('No ID provided for archive');
            return;
        }
        
        Swal.fire({
            title: 'Arsipkan Berita?',
            html: 'Apakah Anda yakin ingin mengarsipkan berita ini?<br><small class="text-muted">Berita yang diarsipkan tidak akan tampil di halaman depan.</small>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ffc107',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Arsipkan!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then(function(result) {
            if (result.isConfirmed) {
                showLoading('Mengarsipkan...', 'Harap tunggu');
                
                fetch('{{ route("backend.berita.archive", ":id") }}'.replace(':id', id), {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(function(response) {
                    return response.json();
                })
                .then(function(data) {
                    closeLoading();
                    
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(function() {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: data.message || 'Gagal mengarsipkan berita.'
                        });
                    }
                })
                .catch(function(error) {
                    closeLoading();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat mengarsipkan data.'
                    });
                });
            }
        });
    }
    
    // Restore data
    function restoreData(id) {
        if (!id) {
            console.error('No ID provided for restore');
            return;
        }
        
        Swal.fire({
            title: 'Pulihkan Berita?',
            html: 'Apakah Anda yakin ingin memulihkan berita ini dari arsip?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Pulihkan!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then(function(result) {
            if (result.isConfirmed) {
                showLoading('Memulihkan...', 'Harap tunggu');
                
                fetch('{{ route("backend.berita.restore", ":id") }}'.replace(':id', id), {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(function(response) {
                    return response.json();
                })
                .then(function(data) {
                    closeLoading();
                    
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(function() {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: data.message || 'Gagal memulihkan berita.'
                        });
                    }
                })
                .catch(function(error) {
                    closeLoading();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat memulihkan data.'
                    });
                });
            }
        });
    }
    
    // Hapus data
    function hapusData(id, title) {
        if (!id || !title) {
            console.error('Missing ID or title for delete');
            return;
        }
        
        Swal.fire({
            title: 'Hapus Berita?',
            html: 'Apakah Anda yakin ingin menghapus berita <strong>"' + title + '"</strong>?<br><small class="text-danger">Data yang dihapus tidak dapat dikembalikan!</small>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then(function(result) {
            if (result.isConfirmed) {
                showLoading('Menghapus...', 'Harap tunggu');
                
                fetch('{{ route("backend.berita.destroy", ":id") }}'.replace(':id', id), {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(function(response) {
                    return response.json();
                })
                .then(function(data) {
                    closeLoading();
                    
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Terhapus!',
                            text: data.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(function() {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: data.message || 'Gagal menghapus berita.'
                        });
                    }
                })
                .catch(function(error) {
                    closeLoading();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat menghapus data.'
                    });
                });
            }
        });
    }
    
    // Clear validation errors
    function clearValidationErrors() {
        if (form) {
            form.querySelectorAll('.is-invalid').forEach(function(field) {
                field.classList.remove('is-invalid');
            });
            form.querySelectorAll('.invalid-feedback').forEach(function(errorDiv) {
                errorDiv.textContent = '';
            });
        }
    }
    
    // Remove invalid class on input
    if (form) {
        form.querySelectorAll('input, select, textarea').forEach(function(field) {
            field.addEventListener('input', function() {
                this.classList.remove('is-invalid');
                var errorDiv = document.getElementById(this.name + '_error');
                if (errorDiv) {
                    errorDiv.textContent = '';
                }
            });
        });
    }

});
</script>
@endpush
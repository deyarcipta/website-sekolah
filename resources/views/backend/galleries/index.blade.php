{{-- resources/views/backend/galleries/index.blade.php --}}

@extends('layouts.backend')

@section('title', 'Kelola Galeri Foto - Dashboard Admin')

@section('content')
    <!-- Header Card -->
    <div class="card shadow mb-4 border-0">
        <div class="card-body py-4">
            <div class="d-flex justify-content-between align-items-center page-header">
                <div>
                    <h1 class="h3 text-gray-800 mb-1">
                        <i class="fas fa-images me-2"></i> Kelola Galeri Foto
                    </h1>
                    <p class="text-muted mb-0">Kelola galeri foto yang akan ditampilkan di website</p>
                </div>
                <div>
                    <button type="button" class="btn btn-primary" id="btnTambah">
                        <i class="fas fa-plus me-1"></i> Tambah Galeri
                    </button>
                    <a href="#" target="_blank" class="btn btn-outline-info">
                        <i class="fas fa-external-link-alt me-1"></i> Lihat di Frontend
                    </a>
                </div>
            </div>
            
            <!-- Stats Row -->
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card border-0 bg-primary bg-opacity-10">
                        <div class="card-body py-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-images fa-2x text-white"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="mb-0">{{ $totalGalleries }}</h5>
                                    <small class="text-white">Total Galeri</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
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
                <div class="col-md-4">
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
            </div>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card shadow mb-4 border-0">
        <div class="card-body">
            <form action="{{ route('backend.galleries.index') }}" method="GET" class="row g-3">
                <div class="col-md-5">
                    <label class="form-label fw-bold">Cari Galeri</label>
                    <input type="text" class="form-control" name="search" placeholder="Judul atau deskripsi galeri..." value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Status</label>
                    <select class="form-select" name="status">
                        <option value="">Semua Status</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
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
            @if($galleries->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-images fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada galeri</h5>
                    <p class="text-muted">Mulai dengan menambahkan galeri baru</p>
                    <button type="button" class="btn btn-primary" id="btnTambahEmpty">
                        <i class="fas fa-plus me-1"></i> Tambah Galeri Pertama
                    </button>
                </div>
            @else
                <div class="table-responsive" style="overflow-x: auto; max-height: 70vh; min-width: 100%;">
                    <table class="table table-hover mb-0" style="min-width: 1200px;">
                        <thead class="bg-light" style="position: sticky; top: 0; z-index: 10; background: #f8f9fa;">
                            <tr>
                                <th class="ps-4" width="50">#</th>
                                <th class="ps-3" width="150">Cover & Judul</th>
                                <th width="300">Deskripsi</th>
                                <th width="120">Tanggal & Jumlah</th>
                                <th width="100">Status</th>
                                <th width="100" class="text-center">Urutan</th>
                                <th width="180" class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="sortable-table" id="sortableTable">
                            @foreach($galleries as $gallery)
                                <tr data-id="{{ $gallery->id }}">
                                    <td class="ps-4">
                                        <i class="fas fa-arrows-alt handle text-secondary me-2"></i>
                                        {{ ($galleries->currentPage() - 1) * $galleries->perPage() + $loop->iteration }}
                                    </td>
                                    <td class="ps-3">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-3">
                                                @if($gallery->cover_image)
                                                    <img src="{{ Storage::url($gallery->cover_image) }}" 
                                                         alt="{{ $gallery->judul }}"
                                                         class="rounded"
                                                         style="width: 80px; height: 60px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light d-flex align-items-center justify-content-center rounded"
                                                         style="width: 80px; height: 60px;">
                                                        <i class="fas fa-images text-muted"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-grow-1">
                                                <strong class="text-dark d-block">{{ Str::limit($gallery->judul, 50) }}</strong>
                                                <small class="text-muted">{{ $gallery->slug }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column" style="max-height: 60px; overflow: hidden;">
                                            <small class="text-muted">
                                                {{ Str::limit(strip_tags($gallery->deskripsi), 100) }}
                                            </small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column small">
                                            <div>
                                                <i class="fas fa-calendar-alt text-info me-1"></i> {{ $gallery->tanggal_short }}
                                            </div>
                                            <div>
                                                <i class="fas fa-images text-success me-1"></i> {{ $gallery->images_count }} foto
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column gap-1">
                                            <span class="badge bg-{{ $gallery->is_published ? 'success' : 'warning' }}">
                                                {{ $gallery->is_published ? 'Published' : 'Draft' }}
                                            </span>
                                            @if($gallery->published_at)
                                                <small class="text-muted">
                                                    <i class="fas fa-calendar me-1"></i> {{ $gallery->published_at->format('d/m/Y') }}
                                                </small>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-secondary">{{ $gallery->urutan }}</span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <!-- Tombol Edit -->
                                            <button type="button" 
                                                    class="btn btn-outline-primary btn-edit"
                                                    data-id="{{ $gallery->id }}"
                                                    title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            
                                            <!-- Tombol untuk draft -->
                                            @if(!$gallery->is_published)
                                                <!-- Tombol Publish -->
                                                <button type="button" 
                                                        class="btn btn-outline-success btn-status"
                                                        data-id="{{ $gallery->id }}"
                                                        data-status="publish"
                                                        title="Publikasikan">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @else
                                                <!-- Tombol Draft -->
                                                <button type="button" 
                                                        class="btn btn-outline-warning btn-status"
                                                        data-id="{{ $gallery->id }}"
                                                        data-status="draft"
                                                        title="Jadikan Draft">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            @endif
                                            
                                            <!-- Tombol Hapus -->
                                            <button type="button" 
                                                    class="btn btn-outline-danger btn-hapus"
                                                    data-id="{{ $gallery->id }}"
                                                    data-title="{{ $gallery->judul }}"
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
                @if($galleries->hasPages())
                    <div class="card-footer border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted small">
                                Menampilkan {{ $galleries->firstItem() }} - {{ $galleries->lastItem() }} dari {{ $galleries->total() }} galeri
                            </div>
                            <div>
                                {{ $galleries->links() }}
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
                <form id="formGallery" method="POST" novalidate enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="formMethod" name="_method" value="POST">
                    <input type="hidden" id="itemId" name="id">
                    
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-images me-2"></i>
                            <span id="modalTitle">Tambah Galeri Baru</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <div class="modal-body">
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-8">
                                <!-- Judul -->
                                <div class="mb-3">
                                    <label for="judul" class="form-label fw-bold">
                                        Judul Galeri <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control" 
                                           name="judul" 
                                           id="judul"
                                           placeholder="Masukkan judul galeri"
                                           required>
                                    <div class="invalid-feedback" id="judul_error"></div>
                                </div>
                                
                                <!-- Deskripsi -->
                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label fw-bold">
                                        Deskripsi
                                    </label>
                                    <textarea class="form-control" 
                                              name="deskripsi" 
                                              id="deskripsi"
                                              rows="3"
                                              placeholder="Deskripsi galeri"></textarea>
                                    <div class="invalid-feedback" id="deskripsi_error"></div>
                                </div>
                                
                                <!-- Tanggal -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="tanggal" class="form-label fw-bold">
                                            Tanggal <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" 
                                               class="form-control" 
                                               name="tanggal" 
                                               id="tanggal"
                                               required>
                                        <div class="invalid-feedback" id="tanggal_error"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="urutan" class="form-label fw-bold">
                                            Urutan Tampilan
                                        </label>
                                        <input type="number" 
                                               class="form-control" 
                                               name="urutan" 
                                               id="urutan"
                                               value="0"
                                               min="0">
                                        <div class="invalid-feedback" id="urutan_error"></div>
                                    </div>
                                </div>
                                
                                <!-- Cover Image -->
                                <div class="mb-3">
                                    <label for="cover_image" class="form-label fw-bold">
                                        Cover Image (Opsional)
                                    </label>
                                    <input type="file" 
                                           class="form-control" 
                                           name="cover_image" 
                                           id="cover_image"
                                           accept="image/*">
                                    <div class="form-text">Gambar cover untuk galeri. Ukuran maksimal 2MB.</div>
                                    <div class="invalid-feedback" id="cover_image_error"></div>
                                    
                                    <!-- Cover Preview -->
                                    <div class="mt-2" id="coverPreviewContainer">
                                        <img id="coverPreview" 
                                             src="" 
                                             alt="Cover Preview" 
                                             class="img-fluid rounded d-none"
                                             style="max-height: 150px;">
                                    </div>
                                </div>
                                
                                <!-- Gallery Images -->
                                <div class="mb-3">
                                    <label for="images" class="form-label fw-bold">
                                        Gambar Galeri <span class="text-danger">*</span>
                                    </label>
                                    <input type="file" 
                                           class="form-control" 
                                           name="images[]" 
                                           id="images"
                                           multiple 
                                           accept="image/*">
                                    <div class="form-text">Pilih satu atau beberapa gambar. Ukuran maksimal per gambar: 5MB.</div>
                                    <div class="invalid-feedback" id="images_error"></div>
                                    
                                    <!-- Images Preview Grid -->
                                    <div class="row g-2 mt-2" id="imagesPreviewGrid">
                                        <!-- Preview akan ditampilkan di sini -->
                                    </div>
                                    
                                    <!-- Existing Images -->
                                    <div class="row g-2 mt-3" id="existingImagesGrid">
                                        <!-- Gambar yang sudah ada akan ditampilkan di sini -->
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Right Column -->
                            <div class="col-md-4">
                                <!-- Status Publish -->
                                <div class="card border-0 bg-light mb-3">
                                    <div class="card-body">
                                        <label class="form-label fw-bold mb-3">
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
                                            Jika aktif, galeri akan tampil di website
                                        </div>
                                        <div class="invalid-feedback" id="is_published_error"></div>
                                    </div>
                                </div>
                                
                                <!-- Preview -->
                                <div class="card border-0 bg-light">
                                    <div class="card-body">
                                        <label class="form-label fw-bold mb-3">
                                            Preview
                                        </label>
                                        <div class="text-center">
                                            <div class="preview-gallery mb-3">
                                                <!-- Preview image container -->
                                                <div id="galleryPreview" class="d-flex align-items-center justify-content-center bg-light rounded mb-2" 
                                                     style="height: 150px; overflow: hidden;">
                                                    <i class="fas fa-images fa-2x text-muted"></i>
                                                </div>
                                                <h6 id="previewTitle" class="mb-1">Judul Galeri</h6>
                                                <p class="small text-muted mb-0" id="previewDate">{{ date('d F Y') }}</p>
                                                <p class="small text-muted" id="previewCount">0 foto</p>
                                            </div>
                                        </div>
                                        <div class="form-text text-center">
                                            Preview tampilan di frontend
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Stats (hanya untuk edit) -->
                                <div class="card border-0 bg-light mt-3 d-none" id="statsCard">
                                    <div class="card-body">
                                        <label class="form-label fw-bold mb-3">Statistik</label>
                                        <ul class="list-group list-group-flush small">
                                            <li class="list-group-item d-flex justify-content-between px-0">
                                                <span>Total Gambar:</span>
                                                <span class="badge bg-primary" id="statsImages">0</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between px-0">
                                                <span>Tanggal Dibuat:</span>
                                                <span id="statsCreatedAt">-</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between px-0">
                                                <span>Terakhir Diubah:</span>
                                                <span id="statsUpdatedAt">-</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Hidden input for deleted images -->
                        <input type="hidden" name="deleted_images" id="deletedImages" value="">
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

.image-wrapper img {
    object-fit: cover;
    width: 100%;
    height: 100%;
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

.btn-group-sm > .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    border-radius: 0.25rem;
}

.image-preview-item {
    position: relative;
    margin-bottom: 10px;
}

.image-preview-item img {
    width: 100%;
    height: 100px;
    object-fit: cover;
    border-radius: 4px;
}

.remove-image {
    position: absolute;
    top: 5px;
    right: 5px;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: rgba(220, 53, 69, 0.9);
    color: white;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    cursor: pointer;
}

.image-caption {
    font-size: 12px;
    margin-top: 5px;
}

/* Table responsive */
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
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing gallery management...');
    
    // Elements
    const modalElement = document.getElementById('modalForm');
    const modal = new bootstrap.Modal(modalElement, {
        backdrop: 'static',
        keyboard: false
    });
    const form = document.getElementById('formGallery');
    const judulInput = document.getElementById('judul');
    const tanggalInput = document.getElementById('tanggal');
    const imagesInput = document.getElementById('images');
    const coverImageInput = document.getElementById('cover_image');
    const deletedImagesInput = document.getElementById('deletedImages');
    const imagesPreviewGrid = document.getElementById('imagesPreviewGrid');
    const existingImagesGrid = document.getElementById('existingImagesGrid');
    const coverPreview = document.getElementById('coverPreview');
    const galleryPreviewContainer = document.getElementById('galleryPreview');
    const previewTitle = document.getElementById('previewTitle');
    const previewDate = document.getElementById('previewDate');
    const previewCount = document.getElementById('previewCount');
    const statsCard = document.getElementById('statsCard');
    
    // Global variables untuk menyimpan file
    let newImagesFiles = []; // Array untuk menyimpan file gambar baru
    let newImagesCaptions = {}; // Object untuk menyimpan caption gambar baru
    let existingImagesCount = 0;
    
    // Format date
    function formatDate(dateString) {
        const date = new Date(dateString);
        const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                       'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        return `${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()}`;
    }
    
    // Set default tanggal ke hari ini
    if (tanggalInput) {
        const today = new Date().toISOString().split('T')[0];
        tanggalInput.value = today;
        previewDate.textContent = formatDate(today);
    }
    
    // Update preview on input change
    if (judulInput) {
        judulInput.addEventListener('input', function() {
            previewTitle.textContent = this.value || 'Judul Galeri';
        });
    }
    
    if (tanggalInput) {
        tanggalInput.addEventListener('change', function() {
            previewDate.textContent = formatDate(this.value);
        });
    }
    
    // Cover image preview
    if (coverImageInput) {
        coverImageInput.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Update cover preview
                    coverPreview.src = e.target.result;
                    coverPreview.classList.remove('d-none');
                    
                    // Update gallery preview
                    updateGalleryPreview(e.target.result);
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    }
    
    // Fungsi untuk update gallery preview dengan gambar
    function updateGalleryPreview(imageSrc) {
        // Kosongkan container
        galleryPreviewContainer.innerHTML = '';
        
        // Buat gambar baru
        const img = document.createElement('img');
        img.src = imageSrc;
        img.className = 'img-fluid rounded mb-2';
        img.style.width = '100%';
        img.style.height = '150px';
        img.style.objectFit = 'cover';
        
        // Tambahkan gambar ke container
        galleryPreviewContainer.appendChild(img);
    }
    
    // Fungsi untuk mengembalikan ke placeholder
    function restoreGalleryPreviewPlaceholder() {
        galleryPreviewContainer.innerHTML = '';
        
        const icon = document.createElement('i');
        icon.className = 'fas fa-images fa-2x text-muted';
        
        galleryPreviewContainer.appendChild(icon);
        galleryPreviewContainer.classList.add('d-flex', 'align-items-center', 'justify-content-center');
    }
    
    // Handle image upload and preview
    if (imagesInput) {
        imagesInput.addEventListener('change', function(e) {
            const files = Array.from(e.target.files);
            const previousNewImagesCount = newImagesFiles.length;
            
            files.forEach((file, index) => {
                if (!file.type.match('image.*')) {
                    showError('File bukan gambar', 'Silakan pilih file gambar yang valid.');
                    return;
                }
                
                if (file.size > 5 * 1024 * 1024) {
                    showError('File terlalu besar', 'Ukuran file maksimal 5MB.');
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    const colDiv = document.createElement('div');
                    colDiv.className = 'col-md-4 col-lg-3';
                    
                    const previewItem = document.createElement('div');
                    previewItem.className = 'image-preview-item';
                    
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = 'Preview';
                    img.className = 'img-fluid rounded';
                    img.style.width = '100%';
                    img.style.height = '100px';
                    img.style.objectFit = 'cover';
                    
                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.className = 'remove-image';
                    removeBtn.innerHTML = '<i class="fas fa-times"></i>';
                    removeBtn.title = 'Hapus gambar';
                    
                    const fileId = 'new_' + Date.now() + '_' + index;
                    const fileIndex = newImagesFiles.length;
                    newImagesFiles.push(file);
                    
                    // Jika ini adalah gambar pertama dan belum ada cover, update gallery preview
                    if (previousNewImagesCount === 0 && index === 0 && 
                        (!coverImageInput.files || coverImageInput.files.length === 0)) {
                        updateGalleryPreview(e.target.result);
                    }
                    
                    removeBtn.addEventListener('click', function() {
                        colDiv.remove();
                        newImagesFiles.splice(fileIndex, 1);
                        delete newImagesCaptions[fileId];
                        updateImageCount();
                        validateImageCount();
                        
                        // Jika tidak ada gambar lagi dan tidak ada cover, kembalikan ke placeholder
                        if (newImagesFiles.length === 0 && existingImagesCount === 0 && 
                            (!coverImageInput.files || coverImageInput.files.length === 0)) {
                            restoreGalleryPreviewPlaceholder();
                        }
                    });
                    
                    const captionDiv = document.createElement('div');
                    captionDiv.className = 'image-caption';
                    
                    const captionInput = document.createElement('input');
                    captionInput.type = 'text';
                    captionInput.className = 'form-control form-control-sm mt-1';
                    captionInput.name = 'new_caption_' + fileIndex;
                    captionInput.placeholder = 'Caption...';
                    captionInput.dataset.fileId = fileId;
                    
                    captionInput.addEventListener('input', function() {
                        newImagesCaptions[fileId] = this.value;
                    });
                    
                    captionDiv.appendChild(captionInput);
                    previewItem.appendChild(img);
                    previewItem.appendChild(removeBtn);
                    previewItem.appendChild(captionDiv);
                    colDiv.appendChild(previewItem);
                    imagesPreviewGrid.appendChild(colDiv);
                    
                    updateImageCount();
                    validateImageCount();
                };
                reader.readAsDataURL(file);
            });
            
            this.value = '';
        });
    }
    
    // Delete existing image
    function deleteExistingImage(imageId) {
        let deletedImages = JSON.parse(deletedImagesInput.value || '[]');
        
        if (!deletedImages.includes(parseInt(imageId))) {
            deletedImages.push(parseInt(imageId));
            deletedImagesInput.value = JSON.stringify(deletedImages);
        }
        
        existingImagesCount = Math.max(0, existingImagesCount - 1);
        updateImageCount();
        validateImageCount();
        
        // Jika tidak ada gambar lagi dan tidak ada cover, kembalikan ke placeholder
        if (existingImagesCount === 0 && newImagesFiles.length === 0 && 
            (!coverImageInput.files || coverImageInput.files.length === 0)) {
            restoreGalleryPreviewPlaceholder();
        }
    }
    
    // Update image count in preview
    function updateImageCount() {
        const totalImages = newImagesFiles.length + existingImagesCount;
        previewCount.textContent = totalImages + ' foto';
    }
    
    // Validate image count
    function validateImageCount() {
        const totalImages = newImagesFiles.length + existingImagesCount;
        const method = document.getElementById('formMethod').value;
        
        if (method === 'POST' && totalImages === 0) {
            imagesInput.setAttribute('required', 'required');
            imagesInput.classList.add('is-invalid');
            document.getElementById('images_error').textContent = 'Minimal upload 1 gambar untuk galeri baru';
            return false;
        } else {
            imagesInput.removeAttribute('required');
            imagesInput.classList.remove('is-invalid');
            document.getElementById('images_error').textContent = '';
            return true;
        }
    }
    
    // Initialize Sortable for table
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
        const rows = document.querySelectorAll('#sortableTable tr:not(.sortable-ghost)');
        const urutan = [];
        
        rows.forEach(function(row, index) {
            urutan.push({
                id: row.dataset.id,
                urutan: index + 1
            });
        });
        
        showLoading('Mengupdate urutan...', 'Harap tunggu');
        
        fetch('{{ route("backend.galleries.update-order") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ order: urutan })
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
                        const page = {{ $galleries->currentPage() }};
                        const perPage = {{ $galleries->perPage() }};
                        const number = (page - 1) * perPage + index + 1;
                        numberCell.innerHTML = '<i class="fas fa-arrows-alt handle text-secondary me-2"></i> ' + number;
                    }
                });
                
                showSuccessToast(data.message || 'Urutan galeri berhasil diperbarui.');
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
    
    // Tambah button
    document.getElementById('btnTambah')?.addEventListener('click', openForm);
    document.getElementById('btnTambahEmpty')?.addEventListener('click', openForm);
    
    // Event listeners untuk tombol di tabel menggunakan event delegation
    document.addEventListener('click', function(e) {
        // Edit button
        const editBtn = e.target.closest('.btn-edit');
        if (editBtn) {
            e.preventDefault();
            const id = editBtn.dataset.id;
            console.log('Edit button clicked:', id);
            editData(id);
        }
        
        // Status button
        const statusBtn = e.target.closest('.btn-status');
        if (statusBtn) {
            e.preventDefault();
            const id = statusBtn.dataset.id;
            const status = statusBtn.dataset.status;
            console.log('Status button clicked:', id, status);
            toggleStatus(id, status);
        }
        
        // Hapus button
        const deleteBtn = e.target.closest('.btn-hapus');
        if (deleteBtn) {
            e.preventDefault();
            const id = deleteBtn.dataset.id;
            const title = deleteBtn.dataset.title;
            console.log('Hapus button clicked:', id, title);
            hapusData(id, title);
        }
    });
    
    // Open form for create
    function openForm() {
        // Reset form
        if (form) form.reset();
        document.getElementById('formMethod').value = 'POST';
        document.getElementById('itemId').value = '';
        form.action = '{{ route("backend.galleries.store") }}';
        document.getElementById('modalTitle').textContent = 'Tambah Galeri Baru';
        document.getElementById('is_published').checked = true;
        
        // Set default tanggal ke hari ini
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('tanggal').value = today;
        
        // Reset previews
        imagesPreviewGrid.innerHTML = '';
        existingImagesGrid.innerHTML = '';
        coverPreview.classList.add('d-none');
        coverPreview.src = '';
        
        // Reset data
        newImagesFiles = [];
        newImagesCaptions = {};
        existingImagesCount = 0;
        deletedImagesInput.value = '';
        
        // Reset cover image input
        if (coverImageInput) {
            coverImageInput.value = '';
        }
        
        // Hide stats card
        statsCard.classList.add('d-none');
        
        // Reset gallery preview ke placeholder
        restoreGalleryPreviewPlaceholder();
        
        // Update previews
        previewTitle.textContent = 'Judul Galeri';
        previewDate.textContent = formatDate(today);
        previewCount.textContent = '0 foto';
        
        // Clear validation errors
        clearValidationErrors();
        
        // Set required for images in create mode
        imagesInput.setAttribute('required', 'required');
        
        // Show modal
        if (modal) {
            modal.show();
        }
    }
    
    // Open form for edit
    function editData(id) {
        if (!id) {
            console.error('No ID provided for edit');
            return;
        }
        
        showLoading('Memuat data...', 'Harap tunggu');
        
        fetch('{{ route("backend.galleries.edit", ":id") }}'.replace(':id', id), {
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            closeLoading();
            
            if (data.success) {
                var gallery = data.data;
                
                // Clear previous validation errors
                clearValidationErrors();
                
                // Set form values
                document.getElementById('formMethod').value = 'PUT';
                document.getElementById('itemId').value = gallery.id;
                form.action = '{{ route("backend.galleries.update", ":id") }}'.replace(':id', gallery.id);
                document.getElementById('judul').value = gallery.judul;
                document.getElementById('deskripsi').value = gallery.deskripsi || '';
                document.getElementById('urutan').value = gallery.urutan || 0;
                document.getElementById('is_published').checked = gallery.is_published == 1;
                
                // Set tanggal
                if (gallery.tanggal) {
                    const date = new Date(gallery.tanggal);
                    const formattedDate = date.toISOString().split('T')[0];
                    document.getElementById('tanggal').value = formattedDate;
                    previewDate.textContent = formatDate(formattedDate);
                }
                
                // Update preview title
                previewTitle.textContent = gallery.judul;
                
                // Clear previews
                imagesPreviewGrid.innerHTML = '';
                existingImagesGrid.innerHTML = '';
                
                // Reset data
                newImagesFiles = [];
                newImagesCaptions = {};
                existingImagesCount = 0;
                deletedImagesInput.value = '';
                
                // Reset cover image input
                if (coverImageInput) {
                    coverImageInput.value = '';
                }
                
                // Display existing images
                if (gallery.images && gallery.images.length > 0) {
                    existingImagesCount = gallery.images.length;
                    gallery.images.forEach(function(image, index) {
                        const colDiv = document.createElement('div');
                        colDiv.className = 'col-md-4 col-lg-3';
                        colDiv.dataset.imageId = image.id;
                        
                        const previewItem = document.createElement('div');
                        previewItem.className = 'image-preview-item';
                        
                        const img = document.createElement('img');
                        img.src = '{{ Storage::url("") }}' + image.image;
                        img.alt = 'Existing Image';
                        img.className = 'img-fluid rounded';
                        img.style.width = '100%';
                        img.style.height = '100px';
                        img.style.objectFit = 'cover';
                        
                        const removeBtn = document.createElement('button');
                        removeBtn.type = 'button';
                        removeBtn.className = 'remove-image';
                        removeBtn.innerHTML = '<i class="fas fa-times"></i>';
                        removeBtn.title = 'Hapus gambar';
                        removeBtn.dataset.imageId = image.id;
                        
                        removeBtn.addEventListener('click', function() {
                            deleteExistingImage(this.dataset.imageId);
                            colDiv.remove();
                        });
                        
                        const captionDiv = document.createElement('div');
                        captionDiv.className = 'image-caption';
                        
                        const captionInput = document.createElement('input');
                        captionInput.type = 'text';
                        captionInput.className = 'form-control form-control-sm mt-1';
                        captionInput.name = 'captions[' + image.id + ']';
                        captionInput.value = image.caption || '';
                        captionInput.placeholder = 'Caption...';
                        
                        captionDiv.appendChild(captionInput);
                        previewItem.appendChild(img);
                        previewItem.appendChild(removeBtn);
                        previewItem.appendChild(captionDiv);
                        colDiv.appendChild(previewItem);
                        existingImagesGrid.appendChild(colDiv);
                        
                        // Jika ini gambar pertama dan belum ada cover, gunakan sebagai gallery preview
                        if (index === 0 && !gallery.cover_image) {
                            updateGalleryPreview('{{ Storage::url("") }}' + image.image);
                        }
                    });
                }
                
                // Display cover image if exists
                if (gallery.cover_image) {
                    const coverUrl = '{{ Storage::url("") }}' + gallery.cover_image;
                    coverPreview.src = coverUrl;
                    coverPreview.classList.remove('d-none');
                    
                    // Update gallery preview dengan cover
                    updateGalleryPreview(coverUrl);
                } else if (gallery.images && gallery.images.length > 0) {
                    // Jika tidak ada cover, tapi ada gambar, gunakan gambar pertama
                    const firstImageUrl = '{{ Storage::url("") }}' + gallery.images[0].image;
                    updateGalleryPreview(firstImageUrl);
                } else {
                    // Jika tidak ada cover dan tidak ada gambar, tampilkan placeholder
                    coverPreview.classList.add('d-none');
                    coverPreview.src = '';
                    restoreGalleryPreviewPlaceholder();
                }
                
                // Update image count
                updateImageCount();
                
                // Show stats
                if (gallery.created_at) {
                    const createdDate = new Date(gallery.created_at);
                    document.getElementById('statsCreatedAt').textContent = createdDate.toLocaleDateString('id-ID');
                }
                if (gallery.updated_at) {
                    const updatedDate = new Date(gallery.updated_at);
                    document.getElementById('statsUpdatedAt').textContent = updatedDate.toLocaleDateString('id-ID');
                }
                document.getElementById('statsImages').textContent = existingImagesCount;
                statsCard.classList.remove('d-none');
                
                // Remove required attribute from images for edit mode
                imagesInput.removeAttribute('required');
                
                // Update modal title
                document.getElementById('modalTitle').textContent = 'Edit Galeri';
                
                // Show modal
                if (modal) {
                    modal.show();
                }
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
    
    // Form submission
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Validasi untuk form baru (harus ada minimal 1 gambar)
            const method = document.getElementById('formMethod').value;
            const totalImages = newImagesFiles.length + existingImagesCount;
            
            if (method === 'POST' && totalImages === 0) {
                showError('Validasi Gagal', 'Minimal upload 1 gambar untuk galeri baru');
                return;
            }
            
            // Validasi form
            if (!this.checkValidity()) {
                e.stopPropagation();
                this.classList.add('was-validated');
                return;
            }
            
            showLoading('Menyimpan...', 'Harap tunggu');
            
            // Buat FormData
            const formData = new FormData(this);
            
            // TAMBAHKAN FILE GAMBAR KE FORMDATA
            newImagesFiles.forEach((file, index) => {
                formData.append('images[]', file);
                console.log('Added file to FormData:', file.name, 'index:', index);
            });
            
            // Tambahkan captions untuk gambar baru
            Object.keys(newImagesCaptions).forEach(fileId => {
                if (newImagesCaptions[fileId]) {
                    formData.append('captions[' + fileId + ']', newImagesCaptions[fileId]);
                }
            });
            
            // Debug: Log FormData contents
            console.log('FormData entries:');
            for (let pair of formData.entries()) {
                console.log(pair[0] + ': ' + (typeof pair[1] === 'object' ? pair[1].name : pair[1]));
            }
            
            // Kirim request
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(async function(response) {
                console.log('Response status:', response.status);
                const text = await response.text();
                console.log('Response text:', text);
                
                try {
                    return JSON.parse(text);
                } catch (e) {
                    console.error('JSON parsing error:', e);
                    return { 
                        success: false, 
                        message: 'Invalid JSON response from server',
                        errors: {}
                    };
                }
            })
            .then(function(data) {
                closeLoading();
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
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        } else {
                            location.reload();
                        }
                    });
                } else {
                    // Display validation errors
                    if (data.errors) {
                        // Clear previous errors
                        clearValidationErrors();
                        
                        // Display new errors
                        Object.keys(data.errors).forEach(function(field) {
                            const input = document.querySelector('[name="' + field + '"]');
                            const errorDiv = document.getElementById(field + '_error');
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
                            text: 'Harap perbaiki kesalahan pada form.',
                            showConfirmButton: true
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
                console.error('Fetch error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat menyimpan data.'
                });
            });
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
            text: 'Apakah Anda yakin ingin mengubah status galeri ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#6b02b1',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Ubah!',
            cancelButtonText: 'Batal'
        }).then(function(result) {
            if (result.isConfirmed) {
                showLoading('Mengubah status...', 'Harap tunggu');
                
                var url = '{{ route("backend.galleries.toggle-status", ["id" => ":id", "status" => ":status"]) }}'
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
    
    // Hapus data
    function hapusData(id, title) {
        if (!id || !title) {
            console.error('Missing ID or title for delete');
            return;
        }
        
        Swal.fire({
            title: 'Hapus Galeri?',
            html: 'Apakah Anda yakin ingin menghapus galeri <strong>"' + title + '"</strong>?<br><small class="text-danger">Semua gambar dalam galeri ini juga akan dihapus dan tidak dapat dikembalikan!</small>',
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
                
                fetch('{{ route("backend.galleries.destroy", ":id") }}'.replace(':id', id), {
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
                            text: data.message || 'Gagal menghapus galeri.'
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
            form.classList.remove('was-validated');
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
    
    // Helper functions for loading and toast
    function showLoading(title, text) {
        Swal.fire({
            title: title,
            text: text,
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    }
    
    function closeLoading() {
        Swal.close();
    }
    
    function showSuccessToast(message) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
        Toast.fire({
            icon: 'success',
            title: message
        });
    }
    
    function showError(title, text) {
        Swal.fire({
            icon: 'error',
            title: title,
            text: text,
            showConfirmButton: true
        });
    }
});
</script>
@endpush
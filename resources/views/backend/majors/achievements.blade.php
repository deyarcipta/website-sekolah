@extends('layouts.backend')

@section('title', 'Kelola Prestasi - Dashboard Admin')

@section('content')
    <!-- Header Card -->
    <div class="card shadow mb-4 border-0">
        <div class="card-body py-4">
            <div class="d-flex justify-content-between align-items-center page-header">
                <div>
                    <h1 class="h3 text-gray-800 mb-1">
                        <i class="fas fa-trophy me-2"></i> Kelola Prestasi: {{ $major->name }}
                    </h1>
                    <p class="text-muted mb-0">Kelola prestasi dan pencapaian untuk jurusan {{ $major->name }}</p>
                </div>
                <div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAchievementModal">
                        <i class="fas fa-plus me-1"></i> Tambah Prestasi
                    </button>
                    <a href="{{ route('backend.majors.edit', $major->id) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-edit me-1"></i> Edit Jurusan
                    </a>
                    <a href="{{ route('backend.majors.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Semua Jurusan
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Card -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-trophy fa-2x"></i>
                        </div>
                        <div>
                            <h3 class="mb-0">{{ $achievements->count() }}</h3>
                            <p class="mb-0">Total Prestasi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                        <div>
                            <h3 class="mb-0">{{ $achievements->where('is_active', true)->count() }}</h3>
                            <p class="mb-0">Prestasi Aktif</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-calendar-alt fa-2x"></i>
                        </div>
                        <div>
                            @php
                                $years = $achievements->pluck('year')->unique()->sort()->values();
                            @endphp
                            <h3 class="mb-0">{{ $years->count() }}</h3>
                            <p class="mb-0">Tahun Prestasi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-medal fa-2x"></i>
                        </div>
                        <div>
                            @php
                                $levels = $achievements->pluck('level')->unique()->filter();
                            @endphp
                            <h3 class="mb-0">{{ $levels->count() }}</h3>
                            <p class="mb-0">Tingkat Prestasi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="card shadow mb-4 border-0">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-bold">Filter Tahun</label>
                    <select class="form-select" id="filterYear">
                        <option value="">Semua Tahun</option>
                        @foreach($achievements->pluck('year')->unique()->sortDesc() as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Filter Tingkat</label>
                    <select class="form-select" id="filterLevel">
                        <option value="">Semua Tingkat</option>
                        @foreach($achievements->pluck('level')->unique()->filter() as $level)
                        <option value="{{ $level }}">{{ $level }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Filter Kategori</label>
                    <select class="form-select" id="filterCategory">
                        <option value="">Semua Kategori</option>
                        @foreach($achievements->pluck('category')->unique()->filter() as $category)
                        <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Filter Status</label>
                    <select class="form-select" id="filterStatus">
                        <option value="">Semua Status</option>
                        <option value="active">Aktif</option>
                        <option value="inactive">Nonaktif</option>
                    </select>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <button type="button" class="btn btn-outline-secondary" id="resetFilters">
                        <i class="fas fa-redo me-1"></i> Reset Filter
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Achievements List Card -->
    <div class="card shadow border-0">
        <div class="card-body">
            @if($achievements->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="achievementsTable">
                    <thead class="table-light">
                        <tr>
                            <th width="60">#</th>
                            <th>Gambar</th>
                            <th>Judul Prestasi</th>
                            <th>Tahun</th>
                            <th>Tingkat</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Urutan</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($achievements->sortByDesc('year')->sortBy('order') as $achievement)
                        <tr data-id="{{ $achievement->id }}" 
                            data-year="{{ $achievement->year }}"
                            data-level="{{ $achievement->level }}"
                            data-category="{{ $achievement->category }}"
                            data-status="{{ $achievement->is_active ? 'active' : 'inactive' }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="achievement-photo">
                                    <img src="{{ $achievement->getImageUrl() }}" 
                                         alt="{{ $achievement->title }}" 
                                         class="rounded"
                                         style="width: 80px; height: 60px; object-fit: cover;">
                                </div>
                            </td>
                            <td>
                                <strong class="d-block">{{ $achievement->title }}</strong>
                                <small class="text-muted">{{ Str::limit($achievement->description, 50) ?: '-' }}</small>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $achievement->year }}</span>
                            </td>
                            <td>
                                @if($achievement->level)
                                    <span class="badge bg-warning">{{ $achievement->level }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($achievement->category)
                                    <span class="badge bg-primary">{{ $achievement->category }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($achievement->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-dark">{{ $achievement->order }}</span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" 
                                            class="btn btn-outline-primary edit-achievement" 
                                            data-id="{{ $achievement->id }}"
                                            data-bs-toggle="tooltip"
                                            title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" 
                                            class="btn btn-outline-danger delete-achievement" 
                                            data-id="{{ $achievement->id }}"
                                            data-title="{{ $achievement->title }}"
                                            data-bs-toggle="tooltip"
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
            
            <!-- Year Summary -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card border">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">
                                <i class="fas fa-chart-bar me-2"></i> Ringkasan Per Tahun
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @php
                                    $yearGroups = $achievements->groupBy('year')->sortKeysDesc();
                                @endphp
                                @foreach($yearGroups as $year => $yearAchievements)
                                <div class="col-md-3 col-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <span class="badge bg-info fs-6">{{ $year }}</span>
                                        </div>
                                        <div>
                                            <small class="d-block text-muted">Jumlah Prestasi</small>
                                            <strong class="fs-5">{{ $yearAchievements->count() }}</strong>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="text-center py-5">
                <div class="empty-state">
                    <i class="fas fa-trophy fa-4x text-muted mb-4"></i>
                    <h4 class="text-muted">Belum ada prestasi</h4>
                    <p class="text-muted mb-4">Tambahkan prestasi pertama untuk jurusan {{ $major->name }}</p>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAchievementModal">
                        <i class="fas fa-plus me-1"></i> Tambah Prestasi Pertama
                    </button>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Add Achievement Modal -->
    <div class="modal fade" id="addAchievementModal" tabindex="-1" aria-labelledby="addAchievementModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="addAchievementForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="major_id" value="{{ $major->id }}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addAchievementModalLabel">
                            <i class="fas fa-plus-circle me-2"></i> Tambah Prestasi Baru
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label class="form-label fw-bold">Gambar Prestasi</label>
                                    <div class="image-upload-wrapper">
                                        <div class="image-preview mb-3" id="achievementImagePreview">
                                            <img src="{{ asset('assets/img/default-achievement.jpg') }}" 
                                                 class="img-fluid rounded border"
                                                 style="width: 200px; height: 150px; object-fit: cover;">
                                        </div>
                                        <input type="file" 
                                               class="form-control" 
                                               name="image" 
                                               accept="image/*"
                                               id="achievementImageInput">
                                        <small class="text-muted d-block mt-2">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Rekomendasi: 800x600px, format JPG/PNG
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label class="form-label fw-bold">Judul Prestasi <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control" 
                                               name="title" 
                                               placeholder="Contoh: Juara 1 Lomba Kompetensi Siswa (LKS)"
                                               required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Tahun <span class="text-danger">*</span></label>
                                        <select class="form-select" name="year" required>
                                            <option value="">Pilih Tahun</option>
                                            @for($i = date('Y'); $i >= 2000; $i--)
                                            <option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Tingkat</label>
                                        <select class="form-select" name="level">
                                            <option value="">Pilih Tingkat</option>
                                            <option value="Sekolah">Sekolah</option>
                                            <option value="Kecamatan">Kecamatan</option>
                                            <option value="Kota">Kota</option>
                                            <option value="Provinsi">Provinsi</option>
                                            <option value="Nasional">Nasional</option>
                                            <option value="Internasional">Internasional</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Kategori</label>
                                        <select class="form-select" name="category">
                                            <option value="">Pilih Kategori</option>
                                            <option value="Akademik">Akademik</option>
                                            <option value="Non-Akademik">Non-Akademik</option>
                                            <option value="Olahraga">Olahraga</option>
                                            <option value="Seni">Seni</option>
                                            <option value="Teknologi">Teknologi</option>
                                            <option value="LKS">Lomba Kompetensi Siswa</option>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Urutan Tampilan</label>
                                        <input type="number" 
                                               class="form-control" 
                                               name="order" 
                                               value="{{ $achievements->where('year', date('Y'))->max('order') + 1 ?? 0 }}"
                                               min="0">
                                        <small class="text-muted">Dalam tahun yang sama</small>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label fw-bold">Deskripsi</label>
                                        <textarea class="form-control" 
                                                  name="description" 
                                                  rows="3"
                                                  placeholder="Deskripsi lengkap tentang prestasi..."></textarea>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Status</label>
                                        <select class="form-select" name="is_active">
                                            <option value="1" selected>Aktif</option>
                                            <option value="0">Nonaktif</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="saveAchievementBtn">
                            <i class="fas fa-save me-1"></i> Simpan Prestasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Achievement Modal -->
    <div class="modal fade" id="editAchievementModal" tabindex="-1" aria-labelledby="editAchievementModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="editAchievementForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="achievement_id" id="editAchievementId">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editAchievementModalLabel">
                            <i class="fas fa-edit me-2"></i> Edit Data Prestasi
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="editAchievementContent">
                            <!-- Content will be loaded via AJAX -->
                            <div class="text-center py-4">
                                <i class="fas fa-spinner fa-spin fa-2x text-muted"></i>
                                <p class="mt-2">Memuat data prestasi...</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="updateAchievementBtn">
                            <i class="fas fa-save me-1"></i> Update Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .achievement-photo {
        width: 80px;
        height: 60px;
        border-radius: 6px;
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .achievement-photo:hover {
        transform: scale(1.05);
    }

    .achievement-photo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .empty-state {
        padding: 3rem 0;
    }

    .empty-state i {
        opacity: 0.5;
    }

    .image-upload-wrapper .image-preview {
        text-align: center;
    }

    .image-upload-wrapper input[type="file"] {
        border: 2px dashed #dee2e6;
        padding: 0.5rem;
        background-color: #f8f9fa;
        transition: all 0.3s ease;
    }

    .image-upload-wrapper input[type="file"]:hover {
        border-color: #6b02b1;
        background-color: #f0f4ff;
    }

    .badge {
        font-size: 0.75rem;
        font-weight: 500;
        padding: 0.35em 0.65em;
    }

    .btn-group .btn {
        padding: 0.25rem 0.5rem;
    }

    .table tbody tr {
        transition: background-color 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: rgba(107, 2, 177, 0.05);
    }

    .modal .modal-dialog {
        max-width: 800px;
    }

    .year-summary .badge {
        font-size: 1rem;
        padding: 0.5em 0.8em;
    }

    @media (max-width: 768px) {
        .achievement-photo {
            width: 60px;
            height: 45px;
        }

        .modal .modal-dialog {
            margin: 0.5rem;
        }

        .btn-group {
            flex-wrap: wrap;
        }

        .btn-group .btn {
            margin-bottom: 2px;
        }

        .year-summary .col-md-3 {
            margin-bottom: 1rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Image preview for add form
    const achievementImageInput = document.getElementById('achievementImageInput');
    const achievementImagePreview = document.getElementById('achievementImagePreview').querySelector('img');
    
    if (achievementImageInput && achievementImagePreview) {
        achievementImageInput.addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    achievementImagePreview.src = event.target.result;
                };
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    }

    // Add Achievement Form Submission
    const addAchievementForm = document.getElementById('addAchievementForm');
    if (addAchievementForm) {
        addAchievementForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const saveBtn = document.getElementById('saveAchievementBtn');
            const originalText = saveBtn.innerHTML;
            
            // Show loading
            saveBtn.disabled = true;
            saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...';
            
            try {
                const response = await fetch('{{ route("backend.majors.store.achievement", $major->id) }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Close modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('addAchievementModal'));
                    if (modal) modal.hide();
                    
                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        // Reload page to show new achievement
                        window.location.reload();
                    });
                } else {
                    // Show error message
                    let errorMessage = data.message || 'Terjadi kesalahan';
                    
                    if (data.errors) {
                        // Show first error
                        const firstErrorKey = Object.keys(data.errors)[0];
                        const firstErrorMessage = data.errors[firstErrorKey][0];
                        errorMessage = firstErrorMessage;
                        
                        // Highlight invalid fields
                        const invalidField = addAchievementForm.querySelector(`[name="${firstErrorKey}"]`);
                        if (invalidField) {
                            invalidField.classList.add('is-invalid');
                            const feedback = invalidField.nextElementSibling;
                            if (!feedback || !feedback.classList.contains('invalid-feedback')) {
                                const errorDiv = document.createElement('div');
                                errorDiv.className = 'invalid-feedback';
                                errorDiv.textContent = firstErrorMessage;
                                invalidField.parentNode.insertBefore(errorDiv, invalidField.nextSibling);
                            }
                        }
                    }
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: errorMessage
                    });
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan jaringan. Silakan coba lagi.'
                });
            } finally {
                // Reset button
                saveBtn.disabled = false;
                saveBtn.innerHTML = originalText;
            }
        });
    }

    // Edit Achievement
    document.querySelectorAll('.edit-achievement').forEach(button => {
        button.addEventListener('click', function() {
            const achievementId = this.dataset.id;
            loadEditAchievementForm(achievementId);
        });
    });

    // Load Edit Achievement Form via AJAX
    async function loadEditAchievementForm(achievementId) {
        const editModal = new bootstrap.Modal(document.getElementById('editAchievementModal'));
        const editContent = document.getElementById('editAchievementContent');
        
        // Show loading
        editContent.innerHTML = `
            <div class="text-center py-4">
                <i class="fas fa-spinner fa-spin fa-2x text-muted"></i>
                <p class="mt-2">Memuat data prestasi...</p>
            </div>
        `;
        
        editModal.show();
        
        try {
            // Get achievement data
            const achievement = await getAchievementData(achievementId);
            
            // Build edit form HTML
            const html = `
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label class="form-label fw-bold">Gambar Prestasi</label>
                            <div class="image-upload-wrapper">
                                <div class="image-preview mb-3" id="editAchievementImagePreview">
                                    <img src="${achievement.image_url}" 
                                         class="img-fluid rounded border"
                                         style="width: 200px; height: 150px; object-fit: cover;">
                                </div>
                                <input type="file" 
                                       class="form-control" 
                                       name="image" 
                                       accept="image/*"
                                       id="editAchievementImageInput">
                                <small class="text-muted d-block mt-2">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Kosongkan jika tidak ingin mengganti gambar
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Judul Prestasi <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control" 
                                       name="title" 
                                       value="${achievement.title}"
                                       required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tahun <span class="text-danger">*</span></label>
                                <select class="form-select" name="year" required>
                                    <option value="">Pilih Tahun</option>
                                    @for($i = date('Y'); $i >= 2000; $i--)
                                    <option value="${$i}" ${achievement.year == $i ? 'selected' : ''}>${$i}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tingkat</label>
                                <select class="form-select" name="level">
                                    <option value="">Pilih Tingkat</option>
                                    <option value="Sekolah" ${achievement.level === 'Sekolah' ? 'selected' : ''}>Sekolah</option>
                                    <option value="Kecamatan" ${achievement.level === 'Kecamatan' ? 'selected' : ''}>Kecamatan</option>
                                    <option value="Kota" ${achievement.level === 'Kota' ? 'selected' : ''}>Kota</option>
                                    <option value="Provinsi" ${achievement.level === 'Provinsi' ? 'selected' : ''}>Provinsi</option>
                                    <option value="Nasional" ${achievement.level === 'Nasional' ? 'selected' : ''}>Nasional</option>
                                    <option value="Internasional" ${achievement.level === 'Internasional' ? 'selected' : ''}>Internasional</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Kategori</label>
                                <select class="form-select" name="category">
                                    <option value="">Pilih Kategori</option>
                                    <option value="Akademik" ${achievement.category === 'Akademik' ? 'selected' : ''}>Akademik</option>
                                    <option value="Non-Akademik" ${achievement.category === 'Non-Akademik' ? 'selected' : ''}>Non-Akademik</option>
                                    <option value="Olahraga" ${achievement.category === 'Olahraga' ? 'selected' : ''}>Olahraga</option>
                                    <option value="Seni" ${achievement.category === 'Seni' ? 'selected' : ''}>Seni</option>
                                    <option value="Teknologi" ${achievement.category === 'Teknologi' ? 'selected' : ''}>Teknologi</option>
                                    <option value="LKS" ${achievement.category === 'LKS' ? 'selected' : ''}>Lomba Kompetensi Siswa</option>
                                    <option value="Lainnya" ${achievement.category === 'Lainnya' ? 'selected' : ''}>Lainnya</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Urutan Tampilan</label>
                                <input type="number" 
                                       class="form-control" 
                                       name="order" 
                                       value="${achievement.order}"
                                       min="0">
                                <small class="text-muted">Dalam tahun yang sama</small>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Deskripsi</label>
                                <textarea class="form-control" 
                                          name="description" 
                                          rows="3">${achievement.description || ''}</textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Status</label>
                                <select class="form-select" name="is_active">
                                    <option value="1" ${achievement.is_active ? 'selected' : ''}>Aktif</option>
                                    <option value="0" ${!achievement.is_active ? 'selected' : ''}>Nonaktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            editContent.innerHTML = html;
            document.getElementById('editAchievementId').value = achievementId;
            
            // Setup image preview for edit form
            const editImageInput = document.getElementById('editAchievementImageInput');
            const editImagePreview = document.getElementById('editAchievementImagePreview').querySelector('img');
            
            if (editImageInput && editImagePreview) {
                editImageInput.addEventListener('change', function(e) {
                    if (e.target.files && e.target.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            editImagePreview.src = event.target.result;
                        };
                        reader.readAsDataURL(e.target.files[0]);
                    }
                });
            }
            
        } catch (error) {
            console.error('Error loading achievement data:', error);
            editContent.innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Terjadi kesalahan saat memuat data. Silakan coba lagi.
                </div>
            `;
        }
    }

    // Get achievement data via AJAX
    async function getAchievementData(achievementId) {
        try {
            const response = await fetch(`/api/achievements/${achievementId}`);
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return await response.json();
        } catch (error) {
            // Fallback: try to get from current page data
            const achievementRow = document.querySelector(`tr[data-id="${achievementId}"]`);
            if (achievementRow) {
                return {
                    title: achievementRow.querySelector('td:nth-child(3) strong').textContent,
                    year: achievementRow.querySelector('td:nth-child(4) .badge').textContent,
                    level: achievementRow.querySelector('td:nth-child(5) .badge')?.textContent || '',
                    category: achievementRow.querySelector('td:nth-child(6) .badge')?.textContent || '',
                    order: achievementRow.querySelector('td:nth-child(8) .badge').textContent,
                    is_active: achievementRow.querySelector('td:nth-child(7) .badge').textContent === 'Aktif',
                    image_url: achievementRow.querySelector('.achievement-photo img').src,
                    description: achievementRow.querySelector('td:nth-child(3) small').textContent
                };
            }
            throw error;
        }
    }

    // Edit Achievement Form Submission
    document.addEventListener('submit', async function(e) {
        if (e.target && e.target.id === 'editAchievementForm') {
            e.preventDefault();
            
            const form = e.target;
            const achievementId = document.getElementById('editAchievementId').value;
            const formData = new FormData(form);
            const updateBtn = document.getElementById('updateAchievementBtn');
            const originalText = updateBtn.innerHTML;
            
            // Show loading
            updateBtn.disabled = true;
            updateBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Memperbarui...';
            
            try {
                const response = await fetch('{{ route("backend.majors.update.achievement", "") }}/' + achievementId, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-HTTP-Method-Override': 'PUT'
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Close modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('editAchievementModal'));
                    if (modal) modal.hide();
                    
                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        // Reload page to show updated data
                        window.location.reload();
                    });
                } else {
                    // Show error message
                    let errorMessage = data.message || 'Terjadi kesalahan';
                    
                    if (data.errors) {
                        const firstErrorKey = Object.keys(data.errors)[0];
                        errorMessage = data.errors[firstErrorKey][0];
                    }
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: errorMessage
                    });
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan jaringan. Silakan coba lagi.'
                });
            } finally {
                // Reset button
                updateBtn.disabled = false;
                updateBtn.innerHTML = originalText;
            }
        }
    });

    // Delete Achievement
    document.querySelectorAll('.delete-achievement').forEach(button => {
        button.addEventListener('click', function() {
            const achievementId = this.dataset.id;
            const achievementTitle = this.dataset.title;
            
            Swal.fire({
                title: 'Hapus Prestasi?',
                html: `Apakah Anda yakin ingin menghapus <strong>${achievementTitle}</strong>?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const response = await fetch('{{ route("backend.majors.destroy.achievement", "") }}/' + achievementId, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        });
                        
                        const data = await response.json();
                        
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: data.message,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: data.message
                            });
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat menghapus'
                        });
                    }
                }
            });
        });
    });

    // Reset add form when modal closes
    const addModal = document.getElementById('addAchievementModal');
    if (addModal) {
        addModal.addEventListener('hidden.bs.modal', function () {
            if (addAchievementForm) {
                addAchievementForm.reset();
                // Reset year to current year
                const yearSelect = addAchievementForm.querySelector('select[name="year"]');
                if (yearSelect) {
                    yearSelect.value = new Date().getFullYear();
                }
                // Reset order to next available number for current year
                const orderInput = addAchievementForm.querySelector('input[name="order"]');
                if (orderInput) {
                    const currentYear = new Date().getFullYear();
                    const currentYearAchievements = {{ $achievements->where('year', date('Y'))->count() }};
                    orderInput.value = currentYearAchievements + 1;
                }
            }
            if (achievementImagePreview) {
                achievementImagePreview.src = '{{ asset("assets/img/default-achievement.jpg") }}';
            }
            // Clear validation errors
            const invalidFields = addAchievementForm.querySelectorAll('.is-invalid');
            invalidFields.forEach(field => {
                field.classList.remove('is-invalid');
                const feedback = field.nextElementSibling;
                if (feedback && feedback.classList.contains('invalid-feedback')) {
                    feedback.remove();
                }
            });
        });
    }

    // Filter functionality
    const filterYear = document.getElementById('filterYear');
    const filterLevel = document.getElementById('filterLevel');
    const filterCategory = document.getElementById('filterCategory');
    const filterStatus = document.getElementById('filterStatus');
    const resetFiltersBtn = document.getElementById('resetFilters');
    
    function filterTable() {
        const yearValue = filterYear.value;
        const levelValue = filterLevel.value;
        const categoryValue = filterCategory.value;
        const statusValue = filterStatus.value;
        
        const rows = document.querySelectorAll('#achievementsTable tbody tr');
        let visibleCount = 0;
        
        rows.forEach(row => {
            const rowYear = row.dataset.year;
            const rowLevel = row.dataset.level;
            const rowCategory = row.dataset.category;
            const rowStatus = row.dataset.status;
            
            let showRow = true;
            
            if (yearValue && rowYear !== yearValue) showRow = false;
            if (levelValue && rowLevel !== levelValue) showRow = false;
            if (categoryValue && rowCategory !== categoryValue) showRow = false;
            if (statusValue) {
                if (statusValue === 'active' && rowStatus !== 'active') showRow = false;
                if (statusValue === 'inactive' && rowStatus !== 'inactive') showRow = false;
            }
            
            if (showRow) {
                row.style.display = '';
                visibleCount++;
                // Update row number
                const rowNum = row.querySelector('td:first-child');
                if (rowNum) {
                    rowNum.textContent = visibleCount;
                }
            } else {
                row.style.display = 'none';
            }
        });
        
        // Show message if no rows visible
        const tableBody = document.querySelector('#achievementsTable tbody');
        if (visibleCount === 0) {
            if (!tableBody.querySelector('.no-results')) {
                const noResults = document.createElement('tr');
                noResults.className = 'no-results';
                noResults.innerHTML = `
                    <td colspan="9" class="text-center py-4">
                        <i class="fas fa-search fa-2x text-muted mb-3"></i>
                        <p class="text-muted">Tidak ada prestasi yang sesuai dengan filter</p>
                    </td>
                `;
                tableBody.appendChild(noResults);
            }
        } else {
            const noResults = tableBody.querySelector('.no-results');
            if (noResults) {
                noResults.remove();
            }
        }
    }
    
    // Add event listeners to filters
    [filterYear, filterLevel, filterCategory, filterStatus].forEach(filter => {
        if (filter) {
            filter.addEventListener('change', filterTable);
        }
    });
    
    // Reset filters
    if (resetFiltersBtn) {
        resetFiltersBtn.addEventListener('click', function() {
            filterYear.value = '';
            filterLevel.value = '';
            filterCategory.value = '';
            filterStatus.value = '';
            filterTable();
        });
    }

    // Auto-update order when year changes
    const yearSelect = document.querySelector('select[name="year"]');
    const orderInput = document.querySelector('input[name="order"]');
    
    if (yearSelect && orderInput) {
        yearSelect.addEventListener('change', function() {
            const selectedYear = this.value;
            if (selectedYear) {
                // Count achievements for selected year
                const yearAchievements = {{ $achievements->where('year', date('Y'))->count() }};
                // Set order to next available number
                orderInput.value = yearAchievements + 1;
            }
        });
    }
});

// API route for getting achievement data
</script>
@endpush
@extends('layouts.backend')

@section('title', 'Kelola Pengajar - Dashboard Admin')

@section('content')
    <!-- Header Card -->
    <div class="card shadow mb-4 border-0">
        <div class="card-body py-4">
            <div class="d-flex justify-content-between align-items-center page-header">
                <div>
                    <h1 class="h3 text-gray-800 mb-1">
                        <i class="fas fa-users me-2"></i> Kelola Pengajar: {{ $major->name }}
                    </h1>
                    <p class="text-muted mb-0">Kelola tim pengajar untuk jurusan {{ $major->name }}</p>
                </div>
                <div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTeacherModal">
                        <i class="fas fa-plus me-1"></i> Tambah Pengajar
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
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                        <div>
                            <h3 class="mb-0">{{ $teachers->count() }}</h3>
                            <p class="mb-0">Total Pengajar</p>
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
                            <h3 class="mb-0">{{ $teachers->where('is_active', true)->count() }}</h3>
                            <p class="mb-0">Pengajar Aktif</p>
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
                            <i class="fas fa-user-graduate fa-2x"></i>
                        </div>
                        <div>
                            @php
                                $positions = $teachers->pluck('position')->unique();
                            @endphp
                            <h3 class="mb-0">{{ $positions->count() }}</h3>
                            <p class="mb-0">Jenis Posisi</p>
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
                            <i class="fas fa-image fa-2x"></i>
                        </div>
                        <div>
                            <h3 class="mb-0">{{ $teachers->whereNotNull('image')->count() }}</h3>
                            <p class="mb-0">Dengan Foto</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Teachers List Card -->
    <div class="card shadow border-0">
        <div class="card-body">
            @if($teachers->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="teachersTable">
                    <thead class="table-light">
                        <tr>
                            <th width="60">#</th>
                            <th>Foto</th>
                            <th>Nama Pengajar</th>
                            <th>Posisi</th>
                            <th>Pendidikan</th>
                            <th>Bidang Keahlian</th>
                            <th>Status</th>
                            <th>Urutan</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teachers->sortBy('order') as $teacher)
                        <tr data-id="{{ $teacher->id }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="teacher-photo">
                                    <img src="{{ $teacher->getImageUrl() }}" 
                                         alt="{{ $teacher->name }}" 
                                         class="rounded-circle"
                                         style="width: 50px; height: 50px; object-fit: cover;"
                                         data-bs-toggle="tooltip"
                                         data-bs-placement="top"
                                         title="Klik untuk lihat detail">
                                </div>
                            </td>
                            <td>
                                <strong class="d-block">{{ $teacher->name }}</strong>
                                <small class="text-muted">{{ Str::limit($teacher->bio, 50) ?: '-' }}</small>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $teacher->position }}</span>
                            </td>
                            <td>{{ $teacher->education ?: '-' }}</td>
                            <td>{{ $teacher->expertise ?: '-' }}</td>
                            <td>
                                @if($teacher->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $teacher->order }}</span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" 
                                            class="btn btn-outline-primary edit-teacher" 
                                            data-id="{{ $teacher->id }}"
                                            data-bs-toggle="tooltip"
                                            title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" 
                                            class="btn btn-outline-danger delete-teacher" 
                                            data-id="{{ $teacher->id }}"
                                            data-name="{{ $teacher->name }}"
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
            @else
            <div class="text-center py-5">
                <div class="empty-state">
                    <i class="fas fa-users fa-4x text-muted mb-4"></i>
                    <h4 class="text-muted">Belum ada pengajar</h4>
                    <p class="text-muted mb-4">Tambahkan pengajar pertama untuk jurusan {{ $major->name }}</p>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTeacherModal">
                        <i class="fas fa-plus me-1"></i> Tambah Pengajar Pertama
                    </button>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Add Teacher Modal -->
    <div class="modal fade" id="addTeacherModal" tabindex="-1" aria-labelledby="addTeacherModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="addTeacherForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="major_id" value="{{ $major->id }}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTeacherModalLabel">
                            <i class="fas fa-plus-circle me-2"></i> Tambah Pengajar Baru
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label class="form-label fw-bold">Foto Pengajar</label>
                                    <div class="image-upload-wrapper">
                                        <div class="image-preview mb-3" id="teacherImagePreview">
                                            <img src="{{ asset('assets/img/default-teacher.png') }}" 
                                                 class="img-fluid rounded-circle border"
                                                 style="width: 150px; height: 150px; object-fit: cover;">
                                        </div>
                                        <input type="file" 
                                               class="form-control" 
                                               name="image" 
                                               accept="image/*"
                                               id="teacherImageInput">
                                        <small class="text-muted d-block mt-2">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Rekomendasi: 500x500px, format JPG/PNG
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control" 
                                               name="name" 
                                               placeholder="Contoh: Dr. Siti Rahmawati, S.Kom."
                                               required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Posisi/Jabatan <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control" 
                                               name="position" 
                                               placeholder="Contoh: Kepala Jurusan TKJ"
                                               required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Pendidikan Terakhir</label>
                                        <input type="text" 
                                               class="form-control" 
                                               name="education" 
                                               placeholder="Contoh: S1 Teknik Informatika">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Bidang Keahlian</label>
                                        <input type="text" 
                                               class="form-control" 
                                               name="expertise" 
                                               placeholder="Contoh: Jaringan Komputer, Pemrograman">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label fw-bold">Biografi Singkat</label>
                                        <textarea class="form-control" 
                                                  name="bio" 
                                                  rows="3"
                                                  placeholder="Deskripsi singkat tentang pengajar..."></textarea>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Urutan Tampilan</label>
                                        <input type="number" 
                                               class="form-control" 
                                               name="order" 
                                               value="{{ $teachers->max('order') + 1 ?? 0 }}"
                                               min="0">
                                        <small class="text-muted">Semakin kecil angka, semakin awal ditampilkan</small>
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
                        <button type="submit" class="btn btn-primary" id="saveTeacherBtn">
                            <i class="fas fa-save me-1"></i> Simpan Pengajar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Teacher Modal -->
    <div class="modal fade" id="editTeacherModal" tabindex="-1" aria-labelledby="editTeacherModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="editTeacherForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="teacher_id" id="editTeacherId">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTeacherModalLabel">
                            <i class="fas fa-edit me-2"></i> Edit Data Pengajar
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="editTeacherContent">
                            <!-- Content will be loaded via AJAX -->
                            <div class="text-center py-4">
                                <i class="fas fa-spinner fa-spin fa-2x text-muted"></i>
                                <p class="mt-2">Memuat data pengajar...</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="updateTeacherBtn">
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
    .teacher-photo {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        overflow: hidden;
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    .teacher-photo:hover {
        transform: scale(1.1);
    }

    .teacher-photo img {
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

    @media (max-width: 768px) {
        .teacher-photo {
            width: 40px;
            height: 40px;
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
    const teacherImageInput = document.getElementById('teacherImageInput');
    const teacherImagePreview = document.getElementById('teacherImagePreview').querySelector('img');
    
    if (teacherImageInput && teacherImagePreview) {
        teacherImageInput.addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    teacherImagePreview.src = event.target.result;
                };
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    }

    // Add Teacher Form Submission
    const addTeacherForm = document.getElementById('addTeacherForm');
    if (addTeacherForm) {
        addTeacherForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const saveBtn = document.getElementById('saveTeacherBtn');
            const originalText = saveBtn.innerHTML;
            
            // Show loading
            saveBtn.disabled = true;
            saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...';
            
            try {
                const response = await fetch('{{ route("backend.majors.store.teacher", $major->id) }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Close modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('addTeacherModal'));
                    if (modal) modal.hide();
                    
                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        // Reload page to show new teacher
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
                        const invalidField = addTeacherForm.querySelector(`[name="${firstErrorKey}"]`);
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

    // Edit Teacher
    document.querySelectorAll('.edit-teacher').forEach(button => {
        button.addEventListener('click', function() {
            const teacherId = this.dataset.id;
            loadEditTeacherForm(teacherId);
        });
    });

    // Load Edit Teacher Form via AJAX
    async function loadEditTeacherForm(teacherId) {
        const editModal = new bootstrap.Modal(document.getElementById('editTeacherModal'));
        const editContent = document.getElementById('editTeacherContent');
        
        // Show loading
        editContent.innerHTML = `
            <div class="text-center py-4">
                <i class="fas fa-spinner fa-spin fa-2x text-muted"></i>
                <p class="mt-2">Memuat data pengajar...</p>
            </div>
        `;
        
        editModal.show();
        
        try {
            // Get teacher data from controller
            const teacher = await getTeacherData(teacherId);
            
            // Build edit form HTML
            const html = `
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label class="form-label fw-bold">Foto Pengajar</label>
                            <div class="image-upload-wrapper">
                                <div class="image-preview mb-3" id="editTeacherImagePreview">
                                    <img src="${teacher.image_url}" 
                                         class="img-fluid rounded-circle border"
                                         style="width: 150px; height: 150px; object-fit: cover;">
                                </div>
                                <input type="file" 
                                       class="form-control" 
                                       name="image" 
                                       accept="image/*"
                                       id="editTeacherImageInput">
                                <small class="text-muted d-block mt-2">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Kosongkan jika tidak ingin mengganti foto
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control" 
                                       name="name" 
                                       value="${teacher.name}"
                                       required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Posisi/Jabatan <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control" 
                                       name="position" 
                                       value="${teacher.position}"
                                       required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Pendidikan Terakhir</label>
                                <input type="text" 
                                       class="form-control" 
                                       name="education" 
                                       value="${teacher.education || ''}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Bidang Keahlian</label>
                                <input type="text" 
                                       class="form-control" 
                                       name="expertise" 
                                       value="${teacher.expertise || ''}">
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Biografi Singkat</label>
                                <textarea class="form-control" 
                                          name="bio" 
                                          rows="3">${teacher.bio || ''}</textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Urutan Tampilan</label>
                                <input type="number" 
                                       class="form-control" 
                                       name="order" 
                                       value="${teacher.order}"
                                       min="0">
                                <small class="text-muted">Semakin kecil angka, semakin awal ditampilkan</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Status</label>
                                <select class="form-select" name="is_active">
                                    <option value="1" ${teacher.is_active ? 'selected' : ''}>Aktif</option>
                                    <option value="0" ${!teacher.is_active ? 'selected' : ''}>Nonaktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            editContent.innerHTML = html;
            document.getElementById('editTeacherId').value = teacherId;
            
            // Setup image preview for edit form
            const editImageInput = document.getElementById('editTeacherImageInput');
            const editImagePreview = document.getElementById('editTeacherImagePreview').querySelector('img');
            
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
            console.error('Error loading teacher data:', error);
            editContent.innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Terjadi kesalahan saat memuat data. Silakan coba lagi.
                </div>
            `;
        }
    }

    // Get teacher data via AJAX
    async function getTeacherData(teacherId) {
        try {
            const response = await fetch(`/api/teachers/${teacherId}`);
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return await response.json();
        } catch (error) {
            // Fallback: try to get from current page data
            const teacherRow = document.querySelector(`tr[data-id="${teacherId}"]`);
            if (teacherRow) {
                return {
                    name: teacherRow.querySelector('td:nth-child(3) strong').textContent,
                    position: teacherRow.querySelector('td:nth-child(4) .badge').textContent,
                    education: teacherRow.querySelector('td:nth-child(5)').textContent,
                    expertise: teacherRow.querySelector('td:nth-child(6)').textContent,
                    order: teacherRow.querySelector('td:nth-child(8) .badge').textContent,
                    is_active: teacherRow.querySelector('td:nth-child(7) .badge').textContent === 'Aktif',
                    image_url: teacherRow.querySelector('.teacher-photo img').src,
                    bio: teacherRow.querySelector('td:nth-child(3) small').textContent
                };
            }
            throw error;
        }
    }

    // Edit Teacher Form Submission
    document.addEventListener('submit', async function(e) {
        if (e.target && e.target.id === 'editTeacherForm') {
            e.preventDefault();
            
            const form = e.target;
            const teacherId = document.getElementById('editTeacherId').value;
            const formData = new FormData(form);
            const updateBtn = document.getElementById('updateTeacherBtn');
            const originalText = updateBtn.innerHTML;
            
            // Show loading
            updateBtn.disabled = true;
            updateBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Memperbarui...';
            
            try {
                const response = await fetch('{{ route("backend.majors.update.teacher", "") }}/' + teacherId, {
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
                    const modal = bootstrap.Modal.getInstance(document.getElementById('editTeacherModal'));
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

    // Delete Teacher
    document.querySelectorAll('.delete-teacher').forEach(button => {
        button.addEventListener('click', function() {
            const teacherId = this.dataset.id;
            const teacherName = this.dataset.name;
            
            Swal.fire({
                title: 'Hapus Pengajar?',
                html: `Apakah Anda yakin ingin menghapus <strong>${teacherName}</strong>?`,
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
                        const response = await fetch('{{ route("backend.majors.destroy.teacher", "") }}/' + teacherId, {
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
    const addModal = document.getElementById('addTeacherModal');
    if (addModal) {
        addModal.addEventListener('hidden.bs.modal', function () {
            if (addTeacherForm) {
                addTeacherForm.reset();
                // Reset order to next available number
                const orderInput = addTeacherForm.querySelector('input[name="order"]');
                if (orderInput) {
                    orderInput.value = {{ $teachers->max('order') + 1 ?? 0 }};
                }
            }
            if (teacherImagePreview) {
                teacherImagePreview.src = '{{ asset("assets/img/default-teacher.png") }}';
            }
            // Clear validation errors
            const invalidFields = addTeacherForm.querySelectorAll('.is-invalid');
            invalidFields.forEach(field => {
                field.classList.remove('is-invalid');
                const feedback = field.nextElementSibling;
                if (feedback && feedback.classList.contains('invalid-feedback')) {
                    feedback.remove();
                }
            });
        });
    }

    // Make table rows sortable (drag and drop)
    const teachersTable = document.getElementById('teachersTable');
    if (teachersTable && typeof Sortable !== 'undefined') {
        new Sortable(teachersTable.querySelector('tbody'), {
            animation: 150,
            handle: '.teacher-photo',
            onEnd: async function(evt) {
                const items = Array.from(evt.from.children);
                const orderData = items.map((row, index) => ({
                    id: row.dataset.id,
                    order: index + 1
                }));
                
                try {
                    // Show loading
                    const originalOrders = Array.from(items).map(row => 
                        row.querySelector('td:nth-child(8) .badge').textContent
                    );
                    
                    // Update UI immediately
                    items.forEach((row, index) => {
                        const orderBadge = row.querySelector('td:nth-child(8) .badge');
                        if (orderBadge) {
                            orderBadge.textContent = index + 1;
                        }
                        const numberCell = row.querySelector('td:nth-child(1)');
                        if (numberCell) {
                            numberCell.textContent = index + 1;
                        }
                    });
                    
                    // Send update to server
                    const response = await fetch('{{ route("backend.majors.teachers.reorder", $major->id) }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ orders: orderData })
                    });
                    
                    const data = await response.json();
                    if (!data.success) {
                        // Revert on error
                        items.forEach((row, index) => {
                            const orderBadge = row.querySelector('td:nth-child(8) .badge');
                            if (orderBadge) {
                                orderBadge.textContent = originalOrders[index];
                            }
                        });
                        throw new Error('Failed to update order');
                    }
                } catch (error) {
                    console.error('Error updating order:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Gagal memperbarui urutan. Silakan coba lagi.'
                    });
                }
            }
        });
    }
});

// Add API route for getting teacher data
// Tambahkan di routes/api.php atau buat route khusus
</script>
@endpush
@extends('layouts.backend')

@section('title', 'Keunggulan Sekolah - Dashboard Admin')

@section('content')
    <!-- Header Card -->
    <div class="card shadow mb-4 border-0">
        <div class="card-body py-4">
            <div class="d-flex justify-content-between align-items-center page-header">
                <div>
                    <h1 class="h3 text-gray-800 mb-1">
                        <i class="fas fa-star me-2"></i> Kelola Keunggulan Sekolah
                    </h1>
                    <p class="text-muted mb-0">Kelola keunggulan dan kelebihan sekolah yang ditampilkan di halaman depan</p>
                </div>
                <div>
                    <button type="button" class="btn btn-primary" id="btnTambah">
                        <i class="fas fa-plus me-1"></i> Tambah Keunggulan
                    </button>
                    <a href="#" target="_blank" class="btn btn-outline-info">
                        <i class="fas fa-external-link-alt me-1"></i> Lihat di Frontend
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="card shadow-lg border-0 rounded-5 overflow-hidden">
        <div class="card-body p-0">
            @if($keunggulan->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-star fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada keunggulan sekolah</h5>
                    <p class="text-muted">Mulai dengan menambahkan keunggulan baru</p>
                    <button type="button" class="btn btn-primary" id="btnTambahEmpty">
                        <i class="fas fa-plus me-1"></i> Tambah Keunggulan Pertama
                    </button>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4" width="50">#</th>
                                <th class="ps-3" width="80">Icon</th>
                                <th>Judul</th>
                                <th>Deskripsi</th>
                                <th width="100">Status</th>
                                <th width="100" class="text-center">Urutan</th>
                                <th width="120" class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="sortable-table" id="sortableTable">
                            @foreach($keunggulan as $item)
                                <tr data-id="{{ $item->id }}">
                                    <td class="ps-4">
                                        <i class="fas fa-arrows-alt handle text-secondary me-2"></i>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="ps-3">
                                        <div class="icon-wrapper">
                                            @if($item->icon)
                                                <i class="{{ $item->icon }} fa-lg" 
                                                   style="color: {{ $item->warna ?? '#007bff' }};"></i>
                                            @else
                                                <i class="fas fa-star fa-lg" 
                                                   style="color: {{ $item->warna ?? '#007bff' }};"></i>
                                            @endif
                                            <div class="color-preview mt-1" 
                                                 style="width: 20px; height: 3px; background-color: {{ $item->warna ?? '#007bff' }};"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <strong class="text-dark">{{ $item->judul }}</strong>
                                        </div>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ Str::limit($item->deskripsi, 60) }}
                                        </small>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $item->is_active ? 'success' : 'secondary' }}">
                                            {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-secondary">{{ $item->urutan }}</span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group" role="group">
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-primary btn-edit"
                                                    data-id="{{ $item->id }}"
                                                    title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-danger btn-hapus"
                                                    data-id="{{ $item->id }}"
                                                    data-name="{{ $item->judul }}"
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
            @endif
        </div>
    </div>

    <!-- Modal Form -->
    <div class="modal fade" id="modalForm" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="formKeunggulan">
                    @csrf
                    <input type="hidden" id="formMethod" name="_method" value="POST">
                    <input type="hidden" id="itemId" name="id">
                    
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-star me-2"></i>
                            <span id="modalTitle">Tambah Keunggulan Sekolah</span>
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
                                        Judul Keunggulan <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control" 
                                           name="judul" 
                                           id="judul"
                                           placeholder="Contoh: Guru Berpengalaman"
                                           required>
                                    <div class="invalid-feedback" id="judul_error"></div>
                                </div>
                                
                                <!-- Deskripsi -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Deskripsi
                                    </label>
                                    <textarea class="form-control" 
                                              name="deskripsi" 
                                              id="deskripsi"
                                              rows="3"
                                              placeholder="Masukkan deskripsi keunggulan..."></textarea>
                                    <div class="invalid-feedback" id="deskripsi_error"></div>
                                </div>
                                
                                <!-- Urutan -->
                                <div class="mb-3">
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
                            
                            <!-- Right Column -->
                            <div class="col-md-4">
                                <!-- Icon -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Icon Font Awesome
                                    </label>
                                    <div class="text-center mb-3">
                                        <div class="icon-preview-wrapper border rounded p-3">
                                            <i class="fas fa-star fa-3x" 
                                               id="iconPreview" 
                                               style="color: #007bff;"></i>
                                            <div class="mt-2 small" id="iconName">fas fa-star</div>
                                        </div>
                                    </div>
                                    <input type="text" 
                                           class="form-control" 
                                           name="icon" 
                                           id="icon"
                                           placeholder="fas fa-star"
                                           value="fas fa-star">
                                    <div class="form-text">
                                        Masukkan class icon Font Awesome. Contoh: fas fa-star, fas fa-check, etc.
                                    </div>
                                </div>
                                
                                <!-- Warna -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Warna Icon
                                    </label>
                                    <div class="input-group mb-2">
                                        <input type="color" 
                                               class="form-control form-control-color" 
                                               name="warna" 
                                               id="warna"
                                               value="#007bff"
                                               title="Pilih warna">
                                        <input type="text" 
                                               class="form-control" 
                                               id="warna_hex"
                                               value="#007bff"
                                               placeholder="#007bff">
                                    </div>
                                    <div class="form-text">Warna dalam format HEX</div>
                                </div>
                                
                                <!-- Status -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Status
                                    </label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               name="is_active" 
                                               id="is_active" 
                                               value="1" 
                                               checked>
                                        <label class="form-check-label" for="is_active">
                                            <span id="statusLabel">Aktif</span>
                                        </label>
                                    </div>
                                    <div class="form-text">
                                        Keunggulan aktif akan ditampilkan di halaman depan
                                    </div>
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
.icon-wrapper {
    width: 50px;
    height: 50px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.icon-preview-wrapper {
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

.form-control-color {
    height: 38px;
    width: 60px;
    padding: 5px;
}

.handle {
    cursor: move;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = new bootstrap.Modal('#modalForm');
    const form = document.getElementById('formKeunggulan');
    const iconInput = document.getElementById('icon');
    const iconPreview = document.getElementById('iconPreview');
    const iconName = document.getElementById('iconName');
    const warnaInput = document.getElementById('warna');
    const warnaHexInput = document.getElementById('warna_hex');
    
    // Initialize Sortable
    const sortableTable = document.getElementById('sortableTable');
    if (sortableTable) {
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
        
        rows.forEach((row, index) => {
            urutan.push({
                id: row.dataset.id,
                urutan: index + 1
            });
        });
        
        fetch('{{ route("backend.keunggulan-sekolah.update-urutan") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ urutan: urutan })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update row numbers
                rows.forEach((row, index) => {
                    const numberCell = row.querySelector('td:first-child');
                    if (numberCell) {
                        numberCell.innerHTML = `<i class="fas fa-arrows-alt handle text-secondary me-2"></i> ${index + 1}`;
                    }
                });
                
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message || 'Urutan keunggulan berhasil diperbarui.',
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        });
    }
    
    // Icon preview
    if (iconInput) {
        iconInput.addEventListener('input', function(e) {
            const iconClass = e.target.value.trim();
            if (iconClass) {
                iconPreview.className = iconClass + ' fa-3x';
                iconName.textContent = iconClass;
            }
        });
    }
    
    // Color picker sync
    if (warnaInput && warnaHexInput) {
        warnaInput.addEventListener('input', function() {
            warnaHexInput.value = this.value;
            updateIconColor();
        });
        
        warnaHexInput.addEventListener('input', function() {
            const color = this.value;
            if (/^#[0-9A-F]{6}$/i.test(color)) {
                warnaInput.value = color;
                updateIconColor();
            }
        });
    }
    
    function updateIconColor() {
        iconPreview.style.color = warnaInput.value;
    }
    
    // Status toggle
    const statusToggle = document.getElementById('is_active');
    const statusLabel = document.getElementById('statusLabel');
    
    if (statusToggle) {
        statusToggle.addEventListener('change', function() {
            statusLabel.textContent = this.checked ? 'Aktif' : 'Nonaktif';
        });
    }
    
    // Tambah button
    document.getElementById('btnTambah')?.addEventListener('click', openForm);
    document.getElementById('btnTambahEmpty')?.addEventListener('click', openForm);
    
    // Edit button
    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            editData(id);
        });
    });
    
    // Hapus button
    document.querySelectorAll('.btn-hapus').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.name;
            hapusData(id, name);
        });
    });
    
    // Open form for create
    function openForm() {
        form.reset();
        document.getElementById('formMethod').value = 'POST';
        document.getElementById('itemId').value = '';
        document.getElementById('modalTitle').textContent = 'Tambah Keunggulan Sekolah';
        document.getElementById('is_active').checked = true;
        document.getElementById('statusLabel').textContent = 'Aktif';
        
        // Reset icon preview
        iconPreview.className = 'fas fa-star fa-3x';
        iconName.textContent = 'fas fa-star';
        
        // Reset color
        warnaInput.value = '#007bff';
        warnaHexInput.value = '#007bff';
        updateIconColor();
        
        clearValidationErrors();
        modal.show();
    }
    
    // Open form for edit
    function editData(id) {
        fetch(`/backend/keunggulan-sekolah/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const item = data.data;
                    
                    // Clear previous validation errors
                    clearValidationErrors();
                    
                    // Set form values
                    document.getElementById('formMethod').value = 'PUT';
                    document.getElementById('itemId').value = item.id;
                    document.getElementById('judul').value = item.judul;
                    document.getElementById('deskripsi').value = item.deskripsi || '';
                    document.getElementById('icon').value = item.icon || 'fas fa-star';
                    document.getElementById('urutan').value = item.urutan || 0;
                    document.getElementById('is_active').checked = item.is_active == 1;
                    document.getElementById('statusLabel').textContent = item.is_active ? 'Aktif' : 'Nonaktif';
                    
                    // Set icon preview
                    const iconClass = item.icon || 'fas fa-star';
                    iconPreview.className = iconClass + ' fa-3x';
                    iconName.textContent = iconClass;
                    
                    // Set color
                    const warna = item.warna || '#007bff';
                    warnaInput.value = warna;
                    warnaHexInput.value = warna;
                    updateIconColor();
                    
                    // Update modal title
                    document.getElementById('modalTitle').textContent = 'Edit Keunggulan Sekolah';
                    
                    modal.show();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat mengambil data.'
                });
            });
    }
    
    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const method = document.getElementById('formMethod').value;
        
        // Set URL based on method
        let url = '{{ route("backend.keunggulan-sekolah.store") }}';
        if (method === 'PUT') {
            const id = document.getElementById('itemId').value;
            url = '{{ route("backend.keunggulan-sekolah.update", ":id") }}'.replace(':id', id);
            formData.append('_method', 'PUT');
        }
        
        // Show loading
        const btnSimpan = document.getElementById('btnSimpan');
        const originalText = btnSimpan.innerHTML;
        btnSimpan.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...';
        btnSimpan.disabled = true;
        
        fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                modal.hide();
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            } else {
                // Display validation errors
                if (data.errors) {
                    Object.keys(data.errors).forEach(field => {
                        const input = document.querySelector(`[name="${field}"]`);
                        const errorDiv = document.getElementById(`${field}_error`);
                        if (input) {
                            input.classList.add('is-invalid');
                        }
                        if (errorDiv) {
                            errorDiv.textContent = data.errors[field][0];
                        }
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
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Terjadi kesalahan saat menyimpan data.'
            });
        })
        .finally(() => {
            btnSimpan.innerHTML = originalText;
            btnSimpan.disabled = false;
        });
    });
    
    // Hapus data
    function hapusData(id, name) {
        Swal.fire({
            title: 'Hapus Keunggulan?',
            html: `Apakah Anda yakin ingin menghapus <strong>"${name}"</strong>?<br>
                  <small class="text-danger">Data yang dihapus tidak dapat dikembalikan!</small>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/backend/keunggulan-sekolah/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Terhapus!',
                            text: data.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: data.message || 'Gagal menghapus keunggulan.'
                        });
                    }
                })
                .catch(error => {
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
        form.querySelectorAll('.is-invalid').forEach(field => {
            field.classList.remove('is-invalid');
        });
        form.querySelectorAll('.invalid-feedback').forEach(errorDiv => {
            errorDiv.textContent = '';
        });
    }
    
    // Remove invalid class on input
    form.querySelectorAll('input, select, textarea').forEach(field => {
        field.addEventListener('input', function() {
            this.classList.remove('is-invalid');
            const errorDiv = document.getElementById(`${this.name}_error`);
            if (errorDiv) {
                errorDiv.textContent = '';
            }
        });
    });
});
</script>
@endpush
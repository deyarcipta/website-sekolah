@extends('layouts.backend')

@section('title', 'Kelola Agenda Sekolah - Dashboard Admin')

@section('content')
    <!-- Header Card -->
    <div class="card shadow mb-4 border-0">
        <div class="card-body py-4">
            <div class="d-flex justify-content-between align-items-center page-header">
                <div>
                    <h1 class="h3 text-gray-800 mb-1">
                        <i class="fas fa-calendar-alt me-2"></i> Kelola Agenda Sekolah
                    </h1>
                    <p class="text-muted mb-0">Kelola agenda sekolah yang akan ditampilkan di website</p>
                </div>
                <div>
                    <button type="button" class="btn btn-primary" id="btnTambah">
                        <i class="fas fa-plus me-1"></i> Tambah Agenda
                    </button>
                    <a href="{{ url('/') }}" target="_blank" class="btn btn-outline-info">
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
                                    <i class="fas fa-calendar-alt fa-2x text-white"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="mb-0">{{ $totalAgenda }}</h5>
                                    <small class="text-white">Total Agenda</small>
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
            <form action="{{ route('backend.agenda-sekolah.index') }}" method="GET" class="row g-3">
                <div class="col-md-5">
                    <label class="form-label fw-bold">Cari Agenda</label>
                    <input type="text" class="form-control" name="search" placeholder="Judul, deskripsi, atau lokasi..." value="{{ request('search') }}">
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
            @if($agenda->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-calendar-alt fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada agenda</h5>
                    <p class="text-muted">Mulai dengan menambahkan agenda baru</p>
                    <button type="button" class="btn btn-primary" id="btnTambahEmpty">
                        <i class="fas fa-plus me-1"></i> Tambah Agenda Pertama
                    </button>
                </div>
            @else
                <div class="table-responsive" style="overflow-x: auto; max-height: 70vh; min-width: 100%;">
                    <table class="table table-hover mb-0" style="min-width: 1200px;">
                        <thead class="bg-light" style="position: sticky; top: 0; z-index: 10; background: #f8f9fa;">
                            <tr>
                                <th class="ps-4" width="50">#</th>
                                <th class="ps-3" width="100">Tanggal</th>
                                <th width="400">Judul & Deskripsi</th>
                                <th width="150">Waktu & Lokasi</th>
                                <th width="100">Status</th>
                                <th width="100" class="text-center">Urutan</th>
                                <th width="180" class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="sortable-table" id="sortableTable">
                            @foreach($agenda as $item)
                                <tr data-id="{{ $item->id }}">
                                    <td class="ps-4">
                                        <i class="fas fa-arrows-alt handle text-secondary me-2"></i>
                                        {{ ($agenda->currentPage() - 1) * $agenda->perPage() + $loop->iteration }}
                                    </td>
                                    <td class="ps-3">
                                        <div class="d-flex flex-column align-items-center">
                                            <div class="text-center p-2 rounded" style="background-color: {{ $item->warna }}20; color: {{ $item->warna }}; border: 1px solid {{ $item->warna }}40; min-width: 70px;">
                                                <div class="small">{{ $item->bulan }}</div>
                                                <div class="h4 mb-0">{{ $item->hari }}</div>
                                            </div>
                                            <small class="text-muted mt-1">{{ $item->tanggal_format }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column" style="max-height: 100px; overflow: hidden;">
                                            <strong class="text-dark">{{ Str::limit($item->judul, 80) }}</strong>
                                            <small class="text-muted mt-1">
                                                {{ Str::limit($item->deskripsi, 150) }}
                                            </small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column small">
                                            @if($item->waktu)
                                                <div>
                                                    <i class="fas fa-clock text-info me-1"></i> {{ $item->waktu_format }}
                                                </div>
                                            @endif
                                            @if($item->lokasi)
                                                <div>
                                                    <i class="fas fa-map-marker-alt text-success me-1"></i> {{ Str::limit($item->lokasi, 40) }}
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column gap-1">
                                            <span class="badge bg-{{ $item->is_published ? 'success' : 'warning' }}">
                                                {{ $item->is_published ? 'Published' : 'Draft' }}
                                            </span>
                                            @if($item->published_at)
                                                <small class="text-muted">
                                                    <i class="fas fa-calendar me-1"></i> {{ $item->published_at->format('d/m/Y') }}
                                                </small>
                                            @endif
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
                                            
                                            <!-- Tombol untuk draft -->
                                            @if(!$item->is_published)
                                                <!-- Tombol Publish -->
                                                <button type="button" 
                                                        class="btn btn-outline-success btn-status"
                                                        data-id="{{ $item->id }}"
                                                        data-status="publish"
                                                        title="Publikasikan">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @else
                                                <!-- Tombol Draft -->
                                                <button type="button" 
                                                        class="btn btn-outline-warning btn-status"
                                                        data-id="{{ $item->id }}"
                                                        data-status="draft"
                                                        title="Jadikan Draft">
                                                    <i class="fas fa-edit"></i>
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
                @if($agenda->hasPages())
                    <div class="card-footer border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted small">
                                Menampilkan {{ $agenda->firstItem() }} - {{ $agenda->lastItem() }} dari {{ $agenda->total() }} agenda
                            </div>
                            <div>
                                {{ $agenda->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>

    <!-- Modal Form -->
    <div class="modal fade" id="modalForm" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="formAgenda" novalidate>
                    @csrf
                    <input type="hidden" id="formMethod" name="_method" value="POST">
                    <input type="hidden" id="itemId" name="id">
                    
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-calendar-alt me-2"></i>
                            <span id="modalTitle">Tambah Agenda Baru</span>
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
                                        Judul Agenda <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control" 
                                           name="judul" 
                                           id="judul"
                                           placeholder="Masukkan judul agenda"
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
                                              placeholder="Deskripsi singkat agenda"></textarea>
                                    <div class="invalid-feedback" id="deskripsi_error"></div>
                                </div>
                                
                                <!-- Tanggal & Waktu -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">
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
                                        <label class="form-label fw-bold">
                                            Waktu
                                        </label>
                                        <input type="time" 
                                               class="form-control" 
                                               name="waktu" 
                                               id="waktu">
                                        <div class="invalid-feedback" id="waktu_error"></div>
                                    </div>
                                </div>
                                
                                <!-- Lokasi -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Lokasi
                                    </label>
                                    <input type="text" 
                                           class="form-control" 
                                           name="lokasi" 
                                           id="lokasi"
                                           placeholder="Masukkan lokasi agenda">
                                    <div class="invalid-feedback" id="lokasi_error"></div>
                                </div>
                            </div>
                            
                            <!-- Right Column -->
                            <div class="col-md-4">
                                <!-- Warna -->
                                <div class="card border-0 bg-light mb-3">
                                    <div class="card-body">
                                        <label class="form-label fw-bold">
                                            Warna Tampilan
                                        </label>
                                        <div class="d-flex align-items-center mb-2">
                                            <input type="color" 
                                                   class="form-control form-control-color" 
                                                   name="warna" 
                                                   id="warna"
                                                   value="#6b02b1"
                                                   title="Pilih warna untuk agenda">
                                            <span class="ms-2 small" id="warnaText">#6b02b1</span>
                                        </div>
                                        <div class="form-text">
                                            Warna akan digunakan untuk tampilan tanggal
                                        </div>
                                        <div class="invalid-feedback" id="warna_error"></div>
                                    </div>
                                </div>
                                
                                <!-- Status & Urutan -->
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
                                                Agenda akan langsung tampil di website
                                            </div>
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
                                </div>
                                
                                <!-- Preview Tanggal -->
                                <div class="card border-0 bg-light">
                                    <div class="card-body">
                                        <label class="form-label fw-bold">
                                            Preview Tampilan
                                        </label>
                                        <div class="text-center">
                                            <div class="d-flex gap-3 mb-4 justify-content-center">
                                                <!-- Kotak Tanggal Preview -->
                                                <div class="agenda-date flex-shrink-0" id="datePreview">
                                                    <div class="agenda-month">Jun 2025</div>
                                                    <div class="agenda-day">15</div>
                                                </div>
                                                
                                                <!-- Teks Agenda Preview -->
                                                <div class="agenda-content">
                                                    <strong id="titlePreview">Judul Agenda</strong>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-text text-center">
                                            Ini adalah preview tampilan di frontend
                                        </div>
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
.image-wrapper {
    width: 80px;
    height: 60px;
    display: flex;
    align-items-center: center;
    justify-content: center;
    overflow: hidden;
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

/* Preview styling */
.agenda-date {
    width: 70px;
    text-align: center;
    border-radius: 8px;
    overflow: hidden;
    border: 1px solid rgba(0,0,0,0.1);
}

.agenda-month {
    background-color: currentColor;
    color: white;
    padding: 4px;
    font-size: 0.75rem;
    font-weight: 600;
}

.agenda-day {
    padding: 8px;
    font-size: 1.5rem;
    font-weight: 700;
    background-color: white;
}

.agenda-content {
    flex: 1;
    padding-top: 4px;
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing agenda management...');
    
    const modalElement = document.getElementById('modalForm');
    const modal = new bootstrap.Modal(modalElement, {
        backdrop: 'static',
        keyboard: false
    });
    const form = document.getElementById('formAgenda');
    const judulInput = document.getElementById('judul');
    const tanggalInput = document.getElementById('tanggal');
    const waktuInput = document.getElementById('waktu');
    const warnaInput = document.getElementById('warna');
    const warnaText = document.getElementById('warnaText');
    const datePreview = document.getElementById('datePreview');
    const titlePreview = document.getElementById('titlePreview');
    const monthPreview = datePreview ? datePreview.querySelector('.agenda-month') : null;
    const dayPreview = datePreview ? datePreview.querySelector('.agenda-day') : null;
    
    // Set default tanggal ke hari ini
    if (tanggalInput && !tanggalInput.value) {
        const today = new Date().toISOString().split('T')[0];
        tanggalInput.value = today;
        updateDatePreview(today);
    }
    
    // Update warna text dan preview
    if (warnaInput && warnaText) {
        warnaInput.addEventListener('input', function() {
            warnaText.textContent = this.value;
            updateDatePreviewColor(this.value);
        });
    }
    
    // Update judul preview
    if (judulInput && titlePreview) {
        judulInput.addEventListener('input', function() {
            titlePreview.textContent = this.value || 'Judul Agenda';
        });
    }
    
    // Update tanggal preview
    if (tanggalInput) {
        tanggalInput.addEventListener('change', function() {
            updateDatePreview(this.value);
        });
    }
    
    function updateDatePreview(dateString) {
        if (!dateString || !monthPreview || !dayPreview) return;
        
        const date = new Date(dateString);
        const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        const month = monthNames[date.getMonth()];
        const year = date.getFullYear();
        const day = date.getDate().toString().padStart(2, '0');
        
        monthPreview.textContent = `${month} ${year}`;
        dayPreview.textContent = day;
    }
    
    function updateDatePreviewColor(color) {
        if (!datePreview || !monthPreview) return;
        
        datePreview.style.color = color;
        monthPreview.style.backgroundColor = color;
        monthPreview.style.color = getContrastColor(color);
    }
    
    function getContrastColor(hexcolor) {
        // Convert hex to RGB
        const r = parseInt(hexcolor.substr(1, 2), 16);
        const g = parseInt(hexcolor.substr(3, 2), 16);
        const b = parseInt(hexcolor.substr(5, 2), 16);
        
        // Calculate luminance
        const luminance = (0.299 * r + 0.587 * g + 0.114 * b) / 255;
        
        return luminance > 0.5 ? '#000000' : '#ffffff';
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
        const rows = document.querySelectorAll('#sortableTable tr:not(.sortable-ghost)');
        const urutan = [];
        
        rows.forEach(function(row, index) {
            urutan.push({
                id: row.dataset.id,
                urutan: index + 1
            });
        });
        
        showLoading('Mengupdate urutan...', 'Harap tunggu');
        
        fetch('{{ route("backend.agenda-sekolah.update-urutan") }}', {
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
                        const page = {{ $agenda->currentPage() }};
                        const perPage = {{ $agenda->perPage() }};
                        const number = (page - 1) * perPage + index + 1;
                        numberCell.innerHTML = '<i class="fas fa-arrows-alt handle text-secondary me-2"></i> ' + number;
                    }
                });
                
                showSuccessToast(data.message || 'Urutan agenda berhasil diperbarui.');
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
        
        // Status button
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
        document.getElementById('modalTitle').textContent = 'Tambah Agenda Baru';
        document.getElementById('is_published').checked = true;
        document.getElementById('warna').value = '#6b02b1';
        
        // Set default tanggal ke hari ini
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('tanggal').value = today;
        
        // Reset preview
        if (warnaText) {
            warnaText.textContent = '#6b02b1';
        }
        updateDatePreview(today);
        updateDatePreviewColor('#6b02b1');
        
        if (titlePreview) {
            titlePreview.textContent = 'Judul Agenda';
        }
        
        // Clear validation errors
        clearValidationErrors();
        
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
        
        fetch('{{ route("backend.agenda-sekolah.edit", ":id") }}'.replace(':id', id))
            .then(function(response) {
                return response.json();
            })
            .then(function(data) {
                closeLoading();
                
                if (data.success) {
                    var item = data.data;
                    
                    // Clear previous validation errors
                    clearValidationErrors();
                    
                    // Set form values
                    document.getElementById('formMethod').value = 'PUT';
                    document.getElementById('itemId').value = item.id;
                    document.getElementById('judul').value = item.judul;
                    document.getElementById('deskripsi').value = item.deskripsi || '';
                    document.getElementById('lokasi').value = item.lokasi || '';
                    document.getElementById('urutan').value = item.urutan || 0;
                    document.getElementById('is_published').checked = item.is_published == 1;
                    
                    // Set tanggal
                    if (item.tanggal) {
                        const date = new Date(item.tanggal);
                        const formattedDate = date.toISOString().split('T')[0];
                        document.getElementById('tanggal').value = formattedDate;
                        updateDatePreview(formattedDate);
                    }
                    
                    // Set waktu
                    if (item.waktu) {
                        document.getElementById('waktu').value = item.waktu.substring(0, 5);
                    }
                    
                    // Set warna
                    if (item.warna) {
                        document.getElementById('warna').value = item.warna;
                        if (warnaText) {
                            warnaText.textContent = item.warna;
                        }
                        updateDatePreviewColor(item.warna);
                    }
                    
                    // Update preview
                    if (titlePreview) {
                        titlePreview.textContent = item.judul;
                    }
                    
                    // Update modal title
                    document.getElementById('modalTitle').textContent = 'Edit Agenda';
                    
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
            
            // Dapatkan method dan ID
            var method = document.getElementById('formMethod').value;
            var itemId = document.getElementById('itemId').value;
            
            // Set URL berdasarkan method
            var url = '{{ route("backend.agenda-sekolah.store") }}';
            if (method === 'PUT') {
                url = '{{ route("backend.agenda-sekolah.update", ":id") }}'.replace(':id', itemId);
            }
            
            // Buat FormData
            var formData = new FormData(this);
            
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
                return response.json();
            })
            .then(function(data) {
                closeLoading();
                
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
            text: 'Apakah Anda yakin ingin mengubah status agenda ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#6b02b1',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Ubah!',
            cancelButtonText: 'Batal'
        }).then(function(result) {
            if (result.isConfirmed) {
                showLoading('Mengubah status...', 'Harap tunggu');
                
                var url = '{{ route("backend.agenda-sekolah.toggle-status", ["id" => ":id", "status" => ":status"]) }}'
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
            title: 'Hapus Agenda?',
            html: 'Apakah Anda yakin ingin menghapus agenda <strong>"' + title + '"</strong>?<br><small class="text-danger">Data yang dihapus tidak dapat dikembalikan!</small>',
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
                
                fetch('{{ route("backend.agenda-sekolah.destroy", ":id") }}'.replace(':id', id), {
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
                            text: data.message || 'Gagal menghapus agenda.'
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
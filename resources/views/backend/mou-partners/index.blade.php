@extends('layouts.backend')

@section('title', 'Mitra Kerjasama - Dashboard Admin')

@section('content')
    <!-- Header Card -->
    <div class="card shadow mb-4 border-0">
        <div class="card-body py-4">
            <div class="d-flex justify-content-between align-items-center page-header">
                <div>
                    <h1 class="h3 text-gray-800 mb-1">
                        <i class="fas fa-handshake me-2"></i> Kelola Mitra Kerjasama
                    </h1>
                    <p class="text-muted mb-0">Kelola data mitra kerjasama dan MoU sekolah</p>
                </div>
                <div>
                    <button type="button" class="btn btn-primary" id="btnTambah">
                        <i class="fas fa-plus me-1"></i> Tambah Mitra
                    </button>
                    <a href="#" target="_blank" class="btn btn-outline-info">
                        <i class="fas fa-external-link-alt me-1"></i> Lihat di Frontend
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="card shadow border-0">
        <div class="card-body p-0">
            @if($partners->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-handshake fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada mitra kerjasama</h5>
                    <p class="text-muted">Mulai dengan menambahkan mitra kerjasama baru</p>
                    <button type="button" class="btn btn-primary" id="btnTambahEmpty">
                        <i class="fas fa-plus me-1"></i> Tambah Mitra Pertama
                    </button>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="mouTable">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4" width="50">#</th>
                                <th class="ps-3" width="80">Logo</th>
                                <th>Nama Perusahaan</th>
                                <th width="120">Tipe</th>
                                <th width="120">Status</th>
                                <th width="150">Tanggal MoU</th>
                                <th width="150">Status MoU</th>
                                <th width="100" class="text-center">Urutan</th>
                                <th width="120" class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="sortable-table" id="sortableTable">
                            @foreach($partners as $partner)
                                <tr data-id="{{ $partner->id }}">
                                    <td class="ps-4">{{ $loop->iteration }}</td>
                                    <td class="ps-3">
                                        <div class="company-logo-wrapper">
                                            <img src="{{ $partner->logo_url }}" 
                                                 alt="{{ $partner->company_name }}"
                                                 class="company-logo"
                                                 onerror="this.src='{{ asset('assets/img/default-company.png') }}'">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <strong class="text-dark">{{ $partner->company_name }}</strong>
                                            @if($partner->website)
                                                <small class="text-muted">
                                                    <i class="fas fa-globe me-1"></i>
                                                    <a href="{{ $partner->website }}" target="_blank" class="text-decoration-none">
                                                        {{ Str::limit($partner->website, 30) }}
                                                    </a>
                                                </small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">
                                            @php
                                                $partnerTypeLabels = [
                                                    'corporate' => 'Perusahaan',
                                                    'government' => 'Pemerintah', 
                                                    'education' => 'Pendidikan',
                                                    'community' => 'Komunitas',
                                                    'other' => 'Lainnya'
                                                ];
                                            @endphp
                                            {{ $partnerTypeLabels[$partner->partner_type] ?? 'Lainnya' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $partner->status == 'active' ? 'success' : 
                                               ($partner->status == 'inactive' ? 'secondary' : 'warning') }}">
                                            @php
                                                $statusLabels = [
                                                    'active' => 'Aktif',
                                                    'inactive' => 'Non-Aktif',
                                                    'draft' => 'Draft'
                                                ];
                                            @endphp
                                            {{ $statusLabels[$partner->status] ?? 'Unknown' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($partner->mou_date)
                                            <div class="small">
                                                <div><strong>Mulai:</strong> {{ $partner->mou_date->format('d/m/Y') }}</div>
                                                @if($partner->mou_expired_date)
                                                    <div><strong>Akhir:</strong> {{ $partner->mou_expired_date->format('d/m/Y') }}</div>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $mouStatus = $partner->mou_status;
                                            $badgeClass = [
                                                'active' => 'success',
                                                'expiring_soon' => 'warning',
                                                'expired' => 'danger',
                                                'unknown' => 'secondary'
                                            ][$mouStatus];
                                            
                                            $statusText = [
                                                'active' => 'Aktif',
                                                'expiring_soon' => 'Akan Kadaluarsa',
                                                'expired' => 'Kadaluarsa',
                                                'unknown' => 'Tidak Diketahui'
                                            ][$mouStatus];
                                        @endphp
                                        <span class="badge bg-{{ $badgeClass }}">
                                            {{ $statusText }}
                                        </span>
                                        @if($partner->mou_expired_date && $mouStatus == 'expiring_soon')
                                            <small class="d-block text-warning mt-1">
                                                {{ $partner->mou_expired_date->diffInDays(now()) }} hari lagi
                                            </small>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-secondary">{{ $partner->sort_order }}</span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group" role="group">
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-primary btn-edit"
                                                    data-id="{{ $partner->id }}"
                                                    title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-danger btn-hapus"
                                                    data-id="{{ $partner->id }}"
                                                    data-name="{{ $partner->company_name }}"
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
                <form id="formMitra" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="form_id" name="id">
                    
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-handshake me-2"></i>
                            <span id="modalTitle">Tambah Mitra Kerjasama</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    
                    <div class="modal-body">
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-8">
                                <!-- Nama Perusahaan -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Nama Perusahaan <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control" 
                                           name="company_name" 
                                           id="company_name"
                                           placeholder="Contoh: PT. Contoh Perusahaan"
                                           required>
                                    <div class="invalid-feedback" id="company_name_error"></div>
                                </div>
                                
                                <!-- Deskripsi -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Deskripsi Perusahaan
                                    </label>
                                    <textarea class="form-control" 
                                              name="description" 
                                              id="description"
                                              rows="3"
                                              placeholder="Masukkan deskripsi singkat perusahaan..."></textarea>
                                </div>
                                
                                <!-- Website & Email -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">
                                            Website
                                        </label>
                                        <input type="url" 
                                               class="form-control" 
                                               name="website" 
                                               id="website"
                                               placeholder="https://www.contoh.com">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">
                                            Email
                                        </label>
                                        <input type="email" 
                                               class="form-control" 
                                               name="email" 
                                               id="email"
                                               placeholder="info@contoh.com">
                                    </div>
                                </div>
                                
                                <!-- Telepon & Alamat -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">
                                            Telepon
                                        </label>
                                        <input type="text" 
                                               class="form-control" 
                                               name="phone" 
                                               id="phone"
                                               placeholder="(021) 12345678">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">
                                            Alamat
                                        </label>
                                        <input type="text" 
                                               class="form-control" 
                                               name="address" 
                                               id="address"
                                               placeholder="Jl. Contoh No. 123, Jakarta">
                                    </div>
                                </div>
                                
                                <!-- Contact Person -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">
                                            Kontak Person
                                        </label>
                                        <input type="text" 
                                               class="form-control" 
                                               name="contact_person" 
                                               id="contact_person"
                                               placeholder="Nama kontak person">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">
                                            Jabatan
                                        </label>
                                        <input type="text" 
                                               class="form-control" 
                                               name="contact_position" 
                                               id="contact_position"
                                               placeholder="Jabatan kontak person">
                                    </div>
                                </div>
                                
                                <!-- Tanggal MoU -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">
                                            Tanggal Mulai MoU
                                        </label>
                                        <input type="date" 
                                               class="form-control" 
                                               name="mou_date" 
                                               id="mou_date">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">
                                            Tanggal Berakhir MoU
                                        </label>
                                        <input type="date" 
                                               class="form-control" 
                                               name="mou_expired_date" 
                                               id="mou_expired_date">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Right Column -->
                            <div class="col-md-4">
                                <!-- Logo -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Logo Perusahaan
                                    </label>
                                    <div class="text-center mb-2">
                                        <img src="{{ asset('assets/img/default-company.png') }}" 
                                             class="img-fluid rounded border" 
                                             style="max-height: 150px; width: auto;"
                                             id="logoPreview">
                                    </div>
                                    <input type="file" 
                                           class="form-control" 
                                           name="logo" 
                                           id="logo"
                                           accept="image/*">
                                    <div class="form-text">
                                        Format: JPG, PNG, SVG. Maks: 2MB
                                    </div>
                                </div>
                                
                                <!-- Tipe Mitra -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Tipe Mitra <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select" name="partner_type" id="partner_type" required>
                                        <option value="">Pilih Tipe</option>
                                        @foreach($partnerTypes as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" id="partner_type_error"></div>
                                </div>
                                
                                <!-- Status -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Status <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select" name="status" id="status" required>
                                        @foreach($statuses as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" id="status_error"></div>
                                </div>
                                
                                <!-- Urutan -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Urutan Tampilan
                                    </label>
                                    <input type="number" 
                                           class="form-control" 
                                           name="sort_order" 
                                           id="sort_order"
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
.company-logo-wrapper {
    width: 50px;
    height: 50px;
    border-radius: 8px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    border: 1px solid #e9ecef;
}

.company-logo {
    width: 100%;
    height: 100%;
    object-fit: contain;
    padding: 4px;
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
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = new bootstrap.Modal('#modalForm');
    const form = document.getElementById('formMitra');
    const logoPreview = document.getElementById('logoPreview');
    const logoInput = document.getElementById('logo');
    
    // Initialize Sortable
    const sortableTable = document.getElementById('sortableTable');
    if (sortableTable) {
        const sortable = new Sortable(sortableTable, {
            animation: 150,
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
        
        fetch('{{ route("backend.mou-partners.update-urutan") }}', {
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
                        numberCell.textContent = index + 1;
                    }
                });
                
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message || 'Urutan mitra berhasil diperbarui.',
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        });
    }
    
    // Logo preview
    if (logoInput) {
        logoInput.addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = (event) => {
                    logoPreview.src = event.target.result;
                };
                reader.readAsDataURL(e.target.files[0]);
            }
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
        form.action = '{{ route("backend.mou-partners.store") }}';
        form.method = 'POST';
        document.getElementById('modalTitle').textContent = 'Tambah Mitra Kerjasama';
        logoPreview.src = '{{ asset("assets/img/default-company.png") }}';
        document.getElementById('form_id').value = '';
        
        // Set default dates
        const today = new Date().toISOString().split('T')[0];
        const nextYear = new Date();
        nextYear.setFullYear(nextYear.getFullYear() + 1);
        const nextYearStr = nextYear.toISOString().split('T')[0];
        
        document.getElementById('mou_date').value = today;
        document.getElementById('mou_expired_date').value = nextYearStr;
        
        // Set default status to active
        document.getElementById('status').value = 'active';
        
        modal.show();
    }
    
    // Open form for edit
    function editData(id) {
        fetch(`/w1s4t4/mou-partners/${id}/edit-data`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const partner = data.data;
                    
                    // Clear previous validation errors
                    clearValidationErrors();
                    
                    // Set form values
                    document.getElementById('form_id').value = partner.id;
                    document.getElementById('company_name').value = partner.company_name;
                    document.getElementById('description').value = partner.description || '';
                    document.getElementById('website').value = partner.website || '';
                    document.getElementById('email').value = partner.email || '';
                    document.getElementById('phone').value = partner.phone || '';
                    document.getElementById('address').value = partner.address || '';
                    document.getElementById('contact_person').value = partner.contact_person || '';
                    document.getElementById('contact_position').value = partner.contact_position || '';
                    document.getElementById('partner_type').value = partner.partner_type;
                    document.getElementById('status').value = partner.status;
                    document.getElementById('sort_order').value = partner.sort_order || 0;
                    
                    if (partner.mou_date) {
                        document.getElementById('mou_date').value = partner.mou_date;
                    }
                    if (partner.mou_expired_date) {
                        document.getElementById('mou_expired_date').value = partner.mou_expired_date;
                    }
                    
                    // Set logo preview
                    if (partner.logo_url) {
                        logoPreview.src = partner.logo_url;
                    } else {
                        logoPreview.src = '{{ asset("assets/img/default-company.png") }}';
                    }
                    
                    // Update form action and method
                    form.action = '{{ route("backend.mou-partners.update", ":id") }}'.replace(':id', partner.id);
                    // form.method = 'PUT';
                    document.getElementById('modalTitle').textContent = 'Edit Mitra Kerjasama';
                    
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
        // const url = this.action;
        // const method = this.method;
        
        // Clear previous validation errors
        // clearValidationErrors();
        // 👇 tambahkan spoofing method
        if (document.getElementById('form_id').value) {
            formData.append('_method', 'PUT');
        }

        
        // Show loading
        const btnSimpan = document.getElementById('btnSimpan');
        const originalText = btnSimpan.innerHTML;
        btnSimpan.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...';
        btnSimpan.disabled = true;
        
        fetch(this.action, {
            method: 'POST', // 👈 SELALU POST
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
            title: 'Hapus Mitra?',
            html: `Apakah Anda yakin ingin menghapus <strong>${name}</strong>?<br>
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
                fetch(`/w1s4t4/mou-partners/${id}`, {
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
                            text: data.message || 'Gagal menghapus mitra.'
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
@extends('layouts.backend')

@section('title', 'Guru dan Staff - Dashboard Admin')

@section('content')
    <!-- Header Card -->
    <div class="card shadow mb-4 border-0">
        <div class="card-body py-4">
            <div class="d-flex justify-content-between align-items-center page-header">
                <div>
                    <h1 class="h3 text-gray-800 mb-1">
                        <i class="fas fa-chalkboard-teacher me-2"></i> Kelola Guru dan Staff
                    </h1>
                    <p class="text-muted mb-0">Kelola data guru dan staff sekolah</p>
                </div>
                <div>
                    <button type="button" class="btn btn-primary" id="btnTambah">
                        <i class="fas fa-plus me-1"></i> Tambah Data
                    </button>
                    <button type="button" class="btn btn-outline-info" id="btnEditText">
                        <i class="fas fa-edit me-1"></i> Edit Deskripsi Halaman
                    </button>
                    <a href="#" target="_blank" class="btn btn-outline-success">
                        <i class="fas fa-external-link-alt me-1"></i> Lihat di Frontend
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card shadow mb-4 border-0">
        <div class="card-body">
            <form action="{{ route('backend.guru-staff.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Cari Guru/Staff</label>
                    <input type="text" class="form-control" name="search" placeholder="Nama, jabatan, atau bidang..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Tipe</label>
                    <select class="form-select" name="tipe">
                        <option value="">Semua Tipe</option>
                        @foreach($tipeOptions as $value => $label)
                            <option value="{{ $value }}" {{ request('tipe') == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Status</label>
                    <select class="form-select" name="status">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex flex-column">
                    <label class="form-label invisible">Filter</label>
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
            @if($guruStaff->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-chalkboard-teacher fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada data guru/staff</h5>
                    <p class="text-muted">Mulai dengan menambahkan data baru</p>
                    <button type="button" class="btn btn-primary" id="btnTambahEmpty">
                        <i class="fas fa-plus me-1"></i> Tambah Data Pertama
                    </button>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4" width="50">#</th>
                                <th class="ps-3" width="80">Foto</th>
                                <th>Nama & Jabatan</th>
                                <th width="120">Tipe</th>
                                <th width="120">Status</th>
                                <th width="150">Kontak</th>
                                <th width="100" class="text-center">Urutan</th>
                                <th width="120" class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="sortable-table" id="sortableTable">
                            @foreach($guruStaff as $item)
                                <tr data-id="{{ $item->id }}">
                                    <td class="ps-4">
                                        <i class="fas fa-arrows-alt handle text-secondary me-2"></i>
                                        {{ ($guruStaff->currentPage() - 1) * $guruStaff->perPage() + $loop->iteration }}
                                    </td>
                                    <td class="ps-3">
                                        <div class="foto-wrapper">
                                            <img src="{{ $item->foto_url }}" 
                                                 alt="{{ $item->nama }}"
                                                 class="foto-guru"
                                                 onerror="this.src='{{ asset('assets/img/foto-guru.png') }}'">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <strong class="text-dark">{{ $item->nama }}</strong>
                                            <small class="text-muted">{{ $item->jabatan }}</small>
                                            @if($item->bidang)
                                                <small class="text-info">{{ $item->bidang }}</small>
                                            @endif
                                            @if($item->jurusan)
                                                <small class="text-warning">{{ $item->jurusan }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $item->tipe_badge_class }}">
                                            {{ $item->tipe_label }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $item->is_active ? 'success' : 'secondary' }}">
                                            {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($item->email || $item->telepon)
                                            <div class="small">
                                                @if($item->email)
                                                    <div><i class="fas fa-envelope me-1"></i> {{ $item->email }}</div>
                                                @endif
                                                @if($item->telepon)
                                                    <div><i class="fas fa-phone me-1"></i> {{ $item->telepon }}</div>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
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
                                                    data-name="{{ $item->nama }}"
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

                <!-- PERBAIKAN PAGINATION: Menambahkan card-footer dengan styling yang konsisten -->
                @if($guruStaff->hasPages())
                    <div class="card-footer border-0 bg-white py-3 px-4">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <!-- Informasi hasil -->
                            <div class="text-muted small mb-2 mb-md-0">
                                Menampilkan <strong>{{ $guruStaff->firstItem() }}</strong> - <strong>{{ $guruStaff->lastItem() }}</strong> dari <strong>{{ $guruStaff->total() }}</strong> data
                            </div>
                            
                            <!-- Navigation pagination -->
                            <div class="d-flex align-items-center">
                                <!-- Previous Page Link -->
                                @if($guruStaff->onFirstPage())
                                    <span class="btn btn-outline-secondary btn-sm disabled me-2 px-3">
                                        <i class="fas fa-chevron-left"></i>
                                    </span>
                                @else
                                    <a href="{{ $guruStaff->previousPageUrl() }}" class="btn btn-outline-primary btn-sm me-2 px-3">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                @endif
                                
                                <!-- Page Numbers -->
                                <div class="d-none d-md-flex">
                                    @php
                                        $current = $guruStaff->currentPage();
                                        $last = $guruStaff->lastPage();
                                        $start = max($current - 2, 1);
                                        $end = min($current + 2, $last);
                                    @endphp
                                    
                                    <!-- First page if not in range -->
                                    @if($start > 1)
                                        <a href="{{ $guruStaff->url(1) }}" class="btn btn-outline-secondary btn-sm mx-1">1</a>
                                        @if($start > 2)
                                            <span class="btn btn-outline-secondary btn-sm mx-1 disabled">...</span>
                                        @endif
                                    @endif
                                    
                                    <!-- Page numbers -->
                                    @for($i = $start; $i <= $end; $i++)
                                        @if($i == $current)
                                            <span class="btn btn-primary btn-sm mx-1 px-3">{{ $i }}</span>
                                        @else
                                            <a href="{{ $guruStaff->url($i) }}" class="btn btn-outline-secondary btn-sm mx-1 px-3">{{ $i }}</a>
                                        @endif
                                    @endfor
                                    
                                    <!-- Last page if not in range -->
                                    @if($end < $last)
                                        @if($end < $last - 1)
                                            <span class="btn btn-outline-secondary btn-sm mx-1 disabled">...</span>
                                        @endif
                                        <a href="{{ $guruStaff->url($last) }}" class="btn btn-outline-secondary btn-sm mx-1">{{ $last }}</a>
                                    @endif
                                </div>
                                
                                <!-- Mobile page info -->
                                <div class="d-md-none text-center mx-2">
                                    <span class="badge bg-primary">{{ $current }}/{{ $last }}</span>
                                </div>
                                
                                <!-- Next Page Link -->
                                @if($guruStaff->hasMorePages())
                                    <a href="{{ $guruStaff->nextPageUrl() }}" class="btn btn-outline-primary btn-sm ms-2 px-3">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                @else
                                    <span class="btn btn-outline-secondary btn-sm disabled ms-2 px-3">
                                        <i class="fas fa-chevron-right"></i>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>

    <!-- Modal Form Data -->
    <div class="modal fade" id="modalForm" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="formGuruStaff" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="form_id" name="id">
                    
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-chalkboard-teacher me-2"></i>
                            <span id="modalTitle">Tambah Data Guru/Staff</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    
                    <div class="modal-body">
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-8">
                                <!-- Tipe -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Tipe <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select" name="tipe" id="tipe" required>
                                        <option value="">Pilih Tipe</option>
                                        @foreach($tipeOptions as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" id="tipe_error"></div>
                                </div>
                                
                                <!-- Nama -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Nama Lengkap <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control" 
                                           name="nama" 
                                           id="nama"
                                           placeholder="Contoh: Budi Santoso, S.Pd."
                                           required>
                                    <div class="invalid-feedback" id="nama_error"></div>
                                </div>
                                
                                <!-- Jabatan & Bidang -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">
                                            Jabatan
                                        </label>
                                        <input type="text" 
                                               class="form-control" 
                                               name="jabatan" 
                                               id="jabatan"
                                               placeholder="Contoh: Kepala Sekolah">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">
                                            Bidang
                                        </label>
                                        <input type="text" 
                                               class="form-control" 
                                               name="bidang" 
                                               id="bidang"
                                               placeholder="Contoh: Kurikulum, Kesiswaan">
                                    </div>
                                </div>
                                
                                <!-- Jurusan -->
                                <div class="mb-3" id="jurusanField" style="display: none;">
                                    <label class="form-label fw-bold">
                                        Jurusan
                                    </label>
                                    <input type="text" 
                                           class="form-control" 
                                           name="jurusan" 
                                           id="jurusan"
                                           placeholder="Contoh: Perhotelan, Kuliner, TJKT">
                                </div>
                                
                                <!-- Deskripsi -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Deskripsi
                                    </label>
                                    <textarea class="form-control tinymce-editor" 
                                              name="deskripsi" 
                                              id="deskripsi"
                                              rows="3"
                                              placeholder="Masukkan deskripsi singkat..."></textarea>
                                </div>
                                
                                <!-- Pendidikan -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Pendidikan
                                    </label>
                                    <input type="text" 
                                           class="form-control" 
                                           name="pendidikan" 
                                           id="pendidikan"
                                           placeholder="Contoh: S.Pd., S.Kom., M.Pd.">
                                </div>
                            </div>
                            
                            <!-- Right Column -->
                            <div class="col-md-4">
                                <!-- Foto -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Foto
                                    </label>
                                    <div class="text-center mb-2">
                                        <img src="{{ asset('assets/img/foto-guru.png') }}" 
                                             class="img-fluid rounded border" 
                                             style="max-height: 150px; width: auto;"
                                             id="fotoPreview">
                                    </div>
                                    <input type="file" 
                                           class="form-control" 
                                           name="foto" 
                                           id="foto"
                                           accept="image/*">
                                    <div class="form-text">
                                        Format: JPG, PNG. Maks: 2MB
                                    </div>
                                </div>
                                
                                <!-- Kontak -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Email
                                    </label>
                                    <input type="email" 
                                           class="form-control" 
                                           name="email" 
                                           id="email"
                                           placeholder="nama@sekolah.sch.id">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Telepon
                                    </label>
                                    <input type="text" 
                                           class="form-control" 
                                           name="telepon" 
                                           id="telepon"
                                           placeholder="0812-3456-7890">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Tahun Masuk
                                    </label>
                                    <input type="number" 
                                           class="form-control" 
                                           name="tahun_masuk" 
                                           id="tahun_masuk"
                                           min="1900"
                                           max="{{ date('Y') }}"
                                           placeholder="{{ date('Y') }}">
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
                                            Aktif
                                        </label>
                                    </div>
                                    <div class="form-text">
                                        Data aktif akan ditampilkan di halaman depan
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

    <!-- Modal Edit Deskripsi Halaman -->
    <div class="modal fade" id="modalDeskripsi" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="formDeskripsi">
                    @csrf
                    
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-file-alt me-2"></i>
                            Edit Deskripsi Halaman Guru & Staff
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Deskripsi ini akan muncul di atas data guru/staff di halaman depan website
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                Konten Deskripsi <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control tinymce-editor" 
                                      name="deskripsi" 
                                      id="deskripsiHalaman"
                                      rows="6"
                                      placeholder="Masukkan deskripsi untuk halaman guru & staff..."
                                      ></textarea>
                            <div class="invalid-feedback" id="deskripsi_error"></div>
                            <div class="form-text">
                                Gunakan editor untuk memformat teks. Contoh format HTML:
                                <code class="d-block mt-1">
                                    &lt;p class="text-center mb-1 mt-4" style="padding: 0px 25px; font-size: 20px;"&gt;
                                    Sebuah tim pendidik yang berdedikasi untuk membentuk masa depan cerdas&lt;br&gt;dan berkarakter.
                                    &lt;/p&gt;
                                </code>
                            </div>
                        </div>
                        
                        <!-- Preview Section -->
                        <div class="card border">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">
                                    <i class="fas fa-eye me-2"></i> Preview
                                </h6>
                            </div>
                            <div class="card-body">
                                <div id="deskripsiPreview" class="text-center p-3">
                                    <!-- Preview akan ditampilkan di sini -->
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary" id="btnSimpanDeskripsi">
                            <i class="fas fa-save me-1"></i> Simpan Deskripsi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
.foto-wrapper {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    border: 2px solid #e9ecef;
}

.foto-guru {
    width: 100%;
    height: 100%;
    object-fit: cover;
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

/* TinyMCE Container */
.tox-tinymce {
    width: 100% !important;
    height: 200px !important;
    border-radius: 8px !important;
    border: 1px solid #ced4da !important;
}

.tox-tinymce:focus-within {
    border-color: #6b02b1 !important;
    box-shadow: 0 0 0 0.2rem rgba(107, 2, 177, 0.25) !important;
}

/* Modal adjustments for TinyMCE */
.modal-body .tox-tinymce {
    height: 150px !important;
}

.modal-lg .modal-body .tox-tinymce {
    height: 250px !important;
}

/* Preview Styling */
#deskripsiPreview {
    min-height: 100px;
    font-size: 14px;
    line-height: 1.6;
}

#deskripsiPreview p {
    margin-bottom: 0.75rem;
}

#deskripsiPreview.text-center {
    text-align: center;
}

/* Info Alert */
.alert-info {
    background-color: rgba(13, 110, 253, 0.1);
    border-color: rgba(13, 110, 253, 0.2);
    color: #084298;
}

/* Code styling */
code {
    background-color: #f8f9fa;
    padding: 2px 6px;
    border-radius: 4px;
    font-size: 0.875em;
    color: #d63384;
}

/* PERBAIKAN PAGINATION: Tambahkan styling untuk pagination yang konsisten */
.card-footer {
    border-top: 1px solid rgba(0,0,0,.125) !important;
}

.btn-outline-primary.btn-sm {
    border-color: #6b02b1;
    color: #6b02b1;
}

.btn-outline-primary.btn-sm:hover {
    background-color: #6b02b1;
    border-color: #6b02b1;
    color: white;
}

.btn-primary.btn-sm {
    background-color: #6b02b1;
    border-color: #6b02b1;
}

.btn-outline-secondary.btn-sm.disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* Responsive pagination */
@media (max-width: 768px) {
    .card-footer .d-flex {
        flex-direction: column;
        gap: 10px;
    }
    
    .card-footer .d-flex > div {
        width: 100%;
        justify-content: center;
    }
    
    .card-footer .text-muted {
        text-align: center;
    }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script src="{{ asset('assets/js/tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = new bootstrap.Modal('#modalForm');
    const modalDeskripsi = new bootstrap.Modal('#modalDeskripsi');
    const form = document.getElementById('formGuruStaff');
    const formDeskripsi = document.getElementById('formDeskripsi');
    const fotoPreview = document.getElementById('fotoPreview');
    const fotoInput = document.getElementById('foto');
    const tipeSelect = document.getElementById('tipe');
    const jurusanField = document.getElementById('jurusanField');
    
    // TinyMCE Config
    const tinymceConfig = {
        selector: '.tinymce-editor',
        height: 200,
        menubar: true,
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'table', 'help', 'wordcount', 'code'
        ],
        toolbar: 'undo redo | blocks | ' +
            'bold italic underline | forecolor backcolor | ' +
            'alignleft aligncenter alignright alignjustify | ' +
            'bullist numlist | ' +
            'removeformat | help | code',
        language: 'id',
        language_url: '{{ asset("assets/js/tinymce/langs/id.js") }}',
        promotion: false,
        branding: false,
        resize: true,
        statusbar: false,
        content_style: `
            body { 
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif; 
                font-size: 14px; 
                line-height: 1.6; 
                color: #212529;
                margin: 8px;
            }
            p { margin-bottom: 1rem; }
            ul, ol { margin-bottom: 1rem; padding-left: 2rem; }
        `
    };
    
    // Initialize TinyMCE
    let tinymceInitialized = false;
    
    function initTinyMCE() {
        if (!tinymceInitialized) {
            tinymce.init(tinymceConfig);
            tinymceInitialized = true;
        }
    }
    
    function destroyTinyMCE() {
        tinymce.get().forEach(editor => {
            if (editor) {
                editor.remove();
            }
        });
        tinymceInitialized = false;
    }
    
    // Initialize Sortable (only for current page items)
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
    
    // Update urutan for current page
    function updateUrutan() {
        const rows = document.querySelectorAll('#sortableTable tr');
        const urutan = [];
        
        rows.forEach((row, index) => {
            urutan.push({
                id: row.dataset.id,
                urutan: index + 1
            });
        });
        
        fetch('{{ route("backend.guru-staff.update-urutan") }}', {
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
                // Update row numbers for current page
                const startNumber = {{ ($guruStaff->currentPage() - 1) * $guruStaff->perPage() + 1 }};
                rows.forEach((row, index) => {
                    const numberCell = row.querySelector('td:first-child');
                    if (numberCell) {
                        numberCell.innerHTML = `<i class="fas fa-arrows-alt handle text-secondary me-2"></i> ${startNumber + index}`;
                    }
                });
                
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message || 'Urutan berhasil diperbarui.',
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        });
    }
    
    // Tipe change handler
    if (tipeSelect) {
        tipeSelect.addEventListener('change', function() {
            const tipe = this.value;
            if (tipe === 'kepala_jurusan') {
                jurusanField.style.display = 'block';
            } else {
                jurusanField.style.display = 'none';
                document.getElementById('jurusan').value = '';
            }
        });
    }
    
    // Foto preview
    if (fotoInput) {
        fotoInput.addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = (event) => {
                    fotoPreview.src = event.target.result;
                };
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    }
    
    // Tambah button
    document.getElementById('btnTambah')?.addEventListener('click', openForm);
    document.getElementById('btnTambahEmpty')?.addEventListener('click', openForm);
    
    // Edit deskripsi button
    document.getElementById('btnEditText')?.addEventListener('click', openDeskripsiForm);
    
    // Edit button
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-edit') || e.target.closest('.btn-edit')) {
            e.preventDefault();
            const button = e.target.classList.contains('btn-edit') ? e.target : e.target.closest('.btn-edit');
            if (button) {
                const id = button.dataset.id;
                editData(id);
            }
        }
        
        // Hapus button
        if (e.target.classList.contains('btn-hapus') || e.target.closest('.btn-hapus')) {
            e.preventDefault();
            const button = e.target.classList.contains('btn-hapus') ? e.target : e.target.closest('.btn-hapus');
            if (button) {
                const id = button.dataset.id;
                const name = button.dataset.name;
                hapusData(id, name);
            }
        }
    });
    
    // Open form for create
    function openForm() {
        form.reset();
        form.action = '{{ route("backend.guru-staff.store") }}';
        form.method = 'POST';
        document.getElementById('modalTitle').textContent = 'Tambah Data Guru/Staff';
        fotoPreview.src = '{{ asset("assets/img/foto-guru.png") }}';
        document.getElementById('form_id').value = '';
        document.getElementById('is_active').checked = true;
        jurusanField.style.display = 'none';
        
        // Clear TinyMCE
        if (tinymce.get('deskripsi')) {
            tinymce.get('deskripsi').setContent('');
        }
        
        clearValidationErrors();
        
        // Initialize TinyMCE after modal shows
        setTimeout(() => {
            if (!tinymce.get('deskripsi')) {
                tinymce.init({
                    ...tinymceConfig,
                    selector: '#deskripsi'
                });
            }
        }, 300);
        
        modal.show();
    }
    
    // Open deskripsi form
    function openDeskripsiForm() {
        // Destroy previous TinyMCE instances
        destroyTinyMCE();
        
        // Load current deskripsi
        fetch('{{ route("backend.guru-staff.deskripsi") }}')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Initialize TinyMCE after modal shows
                    setTimeout(() => {
                        tinymce.init({
                            ...tinymceConfig,
                            selector: '#deskripsiHalaman',
                            height: 300,
                            setup: function(editor) {
                                editor.on('change', function() {
                                    // Update preview real-time
                                    const content = editor.getContent();
                                    updateDeskripsiPreview(content);
                                });
                                
                                // Initial preview update
                                editor.on('init', function() {
                                    const content = editor.getContent();
                                    updateDeskripsiPreview(content);
                                });
                            }
                        });
                        
                        // Set initial content after TinyMCE initialized
                        setTimeout(() => {
                            if (tinymce.get('deskripsiHalaman')) {
                                tinymce.get('deskripsiHalaman').setContent(data.data || '');
                                updateDeskripsiPreview(data.data || '');
                            }
                        }, 500);
                    }, 300);
                    
                    modalDeskripsi.show();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat mengambil data deskripsi.'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat mengambil data deskripsi.'
                });
            });
    }
    
    // Update preview deskripsi
    function updateDeskripsiPreview(content) {
        const previewElement = document.getElementById('deskripsiPreview');
        if (previewElement) {
            if (content.trim()) {
                previewElement.innerHTML = content;
                previewElement.classList.remove('text-muted');
            } else {
                previewElement.innerHTML = '<span class="text-muted fst-italic">(Kosong - tambahkan deskripsi di editor)</span>';
                previewElement.classList.add('text-muted');
            }
        }
    }
    
    // Open form for edit
    function editData(id) {
        // Destroy previous TinyMCE instances
        destroyTinyMCE();
        
        fetch('{{ route("backend.guru-staff.edit-data", ":id") }}'.replace(':id', id))
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const item = data.data;
                    
                    // Clear previous validation errors
                    clearValidationErrors();
                    
                    // Set form values
                    document.getElementById('form_id').value = item.id;
                    document.getElementById('tipe').value = item.tipe;
                    document.getElementById('nama').value = item.nama;
                    document.getElementById('jabatan').value = item.jabatan || '';
                    document.getElementById('bidang').value = item.bidang || '';
                    document.getElementById('jurusan').value = item.jurusan || '';
                    document.getElementById('pendidikan').value = item.pendidikan || '';
                    document.getElementById('email').value = item.email || '';
                    document.getElementById('telepon').value = item.telepon || '';
                    document.getElementById('tahun_masuk').value = item.tahun_masuk || '';
                    document.getElementById('urutan').value = item.urutan || 0;
                    document.getElementById('is_active').checked = item.is_active == 1;
                    
                    // Toggle jurusan field
                    if (item.tipe === 'kepala_jurusan') {
                        jurusanField.style.display = 'block';
                    }
                    
                    // Set foto preview
                    if (item.foto_url) {
                        fotoPreview.src = item.foto_url;
                    } else {
                        fotoPreview.src = '{{ asset("assets/img/foto-guru.png") }}';
                    }
                    
                    // Update form action and method
                    form.action = '{{ route("backend.guru-staff.update", ":id") }}'.replace(':id', item.id);
                    document.getElementById('modalTitle').textContent = 'Edit Data Guru/Staff';
                    
                    // Initialize TinyMCE after modal shows
                    setTimeout(() => {
                        tinymce.init({
                            ...tinymceConfig,
                            selector: '#deskripsi'
                        });
                        
                        // Set TinyMCE content
                        if (item.deskripsi && tinymce.get('deskripsi')) {
                            tinymce.get('deskripsi').setContent(item.deskripsi);
                        }
                    }, 300);
                    
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
    
    // Form submission for data
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Save TinyMCE content
        if (tinymce.get('deskripsi')) {
            tinymce.get('deskripsi').save();
        }
        
        const formData = new FormData(this);

        if (document.getElementById('form_id').value) {
            formData.append('_method', 'PUT');
        }

        // Show loading
        const btnSimpan = document.getElementById('btnSimpan');
        const originalText = btnSimpan.innerHTML;
        btnSimpan.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...';
        btnSimpan.disabled = true;
        
        fetch(this.action, {
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
                    // Reload with current pagination parameters
                    window.location.reload();
                });
            } else {
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
    
    // Form submission for deskripsi
    formDeskripsi.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Save TinyMCE content
        if (tinymce.get('deskripsiHalaman')) {
            tinymce.get('deskripsiHalaman').save();
        }
        
        const formData = new FormData(this);

        // Show loading
        const btnSimpanDeskripsi = document.getElementById('btnSimpanDeskripsi');
        const originalText = btnSimpanDeskripsi.innerHTML;
        btnSimpanDeskripsi.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...';
        btnSimpanDeskripsi.disabled = true;
        
        // Validasi minimal content
        const deskripsiValue = formData.get('deskripsi');
        if (!deskripsiValue || deskripsiValue.trim() === '') {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Deskripsi tidak boleh kosong.'
            });
            btnSimpanDeskripsi.innerHTML = originalText;
            btnSimpanDeskripsi.disabled = false;
            return;
        }
        
        fetch('{{ route("backend.guru-staff.store.deskripsi") }}', {
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
                modalDeskripsi.hide();
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                });
            } else {
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
                    
                    // Scroll to error
                    const firstError = document.querySelector('.is-invalid');
                    if (firstError) {
                        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message || 'Terjadi kesalahan saat menyimpan deskripsi.'
                    });
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Terjadi kesalahan saat menyimpan deskripsi.'
            });
        })
        .finally(() => {
            btnSimpanDeskripsi.innerHTML = originalText;
            btnSimpanDeskripsi.disabled = false;
        });
    });
    
    // Hapus data
    function hapusData(id, name) {
        Swal.fire({
            title: 'Hapus Data?',
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
                fetch('{{ route("backend.guru-staff.destroy", ":id") }}'.replace(':id', id), {
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
                            // Reload with current pagination parameters
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: data.message || 'Gagal menghapus data.'
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
        
        formDeskripsi.querySelectorAll('.is-invalid').forEach(field => {
            field.classList.remove('is-invalid');
        });
        formDeskripsi.querySelectorAll('.invalid-feedback').forEach(errorDiv => {
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
    
    // Clean up TinyMCE when modals close
    document.getElementById('modalForm')?.addEventListener('hidden.bs.modal', function() {
        destroyTinyMCE();
    });
    
    document.getElementById('modalDeskripsi')?.addEventListener('hidden.bs.modal', function() {
        destroyTinyMCE();
    });
});
</script>
@endpush
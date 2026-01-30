@extends('layouts.backend')

@section('title', 'Pengumuman - Dashboard Admin')

@section('content')
    <!-- Header Card -->
    <div class="card shadow mb-4 border-0">
        <div class="card-body py-4">
            <div class="d-flex justify-content-between align-items-center page-header">
                <div>
                    <h1 class="h3 text-gray-800 mb-1">
                        <i class="fas fa-bullhorn me-2"></i> Kelola Pengumuman
                    </h1>
                    <p class="text-muted mb-0">Kelola pengumuman dan popup modal di frontend</p>
                </div>
                <div>
                    <button type="button" class="btn btn-primary" id="btnTambah">
                        <i class="fas fa-plus me-1"></i> Tambah Pengumuman
                    </button>
                    <a href="{{ url('/') }}" target="_blank" class="btn btn-outline-info">
                        <i class="fas fa-external-link-alt me-1"></i> Lihat di Frontend
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="card shadow-lg border-0 rounded-5 overflow-hidden">
        <div class="card-body p-0">
            @if($announcements->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-bullhorn fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada pengumuman</h5>
                    <p class="text-muted">Mulai dengan menambahkan pengumuman baru</p>
                    <button type="button" class="btn btn-primary" id="btnTambahEmpty">
                        <i class="fas fa-plus me-1"></i> Tambah Pengumuman Pertama
                    </button>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="announcementTable">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4" width="50">#</th>
                                <th class="ps-3">Judul</th>
                                <th width="100">Tipe</th>
                                <th width="100">Status</th>
                                <th width="150">Tampil Modal</th>
                                <th width="120">Tanggal Mulai</th>
                                <th width="120">Tanggal Berakhir</th>
                                <th width="100" class="text-center">Urutan</th>
                                <th width="120" class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="sortable-table" id="sortableTable">
                            @foreach($announcements as $announcement)
                                <tr data-id="{{ $announcement->id }}">
                                    <td class="ps-4">{{ $loop->iteration }}</td>
                                    <td class="ps-3">
                                        <div class="d-flex flex-column">
                                            <strong class="text-dark">{{ $announcement->title }}</strong>
                                            <small class="text-muted">
                                                {{ Str::limit(strip_tags($announcement->content), 50) }}
                                            </small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $announcement->type_color }}">
                                            <i class="fas fa-circle me-1"></i>
                                            {{ $announcement->type_label }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $announcement->status == 'active' ? 'success' : 
                                               ($announcement->status == 'inactive' ? 'secondary' : 'warning') }}">
                                            {{ $announcement->status_label }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="badge bg-{{ $announcement->show_on_frontend ? 'success' : 'secondary' }} mb-1">
                                                {{ $announcement->show_on_frontend ? 'Ya' : 'Tidak' }}
                                            </span>
                                            @if($announcement->show_as_modal)
                                                <small class="text-success">
                                                    <i class="fas fa-expand-alt me-1"></i> Modal
                                                </small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if($announcement->start_date)
                                            {{ $announcement->start_date->format('d/m/Y') }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($announcement->end_date)
                                            {{ $announcement->end_date->format('d/m/Y') }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-secondary">{{ $announcement->sort_order }}</span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group" role="group">
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-primary btn-edit"
                                                    data-id="{{ $announcement->id }}"
                                                    title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-danger btn-hapus"
                                                    data-id="{{ $announcement->id }}"
                                                    data-name="{{ $announcement->title }}"
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
                <form id="formAnnouncement" novalidate>
                    @csrf
                    <input type="hidden" id="formMethod" name="_method" value="POST">
                    <input type="hidden" id="form_id" name="id">
                    <!-- Hidden field untuk menyimpan konten asli -->
                    <input type="hidden" id="original_content" name="original_content">
                    
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-bullhorn me-2"></i>
                            <span id="modalTitle">Tambah Pengumuman</span>
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
                                        Judul Pengumuman <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control" 
                                           name="title" 
                                           id="title"
                                           placeholder="Contoh: Pengumuman Penting!"
                                           required>
                                    <div class="invalid-feedback" id="title_error"></div>
                                </div>
                                
                                <!-- Konten -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Konten Pengumuman <span class="text-danger">*</span>
                                    </label>
                                    <textarea
                                        name="content"
                                        id="content"
                                        class="form-control tinymce-editor"
                                        rows="10"
                                        placeholder="Tulis konten pengumuman lengkap di sini..."
                                    ></textarea>
                                    <div class="invalid-feedback" id="content_error"></div>
                                    <div class="form-text">
                                        Gunakan editor untuk memformat teks.
                                    </div>
                                </div>
                                
                                <!-- Tanggal -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">
                                            Tanggal Mulai
                                        </label>
                                        <input type="datetime-local" 
                                               class="form-control" 
                                               name="start_date" 
                                               id="start_date">
                                        <div class="form-text">Kosongkan untuk langsung aktif</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">
                                            Tanggal Berakhir
                                        </label>
                                        <input type="datetime-local" 
                                               class="form-control" 
                                               name="end_date" 
                                               id="end_date">
                                        <div class="form-text">Kosongkan untuk tidak ada batas waktu</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Right Column -->
                            <div class="col-md-4">
                                <!-- Tipe -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Tipe Pengumuman <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select" name="type" id="type" required>
                                        <option value="">Pilih Tipe</option>
                                        @foreach($types as $value => $label)
                                            <option value="{{ $value }}" data-color="{{ $value }}">
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" id="type_error"></div>
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
                                
                                <!-- Pengaturan Frontend -->
                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Pengaturan Frontend</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" 
                                                   type="checkbox" 
                                                   name="show_on_frontend" 
                                                   id="show_on_frontend" 
                                                   value="1">
                                            <label class="form-check-label fw-bold" for="show_on_frontend">
                                                Tampilkan di Frontend
                                            </label>
                                        </div>
                                        
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" 
                                                   type="checkbox" 
                                                   name="show_as_modal" 
                                                   id="show_as_modal" 
                                                   value="1">
                                            <label class="form-check-label fw-bold" for="show_as_modal">
                                                Tampilkan sebagai Modal Popup
                                            </label>
                                        </div>
                                        
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" 
                                                   type="checkbox" 
                                                   name="modal_show_once" 
                                                   id="modal_show_once" 
                                                   value="1">
                                            <label class="form-check-label fw-bold" for="modal_show_once">
                                                Tampilkan Modal Sekali Saja
                                            </label>
                                            <div class="form-text">
                                                Modal hanya muncul sekali per pengunjung
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Pengaturan Modal -->
                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Pengaturan Modal</h6>
                                    </div>
                                    <div class="card-body">
                                        <!-- Lebar Modal -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">
                                                Lebar Modal
                                            </label>
                                            <input type="number" 
                                                   class="form-control" 
                                                   name="modal_width" 
                                                   id="modal_width"
                                                   placeholder="800"
                                                   min="300"
                                                   max="1200">
                                            <div class="form-text">Pixel (300-1200), kosong untuk auto</div>
                                        </div>
                                        
                                        <!-- Posisi -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">
                                                Posisi Modal
                                            </label>
                                            <select class="form-select" name="modal_position" id="modal_position">
                                                @foreach($modalPositions as $value => $label)
                                                    <option value="{{ $value }}">{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <!-- Animasi -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">
                                                Animasi
                                            </label>
                                            <select class="form-select" name="modal_animation" id="modal_animation">
                                                @foreach($animations as $value => $label)
                                                    <option value="{{ $value }}">{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <!-- Opsi Modal -->
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" 
                                                   type="checkbox" 
                                                   name="modal_backdrop" 
                                                   id="modal_backdrop" 
                                                   value="1" 
                                                   checked>
                                            <label class="form-check-label" for="modal_backdrop">
                                                Backdrop
                                            </label>
                                        </div>
                                        
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" 
                                                   type="checkbox" 
                                                   name="modal_keyboard" 
                                                   id="modal_keyboard" 
                                                   value="1" 
                                                   checked>
                                            <label class="form-check-label" for="modal_keyboard">
                                                Tutup dengan ESC
                                            </label>
                                        </div>
                                        
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" 
                                                   type="checkbox" 
                                                   name="modal_close_button" 
                                                   id="modal_close_button" 
                                                   value="1" 
                                                   checked>
                                            <label class="form-check-label" for="modal_close_button">
                                                Tampilkan Tombol Tutup
                                            </label>
                                        </div>
                                    </div>
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

.badge.bg-info { background-color: #0dcaf0 !important; }
.badge.bg-warning { background-color: #ffc107 !important; color: #000 !important; }
.badge.bg-danger { background-color: #dc3545 !important; }
.badge.bg-success { background-color: #198754 !important; }
.badge.bg-primary { background-color: #0d6efd !important; }

/* TinyMCE Styling */
.tox-tinymce {
    border-radius: 8px !important;
    border: 1px solid #dee2e6 !important;
}

.tox-tinymce:focus-within {
    border-color: #6b02b1 !important;
    box-shadow: 0 0 0 0.25rem rgba(107, 2, 177, 0.25) !important;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script src="{{ asset('assets/js/tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script>
// Variabel global untuk menyimpan instance editor dan konten asli
let announcementEditor = null;
let originalContent = '';

// Inisialisasi TinyMCE untuk konten pengumuman
function initTinyMCE(callback) {
    if (announcementEditor) {
        tinymce.remove('#content');
    }
    
    announcementEditor = tinymce.init({
        selector: '#content',
        height: 300,
        menubar: false,
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
        images_upload_url: '{{ route("backend.announcements.upload-image") }}',
        automatic_uploads: true,
        images_upload_credentials: true,
        images_reuse_filename: true,
        image_caption: true,

        content_style: `
          img {
            display: block;
            margin-left: auto;
            margin-right: auto;
          }
        `,
        
        // Handler untuk upload gambar
        images_upload_handler: function (blobInfo) {
            return new Promise(function (resolve, reject) {
                console.log('Uploading image:', blobInfo.filename());
                
                const formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());
                formData.append('_token', '{{ csrf_token() }}');
                
                const xhr = new XMLHttpRequest();
                xhr.withCredentials = true;
                xhr.open('POST', '{{ route("backend.announcements.upload-image") }}');
                
                xhr.onload = function() {
                    if (xhr.status !== 200) {
                        reject('HTTP Error: ' + xhr.status);
                        return;
                    }
                    
                    try {
                        const json = JSON.parse(xhr.responseText);
                        if (json.location) {
                            resolve(json.location);
                        } else if (json.error) {
                            reject(json.error.message || json.error);
                        } else {
                            reject('Invalid response from server: No location field');
                        }
                    } catch (e) {
                        reject('Invalid response from server: ' + e.message);
                    }
                };
                
                xhr.onerror = function() {
                    reject('Network error');
                };
                
                xhr.timeout = 30000;
                xhr.ontimeout = function() {
                    reject('Upload timeout');
                };
                
                xhr.send(formData);
            });
        },
        
        content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, sans-serif; font-size: 14px; line-height: 1.6; color: #212529; margin: 8px; }' +
            'h1, h2, h3, h4, h5, h6 { margin-top: 1rem; margin-bottom: 0.5rem; font-weight: 600; line-height: 1.2; }' +
            'p { margin-bottom: 1rem; }' +
            'ul, ol { margin-bottom: 1rem; padding-left: 2rem; }' +
            'table { border-collapse: collapse; width: 100%; margin-bottom: 1rem; }' +
            'table, th, td { border: 1px solid #dee2e6; padding: 0.75rem; }',
        
        setup: function (editor) {
            editor.on('init', function () {
                console.log('TinyMCE initialized for announcement content');
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
        min_height: 300,
        max_height: 500,
        statusbar: true,
        relative_urls: false,
        remove_script_host: false,
        convert_urls: true
    });
}

// Fungsi untuk menghapus TinyMCE instance
function removeTinyMCE() {
    if (announcementEditor) {
        tinymce.remove('#content');
        announcementEditor = null;
    }
}

// Fungsi untuk mendapatkan konten dari editor
function getEditorContent() {
    if (announcementEditor) {
        var editor = tinymce.get('content');
        if (editor) {
            return editor.getContent().trim();
        }
    }
    return document.getElementById('content') ? document.getElementById('content').value.trim() : '';
}

document.addEventListener('DOMContentLoaded', function() {

    @if(session('show_pengumuman_modal'))
        console.log('Auto-show modal from session');
        setTimeout(function() {
            const btnTambah = document.getElementById('btnTambah') || 
                             document.getElementById('btnTambahEmpty');
            if (btnTambah) {
                btnTambah.click();
            }
        }, 500);
    @endif

    const modal = new bootstrap.Modal('#modalForm');
    const form = document.getElementById('formAnnouncement');
    const showAsModalCheckbox = document.getElementById('show_as_modal');
    const showOnFrontendCheckbox = document.getElementById('show_on_frontend');
    const modalSettingsCard = document.querySelector('.card:has([name="modal_width"])');
    const originalContentField = document.getElementById('original_content');
    
    // Flag untuk menandai apakah form sedang diproses
    let isSubmitting = false;
    
    // Event listeners untuk modal
    const modalElement = document.getElementById('modalForm');
    modalElement.addEventListener('hidden.bs.modal', function () {
        // Hapus TinyMCE instance ketika modal ditutup
        removeTinyMCE();
        // Reset original content
        originalContent = '';
        if (originalContentField) {
            originalContentField.value = '';
        }
        // Reset flag submit
        isSubmitting = false;
    });
    
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
    
    // Toggle modal settings visibility
    function toggleModalSettings() {
        const isModal = showAsModalCheckbox.checked && showOnFrontendCheckbox.checked;
        if (modalSettingsCard) {
            modalSettingsCard.style.display = isModal ? 'block' : 'none';
        }
    }
    
    // Event listeners for checkboxes
    if (showAsModalCheckbox) {
        showAsModalCheckbox.addEventListener('change', toggleModalSettings);
    }
    if (showOnFrontendCheckbox) {
        showOnFrontendCheckbox.addEventListener('change', toggleModalSettings);
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
        
        fetch('{{ route("backend.announcements.update-urutan") }}', {
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
                    text: data.message || 'Urutan pengumuman berhasil diperbarui.',
                    timer: 1500,
                    showConfirmButton: false
                });
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
        document.getElementById('formMethod').value = 'POST';
        document.getElementById('modalTitle').textContent = 'Tambah Pengumuman';
        document.getElementById('form_id').value = '';
        
        // Reset original content
        originalContent = '';
        if (originalContentField) {
            originalContentField.value = '';
        }
        
        // Set default values
        document.getElementById('type').value = 'info';
        document.getElementById('status').value = 'draft';
        document.getElementById('sort_order').value = '0';
        document.getElementById('modal_position').value = 'center';
        document.getElementById('modal_animation').value = 'fade';
        document.getElementById('modal_backdrop').checked = true;
        document.getElementById('modal_keyboard').checked = true;
        document.getElementById('modal_close_button').checked = true;
        
        // Set default dates
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const datetimeLocal = `${year}-${month}-${day}T${hours}:${minutes}`;
        
        document.getElementById('start_date').value = datetimeLocal;
        
        // Hide modal settings initially
        toggleModalSettings();
        
        // Clear validation errors
        clearValidationErrors();
        
        modal.show();
        
        // Inisialisasi TinyMCE setelah modal muncul
        setTimeout(function() {
            initTinyMCE(function() {
                console.log('TinyMCE ready for new announcement');
            });
        }, 300);
    }
    
    // Open form for edit
    function editData(id) {
        // Gunakan route dengan parameter langsung
        const editUrl = '{{ route("backend.announcements.edit-data", ":id") }}'.replace(':id', id);
        
        console.log('Fetching from:', editUrl);
        
        fetch(editUrl, {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                const announcement = data.data;
                
                // Clear previous validation errors
                clearValidationErrors();
                
                // Simpan konten asli
                originalContent = announcement.content || '';
                if (originalContentField) {
                    originalContentField.value = originalContent;
                }
                
                // Set form values dengan null safety
                document.getElementById('formMethod').value = 'PUT';
                document.getElementById('form_id').value = announcement.id;
                document.getElementById('title').value = announcement.title || '';
                document.getElementById('type').value = announcement.type || 'info';
                document.getElementById('status').value = announcement.status || 'draft';
                document.getElementById('sort_order').value = announcement.sort_order || 0;
                document.getElementById('modal_width').value = announcement.modal_width || '';
                document.getElementById('show_on_frontend').checked = Boolean(announcement.show_on_frontend);
                document.getElementById('show_as_modal').checked = Boolean(announcement.show_as_modal);
                document.getElementById('modal_show_once').checked = Boolean(announcement.modal_show_once);
                
                // Format dates for datetime-local input
                if (announcement.start_date) {
                    const startDate = new Date(announcement.start_date);
                    document.getElementById('start_date').value = startDate.toISOString().slice(0, 16);
                } else {
                    document.getElementById('start_date').value = '';
                }
                
                if (announcement.end_date) {
                    const endDate = new Date(announcement.end_date);
                    document.getElementById('end_date').value = endDate.toISOString().slice(0, 16);
                } else {
                    document.getElementById('end_date').value = '';
                }
                
                // Modal settings dengan default values
                const modalSettings = announcement.modal_settings_array || {};
                document.getElementById('modal_position').value = modalSettings.position || 'center';
                document.getElementById('modal_animation').value = modalSettings.animation || 'fade';
                document.getElementById('modal_backdrop').checked = modalSettings.backdrop !== false;
                document.getElementById('modal_keyboard').checked = modalSettings.keyboard !== false;
                document.getElementById('modal_close_button').checked = modalSettings.close_button !== false;
                
                // Update modal title
                document.getElementById('modalTitle').textContent = 'Edit Pengumuman';
                
                // Toggle modal settings visibility
                toggleModalSettings();
                
                modal.show();
                
                // Inisialisasi TinyMCE dengan konten setelah modal muncul
                setTimeout(function() {
                    initTinyMCE(function() {
                        // Set konten setelah editor siap
                        var editor = tinymce.get('content');
                        if (editor) {
                            editor.setContent(originalContent);
                            console.log('Konten berhasil dimuat ke editor');
                        }
                    });
                }, 300);
            } else {
                throw new Error(data.message || 'Gagal mengambil data');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Terjadi kesalahan saat mengambil data: ' + error.message
            });
        });
    }
    
    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Cegah submit ganda
        if (isSubmitting) {
            return false;
        }
        
        // Set flag sedang submit
        isSubmitting = true;
        
        // Dapatkan konten dari editor
        var content = getEditorContent();
        var method = document.getElementById('formMethod').value;
        var itemId = document.getElementById('form_id').value;
        
        console.log('Form submission started, method:', method, 'content length:', content.length);
        
        // Validasi konten
        if (method === 'POST' && content.length === 0) {
            // Mode tambah baru, konten wajib diisi
            isSubmitting = false;
            Swal.fire({
                icon: 'error',
                title: 'Kesalahan',
                text: 'Konten pengumuman tidak boleh kosong!'
            });
            var editor = tinymce.get('content');
            if (editor) {
                editor.focus();
            }
            return false;
        }
        
        // Jika edit mode dan konten kosong, gunakan konten asli
        if (method === 'PUT' && content.length === 0) {
            console.log('Konten kosong pada edit mode, menggunakan konten asli');
            content = originalContent;
            
            // Pastikan konten asli ada
            if (content.length === 0) {
                isSubmitting = false;
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan',
                    text: 'Konten pengumuman tidak boleh kosong!'
                });
                return false;
            }
        }
        
        const formData = new FormData(this);
        
        // Tambahkan konten ke FormData
        formData.set('content', content);

        // Add method spoofing for PUT
        if (itemId) {
            formData.append('_method', 'PUT');
        }

        // Show loading
        const btnSimpan = document.getElementById('btnSimpan');
        const originalText = btnSimpan.innerHTML;
        btnSimpan.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...';
        btnSimpan.disabled = true;
        
        // Set URL berdasarkan method
        let url = '{{ route("backend.announcements.store") }}';
        if (method === 'PUT') {
            url = '{{ route("backend.announcements.update", ":id") }}'.replace(':id', itemId);
        }
        
        console.log('Submitting to:', url);
        
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
            btnSimpan.innerHTML = originalText;
            btnSimpan.disabled = false;
            isSubmitting = false;
            
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
        .catch(error => {
            console.error('Error:', error);
            btnSimpan.innerHTML = originalText;
            btnSimpan.disabled = false;
            isSubmitting = false;
            
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Terjadi kesalahan saat menyimpan data.'
            });
        });
    });
    
    // Hapus data
    function hapusData(id, name) {
        Swal.fire({
            title: 'Hapus Pengumuman?',
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
                fetch(`{{ route('backend.announcements.destroy', '') }}/${id}`, {
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
                            text: data.message || 'Gagal menghapus pengumuman.'
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
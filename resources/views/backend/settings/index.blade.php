@extends('layouts.backend')

@section('title', 'Pengaturan Website')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Pengaturan Umum Website</h5>
                    <p class="text-sm mb-0">Kelola pengaturan dasar website SMK Wisata Indonesia</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            {{-- ========== INFORMASI SEKOLAH ========== --}}
                            <div class="col-12">
                                <h6 class="text-dark mb-3">
                                    <i class="fas fa-school me-2"></i> Informasi Sekolah
                                </h6>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Sekolah *</label>
                                <input type="text" name="site_name" class="form-control" 
                                       value="{{ old('site_name', $settings->site_name) }}" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tagline</label>
                                <input type="text" name="site_tagline" class="form-control" 
                                       value="{{ old('site_tagline', $settings->site_tagline) }}">
                            </div>
                            
                            <div class="col-12 mb-3">
                                <label class="form-label">Deskripsi Sekolah</label>
                                <textarea name="site_description" class="form-control" rows="3">{{ old('site_description', $settings->site_description) }}</textarea>
                                <small class="text-muted">Deskripsi singkat tentang sekolah (maks. 500 karakter)</small>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Alamat Sekolah</label>
                                <textarea name="site_address" class="form-control" rows="2">{{ old('site_address', $settings->site_address) }}</textarea>
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Telepon</label>
                                <input type="text" name="site_phone" class="form-control" 
                                       value="{{ old('site_phone', $settings->site_phone) }}">
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="site_email" class="form-control" 
                                       value="{{ old('site_email', $settings->site_email) }}">
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">NPSN</label>
                                <input type="text" name="school_npsn" class="form-control" 
                                       value="{{ old('school_npsn', $settings->school_npsn) }}">
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">NSS</label>
                                <input type="text" name="school_nss" class="form-control" 
                                       value="{{ old('school_nss', $settings->school_nss) }}">
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Akreditasi</label>
                                <input type="text" name="school_akreditation" class="form-control" 
                                       value="{{ old('school_akreditation', $settings->school_akreditation) }}">
                            </div>
                            
                            {{-- ========== LOGO & FAVICON ========== --}}
                            <div class="col-12 mt-4">
                                <h6 class="text-dark mb-3">
                                    <i class="fas fa-images me-2"></i> Logo & Favicon
                                </h6>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Logo Sekolah</label>
                                <div class="mb-2">
                                    @if($settings->site_logo)
                                        <img src="{{ asset($settings->site_logo) }}" alt="Logo" 
                                             class="img-thumbnail" style="max-height: 100px;">
                                    @else
                                        <div class="bg-light p-4 text-center rounded">
                                            <i class="fas fa-image fa-2x text-muted"></i>
                                            <p class="mt-2 mb-0 text-sm">Belum ada logo</p>
                                        </div>
                                    @endif
                                </div>
                                <input type="file" name="site_logo" class="form-control" accept="image/*">
                                <small class="text-muted">Ukuran rekomendasi: 200x60px (PNG/JPG)</small>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Favicon</label>
                                <div class="mb-2">
                                    @if($settings->site_favicon)
                                        <img src="{{ asset($settings->site_favicon) }}" alt="Favicon" 
                                             class="img-thumbnail" style="width: 64px; height: 64px;">
                                    @else
                                        <div class="bg-light p-4 text-center rounded">
                                            <i class="fas fa-image fa-2x text-muted"></i>
                                            <p class="mt-2 mb-0 text-sm">Belum ada favicon</p>
                                        </div>
                                    @endif
                                </div>
                                <input type="file" name="site_favicon" class="form-control" accept="image/x-icon,image/png">
                                <small class="text-muted">Ukuran: 32x32px atau 64x64px (ICO/PNG)</small>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Foto Kepala Sekolah</label>
                                <div class="mb-2">
                                    @if($settings->headmaster_photo)
                                        <img src="{{ asset($settings->headmaster_photo) }}" alt="Kepala Sekolah" 
                                             class="img-thumbnail" style="max-height: 100px;">
                                    @else
                                        <div class="bg-light p-4 text-center rounded">
                                            <i class="fas fa-user fa-2x text-muted"></i>
                                            <p class="mt-2 mb-0 text-sm">Belum ada foto</p>
                                        </div>
                                    @endif
                                </div>
                                <input type="file" name="headmaster_photo" class="form-control" accept="image/*">
                                <small class="text-muted">Ukuran rekomendasi: 400x500px</small>
                            </div>
                            
                            {{-- ========== KEPALA SEKOLAH ========== --}}
                            <div class="col-12 mt-4">
                                <h6 class="text-dark mb-3">
                                    <i class="fas fa-user-tie me-2"></i> Informasi Kepala Sekolah
                                </h6>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Kepala Sekolah</label>
                                <input type="text" name="headmaster_name" class="form-control" 
                                       value="{{ old('headmaster_name', $settings->headmaster_name) }}">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">NIP</label>
                                <input type="text" name="headmaster_nip" class="form-control" 
                                       value="{{ old('headmaster_nip', $settings->headmaster_nip) }}">
                            </div>
                            
                            <div class="col-12 mb-3">
                                <label class="form-label">Sambutan / Kata Pengantar</label>
                                <textarea
                                    name="headmaster_message"
                                    id="headmaster_message"
                                    class="form-control"
                                    rows="6"
                                >{{ old('headmaster_message', $settings->headmaster_message) }}</textarea>
                            </div>
                            
                            {{-- ========== MEDIA SOSIAL ========== --}}
                            <div class="col-12 mt-4">
                                <h6 class="text-dark mb-3">
                                    <i class="fas fa-share-alt me-2"></i> Media Sosial
                                </h6>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <i class="fab fa-facebook text-primary me-2"></i> Facebook URL
                                </label>
                                <input type="url" name="facebook" class="form-control" 
                                       value="{{ old('facebook', $settings->facebook) }}" 
                                       placeholder="https://facebook.com/smkwisataindonesia">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <i class="fab fa-instagram text-danger me-2"></i> Instagram URL
                                </label>
                                <input type="url" name="instagram" class="form-control" 
                                       value="{{ old('instagram', $settings->instagram) }}"
                                       placeholder="https://instagram.com/smkwisataindonesia">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <i class="fab fa-youtube text-danger me-2"></i> YouTube URL
                                </label>
                                <input type="url" name="youtube" class="form-control" 
                                       value="{{ old('youtube', $settings->youtube) }}"
                                       placeholder="https://youtube.com/c/smkwisataindonesia">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <i class="fab fa-tiktok me-2"></i> TikTok URL
                                </label>
                                <input type="url" name="tiktok" class="form-control" 
                                       value="{{ old('tiktok', $settings->tiktok) }}"
                                       placeholder="https://tiktok.com/@smkwisataindonesia">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">WhatsApp</label>
                                <div class="input-group">
                                    <span class="input-group-text">+62</span>
                                    <input type="text" name="site_whatsapp" class="form-control" 
                                           value="{{ old('site_whatsapp', $settings->site_whatsapp) }}"
                                           placeholder="81234567890">
                                </div>
                                <small class="text-muted">Nomor tanpa kode negara (+62)</small>
                            </div>
                            
                            {{-- ========== SEO ========== --}}
                            <div class="col-12 mt-4">
                                <h6 class="text-dark mb-3">
                                    <i class="fas fa-search me-2"></i> Pengaturan SEO
                                </h6>
                            </div>
                            
                            <div class="col-12 mb-3">
                                <label class="form-label">Meta Title</label>
                                <input type="text" name="meta_title" class="form-control" 
                                       value="{{ old('meta_title', $settings->meta_title) }}">
                                <small class="text-muted">Judul untuk mesin pencari (maks. 70 karakter)</small>
                            </div>
                            
                            <div class="col-12 mb-3">
                                <label class="form-label">Meta Description</label>
                                <textarea name="meta_description" class="form-control" rows="2">{{ old('meta_description', $settings->meta_description) }}</textarea>
                                <small class="text-muted">Deskripsi untuk mesin pencari (maks. 160 karakter)</small>
                            </div>
                            
                            <div class="col-12 mb-3">
                                <label class="form-label">Meta Keywords</label>
                                <input type="text" name="meta_keywords" class="form-control" 
                                       value="{{ old('meta_keywords', $settings->meta_keywords) }}">
                                <small class="text-muted">Kata kunci dipisahkan dengan koma</small>
                            </div>
                            
                            <div class="col-12 mb-3">
                                <label class="form-label">Google Analytics Tracking ID</label>
                                <input type="text" name="google_analytics" class="form-control" 
                                       value="{{ old('google_analytics', $settings->google_analytics) }}"
                                       placeholder="UA-XXXXX-Y atau G-XXXXXXXX">
                            </div>
                            
                            {{-- ========== PENGATURAN SISTEM ========== --}}
                            <div class="col-12 mt-4">
                                <h6 class="text-dark mb-3">
                                    <i class="fas fa-cogs me-2"></i> Pengaturan Sistem
                                </h6>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Zona Waktu</label>
                                <select name="timezone" class="form-select">
                                    <option value="Asia/Jakarta" {{ $settings->timezone == 'Asia/Jakarta' ? 'selected' : '' }}>WIB (Jakarta)</option>
                                    <option value="Asia/Makassar" {{ $settings->timezone == 'Asia/Makassar' ? 'selected' : '' }}>WITA (Makassar)</option>
                                    <option value="Asia/Jayapura" {{ $settings->timezone == 'Asia/Jayapura' ? 'selected' : '' }}>WIT (Jayapura)</option>
                                </select>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Format Tanggal</label>
                                <select name="date_format" class="form-select">
                                    <option value="d/m/Y" {{ $settings->date_format == 'd/m/Y' ? 'selected' : '' }}>DD/MM/YYYY</option>
                                    <option value="m/d/Y" {{ $settings->date_format == 'm/d/Y' ? 'selected' : '' }}>MM/DD/YYYY</option>
                                    <option value="Y-m-d" {{ $settings->date_format == 'Y-m-d' ? 'selected' : '' }}>YYYY-MM-DD</option>
                                </select>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Format Waktu</label>
                                <select name="time_format" class="form-select">
                                    <option value="H:i" {{ $settings->time_format == 'H:i' ? 'selected' : '' }}>24 Jam (14:30)</option>
                                    <option value="h:i A" {{ $settings->time_format == 'h:i A' ? 'selected' : '' }}>12 Jam (02:30 PM)</option>
                                </select>
                            </div>
                            
                            <div class="col-12 mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="maintenance_mode" 
                                           id="maintenance_mode" {{ $settings->maintenance_mode ? 'checked' : '' }}>
                                    <label class="form-check-label" for="maintenance_mode">
                                        <strong>Mode Maintenance</strong>
                                    </label>
                                    <small class="d-block text-muted">Aktifkan untuk melakukan pemeliharaan website</small>
                                </div>
                            </div>
                            
                            <div class="col-12 mb-3">
                                <label class="form-label">Pesan Maintenance</label>
                                <textarea name="maintenance_message" class="form-control" rows="3">{{ old('maintenance_message', $settings->maintenance_message) }}</textarea>
                            </div>
                            
                            {{-- ========== OPERATOR SEKOLAH ========== --}}
                            <div class="col-12 mt-4">
                                <h6 class="text-dark mb-3">
                                    <i class="fas fa-user-cog me-2"></i> Informasi Operator
                                </h6>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Operator</label>
                                <input type="text" name="school_operator_name" class="form-control" 
                                       value="{{ old('school_operator_name', $settings->school_operator_name) }}">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email Operator</label>
                                <input type="email" name="school_operator_email" class="form-control" 
                                       value="{{ old('school_operator_email', $settings->school_operator_email) }}">
                            </div>
                            
                            {{-- ========== SUBMIT ========== --}}
                            <div class="col-12 mt-4">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('backend.dashboard') }}" class="btn btn-light">
                                        <i class="fas fa-arrow-left me-2"></i> Kembali
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            {{-- ========== PREVIEW SETTINGS ========== --}}
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Preview Pengaturan</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Informasi Dasar:</h6>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between px-0">
                                    <span>Nama Sekolah:</span>
                                    <strong>{{ $settings->site_name }}</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between px-0">
                                    <span>Tagline:</span>
                                    <span>{{ $settings->site_tagline ?? '-' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between px-0">
                                    <span>Alamat:</span>
                                    <span class="text-end">{{ $settings->site_address ?? '-' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between px-0">
                                    <span>Telepon:</span>
                                    <span>{{ $settings->site_phone ?? '-' }}</span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6>Status Sistem:</h6>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between px-0">
                                    <span>Mode Maintenance:</span>
                                    <span class="badge bg-{{ $settings->maintenance_mode ? 'danger' : 'success' }}">
                                        {{ $settings->maintenance_mode ? 'AKTIF' : 'NON-AKTIF' }}
                                    </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between px-0">
                                    <span>Zona Waktu:</span>
                                    <span>{{ $settings->timezone }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between px-0">
                                    <span>Format Tanggal:</span>
                                    <span>{{ $settings->date_format }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between px-0">
                                    <span>Media Sosial Aktif:</span>
                                    <span>{{ $settings->hasSocialMedia() ? count(array_filter($settings->social_media)) : '0' }} platform</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Character counter for SEO fields
    document.addEventListener('DOMContentLoaded', function() {
        const metaTitle = document.querySelector('input[name="meta_title"]');
        const metaDesc = document.querySelector('textarea[name="meta_description"]');
        
        function createCounter(input, max) {
            const counter = document.createElement('small');
            counter.className = 'float-end text-muted';
            counter.innerHTML = `<span class="char-count">0</span>/${max} karakter`;
            
            input.parentNode.appendChild(counter);
            
            const charCount = counter.querySelector('.char-count');
            
            input.addEventListener('input', function() {
                const length = this.value.length;
                charCount.textContent = length;
                
                if (length > max) {
                    counter.classList.remove('text-muted');
                    counter.classList.add('text-danger');
                } else {
                    counter.classList.remove('text-danger');
                    counter.classList.add('text-muted');
                }
            });
            
            // Trigger initial count
            input.dispatchEvent(new Event('input'));
        }
        
        if (metaTitle) createCounter(metaTitle, 70);
        if (metaDesc) createCounter(metaDesc, 160);
        
        // Preview logo on file select
        const logoInput = document.querySelector('input[name="site_logo"]');
        const faviconInput = document.querySelector('input[name="site_favicon"]');
        const headmasterInput = document.querySelector('input[name="headmaster_photo"]');
        
        function previewImage(input, previewClass) {
            if (input) {
                input.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const preview = document.querySelector(previewClass);
                            if (preview) {
                                preview.src = e.target.result;
                            }
                        }
                        reader.readAsDataURL(file);
                    }
                });
            }
        }
        
        previewImage(logoInput, '.img-thumbnail:first-child');
        previewImage(faviconInput, '.img-thumbnail:nth-child(2)');
        previewImage(headmasterInput, '.img-thumbnail:nth-child(3)');
    });
</script>
<script src="{{ asset('assets/js/tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi TinyMCE
    tinymce.init({
        selector: '#headmaster_message',
        height: 350,
        menubar: true,
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table', 'help', 'wordcount'
        ],
        toolbar: 'undo redo | blocks | ' +
            'bold italic underline strikethrough | forecolor backcolor | ' +
            'alignleft aligncenter alignright alignjustify | ' +
            'bullist numlist outdent indent | ' +
            'link image media table | ' +
            'removeformat | help | code',
        
        // Konfigurasi bahasa
        language: 'id',
        language_url: '{{ asset("assets/js/tinymce/langs/id.js") }}',
        
        // Konfigurasi upload gambar
        images_upload_url: '{{ route("backend.upload.image") }}',
        images_upload_handler: function (blobInfo, progress) {
            return new Promise((resolve, reject) => {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route("backend.upload.image") }}');
                xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
                
                xhr.upload.onprogress = function (e) {
                    progress(e.loaded / e.total * 100);
                };
                
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
                        resolve(response.location || response.url);
                    } else {
                        reject('Upload gagal: ' + xhr.statusText);
                    }
                };
                
                xhr.onerror = function () {
                    reject('Koneksi jaringan error');
                };
                
                const formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());
                xhr.send(formData);
            });
        },
        
        // Konfigurasi validasi gambar
        images_file_types: 'jpeg,jpg,png,gif,webp',
        images_reuse_filename: true,
        
        // Konfigurasi styling
        content_style: `
            body { 
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif; 
                font-size: 14px; 
                line-height: 1.6; 
            }
            img { 
                max-width: 100%; 
                height: auto; 
            }
            table { 
                border-collapse: collapse; 
                width: 100%; 
            }
            table, th, td { 
                border: 1px solid #ddd; 
                padding: 8px; 
            }
        `,
        
        // Setup callback
        setup: function (editor) {
            editor.on('init', function () {
                console.log('TinyMCE initialized for headmaster message');
            });
        },
        
        // Promo bar (nonaktifkan untuk menghilangkan credit)
        promotion: false,
        
        // Konfigurasi branding (nonaktifkan)
        branding: false,
        
        // Resize editor
        resize: true,
        min_height: 350,
        max_height: 600,
        
        // Status bar
        statusbar: true,
        
        // Konfigurasi media
        media_live_embeds: true,
        media_alt_source: false,
        media_poster: false,
        
        // Konfigurasi link
        link_title: false,
        link_assume_external_targets: true,
        
        // Konfigurasi table
        table_header_type: 'section',
        table_use_colgroups: false,
        
        // Konfigurasi code view
        codemirror: {
            indentOnInit: true,
            path: 'codemirror',
            config: {
                mode: 'htmlmixed',
                lineNumbers: true
            }
        }
    });
    
    // Fungsi untuk mendapatkan konten dari TinyMCE sebelum submit
    document.querySelector('form').addEventListener('submit', function(e) {
        // TinyMCE secara otomatis menyinkronkan konten ke textarea
        // Tapi kita bisa tambahkan validasi jika perlu
        const editor = tinymce.get('headmaster_message');
        if (editor) {
            const content = editor.getContent();
            if (content.trim().length === 0) {
                // Jika konten kosong, bisa tambahkan alert atau validasi
                console.log('Konten sambutan kosong');
            }
        }
    });
});
</script>
@endpush
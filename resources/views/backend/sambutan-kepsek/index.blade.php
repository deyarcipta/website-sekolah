@extends('layouts.backend')
@section('title', 'Sambutan Kepala Sekolah')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Sambutan Kepala Sekolah</h5>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('backend.sambutan-kepsek.store') }}" method="POST" id="sambutanForm">
            @csrf
            
            <div class="row">
                <div class="col-12 mb-3">
                    <label class="form-label">Sambutan / Kata Pengantar *</label>
                    <textarea
                        name="deskripsi"
                        id="deskripsi"
                        class="form-control"
                        rows="10"
                        placeholder="Tulis sambutan kepala sekolah disini..."
                        required
                    >{{ old('deskripsi', $sambutan->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                    <div class="form-text">
                        Gunakan editor untuk memformat teks. Sambutan ini akan ditampilkan di halaman depan website.
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <i class="fas fa-save me-1"></i> Simpan Sambutan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    .tox-tinymce {
        border-radius: 0.375rem;
        border: 1px solid #ced4da;
    }
    
    .tox .tox-edit-area__iframe {
        background-color: #fff;
    }
    
    .tox-statusbar {
        border-top: 1px solid #e9ecef;
    }
</style>
@endpush

@push('scripts')
<script src="{{ asset('assets/js/tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script>
// Fungsi untuk menampilkan loading
function showLoading(title = 'Menyimpan...', text = 'Harap tunggu') {
    Swal.fire({
        title: title,
        text: text,
        allowOutsideClick: false,
        showConfirmButton: false,
        willOpen: () => {
            Swal.showLoading();
        }
    });
}

// Fungsi untuk menutup loading
function closeLoading() {
    Swal.close();
}

// Fungsi untuk menampilkan toast sukses
function showSuccessToast(message) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
    
    Toast.fire({
        icon: 'success',
        title: message
    });
}

// Fungsi konfirmasi delete
function confirmDelete(title, html, callback) {
    Swal.fire({
        title: title,
        html: html,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            callback();
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi TinyMCE
    tinymce.init({
        selector: '#deskripsi',
        height: 400,
        menubar: true,
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'table', 'help', 'wordcount'
        ],
        toolbar: 'undo redo | blocks | ' +
            'bold italic underline strikethrough | forecolor backcolor | ' +
            'alignleft aligncenter alignright alignjustify | ' +
            'bullist numlist outdent indent | ' +
            'link table | ' +
            'removeformat | help | code',
        
        language: 'id',
        language_url: '{{ asset("assets/js/tinymce/langs/id.js") }}',
        
        content_style: `
            body { 
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif; 
                font-size: 14px; 
                line-height: 1.6; 
                color: #212529;
            }
            h1, h2, h3, h4, h5, h6 {
                margin-top: 1rem;
                margin-bottom: 0.5rem;
                font-weight: 600;
                line-height: 1.2;
            }
            h1 { font-size: 2rem; }
            h2 { font-size: 1.75rem; }
            h3 { font-size: 1.5rem; }
            h4 { font-size: 1.25rem; }
            h5 { font-size: 1.125rem; }
            h6 { font-size: 1rem; }
            p { 
                margin-bottom: 1rem;
                text-align: justify;
            }
            ul, ol {
                margin-bottom: 1rem;
                padding-left: 2rem;
            }
            table { 
                border-collapse: collapse; 
                width: 100%; 
                margin-bottom: 1rem;
            }
            table, th, td { 
                border: 1px solid #dee2e6; 
                padding: 0.75rem; 
            }
            th {
                background-color: #f8f9fa;
                font-weight: 600;
            }
            blockquote {
                margin: 0 0 1rem;
                padding: 0.5rem 1rem;
                border-left: 4px solid #007bff;
                background-color: #f8f9fa;
                font-style: italic;
            }
            a {
                color: #007bff;
                text-decoration: none;
            }
            a:hover {
                text-decoration: underline;
            }
        `,
        
        setup: function (editor) {
            editor.on('init', function () {
                console.log('TinyMCE initialized for sambutan kepala sekolah');
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
        link_title: false,
        link_assume_external_targets: true,
        link_target_list: [
            {title: 'Halaman Saat Ini', value: ''},
            {title: 'Tab Baru', value: '_blank'}
        ],
        table_header_type: 'section',
        table_use_colgroups: false,
        table_class_list: [
            {title: 'Default', value: ''},
            {title: 'Striped', value: 'table-striped'},
            {title: 'Bordered', value: 'table-bordered'}
        ],
        codemirror: {
            indentOnInit: true,
            path: 'codemirror',
            config: {
                mode: 'htmlmixed',
                lineNumbers: true,
                lineWrapping: true,
                theme: 'default'
            }
        },
        formats: {
            alignleft: {selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'text-start'},
            aligncenter: {selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'text-center'},
            alignright: {selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'text-end'},
            alignfull: {selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'text-justify'}
        },
        style_formats: [
            {title: 'Judul Besar', format: 'h1'},
            {title: 'Judul Sedang', format: 'h2'},
            {title: 'Judul Kecil', format: 'h3'},
            {title: 'Paragraf', format: 'p'},
            {title: 'Kutipan', format: 'blockquote'},
            {title: 'Kode', format: 'code'},
            {title: 'Div Container', format: 'div', attributes: {class: 'container'}}
        ],
        valid_elements: '*[*]',
        valid_children: '+body[p,div,h1,h2,h3,h4,h5,h6,ul,ol,li,table,blockquote]',
        verify_html: true,
        cleanup: true,
        cleanup_on_startup: true,
        forced_root_block: 'p',
        force_br_newlines: false,
        force_p_newlines: true,
        convert_newlines_to_brs: false,
        remove_linebreaks: true,
        browser_spellcheck: true,
        contextmenu: 'link table',
        elementpath: true,
        relative_urls: false,
        remove_script_host: true,
        convert_urls: false
    });
    
    // Form submit handler dengan AJAX
    $('#sambutanForm').on('submit', function(e) {
        e.preventDefault();
        
        var form = $(this);
        var formData = form.serialize();
        
        // Clear previous errors
        form.find('.is-invalid').removeClass('is-invalid');
        form.find('.invalid-feedback').text('');
        
        // Validasi konten tidak kosong
        const editor = tinymce.get('deskripsi');
        if (editor) {
            editor.save();
            const content = editor.getContent().trim();
            if (content.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan',
                    text: 'Sambutan tidak boleh kosong!'
                });
                editor.focus();
                return false;
            }
        }
        
        // Tampilkan loading
        showLoading('Menyimpan...', 'Harap tunggu');
        
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: formData,
            success: function(response) {
                closeLoading();
                
                // Tampilkan SweetAlert sukses
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: response.message || 'Sambutan kepala sekolah berhasil disimpan.',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    // Reload halaman untuk melihat perubahan
                    window.location.reload();
                });
            },
            error: function(xhr) {
                closeLoading();
                
                if (xhr.status === 422) {
                    // Validasi error
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        var input = $('[name="' + key + '"]');
                        input.addClass('is-invalid');
                        input.closest('.mb-3').find('.invalid-feedback').text(value[0]);
                    });
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Validasi Gagal',
                        text: 'Harap perbaiki kesalahan pada form.'
                    });
                } else {
                    // Error lainnya
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: xhr.responseJSON.message || 'Terjadi kesalahan saat menyimpan.'
                    });
                }
            }
        });
    });
});

// Tampilkan SweetAlert dari session jika ada
@if(session('success'))
    $(document).ready(function() {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 1500
        });
    });
@endif

@if(session('error'))
    $(document).ready(function() {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ session('error') }}',
            showConfirmButton: true
        });
    });
@endif
</script>
@endpush
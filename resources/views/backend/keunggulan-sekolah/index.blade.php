@extends('layouts.backend')
@section('title', 'Keunggulan Sekolah')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Keunggulan Sekolah</h5>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#keunggulanModal" onclick="resetForm()">
                <i class="fas fa-plus"></i> Tambah Keunggulan
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="50">Urutan</th>
                        <th>Icon & Warna</th>
                        <th>Judul</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody id="sortable">
                    @foreach($keunggulan as $item)
                    <tr data-id="{{ $item->id }}">
                        <td>
                            <i class="fas fa-arrows-alt handle text-secondary"></i>
                            {{ $item->urutan }}
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($item->icon)
                                    <i class="{{ $item->icon }} fa-lg me-2" style="color: {{ $item->warna ?? '#007bff' }};"></i>
                                @else
                                    <i class="fas fa-star fa-lg me-2" style="color: {{ $item->warna ?? '#007bff' }};"></i>
                                @endif
                                <div class="color-preview" style="width: 20px; height: 20px; background-color: {{ $item->warna ?? '#007bff' }}; border-radius: 3px;"></div>
                            </div>
                        </td>
                        <td>{{ $item->judul }}</td>
                        <td>{{ Str::limit($item->deskripsi, 50) }}</td>
                        <td>
                            @if($item->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-warning edit-btn" 
                                    data-id="{{ $item->id }}"
                                    data-judul="{{ $item->judul }}"
                                    data-deskripsi="{{ $item->deskripsi }}"
                                    data-icon="{{ $item->icon }}"
                                    data-warna="{{ $item->warna }}"
                                    data-urutan="{{ $item->urutan }}"
                                    data-is_active="{{ $item->is_active }}"
                                    onclick="editData(this)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="deleteData({{ $item->id }}, '{{ $item->judul }}')" 
                                    class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="keunggulanModal" tabindex="-1" aria-labelledby="keunggulanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Tambah Keunggulan Sekolah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="keunggulanForm">
                    @csrf
                    <input type="hidden" id="formMethod" name="_method" value="POST">
                    <input type="hidden" id="itemId" name="id">
                    
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul *</label>
                        <input type="text" class="form-control" 
                               id="judul" name="judul" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" 
                                  id="deskripsi" name="deskripsi" rows="3"></textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="icon" class="form-label">Icon Font Awesome</label>
                            <input type="text" class="form-control" 
                                   id="icon" name="icon" 
                                   placeholder="fas fa-star">
                            <small class="text-muted">Contoh: fas fa-star, fas fa-check, etc</small>
                            <div class="invalid-feedback"></div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="warna" class="form-label">Warna</label>
                            <div class="input-group">
                                <input type="color" class="form-control form-control-color" 
                                       id="warna" name="warna" 
                                       value="#007bff"
                                       title="Pilih warna">
                                <input type="text" class="form-control" 
                                       id="warna_hex" 
                                       value="#007bff"
                                       placeholder="#007bff">
                            </div>
                            <small class="text-muted">Warna dalam format HEX</small>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="urutan" class="form-label">Urutan</label>
                        <input type="number" class="form-control" 
                               id="urutan" name="urutan" value="0">
                        <div class="invalid-feedback"></div>
                    </div>
                    
                    <div class="mb-3 form-check" id="statusField" style="display: none;">
                        <input type="checkbox" class="form-check-input" 
                               id="is_active" name="is_active" value="1">
                        <label class="form-check-label" for="is_active">Aktif</label>
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .handle {
        cursor: move;
        cursor: -webkit-grabbing;
    }
    .color-preview {
        border: 1px solid #ddd;
    }
    .form-control-color {
        height: 38px;
        padding: 5px;
    }
</style>
@endpush

@push('scripts')
<script>
    $(function() {
        // Initialize sortable
        $("#sortable").sortable({
            handle: '.handle',
            update: function(event, ui) {
                var urutan = [];
                $('#sortable tr').each(function() {
                    urutan.push($(this).data('id'));
                });
                
                $.ajax({
                    url: "{{ route('backend.keunggulan-sekolah.update-urutan') }}",
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        urutan: urutan
                    },
                    success: function(response) {
                        if (response.success) {
                            // Update nomor urutan
                            $('#sortable tr').each(function(index) {
                                $(this).find('td:first').html(
                                    '<i class="fas fa-arrows-alt handle text-secondary"></i> ' + 
                                    (index + 1)
                                );
                            });
                            
                            showSuccessToast('Urutan berhasil diperbarui.');
                        }
                    }
                });
            }
        });

        // Sync color picker dengan text input
        $('#warna').on('input', function() {
            $('#warna_hex').val($(this).val());
        });
        
        $('#warna_hex').on('input', function() {
            var color = $(this).val();
            if (/^#[0-9A-F]{6}$/i.test(color)) {
                $('#warna').val(color);
            }
        });

        // Form submit handler
        $('#keunggulanForm').on('submit', function(e) {
            e.preventDefault();
            
            var form = $(this);
            var formData = form.serialize();
            var method = form.find('#formMethod').val();
            var id = form.find('#itemId').val();
            
            // Set URL based on method
            var url = method === 'PUT' 
                ? "{{ route('backend.keunggulan-sekolah.update', ':id') }}".replace(':id', id)
                : "{{ route('backend.keunggulan-sekolah.store') }}";
            
            // Clear previous errors
            form.find('.is-invalid').removeClass('is-invalid');
            form.find('.invalid-feedback').text('');
            
            showLoading('Menyimpan...', 'Harap tunggu');
            
            $.ajax({
                url: url,
                method: method,
                data: formData,
                success: function(response) {
                    closeLoading();
                    
                    if (response.success) {
                        // Close modal
                        $('#keunggulanModal').modal('hide');
                        
                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            // Reload page to see changes
                            window.location.reload();
                        });
                    }
                }
            });
        });
    });
    
    function resetForm() {
        $('#modalTitle').text('Tambah Keunggulan Sekolah');
        $('#formMethod').val('POST');
        $('#itemId').val('');
        $('#keunggulanForm')[0].reset();
        $('#warna').val('#007bff');
        $('#warna_hex').val('#007bff');
        $('#statusField').hide();
        $('#is_active').prop('checked', false);
        
        // Clear validation errors
        $('#keunggulanForm').find('.is-invalid').removeClass('is-invalid');
        $('#keunggulanForm').find('.invalid-feedback').text('');
    }
    
    function editData(button) {
        $('#modalTitle').text('Edit Keunggulan Sekolah');
        $('#formMethod').val('PUT');
        
        // Set form values
        $('#itemId').val($(button).data('id'));
        $('#judul').val($(button).data('judul'));
        $('#deskripsi').val($(button).data('deskripsi'));
        $('#icon').val($(button).data('icon'));
        
        // Set warna
        var warna = $(button).data('warna') || '#007bff';
        $('#warna').val(warna);
        $('#warna_hex').val(warna);
        
        $('#urutan').val($(button).data('urutan'));
        
        // Set checkbox
        var isActive = $(button).data('is_active');
        $('#is_active').prop('checked', isActive == 1 || isActive === true);
        
        // Show status field
        $('#statusField').show();
        
        // Clear validation errors
        $('#keunggulanForm').find('.is-invalid').removeClass('is-invalid');
        $('#keunggulanForm').find('.invalid-feedback').text('');
        
        // Show modal
        $('#keunggulanModal').modal('show');
    }
    
    function deleteData(id, judul) {
        confirmDelete(
            'Hapus Keunggulan?',
            `Anda akan menghapus: <strong>"${judul}"</strong><br>Data yang dihapus tidak dapat dikembalikan.`,
            function() {
                $.ajax({
                    url: "{{ url('backend/keunggulan-sekolah') }}/" + id,
                    method: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Terhapus!',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                window.location.reload();
                            });
                        }
                    }
                });
            }
        );
    }
</script>
@endpush
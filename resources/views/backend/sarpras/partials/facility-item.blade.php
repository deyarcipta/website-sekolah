{{-- resources/views/backend/sarpras/partials/facility-item.blade.php --}}
<div class="card mb-3 border facilities-item" data-index="{{ $index }}">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h6 class="mb-0">Fasilitas {{ $index + 1 }}</h6>
        @if($index >= 1)
        <button type="button" 
                class="btn btn-sm btn-outline-danger remove-facilities-item-btn"
                data-index="{{ $index }}">
            <i class="fas fa-trash"></i>
        </button>
        @endif
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label fw-bold">Judul Fasilitas <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control facility-title-input" 
                           name="facility_title[]" 
                           value="{{ $item['title'] }}"
                           placeholder="Contoh: Ruang Belajar Full AC"
                           data-index="{{ $index }}"
                           required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label fw-bold">Deskripsi <span class="text-danger">*</span></label>
                    <textarea class="form-control facility-desc-input" 
                              name="facility_desc[]" 
                              rows="2"
                              placeholder="Deskripsi fasilitas..."
                              data-index="{{ $index }}"
                              required>{{ $item['desc'] }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>
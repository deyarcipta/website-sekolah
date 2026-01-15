{{-- resources/views/backend/sarpras/partials/gallery-item.blade.php --}}
<div class="col-md-4 mb-4 gallery-item" data-index="{{ $index }}">
    <div class="card border h-100">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h6 class="mb-0">Gambar {{ $index + 1 }}</h6>
            @if($index >= 1)
            <button type="button" 
                    class="btn btn-sm btn-outline-danger remove-gallery-item-btn"
                    data-index="{{ $index }}">
                <i class="fas fa-trash"></i>
            </button>
            @endif
        </div>
        <div class="card-body text-center">
            <!-- Current Image -->
            <div class="mb-3">
                <div class="position-relative d-inline-block">
                    @php
                        $imageUrl = $image;
                        if (strpos($image, 'assets/') === 0) {
                            $imageUrl = asset($image);
                        } elseif (strpos($image, 'storage/') === 0) {
                            $imageUrl = asset($image);
                        } else {
                            $imageUrl = asset('assets/img/placeholder.jpg');
                        }
                    @endphp
                    <img src="{{ $imageUrl }}" 
                         class="img-fluid rounded border" 
                         style="max-height: 150px; width: 100%; object-fit: cover;"
                         id="current-gallery-image-{{ $index }}"
                         data-original-src="{{ $imageUrl }}">
                    @if(strpos($image, 'storage/') === 0)
                    <div class="position-absolute top-0 end-0 mt-2 me-2">
                        <button type="button" 
                                class="btn btn-sm btn-danger remove-gallery-image" 
                                data-index="{{ $index }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Upload New Image -->
            <div class="form-group">
                <input type="file" 
                       class="form-control gallery-image-input" 
                       name="gallery_images[]" 
                       accept="image/*"
                       id="gallery-image-input-{{ $index }}"
                       data-index="{{ $index }}">
                <small class="text-muted d-block mt-2">
                    <i class="fas fa-ruler-combined me-1"></i>
                    Ukuran: 400x300px (rasio 4:3)
                </small>
            </div>
            
            <!-- Hidden input untuk gambar yang sudah ada -->
            <input type="hidden" 
                   name="existing_gallery_images[]" 
                   value="{{ $image }}">
        </div>
    </div>
</div>
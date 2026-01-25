@extends('layouts.frontend')

@section('title', $gallery->meta_title ?: $gallery->judul . ' - SMK Wisata Indonesia Jakarta')

@section('content')

{{-- === Hero Section === --}}
@include('frontend.partials.hero', [
    'title' => 'GALLERY ' . $gallery->judul,
    'backgroundImage' => 'assets/img/foto-gedung.png',
    'height' => '200px'
])

<section class="gallery-show py-5">
    <div class="container">

        {{-- Gallery Info --}}
        <div class="row mb-5">
            <div class="col-lg-12">
                <div class="gallery-info-card p-4 shadow-sm rounded">
                    <h1 class="fw-bold mb-3">{{ $gallery->judul }}</h1>
                    
                    @if($gallery->deskripsi)
                        <div class="gallery-description mb-4">
                            {!! nl2br(e($gallery->deskripsi)) !!}
                        </div>
                    @endif

                    <div class="d-flex flex-wrap gap-3 text-muted">
                        @if($gallery->tanggal)
                            <div class="d-flex align-items-center">
                                <i class="fas fa-calendar-alt me-2"></i>
                                <span>{{ \Carbon\Carbon::parse($gallery->tanggal)->format('d F Y') }}</span>
                            </div>
                        @endif
                        
                        @if($gallery->lokasi)
                            <div class="d-flex align-items-center">
                                <i class="fas fa-map-marker-alt me-2"></i>
                                <span>{{ $gallery->lokasi }}</span>
                            </div>
                        @endif
                        
                        <div class="d-flex align-items-center">
                            <i class="fas fa-images me-2"></i>
                            <span>{{ $gallery->images->count() }} Foto</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Gallery Images Grid --}}
        @if($gallery->images->isNotEmpty())
            <div class="row mb-5">
                <div class="col-12">
                    <div class="row g-4">
                        @foreach($gallery->images as $index => $image)
                            <div class="col-md-4 col-lg-3 col-sm-6">
                                <div class="gallery-image-card shadow-sm rounded overflow-hidden cursor-pointer"
                                     data-bs-toggle="modal" 
                                     data-bs-target="#imageModal"
                                     data-image-index="{{ $index }}">
                                    <img src="{{ asset('storage/' . $image->image) }}" 
                                         class="img-fluid w-100 gallery-thumbnail" 
                                         alt="{{ $image->caption ?? $gallery->judul }}"
                                         style="height: 250px; object-fit: cover;"
                                         data-src="{{ asset('storage/' . $image->image) }}"
                                         data-caption="{{ $image->caption ?? '' }}">
                                    
                                    @if($image->caption)
                                        <div class="image-caption p-3 bg-light">
                                            <p class="mb-0 text-center">{{ $image->caption }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        {{-- Lightbox Modal --}}
        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0">
                    <div class="modal-header bg-dark text-white">
                        <h5 class="modal-title" id="imageModalLabel">
                            <span id="modalImageCount"></span>
                            <span id="modalImageCaption"></span>
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div id="modalCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($gallery->images as $index => $image)
                                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                        <img src="{{ asset('storage/' . $image->image) }}" 
                                             class="d-block w-100" 
                                             alt="{{ $image->caption ?? $gallery->judul }}"
                                             style="max-height: 70vh; object-fit: contain;">
                                    </div>
                                @endforeach
                            </div>
                            
                            @if($gallery->images->count() > 1)
                                <button class="carousel-control-prev" type="button" data-bs-target="#modalCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#modalCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer bg-dark text-white justify-content-between">
                        <div>
                            <button type="button" class="btn btn-outline-light btn-sm" id="downloadBtn">
                                <i class="fas fa-download me-1"></i> Download
                            </button>
                        </div>
                        <div class="text-center flex-grow-1">
                            <span id="currentImageNumber">1</span> / {{ $gallery->images->count() }}
                        </div>
                        <div>
                            <button type="button" class="btn btn-outline-light btn-sm" id="fullscreenBtn">
                                <i class="fas fa-expand me-1"></i> Fullscreen
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- YouTube Video (if exists) --}}
        @if($gallery->youtube_url && $youtubeId = $this->getYoutubeId($gallery->youtube_url))
            <div class="row mb-5">
                <div class="col-12">
                    <h2 class="fw-bold mb-4 text-center text-purple">Video</h2>
                    <div class="ratio ratio-16x9">
                        <iframe src="https://www.youtube.com/embed/{{ $youtubeId }}" 
                                title="{{ $gallery->judul }}" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen>
                        </iframe>
                    </div>
                </div>
            </div>
        @endif

        {{-- Next/Previous Navigation --}}
        <div class="row mb-5">
            <div class="col-12">
                <div class="d-flex justify-content-between">
                    @if($previousGallery)
                        <a href="{{ route('frontend.gallery.show', $previousGallery->slug) }}" class="btn btn-outline-purple">
                            <i class="fas fa-arrow-left me-2"></i> Sebelumnya: {{ Str::limit($previousGallery->judul, 30) }}
                        </a>
                    @else
                        <span></span>
                    @endif
                    
                    @if($nextGallery)
                        <a href="{{ route('frontend.gallery.show', $nextGallery->slug) }}" class="btn btn-outline-purple">
                            Selanjutnya: {{ Str::limit($nextGallery->judul, 30) }} <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    @else
                        <span></span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Related Galleries --}}
        @if($relatedGalleries->isNotEmpty())
            <div class="row">
                <div class="col-12">
                    <h2 class="fw-bold mb-4 text-center text-purple">Galeri Lainnya</h2>
                    
                    <div class="row g-4">
                        @foreach($relatedGalleries as $related)
                            <div class="col-md-4 col-lg-3 col-sm-6">
                                <div class="related-gallery-card shadow-sm rounded overflow-hidden">
                                    <a href="{{ route('frontend.gallery.show', $related->slug) }}">
                                        <img src="{{ $related->images->isNotEmpty() ? asset('storage/' . $related->cover_image) : 'assets/img/no-image.jpg' }}" 
                                             class="img-fluid w-100" 
                                             alt="{{ $related->judul }}"
                                             style="height: 200px; object-fit: cover;">
                                    </a>
                                    <div class="p-3">
                                        <h5 class="fw-bold mb-2">{{ Str::limit($related->judul, 50) }}</h5>
                                        @if($related->tanggal)
                                            <small class="text-muted">
                                                <i class="fas fa-calendar-alt me-1"></i>
                                                {{ \Carbon\Carbon::parse($related->tanggal)->format('d M Y') }}
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    @if($relatedGalleries->hasPages())
                        <div class="row mt-5">
                            <div class="col-12">
                                <nav aria-label="Related galleries pagination">
                                    <ul class="pagination justify-content-center mb-0">
                                        {{-- Previous Page Link --}}
                                        @if($relatedGalleries->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link">&laquo;</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $relatedGalleries->previousPageUrl() }}" aria-label="Sebelumnya">
                                                    &laquo;
                                                </a>
                                            </li>
                                        @endif

                                        {{-- Pagination Elements --}}
                                        @php
                                            $current = $relatedGalleries->currentPage();
                                            $last = $relatedGalleries->lastPage();
                                            $start = max(1, $current - 1);
                                            $end = min($last, $current + 1);
                                            
                                            if ($start > 1) {
                                                $start = max(1, $current - 0);
                                            }
                                            if ($end < $last) {
                                                $end = min($last, $current + 0);
                                            }
                                        @endphp

                                        @if($start > 1)
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $relatedGalleries->url(1) }}">1</a>
                                            </li>
                                            @if($start > 2)
                                                <li class="page-item disabled">
                                                    <span class="page-link">...</span>
                                                </li>
                                            @endif
                                        @endif

                                        @for($page = $start; $page <= $end; $page++)
                                            @if($page == $relatedGalleries->currentPage())
                                                <li class="page-item active">
                                                    <span class="page-link">{{ $page }}</span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $relatedGalleries->url($page) }}">{{ $page }}</a>
                                                </li>
                                            @endif
                                        @endfor

                                        @if($end < $last)
                                            @if($end < $last - 1)
                                                <li class="page-item disabled">
                                                    <span class="page-link">...</span>
                                                </li>
                                            @endif
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $relatedGalleries->url($last) }}">{{ $last }}</a>
                                            </li>
                                        @endif

                                        {{-- Next Page Link --}}
                                        @if($relatedGalleries->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $relatedGalleries->nextPageUrl() }}" aria-label="Selanjutnya">
                                                    &raquo;
                                                </a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <span class="page-link">&raquo;</span>
                                            </li>
                                        @endif
                                    </ul>
                                    
                                    {{-- Info --}}
                                    <div class="text-center text-muted mt-2">
                                        <small>
                                            Menampilkan {{ $relatedGalleries->firstItem() }} - {{ $relatedGalleries->lastItem() }} dari {{ $relatedGalleries->total() }} galeri
                                        </small>
                                    </div>
                                </nav>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
</section>
@endsection

@push('styles')
<style>
    .gallery-info-card {
        background-color: #f8f9fa;
        border-left: 4px solid #6b02b1;
    }

    .gallery-description {
        line-height: 1.8;
        color: #495057;
    }

    .gallery-image-card {
        transition: transform 0.8s ease, box-shadow 0.8s ease;
        background-color: #fff;
        cursor: pointer;
    }

    .gallery-image-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 15px rgba(107, 2, 177, 0.25) !important;
    }

    .image-caption {
        border-top: 1px solid #dee2e6;
    }

    .related-gallery-card {
        transition: transform 0.3s ease;
        background-color: #fff;
        height: 100%;
    }

    .related-gallery-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 15px rgba(107, 2, 177, 0.15) !important;
    }

    .btn-outline-purple {
        color: #6b02b1;
        border-color: #6b02b1;
    }

    .btn-outline-purple:hover {
        background-color: #6b02b1;
        color: white;
    }

    .text-purple {
        color: #6b02b1 !important;
    }

    .cursor-pointer {
        cursor: pointer;
    }

    /* Modal styles */
    #imageModal .modal-content {
        background-color: transparent;
        border: none;
    }

    #imageModal .modal-header,
    #imageModal .modal-footer {
        background-color: rgba(0, 0, 0, 0.8);
        border: none;
    }

    #imageModal .carousel-control-prev,
    #imageModal .carousel-control-next {
        width: 50px;
        height: 50px;
        top: 50%;
        transform: translateY(-50%);
        opacity: 0.7;
    }

    #imageModal .carousel-control-prev:hover,
    #imageModal .carousel-control-next:hover {
        opacity: 1;
    }

    /* Pagination Styles */
    .pagination {
        margin-bottom: 0;
    }

    .page-link {
        color: #6b02b1;
        border: 1px solid #dee2e6;
        margin: 0 3px;
        border-radius: 5px;
        transition: all 0.3s;
    }

    .page-link:hover {
        color: #fff;
        background-color: #6b02b1;
        border-color: #6b02b1;
    }

    .page-item.active .page-link {
        background-color: #6b02b1;
        border-color: #6b02b1;
        color: white;
    }

    .page-item.disabled .page-link {
        color: #6c757d;
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .gallery-image-card img {
            height: 200px;
        }
        
        #imageModal .modal-dialog {
            margin: 0;
            max-width: 100%;
        }
        
        #imageModal .carousel-control-prev,
        #imageModal .carousel-control-next {
            width: 40px;
            height: 40px;
        }
        
        .page-link {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
            margin: 0 2px;
        }
    }
    
    @media (max-width: 576px) {
        .pagination {
            flex-wrap: wrap;
        }
        
        .page-item {
            margin-bottom: 5px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Bootstrap modal
        const imageModal = document.getElementById('imageModal');
        const modalInstance = new bootstrap.Modal(imageModal);
        
        // Initialize carousel
        const modalCarousel = document.getElementById('modalCarousel');
        const carouselInstance = new bootstrap.Carousel(modalCarousel, {
            interval: 4000, // 4 detik
            ride: 'carousel',
            pause: 'hover',
            wrap: true
        });
        
        // When modal is shown, go to clicked image
        imageModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const slideIndex = button.getAttribute('data-image-index');
            
            if (slideIndex !== null) {
                carouselInstance.to(parseInt(slideIndex));
                updateImageCounter(parseInt(slideIndex) + 1);
            }
        });
        
        // Update image counter when carousel slides
        modalCarousel.addEventListener('slid.bs.carousel', function(event) {
            const activeIndex = event.to;
            updateImageCounter(activeIndex + 1);
        });
        
        // Download button functionality
        document.getElementById('downloadBtn').addEventListener('click', function() {
            const activeItem = modalCarousel.querySelector('.carousel-item.active img');
            const imageUrl = activeItem.src;
            const imageName = imageUrl.split('/').pop();
            
            // Create temporary link for download
            const link = document.createElement('a');
            link.href = imageUrl;
            link.download = imageName || 'gambar.jpg';
            link.target = '_blank';
            
            // Append to body, click, and remove
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });
        
        // Fullscreen button functionality
        document.getElementById('fullscreenBtn').addEventListener('click', function() {
            const modalContent = document.querySelector('#imageModal .modal-content');
            
            if (!document.fullscreenElement) {
                // Enter fullscreen
                if (modalContent.requestFullscreen) {
                    modalContent.requestFullscreen();
                } else if (modalContent.webkitRequestFullscreen) {
                    modalContent.webkitRequestFullscreen();
                } else if (modalContent.msRequestFullscreen) {
                    modalContent.msRequestFullscreen();
                }
                
                // Update button icon
                this.innerHTML = '<i class="fas fa-compress me-1"></i> Exit Fullscreen';
                this.setAttribute('title', 'Keluar dari mode layar penuh');
            } else {
                // Exit fullscreen
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.webkitExitFullscreen) {
                    document.webkitExitFullscreen();
                } else if (document.msExitFullscreen) {
                    document.msExitFullscreen();
                }
                
                // Update button icon
                this.innerHTML = '<i class="fas fa-expand me-1"></i> Fullscreen';
                this.setAttribute('title', 'Mode layar penuh');
            }
        });
        
        // Update fullscreen button when exiting fullscreen
        document.addEventListener('fullscreenchange', function() {
            const fullscreenBtn = document.getElementById('fullscreenBtn');
            if (!document.fullscreenElement) {
                fullscreenBtn.innerHTML = '<i class="fas fa-expand me-1"></i> Fullscreen';
                fullscreenBtn.setAttribute('title', 'Mode layar penuh');
            }
        });
        
        // Function to update image counter
        function updateImageCounter(current) {
            const total = {{ $gallery->images->count() }};
            document.getElementById('currentImageNumber').textContent = current;
        }
        
        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (imageModal.classList.contains('show')) {
                switch(e.key) {
                    case 'ArrowLeft':
                        carouselInstance.prev();
                        e.preventDefault();
                        break;
                    case 'ArrowRight':
                        carouselInstance.next();
                        e.preventDefault();
                        break;
                    case 'Escape':
                        if (document.fullscreenElement) {
                            // Exit fullscreen first
                            if (document.exitFullscreen) {
                                document.exitFullscreen();
                            }
                        } else {
                            modalInstance.hide();
                        }
                        e.preventDefault();
                        break;
                    case ' ':
                        e.preventDefault(); // Prevent spacebar from scrolling
                        break;
                }
            }
        });
        
        // Close modal when clicking on backdrop (outside modal content)
        imageModal.addEventListener('click', function(e) {
            if (e.target === imageModal) {
                modalInstance.hide();
            }
        });
        
        // Click to zoom image
        modalCarousel.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal-image')) {
                e.target.classList.toggle('zoomed');
            }
        });
        
        // Initialize image counter
        document.getElementById('totalImages').textContent = {{ $gallery->images->count() }};
        updateImageCounter(1);
    });
</script>
@endpush
@extends('layouts.frontend')

@section('title', 'Galeri - SMK Wisata Indonesia Jakarta')

@section('content')

{{-- === Hero Section === --}}
@include('frontend.partials.hero', [
  'title' => 'Galeri',
  'backgroundImage' => 'assets/img/foto-gedung.png',
  'height' => '200px'
])

<section class="galeri-list py-5">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <!-- Header -->
        <div class="content-header mb-5">
          <div class="row align-items-center">
            <div class="col-md-8">
              <h1 class="mb-0 text-purple fw-bold">Galeri Kegiatan</h1>
              <p class="text-muted mb-0 mt-2">Kumpulan dokumentasi kegiatan dan momen spesial di SMK Wisata Indonesia Jakarta</p>
            </div>
            <div class="col-md-4 mt-3 mt-md-0">
              <form action="{{ route('frontend.gallery.index') }}" method="GET" class="search-form">
                <div class="input-group">
                  <input type="text" name="search" class="form-control border-primary" 
                         placeholder="Cari galeri..." value="{{ request('search') }}">
                  <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </form>
            </div>
          </div>
          
          <!-- Filter Tags -->
          @if(request('search'))
            <div class="filter-tags mt-3">
              <span class="badge bg-info me-2 mb-2">
                Pencarian: "{{ request('search') }}"
                <a href="{{ route('frontend.gallery.index') }}" class="text-white ms-2">
                  <i class="fas fa-times"></i>
                </a>
              </span>
            </div>
          @endif
        </div>

        @if($galleries->count() > 0)
          <!-- Gallery Grid -->
          <div class="row g-4">
            @foreach($galleries as $gallery)
              <div class="col-md-4 col-lg-3 col-sm-6">
                <div class="related-gallery-card shadow-sm rounded overflow-hidden">
                  <a href="{{ route('frontend.gallery.show', $gallery->slug) }}">
                    <img src="{{ $gallery->images->isNotEmpty() ? asset('storage/' . $gallery->cover_image) : 'assets/img/no-image.jpg' }}" 
                         class="img-fluid w-100" 
                         alt="{{ $gallery->judul }}"
                         style="height: 200px; object-fit: cover;">
                  </a>
                  <div class="p-3">
                    <h5 class="fw-bold mb-2">{{ Str::limit($gallery->judul, 50) }}</h5>
                    @if($gallery->tanggal)
                      <small class="text-muted">
                        <i class="fas fa-calendar-alt me-1"></i>
                        {{ \Carbon\Carbon::parse($gallery->tanggal)->format('d M Y') }}
                      </small>
                    @endif
                  </div>
                </div>
              </div>
            @endforeach
          </div>

          {{-- Pagination --}}
          @if($galleries->hasPages())
            <div class="row mt-5">
              <div class="col-12">
                <nav aria-label="Related galleries pagination">
                  <ul class="pagination justify-content-center mb-0">
                    {{-- Previous Page Link --}}
                    @if($galleries->onFirstPage())
                      <li class="page-item disabled">
                        <span class="page-link">&laquo;</span>
                      </li>
                    @else
                      <li class="page-item">
                        <a class="page-link" href="{{ $galleries->previousPageUrl() }}" aria-label="Sebelumnya">
                          &laquo;
                        </a>
                      </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @php
                      $current = $galleries->currentPage();
                      $last = $galleries->lastPage();
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
                        <a class="page-link" href="{{ $galleries->url(1) }}">1</a>
                      </li>
                      @if($start > 2)
                        <li class="page-item disabled">
                          <span class="page-link">...</span>
                        </li>
                      @endif
                    @endif

                    @for($page = $start; $page <= $end; $page++)
                      @if($page == $galleries->currentPage())
                        <li class="page-item active">
                          <span class="page-link">{{ $page }}</span>
                        </li>
                      @else
                        <li class="page-item">
                          <a class="page-link" href="{{ $galleries->url($page) }}">{{ $page }}</a>
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
                        <a class="page-link" href="{{ $galleries->url($last) }}">{{ $last }}</a>
                      </li>
                    @endif

                    {{-- Next Page Link --}}
                    @if($galleries->hasMorePages())
                      <li class="page-item">
                        <a class="page-link" href="{{ $galleries->nextPageUrl() }}" aria-label="Selanjutnya">
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
                      Menampilkan {{ $galleries->firstItem() }} - {{ $galleries->lastItem() }} dari {{ $galleries->total() }} galeri
                    </small>
                  </div>
                </nav>
              </div>
            </div>
          @endif
          
        @else
          <!-- Empty State -->
          <div class="empty-state text-center py-5 my-5">
            <div class="empty-icon mb-4">
              <i class="fas fa-images fa-4x text-muted opacity-25"></i>
            </div>
            <h4 class="text-muted mb-3">Belum ada galeri tersedia</h4>
            @if(request('search'))
              <p class="text-muted mb-4">Tidak ditemukan galeri dengan kata kunci "{{ request('search') }}"</p>
            @endif
            <a href="{{ route('frontend.home') }}" class="btn btn-primary">
              <i class="fas fa-arrow-left me-2"></i> Kembali ke Beranda
            </a>
          </div>
        @endif
      </div>
    </div>
  </div>
</section>

@endsection

@push('styles')
<style>
    /* Header Styles */
    .content-header {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 2rem;
    }

    .search-form .input-group {
        border-radius: 50px;
        overflow: hidden;
    }

    .search-form input {
        border-right: none;
        border-color: #6b02b1;
    }

    .search-form input:focus {
        box-shadow: 0 0 0 3px rgba(107, 2, 177, 0.15);
        border-color: #6b02b1;
    }

    .search-form button {
        border-radius: 0 50px 50px 0;
        padding: 0.5rem 1.2rem;
        background-color: #6b02b1;
        border-color: #6b02b1;
    }

    .filter-tags .badge {
        padding: 0.5rem 0.8rem;
        font-weight: 500;
        background-color: #17a2b8;
    }

    .filter-tags .badge a {
        opacity: 0.8;
        transition: opacity 0.3s;
        color: white;
        text-decoration: none;
    }

    .filter-tags .badge a:hover {
        opacity: 1;
    }

    /* Gallery Card Styles */
    .related-gallery-card {
        transition: transform 0.3s ease;
        background-color: #fff;
        height: 100%;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        overflow: hidden;
    }

    .related-gallery-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 15px rgba(107, 2, 177, 0.15) !important;
        border-color: #6b02b1;
    }

    .related-gallery-card img {
        transition: transform 0.5s ease;
        height: 200px;
        width: 100%;
        object-fit: cover;
    }

    .related-gallery-card:hover img {
        transform: scale(1.05);
    }

    .related-gallery-card .p-3 {
        padding: 1rem;
    }

    .related-gallery-card h5 {
        color: #2e004f;
        font-size: 1.05rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        line-height: 1.3;
    }

    .related-gallery-card small {
        color: #6c757d;
        font-size: 0.85rem;
    }

    .text-purple {
        color: #6b02b1 !important;
    }

    /* Empty State */
    .empty-state {
        background: linear-gradient(135deg, #F8F9FA, #E9ECEF);
        border-radius: 15px;
        padding: 3rem 1rem;
    }

    .empty-icon {
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    /* Pagination Styles */
    .pagination {
        margin-bottom: 0;
        margin-top: 2rem;
    }

    .page-link {
        color: #6b02b1;
        border: 1px solid #dee2e6;
        margin: 0 3px;
        border-radius: 5px;
        transition: all 0.3s;
        padding: 0.5rem 0.75rem;
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
        .content-header {
            text-align: center;
        }
        
        .search-form {
            max-width: 300px;
            margin: 0 auto;
        }
        
        .related-gallery-card {
            margin-bottom: 1.5rem;
        }
        
        .page-link {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
            margin: 0 2px;
        }
    }
    
    @media (max-width: 576px) {
        .related-gallery-card img {
            height: 180px;
        }
        
        .related-gallery-card h5 {
            font-size: 1rem;
        }
        
        .pagination {
            flex-wrap: wrap;
        }
        
        .page-item {
            margin-bottom: 5px;
        }
    }

    /* Animation */
    .related-gallery-card {
        animation: fadeInUp 0.6s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Button Styles */
    .btn-primary {
        background-color: #6b02b1;
        border-color: #6b02b1;
    }

    .btn-primary:hover {
        background-color: #4d0283;
        border-color: #4d0283;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll for pagination
    document.querySelectorAll('.pagination a').forEach(link => {
        link.addEventListener('click', function(e) {
            if (this.getAttribute('href') && !this.getAttribute('href').startsWith('#')) {
                e.preventDefault();
                window.scrollTo({
                    top: document.querySelector('.content-header').offsetTop - 80,
                    behavior: 'smooth'
                });
                setTimeout(() => {
                    window.location.href = this.getAttribute('href');
                }, 300);
            }
        });
    });

    // Search form validation
    const searchForm = document.querySelector('.search-form');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            const input = this.querySelector('input[name="search"]');
            if (input.value.trim().length < 2 && input.value.trim() !== '') {
                e.preventDefault();
                alert('Masukkan minimal 2 karakter untuk pencarian');
                input.focus();
            }
        });
    }

    // Add click effect to gallery cards
    const galleryCards = document.querySelectorAll('.related-gallery-card');
    galleryCards.forEach(card => {
        card.addEventListener('click', function(e) {
            if (!e.target.closest('a')) {
                const link = this.querySelector('a[href]');
                if (link) {
                    window.location.href = link.href;
                }
            }
        });
    });
});
</script>
@endpush
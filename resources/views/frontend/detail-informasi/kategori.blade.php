@extends('layouts.frontend')

@section('title', 'Berita Kategori ' . $kategori->nama . ' - SMK Wisata Indonesia Jakarta')

@section('content')

{{-- === Hero Section === --}}
@include('frontend.partials.hero', [
  'title' => 'Berita Kategori: ' . $kategori->nama,
  'backgroundImage' => 'assets/img/foto-gedung.png',
  'height' => '200px'
])

<section class="detail-informasi-list py-5">
  <div class="container">
    <div class="row">
      <!-- Main Content Area -->
      <div class="col-lg-8">
        <!-- Header with Search -->
        <div class="content-header mb-5">
          <div class="row align-items-center">
            <div class="col-md-8">
              <h1 class="mb-0 text-purple fw-bold">Berita Kategori: <span class="badge bg-primary">{{ $kategori->nama }}</span></h1>
              <p class="text-muted mb-0 mt-2">
                @if($kategori->deskripsi)
                  {{ $kategori->deskripsi }}
                @else
                  Kumpulan berita dan informasi dalam kategori {{ $kategori->nama }}
                @endif
              </p>
            </div>
            <div class="col-md-4 mt-3 mt-md-0">
              <form action="{{ route('detail-informasi.kategori', $kategori->slug) }}" method="GET" class="search-form">
                <div class="input-group">
                  <input type="text" name="search" class="form-control border-primary" 
                         placeholder="Cari dalam kategori..." value="{{ request('search') }}">
                  <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </form>
            </div>
          </div>
          
          <!-- Filter Tags -->
          <div class="filter-tags mt-3">
            <span class="badge bg-primary me-2 mb-2">
              Kategori: {{ $kategori->nama }}
              <a href="{{ route('detail-informasi.index') }}" class="text-white ms-2">
                <i class="fas fa-times"></i>
              </a>
            </span>
            
            @if(request('search'))
              <span class="badge bg-info me-2 mb-2">
                Pencarian: "{{ request('search') }}"
                <a href="{{ route('detail-informasi.kategori', $kategori->slug) }}" class="text-white ms-2">
                  <i class="fas fa-times"></i>
                </a>
              </span>
            @endif
            
            <span class="badge bg-success me-2 mb-2">
              <i class="fas fa-newspaper me-1"></i> {{ $berita->total() }} Berita
            </span>
          </div>
        </div>

        @if($berita->count() > 0)
          <!-- News Grid -->
          <div class="news-grid">
            <div class="row g-4">
              @foreach($berita as $item)
                <div class="col-md-6">
                  <div class="news-card">
                    <!-- Image -->
                    <div class="news-image position-relative">
                      <img src="{{ $item->gambar_thumbnail ? asset('storage/' . $item->gambar_thumbnail) : ($item->gambar ? asset('storage/' . $item->gambar) : asset('assets/img/default-news.jpg')) }}" 
                           alt="{{ $item->judul }}"
                           class="img-fluid w-100"
                           style="height: 240px; object-fit: cover;">
                      
                      <!-- News Badge -->
                      <div class="position-absolute" style="top: 15px; right: 15px;">
                        <span class="news-badge" style="background-color: {{ $item->kategori ? ($item->kategori->warna ?? '#7c3aed') : '#7c3aed' }}">
                          {{ $item->kategori ? $item->kategori->nama : 'NEWS' }}
                        </span>
                      </div>
                    </div>

                    <!-- Content -->
                    <div class="news-content">
                      <h3 class="news-title">{{ Str::limit($item->judul, 70) }}</h3>
                      <p class="news-desc">{{ Str::limit(strip_tags($item->ringkasan ?: $item->konten), 150) }}</p>
                      <a href="{{ route('detail-informasi.show', $item->slug) }}" class="news-link">
                        Baca Selengkapnya >>
                      </a>
                    </div>

                    <!-- Footer -->
                    <div class="news-footer-border"></div>
                    <div class="news-footer">
                      <span class="footer-date">{{ \Carbon\Carbon::parse($item->published_at ?? $item->created_at)->translatedFormat('F d, Y') }}</span>
                      <span class="footer-separator">•</span>
                      <span class="footer-views">
                        <i class="fas fa-eye"></i> {{ $item->views ?? 0 }}
                      </span>
                      <span class="footer-separator">•</span>
                      <span class="footer-comments">
                        @php
                          $komentar_count = $item->komentar_count ?? 0;
                        @endphp
                        <i class="fas fa-comment"></i> {{ $komentar_count }}
                      </span>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
          
          <!-- Pagination -->
          @if($berita->hasPages())
            <div class="pagination-section mt-5 pt-4">
              <nav aria-label="Page navigation">
                {{ $berita->onEachSide(1)->links('vendor.pagination.custom') }}
              </nav>
            </div>
          @endif
          
        @else
          <!-- Empty State -->
          <div class="empty-state text-center py-5 my-5">
            <div class="empty-icon mb-4">
              <i class="fas fa-newspaper fa-4x text-muted opacity-25"></i>
            </div>
            <h4 class="text-muted mb-3">Belum ada berita dalam kategori ini</h4>
            @if(request('search'))
              <p class="text-muted mb-4">Tidak ditemukan berita dengan kata kunci "{{ request('search') }}"</p>
            @endif
            <a href="{{ route('detail-informasi.index') }}" class="btn btn-primary">
              <i class="fas fa-arrow-left me-2"></i> Kembali ke Semua Berita
            </a>
          </div>
        @endif
      </div>
      
      <!-- Sidebar -->
      <div class="col-lg-4">
        <!-- Category Info Widget -->
        <div class="sidebar-widget card border-0 shadow-sm mb-4">
          <div class="card-header bg-gradient-primary text-white">
            <h5 class="mb-0 d-flex align-items-center">
              <i class="fas fa-info-circle me-2"></i> Tentang Kategori
            </h5>
          </div>
          <div class="card-body">
            <div class="d-flex align-items-center mb-3">
              @if($kategori->icon)
                <div class="me-3">
                  <i class="{{ $kategori->icon }} fa-2x text-primary"></i>
                </div>
              @endif
              <div>
                <h6 class="text-primary mb-1">{{ $kategori->nama }}</h6>
                @if($kategori->deskripsi)
                  <p class="small text-muted mb-0">{{ $kategori->deskripsi }}</p>
                @endif
              </div>
            </div>
            
            <div class="category-stats">
              <div class="d-flex justify-content-between mb-2">
                <span class="text-muted small">Total Berita</span>
                <span class="fw-bold">{{ $berita->total() }}</span>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span class="text-muted small">Dilihat Total</span>
                <span class="fw-bold">{{ \App\Models\Berita::where('kategori_id', $kategori->id)->where('is_published', true)->sum('views') }}</span>
              </div>
              <div class="d-flex justify-content-between">
                <span class="text-muted small">Berita Terbaru</span>
                <span class="fw-bold">
                  @if($berita->count() > 0)
                    {{ \Carbon\Carbon::parse($berita->first()->published_at ?? $berita->first()->created_at)->translatedFormat('d M Y') }}
                  @else
                    -
                  @endif
                </span>
              </div>
            </div>
          </div>
        </div>
        
        <!-- All Categories Widget -->
        <div class="sidebar-widget card border-0 shadow-sm mb-4">
          <div class="card-header bg-gradient-success text-white">
            <h5 class="mb-0 d-flex align-items-center">
              <i class="fas fa-tags me-2"></i> Semua Kategori
            </h5>
          </div>
          <div class="card-body p-0">
            <div class="list-group list-group-flush">
              <a href="{{ route('detail-informasi.index') }}" 
                 class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                Semua Kategori
                <span class="badge bg-primary rounded-pill">{{ \App\Models\Berita::where('is_published', true)->count() }}</span>
              </a>
              @foreach(\App\Models\KategoriBerita::withCount(['berita' => function($query) {
                  $query->where('is_published', true);
              }])->get() as $kat)
                <a href="{{ route('detail-informasi.kategori', $kat->slug) }}" 
                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ $kat->id == $kategori->id ? 'active' : '' }}">
                  {{ $kat->nama }}
                  <span class="badge bg-primary rounded-pill">{{ $kat->berita_count }}</span>
                </a>
              @endforeach
            </div>
          </div>
        </div>
        
        <!-- Popular News Widget -->
        <div class="sidebar-widget card border-0 shadow-sm mb-4">
          <div class="card-header bg-gradient-info text-white">
            <h5 class="mb-0 d-flex align-items-center">
              <i class="fas fa-fire me-2"></i> Berita Populer
            </h5>
          </div>
          <div class="card-body">
            @php
              $popularBerita = \App\Models\Berita::where('is_published', true)
                ->whereNull('archived_at')
                ->orderBy('views', 'desc')
                ->take(5)
                ->get();
            @endphp
            
            @if($popularBerita->count() > 0)
              @foreach($popularBerita as $item)
                <div class="popular-news-item mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                  <div class="d-flex align-items-start">
                    <div class="popular-thumb me-3">
                      <img src="{{ $item->gambar_thumbnail ? asset('storage/' . $item->gambar_thumbnail) : ($item->gambar ? asset('storage/' . $item->gambar) : asset('assets/img/default-news.jpg')) }}" 
                           alt="{{ $item->judul }}"
                           class="img-fluid rounded"
                           style="width: 70px; height: 70px; object-fit: cover;">
                    </div>
                    <div class="popular-content flex-grow-1">
                      <h6 class="mb-1">
                        <a href="{{ route('detail-informasi.show', $item->slug) }}" 
                           class="text-decoration-none text-dark">
                          {{ Str::limit($item->judul, 50) }}
                        </a>
                      </h6>
                      <div class="d-flex align-items-center text-muted small">
                        <div class="me-3">
                          <i class="fas fa-eye me-1"></i> {{ $item->views }}
                        </div>
                        <div>
                          <i class="fas fa-calendar me-1"></i> 
                          {{ \Carbon\Carbon::parse($item->created_at)->format('d M') }}
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach
            @else
              <p class="text-muted small mb-0">Belum ada berita populer</p>
            @endif
          </div>
        </div>
        
        <!-- Navigation Widget -->
        <div class="sidebar-widget card border-0 shadow-sm">
          <div class="card-header bg-gradient-warning text-white">
            <h5 class="mb-0 d-flex align-items-center">
              <i class="fas fa-arrow-left me-2"></i> Navigasi
            </h5>
          </div>
          <div class="card-body">
            <a href="{{ route('detail-informasi.index') }}" class="btn btn-outline-primary w-100 mb-2">
              <i class="fas fa-list me-2"></i> Semua Berita
            </a>
            <a href="{{ url('/') }}" class="btn btn-outline-secondary w-100">
              <i class="fas fa-home me-2"></i> Kembali ke Home
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection

@push('styles')
<style>
:root {
  --primary-color: #6B02B1;
  --primary-dark: #4d0283;
  --secondary-color: #8A2BE2;
  --success-color: #28a745;
  --info-color: #17a2b8;
  --warning-color: #ffc107;
  --light-purple: #F3E8FF;
  --border-gray: #f0f0f0;
}

.text-white {
  color: #fff !important;
}

/* === NEW CARD STYLES === */
.news-card {
  background: #fff;
  border-radius: 14px;
  overflow: hidden;
  box-shadow: 0 10px 30px rgba(0,0,0,0.08);
  transition: transform 0.3s ease;
  max-width: 100%;
  height: 100%;
  display: flex;
  flex-direction: column;
}

.news-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 15px 35px rgba(0,0,0,0.15);
}

/* IMAGE */
.news-image {
  position: relative;
  overflow: hidden;
}

.news-image img {
  width: 100%;
  height: 240px;
  object-fit: cover;
  transition: transform 0.6s ease;
}

.news-card:hover .news-image img {
  transform: scale(1.05);
}

/* BADGE - POSISI ATAS KANAN SEPERTI GAMBAR KEDUA */
.news-badge {
  display: inline-block;
  background: #7c3aed;
  color: #fff;
  padding: 8px 16px;
  border-radius: 0 0 0 12px;
  font-size: 12px;
  font-weight: 600;
  z-index: 2;
  text-transform: uppercase;
  letter-spacing: 1px;
  box-shadow: 0 4px 6px rgba(0,0,0,0.15);
  position: relative;
  min-width: 80px;
  text-align: center;
}

/* Efek sudut terpotong seperti pada gambar kedua */
.news-badge::before {
  content: '';
  position: absolute;
  top: 0;
  right: -8px;
  width: 0;
  height: 0;
  border-style: solid;
  border-width: 0 0 8px 8px;
  border-color: transparent transparent #5a2bc9 transparent;
  filter: brightness(0.8);
}

/* CONTENT */
.news-content {
  padding: 22px;
  flex-grow: 1;
  display: flex;
  flex-direction: column;
}

.news-title {
  font-size: 18px;
  font-weight: 800;
  line-height: 1.4;
  margin-bottom: 12px;
  color: #000;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.news-desc {
  font-size: 14px;
  color: #555;
  line-height: 1.6;
  margin-bottom: 14px;
  flex-grow: 1;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

/* LINK */
.news-link {
  font-size: 14px;
  font-weight: 600;
  color: #000;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  transition: all 0.3s;
}

.news-link:hover {
  text-decoration: none;
  color: var(--primary-color);
  transform: translateX(5px);
}

/* FOOTER BORDER */
.news-footer-border {
  border-top: 1px solid var(--border-gray);
  margin: 0 22px;
  opacity: 0.8;
}

/* FOOTER */
.news-footer {
  padding: 12px 22px;
  font-size: 11px;
  color: #888;
  background: #f9f9f9;
  display: flex;
  align-items: center;
  justify-content: flex-start;
  flex-wrap: nowrap;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  gap: 8px;
}

.footer-date,
.footer-views,
.footer-comments {
  display: inline-flex;
  align-items: center;
  gap: 4px;
}

.footer-separator {
  color: #ccc;
  font-size: 10px;
}

.news-footer i {
  font-size: 10px;
  color: #aaa;
}

/* === CONTENT HEADER === */
.content-header {
  background: white;
  padding: 1.5rem;
  border-radius: 12px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.search-form .input-group {
  border-radius: 50px;
  overflow: hidden;
}

.search-form input {
  border-right: none;
}

.search-form input:focus {
  box-shadow: 0 0 0 3px rgba(107, 2, 177, 0.15);
  border-color: var(--primary-color);
}

.search-form button {
  border-radius: 0 50px 50px 0;
  padding: 0.5rem 1.2rem;
}

.filter-tags .badge {
  padding: 0.5rem 0.8rem;
  font-weight: 500;
}

.filter-tags .badge a {
  opacity: 0.8;
  transition: opacity 0.3s;
}

.filter-tags .badge a:hover {
  opacity: 1;
  text-decoration: none;
}

/* === CATEGORY STATS === */
.category-stats {
  background: #f8f9fa;
  border-radius: 8px;
  padding: 1rem;
  margin-top: 1rem;
}

.category-stats .fw-bold {
  color: var(--primary-color);
}

/* === EMPTY STATE === */
.empty-state {
  background: linear-gradient(135deg, #F8F9FA, #E9ECEF);
  border-radius: 15px;
}

.empty-icon {
  animation: float 3s ease-in-out infinite;
}

@keyframes float {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-10px); }
}

/* === SIDEBAR WIDGETS === */
.sidebar-widget {
  border-radius: 12px;
  overflow: hidden;
}

.bg-gradient-primary {
  background: linear-gradient(135deg, #6B02B1, #8A2BE2) !important;
}

.bg-gradient-success {
  background: linear-gradient(135deg, #28a745, #20c997) !important;
}

.bg-gradient-info {
  background: linear-gradient(135deg, #17a2b8, #0dcaf0) !important;
}

.bg-gradient-warning {
  background: linear-gradient(135deg, #ffc107, #ffca2c) !important;
}

.list-group-item {
  border: none;
  padding: 0.8rem 1.25rem;
  transition: all 0.3s;
}

.list-group-item:hover {
  background-color: var(--light-purple);
  padding-left: 1.5rem;
}

.list-group-item.active {
  background-color: var(--primary-color);
  border-color: var(--primary-color);
  color: white;
}

.list-group-item.active .badge {
  background-color: white !important;
  color: var(--primary-color) !important;
}

.popular-news-item .popular-thumb img,
.recent-news-item .recent-thumb img {
  transition: transform 0.3s;
}

.popular-news-item:hover .popular-thumb img,
.recent-news-item:hover .recent-thumb img {
  transform: scale(1.1);
}

.popular-content h6,
.recent-content h6 {
  transition: color 0.3s;
}

.popular-news-item:hover .popular-content h6 a,
.recent-news-item:hover .recent-content h6 a {
  color: var(--primary-color) !important;
}

/* === PAGINATION === */
.pagination-section {
  border-top: 2px solid #f1f3f4;
}

/* === RESPONSIVE === */
@media (max-width: 768px) {
  .content-header {
    text-align: center;
  }
  
  .search-form {
    max-width: 300px;
    margin: 0 auto;
  }
  
  .news-grid .col-md-6 {
    margin-bottom: 1.5rem;
  }
  
  .news-card {
    margin-bottom: 1rem;
  }
  
  .news-title {
    font-size: 16px;
  }
  
  .news-desc {
    font-size: 13px;
  }
  
  .news-link {
    font-size: 13px;
  }
  
  .news-footer {
    font-size: 10px;
    padding: 10px 15px;
  }
  
  .news-footer-border {
    margin: 0 15px;
  }
  
  .news-badge {
    padding: 6px 12px;
    font-size: 10px;
    min-width: 60px;
  }
  
  .news-badge::before {
    border-width: 0 0 6px 6px;
    right: -6px;
  }
  
  .category-stats {
    padding: 0.75rem;
  }
}

/* === ANIMATIONS === */
.news-card, .sidebar-widget {
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

/* === SCROLLBAR STYLING === */
.sidebar-widget .card-body {
  max-height: 400px;
  overflow-y: auto;
}

.sidebar-widget .card-body::-webkit-scrollbar {
  width: 6px;
}

.sidebar-widget .card-body::-webkit-scrollbar-track {
  background: #f1f3f4;
  border-radius: 10px;
}

.sidebar-widget .card-body::-webkit-scrollbar-thumb {
  background: var(--primary-color);
  border-radius: 10px;
}

/* === CUSTOM PAGINATION STYLING === */
.pagination {
  display: flex;
  justify-content: center;
  padding-left: 0;
  list-style: none;
}

.pagination .page-item .page-link {
  color: var(--primary-color);
  background-color: #fff;
  border: 1px solid #dee2e6;
  padding: 0.5rem 0.75rem;
  margin: 0 0.25rem;
  border-radius: 8px;
  transition: all 0.3s;
}

.pagination .page-item.active .page-link {
  background-color: var(--primary-color);
  border-color: var(--primary-color);
  color: white;
}

.pagination .page-item .page-link:hover {
  background-color: var(--light-purple);
  border-color: var(--primary-color);
}

.pagination .page-item.disabled .page-link {
  color: #6c757d;
  pointer-events: none;
  background-color: #fff;
  border-color: #dee2e6;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Add hover effect to news cards
  const newsCards = document.querySelectorAll('.news-card');
  newsCards.forEach(card => {
    card.addEventListener('mouseenter', function() {
      this.style.zIndex = '10';
    });
    
    card.addEventListener('mouseleave', function() {
      this.style.zIndex = '1';
    });
  });
  
  // Search form enhancement
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
  
  // News card click enhancement
  document.querySelectorAll('.news-link').forEach(link => {
    link.addEventListener('click', function(e) {
      // Add a small animation before navigation
      const card = this.closest('.news-card');
      if (card) {
        card.style.transform = 'scale(0.98)';
        setTimeout(() => {
          card.style.transform = '';
        }, 200);
      }
    });
  });
  
  // Category badge color consistency
  const categoryBadges = document.querySelectorAll('.news-badge');
  categoryBadges.forEach(badge => {
    const categoryName = badge.textContent.trim();
    if (categoryName === '{{ $kategori->nama }}') {
      badge.style.backgroundColor = '{{ $kategori->warna ?? "#7c3aed" }}';
    }
  });
});
</script>
@endpush
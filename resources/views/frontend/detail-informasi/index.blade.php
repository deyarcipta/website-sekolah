@extends('layouts.frontend')

@section('title', 'Detail Informasi - SMK Wisata Indonesia Jakarta')

@section('content')

{{-- === Hero Section === --}}
@include('frontend.partials.hero', [
  'title' => 'Detail Informasi',
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
              <h1 class="mb-0 text-purple fw-bold">Berita Terbaru</h1>
              <p class="text-muted mb-0 mt-2">Informasi terkini seputar kegiatan dan perkembangan SMK Wisata Indonesia Jakarta</p>
            </div>
            <div class="col-md-4 mt-3 mt-md-0">
              <form action="{{ route('detail-informasi.index') }}" method="GET" class="search-form">
                <div class="input-group">
                  <input type="text" name="search" class="form-control border-primary" 
                         placeholder="Cari berita..." value="{{ request('search') }}">
                  <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </form>
            </div>
          </div>
          
          <!-- Category Filter -->
          @if(request('kategori') || request('search'))
            <div class="filter-tags mt-3">
              @if(request('kategori'))
                <span class="badge bg-primary me-2 mb-2">
                  Kategori: {{ $kategori->where('slug', request('kategori'))->first()->nama ?? request('kategori') }}
                  <a href="{{ route('detail-informasi.index') }}" class="text-white ms-2">
                    <i class="fas fa-times"></i>
                  </a>
                </span>
              @endif
              @if(request('search'))
                <span class="badge bg-info me-2 mb-2">
                  Pencarian: "{{ request('search') }}"
                  <a href="{{ route('detail-informasi.index') }}" class="text-white ms-2">
                    <i class="fas fa-times"></i>
                  </a>
                </span>
              @endif
            </div>
          @endif
        </div>

        @if($berita->count() > 0)
          <!-- News Grid -->
          <div class="news-grid">
            <div class="row g-4">
              @foreach($berita as $item)
                <div class="col-md-6">
                  <article class="news-card card border-0 shadow-sm h-100 overflow-hidden">
                    <!-- Featured Badge -->
                    @if($item->is_featured)
                      <div class="featured-badge">
                        <i class="fas fa-star me-1"></i> Featured
                      </div>
                    @endif
                    
                    <!-- Image with Overlay -->
                    <div class="news-image position-relative">
                      <img src="{{ $item->gambar_thumbnail ? asset('storage/' . $item->gambar_thumbnail) : ($item->gambar ? asset('storage/' . $item->gambar) : asset('assets/img/default-news.jpg')) }}" 
                           class="img-fluid w-100" 
                           alt="{{ $item->judul }}"
                           style="height: 220px; object-fit: cover;">
                      
                      <!-- Category Badge -->
                      @if($item->kategori)
                        <span class="category-badge" style="background-color: {{ $item->kategori->warna ?? '#6B02B1' }};">
                          {{ $item->kategori->nama }}
                        </span>
                      @endif
                      
                      <!-- Date Overlay -->
                      <div class="date-overlay">
                        <div class="date-day">{{ \Carbon\Carbon::parse($item->published_at)->format('d') }}</div>
                        <div class="date-month">{{ \Carbon\Carbon::parse($item->published_at)->format('M') }}</div>
                      </div>
                    </div>
                    
                    <!-- Card Content -->
                    <div class="card-body d-flex flex-column">
                      <!-- Meta Info -->
                      <div class="news-meta d-flex align-items-center mb-2">
                        <div class="d-flex align-items-center me-3">
                          <i class="fas fa-user-circle me-1 text-primary"></i>
                          <small class="text-muted">{{ $item->penulis ?? 'Admin SMK WI' }}</small>
                        </div>
                        <div class="d-flex align-items-center">
                          <i class="fas fa-eye me-1 text-primary"></i>
                          <small class="text-muted">{{ $item->views }} dilihat</small>
                        </div>
                      </div>
                      
                      <!-- Title -->
                      <h3 class="news-title mb-3">
                        <a href="{{ route('detail-informasi.show', $item->slug) }}" 
                           class="text-decoration-none text-dark">
                          {{ Str::limit($item->judul, 65) }}
                        </a>
                      </h3>
                      
                      <!-- Excerpt -->
                      <p class="news-excerpt text-muted mb-4 flex-grow-1">
                        {{ Str::limit(strip_tags($item->ringkasan ?: $item->konten), 130) }}
                      </p>
                      
                      <!-- Footer -->
                      <div class="news-footer d-flex justify-content-between align-items-center mt-auto">
                        <!-- Tanggal Publikasi -->
                        <div class="publish-date">
                          <small class="text-muted">
                            <i class="fas fa-calendar me-1"></i>
                            {{ \Carbon\Carbon::parse($item->published_at)->translatedFormat('d F Y') }}
                          </small>
                        </div>
                        
                        <!-- Read More Button -->
                        <a href="{{ route('detail-informasi.show', $item->slug) }}" 
                           class="read-more-btn">
                          Baca <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                      </div>
                    </div>
                  </article>
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
            <h4 class="text-muted mb-3">Belum ada berita tersedia</h4>
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
        <!-- Category Widget -->
        <div class="sidebar-widget card border-0 shadow-sm mb-4">
          <div class="card-header bg-gradient-primary text-white">
            <h5 class="mb-0 d-flex align-items-center">
              <i class="fas fa-tags me-2"></i> Kategori Berita
            </h5>
          </div>
          <div class="card-body p-0">
            <div class="list-group list-group-flush">
              <a href="{{ route('detail-informasi.index') }}" 
                 class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ !request('kategori') ? 'active' : '' }}">
                Semua Kategori
                <span class="badge bg-primary rounded-pill">{{ \App\Models\Berita::where('is_published', true)->count() }}</span>
              </a>
              @foreach($kategori as $kat)
                <a href="{{ route('detail-informasi.kategori', $kat->slug) }}" 
                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ request('kategori') == $kat->slug ? 'active' : '' }}">
                  {{ $kat->nama }}
                  <span class="badge bg-primary rounded-pill">{{ $kat->berita()->count() }}</span>
                </a>
              @endforeach
            </div>
          </div>
        </div>
        
        <!-- Popular News Widget -->
        <div class="sidebar-widget card border-0 shadow-sm mb-4">
          <div class="card-header bg-gradient-success text-white">
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
          </div>
        </div>
        
        <!-- Recent News Widget -->
        <div class="sidebar-widget card border-0 shadow-sm mb-4">
          <div class="card-header bg-gradient-info text-white">
            <h5 class="mb-0 d-flex align-items-center">
              <i class="fas fa-clock me-2"></i> Berita Terbaru
            </h5>
          </div>
          <div class="card-body">
            @php
              $recentBerita = \App\Models\Berita::where('is_published', true)
                ->whereNull('archived_at')
                ->orderBy('published_at', 'desc')
                ->take(5)
                ->get();
            @endphp
            
            @foreach($recentBerita as $item)
              <div class="recent-news-item mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                <div class="d-flex align-items-start">
                  <div class="recent-thumb me-3">
                    <img src="{{ $item->gambar_thumbnail ? asset('storage/' . $item->gambar_thumbnail) : ($item->gambar ? asset('storage/' . $item->gambar) : asset('assets/img/default-news.jpg')) }}" 
                         alt="{{ $item->judul }}"
                         class="img-fluid rounded"
                         style="width: 70px; height: 70px; object-fit: cover;">
                  </div>
                  <div class="recent-content flex-grow-1">
                    <h6 class="mb-1">
                      <a href="{{ route('detail-informasi.show', $item->slug) }}" 
                         class="text-decoration-none text-dark">
                        {{ Str::limit($item->judul, 50) }}
                      </a>
                    </h6>
                    <div class="d-flex align-items-center text-muted small">
                      <div>
                        <i class="fas fa-calendar me-1"></i> 
                        {{ \Carbon\Carbon::parse($item->published_at)->format('d M') }}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
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

/* === NEWS CARD === */
.news-card {
  border-radius: 12px;
  overflow: hidden;
  transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  background: white;
}

.news-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important;
}

.featured-badge {
  position: absolute;
  top: 15px;
  left: 15px;
  background: linear-gradient(135deg, #FFD700, #FFA500);
  color: #000;
  padding: 0.4rem 0.8rem;
  border-radius: 50px;
  font-size: 0.75rem;
  font-weight: 600;
  z-index: 2;
}

.news-image {
  overflow: hidden;
  position: relative;
}

.news-image img {
  transition: transform 0.6s ease;
  width: 100%;
}

.news-card:hover .news-image img {
  transform: scale(1.05);
}

.category-badge {
  position: absolute;
  top: 15px;
  right: 15px;
  background-color: var(--primary-color);
  color: white;
  padding: 0.4rem 0.8rem;
  border-radius: 50px;
  font-size: 0.75rem;
  font-weight: 600;
  z-index: 2;
}

.date-overlay {
  position: absolute;
  bottom: 0;
  left: 0;
  background: rgba(107, 2, 177, 0.9);
  color: white;
  padding: 0.5rem 0.8rem;
  text-align: center;
  min-width: 60px;
}

.date-day {
  font-size: 1.5rem;
  font-weight: 700;
  line-height: 1;
}

.date-month {
  font-size: 0.8rem;
  text-transform: uppercase;
  opacity: 0.9;
}

.news-meta {
  font-size: 0.85rem;
}

.news-title {
  font-size: 1.1rem;
  font-weight: 700;
  line-height: 1.4;
  transition: color 0.3s;
}

.news-card:hover .news-title a {
  color: var(--primary-color) !important;
}

.news-excerpt {
  font-size: 0.95rem;
  line-height: 1.6;
}

.publish-date small {
  font-size: 0.85rem;
}

.read-more-btn {
  display: inline-flex;
  align-items: center;
  color: var(--primary-color);
  text-decoration: none;
  font-weight: 600;
  font-size: 0.9rem;
  transition: all 0.3s;
}

.read-more-btn:hover {
  color: var(--primary-dark);
  transform: translateX(5px);
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
  background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)) !important;
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

/* === NEWSLETTER FORM === */
.newsletter-form input {
  border-radius: 50px;
  padding: 0.6rem 1rem;
}

.newsletter-form button {
  border-radius: 50px;
  font-weight: 600;
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
  
  .date-overlay {
    min-width: 50px;
    padding: 0.3rem 0.5rem;
  }
  
  .date-day {
    font-size: 1.2rem;
  }
  
  .news-title {
    font-size: 1rem;
  }
  
  .news-excerpt {
    font-size: 0.9rem;
  }
  
  .news-footer {
    flex-direction: column;
    align-items: flex-start !important;
    gap: 0.5rem;
  }
  
  .read-more-btn {
    align-self: flex-end;
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
  
  // Newsletter form submission
  const newsletterForm = document.querySelector('.newsletter-form');
  if (newsletterForm) {
    newsletterForm.addEventListener('submit', function(e) {
      e.preventDefault();
      const email = this.querySelector('input[type="email"]').value;
      
      // Simulate subscription
      const button = this.querySelector('button');
      const originalText = button.innerHTML;
      
      button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
      button.disabled = true;
      
      setTimeout(() => {
        button.innerHTML = '<i class="fas fa-check me-2"></i>Terdaftar!';
        button.classList.remove('btn-warning');
        button.classList.add('btn-success');
        
        setTimeout(() => {
          button.innerHTML = originalText;
          button.classList.remove('btn-success');
          button.classList.add('btn-warning');
          button.disabled = false;
          this.reset();
        }, 2000);
      }, 1500);
    });
  }
  
  // Lazy load images
  const images = document.querySelectorAll('img');
  const imageObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const img = entry.target;
        img.src = img.dataset.src || img.src;
        img.classList.add('loaded');
        observer.unobserve(img);
      }
    });
  });
  
  images.forEach(img => {
    if (img.complete) return;
    imageObserver.observe(img);
  });
  
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
});
</script>
@endpush

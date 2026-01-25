@extends('layouts.frontend')

@section('title', $berita->meta_title ?: $berita->judul . ' - SMK Wisata Indonesia Jakarta')

@section('meta')
    @if($berita->meta_description)
        <meta name="description" content="{{ $berita->meta_description }}">
    @endif
    @if($berita->meta_keywords)
        <meta name="keywords" content="{{ $berita->meta_keywords }}">
    @endif
    <meta property="og:title" content="{{ $berita->judul }}">
    <meta property="og:description" content="{{ $berita->meta_description ?: Str::limit(strip_tags($berita->ringkasan ?: $berita->konten), 160) }}">
    <meta property="og:image" content="{{ $berita->gambar ? asset('storage/' . $berita->gambar) : asset('assets/img/default-news.jpg') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="article">
@endsection

@section('content')

{{-- === Hero Section === --}}
@include('frontend.partials.hero', [
  'title' => 'Detail Informasi',
  'backgroundImage' => $berita->gambar ? asset('storage/' . $berita->gambar) : 'assets/img/foto-gedung.png',
  'height' => '200px'
])

<section class="detail-informasi py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-9">

        {{-- === Gambar Utama === --}}
        @if($berita->gambar)
        <div class="detail-image position-relative mb-4">
          <img src="{{ asset('storage/' . $berita->gambar) }}" 
               alt="{{ $berita->judul }}" 
               class="img-fluid rounded-3 shadow-sm"
               style="width: 100%; height: 420px; object-fit: cover;">
          
          {{-- Badge Kategori --}}
          @if($berita->kategori)
          <span class="badge-news" style="background-color: {{ $berita->kategori->warna ?? '#6B02B1' }};">
            {{ strtoupper($berita->kategori->nama) }}
          </span>
          @endif
          
          {{-- Badge Featured/Headline --}}
          @if($berita->is_featured)
          <span class="badge-news" style="background-color: #FFC107; color: #000; top: 50px; right: 15px;">
            <i class="fas fa-star me-1"></i> FEATURED
          </span>
          @endif
          
          @if($berita->is_headline)
          <span class="badge-news" style="background-color: #DC3545; top: 50px; right: 15px;">
            <i class="fas fa-bullhorn me-1"></i> HEADLINE
          </span>
          @endif
        </div>
        @endif

        {{-- === Konten Utama === --}}
        <div class="detail-content mt-4">
          <h1 class="fw-bold text-purple mb-3">
            {{ $berita->judul }}
          </h1>

          <div class="text-muted mb-4">
            <small>
              <i class="fas fa-calendar-alt me-1"></i>
              {{ \Carbon\Carbon::parse($berita->tanggal_publish)->translatedFormat('d F Y') }}
              <i class="fas fa-user ms-3 me-1"></i>
              {{ $berita->penulis ?? 'Admin SMK WI' }}
              @if($berita->sumber)
                <i class="fas fa-newspaper ms-3 me-1"></i>
                Sumber: {{ $berita->sumber }}
              @endif
              <i class="fas fa-eye ms-3 me-1"></i>
              {{ $berita->views }} dilihat
              <i class="fas fa-clock ms-3 me-1"></i>
              {{ \Carbon\Carbon::parse($berita->created_at)->diffForHumans() }}
            </small>
          </div>

          {{-- Ringkasan --}}
          {{-- @if($berita->ringkasan)
          <div class="alert alert-info bg-light border-info mb-4">
            <div class="d-flex">
              <i class="fas fa-info-circle fa-2x text-info me-3 mt-1"></i>
              <div>
                <h5 class="text-info mb-2">Ringkasan Berita</h5>
                <p class="mb-0">{{ $berita->ringkasan }}</p>
              </div>
            </div>
          </div>
          @endif --}}

          {{-- Konten Berita --}}
          <div class="berita-konten mb-5">
            {!! $berita->konten !!}
          </div>

          {{-- Share Buttons --}}
          <div class="share-section border-top border-bottom py-4 mb-4">
            <div class="d-flex flex-wrap align-items-center">
              <h6 class="me-3 mb-2 mb-md-0">Bagikan:</h6>
              <div class="d-flex flex-wrap gap-2">
                <!-- Facebook -->
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                   target="_blank" 
                   class="btn btn-sm btn-outline-primary d-flex align-items-center">
                  <i class="fab fa-facebook-f me-1"></i> Facebook
                </a>
                
                <!-- Twitter -->
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($berita->judul) }}"
                   target="_blank"
                   class="btn btn-sm btn-outline-info d-flex align-items-center">
                  <i class="fab fa-twitter me-1"></i> Twitter
                </a>
                
                <!-- WhatsApp -->
                <a href="https://wa.me/?text={{ urlencode($berita->judul . ' ' . url()->current()) }}"
                   target="_blank"
                   class="btn btn-sm btn-outline-success d-flex align-items-center">
                  <i class="fab fa-whatsapp me-1"></i> WhatsApp
                </a>
                
                <!-- LinkedIn -->
                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ urlencode($berita->judul) }}"
                   target="_blank"
                   class="btn btn-sm btn-outline-primary d-flex align-items-center">
                  <i class="fab fa-linkedin-in me-1"></i> LinkedIn
                </a>
              </div>
            </div>
          </div>

          {{-- Navigation --}}
          <div class="navigation-section mt-5 pt-4 border-top">
            <div class="row align-items-center">
              {{-- Berita Sebelumnya --}}
              <div class="col-md-4 mb-3 mb-md-0">
                @if($previous)
                <a href="{{ route('detail-informasi.show', $previous->slug) }}" 
                   class="nav-previous d-flex align-items-center text-decoration-none">
                  <div class="nav-icon me-3">
                    <i class="fas fa-arrow-left"></i>
                  </div>
                  <div class="nav-content">
                    <div class="text-muted small">Berita Sebelumnya</div>
                    <div class="fw-bold text-dark">{{ Str::limit($previous->judul, 40) }}</div>
                  </div>
                </a>
                @endif
              </div>
              
              {{-- Kembali ke Daftar Berita (Tengah) --}}
              <div class="col-md-4 mb-3 mb-md-0 text-center">
                <a href="{{ route('detail-informasi.index') }}" class="btn-back">
                  <i class="fas fa-newspaper me-2"></i> Kembali ke Daftar Berita
                </a>
              </div>
              
              {{-- Berita Selanjutnya --}}
              <div class="col-md-4 text-md-end">
                @if($next)
                <a href="{{ route('detail-informasi.show', $next->slug) }}" 
                   class="nav-next d-flex align-items-center text-decoration-none justify-content-md-end">
                  <div class="nav-content text-end me-3">
                    <div class="text-muted small">Berita Selanjutnya</div>
                    <div class="fw-bold text-dark">{{ Str::limit($next->judul, 40) }}</div>
                  </div>
                  <div class="nav-icon">
                    <i class="fas fa-arrow-right"></i>
                  </div>
                </a>
                @endif
              </div>
            </div>
          </div>
        </div>

        {{-- === Garis Pembatas === --}}
        <hr class="my-5">

        {{-- === Berita Lainnya === --}}
        @if($relatedBerita->count() > 0)
        <div class="related-section mt-5">
          <h4 class="fw-bold text-purple mb-5 text-center">Berita Lainnya</h4>

          <div class="row gy-5 gx-4">
            @foreach($relatedBerita as $item)
            <div class="col-md-4">
              <div class="news-card">
                <div class="news-image position-relative">
                  <img src="{{ $item->gambar_thumbnail ? asset('storage/' . $item->gambar_thumbnail) : ($item->gambar ? asset('storage/' . $item->gambar) : asset('assets/img/default-news.jpg')) }}" 
                       alt="{{ $item->judul }}" 
                       class="img-fluid"
                       style="width: 100%; height: 220px; object-fit: cover;">
                  
                  @if($item->kategori)
                  <span class="badge-news" style="background-color: {{ $item->kategori->warna ?? '#6B02B1' }};">
                    {{ strtoupper($item->kategori->nama) }}
                  </span>
                  @endif
                </div>
                <div class="news-content">
                  <h5 class="fw-bold mt-2" style="font-size: 16px;">
                    {{ Str::limit($item->judul, 60) }}
                  </h5>
                  <p style="font-size: 14.5px;">
                    {{ Str::limit(strip_tags($item->ringkasan ?: $item->konten), 80) }}
                  </p>
                  <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                      <i class="fas fa-calendar me-1"></i>
                      {{ \Carbon\Carbon::parse($item->tanggal_publish)->format('d/m/Y') }}
                    </small>
                    <a href="{{ route('detail-informasi.show', $item->slug) }}" class="read-more">
                      Baca <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
        @endif

      </div>
    </div>
  </div>
</section>

@endsection

@push('styles')
<style>
/* === DETAIL INFORMASI === */
.detail-image img {
  width: 100%;
  height: 420px;
  object-fit: cover;
  border-radius: 12px;
}

.badge-news {
  position: absolute;
  top: 15px;
  right: 15px;
  background-color: #6B02B1;
  color: #fff;
  padding: 6px 12px;
  font-size: 13px;
  border-radius: 50px;
  font-weight: bold;
  z-index: 10;
}

/* === KONTEN BERITA === */
.berita-konten {
  font-size: 16px;
  line-height: 1.8;
  color: #333;
}

.berita-konten img {
  max-width: 100%;
  height: auto;
  border-radius: 8px;
  margin: 20px 0;
}

.berita-konten h1,
.berita-konten h2,
.berita-konten h3,
.berita-konten h4,
.berita-konten h5,
.berita-konten h6 {
  color: #6B02B1;
  margin-top: 1.5rem;
  margin-bottom: 1rem;
  font-weight: 600;
}

.berita-konten p {
  margin-bottom: 1.2rem;
  text-align: justify;
}

.berita-konten ul,
.berita-konten ol {
  margin-bottom: 1.2rem;
  padding-left: 2rem;
}

.berita-konten blockquote {
  border-left: 4px solid #6B02B1;
  padding-left: 1rem;
  margin: 1.5rem 0;
  font-style: italic;
  color: #555;
  background-color: #f8f9fa;
  padding: 1rem;
  border-radius: 0 8px 8px 0;
}

.berita-konten table {
  width: 100%;
  margin: 1.5rem 0;
  border-collapse: collapse;
}

.berita-konten table th {
  background-color: #f8f9fa;
  font-weight: 600;
}

.berita-konten table th,
.berita-konten table td {
  border: 1px solid #dee2e6;
  padding: 0.75rem;
}

.text-purple {
  color: #6B02B1;
}

/* === NAVIGATION SECTION === */
.navigation-section {
  padding-top: 1.5rem;
  border-top: 2px solid #e9ecef;
}

.nav-previous, .nav-next {
  display: inline-flex;
  align-items: center;
  padding: 0.75rem 1rem;
  border-radius: 8px;
  transition: all 0.3s ease;
  background-color: #f8f9fa;
}

.nav-previous:hover, .nav-next:hover {
  background-color: #e9ecef;
  text-decoration: none;
  transform: translateY(-2px);
}

.nav-icon {
  width: 40px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: #6B02B1;
  color: white;
  border-radius: 8px;
  font-size: 1rem;
}

.nav-previous:hover .nav-icon,
.nav-next:hover .nav-icon {
  background-color: #4d0283;
}

.nav-content .text-dark {
  color: #333;
  font-size: 0.9rem;
  transition: color 0.3s;
}

.nav-previous:hover .nav-content .text-dark,
.nav-next:hover .nav-content .text-dark {
  color: #6B02B1;
}

/* === TOMBOL KEMBALI === */
.btn-back {
  display: inline-flex;
  align-items: center;
  background-color: #6B02B1;
  color: #fff;
  padding: 0.75rem 1.5rem;
  border-radius: 8px;
  text-decoration: none;
  font-weight: 500;
  transition: all 0.3s ease;
  border: none;
  font-size: 0.9rem;
}

.btn-back:hover {
  background-color: #4d0283;
  color: #fff;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(107, 2, 177, 0.2);
}

.btn-back i {
  font-size: 0.9rem;
}

/* === CARD INFORMASI LAIN === */
.news-card {
  background: #fff;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
  transition: transform 0.25s ease, box-shadow 0.25s ease;
  height: 100%;
  padding-bottom: 10px;
}

.news-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 10px 22px rgba(0,0,0,0.15);
}

.news-image {
  position: relative;
}

.news-image img {
  width: 100%;
  height: 220px;
  object-fit: cover;
}

.news-content {
  padding: 18px;
}

.news-content h5 {
  font-size: 16px;
  color: #333;
  line-height: 1.5;
}

.news-content p {
  font-size: 14.5px;
  color: #555;
  margin-top: 10px;
  line-height: 1.6;
}

.read-more {
  display: inline-block;
  margin-top: 12px;
  color: #6B02B1;
  font-weight: 600;
  text-decoration: none;
  transition: color 0.2s;
}

.read-more:hover {
  color: #4d0283;
}

/* === SHARE BUTTONS === */
.share-section {
  background-color: #f8f9fa;
  border-radius: 8px;
}

.btn-outline-primary:hover {
  background-color: #6B02B1;
  border-color: #6B02B1;
  color: white;
}

.btn-outline-info:hover {
  background-color: #0dcaf0;
  border-color: #0dcaf0;
  color: white;
}

.btn-outline-success:hover {
  background-color: #198754;
  border-color: #198754;
  color: white;
}

/* === RESPONSIVE === */
@media (max-width: 768px) {
  .detail-image img {
    height: 250px;
  }

  .news-content h5 {
    font-size: 15px;
  }
  
  .berita-konten {
    font-size: 15px;
  }
  
  .detail-content h1 {
    font-size: 1.5rem;
  }
  
  .navigation-section .row > div {
    text-align: center !important;
    margin-bottom: 1rem;
  }
  
  .nav-previous, .nav-next {
    justify-content: center !important;
    width: 100%;
  }
  
  .nav-next .nav-content {
    text-align: left !important;
    margin-right: auto;
  }
  
  .btn-back {
    width: 100%;
    justify-content: center;
  }
  
  .share-section .btn {
    margin-bottom: 0.5rem;
  }
}

/* === MEDIUM DEVICES (Tablets) === */
@media (min-width: 768px) and (max-width: 992px) {
  .navigation-section .row > div {
    margin-bottom: 1rem;
  }
  
  .nav-previous, .nav-next {
    width: 100%;
  }
  
  .btn-back {
    width: 100%;
    justify-content: center;
  }
}
</style>
@endpush
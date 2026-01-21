@extends('layouts.frontend')

@section('title', 'Berita Kategori ' . $kategori->nama . ' - SMK Wisata Indonesia Jakarta')

@section('content')

{{-- === Hero Section === --}}
@include('frontend.partials.hero', [
  'title' => 'Berita Kategori: ' . $kategori->nama,
  'backgroundImage' => 'assets/img/foto-gedung.png',
  'height' => '200px'
])

<section class="kategori-informasi py-5">
  <div class="container">
    <div class="row">
      <div class="col-lg-8">
        <h1 class="mb-4 text-purple">
          Berita Kategori: <span class="badge bg-primary">{{ $kategori->nama }}</span>
        </h1>
        
        @if($berita->count() > 0)
          <div class="row">
            @foreach($berita as $item)
              <div class="col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                  <div class="position-relative">
                    <img src="{{ $item->gambar_thumbnail ? asset('storage/' . $item->gambar_thumbnail) : ($item->gambar ? asset('storage/' . $item->gambar) : asset('assets/img/default-news.jpg')) }}" 
                         class="card-img-top" 
                         alt="{{ $item->judul }}"
                         style="height: 200px; object-fit: cover;">
                  </div>
                  
                  <div class="card-body">
                    <h5 class="card-title">
                      <a href="{{ route('detail-informasi.show', $item->slug) }}" class="text-decoration-none text-dark">
                        {{ Str::limit($item->judul, 70) }}
                      </a>
                    </h5>
                    
                    <p class="card-text text-muted small">
                      {{ Str::limit(strip_tags($item->ringkasan ?: $item->konten), 120) }}
                    </p>
                    
                    <div class="d-flex justify-content-between align-items-center mt-3">
                      <small class="text-muted">
                        <i class="fas fa-user me-1"></i> {{ $item->penulis ?? 'Admin' }}
                      </small>
                      <small class="text-muted">
                        <i class="fas fa-calendar me-1"></i> 
                        {{ \Carbon\Carbon::parse($item->tanggal_publish)->translatedFormat('d F Y') }}
                      </small>
                    </div>
                  </div>
                  
                  <div class="card-footer bg-white border-0">
                    <a href="{{ route('detail-informasi.show', $item->slug) }}" class="btn btn-sm btn-outline-primary">
                      Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
          
          <!-- Pagination -->
          <div class="d-flex justify-content-center mt-4">
            {{ $berita->links() }}
          </div>
          
        @else
          <div class="text-center py-5">
            <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">Belum ada berita dalam kategori ini</h5>
            <a href="{{ route('detail-informasi.index') }}" class="btn btn-primary mt-3">
              Kembali ke Semua Berita
            </a>
          </div>
        @endif
      </div>
      
      <!-- Sidebar -->
      <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
          <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i> Tentang Kategori</h5>
          </div>
          <div class="card-body">
            <h6 class="text-primary">{{ $kategori->nama }}</h6>
            @if($kategori->deskripsi)
              <p class="small">{{ $kategori->deskripsi }}</p>
            @else
              <p class="small text-muted">Tidak ada deskripsi untuk kategori ini.</p>
            @endif
            <div class="mt-3">
              <small class="text-muted">
                <i class="fas fa-newspaper me-1"></i>
                Total Berita: {{ $berita->total() }}
              </small>
            </div>
          </div>
        </div>
        
        <div class="card border-0 shadow-sm">
          <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-arrow-left me-2"></i> Navigasi</h5>
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
@extends('layouts.frontend')

@section('title', 'Sarana dan Prasarana - SMK Wisata Indonesia Jakarta')

@section('content')

{{-- === Hero Section dengan background gedung dan warna ungu A948EA transparan === --}}
@include('frontend.partials.hero', [
  'title' => 'Sarana dan Prasarana',
  'backgroundImage' => 'assets/img/foto-gedung.png',
  'height' => '200px'
])

{{-- === Konten Pembuka === --}}
<section class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-12">
        {!! $sarpras->opening_paragraph ?? '<h1 class="fw-bold mb-4 text-center">Sarana dan Prasarana Berkualitas untuk Pendidikan Terbaik</h1>' !!}

        <div class="line-with-star">
          <span>★</span>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- === Bagian Lingkungan Belajar === --}}
<section class="container">
  <div class="row align-items-center flex-row-reverse mb-5">
    {{-- FOTO (KANAN) --}}
    <div class="col-lg-6 d-flex justify-content-center position-relative mb-4 mb-lg-0">
      <div class="photo-wrapper photo-down">
        <img src="/assets/img/gedung-sarpras.png" alt="Gedung Sarpras">
        <div class="shape-square"></div>
        <div class="shape-circle"></div>
      </div>
    </div>

    {{-- TEKS (KIRI) --}}
    <div class="col-lg-6">
      <h1 class="fw-bold text-purple mb-2">{{ $sarpras->learning_title ?? 'Lingkungan Belajar Nyaman & Inspiratif' }}</h1>
      {!! $sarpras->learning_description ?? '<p class="mb-4">Kami menyediakan lingkungan belajar yang mendukung perkembangan akademis dan kreativitas siswa. Fasilitas kami dirancang untuk menciptakan suasana yang kondusif bagi pembelajaran efektif.</p>' !!}
      <div class="features-list">
        <ul>
          @php
            // Pastikan learning adalah array
            $learningItems = $sarpras->learning_features ?? [];
            if (!is_array($learningItems)) {
                $learningItems = json_decode($learningItems, true) ?? [];
            }

            // Tampilkan setiap item dalam list
            foreach ($learningItems as $item) {
                echo '<li>' . e($item) . '</li>';
            }
          @endphp
        </ul>
      </div>
    </div>
  </div>
</section>

{{-- === Fasilitas Unggulan === --}}
<section class="container py-5 mb-5">
  <h1 class="fw-bold mb-4 text-center text-purple">Fasilitas Unggulan</h1>

  <div class="row g-4 justify-content-center">
    @php
      // Pastikan facilities_items adalah array
      $fasilitas = $sarpras->facilities_items ?? [];
      if (!is_array($fasilitas)) {
          $fasilitas = json_decode($fasilitas, true) ?? [];
      }
    @endphp

    @foreach ($fasilitas as $item)
      <div class="col-12 col-md-6 col-lg-4">
        <div class="facility-card text-center">
          <div class="icon">+</div>
          <div class="content">
            <h5 class="title">{{ $item['title'] }}</h5>
            <p class="desc">{{ $item['desc'] }}</p>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</section>

{{-- === Mengintip Fasilitas === --}}
<section style="background-color: #F4E8FC; margin-bottom: 75px; padding: 50px 0;">
  <div class="container">
    <h1 class="fw-bold mb-5 text-center text-purple">{{ $sarpras->gallery_title ?? 'Gallery Fasilitas' }}</h1>

    <div class="row g-3 justify-content-center">
      @php
        // Pastikan gallery_images adalah array
        $gallery = $sarpras->gallery_images ?? [];
        if (!is_array($gallery)) {
            $gallery = json_decode($gallery, true) ?? [];
        }
        
        // Default images jika kosong
        if (empty($gallery)) {
            $gallery = [
                'assets/img/sarpras.png',
                'assets/img/sarpras.png',
                'assets/img/sarpras.png',
                'assets/img/sarpras.png',
                'assets/img/sarpras.png',
                'assets/img/sarpras.png'
            ];
        }
      @endphp

      @foreach ($gallery as $index => $image)
        <!-- Gambar {{ $index + 1 }} -->
        <div class="col-12 col-md-4 mb-4">
          <div class="image-card card-rect"
               style="
                 background-image: url('{{ asset($image) }}'); 
                 height: 250px;
                 background-size: cover;
                 background-position: center;
                 border-radius: 8px;
               ">
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>

@endsection

@push('styles')
<style>
.text-purple {
  color: #6B02B1;
}

/* === LIST FITUR === */
.features-list ul {
  list-style: none;
  padding: 0;
  margin: 0;
}
.features-list li {
  position: relative;
  padding-left: 40px;
  margin-bottom: 14px;
  line-height: 1.6;
  color: #333;
  font-size: 1rem;
}
.features-list li::before {
  content: "✔";
  position: absolute;
  left: 0;
  top: 4px;
  width: 22px;
  height: 22px;
  background-color: #D8FFB5;
  color: #28a745;
  border-radius: 50%;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-weight: bold;
  font-size: 0.9rem;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

/* === KARTU FASILITAS === */
.facility-card {
  background-color: #EBD6FF;
  border: 2px solid #d2a8ff;
  border-radius: 20px;
  padding: 24px 20px;
  transition: all 0.3s ease;
  height: 100%;
  display: flex;
  flex-direction: column; /* ikon di atas teks */
  align-items: center;
  text-align: center;
}
.facility-card:hover {
  background-color: #dcb8ff;
  transform: translateY(-4px);
  box-shadow: 0 4px 10px rgba(107, 2, 177, 0.15);
}

/* Ikon kotak dengan sedikit radius */
.facility-card .icon {
  background-color: rgba(107, 2, 177, 0.2);
  color: #6B02B1;
  font-weight: bold;
  font-size: 1.5rem;
  border-radius: 8px; /* kotak sedikit rounded */
  width: 42px;
  height: 42px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 10px;
}

/* Judul dan deskripsi */
.facility-card .content .title {
  font-weight: 700;
  font-size: 1rem;
  color: #2e004f;
  margin-bottom: 4px;
}
.facility-card .content .desc {
  font-size: 0.9rem;
  color: #333;
  margin-bottom: 0;
  line-height: 1.4;
}

/* Responsif */
@media (max-width: 767.98px) {
  .facility-card {
    padding: 18px;
  }
  .facility-card .icon {
    width: 36px;
    height: 36px;
    font-size: 1.2rem;
  }
}
</style>
@endpush

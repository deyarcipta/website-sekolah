@extends('layouts.frontend')

@section('title', $metaTitle ?? 'Jurusan - SMK Wisata Indonesia Jakarta')

@section('meta')
@if(isset($metaDescription))
<meta name="description" content="{{ $metaDescription }}">
@endif
@if(isset($major) && $major->meta_keywords)
<meta name="keywords" content="{{ $major->meta_keywords }}">
@endif
@endsection

@section('content')

{{-- === Hero Section === --}}
@include('frontend.partials.hero', [
  'title' => isset($major) ? ($major->hero_title ?? $major->name) : 'Jurusan',
  'backgroundImage' => isset($major) && $major->hero_image ? asset('storage/' . $major->hero_image) : 'assets/img/foto-gedung.png',
  'height' => '200px'
])

{{-- === Bagian Penjelasan Jurusan === --}}
<section class="container" style="margin-top: 100px;">
  <div class="row align-items-center flex-row-reverse mb-5">

    {{-- FOTO (KANAN) --}}
    <div class="col-lg-6 d-flex justify-content-center position-relative mb-4 mb-lg-0">
      <div class="photo-wrapper photo-down mt-4">
        @if(isset($major) && $major->overview_image)
        <img src="{{ asset('storage/' . $major->overview_image) }}" alt="{{ $major->name }}" class="img-fluid rounded custom-img">
        @else
        <img src="/assets/img/jurusan-tkj.png" alt="Gedung Sarpras" class="img-fluid rounded custom-img">
        @endif
      </div>
    </div>

    {{-- TEKS (KIRI) --}}
    <div class="col-lg-6" style="padding: 0px 30px;">
      <h1 class="fw-bold text-purple mb-2">
        @if(isset($major))
          {{ $major->overview_title ?? $major->name }}
        @else
          Teknik Jaringan Komputer & Telekomunikasi
        @endif
      </h1>
      
      @if(isset($major) && $major->overview_content)
        <p class="mb-2 fw-semibold">
          {!! $major->overview_content !!}
        </p>
      @else
        <p class="mb-2 fw-semibold">
          Teknik Jaringan Komputer dan Telekomunikasi merupakan kompetensi keahlian yang berfokus pada jaringan, komputer, dan server.
        </p>
      @endif
      
      <div class="features-list">
        @if(isset($major) && $major->learning_items)
          @php
            // Handle JSON atau array
            if (is_string($major->learning_items)) {
                $items = json_decode($major->learning_items, true);
            } else {
                $items = $major->learning_items;
            }
            
            // Pastikan items adalah array
            $items = is_array($items) ? $items : [];
          @endphp
          
          @if(count($items) > 0 && isset($items[0]['description']))
            {{-- Format dengan deskripsi --}}
            <p class="mb-1">
              Kompetensi keahlian {{ $major->name }} memiliki tujuan sebagai berikut:
            </p>
            <ul class="numbered-list">
              @foreach($items as $item)
                <li>{{ $item['description'] ?? '' }}</li>
              @endforeach
            </ul>
          @elseif(count($items) > 0)
            {{-- Format default --}}
            <p class="mb-1">
              Kompetensi keahlian {{ $major->name }} memiliki tujuan sebagai berikut:
            </p>
            <ul class="numbered-list">
              @foreach($items as $item)
                <li>{{ $item }}</li>
              @endforeach
            </ul>
          @else
            {{-- Jika learning_items kosong --}}
            <div class="alert alert-info" role="alert">
              <div class="d-flex align-items-center">
                <i class="fas fa-info-circle me-3"></i>
                <div>
                  <h6 class="alert-heading mb-1">Informasi Tujuan Kompetensi</h6>
                  <p class="mb-0">
                    Tujuan dan kompetensi jurusan ini sedang dalam proses penyusunan. 
                    Informasi lengkap akan tersedia dalam waktu dekat.
                  </p>
                </div>
              </div>
            </div>
          @endif
        @else
          {{-- Jika tidak ada learning_items sama sekali --}}
          <div class="alert alert-info" role="alert">
            <div class="d-flex align-items-center">
              <i class="fas fa-info-circle me-3"></i>
              <div>
                <h6 class="alert-heading mb-1">Informasi Tujuan Kompetensi</h6>
                <p class="mb-0">
                  Tujuan dan kompetensi jurusan ini sedang dalam proses penyusunan. 
                  Informasi lengkap akan tersedia dalam waktu dekat.
                </p>
              </div>
            </div>
          </div>
        @endif
        
        <!-- Tombol Mari Bergabung -->
        <a href="https://ppdb.smkwisataindonesia.sch.id/" target="_blank" class="btn-bergabung mt-3">
          Mari Bergabung
          <span class="arrow">→</span>
        </a>
      </div>
    </div>

  </div>
</section>

{{-- === Bagian Prestasi === --}}
<section style="background-color: #F4E8FC; margin-bottom: 75px; padding: 75px 0;">
  <div class="container">
    <h1 class="fw-bold text-center">Prestasi</h1>
    <div>
      <hr class="purple-line mb-5">
    </div>
    
    @if(isset($major) && $major->achievements && $major->achievements->count() > 0)
      <!-- Tampilkan prestasi dari database -->
      <!-- === 3 Kotak Sejajar: 2 kotak square kiri + 1 kotak rectangular kanan === -->
      @php
        $achievements = $major->achievements;
      @endphp
      
      @for($i = 0; $i < min(count($achievements), 6); $i += 3)
      <div class="row g-3 mt-4">
        @for($j = $i; $j < min($i + 3, count($achievements)); $j++)
          @php
            $achievement = $achievements[$j];
            $colClass = ($j - $i) < 2 ? 'col-12 col-md-3' : 'col-12 col-md-6';
            $cardClass = ($j - $i) < 2 ? 'card-square' : 'card-rect';
            $imageUrl = $achievement->image ? asset('storage/' . $achievement->image) : 
                       (($j - $i) < 2 ? asset('assets/img/prestasi-kotak.png') : asset('assets/img/prestasi.png'));
          @endphp
          
          <div class="{{ $colClass }}">
            <div class="image-card {{ $cardClass }}"
                 style="background-image: url('{{ $imageUrl }}');">
              <div class="overlay d-flex align-items-center justify-content-center">
                <h5 class="card-label mb-0">{{ $achievement->title }}</h5>
              </div>
            </div>
          </div>
        @endfor
      </div>
      @endfor
      
    @else
      <!-- Tampilan default prestasi -->
      <!-- === 3 Kotak Sejajar: 2 kotak square kiri + 1 kotak rectangular kanan === -->
      <div class="row g-3 mt-4">
        <!-- Kotak 1 (square) -->
        <div class="col-12 col-md-3">
          <div class="image-card card-square"
               style="background-image: url('{{ asset('assets/img/prestasi-kotak.png') }}');">
            <div class="overlay d-flex align-items-center justify-content-center">
              <h5 class="card-label mb-0">Juara Harapan 1 LKS</h5>
            </div>
          </div>
        </div>

        <!-- Kotak 2 (square) -->
        <div class="col-12 col-md-3">
          <div class="image-card card-square"
               style="background-image: url('{{ asset('assets/img/prestasi-kotak.png') }}');">
            <div class="overlay d-flex align-items-center justify-content-center">
              <h5 class="card-label mb-0">Juara Harapan 1 LKS</h5>
            </div>
          </div>
        </div>

        <!-- Kotak 3 (rectangular, lebih lebar) -->
        <div class="col-12 col-md-6">
          <div class="image-card card-rect"
               style="background-image: url('{{ asset('assets/img/prestasi.png') }}');">
            <div class="overlay d-flex align-items-center justify-content-center">
              <h5 class="card-label mb-0">Juara Harapan 1 LKS</h5>
            </div>
          </div>
        </div>
      </div>
      <!-- === akhir 3 kotak === -->
      <!-- === 3 Kotak Sejajar: 2 kotak square kiri + 1 kotak rectangular kanan === -->
      <div class="row g-3 mt-4">
        <!-- Kotak 3 (rectangular, lebih lebar) -->
        <div class="col-12 col-md-6">
          <div class="image-card card-rect"
               style="background-image: url('{{ asset('assets/img/prestasi.png') }}');">
            <div class="overlay d-flex align-items-center justify-content-center">
              <h5 class="card-label mb-0">Juara Harapan 1 LKS</h5>
            </div>
          </div>
        </div>
        <!-- Kotak 1 (square) -->
        <div class="col-12 col-md-3">
          <div class="image-card card-square"
               style="background-image: url('{{ asset('assets/img/prestasi-kotak.png') }}');">
            <div class="overlay d-flex align-items-center justify-content-center">
              <h5 class="card-label mb-0">Juara Harapan 1 LKS</h5>
            </div>
          </div>
        </div>

        <!-- Kotak 2 (square) -->
        <div class="col-12 col-md-3">
          <div class="image-card card-square"
               style="background-image: url('{{ asset('assets/img/prestasi-kotak.png') }}');">
            <div class="overlay d-flex align-items-center justify-content-center">
              <h5 class="card-label mb-0">Juara Harapan 1 LKS</h5>
            </div>
          </div>
        </div>
      </div>
      <!-- === akhir 3 kotak === -->
    @endif
  </div>
</section>

{{-- === Bagian Visi & Misi === --}}
<section class="container">
  <div class="row flex-row-reverse mb-5">

    {{-- FOTO (KANAN) --}}
    <div class="col-lg-6 d-flex justify-content-center position-relative">
      <div class="photo-wrapper photo-down">
        @if(isset($major) && $major->vision_mission_image)
        <img src="{{ asset('storage/' . $major->vision_mission_image) }}" alt="{{ $major->name }}" class="img-fluid rounded custom-img-quote">
        @else
        <img src="/assets/img/praktek.png" alt="Praktek" class="img-fluid rounded custom-img-quote">
        @endif
        
        @if(isset($major) && $major->quote)
        <p class="text-quote">{{ $major->quote }}</p>
        <hr class="purple-line purple-line-left mb-3">
        <div>
          <h4 class="fw-semibold mb-0" style="line-height: 1;">{{ $major->quote_author ?? '' }}</h4>
          <span style="font-size: 10px; margin-top: 0px; line-height: 1;">{{ $major->quote_position ?? '' }}</span>
        </div>
        @else
        <p class="text-quote">Karakter utama dari orang yang sukses adalah keberanian dan komitmen mereka untuk terus maju tanpa takut halangan. Tidak ada jaminan sebuah kesuksesan bagi seorang yang tidak keluar dari zona nyamannya dan takut mengambil risiko.</p>
        <hr class="purple-line purple-line-left mb-3">
        <div>
          <h4 class="fw-semibold mb-0" style="line-height: 1;">Mark Zuckerberg</h4>
          <span style="font-size: 10px; margin-top: 0px; line-height: 1;">CEO Meta</span>
        </div>
        @endif
      </div>
    </div>

    {{-- TEKS (KIRI) --}}
    <div class="col-lg-6" style="padding: 0px 30px;">
      <h1 class="fw-bold text-purple mb-2">Visi & Misi</h1>
      
      @if(isset($major) && $major->vision)
      <p class="mb-2 fw-semibold">{{ $major->vision }}</p>
      @else
      <p class="mb-2 fw-semibold">
        Terwujudnya Sumber Daya Manusia yang professional dalam bidang Teknik Informatika sesuai dengan tuntutan dunia industry dengan etos kerja yang tinggi dengan dilandasi akhlak yang baik.
      </p>
      @endif
      
      <div class="features-list">
        @if(isset($major) && $major->mission)
          @php
            // Handle mission text - bisa string atau array
            if (is_string($major->mission)) {
                // Pisahkan berdasarkan baris baru
                $missions = array_filter(explode("\n", $major->mission));
            } elseif (is_array($major->mission)) {
                $missions = $major->mission;
            } else {
                $missions = [];
            }
          @endphp
          
          @if(count($missions) > 0)
          <ul class="bullet-list">
            @foreach($missions as $mission)
              @if(trim($mission))
              <li>{{ trim($mission) }}</li>
              @endif
            @endforeach
          </ul>
          @endif
        @else
        <ul class="bullet-list">
          <li>Menghasilkan tamatan yang berkualitas, terampil dan potensial di bidang Teknik Komputer dan Jaringan.</li>
          <li>Menyelenggarakan program pendidikan profesional di bidang IT dan mampu menjawab tantangan serta perubahan kemajuan ilmu dan teknologi.</li>
          <li>Meningkatkan kerjasama dengan DU/DI di bidang Teknik Komputer dan Jaringan.</li>
          <li>Menjadikan peserta didik memiliki kreativitas dan inovasi sehingga dapat mengembangkan diri dalam bidang IT.</li>
          <li>Mengembangkan fasilitas dan alat media pembelajaran berbasis PBL (Project Based Learning).</li>
          <li>Menghasilkan lulusan tepat waktu yang mampu bersaing di dunia industri.</li>
        </ul>
        @endif
      </div>
    </div>

  </div>
</section>

{{-- === Bagian Tim Pengajar === --}}
<section style="background-color: #F4E8FC; margin-bottom: 75px; padding: 75px 0;">
  <div class="container">
    <h1 class="fw-bold text-center">Tim Pengajar</h1>
    <div>
      <hr class="purple-line mb-5">
    </div>
    <div class="col-lg-12">
      <p class="text-center mb-1 fw-semibold" style="padding: 0px 25px; font-size: 20px;">
        @if(isset($major) && $major->teachers_content)
          {!! nl2br(e($major->teachers_content)) !!}
        @else
          Teknik jaringan komputer dan telekomunikasi memiliki tim pengajar yang profesional untuk<br>melahirkan siswa yang unggul dan siap bersaing di dunia industri.
        @endif
      </p>
    
    {{-- === Tim Pengajar === --}}
      <div class="row g-4 justify-content-center mt-4">
        @if(isset($major) && $major->teachers && $major->teachers->count() > 0)
          @foreach($major->teachers as $teacher)
          <div class="col-md-4 col-lg-3 d-flex">
            <div class="card text-center kepala-card shadow-sm flex-fill">
              @if($teacher->image)
              <img src="{{ asset('storage/' . $teacher->image) }}" class="card-img-top" alt="{{ $teacher->name }}">
              @else
              <img src="/assets/img/pengajar-jurusan.png" class="card-img-top" alt="{{ $teacher->name }}">
              @endif
              <div class="card-body">
                <h5 class="card-title mb-1">{{ $teacher->name }}</h5>
                <p class="card-text mb-0">{{ $teacher->position }}</p>
              </div>
            </div>
          </div>
          @endforeach
        @else
          <!-- Default teachers -->
          <div class="col-md-4 col-lg-3 d-flex">
            <div class="card text-center kepala-card shadow-sm flex-fill">
              <img src="/assets/img/pengajar-jurusan.png" class="card-img-top" alt="Wakil Kepala Sekolah 1">
              <div class="card-body">
                <h5 class="card-title mb-1">Siti Rahmawati, S.Kom.</h5>
                <p class="card-text mb-0">Wakil Kepala Sekolah Kurikulum</p>
              </div>
            </div>
          </div>

          <div class="col-md-4 col-lg-3 d-flex">
            <div class="card text-center kepala-card shadow-sm flex-fill">
              <img src="/assets/img/pengajar-jurusan.png" class="card-img-top" alt="Wakil Kepala Sekolah 2">
              <div class="card-body">
                <h5 class="card-title mb-1 fw-bold">Andi Prasetyo, S.Pd.</h5>
                <p class="card-text mb-0">Wakil Kepala Sekolah Bidang Kesiswaan</p>
              </div>
            </div>
          </div>

          <div class="col-md-4 col-lg-3 d-flex">
            <div class="card text-center kepala-card shadow-sm flex-fill">
              <img src="/assets/img/pengajar-jurusan.png" class="card-img-top" alt="Wakil Kepala Sekolah 3">
              <div class="card-body">
                <h5 class="card-title mb-1 fw-bold">Lina Marlina, S.Pd.</h5>
                <p class="card-text mb-0">Wakil Kepala Sekolah Bidangan Sarana & Prasarana</p>
              </div>
            </div>
          </div>
        @endif
      </div>
    </div>
  </div>
</section>

{{-- === Bagian Pembelajaran === --}}
<section class="container">
  <div class="row align-items-center flex-row-reverse mb-5 py-5 pembelajaran">

    {{-- TEKS (KANAN) --}}
    <div class="col-lg-6" style="padding: 0px 30px;">
      <h1 class="fw-bold text-purple mb-2">
        @if(isset($major) && $major->learning_title)
          {{ $major->learning_title }}
        @else
          Pembelajaran di TJKT
        @endif
      </h1>
      
      {{-- TAMPILKAN LANGSUNG learning_content --}}
      @if(isset($major) && $major->learning_content)
        {!! $major->learning_content !!}
      @else
        {{-- Jika tidak ada data pembelajaran --}}
        <div class="alert alert-info" role="alert">
          <div class="d-flex align-items-center">
            <i class="fas fa-info-circle me-3"></i>
            <div>
              <h6 class="alert-heading mb-1">Informasi Pembelajaran</h6>
              <p class="mb-0">
                Materi pembelajaran untuk jurusan ini sedang dalam proses pengembangan. 
                Silakan hubungi bagian administrasi untuk informasi lebih detail.
              </p>
            </div>
          </div>
        </div>
      @endif
    </div>

    {{-- FOTO (KIRI) --}}
    <div class="col-lg-6 d-flex justify-content-center position-relative mb-4 mb-lg-0">
      <div class="photo-wrapper photo-down">
        @if(isset($major) && $major->learning_image)
        <img src="{{ asset('storage/' . $major->learning_image) }}" 
             alt="{{ $major->learning_title ?? 'Pembelajaran' }}" 
             class="img-fluid rounded custom-img">
        @else
        <img src="/assets/img/pembelajaran-tjkt.png" alt="Pembelajaran TJKT" class="img-fluid rounded custom-img">
        @endif
      </div>
    </div>

  </div>
</section>

{{-- === Bagian Accordion (Optional) === --}}
{{-- @if(isset($major) && $major->accordion_items)
<section class="container mb-5">
  <h2 class="fw-bold text-center text-purple mb-4">Detail Program</h2>
  <div class="accordion" id="programAccordion">
    @php
      // Handle accordion_items
      if (is_string($major->accordion_items)) {
          $accordionItems = json_decode($major->accordion_items, true);
      } else {
          $accordionItems = $major->accordion_items;
      }
      
      $accordionItems = is_array($accordionItems) ? $accordionItems : [];
    @endphp
    
    @foreach($accordionItems as $index => $item)
    <div class="accordion-item">
      <h2 class="accordion-header">
        <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" 
                type="button" 
                data-bs-toggle="collapse" 
                data-bs-target="#collapse{{ $index }}">
          {{ $item['title'] ?? '' }}
        </button>
      </h2>
      <div id="collapse{{ $index }}" 
           class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" 
           data-bs-parent="#programAccordion">
        <div class="accordion-body">
          {!! $item['content'] ?? '' !!}
        </div>
      </div>
    </div>
    @endforeach
  </div>
</section>
@endif --}}

@endsection

@push('styles')
<style>
.purple-line {
  border: none;
  height: 4px; /* makin besar = makin tebal */
  background-color: #6B02B1 !important; /* warna ungu sesuai navbar */
  border-radius: 4px; /* ujung sedikit melengkung */
  width: 50px; /* setengah lebar container */
  margin: 0 auto; /* agar berada di tengah */
  opacity: 1;
}

.purple-line-left {
  margin-left: 0; /* agar rata kiri */
}

.text-purple {
  color: #6B02B1;
}

/* Daftar bernomor */
.numbered-list {
  list-style-type: decimal;
  padding-left: 20px;
  margin: 0;
}
.numbered-list li {
  margin-bottom: 5px;
  line-height: 1.7;
  color: #333;
  font-size: 1rem;
}

.bullet-list {
  list-style-type: disc; /* gunakan bullet standar */
  padding-left: 20px; /* jarak dari tepi kiri */
  color: #333;
  font-size: 1rem;
  line-height: 1.7;
}

.bullet-list li {
  margin-bottom: 10px;
}

/* Ukuran dan posisi gambar */
.custom-img {
  width: 90%; /* perkecil sedikit dari lebar kolom */
  max-width: 480px; /* batas maksimal agar tidak terlalu besar */
  height: auto;
  object-fit: contain;
  transition: all 0.3s ease;
}

/* Ukuran dan posisi gambar */
.custom-img-quote {
  width: 100%; /* perkecil sedikit dari lebar kolom */
  max-width: 480px; /* batas maksimal agar tidak terlalu besar */
  height: auto;
  object-fit: contain;
  transition: all 0.3s ease;
}

.text-quote {
  font-style: italic;
  color: #555;
  margin-top: 10px;
  font-size: 1rem;
  max-width: 480px;
}

/* Efek hover lembut */
.custom-img:hover {
  transform: scale(1.03);
}

/* Tombol "Mari Bergabung" */
.btn-bergabung {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background-color: #6B02B1; /* warna ungu navbar */
  color: #fff;
  font-weight: 600;
  padding: 10px 22px;
  border-radius: 25px;
  text-decoration: none;
  transition: all 0.3s ease;
  font-size: 1rem;
}

.btn-bergabung:hover {
  background-color: #56018e; /* ungu sedikit lebih gelap saat hover */
  transform: translateY(-2px);
}

.btn-bergabung .arrow {
  font-size: 1.2rem;
  transition: transform 0.3s ease;
}

.btn-bergabung:hover .arrow {
  transform: translateX(4px); /* animasi panah ke kanan */
}

/* === CARD UMUM === */
.image-card {
  position: relative;
  width: 100%; /* biarkan mengikuti col bootstrap */
  height: 250px; /* tinggi tetap */
  background-size: cover;
  background-position: center;
  overflow: hidden;
  box-shadow: 0 6px 18px rgba(0,0,0,0.08);
  transition: transform 0.2s ease, box-shadow 0.2s ease;
  border-radius: 10px;
}

/* === HOVER EFFECT === */
.image-card:hover {
  transform: scale(1.02);
  box-shadow: 0 8px 20px rgba(0,0,0,0.12);
}

/* === OVERLAY === */
.overlay {
  position: absolute;
  inset: 0;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background 0.2s ease;
}

.image-card:hover .overlay {
  background: rgba(0, 0, 0, 0.65);
}

/* === TEKS === */
.card-label {
  color: #fff;
  font-weight: 600;
  text-align: center;
  font-size: 20px;
}

.kepala-card {
  border: none;
  overflow: hidden;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  background-color: #fff;
  display: flex;
  flex-direction: column;
  height: 100%;
}

.kepala-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 6px 15px rgba(107, 2, 177, 0.15);
}

/* Foto menyesuaikan lebar card */
.kepala-card img {
  width: 100%;
  height: 250px;
  object-fit: cover;
}

/* Bagian bawah card — selalu vertikal tengah */
.kepala-card .card-body {
  background-color: #fff;
  padding: 16px;
  border-top: 1px solid rgba(107, 2, 177, 0.15);
  flex-grow: 1;
  display: flex;
  flex-direction: column;
  justify-content: center; /* tengah vertikal */
  align-items: center;      /* tengah horizontal */
  text-align: center;
}

.kepala-card .card-title {
  color: #000;
  font-size: 1.05rem;
  font-weight: 700;
  margin-bottom: 4px;
}

.kepala-card .card-text {
  color: #000;
  font-size: 0.8rem;
}

/* Responsif */
@media (max-width: 767.98px) {
  .custom-img {
    width: 100%;
    max-width: 360px;
  }

  .card-square,
  .card-rect {
    width: 48%;     /* dua kolom di tablet */
    height: 250px;  /* sedikit lebih pendek */
  }

  .kepala-card img {
    height: 200px;
  }
}

@media (max-width: 575.98px) {
  .card-square,
  .card-rect {
    width: 100%;
    height: 200px;
  }

  .photo-wrapper {
    margin-bottom: 20px; /* ✅ tambahan jarak bawah di versi mobile */
    width: 85%;
  }

  .custom-img-quote {
    display: block;
    margin: 0 auto; /* membuat gambar berada di tengah */
  }

  .pembelajaran .photo-down {
    margin-top: 20px; /* hilangkan margin top di versi mobile */
  }
}
</style>
@endpush
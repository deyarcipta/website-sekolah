@extends('layouts.frontend')

@section('title', 'Visi & Misi - SMK Wisata Indonesia Jakarta')

@section('content')

{{-- === Hero Section dengan background gedung dan warna ungu A948EA transparan === --}}
@include('frontend.partials.hero', [
  'title' => $visiMisi->hero_title ?? 'Visi & Misi',
  'backgroundImage' => $visiMisi->getHeroBackgroundUrl(),
  'height' => '200px'
])

<section class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-12">
        <p class="text-center mb-1 mt-4" style="padding: 0px 25px; font-size: 20px;">
          {{ $visiMisi->opening_paragraph ?? 'Pendidikan di SMK Wisata Indonesia adalah tentang meningkatkan kemampuan keterampilan siswa yang dilandaskan dengan ide kreatif, unggul dan berakhlak mulia untuk mampu<br>bersaing di dunia industri.' }}
        </p>

        <div class="line-with-star">
          <span>★</span>
        </div>

        <!-- === 3 Kotak Sejajar: 2 kotak square kiri + 1 kotak rectangular kanan === -->
        <div class="row g-3 mt-4">
          <!-- Kotak 1 (square) -->
          <div class="col-12 col-md-3">
            <div class="image-card card-square"
                 style="background-image: url('{{ $visiMisi->getCardImageUrl(1) }}');">
              <div class="overlay d-flex align-items-center justify-content-center">
                <h5 class="card-label mb-0">{{ $visiMisi->card1_label ?? 'Kreatif' }}</h5>
              </div>
            </div>
          </div>

          <!-- Kotak 2 (square) -->
          <div class="col-12 col-md-3">
            <div class="image-card card-square"
                 style="background-image: url('{{ $visiMisi->getCardImageUrl(2) }}');">
              <div class="overlay d-flex align-items-center justify-content-center">
                <h5 class="card-label mb-0">{{ $visiMisi->card2_label ?? 'Unggul' }}</h5>
              </div>
            </div>
          </div>

          <!-- Kotak 3 (rectangular, lebih lebar) -->
          <div class="col-12 col-md-6">
            <div class="image-card card-rect"
                 style="background-image: url('{{ $visiMisi->getCardImageUrl(3) }}');">
              <div class="overlay d-flex align-items-center justify-content-center">
                <h5 class="card-label mb-0">{{ $visiMisi->card3_label ?? 'Berakhlak Mulia' }}</h5>
              </div>
            </div>
          </div>
        </div>
        <!-- === akhir 3 kotak === -->
      </div>
    </div>
  </div>
</section>

<section class="container my-5 py-3">
  {{-- ===== VISI KAMI ===== --}}
  <div class="row align-items-center mb-5">
    {{-- FOTO (KIRI) --}}
    <div class="col-lg-6 d-flex justify-content-center position-relative">
      <div class="photo-wrapper photo-up">
        <img src="{{ $visiMisi->getVisiImageUrl() }}" alt="Visi 1">
        <div class="shape-square"></div>
        <div class="shape-circle"></div>
      </div>
    </div>

    {{-- TEKS (KANAN) --}}
    <div class="col-lg-6">
      <h3 class="title-purple mb-3">{{ $visiMisi->visi_title ?? 'Visi Kami' }}</h3>
      <p class="fw-semibold">
        {!! $visiMisi->visi_description !!}
      </p>
      <ul>
        @php
            // Pastikan visi_items adalah array
            $visiItems = $visiMisi->visi_items ?? [];
            if (!is_array($visiItems)) {
                $visiItems = json_decode($visiItems, true) ?? [];
            }
            
            // Default items jika tidak ada data
            $defaultVisiItems = [
                'Menghasilkan lulusan yang terampil, profesional, dan siap kerja.',
                'Membekali siswa dengan wawasan internasional dan kemampuan bahasa asing.',
                'Menanamkan karakter positif agar menjadi pribadi berintegritas.',
                'Menjadi sekolah rujukan di bidang pariwisata dan perhotelan berstandar global.',
                'Menjalin kemitraan luas dengan dunia usaha dan dunia industri (DUDI).'
            ];
            
            // Gabungkan default dengan data dari database
            $finalVisiItems = !empty($visiItems) ? $visiItems : $defaultVisiItems;
        @endphp
        
        @foreach($finalVisiItems as $item)
            <li>{{ $item }}</li>
        @endforeach
      </ul>
    </div>
  </div>

  {{-- ===== MISI KAMI ===== --}}
  <div class="row align-items-center flex-row-reverse mb-5">
    {{-- FOTO (KANAN) --}}
    <div class="col-lg-6 d-flex justify-content-center position-relative">
      <div class="photo-wrapper photo-down">
        <img src="{{ $visiMisi->getMisiImageUrl() }}" alt="Misi 1">
        <div class="shape-square"></div>
        <div class="shape-circle"></div>
      </div>
    </div>

    {{-- TEKS (KIRI) --}}
    <div class="col-lg-6">
      <h3 class="title-purple mb-3">{{ $visiMisi->misi_title ?? 'Misi Kami' }}</h3>
      <p class="fw-semibold">
        {!! $visiMisi->misi_description !!}
      </p>
      <ul>
        @php
            // Pastikan misi_items adalah array
            $misiItems = $visiMisi->misi_items ?? [];
            if (!is_array($misiItems)) {
                $misiItems = json_decode($misiItems, true) ?? [];
            }
            
            // Default items jika tidak ada data
            $defaultMisiItems = [
                'Meningkatkan kompetensi peserta didik di bidang pariwisata dan perhotelan.',
                'Mengintegrasikan kurikulum dengan kebutuhan dunia industri (DUDI).',
                'Meningkatkan penguasaan bahasa asing dan teknologi informasi.',
                'Membangun karakter, etos kerja, dan tanggung jawab sosial.'
            ];
            
            // Gabungkan default dengan data dari database
            $finalMisiItems = !empty($misiItems) ? $misiItems : $defaultMisiItems;
        @endphp
        
        @foreach($finalMisiItems as $item)
            <li>{{ $item }}</li>
        @endforeach
      </ul>
    </div>
  </div>
</section>

@endsection

@push('styles')
<style>
/* === CARD STYLE === */
.image-card {
  position: relative;
  background-size: cover;
  background-position: center;
  overflow: hidden;
  box-shadow: 0 6px 18px rgba(0,0,0,0.08);
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card-square {
  width: 250px;
  height: 250px;
}

.card-rect {
  width: 510px;
  height: 250px;
}

.overlay {
  position: absolute;
  inset: 0;
  background: rgba(107, 2, 177, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background 0.2s ease;
}

.card-label {
  color: #fff;
  font-weight: 600;
  text-align: center;
  font-size: 20px;
}

.image-card:hover {
  transform: scale(1.02);
  box-shadow: 0 8px 20px rgba(0,0,0,0.12);
}
.image-card:hover .overlay {
  background: rgba(107, 2, 177, 0.65);
}

/* Judul Ungu */
.title-purple {
  color: #6b02b1;
  font-weight: 700;
}

/* Kontainer Gambar */
.photo-wrapper {
  overflow: hidden;
  position: relative;
}

/* Gambar di dalam */
.photo-wrapper img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

/* Hiasan dekoratif */
.shape-square {
  position: absolute;
  top: -20px;
  left: -20px;
  width: 60px;
  height: 60px;
  background-color: #00b140;
  border-radius: 10px;
  z-index: 2;
}

.shape-circle {
  position: absolute;
  bottom: -25px;
  right: -25px;
  width: 70px;
  height: 70px;
  background-color: #2d3df7;
  border-radius: 50%;
  z-index: 2;
}

.photo-up {
  transform: translateY(-25px);
}

.photo-down {
  transform: translateY(25px);
}

ul {
  padding-left: 20px;
}

ul li {
  margin-bottom: 6px;
}

/* === RESPONSIVE === */
@media (max-width: 991.98px) {
  .card-square,
  .card-rect {
    width: 48%;
    height: 250px;
  }

  .row.align-items-center {
    text-align: center;
  }

  .photo-wrapper {
    width: 85%;
    height: auto;
  }

  .photo-up,
  .photo-down {
    transform: none;
  }

  .shape-square,
  .shape-circle {
    display: none;
  }
}

@media (max-width: 575.98px) {
  .card-square,
  .card-rect {
    width: 100%;
    height: 200px;
  }

  /* === PERBAIKAN KHUSUS MOBILE === */
  .photo-wrapper {
    margin-bottom: 20px;
  }

  .row.align-items-center ul {
    text-align: left !important;
    margin: 0 auto;
  }
}
</style>
@endpush
@extends('layouts.frontend')

@section('title', 'Visi & Misi - SMK Wisata Indonesia Jakarta')

@section('content')

{{-- === Hero Section dengan background gedung dan warna ungu A948EA transparan === --}}
@include('frontend.partials.hero', [
  'title' => 'Visi & Misi',
  'backgroundImage' => 'assets/img/foto-gedung.png',
  'height' => '200px'
])

<section class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-12">
        <p class="text-center mb-1 mt-4" style="padding: 0px 25px; font-size: 20px;">
          Pendidikan di SMK Wisata Indonesia adalah tentang meningkatkan kemampuan keterampilan siswa yang dilandaskan dengan ide kreatif, unggul dan berakhlak mulia untuk mampu<br>bersaing di dunia industri.
        </p>

        <div class="line-with-star">
          <span>★</span>
        </div>

        <!-- === 3 Kotak Sejajar: 2 kotak square kiri + 1 kotak rectangular kanan === -->
        <div class="row g-3 mt-4">
          <!-- Kotak 1 (square) -->
          <div class="col-12 col-md-3">
            <div class="image-card card-square"
                 style="background-image: url('{{ asset('assets/img/card1.png') }}');">
              <div class="overlay d-flex align-items-center justify-content-center">
                <h5 class="card-label mb-0">Kreatif</h5>
              </div>
            </div>
          </div>

          <!-- Kotak 2 (square) -->
          <div class="col-12 col-md-3">
            <div class="image-card card-square"
                 style="background-image: url('{{ asset('assets/img/card2.png') }}');">
              <div class="overlay d-flex align-items-center justify-content-center">
                <h5 class="card-label mb-0">Unggul</h5>
              </div>
            </div>
          </div>

          <!-- Kotak 3 (rectangular, lebih lebar) -->
          <div class="col-12 col-md-6">
            <div class="image-card card-rect"
                 style="background-image: url('{{ asset('assets/img/card3.png') }}');">
              <div class="overlay d-flex align-items-center justify-content-center">
                <h5 class="card-label mb-0">Berakhlak Mulia</h5>
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
        <img src="/assets/img/visi&misi.png" alt="Visi 1">
        <div class="shape-square"></div>
        <div class="shape-circle"></div>
      </div>
    </div>

    {{-- TEKS (KANAN) --}}
    <div class="col-lg-6">
      <h3 class="title-purple mb-3">Visi Kami</h3>
      <p class="fw-semibold">
        SMK Wisata Indonesia diharapkan menjadi lembaga pendidikan dan pelatihan yang berwawasan global 
        dan menghasilkan tamatan yang unggul di bidangnya dengan dilandasi akhlak mulia.
      </p>
      <ul>
        <li>Menghasilkan lulusan yang terampil, profesional, dan siap kerja.</li>
        <li>Membekali siswa dengan wawasan internasional dan kemampuan bahasa asing.</li>
        <li>Menanamkan karakter positif agar menjadi pribadi berintegritas.</li>
        <li>Menjadi sekolah rujukan di bidang pariwisata dan perhotelan berstandar global.</li>
        <li>Menjalin kemitraan luas dengan dunia usaha dan dunia industri (DUDI).</li>
      </ul>
    </div>
  </div>

  {{-- ===== MISI KAMI ===== --}}
  <div class="row align-items-center flex-row-reverse mb-5">
    {{-- FOTO (KANAN) --}}
    <div class="col-lg-6 d-flex justify-content-center position-relative">
      <div class="photo-wrapper photo-down">
        <img src="/assets/img/visi&misi.png" alt="Misi 1">
        <div class="shape-square"></div>
        <div class="shape-circle"></div>
      </div>
    </div>

    {{-- TEKS (KIRI) --}}
    <div class="col-lg-6">
      <h3 class="title-purple mb-3">Misi Kami</h3>
      <p class="fw-semibold">
        SMK Wisata Indonesia memiliki misi untuk mendukung pengembangan potensi peserta didik 
        agar menjadi tenaga kerja profesional dan berdaya saing global.
      </p>
      <ul>
        <li>Meningkatkan kompetensi peserta didik di bidang pariwisata dan perhotelan.</li>
        <li>Mengintegrasikan kurikulum dengan kebutuhan dunia industri (DUDI).</li>
        <li>Meningkatkan penguasaan bahasa asing dan teknologi informasi.</li>
        <li>Membangun karakter, etos kerja, dan tanggung jawab sosial.</li>
      </ul>
    </div>
  </div>

</section>

@endsection

{{-- CSS khusus (letakkan di head/global CSS kalau mau) --}}
@push('styles')
<style>

  /* Setting Star Garis */

.line-with-star {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 25px !important;
}

.line-with-star::before,
.line-with-star::after {
    content: "";
    display: inline-block;
    width: 50px;
    /* lebar garis */
    height: 4px;
    /* ketebalan garis */
    background-color: #6b21a8;
    /* warna garis */
}

.line-with-star span {
    color: #6b21a8;
    /* warna bintang */
    margin: 0 10px;
    /* jarak kiri kanan bintang */
    font-size: 22px;
}

/* Akhir Setting Star Garis */

/* === CARD STYLE === */

/* card container umum */
.image-card {
  position: relative;
  background-size: cover;
  background-position: center;
  /* border-radius: 12px; */
  overflow: hidden;
  box-shadow: 0 6px 18px rgba(0,0,0,0.08);
  /* border: 2px solid #6B02B1; */
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

/* persegi */
.card-square {
  width: 250px;
  height: 250px;
}

/* persegi panjang */
.card-rect {
  width: 510px;
  height: 250px;
}

/* overlay ungu 50% */
.overlay {
  position: absolute;
  inset: 0;
  background: rgba(107, 2, 177, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background 0.2s ease;
}

/* teks */
.card-label {
  color: #fff;
  font-weight: 600;
  text-align: center;
  font-size: 20px;
}

/* efek hover */
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

/* Posisi naik-turun agar tidak sejajar */
.photo-up {
  transform: translateY(-25px);
}

.photo-down {
  transform: translateY(25px);
}

/* List teks */
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
    width: 48%;     /* dua kolom di tablet */
    height: 250px;  /* sedikit lebih pendek */
  }

  .row.align-items-center {
    text-align: center;
  }

  .photo-wrapper {
    width: 85%;
    height: auto;
    border: 2px solid #6b02b1;
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
    width: 100%;    /* full lebar */
    height: 200px;  /* tinggi otomatis lebih kecil */
  }
}

</style>
@endpush

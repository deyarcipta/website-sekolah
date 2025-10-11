@extends('layouts.frontend')

@section('title', 'Informasi - SMK Wisata Indonesia Jakarta')

@section('content')

{{-- === Hero Section === --}}
@include('frontend.partials.hero', [
  'title' => 'Informasi',
  'backgroundImage' => 'assets/img/foto-gedung.png',
  'height' => '200px'
])

<section class="news-section py-5">
  <div class="container">
    <div class="row justify-content-center">

      @for ($i = 0; $i < 6; $i++)
      <div class="col-md-4 mb-4">
        <div class="news-card">
          <div class="news-image">
            <img src="{{ asset('assets/img/informasi.png') }}" alt="informasi" class="img-fluid">
            <span class="badge-news">NEWS</span>
          </div>
          <div class="news-content d-flex">
            <img src="{{ asset('assets/img/logowi.png') }}" alt="Logo" class="logo-small">
            <div class="ms-3">
              <h5 class="fw-bold mt-1">
                SERAH TERIMA APLIKASI SISTEM INFORMASI AKADEMIK SMK WISATA INDONESIA HASIL KARYA MAHASISWA UNIVERSITAS BSI
              </h5>
              <p>
                Serah terima aplikasi karya mahasiswa Universitas Bina Sarana Informatika, resmi dilaksanakan pada Kamis, 27 Juni 2024 Pukul 08.00 WIB.
                Aplikasi Sistem Informasi Akademik SMK Wisata Indonesia...
              </p>
              <a href="#" class="read-more">Read More >></a>
              <div class="news-footer">
                <small class="text-muted">June 27, 2024 · No Comments</small>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endfor
    </div>
  </div>
</section>

@endsection

@push('styles')
<style>
/* === CARD DASAR === */
.news-card {
  background: #fff;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
  transition: transform 0.25s ease, box-shadow 0.25s ease;
  position: relative;
}

.news-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

/* === GAMBAR === */
.news-image {
  position: relative;
}

.news-image img {
  width: 100%;
  height: 200px;
  object-fit: cover;
  border-top-left-radius: 10px;
  border-top-right-radius: 10px;
}

/* === BADGE NEWS === */
.badge-news {
  position: absolute;
  top: 10px;
  right: 10px;
  background-color: #6B02B1;
  color: #fff;
  padding: 4px 10px;
  font-size: 12px;
  border-radius: 50px;
  font-weight: bold;
}

/* === LOGO KECIL DI SEBELAH KIRI TEKS === */
.logo-small {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  flex-shrink: 0;
  margin-top: -40px;
  margin-bottom: 10px;
  z-index: 2;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
  object-fit: cover;
}

/* === KONTEN === */
.news-content {
  padding: 20px;
}

.news-content h5 {
  font-size: 15px;
  line-height: 1.4;
}

.news-content p {
  font-size: 14px;
  color: #444;
  margin-top: 10px;
}

.read-more {
  display: inline-block;
  margin-top: 10px;
  color: #6B02B1;
  font-weight: 600;
  text-decoration: none;
  transition: color 0.2s;
}

.read-more:hover {
  color: #49027f;
}

.news-footer {
  border-top: 1px solid #eee;
  margin-top: 15px;
  padding-top: 10px;
  font-size: 13px;
  color: #777;
}
</style>
@endpush

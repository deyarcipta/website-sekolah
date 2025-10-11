@extends('layouts.frontend')

@section('title', 'Detail Informasi - SMK Wisata Indonesia Jakarta')

@section('content')

{{-- === Hero Section === --}}
@include('frontend.partials.hero', [
  'title' => 'Detail Informasi',
  'backgroundImage' => 'assets/img/foto-gedung.png',
  'height' => '200px'
])

<section class="detail-informasi py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-9">

        {{-- === Gambar Utama === --}}
        <div class="detail-image position-relative mb-4">
          <img src="{{ asset('assets/img/informasi.png') }}" alt="Gambar Informasi" class="img-fluid rounded-3 shadow-sm">
          <span class="badge-news">NEWS</span>
        </div>

        {{-- === Konten Utama === --}}
        <div class="detail-content mt-4">
          <h2 class="fw-bold text-purple mb-3">
            SERAH TERIMA APLIKASI SISTEM INFORMASI AKADEMIK SMK WISATA INDONESIA HASIL KARYA MAHASISWA UNIVERSITAS BSI
          </h2>

          <div class="text-muted mb-4">
            <small>June 27, 2024 · Admin SMK WI · No Comments</small>
          </div>

          <p>
            Serah terima aplikasi karya mahasiswa Universitas Bina Sarana Informatika, resmi dilaksanakan pada Kamis, 27 Juni 2024 pukul 08.00 WIB. 
            Acara ini diselenggarakan di Aula SMK Wisata Indonesia dan dihadiri oleh perwakilan sekolah serta tim pengembang dari UBSI.
          </p>

          <p>
            Aplikasi ini dikembangkan dengan tujuan untuk membantu digitalisasi proses administrasi akademik di SMK Wisata Indonesia. 
            Dengan adanya sistem ini, diharapkan manajemen data siswa, guru, dan nilai dapat dilakukan lebih efisien, cepat, dan akurat.
          </p>

          <p>
            Kepala Sekolah SMK Wisata Indonesia menyampaikan rasa terima kasih kepada mahasiswa UBSI atas kontribusinya dalam mendukung pengembangan sistem informasi di dunia pendidikan. 
            Beliau juga berharap kerja sama ini dapat terus berlanjut di masa mendatang.
          </p>

          <div class="mt-4">
            <a href="{{ url('/informasi') }}" class="btn-back">
              <i class="bi bi-arrow-left"></i> Kembali ke Daftar Informasi
            </a>
          </div>
        </div>

        {{-- === Garis Pembatas === --}}
        <hr class="my-5">

        {{-- === Bagian Informasi Lain === --}}
        <div class="related-section mt-5">
          <h4 class="fw-bold text-purple mb-5 text-center">Informasi Lainnya</h4>

          <div class="row gy-5 gx-4">
            @for ($i = 0; $i < 3; $i++)
            <div class="col-md-4">
              <div class="news-card">
                <div class="news-image">
                  <img src="{{ asset('assets/img/informasi.png') }}" alt="Informasi Lain" class="img-fluid">
                  <span class="badge-news">NEWS</span>
                </div>
                <div class="news-content">
                  <h5 class="fw-bold mt-2">Kegiatan Workshop Digitalisasi Sekolah</h5>
                  <p>SMK Wisata Indonesia melaksanakan workshop tentang digitalisasi pembelajaran ...</p>
                  <a href="#" class="read-more">Read More >></a>
                </div>
              </div>
            </div>
            @endfor
          </div>
        </div>

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
}

/* === LOGO KECIL === */
.logo-small {
  width: 65px;
  height: 65px;
  border-radius: 50%;
  margin-top: -35px;
  box-shadow: 0 3px 8px rgba(0,0,0,0.2);
  background: #fff;
  padding: 6px;
  object-fit: cover;
}

/* === KONTEN === */
.detail-content {
  font-size: 16px;
  color: #444;
  line-height: 1.8;
  text-align: justify;
}

.text-purple {
  color: #6B02B1;
}

/* === TOMBOL KEMBALI === */
.btn-back {
  display: inline-block;
  background-color: #6B02B1;
  color: #fff;
  padding: 10px 18px;
  border-radius: 8px;
  text-decoration: none;
  font-weight: 500;
  transition: background 0.3s;
}

.btn-back:hover {
  background-color: #4d0283;
  color: #fff;
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

/* === RESPONSIVE === */
@media (max-width: 768px) {
  .detail-image img {
    height: 250px;
  }

  .logo-small {
    width: 55px;
    height: 55px;
    margin-top: -25px;
  }

  .news-content h5 {
    font-size: 15px;
  }
}
</style>
@endpush

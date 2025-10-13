@extends('layouts.frontend')

@section('title', 'Kontak - SMK Wisata Indonesia Jakarta')

@section('content')

{{-- === Hero Section === --}}
@include('frontend.partials.hero', [
  'title' => 'Kontak',
  'backgroundImage' => 'assets/img/foto-gedung.png',
  'height' => '200px'
])

{{-- === Konten Pembuka === --}}
<section class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-12">
        <p class="text-center mb-1 mt-4" style="padding: 0px 25px; font-size: 20px;">
          SMK Wisata Indonesia menyambut Anda atas saran dan masukan yang berharga. Jangan ragu untuk<br>menghubungi kami di alamat yang disebutkan di bawah ini.
        </p>

        <div class="line-with-star">
          <span>★</span>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="container">
  <div class="row align-items-center flex-row-reverse mb-5">
    <div class="col-lg-4 d-flex justify-content-center position-relative mb-4 mb-lg-0">
      <div class="maps-kontak">
        <iframe 
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.6338566938543!2d106.83336617402644!3d-6.31173736176519!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69edee70aeb597%3A0x3c33aa85fd86d917!2sSMK%20WISATA%20INDONESIA%20%7BSekolah%20Menengah%20Kejuruan%7D!5e0!3m2!1sid!2sid!4v1760179549082!5m2!1sid!2sid" 
          allowfullscreen="" loading="lazy"
          referrerpolicy="no-referrer-when-downgrade">
        </iframe>
      </div>
    </div>
    <div class="col-lg-4 d-flex justify-content-center position-relative mb-4 mb-lg-0">
      <div class="img-kontak">
        <img src="/assets/img/gambar-kontak.png" alt="Gambar Kontak">
      </div>
    </div>
    <div class="col-lg-4 px-5">
      <h1 class="fw-bold text-purple mb-2">Alamat Kami</h1>
      <h4>
        Berikut merupakan data lengkap alamat dan nomor SMK Wisata Indonesia yang bisa kalian hubungi
      </h4>
      <div class="kontak-sekolah">
        <h5 class="text-center mt-5 mb-2">SMK Wisata Indonesia</h5>
        <div class="info-item">
          <i class="bi bi-geo-alt-fill"></i>
          <span>
            JL. Raya Lenteng Agung / Jl. Langgar<br>
            Rt. 009/003 No. 1, Kebagusan,<br>
            Ps. Minggu, Jakarta Selatan, 12520
          </span>
        </div>        

        <div class="info-item">
          <i class="bi bi-telephone-fill"></i>
          <span>(021) 78830761</span>
        </div>

        <div class="info-item">
          <i class="bi bi-envelope-fill"></i>
          <span>smkwisataindonesia01@gmail.com</span>
        </div>
      </div>
    </div>
  </div>
</section>

<section style="background-color: #F4E8FC; padding: 50px 0;">
  <div class="container">
    <h1 class="fw-bold text-center">Staff Contacts</h1>
    <p class="text-center mb-3" style="padding: 0px 25px; font-size: 20px;">
      For admission and financial aid related queries, <br>you can directly contact our staff members mentioned below
    </p>
    <div class="purple-line mb-4"></div>
    <div class="row g-5">
      <div class="col-lg-6 d-flex justify-content-end position-relative mb-3 mb-lg-0">
        <div class="card kepala-card shadow-sm">
          <img src="/assets/img/foto-guru.png" class="card-img-top" alt="Staff 1">
          <div class="card-body d-flex flex-column justify-content-end">
            <h5 class="card-title mb-1 fw-bold">Dewi Lestari, S.Pd.</h5>
            <p class="card-text mb-0">Wakil Bid. Kesiswaan & Pembina Osis</p>
            <div class="staff-item mt-3">
              <i class="bi bi-telephone-fill"></i>
              <span>+62 852-1815-0720</span>
            </div>
            <div class="staff-item">
              <i class="bi bi-envelope-fill"></i>
              <span>smkwisataindonesia01@gmail.com</span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6 d-flex justify-content-start position-relative mb-3 mb-lg-0">
        <div class="card kepala-card shadow-sm">
          <img src="/assets/img/foto-guru.png" class="card-img-top" alt="Staff 2">
          <div class="card-body d-flex flex-column justify-content-end">
            <h5 class="card-title mb-1 fw-bold">Dewi Lestari, S.Pd.</h5>
            <p class="card-text mb-0">Wakil Bid. Kesiswaan & Pembina Osis</p>
            <div class="staff-item mt-3">
              <i class="bi bi-telephone-fill"></i>
              <span>+62 852-1815-0720</span>
            </div>
            <div class="staff-item">
              <i class="bi bi-envelope-fill"></i>
              <span>smkwisataindonesia01@gmail.com</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section-bg-overlay">
  <div class="container">
    <h1 class="fw-bold text-center mb-3 social">Let's get Social</h1>
    <p class="text-center mb-4" style="padding: 0px 25px; font-size: 20px;">
      We'd love to hear from you on our social networks.<br>
      Morbi volutpat justo sed efficitur cursus fringilla quam vitae lacinia viverra.
    </p>

    <div class="social-links d-flex justify-content-center gap-2">
      <a href="https://facebook.com" target="_blank" class="social-icon facebook">
        <i class="bi bi-facebook"></i>
      </a>
      <a href="https://instagram.com" target="_blank" class="social-icon instagram">
        <i class="bi bi-instagram"></i>
      </a>
      <a href="https://youtube.com" target="_blank" class="social-icon youtube">
        <i class="bi bi-youtube"></i>
      </a>
    </div>
  </div>
</section>


@endsection

@push('styles')
<style>
.maps-kontak {
  width: 300px;
  height: 500px;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.maps-kontak iframe {
  width: 100%;
  height: 100%;
  border: 0;
}

.img-kontak {
  text-align: center;
  margin: 20px auto;
}

.img-kontak img {
  width: 300px;
  height: 500px;
  object-fit: cover;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease;
  display: block;
  margin: 0 auto;
}

.img-kontak img:hover {
  transform: scale(1.03);
}

.text-purple {
  color: #6B02B1;
}

.kontak-sekolah {
  font-family: 'Poppins', sans-serif;
  color: #000;
  font-size: 14px;
  line-height: 1.6;
  max-width: 320px;
}

.kontak-sekolah .info-item {
  display: flex;
  align-items: center;
  margin-bottom: 8px;
}

.kontak-sekolah .info-item i {
  font-size: 16px;
  margin-right: 8px;
}

.purple-line {
  border: none;
  height: 4px;
  background-color: #6B02B1 !important;
  border-radius: 4px;
  width: 75px;
  margin: 0 auto;
  opacity: 1;
}

/* === CARD STAFF === */
.kepala-card {
  border: none;
  overflow: hidden;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  background-color: #fff;
  display: flex;
  flex-direction: column;
  align-items: center;
  height: 480px;             /* 🔹 Tinggi sesuai permintaan */
  width: 350px;              /* 🔹 Lebar sesuai permintaan */
  border-radius: 0 !important;
}

.kepala-card img {
  width: 100%;
  height: 400px;             /* Gambar proporsional dengan tinggi card */
  object-fit: cover;
  border-radius: 0 !important;
}

.kepala-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 6px 15px rgba(107, 2, 177, 0.15);
}

.kepala-card .card-body {
  background-color: #fff;
  padding: 16px;
  border-top: 1px solid rgba(107, 2, 177, 0.15);
  flex-grow: 1;
  display: flex;
  flex-direction: column;
  /* justify-content: center;
  align-items: center; */
  /* text-align: center; */
  width: 100%;
}

.kepala-card .card-title {
  color: #000;
  font-size: 1.2rem;
  font-weight: 700;
  margin-bottom: 6px;
}

.kepala-card .card-text {
  color: #000;
  font-size: 0.9rem;
}

.staff-item {
  display: flex;
  align-items: center;
  margin-bottom: 8px;
  color: #6b6b6b;
  font-size: 14px;
}

.staff-item i {
  font-size: 14px;
  margin-right: 15px;
}

.section-bg-overlay {
  position: relative;
  background: 
    linear-gradient(rgba(107, 2, 177, 0.45), rgba(107, 2, 177, 0.45)),
    url('/assets/img/gambar-kontak2.png') no-repeat center;
  background-size: cover;
  background-position: center top; /* Geser gambar ke bawah */
  background-attachment: scroll; /* Bisa diganti fixed untuk efek parallax */
  padding: 50px 0;
  margin-bottom: 75px;
  color: #fff;
}

/* === SOSIAL MEDIA === */
.social-links {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 28px;
  margin-top: 20px;
}

.social-links a {
  font-size: 38px;                 /* Lebih besar dari sebelumnya */
  color: #fff;                     /* Ikon putih */
  width: 70px;                     /* Tambahkan area klik */
  height: 70px;
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 50%;              /* Bentuk lingkaran */
  transition: all 0.3s ease;
  text-decoration: none;
}

/* Efek hover keren */
.social-links a:hover {
  background-color: rgba(107, 2, 177, 0.25); /* Latar ungu transparan */
  color: #fff;                               /* Tetap putih */
  transform: scale(1.15);                    /* Membesar sedikit */
  box-shadow: 0 0 15px rgba(107, 2, 177, 0.5); /* Glow ungu lembut */
}

/* Opsional: efek warna spesifik per platform */
.social-links .facebook:hover {
  background-color: rgba(59, 89, 152, 0.3);
}

.social-links .instagram:hover {
  background-color: rgba(225, 48, 108, 0.3);
}

.social-links .youtube:hover {
  background-color: rgba(255, 0, 0, 0.3);
}

@media (max-width: 768px) {
  .kontak-sekolah h5{
    font-size: 16px;
    font-weight: 500 !important;
  }

  .maps-kontak {
    width: 80%;
    height: 400px;
    margin: 0 auto;
  }

  .img-kontak img {
    width: 80%;
    height: auto;
  }

    .row.g-5 {
    justify-content: center !important;
  }

  .kepala-card {
    width: 85%;
    height: auto;
    margin: 0 auto; /* Tengah horizontal */
  }

  .social P{
    font-size: 16px; /* Ukuran font lebih kecil di versi mobile */
  }

  .social-links a {
    font-size: 30px;                 /* Ukuran ikon lebih kecil di versi mobile */
    width: 60px;                     /* Area klik sedikit lebih kecil */
    height: 60px;
  }
}
</style>
@endpush

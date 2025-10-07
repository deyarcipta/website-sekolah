@extends('layouts.frontend')

@section('title', 'Home - SMK Wisata Indonesia Jakarta')

@section('content')
<section id="hero" class="pd-top-100 pd-bottom-100 d-flex align-items-center">
  <div class="container">
    <div class="img-mockup">
      <img src="{{ asset('assets/img/rectangle.svg') }}" alt="Rectangle Image" class="img-custom" />
    </div>
    <div class="row">
      <div class="col-md-6 .col-lg-6 d-flex flex-column justify-content-center">
        <div class="hero-text">
          <h1>Selamat Datang di <br>SMK Wisata Indonesia Jakarta</h1>
          <p>SMK Pusat Keunggulan di Jakarta Selatan yang menerapkan kedisiplinan.</p>
          <a href="#" class="btn btn-join-now">Join Now</a>
        </div>
      </div>
      <div class="col-md-6 .col-lg-6 d-flex flex-column justify-content-center">
        <div class="hero-imgs">
          <img src="{{ asset('assets/img/hero.png') }}" alt="Hero Image" class="w-100 h-100" style="object-fit: cover;" />
        </div>
      </div>
    </div>
  </div>
</section>

<section id="alasan" class="pd-top-50 pd-bottom-50">
  <div class="container">
    <div class="section-title text-center">
      <h1>Kenapa harus wistin ?</h1>
      <p>Alasan kenapa kalian harus bergabung bersama kami</p>
    </div>
    <div class="row">
      <div class="col-md-3 mb-3">
        <div class="card h-100 custom-card text-center">
          <img src="{{ asset('assets/img/akreditasi.png') }}" class="card-img-top mx-auto d-block" alt="Keunggulan 1">
          <div class="card-body">
            <h5 class="card-title">Akreditasi A</h5>
            <p class="card-text">Terakreditasi A untuk semua program keahlian</p>
          </div>
        </div>
      </div>
      <div class="col-md-3 mb-3">
        <div class="card h-100 custom-card text-center">
          <img src="{{ asset('assets/img/fasilitas.png') }}" class="card-img-top mx-auto d-block" alt="Keunggulan 1">
          <div class="card-body">
            <h5 class="card-title">Fasilitas Lengkap</h5>
            <p class="card-text">Sarana dan prasarana yang mendukung pemberlajaran</p>
          </div>
        </div>
      </div>
      <div class="col-md-3 mb-3">
        <div class="card h-100 custom-card text-center">
          <img src="{{ asset('assets/img/guru.png') }}" class="card-img-top mx-auto d-block" alt="Keunggulan 1">
          <div class="card-body">
            <h5 class="card-title">Guru Profesional</h5>
            <p class="card-text">Tenaga pengajar yang <i>up-to-date</i>, berpengalaman dan tersertifikasi</p>
          </div>
        </div>
      </div>
      <div class="col-md-3 mb-3">
        <div class="card h-100 custom-card text-center">
          <img src="{{ asset('assets/img/lingkungan.png') }}" class="card-img-top mx-auto d-block" alt="Keunggulan 1">
          <div class="card-body">
            <h5 class="card-title">Lingkungan Nyaman</h5>
            <p class="card-text">Lingkungan yang nyaman dalam proses pembelajaran</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="programs-card">
  <div class="container">
    <div class="section-title text-center mb-5">
      <h2>Program Keahlian</h2>
      <h1>Konsesntrasi Keahlian</h1>
      <hr class="mx-auto">
    </div>
    <div class="row">
      <div class="col-md-4 mb-4">
        <div class="card h-100 custom-card text-center">
          <img src="{{ asset('assets/img/kuliner.png') }}" class="card-img-top mx-auto d-block" alt="Kuliner">
          <div class="card-body">
            <h5 class="card-title">Kuliner</h5>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card h-100 custom-card text-center">
          <img src="{{ asset('assets/img/perhotelan.png') }}" class="card-img-top mx-auto d-block" alt="Perhotelan">
          <div class="card-body">
            <h5 class="card-title">Perhotelan</h5>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card h-100 custom-card text-center">
          <img src="{{ asset('assets/img/tkj.png') }}" class="card-img-top mx-auto d-block" alt="Teknik Komputer dan Jaringan">
          <div class="card-body">
            <h5 class="card-title">Teknik Komputer dan Jaringan</h5>
          </div>
        </div>
      </div>
</section>

<section id="programs">
  <div class="container">
    <div class="row gx-md-5 gx-2">
      <div class="col-md-6">
        <h1>Kuliner</h1>
        <p>Mempelajari seni dan teknik memasak, manajemen dapur, serta tata saji makanan dan minuman untuk industri restoran dan perhotelan.</p>
        <div class="accordion" id="accordionExampleKuliner">
          <!-- Collapse 1 (Aktif) -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingOneKuliner">
              <button class="accordion-button" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseOneKuliner" aria-expanded="true" aria-controls="collapseOneKuliner">
                <i class="fas fa-bowl-rice me-2 text-danger custom-icon"></i>
                Dasar Memasak
              </button>
            </h2>
            <div id="collapseOneKuliner" class="accordion-collapse collapse show" aria-labelledby="headingOneKuliner" data-bs-parent="#accordionExampleKuliner">
              <div class="accordion-body">
                Siswa nantinya akan belajar dan dituntut untuk mampu mengolah berbagai jenis makanan dan minuman sesuai standar industri kuliner.
              </div>
            </div>
          </div>

          <!-- Collapse 2 -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwoKuliner">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseTwoKuliner" aria-expanded="false" aria-controls="collapseTwoKuliner">
                <i class="fas fa-cake-candles me-2 text-danger custom-icon"></i>
                Manajemen Dapur Profesional
              </button>
            </h2>
            <div id="collapseTwoKuliner" class="accordion-collapse collapse" aria-labelledby="headingTwoKuliner"
              data-bs-parent="#accordionExampleKuliner">
              <div class="accordion-body">
                Siswa nantinya akan belajar dan dituntut untuk mampu mengolah berbagai jenis makanan dan minuman sesuai standar industri kuliner.
              </div>
            </div>
          </div>

          <!-- Collapse 3 -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingThreeKuliner">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseThreeKuliner" aria-expanded="false" aria-controls="collapseThreeKuliner">
                <i class="fas fa-briefcase me-2 text-danger custom-icon"></i>
                Kesempatan Kerja
              </button>
            </h2>
            <div id="collapseThreeKuliner" class="accordion-collapse collapse" aria-labelledby="headingThreeKuliner"
              data-bs-parent="#accordionExampleKuliner">
              <div class="accordion-body">
                Siswa nantinya akan belajar dan dituntut untuk mampu mengolah berbagai jenis makanan dan minuman sesuai standar industri kuliner.
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 d-none d-md-block position-relative p-0">
        <img src="{{ asset('assets/img/kuliner-program.png') }}" alt="Kuliner" class="img-fluid ">
      </div>
    </div>
    <div class="row gx-md-5 gx-2">
      <div class="col-md-6 d-none d-md-block ">
        <img src="{{ asset('assets/img/perhotelan-program.png') }}" alt="Kuliner" class="img-fluid">
      </div>
      <div class="col-md-6">
        <h1>Perhotelan</h1>
        <p>Mempelajari pelayanan dan pengelolaan operasional hotel, termasuk front office, housekeeping, food & beverage service, serta keterampilan komunikasi dan pelayanan prima sesuai standar industri perhotelan.</p>
        <div class="accordion" id="accordionExamplePerhotelan">
          <!-- Collapse 1 (Aktif) -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingOnePerhotelan">
              <button class="accordion-button" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseOnePerhotelan" aria-expanded="true" aria-controls="collapseOnePerhotelan">
                <i class="fas fa-hotel me-2 text-danger custom-icon"></i>
                Manajemen Hotel
              </button>
            </h2>
            <div id="collapseOnePerhotelan" class="accordion-collapse collapse show" aria-labelledby="headingOnePerhotelan" data-bs-parent="#accordionExamplePerhotelan">
              <div class="accordion-body">
                Siswa nantinya akan belajar dan dituntut untuk mampu melakukan Pelayanan dan pengelolaan operasional hotel berbasis standar industri
              </div>
            </div>
          </div>

          <!-- Collapse 2 -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwoPerhotelan">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseTwoPerhotelan" aria-expanded="false" aria-controls="collapseTwoPerhotelan">
                <i class="fas fa-bed me-2 text-danger custom-icon"></i>
                House Keeping
              </button>
            </h2>
            <div id="collapseTwoPerhotelan" class="accordion-collapse collapse" aria-labelledby="headingTwoPerhotelan" data-bs-parent="#accordionExamplePerhotelan">
              <div class="accordion-body">
                Siswa nantinya akan belajar dan dituntut untuk mampu mengolah berbagai jenis makanan dan minuman sesuai standar industri kuliner.
              </div>
            </div>
          </div>

          <!-- Collapse 3 -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingThreePerhotelan">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseThreePerhotelan" aria-expanded="false" aria-controls="collapseThreePerhotelan">
                <i class="fas fa-briefcase me-2 text-danger custom-icon"></i>
                Kesempatan Kerja
              </button>
            </h2>
            <div id="collapseThreePerhotelan" class="accordion-collapse collapse" aria-labelledby="headingThreePerhotelan" data-bs-parent="#accordionExamplePerhotelan">
              <div class="accordion-body">
                Siswa nantinya akan belajar dan dituntut untuk mampu mengolah berbagai jenis makanan dan minuman sesuai standar industri kuliner.
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row gx-md-5 gx-2">
      <div class="col-md-6">
        <h1>Teknik Komputer dan Jaringan</h1>
        <p>Mempelajari seni dan teknik memasak, manajemen dapur, serta tata saji makanan dan minuman untuk industri restoran dan perhotelan.</p>
        <div class="accordion" id="accordionExampleTkj">
          <!-- Collapse 1 (Aktif) -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingOneTkj">
              <button class="accordion-button" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseOneTkj" aria-expanded="true" aria-controls="collapseOneTkj">
                <i class="fas fa-network-wired me-2 text-danger custom-icon"></i>
                Dasar Teknik Komputer & Jaringan
              </button>
            </h2>
            <div id="collapseOneTkj" class="accordion-collapse collapse show" aria-labelledby="headingOneTkj" data-bs-parent="#accordionExampleTkj">
              <div class="accordion-body">
                Siswa nantinya akan belajar dan dituntut untuk mampu mengolah berbagai jenis makanan dan minuman sesuai standar industri kuliner.
              </div>
            </div>
          </div>

          <!-- Collapse 2 -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwoTkj">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseTwoTkj" aria-expanded="false" aria-controls="collapseTwoTkj">
                <i class="fas fa-desktop me-2 text-danger custom-icon"></i>
                Administrasi Server
              </button>
            </h2>
            <div id="collapseTwoTkj" class="accordion-collapse collapse" aria-labelledby="headingTwoTkj"
              data-bs-parent="#accordionExampleTkj">
              <div class="accordion-body">
                Siswa nantinya akan belajar dan dituntut untuk mampu mengolah berbagai jenis makanan dan minuman sesuai standar industri kuliner.
              </div>
            </div>
          </div>

          <!-- Collapse 3 -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingThreeTkj">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseThreeTkj" aria-expanded="false" aria-controls="collapseThreeTkj">
                <i class="fas fa-briefcase me-2 text-danger custom-icon"></i>
                Kesempatan Kerja
              </button>
            </h2>
            <div id="collapseThreeTkj" class="accordion-collapse collapse" aria-labelledby="headingThreeTkj"
              data-bs-parent="#accordionExampleTkj">
              <div class="accordion-body">
                Siswa nantinya akan belajar dan dituntut untuk mampu mengolah berbagai jenis makanan dan minuman sesuai standar industri kuliner.
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 d-none d-md-block position-relative p-0">
        <img src="{{ asset('assets/img/kuliner-program.png') }}" alt="Kuliner" class="img-fluid ">
      </div>
    </div>
  </div>
</section>

<section id="konten-utama">
  <div class="container">
    <div class="row">
      <!-- Section Berita Sekolah (8 kolom) -->
      <div class="col-md-8 mb-4 mb-md-0">
        <section id="berita-sekolah" class="p-4 bg-light rounded">
          <h1 class="mb-3">Berita Sekolah</h1>
          <hr class="garis">
          <div class="row">
            <!-- Card 1 -->
            <div class="col-md-6 mb-3">
              <a href="#">
              <div class="card berita-card text-white mb-3">
                <div class="berita-img" style="background-image: url('{{ asset('assets/img/home-decor-1.jpg') }}');">
                  <div class="berita-overlay d-flex align-items-end p-3">
                    <div>
                      <h5 class="card-title">Judul Berita 1</h5>
                      <p class="card-text">Isi singkat berita pertama yang akan ditampilkan kepada pengunjung.</p>
                    </div>
                  </div>
                </div>
              </div>
              </a>
            </div>

            <!-- Card 2 -->
            <div class="col-md-6 mb-3">
              <a href="#">
              <div class="card berita-card text-white mb-3">
                <div class="berita-img" style="background-image: url('{{ asset('assets/img/home-decor-1.jpg') }}');">
                  <div class="berita-overlay d-flex align-items-end p-3">
                    <div>
                      <h5 class="card-title">Judul Berita 2</h5>
                      <p class="card-text">Isi singkat berita kedua yang akan ditampilkan kepada pengunjung.</p>
                    </div>
                  </div>
                </div>
              </div>
              </a>
            </div>

            <!-- Card 3 -->
            <div class="col-md-6 mb-3">.
              <a href="#">
              <div class="card berita-card text-white mb-3">
                <div class="berita-img" style="background-image: url('{{ asset('assets/img/home-decor-1.jpg') }}');">
                  <div class="berita-overlay d-flex align-items-end p-3">
                    <div>
                      <h5 class="card-title">Judul Berita 3</h5>
                      <p class="card-text">Isi singkat berita ketiga yang akan ditampilkan kepada pengunjung.</p>
                    </div>
                  </div>
                </div>
              </div>
              </a>
            </div>

            <!-- Card 3 -->
            <div class="col-md-6 mb-3">.
              <a href="#">
              <div class="card berita-card text-white mb-3">
                <div class="berita-img" style="background-image: url('{{ asset('assets/img/home-decor-1.jpg') }}');">
                  <div class="berita-overlay d-flex align-items-end p-3">
                    <div>
                      <h5 class="card-title">Judul Berita 3</h5>
                      <p class="card-text">Isi singkat berita ketiga yang akan ditampilkan kepada pengunjung.</p>
                    </div>
                  </div>
                </div>
              </div>
              </a>
            </div>
          </div>
          <a href="#" class="btn all-berita">Lihat Semua Berita</a>
        </section>
      </div>

      <!-- Section Agenda Sekolah (4 kolom) -->
      <div class="col-md-4">
        <section id="agenda-sekolah" class="p-4 bg-white border rounded h-100">
          <h1 class="mb-3">Agenda Sekolah</h1>
          <hr class="garis">

          <ul class="list-unstyled">
            <!-- Item Agenda -->
            <li class="d-flex gap-3 mb-4">
              <!-- Kotak Tanggal -->
              <div class="agenda-date flex-shrink-0">
                <div class="agenda-month">Jun 2025</div>
                <div class="agenda-day">15</div>
              </div>

              <!-- Teks Agenda -->
              <div class="agenda-content">
                <strong>Assessment Sumatif Akhir Sekolah yang judulnya sangat panjang dan bisa dua baris atau lebih tapi tetap sejajar atas</strong>
              </div>
            </li>

            <li class="d-flex gap-3 mb-4">
              <!-- Kotak Tanggal -->
              <div class="agenda-date flex-shrink-0">
                <div class="agenda-month">Jun 2025</div>
                <div class="agenda-day">15</div>
              </div>

              <!-- Teks Agenda -->
              <div class="agenda-content">
                <strong>Assessment Sumatif Akhir Sekolah yang judulnya sangat panjang dan bisa dua baris atau lebih tapi tetap sejajar atas</strong>
              </div>
            </li>

            <li class="d-flex gap-3 mb-4">
              <!-- Kotak Tanggal -->
              <div class="agenda-date flex-shrink-0">
                <div class="agenda-month">Jun 2025</div>
                <div class="agenda-day">15</div>
              </div>

              <!-- Teks Agenda -->
              <div class="agenda-content">
                <strong>Assessment Sumatif Akhir Sekolah</strong>
              </div>
            </li>

            <li class="d-flex gap-3 mb-4">
              <!-- Kotak Tanggal -->
              <div class="agenda-date flex-shrink-0">
                <div class="agenda-month">Jun 2025</div>
                <div class="agenda-day">15</div>
              </div>

              <!-- Teks Agenda -->
              <div class="agenda-content">
                <strong>Assessment Sumatif Akhir Sekolah</strong>
              </div>
            </li>

            <li class="d-flex gap-3 mb-4">
              <!-- Kotak Tanggal -->
              <div class="agenda-date flex-shrink-0">
                <div class="agenda-month">Jun 2025</div>
                <div class="agenda-day">15</div>
              </div>

              <!-- Teks Agenda -->
              <div class="agenda-content">
                <strong>Assessment Sumatif Akhir Sekolah yang judulnya sangat panjang dan bisa dua baris atau lebih tapi tetap sejajar atas</strong>
              </div>
            </li>
          </ul>
        </section>
      </div>
    </div>
  </div>
</section>

<section id="galery" class="py-5 bg-purple">
  <div class="container-fluid px-0">
    <div class="section-title text-center mb-4">
      <h2>Yuk, Lihat lebih dekat aktifitas dari wistin</h2>
      <h1>Galeri Foto Aktivitas Wistin</h1>
    </div>

    <!-- Swiper -->
    <div class="swiper galerySwiper">
      <div class="swiper-wrapper">
        <!-- Slide 1 -->
        <div class="swiper-slide">
          <a href="" class="image-overlay-wrapper">
            <img src="{{ asset('assets/img/carousel-1.jpg') }}" class="img-fluid w-100" alt="Gallery 1">
            <div class="overlay">
              <div class="overlay-text">Judul Gambar 1</div>
            </div>
          </a>
        </div>
        <!-- Slide 2 -->
        <div class="swiper-slide">
          <a href="" class="image-overlay-wrapper">
            <img src="{{ asset('assets/img/carousel-2.jpg') }}" class="img-fluid w-100" alt="Gallery 1">
            <div class="overlay">
              <div class="overlay-text">Judul Gambar 2</div>
            </div>
          </a>
        </div>
        <!-- Slide 3 -->
        <div class="swiper-slide">
          <a href="" class="image-overlay-wrapper">
            <img src="{{ asset('assets/img/carousel-3.jpg') }}" class="img-fluid w-100" alt="Gallery 1">
            <div class="overlay">
              <div class="overlay-text">Judul Gambar 3</div>
            </div>
          </a>
        </div>
        <!-- Slide 4 -->
        <div class="swiper-slide">
          <a href="" class="image-overlay-wrapper">
            <img src="{{ asset('assets/img/home-decor-1.jpg') }}" class="img-fluid w-100" alt="Gallery 1">
            <div class="overlay">
              <div class="overlay-text">Judul Gambar 4</div>
            </div>
          </a>
        </div>
        <div class="swiper-slide">
          <a href="" class="image-overlay-wrapper">
            <img src="{{ asset('assets/img/home-decor-2.jpg') }}" class="img-fluid w-100" alt="Gallery 1">
            <div class="overlay">
              <div class="overlay-text">Judul Gambar 5</div>
            </div>
          </a>
        </div>
        <!-- Tambah slide lainnya -->
      </div>

      <!-- Pagination -->
      <div class="swiper-pagination"></div>

      <!-- Navigation -->
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>
    </div>
  </div>
</section>

<section id="testimoni">
  <div class="container">
    <div class="swiper alumniSwiper">
      <div class="swiper-wrapper">

        <!-- Slide 1 -->
        <div class="swiper-slide">
          <div class="row align-items-center">
            <!-- Kiri: Text -->
            <div class="col-md-7 textAlumni">
              <h4 class="fw-bold mb-3">Apa Kata Alumni?</h4>
              <p class="mb-3">
                SMK Wisata Indonesia mengajarkanku lebih dari sekadar teori—pengalaman magang di hotel bintang 5 membentukku menjadi profesional siap kerja. Terima kasih, guru-guruku!
              </p>
              <p class="fw-medium">Ilham Muhammad Alamsyah (SMK Wisata Indonesia)</p>
            </div>
            <!-- Kanan: Gambar -->
            <div class="col-md-5 d-flex align-items-center justify-content-center">
              <img src="{{ asset('assets/img/team-1.jpg') }}" alt="Ilham Muhammad Alamsyah"
                class="img-fluid rounded-4 shadow" >
            </div>
          </div>
        </div>

        <!-- Slide 2 -->
        <div class="swiper-slide">
          <div class="row align-items-center">
            <div class="col-md-7 textAlumni">
              <h4 class="fw-bold mb-3">Apa Kata Alumni?</h4>
              <p class="mb-3">
                Pembelajaran di SMK WI membuat saya percaya diri menghadapi dunia kerja. Banyak praktik nyata yang saya alami langsung.
              </p>
              <p class="fw-medium">Putri Anjani (SMK WI - Perhotelan)</p>
            </div>
            <div class="col-md-5 text-center">
              <img src="{{ asset('assets/img/team-2.jpg') }}" alt="Putri Anjani"
                class="img-fluid rounded-4 shadow">
            </div>
          </div>
        </div>

        <!-- Slide 3 -->
        <div class="swiper-slide">
          <div class="row align-items-center">
            <div class="col-md-7 textAlumni">
              <h4 class="fw-bold mb-3">Apa Kata Alumni?</h4>
              <p class="mb-3">
                Pembelajaran di SMK WI membuat saya percaya diri menghadapi dunia kerja. Banyak praktik nyata yang saya alami langsung.
              </p>
              <p class="fw-medium">Putri Anjani (SMK WI - Perhotelan)</p>
            </div>
            <div class="col-md-5 text-center">
              <img src="{{ asset('assets/img/team-3.jpg') }}" alt="Putri Anjani"
                class="img-fluid rounded-4 shadow">
            </div>
          </div>
        </div>

        <!-- Tambah slide lain jika perlu -->

      </div>

      <!-- Optional pagination -->
      <div class="swiper-pagination"></div>
    </div>
  </div>
</section>
@endsection

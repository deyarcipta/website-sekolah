@extends('layouts.frontend')

@section('title', 'Jurusan - SMK Wisata Indonesia Jakarta')

@section('content')

{{-- === Hero Section dengan background gedung dan warna ungu A948EA transparan === --}}
@include('frontend.partials.hero', [
  'title' => 'Jurusan',
  'backgroundImage' => 'assets/img/foto-gedung.png',
  'height' => '200px'
])

{{-- === Bagian Penjelasan Jurusan === --}}
<section class="container" style="margin-top: 100px;">
  <div class="row align-items-center flex-row-reverse mb-5">

    {{-- FOTO (KANAN) --}}
    <div class="col-lg-6 d-flex justify-content-center position-relative mb-4 mb-lg-0">
      <div class="photo-wrapper photo-down mt-4"> {{-- Tambahkan margin top agar lebih turun --}}
        <img src="/assets/img/jurusan-tkj.png" alt="Gedung Sarpras" class="img-fluid rounded custom-img">
      </div>
    </div>

    {{-- TEKS (KIRI) --}}
    <div class="col-lg-6" style="padding: 0px 30px;">
      <h1 class="fw-bold text-purple mb-2">Teknik Jaringan Komputer & Telekomunikasi</h1>
      <p class="mb-2 fw-semibold">
        Teknik Jaringan Komputer dan Telekomunikasi merupakan kompetensi keahlian yang berfokus pada jaringan, komputer, dan server.
      </p>
      <div class="features-list">
        <p class="mb-1">
          Kompetensi keahlian Teknik Jaringan Komputer dan Telekomunikasi memiliki tujuan sebagai berikut:
        </p>
        <ul class="numbered-list">
          <li>Mendidik peserta didik agar dapat bekerja baik secara mandiri atau mengisi lowongan pekerjaan yang ada di dunia usaha dan dunia industri sebagai tenaga kerja profesional.</li>
          <li>Mendidik peserta didik agar mampu memilih karir, berkompetisi, dan mengembangkan sikap profesional dalam program keahlian Komputer dan Jaringan.</li>
          <li>Membekali peserta didik dengan ilmu pengetahuan dan keterampilan sebagai bekal bagi yang berminat untuk melanjutkan pendidikan.</li>
        </ul>
        <!-- Tombol Mari Bergabung -->
        <a href="#daftar" class="btn-bergabung mt-3">
          Mari Bergabung
          <span class="arrow">→</span>
        </a>
      </div>
    </div>

  </div>
</section>

{{-- === Bagian Prestasi (background ungu muda) === --}}
<section style="background-color: #F4E8FC; margin-bottom: 75px; padding: 75px 0;">
  <div class="container">
    <h1 class="fw-bold text-center">Prestasi</h1>
    <div>
      <hr class="purple-line mb-5">
    </div>
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
  </div>
</section>

{{-- === Bagian Visi & Misi === --}}
<section class="container">
  <div class="row flex-row-reverse mb-5">

    {{-- FOTO (KANAN) --}}
    <div class="col-lg-6">
      <div class="photo-wrapper photo-down">
        <img src="/assets/img/praktek.png" alt="Praktek" class="img-fluid rounded custom-img-quote">
        <p class="text-quote">Karakter utama dari orang yang sukses adalah keberanian dan komitmen mereka untuk terus maju tanpa takut halangan. Tidak ada jaminan sebuah kesuksesan bagi seorang yang tidak keluar dari zona nyamannya dan takut mengambil risiko.</p>
        <hr class="purple-line purple-line-left mb-3">
        <div>
          <h4 class="fw-semibold mb-0" style="line-height: 1;">Mark Zuckerberg</h4>
          <span style="font-size: 10px; margin-top: 0px; line-height: 1;">CEO Meta</span>
        </div>
        
      </div>
    </div>

    {{-- TEKS (KIRI) --}}
    <div class="col-lg-6" style="padding: 0px 30px;">
      <h1 class="fw-bold text-purple mb-2">Visi & Misi</h1>
      <p class="mb-2 fw-semibold">
        Terwujudnya Sumber Daya Manusia yang professional dalam bidang Teknik Informatika sesuai dengan tuntutan dunia industry dengan etos kerja yang tinggi dengan dilandasi akhlak yang baik.
      </p>
      <div class="features-list">
        <ul class="bullet-list">
          <li>Menghasilkan tamatan yang berkualitas, terampil dan potensial di bidang Teknik Komputer dan Jaringan.</li>
          <li>Menyelenggarakan program pendidikan profesional di bidang IT dan mampu menjawab tantangan serta perubahan kemajuan ilmu dan teknologi.</li>
          <li>Meningkatkan kerjasama dengan DU/DI di bidang Teknik Komputer dan Jaringan.</li>
          <li>Menjadikan peserta didik memiliki kreativitas dan inovasi sehingga dapat mengembangkan diri dalam bidang IT.</li>
          <li>Mengembangkan fasilitas dan alat media pembelajaran berbasis PBL (Project Based Learning).</li>
          <li>Menghasilkan lulusan tepat waktu yang mampu bersaing di dunia industri.</li>
        </ul>
      </div>
    </div>

  </div>
</section>

{{-- === Bagian Tim Pengajar (background ungu muda) === --}}
<section style="background-color: #F4E8FC; margin-bottom: 75px; padding: 75px 0;">
  <div class="container">
    <h1 class="fw-bold text-center">Tim Pengajar</h1>
    <div>
      <hr class="purple-line mb-5">
    </div>
    <div class="col-lg-12">
      <p class="text-center mb-1 fw-semibold" style="padding: 0px 25px; font-size: 20px;">
          Teknik jaringan komputer dan telekomunikasi memiliki tim pengajar yang profesional untuk<br>melahirkan siswa yang unggul dan siap bersaing di dunia industri.
      </p>
    
    {{-- === Tim Pengajar === --}}
      <div class="row g-4 justify-content-center  mt-4">
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
      </div>
    </div>
  </div>
</section>

{{-- === Bagian Pembelajaran === --}}
<section class="container">
  <div class="row align-items-center flex-row-reverse mb-5 py-5">

    {{-- TEKS (KANAN) --}}
    <div class="col-lg-6" style="padding: 0px 30px;">
      <h1 class="fw-bold text-purple mb-2">Pembelajaran di TJKT</h1>
      <p class="mb-2 fw-semibold">
        Materi pembelajaran yang akan diajarkan di kompetensi keahlian Teknik Jaringan Komputer dan Telekomunikasi lebih difokuskan ke jaringan dan pengelolahan server.
      </p>
      <div class="features-list">
        <ul class="numbered-list">
          <li><strong>Web Design :</strong> Pembelajaran dalam membuat tampilan sebuah website atau biasa disebut UI, selain itu akan ada pembelajaran terkait HTML dan CSS.</li>
          <li><strong>Pemrograman Dasar :</strong> Pembelajaran yang berkaitan dengan algoritma, logika, dan bahasa pemrograman.</li>
          <li><strong>Dasar TJKT :</strong> Pembelajaran yang berkaitan dengan dasar–dasar komputer, instalasi, IP address, dan masih banyak lainnya.</li>
          <li><strong>Administrasi Sistem Jaringan :</strong> Pembelajaran yang berkaitan dengan pengelolaan server.</li>
          <li><strong>Administrasi Infrastruktur Jaringan :</strong> Pembelajaran yang berkaitan dengan pengelolaan jaringan.</li>
        </ul>
      </div>
    </div>

    {{-- FOTO (KIRI) --}}
    <div class="col-lg-6 d-flex justify-content-center position-relative mb-4 mb-lg-0">
      <div class="photo-wrapper photo-down">
        <img src="/assets/img/pembelajaran-tjkt.png" alt="Pembelajaran TJKT" class="img-fluid rounded custom-img">
        
      </div>
    </div>

  </div>
</section>

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

/* Tombol “Mari Bergabung” */
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
</style>
@endpush

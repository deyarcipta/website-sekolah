@extends('layouts.frontend')

@section('title', 'Guru dan Staff - SMK Wisata Indonesia Jakarta')

@section('content')

{{-- === Hero Section dengan background gedung dan warna ungu A948EA transparan === --}}
@include('frontend.partials.hero', [
  'title' => 'Guru dan Staff',
  'backgroundImage' => 'assets/img/foto-gedung.png',
  'height' => '200px'
])

{{-- === Konten Pembuka === --}}
<section class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-12">
        <p class="text-center mb-1 mt-4" style="padding: 0px 25px; font-size: 20px;">
          Sebuah tim pendidik yang berdedikasi untuk membentuk masa depan cerdas<br>dan berkarakter.
        </p>

        <div class="line-with-star">
          <span>★</span>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="container" style="margin-bottom: 100px;">

  {{-- === Kepala Sekolah === --}}
  <h1 class="fw-bold mb-4 text-center text-purple">Kepala Sekolah</h1>
  <div class="row justify-content-center mb-5">
    <div class="col-md-4 col-lg-3 d-flex">
      <div class="card text-center kepala-card shadow-sm flex-fill">
        <img src="/assets/img/foto-guru.png" class="card-img-top" alt="Kepala Sekolah">
        <div class="card-body d-flex flex-column justify-content-end">
          <h5 class="card-title mb-1 fw-bold">Budi Santoso, S.Pd.</h5>
          <p class="card-text mb-0">Kepala Sekolah</p>
        </div>
      </div>
    </div>
  </div>

  {{-- === Wakil Kepala Sekolah === --}}
  <h1 class="fw-bold mb-4 text-center text-purple">Wakil Kepala Sekolah</h1>
  <div class="row g-4 justify-content-center mb-5">
    <div class="col-md-4 col-lg-3 d-flex">
      <div class="card text-center kepala-card shadow-sm flex-fill">
        <img src="/assets/img/foto-guru.png" class="card-img-top" alt="Wakil Kepala Sekolah 1">
        <div class="card-body">
          <h5 class="card-title mb-1">Siti Rahmawati, S.Kom.</h5>
          <p class="card-text mb-0">Wakil Kepala Sekolah Kurikulum</p>
        </div>
      </div>
    </div>

    <div class="col-md-4 col-lg-3 d-flex">
      <div class="card text-center kepala-card shadow-sm flex-fill">
        <img src="/assets/img/foto-guru.png" class="card-img-top" alt="Wakil Kepala Sekolah 2">
        <div class="card-body">
          <h5 class="card-title mb-1 fw-bold">Andi Prasetyo, S.Pd.</h5>
          <p class="card-text mb-0">Wakil Kepala Sekolah Bidang Kesiswaan</p>
        </div>
      </div>
    </div>

    <div class="col-md-4 col-lg-3 d-flex">
      <div class="card text-center kepala-card shadow-sm flex-fill">
        <img src="/assets/img/foto-guru.png" class="card-img-top" alt="Wakil Kepala Sekolah 3">
        <div class="card-body">
          <h5 class="card-title mb-1 fw-bold">Lina Marlina, S.Pd.</h5>
          <p class="card-text mb-0">Wakil Kepala Sekolah Bidangan Sarana & Prasarana</p>
        </div>
      </div>
    </div>
  </div>

  {{-- === Kepala Kompetensi Keahlian === --}}
  <h1 class="fw-bold mb-4 text-center text-purple">Kepala Kompetensi Keahlian</h1>
  <div class="row g-4 justify-content-center mb-5">
    <div class="col-md-4 col-lg-3 d-flex">
      <div class="card text-center kepala-card shadow-sm flex-fill">
        <img src="/assets/img/foto-guru.png" class="card-img-top" alt="Kepala Kompetensi Keahlian 1">
        <div class="card-body">
          <h5 class="card-title mb-1">Siti Rahmawati, S.Kom.</h5>
          <p class="card-text mb-0">Kepala Kompetensi Keahlian Perhotelan</p>
        </div>
      </div>
    </div>

    <div class="col-md-4 col-lg-3 d-flex">
      <div class="card text-center kepala-card shadow-sm flex-fill">
        <img src="/assets/img/foto-guru.png" class="card-img-top" alt="Kepala Kompetensi Keahlian 2">
        <div class="card-body">
          <h5 class="card-title mb-1 fw-bold">Andi Prasetyo, S.Pd.</h5>
          <p class="card-text mb-0">Kepala Kompetensi Keahlian Kuliner</p>
        </div>
      </div>
    </div>

    <div class="col-md-4 col-lg-3 d-flex">
      <div class="card text-center kepala-card shadow-sm flex-fill">
        <img src="/assets/img/foto-guru.png" class="card-img-top" alt="Wakil Kepala Sekolah 3">
        <div class="card-body">
          <h5 class="card-title mb-1 fw-bold">Lina Marlina, S.Pd.</h5>
          <p class="card-text mb-0">Kepalaa Kompetensi Keahlian TJKT</p>
        </div>
      </div>
    </div>
  </div>

  {{-- === Guru === --}}
  <h1 class="fw-bold mb-4 text-center text-purple">Guru</h1>
  <div class="row g-4 justify-content-center mb-5">
    @for ($i = 1; $i <= 8; $i++)
      <div class="col-md-3 col-sm-6 d-flex">
        <div class="card text-center kepala-card shadow-sm flex-fill">
          <img src="/assets/img/foto-guru.png" class="card-img-top" alt="Guru {{ $i }}">
          <div class="card-body d-flex flex-column justify-content-end">
            <h5 class="card-title mb-1 fw-bold">Guru {{ $i }}</h5>
            <p class="card-text mb-0">Guru Mata Pelajaran</p>
          </div>
        </div>
      </div>
    @endfor
  </div>

  {{-- === Staff === --}}
  <h1 class="fw-bold mb-4 text-center text-purple">Staff</h1>
  <div class="row g-4 justify-content-center">
    @for ($i = 1; $i <= 8; $i++)
      <div class="col-md-3 col-sm-6 d-flex">
        <div class="card text-center kepala-card shadow-sm flex-fill">
          <img src="/assets/img/foto-guru.png" class="card-img-top" alt="Staff {{ $i }}">
          <div class="card-body d-flex flex-column justify-content-end">
            <h5 class="card-title mb-1 fw-bold">Staff {{ $i }}</h5>
            <p class="card-text mb-0">Staff Mata Pelajaran</p>
          </div>
        </div>
      </div>
    @endfor
  </div>
</section>
@endsection

@push('styles')
<style>
.kepala-card {
  border: none;
  border-radius: 20px;
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
  border-top-left-radius: 20px;
  border-top-right-radius: 20px;
}

/* Bagian bawah card — selalu vertikal tengah */
.kepala-card .card-body {
  background-color: #E5C1FD;
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
  color: #2e004f;
  font-size: 1.05rem;
  font-weight: 700;
  margin-bottom: 4px;
}

.kepala-card .card-text {
  color: #5a008a;
  font-size: 0.9rem;
}

/* Responsif */
@media (max-width: 767.98px) {
  .kepala-card img {
    height: 200px;
  }
}

</style>
@endpush
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
          {!! $description ?? 'Sebuah tim pendidik yang berdedikasi untuk membentuk masa depan cerdas dan berkarakter.' !!}
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
  @if(isset($kepalaSekolah) && $kepalaSekolah->isNotEmpty())
    <h1 class="fw-bold mb-4 text-center text-purple">Kepala Sekolah</h1>
    <div class="row justify-content-center mb-5">
      @foreach($kepalaSekolah as $kepala)
        <div class="col-md-4 col-lg-3 d-flex">
          <div class="card text-center kepala-card shadow-sm flex-fill">
            <img src="{{ $kepala->foto_url }}" class="card-img-top" alt="{{ $kepala->nama }}">
            <div class="card-body d-flex flex-column justify-content-end">
              <h5 class="card-title mb-1 fw-bold">{{ $kepala->nama }}</h5>
              <p class="card-text mb-0">{{ $kepala->jabatan }}</p>
              @if($kepala->pendidikan)
                <small class="text-muted">{{ $kepala->pendidikan }}</small>
              @endif
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @else
    {{-- Informasi jika data tidak ada --}}
    <h1 class="fw-bold mb-4 text-center text-purple">Kepala Sekolah</h1>
    <div class="alert alert-info text-center" role="alert">
      <i class="fas fa-info-circle me-2"></i>
      Data Kepala Sekolah sedang dalam proses pengisian.
    </div>
  @endif

  {{-- === Wakil Kepala Sekolah === --}}
  @if(isset($wakilKepala) && $wakilKepala->isNotEmpty())
    <h1 class="fw-bold mb-4 text-center text-purple">Wakil Kepala Sekolah</h1>
    <div class="row g-4 justify-content-center mb-5">
      @foreach($wakilKepala as $wakil)
        <div class="col-md-4 col-lg-3 d-flex">
          <div class="card text-center kepala-card shadow-sm flex-fill">
            <img src="{{ $wakil->foto_url }}" class="card-img-top" alt="{{ $wakil->nama }}">
            <div class="card-body">
              <h5 class="card-title mb-1">{{ $wakil->nama }}</h5>
              <p class="card-text mb-0">{{ $wakil->jabatan }}</p>
              @if($wakil->bidang)
                <small class="text-info">{{ $wakil->bidang }}</small>
              @endif
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @else
    {{-- Informasi jika data tidak ada --}}
    <h1 class="fw-bold mb-4 text-center text-purple">Wakil Kepala Sekolah</h1>
    <div class="alert alert-info text-center" role="alert">
      <i class="fas fa-info-circle me-2"></i>
      Data Wakil Kepala Sekolah sedang dalam proses pengisian.
    </div>
  @endif

  {{-- === Kepala Kompetensi Keahlian === --}}
  @if(isset($kepalaJurusan) && $kepalaJurusan->isNotEmpty())
    <h1 class="fw-bold mb-4 text-center text-purple">Kepala Kompetensi Keahlian</h1>
    <div class="row g-4 justify-content-center mb-5">
      @foreach($kepalaJurusan as $jurusan)
        <div class="col-md-4 col-lg-3 d-flex">
          <div class="card text-center kepala-card shadow-sm flex-fill">
            <img src="{{ $jurusan->foto_url }}" class="card-img-top" alt="{{ $jurusan->nama }}">
            <div class="card-body">
              <h5 class="card-title mb-1">{{ $jurusan->nama }}</h5>
              <p class="card-text mb-0">{{ $jurusan->jabatan }}</p>
              @if($jurusan->jurusan)
                <small class="text-warning">{{ $jurusan->jurusan }}</small>
              @endif
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @else
    {{-- Informasi jika data tidak ada --}}
    <h1 class="fw-bold mb-4 text-center text-purple">Kepala Kompetensi Keahlian</h1>
    <div class="alert alert-info text-center" role="alert">
      <i class="fas fa-info-circle me-2"></i>
      Data Kepala Kompetensi Keahlian sedang dalam proses pengisian.
    </div>
  @endif

  {{-- === Guru === --}}
  @if(isset($guru) && $guru->isNotEmpty())
    <h1 class="fw-bold mb-4 text-center text-purple">Guru</h1>
    <div class="row g-4 justify-content-center mb-5">
      @foreach($guru as $g)
        <div class="col-md-3 col-sm-6 d-flex">
          <div class="card text-center kepala-card shadow-sm flex-fill">
            <img src="{{ $g->foto_url }}" class="card-img-top" alt="{{ $g->nama }}">
            <div class="card-body d-flex flex-column justify-content-end">
              <h5 class="card-title mb-1 fw-bold">{{ $g->nama }}</h5>
              <p class="card-text mb-0">{{ $g->jabatan ?: 'Guru' }}</p>
              @if($g->bidang)
                <small class="text-muted">{{ $g->bidang }}</small>
              @endif
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @else
    {{-- Informasi jika data tidak ada --}}
    <h1 class="fw-bold mb-4 text-center text-purple">Guru</h1>
    <div class="alert alert-info text-center" role="alert">
      <i class="fas fa-info-circle me-2"></i>
      Data Guru sedang dalam proses pengisian.
    </div>
  @endif

  {{-- === Staff === --}}
  @if(isset($staff) && $staff->isNotEmpty())
    <h1 class="fw-bold mb-4 text-center text-purple">Staff</h1>
    <div class="row g-4 justify-content-center">
      @foreach($staff as $s)
        <div class="col-md-3 col-sm-6 d-flex">
          <div class="card text-center kepala-card shadow-sm flex-fill">
            <img src="{{ $s->foto_url }}" class="card-img-top" alt="{{ $s->nama }}">
            <div class="card-body d-flex flex-column justify-content-end">
              <h5 class="card-title mb-1 fw-bold">{{ $s->nama }}</h5>
              <p class="card-text mb-0">{{ $s->jabatan ?: 'Staff' }}</p>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @else
    {{-- Informasi jika data tidak ada --}}
    <h1 class="fw-bold mb-4 text-center text-purple">Staff</h1>
    <div class="alert alert-info text-center" role="alert">
      <i class="fas fa-info-circle me-2"></i>
      Data Staff sedang dalam proses pengisian.
    </div>
  @endif
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

/* Alert untuk data kosong */
.alert-info {
  background-color: #f8f9fa;
  border-color: #dee2e6;
  color: #6c757d;
  border-radius: 10px;
  padding: 20px;
  font-size: 1rem;
}

.alert-info i {
  color: #007bff;
}

/* Responsif */
@media (max-width: 767.98px) {
  .kepala-card img {
    height: 200px;
  }
  
  .alert-info {
    padding: 15px;
    font-size: 0.9rem;
  }
}

</style>
@endpush
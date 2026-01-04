@extends('layouts.backend')

@section('content')

{{-- ================= RINGKASAN DATA SEKOLAH ================= --}}
<div class="row">

  {{-- TOTAL SISWA --}}
  <div class="col-xl-3 col-sm-6 mb-4">
    <div class="card">
      <div class="card-body p-3">
        <div class="row align-items-center h-100">
          <div class="col-8">
            <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Siswa</p>
            <h5 class="font-weight-bolder mb-0">1.245</h5>
            <span class="text-sm text-muted">Data aktif</span>
          </div>
          <div class="col-4 d-flex align-items-center justify-content-end">
            <!-- Ubah struktur disini -->
            <div class="icon-circle bg-gradient-primary shadow d-flex align-items-center justify-content-center" 
                style="width: 48px; height: 48px; border-radius: 50%;">
              <i class="fas fa-user-graduate text-white" style="font-size: 1.25rem;"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- GURU & TENDIK --}}
  <div class="col-xl-3 col-sm-6 mb-4">
    <div class="card">
      <div class="card-body p-3">
        <div class="row align-items-center h-100">
          <div class="col-8">
            <p class="text-sm mb-0 text-uppercase font-weight-bold">Guru & Tendik</p>
            <h5 class="font-weight-bolder mb-0">86</h5>
            <span class="text-sm text-muted">Aktif</span>
          </div>
          <div class="col-4 d-flex align-items-center justify-content-end">
            <div class="icon-circle bg-gradient-danger shadow d-flex align-items-center justify-content-center" 
                style="width: 48px; height: 48px; border-radius: 50%;">
              <i class="fas fa-chalkboard-teacher text-white" style="font-size: 1.25rem;"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- ROMBEL --}}
  <div class="col-xl-3 col-sm-6 mb-4">
    <div class="card">
      <div class="card-body p-3">
        <div class="row align-items-center h-100">
          <div class="col-8">
            <p class="text-sm mb-0 text-uppercase font-weight-bold">Rombel</p>
            <h5 class="font-weight-bolder mb-0">42</h5>
            <span class="text-sm text-muted">Kelas X – XII</span>
          </div>
          <div class="col-4 d-flex align-items-center justify-content-end">
            <div class="icon-circle bg-gradient-success shadow d-flex align-items-center justify-content-center" 
                style="width: 48px; height: 48px; border-radius: 50%;">
              <i class="fas fa-school text-white" style="font-size: 1.25rem;"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- JURUSAN --}}
  <div class="col-xl-3 col-sm-6 mb-4">
    <div class="card">
      <div class="card-body p-3">
        <div class="row align-items-center h-100">
          <div class="col-8">
            <p class="text-sm mb-0 text-uppercase font-weight-bold">Jurusan</p>
            <h5 class="font-weight-bolder mb-0">5</h5>
            <span class="text-sm text-muted">Aktif</span>
          </div>
          <div class="col-4 d-flex align-items-center justify-content-end">
            <div class="icon-circle bg-gradient-warning shadow d-flex align-items-center justify-content-center" 
                style="width: 48px; height: 48px; border-radius: 50%;">
              <i class="fas fa-book-open text-white" style="font-size: 1.25rem;"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

{{-- ================= INFORMASI AKADEMIK ================= --}}
<div class="row mt-4">
  <div class="col-lg-6 mb-4">
    <div class="card h-100">
      <div class="card-header pb-0">
        <h6>Informasi Akademik</h6>
      </div>
      <div class="card-body">
        <ul class="list-group">
          <li class="list-group-item d-flex justify-content-between">
            <span>Tahun Ajaran Aktif</span>
            <strong>2025 / 2026</strong>
          </li>
          <li class="list-group-item d-flex justify-content-between">
            <span>Semester</span>
            <strong>Ganjil</strong>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>Status Website</span>
            <span class="badge bg-success">Online</span>
          </li>
          <li class="list-group-item d-flex justify-content-between">
            <span>Terakhir Update Konten</span>
            <strong>Hari ini</strong>
          </li>
        </ul>
      </div>
    </div>
  </div>

  {{-- ================= KONTEN WEBSITE ================= --}}
  <div class="col-lg-6 mb-4">
    <div class="card h-100">
      <div class="card-header pb-0">
        <h6>Konten Website</h6>
      </div>
      <div class="card-body">
        <ul class="list-group">
          <li class="list-group-item d-flex justify-content-between">
            <span>Berita Sekolah</span>
            <strong>28</strong>
          </li>
          <li class="list-group-item d-flex justify-content-between">
            <span>Pengumuman</span>
            <strong>6</strong>
          </li>
          <li class="list-group-item d-flex justify-content-between">
            <span>Galeri Foto</span>
            <strong>124</strong>
          </li>
          <li class="list-group-item d-flex justify-content-between">
            <span>Halaman Profil</span>
            <strong>Lengkap</strong>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>

@endsection
@section('styles')
<style>
  /* Style untuk icon-circle baru */
  .icon-circle {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
  }
</style>
@endsection
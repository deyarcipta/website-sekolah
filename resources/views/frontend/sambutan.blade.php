@extends('layouts.frontend')

@section('title', 'Sambutan Kepala Sekolah - SMK Wisata Indonesia Jakarta')

@section('content')

{{-- === Hero Section dengan background gedung dan warna ungu A948EA transparan === --}}
@include('frontend.partials.hero', [
  'title' => 'Sambutan Kepala Sekolah',
  'backgroundImage' => 'assets/img/foto-gedung.png',
  'height' => '200px'
])

{{-- === Konten Sambutan === --}}
<section class="py-5">
  <div class="container">
    <div class="row align-items-center" style="min-height: 50vh;">
      <!-- Foto Kepala Sekolah -->
      <div class="col-md-4 d-flex flex-column align-items-center justify-content-center text-center">
        <img src="{{ asset($settings->headmaster_photo) }}" 
            class="img-fluid rounded-circle shadow mb-3" 
            alt="Kepala Sekolah" 
            style="max-width: 250px;">
        <h5 class="fw-bold mb-0">{{ $settings->headmaster_name }}</h5>
        <p class="text-muted">Kepala Sekolah</p>
      </div>

      <!-- Sambutan Kepala Sekolah -->
      <div class="col-md-8 d-flex align-items-center">
        <div>
          <p>
            {!! $settings->headmaster_message !!}
          </p>
        </div>
      </div>
    </div>

    <hr class="my-3">

    <!-- Bagian-bagian lainnya -->
    <div class="content-section">
      {!! $sambutan->deskripsi !!}
    </div>
  </div>
</section>

@endsection

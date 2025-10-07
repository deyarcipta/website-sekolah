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
      <div class="col-lg-10">
        <h2 class="fw-bold text-center mb-4">Visi</h2>
        <p class="text-center mb-5">
          Menjadi lembaga pendidikan kejuruan unggulan di bidang pariwisata, perhotelan, kuliner, dan teknologi informasi yang menghasilkan lulusan berkompeten, berkarakter, dan siap bersaing di tingkat nasional maupun internasional.
        </p>

        <h2 class="fw-bold text-center mb-4">Misi</h2>
        <ul class="list-unstyled">
          <li class="mb-3">
            <i class="fas fa-check-circle text-purple me-2"></i>
            Menyelenggarakan pendidikan kejuruan berbasis kompetensi yang relevan dengan kebutuhan industri dan perkembangan teknologi.
          </li>
          <li class="mb-3">
            <i class="fas fa-check-circle text-purple me-2"></i>
            Membangun kemitraan strategis dengan berbagai industri, lembaga pendidikan, dan komunitas untuk mendukung pembelajaran berbasis proyek dan praktik nyata.
          </li>
          <li class="mb-3">
            <i class="fas fa-check-circle text-purple me-2"></i>
            Mengembangkan karakter siswa melalui program pembinaan soft skills, kepemimpinan, dan kewirausahaan.
          </li>
          <li class="mb-3">
            <i class="fas fa-check-circle text-purple me-2"></i>
            Meningkatkan kualitas sumber daya manusia melalui pelatihan dan pengembangan profesional bagi tenaga pendidik dan kependidikan.
          </li>
          <li class="mb-3">
            <i class="fas fa-check-circle text-purple me-2"></i>
            Menciptakan lingkungan belajar yang kondusif, inklusif, dan mendukung inovasi serta kreativitas siswa.
          </li>
        </ul>
      </div>
    </div>
  </div>
</section>
@endsection
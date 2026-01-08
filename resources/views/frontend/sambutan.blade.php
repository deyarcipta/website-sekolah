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
      <h4 class="fw-bold text-purple">Prestasi Akademik dan Dunia Kerja</h4>
      <p>
        SMK Wisata Indonesia berkomitmen menghasilkan lulusan yang kompeten dan siap kerja di berbagai bidang, baik
        akademik maupun keterampilan kejuruan. Setiap tahun kami berhasil menempatkan siswa dalam program magang industri
        dan kompetisi tingkat kota hingga nasional.
      </p>

      <h4 class="fw-bold text-purple mt-4">Identitas Kami sebagai Sekolah Kejuruan Unggulan</h4>
      <p>
        Berdiri sejak tahun 2002, sekolah ini telah berkembang menjadi salah satu sekolah kejuruan unggulan di bidang
        perhotelan, pariwisata, kuliner, dan teknologi informasi. Kami berkomitmen menghadirkan pembelajaran yang
        menyenangkan, relevan, dan selaras dengan kebutuhan dunia kerja.
      </p>

      <h4 class="fw-bold text-purple mt-4">Visi, Misi, dan Komitmen</h4>
      <p>
        Dengan visi *“Mewujudkan SMK Wisata Indonesia sebagai sekolah unggulan, berkarakter, dan berdaya saing global”*, 
        kami terus memperkuat pembelajaran karakter serta fasilitas pendidikan yang mendukung terciptanya siswa-siswa profesional dan mandiri.
      </p>

      <h4 class="fw-bold text-purple mt-4">Komunitas yang Beragam dan Bersinergi</h4>
      <p>
        Kami percaya bahwa keberagaman adalah kekuatan. Setiap siswa diajak berkolaborasi, menghargai perbedaan, serta
        membangun jejaring dengan sesama pelajar di dalam maupun luar sekolah.
      </p>

      <h4 class="fw-bold text-purple mt-4">Fasilitas dan Kegiatan Unggulan</h4>
      <p>
        SMK Wisata Indonesia menyediakan fasilitas lengkap seperti laboratorium komputer, dapur praktik, ruang perhotelan,
        hingga ruang multimedia. Selain itu, berbagai kegiatan ekstrakurikuler disediakan untuk mengembangkan minat dan bakat siswa.
      </p>

      <h4 class="fw-bold text-purple mt-4">Memandang ke Depan</h4>
      <p>
        Kami optimis menghadapi masa depan dengan inovasi dan semangat kolaboratif. Mari bersama-sama wujudkan generasi
        penerus bangsa yang profesional, berkarakter, dan siap bersaing di era global.
      </p>
    </div>
  </div>
</section>

@endsection

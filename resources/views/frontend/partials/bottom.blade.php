<footer class="bg-white border-top mt-5 py-4">
  <div class="container footer-container">
    <div class="row text-start align-items-start">

      {{-- Kolom 1: Logo & Kontak --}}
      <div class="col-md-5 mb-4">
        <div class="mb-2">
          <img src="{{ asset($settings->site_logo) }}" alt="Logo" width="100" class="img-fluid">
        </div>
        <h3 class="fw-bold text-uppercase">{{ $settings->site_name }}</h3>
        <p class="mb-1">{{ $settings->site_address }}</p>
        <p class="mb-1">
          <i class="bi bi-envelope-fill me-1"></i> {{ $settings->site_email }}
        </p>
        <p class="mb-1">
          <i class="bi bi-telephone-fill me-1"></i> {{ $settings->site_phone }}
        </p>
        <p class="mb-0">
          <i class="bi bi-phone-fill me-1"></i> {{ $settings->site_whatsapp }}
        </p>
      </div>

      {{-- Kolom 2: Menu --}}
      <div class="col-md-3 mb-4">
        <h4 class="fw-bold">Menu Utama</h4>
        <ul class="list-unstyled">
          <li><a href="/" class="text-dark text-decoration-none">Beranda</a></li>
          <li><a href="#" class="text-dark text-decoration-none">Program Keahlian</a></li>
          <li><a href="https://ppdb.smkwisataindonesia.sch.id" class="text-dark text-decoration-none" target="_blank">PPDB</a></li>
          <li><a href="/kontak" class="text-dark text-decoration-none">Tentang Kami</a></li>
          <li><a href="#" class="text-dark text-decoration-none">FAQ</a></li>
        </ul>
        <h4 class="fw-bold mt-3">Aplikasi Siswa</h4>
        <ul class="list-unstyled">
          <li><a href="#" class="text-dark text-decoration-none">Siawi</a></li>
          <li><a href="#" class="text-dark text-decoration-none">Sistem Alumni</a></li>
        </ul>
      </div>

      {{-- Kolom 3: Statistik & Sosial Media --}}
      <div class="col-md-4 mb-4">
        <h4 class="fw-bold">Statistik</h4>
        <h3 class="mb-1"><strong>Website Wistin</strong></h3>
        <p class="mb-1">Pageview Hari Ini : {{ $pageviewHariIni }}</p>
        <p class="mb-1">Visitor Hari Ini : {{ $visitorHariIni }}</p>
        <p class="mb-1">Visitor Bulan Ini : {{ $visitorBulanIni }}</p>
        <p class="mb-3">Total Visitor : {{ $totalVisitor }}</p>

        <h4 class="fw-bold">Our Social Media</h4>
        <div class="d-flex gap-2 flex-wrap">
          <a href="{{ $settings->instagram }}" target="_blank"><img src="{{ asset('assets/img/instagram.png') }}" width="50" alt="Instagram"></a>
          <a href="{{ $settings->youtube }}" target="_blank"><img src="{{ asset('assets/img/youtube.png') }}" width="50" alt="YouTube"></a>
          <a href="{{ $settings->facebook }}" target="_blank"><img src="{{ asset('assets/img/facebook.png') }}" width="50" alt="Facebook"></a>
          <a href="{{ $settings->tiktok }}" target="_blank"><img src="{{ asset('assets/img/tiktok.png') }}" width="50" alt="Tiktok"></a>
        </div>
      </div>
    </div>
  </div>
</footer>

<style>
/* Tambahan CSS */
@media (max-width: 768px) {
  .footer-container {
    padding-left: 20px !important;
    padding-right: 20px !important;
  }

  .footer-container h3,
  .footer-container h4 {
    font-size: 1.1rem;
  }

  .footer-container p,
  .footer-container li,
  .footer-container a {
    font-size: 0.9rem;
    line-height: 1.5;
  }
}
</style>

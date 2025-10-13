<footer class="bg-white border-top mt-5 py-4">
  <div class="container footer-container">
    <div class="row text-start align-items-start">

      {{-- Kolom 1: Logo & Kontak --}}
      <div class="col-md-5 mb-4">
        <div class="mb-2">
          <img src="{{ asset('assets/img/logowi.png') }}" alt="Logo SMK" width="100" class="img-fluid">
        </div>
        <h3 class="fw-bold">SMK WISATA INDONESIA</h3>
        <p class="mb-1">JL. Raya Lenteng Agung / Jl. Langgar, Rt. 009/003<br>
          No. 1, Kebagusan, Ps. Minggu, Kota Jakarta Selatan, DKI Jakarta 12520</p>
        <p class="mb-1">
          <i class="bi bi-envelope-fill me-1"></i> smkwisataindonesia01@gmail.com
        </p>
        <p class="mb-1">
          <i class="bi bi-telephone-fill me-1"></i> (021) 123123123
        </p>
        <p class="mb-0">
          <i class="bi bi-phone-fill me-1"></i> 081203412312
        </p>
      </div>

      {{-- Kolom 2: Menu --}}
      <div class="col-md-3 mb-4">
        <h4 class="fw-bold">Menu Utama</h4>
        <ul class="list-unstyled">
          <li><a href="#" class="text-dark text-decoration-none">Beranda</a></li>
          <li><a href="#" class="text-dark text-decoration-none">Program Keahlian</a></li>
          <li><a href="#" class="text-dark text-decoration-none">PPDB</a></li>
          <li><a href="#" class="text-dark text-decoration-none">Tentang Kami</a></li>
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
        <p class="mb-1">Pageview Hari Ini : 496</p>
        <p class="mb-1">Visitor Hari Ini : 505</p>
        <p class="mb-1">Visitor Bulan Ini : 2321</p>
        <p class="mb-3">Total Visitor : 1207213</p>

        <h4 class="fw-bold">Our Social Media</h4>
        <div class="d-flex gap-2 flex-wrap">
          <a href="#"><img src="{{ asset('assets/img/instagram.png') }}" width="50" alt="Instagram"></a>
          <a href="#"><img src="{{ asset('assets/img/youtube.png') }}" width="50" alt="YouTube"></a>
          <a href="#"><img src="{{ asset('assets/img/facebook.png') }}" width="50" alt="Facebook"></a>
          <a href="#"><img src="{{ asset('assets/img/tiktok.png') }}" width="50" alt="Tiktok"></a>
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

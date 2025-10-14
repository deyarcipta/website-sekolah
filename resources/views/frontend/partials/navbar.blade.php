<header class="navbar-header">
  <nav id="mainNavbar" class="navbar navbar-expand-lg fixed-top 
    @if (Request::is('/')) navbar-light navbar-custom 
    @else navbar-purple 
    @endif">
    <div class="container">
      <a class="navbar-brand" href="/">
        <img src="{{ asset('assets/img/logowi.png') }}" alt="Logo" height="50">
        <span class="ms-2">SMK WISATA INDONESIA</span>
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="/">Beranda</a></li>

          <!-- Dropdown Profile -->
          <li class="nav-item dropdown">
            <a class="nav-link" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Profile
            </a>
            <ul class="dropdown-menu" aria-labelledby="profileDropdown">
              <li><a class="dropdown-item" href="/sambutan">Sambutan Kepala Sekolah</a></li>
              <li><a class="dropdown-item" href="/visi-misi">Visi & Misi</a></li>
              <li><a class="dropdown-item" href="/sarpras">Sarana Prasarana</a></li>
              <li><a class="dropdown-item" href="/gurustaff">Guru & Staff</a></li>
            </ul>
          </li>

          <!-- Dropdown Program -->
          <li class="nav-item dropdown">
            <a class="nav-link" href="#" id="programDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Program
            </a>
            <ul class="dropdown-menu" aria-labelledby="programDropdown">
              <li><a class="dropdown-item" href="/perhotelan">Perhotelan</a></li>
              <li><a class="dropdown-item" href="/kuliner">Kuliner</a></li>
              <li><a class="dropdown-item" href="/tkj">TKJ</a></li>
            </ul>
          </li>

          <li class="nav-item"><a class="nav-link" href="/informasi">Informasi</a></li>
          <li class="nav-item"><a class="nav-link" href="/kontak">Hubungi Kami</a></li>
          <li class="nav-item"><a class="nav-link" href="#">PPDB</a></li>
        </ul>

        <div class="d-flex align-items-center gap-1 ms-2">
          <a href="#" class="social-icon"><i class="fab fa-facebook"></i></a>
          <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
        </div>
      </div>
    </div>
  </nav>
</header>

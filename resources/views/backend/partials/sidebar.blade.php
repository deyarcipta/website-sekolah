<aside
  class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl fixed-start ms-4 mt-2 mb-2"
  id="sidenav-main"
>

  {{-- ================= HEADER / LOGO ================= --}}
  <div class="sidenav-header" style="flex-shrink: 0; min-height: 70px;">
    <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-xl-none"
       aria-hidden="true" id="iconSidenav"></i>

    <a class="navbar-brand m-0 d-flex align-items-center h-100" href="#" style="padding-left: 1rem;">
      <img src="{{ asset($settings->site_logo ?? 'assets/img/logo.png') }}"
           class="navbar-brand-img"
           alt="logo"
           width="26" height="26">
      <span class="ms-2 font-weight-bold">Admin Sekolah</span>
    </a>
  </div>

  <hr class="horizontal dark my-0" style="flex-shrink: 0;">

  {{-- ================= MENU UTAMA - FILL REMAINING SPACE ================= --}}
  <div class="navbar-vertical-content-wrapper" 
       style="flex: 1; min-height: 0; display: flex; flex-direction: column;">
    
    {{-- MENU CONTENT (SCROLLABLE) --}}
    <div class="navbar-vertical-content flex-grow-1" 
         style="overflow-y: auto; padding: 0.5rem 0;">
      <ul class="navbar-nav flex-column">

        {{-- DASHBOARD --}}
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('backend.dashboard') ? 'active' : '' }}"
             href="{{ route('backend.dashboard') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-tv text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>

        {{-- ================= MANAJEMEN KONTEN WEBSITE ================= --}}
        <li class="nav-item mt-2">
          <h6 class="ps-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-1">
            Konten Website
          </h6>
        </li>

        {{-- Profil Sekolah --}}
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('backend.keunggulan-sekolah.index') || request()->routeIs('backend.sambutan-kepsek.index') || request()->routeIs('backend.visi-misi.index') || request()->routeIs('backend.sarpras.index') ? 'active' : '' }}" href="#">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-school text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Profil Sekolah</span>
          </a>
          <ul class="nav flex-column ps-4">
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('backend.sambutan-kepsek.index') ? 'active' : '' }}" href="{{ route('backend.sambutan-kepsek.index') }}">
                <i class="fas fa-comment-dots text-xs opacity-6 me-2"></i>
                Sambutan Kepsek
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('backend.visi-misi.index') ? 'active' : '' }}" href="{{ route('backend.visi-misi.index') }}">
                <i class="fas fa-bullseye text-xs opacity-6 me-2"></i>
                Visi & Misi
              </a>
            </li>
            <li class="nav-item">
             <a class="nav-link {{ request()->routeIs('backend.sarpras.index') ? 'active' : '' }}" href="{{ route('backend.sarpras.index') }}">
                <i class="fas fa-building text-xs opacity-6 me-2"></i>
                Sarana Prasarana
              </a>
            </li>
            <li class="nav-item">
             <a class="nav-link {{ request()->routeIs('backend.keunggulan-sekolah.index') ? 'active' : '' }}" href="{{ route('backend.keunggulan-sekolah.index') }}">
                <i class="fas fa-star text-xs opacity-6 me-2"></i>
                Keunggulan Sekolah
              </a>
            </li>
          </ul>
        </li>

        {{-- Berita --}}
        <li class="nav-item">
          <a class="nav-link" href="#">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-newspaper text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Berita & Artikel</span>
          </a>
        </li>

        {{-- Pengumuman --}}
        <li class="nav-item">
          <a class="nav-link" href="#">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-bullhorn text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Pengumuman</span>
          </a>
        </li>

        {{-- Agenda --}}
        <li class="nav-item">
          <a class="nav-link" href="#">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-calendar-alt text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Agenda Sekolah</span>
          </a>
        </li>

        {{-- Galeri --}}
        <li class="nav-item">
          <a class="nav-link" href="#">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-images text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Galeri</span>
          </a>
          <ul class="nav flex-column ps-4">
            <li class="nav-item">
              <a class="nav-link" href="#">
                <i class="fas fa-camera text-xs opacity-6 me-2"></i>
                Foto
              </a>
            </li>
            <li class="nav-item">
             <a class="nav-link" href="#">
                <i class="fas fa-video text-xs opacity-6 me-2"></i>
                Video
              </a>
            </li>
          </ul>
        </li>

        {{-- Kontak & Hubungi Kami --}}
        <li class="nav-item">
          <a class="nav-link" href="#">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-envelope text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Kontak</span>
          </a>
        </li>

        {{-- ================= AKADEMIK ================= --}}
        <li class="nav-item mt-2">
          <h6 class="ps-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-1">
            Akademik
          </h6>
        </li>

        {{-- ================= PROGRAM / JURUSAN ================= --}}
        <li class="nav-item">
          <a class="nav-link"
            href="#">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-graduation-cap text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Program / Jurusan</span>
          </a>
        </li>


        {{-- Guru & Staff --}}
        <li class="nav-item">
         <a class="nav-link" href="#">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-chalkboard-teacher text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Guru & Staff</span>
          </a>
          <ul class="nav flex-column ps-4">
            <li class="nav-item">
              <a class="nav-link" href="#">
                <i class="fas fa-users text-xs opacity-6 me-2"></i>
                Data Guru
              </a>
            </li>
            <li class="nav-item">
             <a class="nav-link" href="#">
                <i class="fas fa-user-tie text-xs opacity-6 me-2"></i>
                Tenaga Kependidikan
              </a>
            </li>
          </ul>
        </li>

        {{-- Siswa --}}
        <li class="nav-item">
          <a class="nav-link" href="#">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-user-graduate text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Data Siswa</span>
          </a>
          <ul class="nav flex-column ps-4">
            <li class="nav-item">
              <a class="nav-link" href="#">
                <i class="fas fa-list text-xs opacity-6 me-2"></i>
                Data Siswa
              </a>
            </li>
            <li class="nav-item">
             <a class="nav-link" href="#">
                <i class="fas fa-school text-xs opacity-6 me-2"></i>
                Rombongan Belajar
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <i class="fas fa-user-graduate text-xs opacity-6 me-2"></i>
                Data Alumni
              </a>
            </li>
          </ul>
        </li>

        {{-- Kurikulum --}}
        <li class="nav-item">
          <a class="nav-link" href="#">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-book-open text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Kurikulum</span>
          </a>
        </li>

        {{-- ================= PENGATURAN ================= --}}
        <li class="nav-item mt-2">
          <h6 class="ps-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-1">
            Pengaturan
          </h6>
        </li>

        {{-- Pengaturan Website --}}
        <li class="nav-item">
          <a class="nav-link {{ request()->is('w1s4t4/settings*') ? 'active' : '' }}" href="#">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-cogs text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Pengaturan Website</span>
          </a>
          <ul class="nav flex-column ps-4">
            <li class="nav-item">
              {{-- Di sidebar --}}
              <a class="nav-link {{ request()->is('w1s4t4/settings*') ? 'active' : '' }}"
                href="{{ route('backend.settings.index') }}">
                <i class="fas fa-cogs"></i>
                <span>Pengaturan Website</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <i class="fas fa-search text-xs opacity-6 me-2"></i>
                SEO & Meta
              </a>
            </li>
            <li class="nav-item">
             <a class="nav-link" href="#">
                <i class="fas fa-share-alt text-xs opacity-6 me-2"></i>
                Media Sosial
              </a>
            </li>
          </ul>
        </li>

        {{-- Manajemen User --}}
        <li class="nav-item">
         <a class="nav-link" href="#">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-users-cog text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Manajemen User</span>
          </a>
          <ul class="nav flex-column ps-4">
            <li class="nav-item">
              <a class="nav-link" href="#">
                <i class="fas fa-user-shield text-xs opacity-6 me-2"></i>
                Admin
              </a>
            </li>
          </ul>
        </li>

        {{-- Backup & Restore --}}
        <li class="nav-item">
         <a class="nav-link" href="#">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-database text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Backup & Restore</span>
          </a>
        </li>

        {{-- Log Aktifitas --}}
        <li class="nav-item">
          <a class="nav-link" href="#">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-history text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Log Aktivitas Sistem</span>
          </a>
        </li>

      </ul>
    </div>
  </div>
</aside>

<style>
/* ===== SIDEBAR FIX ===== */
#sidenav-main {
  position: fixed;
  top: 0.5rem;
  bottom: 0.5rem;
  left: 0;
  z-index: 1030;
  display: flex;
  flex-direction: column;
  height: auto !important;
  max-height: calc(100vh - 1rem);
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
  z-index: 1040;
   background-color: white !important; /* TAMBAHKAN INI */
}

/* HEADER */
.sidenav-header {
  flex-shrink: 0;
  min-height: 70px;
}

/* CONTENT WRAPPER */
.navbar-vertical-content-wrapper {
  flex: 1;
  min-height: 0;
  display: flex;
  flex-direction: column;
}

/* SCROLLABLE MENU */
.navbar-vertical-content {
  flex: 1;
  overflow-y: auto;
  padding: 0.5rem 0;
}

/* SCROLLBAR */
.navbar-vertical-content::-webkit-scrollbar {
  width: 4px;
}
.navbar-vertical-content::-webkit-scrollbar-thumb {
  background: #adb5bd;
  border-radius: 4px;
}
.navbar-vertical-content::-webkit-scrollbar-thumb:hover {
  background: #6c757d;
}

/* NAV LINK UTAMA */
.nav-link {
  padding: 0.5rem 1rem !important;
  margin: 0.125rem 0.5rem;
  border-radius: 0.375rem;
  min-height: 40px;
  display: flex;
  align-items: center;
  transition: all 0.15s ease;
}

.nav-link.active {
  background: linear-gradient(135deg, #f1e6ff 0%, #efe9ff 100%);
  color: #344767 !important;
  font-weight: 600;
  box-shadow: 0 6px 18px rgba(102, 126, 234, 0.25);
}

/* SUB MENU */
.nav-item > ul.nav {
  margin-top: 0.25rem;
  margin-bottom: 0.25rem;
}

.nav-item > ul.nav .nav-link {
  padding: 0.25rem 0.75rem !important;
  margin: 0.125rem 0;
  min-height: 32px;
  font-size: 0.8125rem;
  color: #6c757d;
}

.nav-item > ul.nav .nav-link.active {
  background-color: rgba(0, 0, 0, 0.05) !important;
  color: #344767;
  font-weight: 500;
}

.nav-item > ul.nav .nav-link:hover {
  background-color: rgba(0, 0, 0, 0.03);
}

/* ICON SUB MENU */
.nav-item > ul.nav .nav-link i {
  font-size: 0.75rem;
  width: 16px;
  text-align: center;
}

/* HEADER SECTION */
.nav-item h6 {
  font-size: 0.65rem;
  letter-spacing: 0.5px;
  padding-left: 1rem !important;
  margin-top: 0.75rem;
  color: #6c757d !important;
}

/* ICON UTAMA */
.icon.icon-shape {
  width: 32px;
  height: 32px;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: rgba(0, 0, 0, 0.05);
  border-radius: 0.375rem;
}

.icon.icon-shape i {
  font-size: 0.875rem;
  opacity: 0.8;
}

/* HOVER EFFECT */
.nav-link:hover {
  background-color: rgba(0, 0, 0, 0.03);
}

/* COLLAPSE/EXPAND INDICATOR */
.nav-item:has(> ul.nav) > .nav-link::after {
  content: '\f078';
  font-family: 'Font Awesome 5 Free';
  font-weight: 900;
  font-size: 0.75rem;
  margin-left: auto;
  transition: transform 0.2s ease;
}

.nav-item.active:has(> ul.nav) > .nav-link::after {
  transform: rotate(180deg);
}
</style>

<script>
// TOGGLE SUBMENU SAJA - SIDEBAR TOGGLE DIPINDAH KE LAYOUT UTAMA
document.addEventListener('DOMContentLoaded', function() {
  // Fungsi untuk toggle submenu
  document.querySelectorAll('.nav-item:has(> ul.nav) > .nav-link').forEach(link => {
    link.addEventListener('click', function(e) {
      e.preventDefault();
      e.stopPropagation();
      
      const parentItem = this.closest('.nav-item');
      const submenu = parentItem.querySelector('ul.nav');
      
      // Toggle class active
      parentItem.classList.toggle('active');
      
      // Toggle display submenu
      if (submenu.style.display === 'block') {
        submenu.style.display = 'none';
      } else {
        submenu.style.display = 'block';
      }
    });
  });
  
  // Set initial state untuk submenu
  document.querySelectorAll('.nav-item:has(> ul.nav)').forEach(item => {
    const submenu = item.querySelector('ul.nav');
    // Jika parent item atau child item active, buka submenu
    if (item.classList.contains('active') || submenu.querySelector('.nav-link.active')) {
      item.classList.add('active');
      submenu.style.display = 'block';
    } else {
      submenu.style.display = 'none';
    }
  });
});
</script>
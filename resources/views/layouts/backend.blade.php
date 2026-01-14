<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dashboard')</title>

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="{{ asset($settings->site_logo ?? 'assets/img/logo.png') }}">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

  <!-- Icons -->
  <link rel="stylesheet" href="{{ asset('assets/css/nucleo.css') }}">
  <!-- Font Awesome Local -->
  <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">

  <!-- SweetAlert2 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

  <!-- Argon CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/argon-dashboard.css') }}">

  <style>
    .main-content {
      margin-left: 17.125rem; /* default width sidenav Argon */
    }

    @media (max-width: 1199.98px) {
      .main-content {
        margin-left: 0;
      }
    }

    /* SweetAlert2 Customization untuk tema Argon */
    .swal2-popup {
      border-radius: 0.75rem !important;
      font-family: 'Open Sans', sans-serif !important;
    }
    
    .swal2-title {
      color: #32325d !important;
      font-weight: 600 !important;
    }
    
    .swal2-confirm {
      background-color: #5e72e4 !important;
      border-color: #5e72e4 !important;
    }
    
    .swal2-cancel {
      background-color: #6c757d !important;
      border-color: #6c757d !important;
    }
    
    .swal2-icon.swal2-success {
      border-color: #2dce89 !important;
      color: #2dce89 !important;
    }
    
    .swal2-icon.swal2-error {
      border-color: #f5365c !important;
      color: #f5365c !important;
    }
    
    .swal2-icon.swal2-warning {
      border-color: #fb6340 !important;
      color: #fb6340 !important;
    }
    
    .swal2-icon.swal2-info {
      border-color: #11cdef !important;
      color: #11cdef !important;
    }
  </style>
  @stack('styles')
</head>
<body class="g-sidenav-show bg-gray-100">
  <div class="min-height-300 bg-dark position-absolute w-100"></div>

    @include('backend.partials.sidebar')
    <main class="main-content position-relative border-radius-lg">
      @include('backend.partials.navbar')
      <div class="container-fluid py-4 px-4">
        @yield('content')
        {{-- @include('backend.partials.configuration') --}}
        @include('backend.partials.footer')
      </div>
    </main>

  <!--   Core JS Files   -->
  <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
  
  <script>
    if (navigator.platform.indexOf('Win') > -1 && document.querySelector('#sidenav-scrollbar')) {
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), {
        damping: 0.5
      });
    }
  </script>

  <!-- Jquery -->
  <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>

  <!-- Jquery UI (untuk sortable) -->
  <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>

  <!-- Core -->
  {{-- <script src="{{ asset('assets/vendor/jquery/dist/jquery.min.js') }}"></script> --}}
  <script src="{{ asset('assets/js/core/bootstrap.bundle.min.js') }}"></script>

  <!-- SweetAlert2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- CKeditor -->
  <script src="{{ asset('assets/js/ckeditor.js') }}"></script>
  
  <!-- Github buttons -->
  <script async defer src="{{ asset('assets/js/buttons.js') }}"></script>
  
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{ asset('assets/js/argon-dashboard.min.js?v=2.1.0') }}"></script>

  <!-- SIDEBAR TOGGLE FIX UNTUK MOBILE -->
  <script>
  document.addEventListener('DOMContentLoaded', function() {
    // ========== SIDEBAR TOGGLE FIX ==========
    const iconNavbarSidenav = document.getElementById('iconNavbarSidenav');
    const iconSidenav = document.getElementById('iconSidenav');
    const sidenav = document.getElementById('sidenav-main');
    const body = document.getElementsByTagName('body')[0];
    
    if (iconNavbarSidenav && sidenav) {
      console.log('Sidebar toggle script loaded');
      
      // ========== OVERLAY MANAGEMENT ==========
      let overlay = null;
      
      function createOverlay() {
        // Hanya buat overlay untuk mobile dan jika belum ada
        if (window.innerWidth < 1200 && !document.querySelector('.sidenav-overlay')) {
          overlay = document.createElement('div');
          overlay.className = 'sidenav-overlay';
          overlay.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1034;
            display: block;
          `;
          document.body.appendChild(overlay);
          
          // Close sidebar ketika overlay diklik
          overlay.addEventListener('click', function() {
            closeSidebar();
          });
          
          // Prevent scroll saat overlay aktif
          document.body.style.overflow = 'hidden';
        }
      }
      
      function removeOverlay() {
        const existingOverlay = document.querySelector('.sidenav-overlay');
        if (existingOverlay && existingOverlay.parentNode) {
          existingOverlay.parentNode.removeChild(existingOverlay);
        }
        overlay = null;
        document.body.style.overflow = '';
      }
      
      // Function untuk membuka sidebar
      function openSidebar() {
        console.log('Opening sidebar');
        
        // Untuk mobile (< 1200px)
        if (window.innerWidth < 1200) {
          // Pastikan overlay dihapus dulu
          removeOverlay();
          // Buat overlay baru
          createOverlay();
          // Tambahkan class untuk sidebar
          sidenav.classList.add('show');
        } else {
          // Untuk desktop (≥ 1200px)
          body.classList.remove('g-sidenav-hidden');
          body.classList.add('g-sidenav-pinned');
        }
        
        iconNavbarSidenav.setAttribute('aria-expanded', 'true');
      }
      
      // Function untuk menutup sidebar
      function closeSidebar() {
        console.log('Closing sidebar');
        
        // Untuk mobile (< 1200px)
        if (window.innerWidth < 1200) {
          sidenav.classList.remove('show');
          removeOverlay();
        } else {
          // Untuk desktop (≥ 1200px)
          body.classList.remove('g-sidenav-pinned');
          body.classList.add('g-sidenav-hidden');
        }
        
        iconNavbarSidenav.setAttribute('aria-expanded', 'false');
      }
      
      // Function untuk toggle sidebar
      function toggleSidebar() {
        console.log('Toggling sidebar');
        
        if (window.innerWidth < 1200) {
          // Untuk mobile: cek apakah sidebar sedang show
          if (sidenav.classList.contains('show')) {
            closeSidebar();
          } else {
            openSidebar();
          }
        } else {
          // Untuk desktop: toggle class pada body
          if (body.classList.contains('g-sidenav-pinned')) {
            closeSidebar();
          } else {
            openSidebar();
          }
        }
      }
      
      // ========== EVENT LISTENERS ==========
      
      // 1. Hamburger di navbar
      iconNavbarSidenav.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        toggleSidebar();
      });
      
      // 2. Close button di sidebar (jika ada)
      if (iconSidenav) {
        iconSidenav.addEventListener('click', function(e) {
          e.preventDefault();
          closeSidebar();
        });
      }
      
      // 3. Close sidebar dengan ESC key
      document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
          if (window.innerWidth < 1200 && sidenav.classList.contains('show')) {
            closeSidebar();
          }
        }
      });
      
      // ========== WINDOW RESIZE HANDLER ==========
      function handleResize() {
        // Jika resize ke desktop (≥ 1200px)
        if (window.innerWidth >= 1200) {
          // Hapus overlay jika ada
          removeOverlay();
          // Pastikan sidebar tidak dalam mode mobile show
          sidenav.classList.remove('show');
        } else {
          // Jika resize ke mobile (< 1200px)
          // Jika sidebar sedang terbuka, buat overlay
          if (sidenav.classList.contains('show')) {
            createOverlay();
          }
        }
      }
      
      // Initial setup
      if (window.innerWidth < 1200) {
        // Pastikan sidebar tertutup di mobile saat pertama load
        sidenav.classList.remove('show');
      }
      
      // Listen untuk resize
      window.addEventListener('resize', handleResize);
    }
  });
  </script>

  <style>
  /* HANYA PERBAIKAN UNTUK DUA MASALAH - TIDAK MENGUBAH TAMPILAN LAIN */
  
  /* 1. FIX BACKGROUND PUTIH DI ATAS NAVBAR */
  .min-height-300.bg-dark.position-absolute.w-100 {
    position: relative !important;
    height: 300px !important;
    z-index: 0 !important;
  }
  
  /* 2. FIX SIDEBAR MOBILE DAN OVERLAY */
  @media (max-width: 1199.98px) {
    /* Overlay untuk sidebar mobile */
    .sidenav-overlay {
      position: fixed !important;
      top: 0 !important;
      left: 0 !important;
      right: 0 !important;
      bottom: 0 !important;
      background-color: rgba(0, 0, 0, 0.5) !important;
      z-index: 1034 !important;
    }
    
    /* Sidebar untuk mobile */
    #sidenav-main {
      position: fixed !important;
      top: 0 !important;
      left: 0 !important;
      height: 100vh !important;
      width: 250px !important;
      max-width: 80vw !important;
      z-index: 1035 !important;
      transform: translateX(-100%);
      transition: transform 0.3s ease;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3) !important;
      border-radius: 0 !important;
      margin: 0 !important;
      background-color: white !important;
    }
    
    /* Sidebar ketika terbuka */
    #sidenav-main.show {
      transform: translateX(0) !important;
    }
  }

  /* Untuk desktop (≥ 1200px) */
  @media (min-width: 1200px) {
    #sidenav-main {
      transform: translateX(0) !important;
    }
  }
  </style>

  <!-- Custom SweetAlert2 Configuration -->
  <script>
    // SweetAlert2 Global Configuration
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
      },
      customClass: {
        popup: 'swal2-popup-custom'
      }
    });

    // Global fungsi untuk show success toast
    function showSuccessToast(message) {
      Toast.fire({
        icon: 'success',
        title: message
      });
    }

    // Global fungsi untuk show error toast
    function showErrorToast(message) {
      Toast.fire({
        icon: 'error',
        title: message
      });
    }

    // Global fungsi untuk show warning toast
    function showWarningToast(message) {
      Toast.fire({
        icon: 'warning',
        title: message
      });
    }

    // Global fungsi untuk show info toast
    function showInfoToast(message) {
      Toast.fire({
        icon: 'info',
        title: message
      });
    }

    // Global fungsi untuk konfirmasi hapus
    function confirmDelete(title, text, callback) {
      Swal.fire({
        title: title || 'Apakah Anda yakin?',
        html: text || 'Data yang dihapus tidak dapat dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#5e72e4',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        customClass: {
          confirmButton: 'btn btn-primary',
          cancelButton: 'btn btn-secondary'
        }
      }).then((result) => {
        if (result.isConfirmed && typeof callback === 'function') {
          callback();
        }
      });
    }

    // Global fungsi untuk show loading
    function showLoading(title = 'Memproses...', text = 'Harap tunggu') {
      Swal.fire({
        title: title,
        text: text,
        allowOutsideClick: false,
        showConfirmButton: false,
        willOpen: () => {
          Swal.showLoading();
        }
      });
    }

    // Global fungsi untuk close loading
    function closeLoading() {
      Swal.close();
    }

    // Global AJAX error handler
    $(document).ajaxError(function(event, jqxhr, settings, thrownError) {
      closeLoading();
      
      if (jqxhr.status === 422) {
        // Validation error
        let errors = jqxhr.responseJSON.errors;
        let errorMessages = '';
        
        $.each(errors, function(key, value) {
          errorMessages += value[0] + '<br>';
        });
        
        Swal.fire({
          icon: 'error',
          title: 'Validasi Gagal',
          html: errorMessages,
          confirmButtonText: 'Mengerti'
        });
      } else if (jqxhr.status === 403) {
        Swal.fire({
          icon: 'error',
          title: 'Akses Ditolak',
          text: 'Anda tidak memiliki izin untuk melakukan aksi ini.',
          confirmButtonText: 'Mengerti'
        });
      } else if (jqxhr.status === 404) {
        Swal.fire({
          icon: 'error',
          title: 'Data Tidak Ditemukan',
          text: 'Data yang diminta tidak ditemukan.',
          confirmButtonText: 'Mengerti'
        });
      } else if (jqxhr.status === 500) {
        Swal.fire({
          icon: 'error',
          title: 'Kesalahan Server',
          text: 'Terjadi kesalahan pada server. Silakan coba lagi.',
          confirmButtonText: 'Mengerti'
        });
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Terjadi Kesalahan',
          text: 'Terjadi kesalahan. Silakan coba lagi.',
          confirmButtonText: 'Mengerti'
        });
      }
    });
  </script>

  @stack('scripts')
</body>
</html>
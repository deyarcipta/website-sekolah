<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title') - {{ $settings->site_name }}</title>
  <link rel="icon" type="image/png" href="{{ asset($settings->site_logo) }}">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

  <!-- Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">


  <!-- Swiper CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

  <!-- Core Styles -->
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/aos.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}" />

  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/frontend-style.css') }}">
  @stack('styles')
</head>

<body>
  <header>
    @include('frontend.partials.navbar')
  </header>
  
  <!-- Main Content -->
  <main>
    @yield('content')
  </main>

  @include('frontend.partials.mou')
  @include('frontend.partials.bottom')
  @include('frontend.partials.footer')

  <!-- Scripts -->
  <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/js/aos.js') }}"></script>
  <script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Inisialisasi AOS
      AOS.init();

      // Swiper untuk Galeri
      new Swiper('.galerySwiper', {
        loop: true,
        autoplay: { delay: 3000 },
        pagination: {
          el: '.galery-pagination',
          clickable: true,
        },
        navigation: {
          nextEl: '.galery-button-next',
          prevEl: '.galery-button-prev',
        },
        breakpoints: {
          320: { slidesPerView: 1 },
          576: { slidesPerView: 2 },
          768: { slidesPerView: 3 },
          992: { slidesPerView: 4 },
        },
      });

      // Swiper untuk Alumni
      new Swiper('.alumniSwiper', {
        loop: true,
        autoplay: {
          delay: 5000,
          disableOnInteraction: false,
        },
        pagination: {
          el: '.swiper-pagination',
          clickable: true,
        },
      });

      // Swiper untuk MOU
      // Swiper untuk MOU - SMOOTH CONTINUOUS VERSION
const mouSwiper = new Swiper('.mouSwiper', {
  loop: true,
  slidesPerView: 5,
  spaceBetween: 20,
  speed: 4000, // 4 detik untuk satu siklus penuh
  allowTouchMove: true,
  grabCursor: true,
  
  // Continuous autoplay
  autoplay: {
    delay: 0,
    disableOnInteraction: false,
    pauseOnMouseEnter: false,
    waitForTransition: true,
    stopOnLastSlide: false, // penting: jangan berhenti di slide terakhir
  },
  
  // Efek gerakan linear
  freeMode: {
    enabled: true,
    momentum: false,
    sticky: false,
    minimumVelocity: 0.02,
  },
  
  breakpoints: {
    320: { 
      slidesPerView: 2,
      spaceBetween: 10,
      speed: 5000 // lebih lambat di mobile
    },
    576: { 
      slidesPerView: 3,
      spaceBetween: 15,
      speed: 4500
    },
    768: { 
      slidesPerView: 4,
      spaceBetween: 18,
      speed: 4000
    },
    992: { 
      slidesPerView: 5,
      spaceBetween: 20,
      speed: 3500
    },
  },
  
  // Event untuk menjaga kontinuitas
  on: {
    init: function() {
      console.log('MOU Swiper initialized - Continuous mode');
      
      // Force linear animation
      this.wrapperEl.style.transitionTimingFunction = 'linear';
      
      // Clone slides untuk efek seamless yang lebih baik
      if (this.slides.length > 0) {
        const wrapper = this.wrapperEl;
        const originalSlides = Array.from(this.slides);
        
        // Clone set pertama
        originalSlides.forEach(slide => {
          const clone = slide.cloneNode(true);
          clone.classList.add('swiper-slide-duplicate');
          wrapper.appendChild(clone);
        });
        
        // Clone set kedua
        originalSlides.forEach(slide => {
          const clone = slide.cloneNode(true);
          clone.classList.add('swiper-slide-duplicate');
          wrapper.appendChild(clone);
        });
      }
    },
    
    // Reset position saat hampir selesai untuk efek seamless
    transitionEnd: function() {
      if (this && this.progress > 0.66) { // Reset di 2/3 progress
        this.slideTo(0, 0, false); // Reset ke slide 0 tanpa animasi
      }
    },
    
    // Restart autoplay jika terhenti
    autoplayStop: function() {
      setTimeout(() => {
        this.autoplay.start();
      }, 100);
    }
  }
});

// Safety: Restart autoplay setiap 30 detik
setInterval(() => {
  if (mouSwiper && !mouSwiper.autoplay.running) {
    mouSwiper.autoplay.start();
  }
}, 30000);

      // Efek Navbar saat Scroll
      document.addEventListener("scroll", function () {
        const navbar = document.getElementById("mainNavbar");
        
        // Tambah efek scroll di semua halaman
        if (window.scrollY > 50) {
          navbar.classList.add("navbar-scrolled");
        } else {
          navbar.classList.remove("navbar-scrolled");
        }
      });
    });

    // Fix dropdown agar tidak langsung tertutup
  document.addEventListener('DOMContentLoaded', function () {
  const dropdowns = document.querySelectorAll('.nav-item.dropdown');
  const toggles = document.querySelectorAll('.nav-item.dropdown > .nav-link, .nav-item.dropdown > button');

  // ======== DESKTOP (Hover) ========
  function handleDesktopDropdown() {
    dropdowns.forEach(item => {
      item.addEventListener('mouseenter', () => {
        const dropdown = item.querySelector('.dropdown-menu');
        dropdown.classList.add('show');
      });
      item.addEventListener('mouseleave', () => {
        const dropdown = item.querySelector('.dropdown-menu');
        setTimeout(() => {
          if (!item.matches(':hover')) dropdown.classList.remove('show');
        }, 150);
      });
    });
  }

  // ======== MOBILE (Click) ========
  function handleMobileDropdown() {
    toggles.forEach(toggle => {
      toggle.addEventListener('click', function (e) {
        if (window.innerWidth < 992) {
          e.preventDefault();
          e.stopPropagation();

          const parent = this.closest('.dropdown');
          const isActive = parent.classList.contains('show');

          // Tutup semua dropdown lain
          document.querySelectorAll('.dropdown.show').forEach(d => d.classList.remove('show'));

          // Toggle dropdown ini
          if (!isActive) parent.classList.add('show');
        }
      });
    });
  }

  // ======== Jalankan sesuai ukuran layar ========
  if (window.innerWidth >= 992) {
    handleDesktopDropdown();
  } else {
    handleMobileDropdown();
  }

  // ======== Update saat resize (ganti mode otomatis) ========
  window.addEventListener('resize', () => {
    // Hapus semua state dropdown saat mode berubah
    document.querySelectorAll('.dropdown.show').forEach(d => d.classList.remove('show'));
  });
});
  </script>

  @stack('scripts')
</body>
</html>

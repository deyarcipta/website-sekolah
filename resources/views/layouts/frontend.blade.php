<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title') - {{ $settings->site_name ?? 'Default Site Name' }}</title>
  <link rel="icon" type="image/png" href="{{ asset($settings->site_logo ?? 'assets/images/logo.png') }}">

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
  <style>
    /* Modal Pengumuman Styles */
    .announcement-modal {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 999999 !important;
      display: none;
      overflow-x: hidden;
      overflow-y: auto;
    }
    
    .announcement-backdrop {
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      background-color: rgba(0, 0, 0, 0.75);
      z-index: 999998;
    }
    
    .announcement-modal .modal-dialog {
      position: relative;
      z-index: 999999;
      max-width: 800px;
      margin: 1.75rem auto;
      padding: 0 15px;
    }
    
    .announcement-modal .modal-content {
      border-radius: 15px;
      border: none;
      box-shadow: 0 20px 60px rgba(0,0,0,0.3);
      overflow: hidden;
    }
    
    .announcement-modal .modal-header {
      background: linear-gradient(135deg, #4e54c8 0%, #8f94fb 100%);
      color: white;
      border-bottom: none;
      padding: 1.5rem 2rem;
      position: relative;
    }
    
    .announcement-modal .modal-header h5 {
      margin: 0;
      font-weight: 600;
      font-size: 1.25rem;
    }
    
    .announcement-modal .modal-body {
      padding: 2rem;
      max-height: 70vh;
      overflow-y: auto;
      font-size: 1rem;
      line-height: 1.6;
    }
    
    .announcement-modal .modal-footer {
      border-top: 1px solid #eee;
      padding: 1.5rem 2rem;
      background: #f8f9fa;
    }
    
    .announcement-badge {
      position: absolute;
      top: -10px;
      right: -10px;
      background: #dc3545;
      color: white;
      border-radius: 50%;
      width: 30px;
      height: 30px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 12px;
      font-weight: bold;
      box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }
    
    .announcement-loading {
      min-height: 200px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
    }
    
    .announcement-loading .spinner-border {
      width: 3rem;
      height: 3rem;
    }
    
    .announcement-content img {
      max-width: 100%;
      height: auto;
      border-radius: 8px;
      margin: 1.5rem 0;
      display: block;
    }
    
    .announcement-content p {
      margin-bottom: 1rem;
    }
    
    .announcement-text {
      line-height: 1.8;
    }
    
    .announcement-text p {
      margin-bottom: 1.2rem;
    }
    
    .announcement-text ul, 
    .announcement-text ol {
      padding-left: 2rem;
      margin-bottom: 1.5rem;
    }
    
    .announcement-text li {
      margin-bottom: 0.5rem;
    }
    
    .announcement-text h1,
    .announcement-text h2,
    .announcement-text h3,
    .announcement-text h4,
    .announcement-text h5,
    .announcement-text h6 {
      margin-top: 2rem;
      margin-bottom: 1rem;
      font-weight: 600;
      color: #333;
    }
    
    .announcement-text h4 {
      color: #4e54c8;
      border-bottom: 2px solid #f0f0f0;
      padding-bottom: 0.5rem;
    }
    
    #dontShowAgainBtn {
      background: linear-gradient(135deg, #4e54c8 0%, #8f94fb 100%);
      border: none;
      padding: 0.5rem 1.5rem;
      font-weight: 500;
    }
    
    #dontShowAgainBtn:hover {
      background: linear-gradient(135deg, #3a3fa0 0%, #6d72e0 100%);
      transform: translateY(-1px);
      box-shadow: 0 5px 15px rgba(78, 84, 200, 0.3);
    }
    
    .announcement-toast {
      animation: slideInUp 0.3s ease;
    }
    
    @keyframes slideInUp {
      from {
        transform: translateY(100%);
        opacity: 0;
      }
      to {
        transform: translateY(0);
        opacity: 1;
      }
    }
    
    @media (max-width: 768px) {
      .announcement-modal .modal-dialog {
        margin: 0.5rem auto;
        max-width: 95%;
      }
      
      .announcement-modal .modal-header,
      .announcement-modal .modal-body,
      .announcement-modal .modal-footer {
        padding: 1rem;
      }
      
      .announcement-modal .modal-body {
        max-height: 80vh;
      }
    }
  </style>
</head>

<body>
  <header>
    @include('frontend.partials.navbar')
  </header>
  
  <!-- Main Content -->
  <main>
    @yield('content')
  </main>

  <!-- Modal Pengumuman - HANYA DI HOME PAGE -->
  @php
    // Tentukan apakah ini halaman home
    $isHomePage = request()->is('/') || 
                  request()->routeIs('home') || 
                  request()->routeIs('frontend.home') ||
                  request()->routeIs('home.index');
    
    $activeAnnouncementModal = null;
    
    // Hanya query database jika ini halaman home
    if ($isHomePage) {
        $activeAnnouncementModal = \App\Models\Announcement::where('show_as_modal', 1)
            ->where('show_on_frontend', 1)
            ->where('status', 'active')
            ->where(function($q) {
                $q->whereNull('start_date')
                  ->orWhere('start_date', '<=', now());
            })
            ->where(function($q) {
                $q->whereNull('end_date')
                  ->orWhere('end_date', '>=', now());
            })
            ->orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->first();
    }
    
    // Debug info
    // \Log::info('Announcement Check', [
    //     'is_home_page' => $isHomePage,
    //     'has_announcement' => !is_null($activeAnnouncementModal),
    //     'announcement_id' => $activeAnnouncementModal ? $activeAnnouncementModal->id : null,
    //     'current_route' => request()->route()->getName() ?? 'unknown',
    //     'current_path' => request()->path()
    // ]);
  @endphp
  
  @if($activeAnnouncementModal)
  <!-- Modal Pengumuman -->
  <div id="announcementModal" class="announcement-modal">
    <!-- Backdrop -->
    <div class="announcement-backdrop" id="announcementBackdrop"></div>
    
    <!-- Modal Content -->
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header position-relative">
          <h5 class="modal-title">
            <i class="fas 
                  @switch($activeAnnouncementModal->type ?? 'info')
                      @case('warning')
                          fa-exclamation-triangle
                          @break
                      @case('danger')
                          fa-radiation
                          @break
                      @case('success')
                          fa-check-circle
                          @break
                      @case('primary')
                          fa-star
                          @break
                      @default
                          fas fa-bullhorn
                  @endswitch
                  me-2"></i>
              {{ $activeAnnouncementModal->title ?? 'PENGUMUMAN PENTING' }}
          </h5>
          <button type="button" class="btn-close btn-close-white" id="announcementCloseBtn" aria-label="Close"></button>
          {{-- <span class="announcement-badge">NEW</span> --}}
        </div>
        <div class="modal-body">
          <div class="announcement-content">
            <div id="announcementLoading" class="announcement-loading">
              <div class="text-center">
                <div class="spinner-border text-primary" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-3">Memuat pengumuman...</p>
              </div>
            </div>
            <div id="announcementContent" style="display: none;">
              <!-- Konten akan dimuat via JavaScript -->
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" id="closeModalBtn">Tutup</button>
          <button type="button" class="btn btn-primary" id="dontShowAgainBtn">
            <i class="fas fa-eye-slash me-2"></i>Jangan Tampilkan Lagi
          </button>
        </div>
      </div>
    </div>
  </div>
  @endif

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

      // ============ MODAL PENGUMUMAN - HANYA DI HOME ============
      @if($activeAnnouncementModal)
      console.log('=== HOME PAGE ANNOUNCEMENT MODAL ===');
      console.log('Current page:', window.location.pathname);
      
      const announcementId = {{ $activeAnnouncementModal->id }};
      const announcementTitle = `{{ $activeAnnouncementModal->title }}`;
      const announcementContent = `{!! str_replace('`', '\\`', $activeAnnouncementModal->content) !!}`;
      const announcementImage = `{{ $activeAnnouncementModal->image ? asset('storage/' . $activeAnnouncementModal->image) : '' }}`;
      const announcementDate = `{{ $activeAnnouncementModal->created_at }}`;
      
      console.log('Announcement Data:', {
        id: announcementId,
        title: announcementTitle.substring(0, 50) + '...',
        hasImage: announcementImage && announcementImage.trim() !== ''
      });
      
      // Elemen modal
      const modalElement = document.getElementById('announcementModal');
      const backdropElement = document.getElementById('announcementBackdrop');
      
      // ==================== FUNGSI UTAMA ====================
      
      // Fungsi untuk cek apakah modal harus ditampilkan
      function shouldShowModal() {
        console.log('🔍 Checking announcement display rules...');
        
        // Rule 1: Cek jika modal element tidak ada
        if (!modalElement) {
          console.log('❌ Modal element not found');
          return false;
        }
        
        // Rule 2: Cek apakah benar-benar di homepage
        // Validasi tambahan di client side
        const currentPath = window.location.pathname;
        const isHomepage = currentPath === '/' || 
                          currentPath === '/home' || 
                          currentPath === '/index' ||
                          currentPath === '/home/index';
        
        if (!isHomepage) {
          console.log('❌ Not on homepage. Current path:', currentPath);
          return false;
        }
        
        // Rule 3: Cek hidden permanen di localStorage
        try {
          const hiddenAnnouncements = JSON.parse(localStorage.getItem('hiddenAnnouncements') || '[]');
          if (hiddenAnnouncements.includes(announcementId)) {
            console.log('❌ Hidden permanently in localStorage');
            return false;
          }
        } catch (e) {
          console.error('Error reading localStorage:', e);
        }
        
        // Rule 4: Cek hidden permanen di cookie
        try {
          const cookieName = `announcement_${announcementId}_hidden`;
          if (document.cookie.includes(`${cookieName}=true`)) {
            console.log('❌ Hidden permanently in cookie');
            return false;
          }
        } catch (e) {
          console.error('Error reading cookie:', e);
        }
        
        // Rule 5: Cek jika sudah ditampilkan dalam session ini
        const sessionKey = `announcement_${announcementId}_shown_in_session`;
        const shownInSession = sessionStorage.getItem(sessionKey);
        
        if (shownInSession === 'true') {
          console.log('❌ Already shown in this browser session');
          return false;
        }
        
        // Rule 6: Cek jika sudah dilihat hari ini (opsional, untuk extra safety)
        const todayKey = `announcement_${announcementId}_shown_date`;
        const lastShownDate = localStorage.getItem(todayKey);
        const today = new Date().toDateString();
        
        if (lastShownDate === today) {
          console.log('❌ Already shown today');
          return false;
        }
        
        console.log('✅ All rules passed - Modal SHOULD be shown');
        return true;
      }
      
      // Fungsi untuk menampilkan modal
      function showAnnouncementModal() {
        console.log('📢 Showing announcement modal on homepage...');
        
        // Tampilkan modal
        modalElement.style.display = 'block';
        
        // Lock body scroll
        document.body.style.overflow = 'hidden';
        document.body.style.paddingRight = '0px';
        
        // Load konten
        loadAnnouncementContent();
        
        // Simpan status bahwa sudah ditampilkan
        saveShownStatus();
      }
      
      // Fungsi untuk menyimpan status "sudah ditampilkan"
      function saveShownStatus() {
        // 1. Simpan di sessionStorage (untuk sekali per session)
        const sessionKey = `announcement_${announcementId}_shown_in_session`;
        sessionStorage.setItem(sessionKey, 'true');
        console.log('💾 Saved to sessionStorage:', sessionKey);
        
        // 2. Simpan tanggal hari ini di localStorage
        const todayKey = `announcement_${announcementId}_shown_date`;
        const today = new Date().toDateString();
        localStorage.setItem(todayKey, today);
        console.log('💾 Saved date to localStorage:', todayKey, '=', today);
      }
      
      // Fungsi untuk menyembunyikan modal
      function hideAnnouncementModal() {
        console.log('Hiding announcement modal...');
        
        if (modalElement) {
          modalElement.style.display = 'none';
        }
        
        // Restore body scroll
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
      }
      
      // Fungsi untuk load konten pengumuman
      function loadAnnouncementContent() {
        console.log('Loading announcement content...');
        
        // Sembunyikan loading
        const loadingElement = document.getElementById('announcementLoading');
        if (loadingElement) {
          loadingElement.style.display = 'none';
        }
        
        // Tampilkan konten
        const contentDiv = document.getElementById('announcementContent');
        if (contentDiv) {
          contentDiv.style.display = 'block';
          
          // Format tanggal
          let formattedDate = 'Tanggal tidak tersedia';
          try {
            const date = new Date(announcementDate.replace(' ', 'T'));
            formattedDate = date.toLocaleDateString('id-ID', {
              weekday: 'long',
              year: 'numeric',
              month: 'long',
              day: 'numeric',
              hour: '2-digit',
              minute: '2-digit'
            });
          } catch (e) {
            console.error('Error formatting date:', e);
          }
          
          // Build HTML
          let html = `
            <div class="announcement-text">
          `;
          
          // Tambahkan gambar jika ada
          if (announcementImage && announcementImage.trim() !== '' && announcementImage !== '{{ asset("") }}') {
            html += `
              <div class="text-center mb-4">
                <img src="${announcementImage}" alt="${announcementTitle}" 
                     class="img-fluid rounded" 
                     style="max-height: 300px; object-fit: contain;"
                     onerror="this.style.display='none'; console.log('Image failed to load')">
              </div>
            `;
          }
          
          // Tambahkan konten
          html += `
              <div class="mt-3">
                ${announcementContent}
              </div>
            </div>
          `;
          
          contentDiv.innerHTML = html;
          
          // Handle image errors
          contentDiv.querySelectorAll('img').forEach(img => {
            img.onerror = function() {
              this.style.display = 'none';
            };
          });
        }
      }
      
      // Fungsi untuk menampilkan toast notification
      function showToast(message, type = 'success') {
        // Hapus toast lama jika ada
        const oldToasts = document.querySelectorAll('.announcement-toast-container');
        oldToasts.forEach(toast => {
          if (toast.parentNode) {
            toast.parentNode.removeChild(toast);
          }
        });
        
        const bgColor = type === 'success' ? 'bg-success' : 'bg-danger';
        
        const toastHtml = `
          <div class="announcement-toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1000000">
            <div class="toast show announcement-toast" role="alert">
              <div class="toast-header ${bgColor} text-white">
                <strong class="me-auto">
                  <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} me-2"></i>
                  ${type === 'success' ? 'Berhasil' : 'Peringatan'}
                </strong>
                <button type="button" class="btn-close btn-close-white" onclick="this.closest('.announcement-toast-container').remove()"></button>
              </div>
              <div class="toast-body">
                ${message}
              </div>
            </div>
          </div>
        `;
        
        document.body.insertAdjacentHTML('beforeend', toastHtml);
        
        // Auto remove setelah 3 detik
        setTimeout(() => {
          const toast = document.querySelector('.announcement-toast-container');
          if (toast && toast.parentNode) {
            toast.parentNode.removeChild(toast);
          }
        }, 3000);
      }
      
      // Setup event listeners
      function setupEventListeners() {
        console.log('Setting up announcement modal event listeners...');
        
        // Tombol close di header
        const closeHeaderBtn = document.getElementById('announcementCloseBtn');
        if (closeHeaderBtn) {
          closeHeaderBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            hideAnnouncementModal();
          });
        }
        
        // Tombol close di footer
        const closeFooterBtn = document.getElementById('closeModalBtn');
        if (closeFooterBtn) {
          closeFooterBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            hideAnnouncementModal();
          });
        }
        
        // Tombol "Jangan Tampilkan Lagi"
        const dontShowBtn = document.getElementById('dontShowAgainBtn');
        if (dontShowBtn) {
          dontShowBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            console.log('🚫 User clicked "Jangan Tampilkan Lagi"');
            
            try {
              // 1. Simpan ke localStorage untuk hidden permanen
              const hiddenAnnouncements = JSON.parse(localStorage.getItem('hiddenAnnouncements') || '[]');
              if (!hiddenAnnouncements.includes(announcementId)) {
                hiddenAnnouncements.push(announcementId);
                localStorage.setItem('hiddenAnnouncements', JSON.stringify(hiddenAnnouncements));
                console.log('💾 Saved to hiddenAnnouncements in localStorage');
              }
              
              // 2. Hapus sessionStorage entry
              const sessionKey = `announcement_${announcementId}_shown_in_session`;
              sessionStorage.removeItem(sessionKey);
              
              // 3. Hapus tanggal shown
              const todayKey = `announcement_${announcementId}_shown_date`;
              localStorage.removeItem(todayKey);
              
              // 4. Set cookie untuk hidden permanen (30 hari)
              const date = new Date();
              date.setTime(date.getTime() + (30 * 24 * 60 * 60 * 1000));
              const expires = "expires=" + date.toUTCString();
              document.cookie = `announcement_${announcementId}_hidden=true; ${expires}; path=/; SameSite=Lax`;
              console.log('🍪 Set permanent hide cookie');
              
              // 5. Tutup modal
              hideAnnouncementModal();
              
              // 6. Show success toast
              showToast('Pengumuman ini tidak akan ditampilkan lagi.', 'success');
              
            } catch (error) {
              console.error('Error hiding announcement:', error);
              showToast('Terjadi kesalahan. Silakan coba lagi.', 'error');
            }
          });
        }
        
        // Klik backdrop untuk close
        if (backdropElement) {
          backdropElement.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            hideAnnouncementModal();
          });
        }
        
        // Escape key untuk close
        document.addEventListener('keydown', function(e) {
          if (e.key === 'Escape' && modalElement.style.display === 'block') {
            hideAnnouncementModal();
          }
        });
      }
      
      // ==================== INISIALISASI ====================
      
      // Setup event listeners terlebih dahulu
      setupEventListeners();
      
      // Cek dan tampilkan modal jika diperlukan
      // Delay 1 detik untuk UX yang lebih baik
      setTimeout(() => {
        if (shouldShowModal()) {
          console.log('🔄 Modal will be shown now on homepage');
          showAnnouncementModal();
        } else {
          console.log('⏸️ Modal will NOT be shown (rules not met)');
        }
      }, 1000);
      
      // ==================== DEBUG FUNCTIONS ====================
      
      // Debug function untuk melihat status
      window.debugAnnouncementStatus = function() {
        console.log('=== ANNOUNCEMENT DEBUG STATUS ===');
        console.log('Announcement ID:', announcementId);
        console.log('Current path:', window.location.pathname);
        console.log('Modal element exists:', !!modalElement);
        
        const hiddenAnnouncements = JSON.parse(localStorage.getItem('hiddenAnnouncements') || '[]');
        console.log('Hidden in localStorage:', hiddenAnnouncements.includes(announcementId));
        
        const sessionKey = `announcement_${announcementId}_shown_in_session`;
        console.log('Shown in session:', sessionStorage.getItem(sessionKey));
        
        const todayKey = `announcement_${announcementId}_shown_date`;
        console.log('Shown date:', localStorage.getItem(todayKey));
        
        console.log('Cookie check:', document.cookie.includes(`announcement_${announcementId}_hidden=true`));
        console.log('Should show?', shouldShowModal());
        console.log('================================');
      };
      
      // Debug function untuk reset status
      window.resetAnnouncementStatus = function() {
        console.log('Resetting announcement status...');
        
        // Hapus dari localStorage
        const hiddenAnnouncements = JSON.parse(localStorage.getItem('hiddenAnnouncements') || '[]');
        const index = hiddenAnnouncements.indexOf(announcementId);
        if (index > -1) {
          hiddenAnnouncements.splice(index, 1);
          localStorage.setItem('hiddenAnnouncements', JSON.stringify(hiddenAnnouncements));
        }
        
        // Hapus sessionStorage
        const sessionKey = `announcement_${announcementId}_shown_in_session`;
        sessionStorage.removeItem(sessionKey);
        
        // Hapus tanggal
        const todayKey = `announcement_${announcementId}_shown_date`;
        localStorage.removeItem(todayKey);
        
        // Hapus cookie
        document.cookie = `announcement_${announcementId}_hidden=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;`;
        
        console.log('✅ Status reset complete!');
        console.log('Reload page to see modal again.');
        
        // Optionally reload
        // window.location.reload();
      };
      
      // Auto debug info setelah 3 detik
      setTimeout(() => {
        console.log('=== AUTO-DEBUG INFO ===');
        window.debugAnnouncementStatus();
      }, 3000);
      
      @else
      console.log('No announcement modal on this page (not homepage or no active announcement)');
      @endif

      // ============ SWIPER ============
      
      // Swiper untuk Galeri
      const galerySwiper = document.querySelector('.galerySwiper');
      if (galerySwiper) {
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
      }

      // Swiper untuk Alumni
      const alumniSwiper = document.querySelector('.alumniSwiper');
      if (alumniSwiper) {
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
      }

      // Swiper untuk MOU
      const mouSwiperEl = document.querySelector('.mouSwiper');
      if (mouSwiperEl) {
        const mouSwiper = new Swiper('.mouSwiper', {
          loop: true,
          slidesPerView: 5,
          spaceBetween: 20,
          speed: 4000,
          allowTouchMove: true,
          grabCursor: true,
          
          autoplay: {
            delay: 0,
            disableOnInteraction: false,
            pauseOnMouseEnter: false,
            waitForTransition: true,
            stopOnLastSlide: false,
          },
          
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
              speed: 5000
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
          
          on: {
            init: function() {
              this.wrapperEl.style.transitionTimingFunction = 'linear';
              
              if (this.slides.length > 0) {
                const wrapper = this.wrapperEl;
                const originalSlides = Array.from(this.slides);
                
                originalSlides.forEach(slide => {
                  const clone = slide.cloneNode(true);
                  clone.classList.add('swiper-slide-duplicate');
                  wrapper.appendChild(clone);
                });
                
                originalSlides.forEach(slide => {
                  const clone = slide.cloneNode(true);
                  clone.classList.add('swiper-slide-duplicate');
                  wrapper.appendChild(clone);
                });
              }
            },
            
            transitionEnd: function() {
              if (this && this.progress > 0.66) {
                this.slideTo(0, 0, false);
              }
            },
            
            autoplayStop: function() {
              setTimeout(() => {
                this.autoplay.start();
              }, 100);
            }
          }
        });

        // Restart autoplay MOU setiap 30 detik
        setInterval(() => {
          if (mouSwiper && !mouSwiper.autoplay.running) {
            mouSwiper.autoplay.start();
          }
        }, 30000);
      }

      // ============ NAVBAR SCROLL EFFECT ============
      document.addEventListener("scroll", function () {
        const navbar = document.getElementById("mainNavbar");
        if (navbar) {
          if (window.scrollY > 50) {
            navbar.classList.add("navbar-scrolled");
          } else {
            navbar.classList.remove("navbar-scrolled");
          }
        }
      });

      // ============ DROPDOWN FIX ============
      const dropdowns = document.querySelectorAll('.nav-item.dropdown');
      const toggles = document.querySelectorAll('.nav-item.dropdown > .nav-link, .nav-item.dropdown > button');

      // Desktop (Hover)
      function handleDesktopDropdown() {
        dropdowns.forEach(item => {
          item.addEventListener('mouseenter', () => {
            const dropdown = item.querySelector('.dropdown-menu');
            if (dropdown) dropdown.classList.add('show');
          });
          item.addEventListener('mouseleave', () => {
            const dropdown = item.querySelector('.dropdown-menu');
            if (dropdown) {
              setTimeout(() => {
                if (!item.matches(':hover')) dropdown.classList.remove('show');
              }, 150);
            }
          });
        });
      }

      // Mobile (Click)
      function handleMobileDropdown() {
        toggles.forEach(toggle => {
          toggle.addEventListener('click', function (e) {
            if (window.innerWidth < 992) {
              e.preventDefault();
              e.stopPropagation();

              const parent = this.closest('.dropdown');
              if (parent) {
                const isActive = parent.classList.contains('show');

                document.querySelectorAll('.dropdown.show').forEach(d => d.classList.remove('show'));

                if (!isActive) parent.classList.add('show');
              }
            }
          });
        });
      }

      // Inisialisasi berdasarkan ukuran layar
      if (window.innerWidth >= 992) {
        handleDesktopDropdown();
      } else {
        handleMobileDropdown();
      }

      // Update saat resize
      window.addEventListener('resize', () => {
        document.querySelectorAll('.dropdown.show').forEach(d => d.classList.remove('show'));
        
        if (window.innerWidth >= 992) {
          handleDesktopDropdown();
        } else {
          handleMobileDropdown();
        }
      });
      
      // Fix untuk klik di luar dropdown pada mobile
      document.addEventListener('click', function(e) {
        if (window.innerWidth < 992) {
          const isDropdownToggle = e.target.closest('.dropdown-toggle');
          const isInDropdown = e.target.closest('.dropdown-menu');
          
          if (!isDropdownToggle && !isInDropdown) {
            document.querySelectorAll('.dropdown.show').forEach(d => d.classList.remove('show'));
          }
        }
      });
    });
  </script>

  @stack('scripts')
</body>
</html>
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="false">
  <div class="container-fluid py-1 px-3">
    
    {{-- LEFT SIDE: BREADCRUMB & TOGGLER (MOBILE) --}}
    <div class="d-flex align-items-center">
      {{-- HAMBURGER MENU (MOBILE) --}}
      <div class="d-xl-none me-3">
        <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
          <div class="sidenav-toggler-inner">
            <i class="fas fa-bars fa-lg"></i>
          </div>
        </a>
      </div>
      
      {{-- BREADCRUMB --}}
      <nav aria-label="breadcrumb" class="d-none d-sm-block">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
          <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
          <li class="breadcrumb-item text-sm text-white active" aria-current="page">Dashboard</li>
        </ol>
        <h6 class="font-weight-bolder text-white mb-0">Dashboard</h6>
      </nav>
    </div>

    {{-- RIGHT SIDE: USER PROFILE --}}
    <div class="collapse navbar-collapse justify-content-end" id="navbar">
      <ul class="navbar-nav align-items-center">
        
        {{-- USER PROFILE DROPDOWN --}}
        <li class="nav-item dropdown d-flex align-items-center" id="userDropdownContainer">
          <a href="javascript:;" class="nav-link text-white p-0 d-flex align-items-center" 
             id="userDropdown">
             
            <div class="d-flex align-items-center">
              {{-- Avatar/Profile Picture --}}
              <div class="avatar avatar-sm me-2">
                <img src="{{ asset('assets/img/team-2.jpg') }}" 
                     alt="Profile" 
                     class="avatar-img rounded-circle border border-white border-2"
                     style="width: 36px; height: 36px; object-fit: cover;">
              </div>
              
              {{-- User Info (hidden on mobile) --}}
              <div class="d-none d-md-flex flex-column align-items-start me-2">
                <span class="text-sm font-weight-bold mb-0">Nama User</span>
                <span class="text-xs opacity-8">Admin</span>
              </div>
              
              {{-- Dropdown Arrow (hidden on mobile) --}}
              <i class="fas fa-chevron-down text-xs opacity-8 d-none d-md-block"></i>
            </div>
          </a>
          
          {{-- DROPDOWN MENU --}}
          <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4" 
              id="userDropdownMenu"
              style="min-width: 200px;">
            
            {{-- Header with User Info --}}
            <li class="mb-2 px-3 py-2">
              <div class="d-flex align-items-center">
                <div class="avatar me-3">
                  <img src="{{ asset('assets/img/team-2.jpg') }}" 
                       alt="Profile" 
                       class="avatar-img rounded-circle"
                       style="width: 48px; height: 48px; object-fit: cover;">
                </div>
                <div class="d-flex flex-column">
                  <h6 class="mb-0 text-sm font-weight-bold">Nama User</h6>
                  <p class="text-xs text-secondary mb-0">admin@sekolah.sch.id</p>
                  <span class="badge bg-primary text-xs mt-1">Administrator</span>
                </div>
              </div>
            </li>
            
            <li><hr class="horizontal dark my-2"></li>
            
            {{-- Profile Link --}}
            <li class="mb-1">
              <a class="dropdown-item border-radius-md" href="#">
                <div class="d-flex align-items-center py-1">
                  <div class="icon icon-sm text-center me-3 d-flex align-items-center justify-content-center">
                    <i class="fas fa-user text-dark opacity-10"></i>
                  </div>
                  <span class="text-sm">Profil Saya</span>
                </div>
              </a>
            </li>
            
            {{-- Settings Link --}}
            <li class="mb-1">
              <a class="dropdown-item border-radius-md" href="#">
                <div class="d-flex align-items-center py-1">
                  <div class="icon icon-sm text-center me-3 d-flex align-items-center justify-content-center">
                    <i class="fas fa-cog text-dark opacity-10"></i>
                  </div>
                  <span class="text-sm">Pengaturan</span>
                </div>
              </a>
            </li>
            
            <li><hr class="horizontal dark my-2"></li>
            
            {{-- Logout --}}
            <li>
              <form action="{{ route('backend.logout') }}" method="POST" class="mb-0">
                @csrf
                <button type="submit" class="dropdown-item border-radius-md w-100 text-start p-0">
                  <div class="d-flex align-items-center py-1">
                    <div class="icon icon-sm text-center me-3 d-flex align-items-center justify-content-center">
                      <i class="fas fa-sign-out-alt text-danger opacity-10"></i>
                    </div>
                    <span class="text-sm">Logout</span>
                  </div>
                </button>
              </form>
            </li>
          </ul>
        </li>
        
      </ul>
    </div>
  </div>
</nav>

<style>
/* Custom styles untuk navbar */
.navbar-main {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  min-height: 70px;
  position: relative;
  z-index: 1030;
}

.avatar-img {
  object-fit: cover;
}

.dropdown-menu {
  border: none;
  box-shadow: 0 10px 30px 0 rgba(31, 45, 61, 0.1);
  border-radius: 0.75rem;
}

.dropdown-item {
  border-radius: 0.5rem;
  padding: 0.5rem 1rem;
}

.dropdown-item:hover {
  background-color: #f8f9fa;
}

.nav-link:hover {
  opacity: 0.8;
}

/* Mobile hamburger styling */
.sidenav-toggler-inner {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 30px;
  height: 30px;
}

/* Breadcrumb mobile adjustment */
@media (max-width: 576px) {
  .breadcrumb {
    font-size: 0.8rem;
  }
  
  .font-weight-bolder {
    font-size: 0.9rem;
  }
  
  .container-fluid {
    padding-left: 1rem !important;
    padding-right: 1rem !important;
  }
  
  .mx-4 {
    margin-left: 1rem !important;
    margin-right: 1rem !important;
  }
}

/* ========== DROPDOWN STYLES ========== */
.nav-item.dropdown {
  position: relative;
}

/* DESKTOP STYLES - Hover & Click functionality */
@media (min-width: 992px) {
  /* Default state - hidden */
  .nav-item.dropdown .dropdown-menu {
    position: absolute !important;
    top: 100% !important;
    right: 0 !important;
    left: auto !important;
    margin-top: 0.5rem !important;
    display: block !important; /* Selalu ada di DOM */
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s ease;
    pointer-events: none;
  }
  
  /* Hover state - show */
  .nav-item.dropdown:hover .dropdown-menu,
  /* Click state - show (via JS) */
  .nav-item.dropdown .dropdown-menu.show {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
    pointer-events: auto;
  }
  
  /* Keep dropdown open when hovering over dropdown itself */
  .dropdown-menu:hover {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
  }
}

/* MOBILE STYLES - Click functionality only */
@media (max-width: 991.98px) {
  /* Hide user info on mobile */
  .d-none.d-md-flex {
    display: none !important;
  }
  
  /* Default state - hidden */
  .nav-item.dropdown .dropdown-menu {
    position: fixed !important;
    right: 15px !important;
    top: 70px !important;
    left: auto !important;
    z-index: 1060 !important;
    width: auto !important;
    min-width: 250px !important;
    display: block !important;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s ease;
    pointer-events: none;
  }
  
  /* Click state - show */
  .nav-item.dropdown .dropdown-menu.show {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
    pointer-events: auto;
  }
  
  /* Disable hover on mobile */
  .nav-item.dropdown:hover .dropdown-menu {
    opacity: 0 !important;
    visibility: hidden !important;
    transform: translateY(-10px) !important;
  }
  
  /* Adjust for very small screens */
  @media (max-width: 576px) {
    .nav-item.dropdown .dropdown-menu {
      right: 10px !important;
      top: 65px !important;
      max-width: calc(100vw - 20px);
    }
  }
  
  /* Adjust avatar margin on mobile */
  .avatar-sm.me-2 {
    margin-right: 0 !important;
  }
  
  /* Ensure proper alignment */
  .navbar-nav {
    flex-direction: row;
    align-items: center;
    margin-left: auto;
  }
  
  .nav-item {
    margin-left: 0.5rem;
  }
}

/* Badge styling */
.badge {
  font-size: 0.6rem;
  font-weight: 600;
  padding: 0.25rem 0.5rem;
}

/* Ensure navbar collapses properly */
.navbar-collapse {
  flex-grow: 0;
}

/* Hamburger button animation */
#iconNavbarSidenav:hover .sidenav-toggler-inner {
  transform: rotate(90deg);
  transition: transform 0.3s ease;
}

/* Smooth animation */
.nav-item.dropdown .dropdown-menu {
  transition: opacity 0.3s ease, visibility 0.3s ease, transform 0.3s ease;
}
</style>

<script>
// USER DROPDOWN SAJA - SIDEBAR TOGGLE DIPINDAH KE LAYOUT UTAMA
document.addEventListener('DOMContentLoaded', function() {
  // ========== USER DROPDOWN FUNCTIONALITY ==========
  const userDropdown = document.getElementById('userDropdown');
  const userDropdownMenu = document.getElementById('userDropdownMenu');
  const userDropdownContainer = document.getElementById('userDropdownContainer');
  
  if (userDropdown && userDropdownMenu && userDropdownContainer) {
    let isMobile = window.innerWidth < 992;
    let isClickOpened = false;
    
    // Update isMobile on resize
    window.addEventListener('resize', function() {
      isMobile = window.innerWidth < 992;
    });
    
    // ========== CLICK FUNCTIONALITY ==========
    userDropdown.addEventListener('click', function(e) {
      e.preventDefault();
      e.stopPropagation();
      
      // Toggle dropdown
      if (userDropdownMenu.classList.contains('show')) {
        userDropdownMenu.classList.remove('show');
        isClickOpened = false;
      } else {
        userDropdownMenu.classList.add('show');
        isClickOpened = true;
        
        // Close other dropdowns if any
        document.querySelectorAll('.dropdown-menu.show').forEach(function(menu) {
          if (menu !== userDropdownMenu) {
            menu.classList.remove('show');
          }
        });
      }
    });
    
    // ========== HOVER SUPPORT FOR DESKTOP ==========
    if (!isMobile) {
      // Saat hover masuk ke dropdown menu, pastikan tetap terbuka
      userDropdownMenu.addEventListener('mouseenter', function() {
        if (isClickOpened) {
          userDropdownMenu.classList.add('show');
        }
      });
      
      // Saat hover keluar dari dropdown menu (hanya untuk click mode)
      userDropdownMenu.addEventListener('mouseleave', function(e) {
        // Cek jika dropdown dibuka dengan click (bukan hover)
        if (isClickOpened) {
          // Cek apakah mouse pergi ke trigger atau masih di dropdown
          setTimeout(() => {
            const isHoveringTrigger = userDropdownContainer.matches(':hover');
            const isHoveringMenu = userDropdownMenu.matches(':hover');
            
            if (!isHoveringTrigger && !isHoveringMenu) {
              userDropdownMenu.classList.remove('show');
              isClickOpened = false;
            }
          }, 100);
        }
      });
      
      // Saat hover keluar dari container (untuk click mode)
      userDropdownContainer.addEventListener('mouseleave', function(e) {
        if (isClickOpened) {
          // Cek apakah mouse pergi ke dropdown menu
          const isGoingToMenu = e.relatedTarget && userDropdownMenu.contains(e.relatedTarget);
          
          if (!isGoingToMenu) {
            setTimeout(() => {
              const isHoveringMenu = userDropdownMenu.matches(':hover');
              
              if (!isHoveringMenu) {
                userDropdownMenu.classList.remove('show');
                isClickOpened = false;
              }
            }, 100);
          }
        }
      });
    }
    
    // ========== CLOSE DROPDOWN WHEN CLICKING OUTSIDE ==========
    document.addEventListener('click', function(e) {
      if (isClickOpened) {
        if (!userDropdownContainer.contains(e.target) && !userDropdownMenu.contains(e.target)) {
          userDropdownMenu.classList.remove('show');
          isClickOpened = false;
        }
      }
    });
    
    // Prevent dropdown from closing when clicking inside (for form submissions)
    userDropdownMenu.addEventListener('click', function(e) {
      e.stopPropagation();
      // Keep dropdown open when clicking inside (except for form submissions)
      if (!e.target.closest('form')) {
        isClickOpened = true;
        userDropdownMenu.classList.add('show');
      }
    });
  }
});
</script>
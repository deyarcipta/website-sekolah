<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl mt-3" id="navbarBlur" data-scroll="false">
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
        <li class="nav-item dropdown d-flex align-items-center">
          <a href="javascript:;" class="nav-link text-white p-0 d-flex align-items-center" 
             id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
             
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
              aria-labelledby="userDropdown"
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

/* Responsive adjustments */
@media (max-width: 768px) {
  .d-none.d-md-flex {
    display: none !important;
  }
  
  .avatar-sm {
    margin-right: 0 !important;
  }
  
  .dropdown-menu {
    margin-right: -1rem !important;
  }
  
  /* Ensure navbar items are properly aligned */
  .navbar-nav {
    flex-direction: row;
    align-items: center;
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
</style>

<script>
// Script untuk hamburger menu toggle
document.addEventListener('DOMContentLoaded', function() {
  const iconSidenav = document.getElementById('iconNavbarSidenav');
  const sidenav = document.getElementById('sidenav-main');
  const body = document.getElementsByTagName('body')[0];
  
  if (iconSidenav && sidenav) {
    // Toggle sidebar
    iconSidenav.addEventListener('click', function(e) {
      e.preventDefault();
      
      if (body.classList.contains('g-sidenav-pinned')) {
        // Close sidebar
        body.classList.remove('g-sidenav-pinned');
        body.classList.add('g-sidenav-hidden');
        sidenav.classList.remove('show');
      } else {
        // Open sidebar
        body.classList.remove('g-sidenav-hidden');
        body.classList.add('g-sidenav-pinned');
        sidenav.classList.add('show');
      }
      
      // Toggle aria-expanded
      const isExpanded = iconSidenav.getAttribute('aria-expanded') === 'true';
      iconSidenav.setAttribute('aria-expanded', !isExpanded);
    });
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
      if (window.innerWidth < 1200) {
        if (!sidenav.contains(event.target) && !iconSidenav.contains(event.target)) {
          if (body.classList.contains('g-sidenav-pinned')) {
            body.classList.remove('g-sidenav-pinned');
            body.classList.add('g-sidenav-hidden');
            sidenav.classList.remove('show');
            iconSidenav.setAttribute('aria-expanded', 'false');
          }
        }
      }
    });
  }
  
  // Optional: Add smooth interactions for user dropdown
  const userDropdown = document.getElementById('userDropdown');
  if (userDropdown) {
    const dropdownMenu = userDropdown.nextElementSibling;
    
    // Add hover effect for desktop
    if (window.innerWidth >= 768) {
      userDropdown.addEventListener('mouseenter', function() {
        dropdownMenu.classList.add('show');
      });
      
      userDropdown.addEventListener('mouseleave', function() {
        setTimeout(() => {
          if (!dropdownMenu.matches(':hover')) {
            dropdownMenu.classList.remove('show');
          }
        }, 100);
      });
      
      dropdownMenu.addEventListener('mouseleave', function() {
        dropdownMenu.classList.remove('show');
      });
    }
  }
});
</script>
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
                      id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        
                        <div class="d-flex align-items-center">
                            {{-- Avatar/Profile Picture --}}
                            <div class="avatar avatar-sm me-2">
                                @if(auth()->user()->foto_profil_url)
                                    <img src="{{ auth()->user()->foto_profil_url }}" 
                                        alt="{{ auth()->user()->name }}" 
                                        class="avatar-img rounded-circle border border-white border-2"
                                        style="width: 36px; height: 36px; object-fit: cover;">
                                @else
                                    <img src="{{ asset('assets/img/team-2.jpg') }}" 
                                        alt="Profile" 
                                        class="avatar-img rounded-circle border border-white border-2"
                                        style="width: 36px; height: 36px; object-fit: cover;">
                                @endif
                            </div>
                            
                            {{-- User Info (hidden on mobile) --}}
                            <div class="d-none d-md-flex flex-column align-items-start me-2">
                                <span class="text-sm font-weight-bold mb-0">{{ auth()->user()->name }}</span>
                                <span class="text-xs opacity-8">
                                    {{ auth()->user()->role == 'superadmin' ? 'Super Admin' : 'Admin' }}
                                </span>
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
                                    @if(auth()->user()->foto_profil_url)
                                        <img src="{{ auth()->user()->foto_profil_url }}" 
                                            alt="{{ auth()->user()->name }}" 
                                            class="avatar-img rounded-circle"
                                            style="width: 48px; height: 48px; object-fit: cover;">
                                    @else
                                        <img src="{{ asset('assets/img/team-2.jpg') }}" 
                                            alt="Profile" 
                                            class="avatar-img rounded-circle"
                                            style="width: 48px; height: 48px; object-fit: cover;">
                                    @endif
                                </div>
                                <div class="d-flex flex-column">
                                    <h6 class="mb-0 text-sm font-weight-bold">{{ auth()->user()->name }}</h6>
                                    <p class="text-xs text-secondary mb-0">{{ auth()->user()->email }}</p>
                                    <span class="badge bg-{{ auth()->user()->role == 'superadmin' ? 'danger' : 'primary' }} text-xs mt-1">
                                        {{ auth()->user()->role == 'superadmin' ? 'Super Administrator' : 'Administrator' }}
                                    </span>
                                </div>
                            </div>
                        </li>
                        
                        <li><hr class="horizontal dark my-2"></li>
                        
                        {{-- Profile Link --}}
                        <li class="mb-1">
                            <a class="dropdown-item border-radius-md" href="javascript:;" id="btnEditProfile">
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
                            <a class="dropdown-item border-radius-md" href="{{ route('backend.settings.index') }}">
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

<!-- Modal Edit Profile -->
<div class="modal fade" id="modalEditProfile" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formEditProfile" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="form_method" name="_method" value="PUT">
                
                <div class="modal-header bg-gradient-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-user-edit me-2"></i>
                        Edit Profil Saya
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                
                <div class="modal-body">
                    <div class="row">
                        <!-- Left Column - Photo & Basic Info -->
                        <div class="col-md-4">
                            <!-- Photo Upload -->
                            <div class="card border-0 bg-light">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <div class="avatar-preview mb-3">
                                            <img src="{{ auth()->user()->foto_profil_url ?? asset('assets/img/team-2.jpg') }}" 
                                                class="img-fluid rounded-circle border shadow"
                                                style="width: 150px; height: 150px; object-fit: cover;"
                                                id="profileFotoPreview"
                                                alt="Profile Preview">
                                        </div>
                                        <div class="d-grid gap-2">
                                            <input type="file" 
                                                  class="form-control d-none" 
                                                  name="foto_profil" 
                                                  id="profileFotoInput"
                                                  accept="image/*">
                                            <button type="button" 
                                                    class="btn btn-outline-primary btn-sm" 
                                                    id="btnUploadProfileFoto">
                                                <i class="fas fa-camera me-1"></i> Upload Foto Baru
                                            </button>
                                            <button type="button" 
                                                    class="btn btn-outline-secondary btn-sm" 
                                                    id="btnRemoveProfileFoto"
                                                    style="display: none;">
                                                <i class="fas fa-trash me-1"></i> Hapus Foto
                                            </button>
                                        </div>
                                        <div class="form-text mt-2">
                                            Format: JPG, PNG, GIF. Maks: 2MB
                                        </div>
                                        <div class="invalid-feedback" id="profile_foto_error"></div>
                                    </div>
                                    
                                    <!-- User Role Info -->
                                    <div class="mt-3 pt-3 border-top">
                                        <small class="text-muted d-block mb-1">
                                            <i class="fas fa-id-card me-1"></i>
                                            ID: {{ auth()->user()->id }}
                                        </small>
                                        <small class="text-muted d-block mb-1">
                                            <i class="fas fa-calendar-plus me-1"></i>
                                            Bergabung: {{ auth()->user()->created_at->format('d/m/Y') }}
                                        </small>
                                        <small class="text-muted d-block">
                                            <i class="fas fa-user-tag me-1"></i>
                                            Role: {{ auth()->user()->role == 'superadmin' ? 'Super Administrator' : 'Administrator' }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right Column - Form Fields -->
                        <div class="col-md-8">
                            <!-- Tabs -->
                            <ul class="nav nav-tabs mb-3" id="profileTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="basic-info-tab" data-bs-toggle="tab" 
                                            data-bs-target="#basic-info" type="button" role="tab">
                                        <i class="fas fa-user me-1"></i> Info Dasar
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="profile-security-tab" data-bs-toggle="tab" 
                                            data-bs-target="#profile-security" type="button" role="tab">
                                        <i class="fas fa-shield-alt me-1"></i> Keamanan
                                    </button>
                                </li>
                            </ul>
                            
                            <div class="tab-content" id="profileTabContent">
                                <!-- Tab 1: Basic Info -->
                                <div class="tab-pane fade show active" id="basic-info" role="tabpanel">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            Nama Lengkap <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" 
                                              class="form-control" 
                                              name="name" 
                                              id="profileName"
                                              placeholder="Masukkan nama lengkap"
                                              value="{{ auth()->user()->name }}"
                                              required>
                                        <div class="invalid-feedback" id="profile_name_error"></div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            Email <span class="text-danger">*</span>
                                        </label>
                                        <input type="email" 
                                              class="form-control" 
                                              name="email" 
                                              id="profileEmail"
                                              placeholder="contoh@sekolah.sch.id"
                                              value="{{ auth()->user()->email }}"
                                              required>
                                        <div class="invalid-feedback" id="profile_email_error"></div>
                                        <div class="form-text">
                                            Email ini digunakan untuk login
                                        </div>
                                    </div>
                                    
                                    <!-- Additional Info -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">
                                                    Terakhir Login
                                                </label>
                                                <input type="text" 
                                                      class="form-control bg-light"
                                                      value="{{ auth()->user()->last_login_at ? auth()->user()->last_login_at->format('d/m/Y H:i') : 'Belum pernah login' }}"
                                                      readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">
                                                    Status Akun
                                                </label>
                                                <div class="form-control bg-light">
                                                    <span class="badge bg-{{ auth()->user()->is_active ? 'success' : 'secondary' }}">
                                                        {{ auth()->user()->is_active ? 'Aktif' : 'Nonaktif' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Tab 2: Security -->
                                <div class="tab-pane fade" id="profile-security" role="tabpanel">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Kosongkan password jika tidak ingin mengubahnya
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            Password Saat Ini
                                        </label>
                                        <div class="input-group">
                                            <input type="password" 
                                                  class="form-control" 
                                                  name="current_password" 
                                                  id="currentPassword"
                                                  placeholder="Masukkan password saat ini">
                                            <button class="btn btn-outline-secondary" type="button" id="toggleCurrentPassword">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        <div class="invalid-feedback" id="current_password_error"></div>
                                        <div class="form-text">
                                            Diperlukan untuk mengubah email atau password
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            Password Baru
                                        </label>
                                        <div class="input-group">
                                            <input type="password" 
                                                  class="form-control" 
                                                  name="password" 
                                                  id="newPassword"
                                                  placeholder="Minimal 8 karakter">
                                            <button class="btn btn-outline-secondary" type="button" id="toggleNewPassword">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        <div class="invalid-feedback" id="profile_password_error"></div>
                                        <div class="form-text">
                                            Gunakan kombinasi huruf, angka, dan simbol untuk keamanan maksimal
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            Konfirmasi Password Baru
                                        </label>
                                        <div class="input-group">
                                            <input type="password" 
                                                  class="form-control" 
                                                  name="password_confirmation" 
                                                  id="confirmNewPassword"
                                                  placeholder="Ulangi password baru">
                                            <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        <div class="invalid-feedback" id="password_confirmation_error"></div>
                                    </div>
                                    
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        Pastikan Anda mengingat password baru. Jika lupa, hubungi administrator.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary" id="btnSimpanProfile">
                        <i class="fas fa-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

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

/* Perbaikan untuk input group di modal profil */
#modalEditProfile .input-group {
    height: 42px; /* Atur tinggi tetap untuk semua input group */
}

#modalEditProfile .input-group .form-control {
    height: 42px;
    padding: 8px 12px;
    border-radius: 0.375rem 0 0 0.375rem;
    border: 1px solid #ced4da;
}

#modalEditProfile .input-group .btn-outline-secondary {
    height: 42px;
    width: 42px;
    padding: 8px;
    border-radius: 0 0.375rem 0.375rem 0;
    border: 1px solid #ced4da;
    border-left: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Pastikan icon sejajar vertikal */
#modalEditProfile .input-group .btn-outline-secondary i {
    font-size: 16px;
    line-height: 1;
}

/* Hover state */
#modalEditProfile .input-group .btn-outline-secondary:hover {
    background-color: #f8f9fa;
    border-color: #adb5bd;
}

/* Focus state */
#modalEditProfile .input-group .form-control:focus {
    border-color: #6b02b1;
    box-shadow: 0 0 0 0.2rem rgba(107, 2, 177, 0.25);
    z-index: 3; /* Pastikan input di atas button saat focus */
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

/* DESKTOP STYLES - Click functionality only (no hover) */
@media (min-width: 992px) {
    .nav-item.dropdown .dropdown-menu {
        position: absolute !important;
        top: 100% !important;
        right: 0 !important;
        left: auto !important;
        margin-top: 0.125rem !important;
        display: none; /* Hidden by default */
        opacity: 0;
        transform: translateY(-10px);
        transition: opacity 0.2s ease, transform 0.2s ease;
    }
    
    /* Hanya tampilkan saat class 'show' ada */
    .nav-item.dropdown .dropdown-menu.show {
        display: block !important;
        opacity: 1;
        transform: translateY(0);
    }
}

/* MOBILE STYLES - Click functionality with fixed positioning */
@media (max-width: 991.98px) {
    /* Hide user info on mobile */
    .d-none.d-md-flex {
        display: none !important;
    }
    
    /* Fixed positioning for mobile dropdown */
    .nav-item.dropdown .dropdown-menu {
        position: fixed !important;
        right: 15px !important;
        top: 70px !important;
        left: auto !important;
        z-index: 1060 !important;
        width: auto !important;
        min-width: 250px !important;
        display: none; /* Hidden by default */
        opacity: 0;
        transform: translateY(-10px);
        transition: opacity 0.2s ease, transform 0.2s ease;
    }
    
    .nav-item.dropdown .dropdown-menu.show {
        display: block !important;
        opacity: 1;
        transform: translateY(0);
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
</style>

<script>
// USER DROPDOWN FUNCTIONALITY - CLICK ONLY (NO HOVER)
document.addEventListener('DOMContentLoaded', function() {
    // Dropdown functionality
    const userDropdown = document.getElementById('userDropdown');
    const userDropdownMenu = document.getElementById('userDropdownMenu');
    
    if (userDropdown && userDropdownMenu) {
        userDropdown.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const isShowing = userDropdownMenu.classList.contains('show');
            
            // Close all other dropdowns
            document.querySelectorAll('.dropdown-menu.show').forEach(function(menu) {
                if (menu !== userDropdownMenu) {
                    menu.classList.remove('show');
                }
            });
            
            // Toggle current dropdown
            if (!isShowing) {
                userDropdownMenu.classList.add('show');
            } else {
                userDropdownMenu.classList.remove('show');
            }
        });
        
        document.addEventListener('click', function(e) {
            if (userDropdownMenu.classList.contains('show')) {
                if (!userDropdown.contains(e.target) && !userDropdownMenu.contains(e.target)) {
                    userDropdownMenu.classList.remove('show');
                }
            }
        });
        
        userDropdownMenu.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }

    // PROFILE EDIT MODAL FUNCTIONALITY
    const modalEditProfile = new bootstrap.Modal('#modalEditProfile');
    const formEditProfile = document.getElementById('formEditProfile');
    const btnEditProfile = document.getElementById('btnEditProfile');
    
    // Elements untuk foto profil
    const profileFotoInput = document.getElementById('profileFotoInput');
    const profileFotoPreview = document.getElementById('profileFotoPreview');
    const btnUploadProfileFoto = document.getElementById('btnUploadProfileFoto');
    const btnRemoveProfileFoto = document.getElementById('btnRemoveProfileFoto');
    
    // Toggle password visibility functions khusus untuk modal profil
    function setupProfilePasswordToggle(passwordId, buttonId) {
        const passwordInput = document.getElementById(passwordId);
        const toggleButton = document.getElementById(buttonId);
        
        if (passwordInput && toggleButton) {
            toggleButton.addEventListener('click', function() {
                const icon = this.querySelector('i');
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        }
    }
    
    // Setup password toggles khusus untuk modal profil
    setupProfilePasswordToggle('currentPassword', 'toggleCurrentPassword');
    setupProfilePasswordToggle('newPassword', 'toggleNewPassword');
    setupProfilePasswordToggle('confirmNewPassword', 'toggleConfirmPassword');
    
    // Handle foto profil upload khusus untuk modal profil
    if (btnUploadProfileFoto) {
        btnUploadProfileFoto.addEventListener('click', function() {
            profileFotoInput.click();
        });
    }
    
    if (profileFotoInput) {
        profileFotoInput.addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                // Validasi ukuran file (maks 2MB)
                if (e.target.files[0].size > 2 * 1024 * 1024) {
                    Swal.fire({
                        icon: 'error',
                        title: 'File terlalu besar',
                        text: 'Ukuran file maksimal 2MB'
                    });
                    this.value = '';
                    return;
                }
                
                // Validasi tipe file
                const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
                if (!validTypes.includes(e.target.files[0].type)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Format tidak didukung',
                        text: 'Hanya format JPG, PNG, dan GIF yang diperbolehkan'
                    });
                    this.value = '';
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(event) {
                    profileFotoPreview.src = event.target.result;
                    btnRemoveProfileFoto.style.display = 'block';
                };
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    }
    
    // Handle remove foto khusus untuk modal profil
    if (btnRemoveProfileFoto) {
        btnRemoveProfileFoto.addEventListener('click', function() {
            profileFotoPreview.src = '{{ asset("assets/img/team-2.jpg") }}';
            profileFotoInput.value = '';
            this.style.display = 'none';
        });
    }
    
    // Open modal when clicking edit profile button
    if (btnEditProfile) {
        btnEditProfile.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Close user dropdown if open
            const userDropdownMenu = document.getElementById('userDropdownMenu');
            if (userDropdownMenu && userDropdownMenu.classList.contains('show')) {
                userDropdownMenu.classList.remove('show');
            }
            
            // Reset form
            formEditProfile.reset();
            
            // Set form action
            formEditProfile.action = '{{ route("backend.profile.update") }}';
            
            // Reset foto preview to current foto
            const currentFoto = '{{ auth()->user()->foto_profil_url ?? asset("assets/img/team-2.jpg") }}';
            profileFotoPreview.src = currentFoto;
            
            // Show/hide remove foto button
            if (currentFoto.includes('team-2.jpg')) {
                btnRemoveProfileFoto.style.display = 'none';
            } else {
                btnRemoveProfileFoto.style.display = 'block';
            }
            
            // Reset password fields
            document.getElementById('currentPassword').value = '';
            document.getElementById('newPassword').value = '';
            document.getElementById('confirmNewPassword').value = '';
            
            // Clear validation errors
            clearProfileValidationErrors();
            
            // Reset to first tab
            const firstTab = document.querySelector('#profileTab .nav-link');
            if (firstTab) {
                new bootstrap.Tab(firstTab).show();
            }
            
            // Show modal
            modalEditProfile.show();
        });
    }
    
    // Form submission untuk modal profil
    if (formEditProfile) {
        formEditProfile.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            // Show loading
            const btnSimpan = document.getElementById('btnSimpanProfile');
            const originalText = btnSimpan.innerHTML;
            btnSimpan.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...';
            btnSimpan.disabled = true;
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    modalEditProfile.hide();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    if (data.errors) {
                        Object.keys(data.errors).forEach(field => {
                            const input = document.querySelector(`#formEditProfile [name="${field}"]`);
                            const errorDiv = document.getElementById(`${field}_error`);
                            if (input) {
                                input.classList.add('is-invalid');
                            }
                            if (errorDiv) {
                                errorDiv.textContent = data.errors[field][0];
                            }
                        });
                        
                        // Scroll to first error
                        const firstError = document.querySelector('#formEditProfile .is-invalid');
                        if (firstError) {
                            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: data.message || 'Terjadi kesalahan saat menyimpan data.'
                        });
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat menyimpan data.'
                });
            })
            .finally(() => {
                btnSimpan.innerHTML = originalText;
                btnSimpan.disabled = false;
            });
        });
    }
    
    // Clear validation errors function khusus untuk modal profil
    function clearProfileValidationErrors() {
        if (formEditProfile) {
            formEditProfile.querySelectorAll('.is-invalid').forEach(field => {
                field.classList.remove('is-invalid');
            });
            formEditProfile.querySelectorAll('.invalid-feedback').forEach(errorDiv => {
                errorDiv.textContent = '';
            });
        }
    }
    
    // Remove invalid class on input khusus untuk modal profil
    const profileFormFields = document.querySelectorAll('#formEditProfile input, #formEditProfile select');
    profileFormFields.forEach(field => {
        field.addEventListener('input', function() {
            this.classList.remove('is-invalid');
            const errorDiv = document.getElementById(`${this.name}_error`);
            if (errorDiv) {
                errorDiv.textContent = '';
            }
        });
    });
    
    // Clear modal on hide khusus untuk modal profil
    document.getElementById('modalEditProfile')?.addEventListener('hidden.bs.modal', function() {
        clearProfileValidationErrors();
    });
});
</script>
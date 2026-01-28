@extends('layouts.backend')

@section('title', 'Kelola User - Dashboard Admin')

@section('content')
    <!-- Header Card -->
    <div class="card shadow mb-4 border-0">
        <div class="card-body py-4">
            <div class="d-flex justify-content-between align-items-center page-header">
                <div>
                    <h1 class="h3 text-gray-800 mb-1">
                        <i class="fas fa-users me-2"></i> Kelola User
                    </h1>
                    <p class="text-muted mb-0">Kelola pengguna dan hak akses sistem</p>
                </div>
                <div>
                    <button type="button" class="btn btn-primary" id="btnTambah">
                        <i class="fas fa-plus me-1"></i> Tambah User
                    </button>
                    <button type="button" class="btn btn-outline-info" onclick="showRoleGuide()">
                        <i class="fas fa-info-circle me-1"></i> Panduan Role
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card shadow mb-4 border-0">
        <div class="card-body">
            <form action="{{ route('backend.users.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Cari User</label>
                    <input type="text" class="form-control" name="search" 
                           placeholder="Nama, email, atau role..." 
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Role</label>
                    <select class="form-select" name="role">
                        <option value="">Semua Role</option>
                        @foreach($roleOptions as $value => $label)
                            <option value="{{ $value }}" {{ request('role') == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Status</label>
                    <select class="form-select" name="status">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex flex-column">
                    <label class="form-label invisible">Filter</label>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Info Role Guide -->
    <div class="card shadow mb-4 border-0" id="roleGuide" style="display: none;">
        <div class="card-body">
            <h5 class="card-title text-info mb-3">
                <i class="fas fa-graduation-cap me-2"></i> Panduan Hak Akses Role
            </h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="border rounded p-3">
                        <h6 class="fw-bold text-primary">
                            <span class="badge bg-primary me-2">Admin</span> Administrator
                        </h6>
                        <p class="mb-2 small">Akses administrasi sistem</p>
                        <ul class="small text-muted mb-0">
                            <li>Kelola data master</li>
                            <li>Kelola konten website</li>
                            <li>Input data siswa</li>
                            <li>Lihat laporan</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="border rounded p-3">
                        <h6 class="fw-bold text-danger">
                            <span class="badge bg-danger me-2">SuperAdmin</span> Super Administrator
                        </h6>
                        <p class="mb-2 small">Akses penuh ke semua fitur sistem</p>
                        <ul class="small text-muted mb-0">
                            <li>Kelola semua data</li>
                            <li>Kelola user & hak akses</li>
                            <li>Konfigurasi sistem</li>
                            <li>Backup dan restore data</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="card shadow-lg border-0 rounded-5 overflow-hidden">
        <div class="card-body p-0">
            @if($users->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada data user</h5>
                    <p class="text-muted">Mulai dengan menambahkan user baru</p>
                    <button type="button" class="btn btn-primary" id="btnTambahEmpty">
                        <i class="fas fa-plus me-1"></i> Tambah User Pertama
                    </button>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4" width="50">#</th>
                                <th class="ps-3" width="80">Avatar</th>
                                <th>User Detail</th>
                                <th width="120">Role</th>
                                <th width="120">Status</th>
                                <th width="150">Login Info</th>
                                <th width="150">Terakhir Login</th>
                                <th width="120" class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr data-id="{{ $user->id }}">
                                    <td class="ps-4">
                                        {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                                    </td>
                                    <td class="ps-3">
                                        <div class="avatar-wrapper">
                                            @if($user->foto_profil_url)
                                                <img src="{{ $user->foto_profil_url }}" 
                                                     class="avatar-circle"
                                                     alt="{{ $user->name }}"
                                                     style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <div class="avatar-circle bg-{{ $user->role_color }}">
                                                    {{ $user->initials }}
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <strong class="text-dark">{{ $user->name }}</strong>
                                            <small class="text-muted">{{ $user->email }}</small>
                                            <small class="text-info">
                                                <i class="fas fa-id-card me-1"></i>
                                                ID: {{ $user->id }}
                                            </small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $user->role_color }}">
                                            {{ $roleOptions[$user->role] ?? ucfirst($user->role) }}
                                        </span>
                                        @if($user->id === auth()->id())
                                            <small class="d-block text-muted mt-1">
                                                <i class="fas fa-user me-1"></i> Anda
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="form-check form-switch me-2">
                                                <input class="form-check-input toggle-status" 
                                                       type="checkbox" 
                                                       data-id="{{ $user->id }}"
                                                       data-name="{{ $user->name }}"
                                                       {{ $user->is_active ? 'checked' : '' }}
                                                       {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                            </div>
                                            <span class="badge bg-{{ $user->is_active ? 'success' : 'secondary' }}">
                                                {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="small">
                                            <div class="mb-1">
                                                <i class="fas fa-calendar-plus me-1"></i>
                                                Dibuat: {{ $user->created_at->format('d/m/Y') }}
                                            </div>
                                            <div>
                                                <i class="fas fa-clock me-1"></i>
                                                Update: {{ $user->updated_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($user->email_verified_at)
                                            <div class="small">
                                                <div class="mb-1">
                                                    <i class="fas fa-check-circle text-success me-1"></i>
                                                    Verified: {{ $user->email_verified_at->format('d/m/Y') }}
                                                </div>
                                                <div>
                                                    <i class="fas fa-sign-in-alt me-1"></i>
                                                    {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Belum login' }}
                                                </div>
                                            </div>
                                        @else
                                            <span class="badge bg-warning">
                                                <i class="fas fa-exclamation-triangle me-1"></i> Belum verifikasi
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group" role="group">
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-primary btn-edit"
                                                    data-id="{{ $user->id }}"
                                                    title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-danger btn-hapus"
                                                    data-id="{{ $user->id }}"
                                                    data-name="{{ $user->name }}"
                                                    data-role="{{ $user->role }}"
                                                    title="Hapus"
                                                    {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($users->hasPages())
                    <div class="card-footer border-0 bg-white py-3 px-4">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <!-- Informasi hasil -->
                            <div class="text-muted small mb-2 mb-md-0">
                                Menampilkan <strong>{{ $users->firstItem() }}</strong> - <strong>{{ $users->lastItem() }}</strong> dari <strong>{{ $users->total() }}</strong> user
                            </div>
                            
                            <!-- Navigation pagination -->
                            <div class="d-flex align-items-center">
                                <!-- Previous Page Link -->
                                @if($users->onFirstPage())
                                    <span class="btn btn-outline-secondary btn-sm disabled me-2 px-3">
                                        <i class="fas fa-chevron-left"></i>
                                    </span>
                                @else
                                    <a href="{{ $users->previousPageUrl() }}" class="btn btn-outline-primary btn-sm me-2 px-3">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                @endif
                                
                                <!-- Page Numbers -->
                                <div class="d-none d-md-flex">
                                    @php
                                        $current = $users->currentPage();
                                        $last = $users->lastPage();
                                        $start = max($current - 2, 1);
                                        $end = min($current + 2, $last);
                                    @endphp
                                    
                                    @if($start > 1)
                                        <a href="{{ $users->url(1) }}" class="btn btn-outline-secondary btn-sm mx-1">1</a>
                                        @if($start > 2)
                                            <span class="btn btn-outline-secondary btn-sm mx-1 disabled">...</span>
                                        @endif
                                    @endif
                                    
                                    @for($i = $start; $i <= $end; $i++)
                                        @if($i == $current)
                                            <span class="btn btn-primary btn-sm mx-1 px-3">{{ $i }}</span>
                                        @else
                                            <a href="{{ $users->url($i) }}" class="btn btn-outline-secondary btn-sm mx-1 px-3">{{ $i }}</a>
                                        @endif
                                    @endfor
                                    
                                    @if($end < $last)
                                        @if($end < $last - 1)
                                            <span class="btn btn-outline-secondary btn-sm mx-1 disabled">...</span>
                                        @endif
                                        <a href="{{ $users->url($last) }}" class="btn btn-outline-secondary btn-sm mx-1">{{ $last }}</a>
                                    @endif
                                </div>
                                
                                <!-- Mobile page info -->
                                <div class="d-md-none text-center mx-2">
                                    <span class="badge bg-primary">{{ $current }}/{{ $last }}</span>
                                </div>
                                
                                <!-- Next Page Link -->
                                @if($users->hasMorePages())
                                    <a href="{{ $users->nextPageUrl() }}" class="btn btn-outline-primary btn-sm ms-2 px-3">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                @else
                                    <span class="btn btn-outline-secondary btn-sm disabled ms-2 px-3">
                                        <i class="fas fa-chevron-right"></i>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>

    <!-- Modal Form Data -->
    <div class="modal fade" id="modalForm" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="formUser" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="form_id" name="id">
                    <!-- PERBAIKAN: Gunakan method spoofing -->
                    @method('POST')
                    
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-user-edit me-2"></i>
                            <span id="modalTitle">Tambah User Baru</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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
                                                <img src="{{ asset('assets/img/ivancik.jpg') }}" 
                                                     class="img-fluid rounded-circle border"
                                                     style="width: 150px; height: 150px; object-fit: cover;"
                                                     id="userFotoProfilPreview"
                                                     alt="Avatar Preview">
                                            </div>
                                            <div class="d-grid gap-2">
                                                <input type="file" 
                                                       class="form-control d-none" 
                                                       name="foto_profil" 
                                                       id="userFotoProfilInput"
                                                       accept="image/*">
                                                <button type="button" 
                                                        class="btn btn-outline-primary btn-sm" 
                                                        id="btnUploadUserFoto">
                                                    <i class="fas fa-camera me-1"></i> Upload Foto
                                                </button>
                                                <button type="button" 
                                                        class="btn btn-outline-secondary btn-sm" 
                                                        id="btnRemoveUserFoto"
                                                        style="display: none;">
                                                    <i class="fas fa-trash me-1"></i> Hapus Foto
                                                </button>
                                            </div>
                                            <div class="form-text mt-2">
                                                Format: JPG, PNG, GIF. Maks: 2MB
                                            </div>
                                            <div class="invalid-feedback" id="user_foto_profil_error"></div>
                                        </div>
                                        
                                        <!-- Status -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">
                                                Status Akun
                                            </label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       name="is_active" 
                                                       id="is_active" 
                                                       value="1" 
                                                       checked>
                                                <label class="form-check-label" for="is_active">
                                                    Akun Aktif
                                                </label>
                                            </div>
                                            <div class="form-text">
                                                User aktif dapat login ke sistem
                                            </div>
                                        </div>
                                        
                                        <!-- Force Password Change -->
                                        <div class="mb-0">
                                            <label class="form-label fw-bold">
                                                Keamanan
                                            </label>
                                            <div class="form-check">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       name="force_password_change" 
                                                       id="force_password_change" 
                                                       value="1">
                                                <label class="form-check-label" for="force_password_change">
                                                    Ubah password saat login pertama
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Right Column - Form Fields -->
                            <div class="col-md-8">
                                <!-- Tabs -->
                                <ul class="nav nav-tabs mb-3" id="userTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="user-basic-tab" data-bs-toggle="tab" 
                                                data-bs-target="#user-basic" type="button" role="tab">
                                            <i class="fas fa-user me-1"></i> Data Dasar
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="user-security-tab" data-bs-toggle="tab" 
                                                data-bs-target="#user-security" type="button" role="tab">
                                            <i class="fas fa-shield-alt me-1"></i> Keamanan
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="user-permissions-tab" data-bs-toggle="tab" 
                                                data-bs-target="#user-permissions" type="button" role="tab">
                                            <i class="fas fa-key me-1"></i> Hak Akses
                                        </button>
                                    </li>
                                </ul>
                                
                                <div class="tab-content" id="userTabContent">
                                    <!-- Tab 1: Basic Data -->
                                    <div class="tab-pane fade show active" id="user-basic" role="tabpanel">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">
                                                Nama Lengkap <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="name" 
                                                   id="userName"
                                                   placeholder="Contoh: Admin Utama"
                                                   required>
                                            <div class="invalid-feedback" id="user_name_error"></div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">
                                                Email <span class="text-danger">*</span>
                                            </label>
                                            <input type="email" 
                                                   class="form-control" 
                                                   name="email" 
                                                   id="userEmail"
                                                   placeholder="contoh@sekolah.sch.id"
                                                   required>
                                            <div class="invalid-feedback" id="user_email_error"></div>
                                        </div>
                                    </div>
                                    
                                    <!-- Tab 2: Security -->
                                    <div class="tab-pane fade" id="user-security" role="tabpanel">
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle me-2"></i>
                                            Kosongkan password jika tidak ingin mengubahnya
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">
                                                Password <span class="text-danger" id="userPasswordRequired">*</span>
                                            </label>
                                            <div class="input-group">
                                                <input type="password" 
                                                       class="form-control"
                                                       name="password" 
                                                       id="userPassword"
                                                       placeholder="Minimal 8 karakter">
                                                <button class="btn btn-outline-secondary" type="button" id="toggleUserPassword">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                            <div class="invalid-feedback" id="user_password_error"></div>
                                            <div class="form-text">
                                                Gunakan kombinasi huruf, angka, dan simbol untuk keamanan maksimal
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">
                                                Konfirmasi Password <span class="text-danger" id="userPasswordConfirmationRequired">*</span>
                                            </label>
                                            <div class="input-group">
                                                <input type="password" 
                                                       class="form-control"
                                                       name="password_confirmation" 
                                                       id="userPasswordConfirmation"
                                                       placeholder="Ulangi password">
                                                <button class="btn btn-outline-secondary" type="button" id="toggleUserPasswordConfirmation">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                            <div class="invalid-feedback" id="user_password_confirmation_error"></div>
                                        </div>
                                    </div>
                                    
                                    <!-- Tab 3: Permissions -->
                                    <div class="tab-pane fade" id="user-permissions" role="tabpanel">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">
                                                Role <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select" name="role" id="userRole" required>
                                                <option value="">Pilih Role</option>
                                                @foreach($roleOptions as $value => $label)
                                                    <option value="{{ $value }}" data-color="{{ 
                                                        $value == 'superadmin' ? 'danger' : 'primary'
                                                    }}">
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback" id="user_role_error"></div>
                                        </div>
                                        
                                        <div class="card border-0 bg-light">
                                            <div class="card-body">
                                                <h6 class="fw-bold mb-3">Deskripsi Role:</h6>
                                                <div id="userRoleDescription">
                                                    <p class="text-muted mb-0">Pilih role untuk melihat deskripsi</p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-3">
                                            <h6 class="fw-bold mb-2">Permissions Preview:</h6>
                                            <div id="userPermissionsPreview" class="row g-2">
                                                <!-- Permissions will be dynamically populated -->
                                            </div>
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
                        <button type="submit" class="btn btn-primary" id="btnSimpanUser">
                            <i class="fas fa-save me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
.avatar-wrapper {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.avatar-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    color: white;
    font-size: 16px;
    text-transform: uppercase;
}

/* Role Guide */
#roleGuide .card {
    border-left: 4px solid #6b02b1;
}

/* Badge colors */
.badge.bg-danger { background-color: #dc3545 !important; }
.badge.bg-primary { background-color: #6b02b1 !important; }
.badge.bg-success { background-color: #198754 !important; }
.badge.bg-secondary { background-color: #6c757d !important; }
.badge.bg-warning { background-color: #ffc107 !important; color: #000 !important; }

#modalForm .input-group {
    align-items: stretch;
}

#modalForm .input-group > .form-control,
#modalForm .input-group > .btn {
    height: 42px;
}

/* PERBAIKAN: Input group yang sejajar */
.input-group.align-items-center {
    align-items: center;
}

.input-group .form-control.py-2 {
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
}

.input-group .btn-outline-secondary.py-2 {
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
    /* height: auto; */
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Toggle switch */
.form-check-input:checked {
    background-color: #6b02b1;
    border-color: #6b02b1;
}

.form-check-input:focus {
    border-color: #6b02b1;
    box-shadow: 0 0 0 0.2rem rgba(107, 2, 177, 0.25);
}

/* Tabs styling */
.nav-tabs .nav-link {
    color: #6b757d;
    border: none;
    padding: 10px 15px;
    transition: all 0.3s;
}

.nav-tabs .nav-link:hover {
    color: #6b02b1;
    border: none;
}

.nav-tabs .nav-link.active {
    color: #6b02b1;
    background-color: rgba(107, 2, 177, 0.05);
    border-bottom: 2px solid #6b02b1;
    font-weight: 600;
}

/* Permissions preview */
.permission-item {
    padding: 8px 12px;
    background: white;
    border-radius: 6px;
    font-size: 12px;
    border: 1px solid #dee2e6;
    transition: all 0.2s;
}

.permission-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.permission-item.allowed {
    background-color: rgba(25, 135, 84, 0.1);
    border-color: #198754;
    color: #198754;
}

.permission-item.denied {
    background-color: rgba(220, 53, 69, 0.1);
    border-color: #dc3545;
    color: #dc3545;
}

.permission-item.limited {
    background-color: rgba(255, 193, 7, 0.1);
    border-color: #ffc107;
    color: #856404;
}

/* Disabled buttons */
.btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .table td, .table th {
        padding: 8px;
    }
    
    .avatar-circle {
        width: 35px;
        height: 35px;
        font-size: 14px;
    }
    
    .btn-group .btn-sm {
        padding: 2px 8px;
    }
}
</style>
@endpush

@push('scripts')
<script>
// USER MANAGEMENT MODAL FUNCTIONALITY
document.addEventListener('DOMContentLoaded', function() {
    const modal = new bootstrap.Modal('#modalForm');
    const form = document.getElementById('formUser');
    
    // Role descriptions
    const roleDescriptions = {
        'admin': {
            description: 'Akses administrasi sistem. Dapat mengelola data master, konten website, dan melihat laporan.',
            permissions: [
                { text: 'Kelola data master', type: 'allowed' },
                { text: 'Kelola konten website', type: 'allowed' },
                { text: 'Input data siswa', type: 'allowed' },
                { text: 'Lihat laporan', type: 'allowed' },
                { text: 'Kelola user lain', type: 'denied' },
                { text: 'Konfigurasi sistem', type: 'denied' }
            ]
        },
        'superadmin': {
            description: 'Akses penuh ke semua fitur sistem. Dapat mengelola semua data, konfigurasi sistem, dan pengguna lain.',
            permissions: [
                { text: 'Kelola semua data', type: 'allowed' },
                { text: 'Kelola user & roles', type: 'allowed' },
                { text: 'Konfigurasi sistem', type: 'allowed' },
                { text: 'Backup & restore', type: 'allowed' },
                { text: 'Lihat semua laporan', type: 'allowed' }
            ]
        }
    };
    
    // Elements untuk foto profil user management
    const userFotoInput = document.getElementById('userFotoProfilInput');
    const userFotoPreview = document.getElementById('userFotoProfilPreview');
    const btnUploadUserFoto = document.getElementById('btnUploadUserFoto');
    const btnRemoveUserFoto = document.getElementById('btnRemoveUserFoto');
    
    // Show/hide role guide
    window.showRoleGuide = function() {
        const guide = document.getElementById('roleGuide');
        if (guide.style.display === 'none' || guide.style.display === '') {
            guide.style.display = 'block';
        } else {
            guide.style.display = 'none';
        }
    };
    
    // Handle foto profil upload untuk user management
    if (btnUploadUserFoto) {
        btnUploadUserFoto.addEventListener('click', function() {
            userFotoInput.click();
        });
    }
    
    if (userFotoInput) {
        userFotoInput.addEventListener('change', function(e) {
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
                    userFotoPreview.src = event.target.result;
                    btnRemoveUserFoto.style.display = 'block';
                };
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    }
    
    // Handle remove foto untuk user management
    if (btnRemoveUserFoto) {
        btnRemoveUserFoto.addEventListener('click', function() {
            userFotoPreview.src = '{{ asset("assets/img/ivancik.jpg") }}';
            userFotoInput.value = '';
            this.style.display = 'none';
        });
    }
    
    // Role change handler untuk user management
    document.getElementById('userRole')?.addEventListener('change', function() {
        updateUserRoleDescription(this.value);
    });
    
    function updateUserRoleDescription(role) {
        const descriptionDiv = document.getElementById('userRoleDescription');
        const previewDiv = document.getElementById('userPermissionsPreview');
        
        if (role && roleDescriptions[role]) {
            const roleInfo = roleDescriptions[role];
            
            // Update description
            descriptionDiv.innerHTML = `
                <div class="alert alert-${role == 'superadmin' ? 'danger' : 'primary'} mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    ${roleInfo.description}
                </div>
            `;
            
            // Update permissions preview
            previewDiv.innerHTML = roleInfo.permissions.map(permission => `
                <div class="col-6 col-md-4">
                    <div class="permission-item ${permission.type}">
                        <i class="fas fa-${permission.type === 'allowed' ? 'check-circle' : 
                        (permission.type === 'denied' ? 'times-circle' : 'exclamation-circle')} me-1"></i>
                        ${permission.text}
                    </div>
                </div>
            `).join('');
        } else {
            descriptionDiv.innerHTML = '<p class="text-muted mb-0">Pilih role untuk melihat deskripsi</p>';
            previewDiv.innerHTML = '';
        }
    }
    
    // Toggle password visibility untuk user management
    document.getElementById('toggleUserPassword')?.addEventListener('click', function() {
        const passwordInput = document.getElementById('userPassword');
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
    
    // Toggle password confirmation visibility untuk user management
    document.getElementById('toggleUserPasswordConfirmation')?.addEventListener('click', function() {
        const passwordInput = document.getElementById('userPasswordConfirmation');
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
    
    // Tambah button
    document.getElementById('btnTambah')?.addEventListener('click', openForm);
    document.getElementById('btnTambahEmpty')?.addEventListener('click', openForm);
    
    // Edit button
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-edit') || e.target.closest('.btn-edit')) {
            e.preventDefault();
            const button = e.target.classList.contains('btn-edit') ? e.target : e.target.closest('.btn-edit');
            if (button) {
                const id = button.dataset.id;
                editData(id);
            }
        }
        
        // Hapus button
        if (e.target.classList.contains('btn-hapus') || e.target.closest('.btn-hapus')) {
            e.preventDefault();
            const button = e.target.classList.contains('btn-hapus') ? e.target : e.target.closest('.btn-hapus');
            if (button && !button.disabled) {
                const id = button.dataset.id;
                const name = button.dataset.name;
                const role = button.dataset.role;
                hapusData(id, name, role);
            }
        }
        
        // Toggle status
        if (e.target.classList.contains('toggle-status') || e.target.closest('.toggle-status')) {
            e.preventDefault();
            const checkbox = e.target.classList.contains('toggle-status') ? e.target : e.target.closest('.toggle-status');
            if (checkbox && !checkbox.disabled) {
                const id = checkbox.dataset.id;
                const name = checkbox.dataset.name;
                toggleStatus(id, name, checkbox.checked);
            }
        }
    });
    
    // Open form for create
    function openForm() {
        form.reset();
        form.action = '{{ route("backend.users.store") }}';
        
        // Set method POST untuk tambah data
        const methodInput = document.querySelector('input[name="_method"]');
        if (methodInput) {
            methodInput.value = 'POST';
        }
        
        document.getElementById('modalTitle').textContent = 'Tambah User Baru';
        document.getElementById('form_id').value = '';
        document.getElementById('is_active').checked = true;
        
        // Tampilkan password required untuk tambah user
        const passwordRequired = document.getElementById('userPasswordRequired');
        const passwordConfirmationRequired = document.getElementById('userPasswordConfirmationRequired');
        if (passwordRequired) passwordRequired.style.display = 'inline';
        if (passwordConfirmationRequired) passwordConfirmationRequired.style.display = 'inline';
        
        // Reset foto preview
        userFotoPreview.src = '{{ asset("assets/img/ivancik.jpg") }}';
        if (btnRemoveUserFoto) btnRemoveUserFoto.style.display = 'none';
        
        // Reset role description
        updateUserRoleDescription('');
        
        // Reset tabs to first tab
        const firstTab = document.querySelector('#userTab .nav-link');
        if (firstTab) {
            new bootstrap.Tab(firstTab).show();
        }
        
        clearUserValidationErrors();
        modal.show();
    }
    
    // Open form for edit
    function editData(id) {
        console.log('Editing user ID:', id);
        
        fetch('{{ route("backend.users.edit", ":id") }}'.replace(':id', id))
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Edit response data:', data);
                if (data.success) {
                    const user = data.data;
                    
                    // Clear previous validation errors
                    clearUserValidationErrors();
                    
                    // Set form values
                    document.getElementById('form_id').value = user.id;
                    document.getElementById('userName').value = user.name;
                    document.getElementById('userEmail').value = user.email;
                    document.getElementById('userRole').value = user.role;
                    document.getElementById('is_active').checked = user.is_active == 1;
                    
                    // PERBAIKAN: Handle force_password_change
                    const forcePasswordChange = document.getElementById('force_password_change');
                    if (forcePasswordChange) {
                        forcePasswordChange.checked = user.force_password_change == 1;
                    }
                    
                    // Set foto preview dari user data
                    if (user.foto_profil) {
                        if (user.foto_profil.startsWith('http')) {
                            userFotoPreview.src = user.foto_profil;
                        } else {
                            userFotoPreview.src = '/storage/' + user.foto_profil;
                        }
                        if (btnRemoveUserFoto) btnRemoveUserFoto.style.display = 'block';
                    } else {
                        userFotoPreview.src = '{{ asset("assets/img/ivancik.jpg") }}';
                        if (btnRemoveUserFoto) btnRemoveUserFoto.style.display = 'none';
                    }
                    
                    // Sembunyikan password required untuk edit
                    const passwordRequired = document.getElementById('userPasswordRequired');
                    const passwordConfirmationRequired = document.getElementById('userPasswordConfirmationRequired');
                    if (passwordRequired) passwordRequired.style.display = 'none';
                    if (passwordConfirmationRequired) passwordConfirmationRequired.style.display = 'none';
                    
                    // Kosongkan password fields untuk edit
                    document.getElementById('userPassword').value = '';
                    document.getElementById('userPasswordConfirmation').value = '';
                    
                    // PERBAIKAN PENTING: Set form action ke route UPDATE
                    form.action = '{{ route("backend.users.update", ":id") }}'.replace(':id', user.id);
                    
                    // PERBAIKAN: Set method menjadi PUT
                    const methodInput = document.querySelector('input[name="_method"]');
                    if (methodInput) {
                        methodInput.value = 'PUT';
                    }
                    
                    document.getElementById('modalTitle').textContent = 'Edit User: ' + user.name;
                    
                    // Update role description
                    updateUserRoleDescription(user.role);
                    
                    // Show first tab
                    const firstTab = document.querySelector('#userTab .nav-link');
                    if (firstTab) {
                        new bootstrap.Tab(firstTab).show();
                    }
                    
                    modal.show();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message || 'Gagal mengambil data user.'
                    });
                }
            })
            .catch(error => {
                console.error('Edit Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat mengambil data. Periksa console untuk detail.'
                });
            });
    }
    
    // PERBAIKAN: Form submission untuk user management
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const formData = new FormData(this);
        const userId = document.getElementById('form_id').value;
        if (userId) {
            formData.append('_method', 'PUT');
        }
        
        console.log('Form submission:', {
            userId: userId,
            formAction: form.action,
            formData: Object.fromEntries(formData)
        });
        
        // Show loading
        const btnSimpan = document.getElementById('btnSimpanUser');
        const originalText = btnSimpan.innerHTML;
        btnSimpan.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...';
        btnSimpan.disabled = true;
        
        // Kirim request dengan FormData
        fetch(form.action, {
            method: 'POST', // Selalu POST untuk form dengan file upload
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            
            if (data.success) {
                modal.hide();
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
                // Handle validation errors
                if (data.errors) {
                    clearUserValidationErrors();
                    Object.keys(data.errors).forEach(field => {
                        const input = document.querySelector(`[name="${field}"]`);
                        const errorDiv = document.getElementById(`${field}_error`);
                        if (input) {
                            input.classList.add('is-invalid');
                        }
                        if (errorDiv) {
                            errorDiv.textContent = data.errors[field][0];
                        }
                    });
                    
                    // Scroll to first error
                    const firstError = document.querySelector('.is-invalid');
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
            console.error('Fetch Error Details:', error);
            console.log('URL attempted:', form.action);
            console.log('User ID:', userId);
            
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                html: `Terjadi kesalahan saat menyimpan data.<br><br>
                      <strong>Detail:</strong><br>
                      <small>${error.message}</small><br><br>
                      <strong>Debug Info:</strong><br>
                      <small>URL: ${form.action}<br>
                      User ID: ${userId}</small>`
            });
        })
        .finally(() => {
            btnSimpan.innerHTML = originalText;
            btnSimpan.disabled = false;
        });
    });
    
    // Toggle status
    function toggleStatus(id, name, newStatus) {
        const action = newStatus ? 'mengaktifkan' : 'menonaktifkan';
        
        Swal.fire({
            title: 'Konfirmasi',
            html: `Apakah Anda yakin ingin ${action} user <strong>${name}</strong>?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#6b02b1',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('{{ route("backend.users.toggle-status", ":id") }}'.replace(':id', id), {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
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
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: data.message
                        }).then(() => {
                            window.location.reload();
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat mengubah status.'
                    });
                });
            } else {
                // Revert checkbox
                const checkbox = document.querySelector(`.toggle-status[data-id="${id}"]`);
                if (checkbox) {
                    checkbox.checked = !newStatus;
                }
            }
        });
    }
    
    // Hapus data
    function hapusData(id, name, role) {
        let warningText = '';
        if (role === 'superadmin') {
            warningText = '<br><small class="text-danger">User ini memiliki role Super Administrator!</small>';
        }
        
        Swal.fire({
            title: 'Hapus User?',
            html: `Apakah Anda yakin ingin menghapus <strong>${name}</strong>?${warningText}`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('{{ route("backend.users.destroy", ":id") }}'.replace(':id', id), {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Terhapus!',
                            text: data.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: data.message
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat menghapus data.'
                    });
                });
            }
        });
    }
    
    // Clear validation errors untuk user management
    function clearUserValidationErrors() {
        form.querySelectorAll('.is-invalid').forEach(field => {
            field.classList.remove('is-invalid');
        });
        form.querySelectorAll('.invalid-feedback').forEach(errorDiv => {
            errorDiv.textContent = '';
        });
    }
    
    // Remove invalid class on input untuk user management
    form.querySelectorAll('input, select').forEach(field => {
        field.addEventListener('input', function() {
            this.classList.remove('is-invalid');
            const errorDiv = document.getElementById(`${this.name}_error`);
            if (errorDiv) {
                errorDiv.textContent = '';
            }
        });
    });
    
    // Clear modal on hide untuk user management
    document.getElementById('modalForm')?.addEventListener('hidden.bs.modal', function() {
        form.reset();
        clearUserValidationErrors();
    });
});
</script>
@endpush
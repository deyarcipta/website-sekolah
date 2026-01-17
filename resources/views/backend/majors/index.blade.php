@extends('layouts.backend')

@section('title', 'Kelola Jurusan - Dashboard Admin')

@section('content')
    <!-- Header Card -->
    <div class="card shadow mb-4 border-0">
        <div class="card-body py-4">
            <div class="d-flex justify-content-between align-items-center page-header">
                <div>
                    <h1 class="h3 text-gray-800 mb-1">
                        <i class="fas fa-graduation-cap me-2"></i> Kelola Jurusan
                    </h1>
                    <p class="text-muted mb-0">Kelola semua kompetensi keahlian SMK Wisata Indonesia Jakarta</p>
                </div>
                <div>
                    <a href="{{ route('backend.majors.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Tambah Jurusan Baru
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="card shadow border-0">
        <div class="card-body p-0">
            <!-- Stats -->
            <div class="row mb-4 p-4 border-bottom">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-graduation-cap fa-2x"></i>
                                </div>
                                <div>
                                    <h3 class="mb-0">{{ $majors->count() }}</h3>
                                    <p class="mb-0">Total Jurusan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-check-circle fa-2x"></i>
                                </div>
                                <div>
                                    <h3 class="mb-0">{{ $majors->where('is_active', true)->count() }}</h3>
                                    <p class="mb-0">Jurusan Aktif</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-eye fa-2x"></i>
                                </div>
                                <div>
                                    <h3 class="mb-0">{{ $majors->where('is_active', false)->count() }}</h3>
                                    <p class="mb-0">Tidak Aktif</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-sort-amount-down fa-2x"></i>
                                </div>
                                <div>
                                    <h3 class="mb-0">{{ $majors->max('order') ?? 0 }}</h3>
                                    <p class="mb-0">Urutan Tertinggi</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="60">#</th>
                            <th>Logo</th>
                            <th>Nama Jurusan</th>
                            <th>Singkatan</th>
                            <th>Status</th>
                            <th>Urutan</th>
                            <th width="200">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($majors as $major)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if($major->logo)
                                    <img src="{{ asset('storage/' . $major->logo) }}" alt="{{ $major->name }}" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="fas fa-graduation-cap text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $major->name }}</strong>
                                <br>
                                <small class="text-muted">{{ Str::limit($major->description, 50) }}</small>
                            </td>
                            <td>{{ $major->short_name ?? '-' }}</td>
                            <td>
                                @if($major->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $major->order }}</span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="#" target="_blank" class="btn btn-sm btn-outline-info" title="Lihat di Frontend">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('backend.majors.edit', $major->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('backend.majors.teachers', $major->id) }}" class="btn btn-sm btn-success" title="Kelola Pengajar">
                                        <i class="fas fa-users"></i>
                                    </a>
                                    <a href="{{ route('backend.majors.achievements', $major->id) }}" class="btn btn-sm btn-warning" title="Kelola Prestasi">
                                        <i class="fas fa-trophy"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger delete-major" data-id="{{ $major->id }}" data-name="{{ $major->name }}" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-graduation-cap fa-3x mb-3"></i>
                                    <p class="mb-0">Belum ada jurusan yang ditambahkan</p>
                                    <a href="{{ route('backend.majors.create') }}" class="btn btn-primary mt-3">
                                        <i class="fas fa-plus me-1"></i> Tambah Jurusan Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .btn-group .btn {
        padding: 0.25rem 0.5rem;
    }
    
    .card .card-body {
        padding: 1rem;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Delete confirmation
    document.querySelectorAll('.delete-major').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.name;
            
            Swal.fire({
                title: 'Hapus Jurusan?',
                html: `<p>Apakah Anda yakin ingin menghapus <strong>${name}</strong>?</p>
                      <p class="text-danger"><small>Semua data terkait (pengajar, prestasi) juga akan dihapus permanen!</small></p>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/w1s4t4/majors/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: data.message,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                location.reload();
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
                            text: 'Terjadi kesalahan saat menghapus'
                        });
                    });
                }
            });
        });
    });
    
    // Reorder functionality (optional)
    const table = document.querySelector('table');
    if (table) {
        new Sortable(table.querySelector('tbody'), {
            animation: 150,
            handle: '.handle',
            onEnd: function(evt) {
                // Update order via AJAX
                const items = Array.from(evt.from.children);
                const orderData = items.map((row, index) => ({
                    id: row.dataset.id,
                    order: index + 1
                }));
                
                fetch('/backend/majors/reorder', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ orders: orderData })
                });
            }
        });
    }
});
</script>
@endpush
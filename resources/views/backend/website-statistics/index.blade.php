{{-- resources/views/backend/website-statistics/index.blade.php --}}

@extends('layouts.backend')

@section('title', 'Statistik Website - Dashboard Admin')

@section('content')
    <!-- Header Card -->
    <div class="card shadow mb-4 border-0">
        <div class="card-body py-4">
            <div class="d-flex justify-content-between align-items-center page-header">
                <div>
                    <h1 class="h3 text-gray-800 mb-1">
                        <i class="fas fa-chart-bar me-2"></i> Kelola Statistik Website
                    </h1>
                    <p class="text-muted mb-0">Kelola data statistik dan pengunjung website Wistin</p>
                </div>
                <div>
                    <button type="button" class="btn btn-primary" id="btnTambahStatistik">
                        <i class="fas fa-plus me-1"></i> Tambah Statistik
                    </button>
                    <a href="{{ url('/') }}" target="_blank" class="btn btn-outline-info">
                        <i class="fas fa-external-link-alt me-1"></i> Lihat di Frontend
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Pageview Hari Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\WebsiteStatistic::where('name', 'pageview_hari_ini')->first()->value ?? 0 }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-eye fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Visitor Hari Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\WebsiteStatistic::where('name', 'visitor_hari_ini')->first()->value ?? 0 }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Visitor Bulan Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\WebsiteStatistic::where('name', 'visitor_bulan_ini')->first()->value ?? 0 }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Visitor
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\WebsiteStatistic::where('name', 'total_visitor')->first()->formatted_value ?? 0 }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <!-- Statistics Management -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-list me-1"></i> Daftar Statistik
                    </h6>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" 
                                data-bs-toggle="dropdown" aria-expanded="false">
                            Filter Kategori
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item filter-category" href="#" data-category="">Semua</a></li>
                            @foreach($categories as $category)
                                <li><a class="dropdown-item filter-category" href="#" data-category="{{ $category }}">
                                    {{ ucfirst($category) }}
                                </a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    @if($statistics->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum ada statistik</h5>
                            <p class="text-muted">Mulai dengan menambahkan statistik baru</p>
                            <button type="button" class="btn btn-primary" id="btnTambahEmpty">
                                <i class="fas fa-plus me-1"></i> Tambah Statistik Pertama
                            </button>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="statisticsTable">
                                <thead class="bg-light">
                                    <tr>
                                        <th width="50">#</th>
                                        <th>Nama Statistik</th>
                                        <th width="120">Kategori</th>
                                        <th width="120">Nilai</th>
                                        <th width="80">Satuan</th>
                                        <th width="100">Status</th>
                                        <th width="100" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="sortable-table" id="sortableTable">
                                    @foreach($statistics as $statistic)
                                        <tr data-id="{{ $statistic->id }}" data-category="{{ $statistic->category }}">
                                            <td class="sortable-handle" style="cursor: move;">
                                                <i class="fas fa-arrows-alt-v text-muted"></i>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($statistic->icon)
                                                        <i class="{{ $statistic->icon }} me-2 text-{{ $statistic->color ?? 'primary' }}"></i>
                                                    @endif
                                                    <div>
                                                        <strong class="text-dark">{{ $statistic->display_name }}</strong>
                                                        <br>
                                                        <small class="text-muted">{{ $statistic->description }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">
                                                    {{ ucfirst($statistic->category) }}
                                                </span>
                                            </td>
                                            <td>
                                                <strong class="text-primary">{{ $statistic->formatted_value }}</strong>
                                            </td>
                                            <td>{{ $statistic->unit ?? '-' }}</td>
                                            <td>
                                                <div class="d-flex flex-column gap-1">
                                                    <span class="badge bg-{{ $statistic->is_visible ? 'success' : 'secondary' }}">
                                                        {{ $statistic->is_visible ? 'Tampil' : 'Sembunyi' }}
                                                    </span>
                                                    <span class="badge bg-{{ $statistic->is_editable ? 'info' : 'warning' }}">
                                                        {{ $statistic->is_editable ? 'Bisa Edit' : 'Read Only' }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <button type="button" 
                                                            class="btn btn-sm btn-outline-primary btn-edit-statistic"
                                                            data-id="{{ $statistic->id }}"
                                                            title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" 
                                                            class="btn btn-sm btn-outline-info btn-update-value"
                                                            data-id="{{ $statistic->id }}"
                                                            data-name="{{ $statistic->display_name }}"
                                                            title="Update Nilai">
                                                        <i class="fas fa-sync-alt"></i>
                                                    </button>
                                                    @if($statistic->is_editable)
                                                        <button type="button" 
                                                                class="btn btn-sm btn-outline-danger btn-hapus-statistic"
                                                                data-id="{{ $statistic->id }}"
                                                                data-name="{{ $statistic->display_name }}"
                                                                title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Visitor Logs and Actions -->
        <div class="col-lg-4">
            <!-- Recent Changes -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-history me-1"></i> Perubahan Terbaru
                    </h6>
                </div>
                <div class="card-body">
                    @if($recentLogs->isEmpty())
                        <p class="text-muted text-center mb-0">Belum ada perubahan</p>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($recentLogs as $log)
                                <div class="list-group-item px-0 py-2">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <strong>{{ $log->statistic->display_name }}</strong>
                                            <br>
                                            <small class="text-muted">
                                                {{ $log->old_value ?? 0 }} → {{ $log->new_value }}
                                                <span class="badge bg-{{ $log->change >= 0 ? 'success' : 'danger' }} ms-1">
                                                    {{ $log->formatted_change }}
                                                </span>
                                            </small>
                                        </div>
                                        <div class="text-end">
                                            <small class="text-muted d-block">{{ $log->created_at->diffForHumans() }}</small>
                                            <small class="text-muted">{{ $log->user->name ?? 'System' }}</small>
                                        </div>
                                    </div>
                                    @if($log->notes)
                                        <small class="text-muted mt-1 d-block">
                                            <i class="fas fa-sticky-note me-1"></i> {{ $log->notes }}
                                        </small>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-bolt me-1"></i> Aksi Cepat
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-warning btn-sm" id="btnResetHarian">
                            <i class="fas fa-redo me-1"></i> Reset Statistik Harian
                        </button>
                        <button type="button" class="btn btn-info btn-sm" id="btnRefreshData">
                            <i class="fas fa-sync-alt me-1"></i> Refresh Data Pengunjung
                        </button>
                        <button type="button" class="btn btn-success btn-sm" id="btnExportData">
                            <i class="fas fa-download me-1"></i> Export Data
                        </button>
                    </div>
                    
                    <hr>
                    
                    <div class="mt-3">
                        <h6 class="text-primary mb-3">Data Aktual Pengunjung</h6>
                        <div class="row text-center">
                            <div class="col-6 mb-3">
                                <div class="border rounded p-2">
                                    <small class="text-muted d-block">Hari Ini</small>
                                    <strong class="text-success">{{ $visitorStats['today'] }}</strong>
                                    <br>
                                    <small class="text-muted">({{ $visitorStats['today_unique'] }} unik)</small>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="border rounded p-2">
                                    <small class="text-muted d-block">Bulan Ini</small>
                                    <strong class="text-info">{{ $visitorStats['this_month'] }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Form Statistik -->
    <div class="modal fade" id="modalStatistik" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="formStatistik" novalidate>
                    @csrf
                    <input type="hidden" id="formMethod" name="_method" value="POST">
                    <input type="hidden" id="form_id" name="id">
                    
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-chart-bar me-2"></i>
                            <span id="modalTitle">Tambah Statistik</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <!-- Display Name -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Nama Tampilan <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control" 
                                           name="display_name" 
                                           id="display_name"
                                           placeholder="Contoh: Pageview Hari Ini"
                                           required>
                                    <div class="invalid-feedback" id="display_name_error"></div>
                                </div>
                                
                                <!-- Name (Key) -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Kode Statistik <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control" 
                                           name="name" 
                                           id="name"
                                           placeholder="Contoh: pageview_hari_ini"
                                           pattern="[a-z0-9_]+"
                                           required>
                                    <div class="form-text">
                                        Gunakan huruf kecil, angka, dan underscore. Tidak boleh ada spasi.
                                    </div>
                                    <div class="invalid-feedback" id="name_error"></div>
                                </div>
                                
                                <!-- Description -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Deskripsi
                                    </label>
                                    <textarea
                                        name="description"
                                        id="description"
                                        class="form-control"
                                        rows="3"
                                        placeholder="Deskripsi singkat tentang statistik ini..."
                                    ></textarea>
                                </div>
                                
                                <!-- Value -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Nilai Awal <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" 
                                           class="form-control" 
                                           name="value" 
                                           id="value"
                                           value="0"
                                           min="0"
                                           required>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <!-- Category -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Kategori <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select" name="category" id="category" required>
                                        <option value="">Pilih Kategori</option>
                                        <option value="daily">Harian</option>
                                        <option value="monthly">Bulanan</option>
                                        <option value="total">Total</option>
                                        <option value="analytics">Analytics</option>
                                        <option value="system">System</option>
                                        <option value="other">Lainnya</option>
                                    </select>
                                    <div class="invalid-feedback" id="category_error"></div>
                                </div>
                                
                                <!-- Unit -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Satuan
                                    </label>
                                    <input type="text" 
                                           class="form-control" 
                                           name="unit" 
                                           id="unit"
                                           placeholder="Contoh: views, visitors, %">
                                </div>
                                
                                <!-- Icon and Color -->
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label fw-bold">
                                            Icon
                                        </label>
                                        <input type="text" 
                                               class="form-control" 
                                               name="icon" 
                                               id="icon"
                                               placeholder="fas fa-eye">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label fw-bold">
                                            Warna
                                        </label>
                                        <select class="form-select" name="color" id="color">
                                            <option value="primary">Primary (Biru)</option>
                                            <option value="success">Success (Hijau)</option>
                                            <option value="info">Info (Biru Muda)</option>
                                            <option value="warning">Warning (Kuning)</option>
                                            <option value="danger">Danger (Merah)</option>
                                            <option value="dark">Dark (Hitam)</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Settings Card -->
                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Pengaturan</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" 
                                                   type="checkbox" 
                                                   name="is_visible" 
                                                   id="is_visible" 
                                                   value="1"
                                                   checked>
                                            <label class="form-check-label fw-bold" for="is_visible">
                                                Tampilkan di Frontend
                                            </label>
                                        </div>
                                        
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" 
                                                   type="checkbox" 
                                                   name="is_editable" 
                                                   id="is_editable" 
                                                   value="1"
                                                   checked>
                                            <label class="form-check-label fw-bold" for="is_editable">
                                                Bisa diubah Manual
                                            </label>
                                        </div>
                                        
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" 
                                                   type="checkbox" 
                                                   name="is_auto_increment" 
                                                   id="is_auto_increment" 
                                                   value="1">
                                            <label class="form-check-label fw-bold" for="is_auto_increment">
                                                Auto Increment
                                            </label>
                                            <div class="form-text">
                                                Nilai bertambah otomatis
                                            </div>
                                        </div>
                                        
                                        <!-- Sort Order -->
                                        <div class="mt-3">
                                            <label class="form-label fw-bold">
                                                Urutan Tampilan
                                            </label>
                                            <input type="number" 
                                                   class="form-control" 
                                                   name="sort_order" 
                                                   id="sort_order"
                                                   value="0"
                                                   min="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="btnSimpan">
                            <i class="fas fa-save me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Update Value -->
    <div class="modal fade" id="modalUpdateValue" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formUpdateValue" novalidate>
                    @csrf
                    <input type="hidden" id="update_statistic_id" name="statistic_id">
                    
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-sync-alt me-2"></i>
                            Update Nilai Statistik
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    
                    <div class="modal-body">
                        <p id="updateDescription"></p>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                Nilai Baru <span class="text-danger">*</span>
                            </label>
                            <input type="number" 
                                   class="form-control" 
                                   name="value" 
                                   id="update_value"
                                   min="0"
                                   required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                Catatan Perubahan
                            </label>
                            <textarea
                                name="notes"
                                id="update_notes"
                                class="form-control"
                                rows="2"
                                placeholder="Contoh: Penyesuaian manual, reset data, dll."
                            ></textarea>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="btnUpdate">
                            <i class="fas fa-save me-1"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
.sortable-table tr {
    cursor: move;
}

.sortable-table tr.sortable-ghost {
    opacity: 0.5;
    background: #f8f9fa;
}

.sortable-table tr.sortable-chosen {
    background-color: rgba(107, 2, 177, 0.05);
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.sortable-handle {
    cursor: move;
    text-align: center;
}

.badge.bg-info { background-color: #0dcaf0 !important; }
.badge.bg-warning { background-color: #ffc107 !important; color: #000 !important; }
.badge.bg-danger { background-color: #dc3545 !important; }
.badge.bg-success { background-color: #198754 !important; }
.badge.bg-primary { background-color: #0d6efd !important; }
.badge.bg-purple { background-color: #6f42c1 !important; }

.list-group-item:hover {
    background-color: #f8f9fa;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modalStatistik = new bootstrap.Modal('#modalStatistik');
    const modalUpdateValue = new bootstrap.Modal('#modalUpdateValue');
    const formStatistik = document.getElementById('formStatistik');
    const formUpdateValue = document.getElementById('formUpdateValue');
    
    // Initialize Sortable
    const sortableTable = document.getElementById('sortableTable');
    if (sortableTable) {
        const sortable = new Sortable(sortableTable, {
            animation: 150,
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            handle: '.sortable-handle',
            onEnd: function(evt) {
                updateOrder();
            }
        });
    }
    
    // Filter kategori
    document.querySelectorAll('.filter-category').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const category = this.dataset.category;
            
            // Update button text
            const dropdownToggle = document.querySelector('[data-bs-toggle="dropdown"]');
            dropdownToggle.textContent = category ? `Kategori: ${this.textContent}` : 'Filter Kategori';
            
            // Filter rows
            const rows = document.querySelectorAll('#statisticsTable tbody tr');
            rows.forEach(row => {
                if (!category || row.dataset.category === category) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
    
    // Update urutan
    function updateOrder() {
        const rows = document.querySelectorAll('#sortableTable tr');
        const statistics = [];
        
        rows.forEach((row, index) => {
            if (row.style.display !== 'none') {
                statistics.push({
                    id: row.dataset.id,
                    sort_order: index + 1
                });
            }
        });
        
        fetch('{{ route("backend.website-statistics.update-order") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ statistics: statistics })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update row numbers
                let visibleIndex = 1;
                rows.forEach(row => {
                    if (row.style.display !== 'none') {
                        const numberCell = row.querySelector('td:first-child');
                        if (numberCell) {
                            numberCell.innerHTML = `<i class="fas fa-arrows-alt-v text-muted"></i> ${visibleIndex++}`;
                        }
                    }
                });
                
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message || 'Urutan statistik berhasil diperbarui.',
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        });
    }
    
    // Tambah statistik button
    document.getElementById('btnTambahStatistik')?.addEventListener('click', openForm);
    document.getElementById('btnTambahEmpty')?.addEventListener('click', openForm);
    
    // Edit statistik button
    document.querySelectorAll('.btn-edit-statistic').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            editData(id);
        });
    });
    
    // Update value button
    document.querySelectorAll('.btn-update-value').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.name;
            openUpdateValue(id, name);
        });
    });
    
    // Hapus statistik button
    document.querySelectorAll('.btn-hapus-statistic').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.name;
            hapusData(id, name);
        });
    });
    
    // Quick actions
    document.getElementById('btnResetHarian')?.addEventListener('click', resetHarian);
    document.getElementById('btnRefreshData')?.addEventListener('click', refreshData);
    document.getElementById('btnExportData')?.addEventListener('click', exportData);
    
    // Open form for create
    function openForm() {
        formStatistik.reset();
        document.getElementById('formMethod').value = 'POST';
        document.getElementById('modalTitle').textContent = 'Tambah Statistik';
        document.getElementById('form_id').value = '';
        
        // Set default values
        document.getElementById('category').value = 'daily';
        document.getElementById('color').value = 'primary';
        document.getElementById('is_visible').checked = true;
        document.getElementById('is_editable').checked = true;
        document.getElementById('is_auto_increment').checked = false;
        document.getElementById('sort_order').value = '0';
        
        // Clear validation errors
        clearValidationErrors();
        
        modalStatistik.show();
    }
    
    // Open form for edit
    function editData(id) {
        // Gunakan route helper dengan parameter
        const editUrl = '{{ route("backend.website-statistics.edit", ":id") }}'.replace(':id', id);
        
        fetch(editUrl, {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const statistic = data.data;
                
                // Clear previous validation errors
                clearValidationErrors();
                
                // Set form values dengan null safety
                document.getElementById('formMethod').value = 'PUT';
                document.getElementById('form_id').value = statistic.id;
                document.getElementById('display_name').value = statistic.display_name || '';
                document.getElementById('name').value = statistic.name || '';
                document.getElementById('description').value = statistic.description || '';
                document.getElementById('value').value = statistic.value || 0;
                document.getElementById('category').value = statistic.category || 'daily';
                document.getElementById('unit').value = statistic.unit || '';
                document.getElementById('icon').value = statistic.icon || '';
                document.getElementById('color').value = statistic.color || 'primary';
                document.getElementById('is_visible').checked = Boolean(statistic.is_visible);
                document.getElementById('is_editable').checked = Boolean(statistic.is_editable);
                document.getElementById('is_auto_increment').checked = Boolean(statistic.is_auto_increment);
                document.getElementById('sort_order').value = statistic.sort_order || 0;
                
                // Disable name field on edit
                document.getElementById('name').readOnly = true;
                
                // Update modal title
                document.getElementById('modalTitle').textContent = 'Edit Statistik';
                
                modalStatistik.show();
            } else {
                throw new Error(data.message || 'Gagal mengambil data');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Terjadi kesalahan saat mengambil data: ' + error.message
            });
        });
    }
    
    // Open update value modal
    function openUpdateValue(id, name) {
        // Get current value
        const row = document.querySelector(`tr[data-id="${id}"]`);
        const currentValue = row.querySelector('strong.text-primary')?.textContent || '0';
        
        document.getElementById('update_statistic_id').value = id;
        document.getElementById('updateDescription').innerHTML = `
            <strong>${name}</strong><br>
            <small class="text-muted">Nilai saat ini: ${currentValue}</small>
        `;
        document.getElementById('update_notes').value = '';
        
        modalUpdateValue.show();
    }
    
    // Form submission - statistic
    formStatistik.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const method = document.getElementById('formMethod').value;
        const itemId = document.getElementById('form_id').value;
        
        // Show loading
        const btnSimpan = document.getElementById('btnSimpan');
        const originalText = btnSimpan.innerHTML;
        btnSimpan.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...';
        btnSimpan.disabled = true;
        
        // Set URL berdasarkan method
        let url = '{{ route("backend.website-statistics.store") }}';
        if (method === 'PUT') {
            url = '{{ route("backend.website-statistics.update", ":id") }}'.replace(':id', itemId);
        }
        
        fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            btnSimpan.innerHTML = originalText;
            btnSimpan.disabled = false;
            
            if (data.success) {
                modalStatistik.hide();
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            } else {
                // Display validation errors
                if (data.errors) {
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
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Validasi Gagal',
                        text: 'Harap perbaiki kesalahan pada form.'
                    });
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
            btnSimpan.innerHTML = originalText;
            btnSimpan.disabled = false;
            
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Terjadi kesalahan saat menyimpan data.'
            });
        });
    });
    
    // Form submission - update value
    formUpdateValue.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const statisticId = document.getElementById('update_statistic_id').value;
        
        // Show loading
        const btnUpdate = document.getElementById('btnUpdate');
        const originalText = btnUpdate.innerHTML;
        btnUpdate.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...';
        btnUpdate.disabled = true;
        
        // Gunakan route helper
        const updateUrl = '{{ route("backend.website-statistics.update-value", ":id") }}'.replace(':id', statisticId);
        
        fetch(updateUrl, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            btnUpdate.innerHTML = originalText;
            btnUpdate.disabled = false;
            
            if (data.success) {
                modalUpdateValue.hide();
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: data.message || 'Terjadi kesalahan saat update nilai.'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            btnUpdate.innerHTML = originalText;
            btnUpdate.disabled = false;
            
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Terjadi kesalahan saat update nilai.'
            });
        });
    });
    
    // Hapus data
    function hapusData(id, name) {
        Swal.fire({
            title: 'Hapus Statistik?',
            html: `Apakah Anda yakin ingin menghapus <strong>${name}</strong>?<br>
                  <small class="text-danger">Data yang dihapus tidak dapat dikembalikan!</small>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Gunakan route helper
                const deleteUrl = '{{ route("backend.website-statistics.destroy", ":id") }}'.replace(':id', id);
                
                fetch(deleteUrl, {
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
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: data.message || 'Gagal menghapus statistik.'
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
    
    // Reset statistik harian
    function resetHarian() {
        Swal.fire({
            title: 'Reset Statistik Harian?',
            html: `Apakah Anda yakin ingin mereset semua statistik harian?<br>
                  <small class="text-danger">Ini akan mengatur ulang pageview dan visitor hari ini!</small>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ffc107',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Reset!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Tapi route 'reset-daily' tidak ada di route Anda!
                // Sebagai alternatif, reset manual satu per satu
                resetDailyManual();
            }
        });
    }
    
    // Fungsi untuk reset harian manual
    function resetDailyManual() {
        // Cari statistik harian
        const dailyStats = document.querySelectorAll('tr[data-category="daily"]');
        const resetPromises = [];
        
        // Reset masing-masing statistik
        dailyStats.forEach(row => {
            const id = row.dataset.id;
            const name = row.querySelector('strong.text-dark').textContent;
            
            // Buat promise untuk reset setiap statistik
            resetPromises.push(
                fetch('{{ route("backend.website-statistics.reset", ":id") }}'.replace(':id', id), {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        notes: 'Reset statistik harian'
                    })
                })
            );
        });
        
        // Jalankan semua reset secara paralel
        Promise.all(resetPromises)
            .then(responses => Promise.all(responses.map(r => r.json())))
            .then(results => {
                const allSuccess = results.every(r => r.success);
                
                if (allSuccess) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Semua statistik harian telah direset',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Sebagian Berhasil',
                        text: 'Beberapa statistik gagal direset'
                    }).then(() => {
                        location.reload();
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat reset: ' + error.message
                });
            });
    }
    
    // Refresh data pengunjung
    function refreshData() {
        Swal.fire({
            title: 'Refresh Data Pengunjung?',
            text: 'Data pengunjung akan diperbarui dari database.',
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#0dcaf0',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Refresh!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Route refresh-visitors tidak ada, gunakan visitor-stats
                fetch('{{ route("backend.website-statistics.visitor-stats") }}', {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Data pengunjung berhasil direfresh',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: data.message || 'Gagal refresh data.'
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat refresh.'
                    });
                });
            }
        });
    }
    
    // Export data
    function exportData() {
        Swal.fire({
            title: 'Export Data Statistik',
            text: 'Hanya format CSV yang tersedia saat ini',
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Export CSV',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Export CSV - buat form untuk download
                const form = document.createElement('form');
                form.method = 'GET';
                form.action = '{{ route("backend.website-statistics.export.csv") }}';
                document.body.appendChild(form);
                form.submit();
                document.body.removeChild(form);
            }
        });
    }
    
    // Clear validation errors
    function clearValidationErrors() {
        formStatistik.querySelectorAll('.is-invalid').forEach(field => {
            field.classList.remove('is-invalid');
        });
        formStatistik.querySelectorAll('.invalid-feedback').forEach(errorDiv => {
            errorDiv.textContent = '';
        });
    }
    
    // Remove invalid class on input
    formStatistik.querySelectorAll('input, select, textarea').forEach(field => {
        field.addEventListener('input', function() {
            this.classList.remove('is-invalid');
            const errorDiv = document.getElementById(`${this.name}_error`);
            if (errorDiv) {
                errorDiv.textContent = '';
            }
        });
    });
});
</script>
@endpush
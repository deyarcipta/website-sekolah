@extends('layouts.backend')

@section('content')

{{-- ================= RINGKASAN WEBSITE ================= --}}
<div class="row">

  {{-- TOTAL BERITA --}}
  <div class="col-xl-3 col-sm-6 mb-4">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-body p-4">
        <div class="row align-items-center">
          <div class="col-8">
            <p class="text-sm mb-1 text-uppercase fw-semibold text-muted">Total Berita</p>
            <h3 class="fw-bold mb-0" id="total-berita">{{ $totalBerita ?? 0 }}</h3>
            <span class="text-xs text-muted">{{ $beritaBulanIni ?? 0 }} baru bulan ini</span>
          </div>
          <div class="col-4 text-end">
            <div class="icon-circle bg-gradient-info shadow-lg d-inline-flex align-items-center justify-content-center" 
                style="width: 52px; height: 52px; border-radius: 50%;">
              <i class="fas fa-newspaper text-white" style="font-size: 1.35rem;"></i>
            </div>
          </div>
        </div>
        <div class="mt-3">
          <a href="{{ route('backend.berita.index') }}" class="text-sm text-info text-decoration-none">
            Kelola Berita <i class="fas fa-arrow-right ms-1"></i>
          </a>
        </div>
      </div>
    </div>
  </div>

  {{-- GALERI FOTO --}}
  <div class="col-xl-3 col-sm-6 mb-4">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-body p-4">
        <div class="row align-items-center">
          <div class="col-8">
            <p class="text-sm mb-1 text-uppercase fw-semibold text-muted">Galeri Foto</p>
            <h3 class="fw-bold mb-0">{{ $totalGaleri ?? 0 }}</h3>
            <span class="text-xs text-muted">{{ $fotoTerbaru ?? 0 }} foto baru</span>
          </div>
          <div class="col-4 text-end">
            <div class="icon-circle bg-gradient-success shadow-lg d-inline-flex align-items-center justify-content-center" 
                style="width: 52px; height: 52px; border-radius: 50%;">
              <i class="fas fa-images text-white" style="font-size: 1.35rem;"></i>
            </div>
          </div>
        </div>
        <div class="mt-3">
          <a href="{{ route('backend.galleries.index') }}" class="text-sm text-success text-decoration-none">
            Kelola Galeri <i class="fas fa-arrow-right ms-1"></i>
          </a>
        </div>
      </div>
    </div>
  </div>

  {{-- PENGUMUMAN --}}
  <div class="col-xl-3 col-sm-6 mb-4">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-body p-4">
        <div class="row align-items-center">
          <div class="col-8">
            <p class="text-sm mb-1 text-uppercase fw-semibold text-muted">Pengumuman</p>
            <h3 class="fw-bold mb-0">{{ $totalPengumuman ?? 0 }}</h3>
            <span class="text-xs text-muted">{{ $pengumumanAktif ?? 0 }} aktif</span>
          </div>
          <div class="col-4 text-end">
            <div class="icon-circle bg-gradient-warning shadow-lg d-inline-flex align-items-center justify-content-center" 
                style="width: 52px; height: 52px; border-radius: 50%;">
              <i class="fas fa-bullhorn text-white" style="font-size: 1.35rem;"></i>
            </div>
          </div>
        </div>
        <div class="mt-3">
          <a href="{{ route('backend.announcements.index') }}" class="text-sm text-warning text-decoration-none">
            Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
          </a>
        </div>
      </div>
    </div>
  </div>

  {{-- AGENDA --}}
  <div class="col-xl-3 col-sm-6 mb-4">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-body p-4">
        <div class="row align-items-center">
          <div class="col-8">
            <p class="text-sm mb-1 text-uppercase fw-semibold text-muted">Agenda</p>
            <h3 class="fw-bold mb-0">{{ $totalAgenda ?? 0 }}</h3>
            <span class="text-xs text-muted">{{ $agendaMendatang ?? 0 }} mendatang</span>
          </div>
          <div class="col-4 text-end">
            <div class="icon-circle bg-gradient-primary shadow-lg d-inline-flex align-items-center justify-content-center" 
                style="width: 52px; height: 52px; border-radius: 50%;">
              <i class="fas fa-calendar-alt text-white" style="font-size: 1.35rem;"></i>
            </div>
          </div>
        </div>
        <div class="mt-3">
          <a href="{{ route('backend.agenda-sekolah.index') }}" class="text-sm text-primary text-decoration-none">
            Lihat Agenda <i class="fas fa-arrow-right ms-1"></i>
          </a>
        </div>
      </div>
    </div>
  </div>

</div>

{{-- ================= KONTEN TERBARU ================= --}}
<div class="row mt-4">
  <div class="col-lg-8 mb-4">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-header bg-white border-bottom pb-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">Konten Terbaru</h5>
        <div class="text-muted">
          <small>Menampilkan {{ $kontenTerbaru->count() }} konten terbaru</small>
        </div>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead class="bg-light">
              <tr>
                <th class="border-0 ps-4">Judul</th>
                <th class="border-0">Tipe</th>
                <th class="border-0">Tanggal</th>
                <th class="border-0">Status</th>
                <th class="border-0 text-end pe-4">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($kontenTerbaru as $konten)
              <tr>
                <td class="ps-4">
                  <div class="d-flex align-items-center">
                    @if(isset($konten->thumbnail))
                    <img src="{{ asset('storage/' . $konten->thumbnail) }}" 
                         class="rounded me-3" 
                         alt="{{ $konten->type === 'pengumuman' ? $konten->title : $konten->judul }}" 
                         width="40" height="40">
                    @else
                    <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" 
                         style="width: 40px; height: 40px;">
                      <i class="fas fa-{{ $konten->type === 'pengumuman' ? 'bullhorn' : 'newspaper' }} text-muted"></i>
                    </div>
                    @endif
                    <div>
                      <h6 class="mb-0 text-sm">{{ Str::limit($konten->type === 'pengumuman' ? $konten->title : $konten->judul, 40) }}</h6>
                      @if($konten->type === 'berita' && isset($konten->kategori))
                      <small class="text-muted">{{ $konten->kategori->nama }}</small>
                      @endif
                    </div>
                  </div>
                </td>
                <td>
                  <span class="badge bg-{{ $konten->type === 'pengumuman' ? 'warning' : 'info' }}">
                    {{ $konten->type === 'pengumuman' ? 'Pengumuman' : 'Berita' }}
                  </span>
                </td>
                <td>
                  <small class="text-muted">
                    {{ \Carbon\Carbon::parse($konten->created_at)->format('d M Y') }}
                  </small>
                </td>
                <td>
                  @if($konten->type === 'pengumuman')
                    @php
                      $statusPengumuman = [
                        'active' => ['label' => 'Aktif', 'color' => 'success'],
                        'draft' => ['label' => 'Draft', 'color' => 'warning'],
                        'inactive' => ['label' => 'Nonaktif', 'color' => 'secondary']
                      ];
                    @endphp
                    @if(isset($konten->status) && array_key_exists($konten->status, $statusPengumuman))
                      <span class="badge bg-{{ $statusPengumuman[$konten->status]['color'] }}">
                        {{ $statusPengumuman[$konten->status]['label'] }}
                      </span>
                    @else
                      <span class="badge bg-secondary">Unknown</span>
                    @endif
                  @else
                    @if(isset($konten->is_published))
                      @php
                        $statusBerita = $konten->is_published == 1 
                          ? ['label' => 'Terbit', 'color' => 'success']
                          : ['label' => 'Draft', 'color' => 'warning'];
                      @endphp
                      <span class="badge bg-{{ $statusBerita['color'] }}">
                        {{ $statusBerita['label'] }}
                      </span>
                    @endif
                  @endif
                </td>
                <td class="text-end pe-4">
                  <div class="btn-group" role="group">
                    @if($konten->type === 'pengumuman')
                      <a href="{{ route('backend.announcements.index') }}" 
                         class="btn btn-sm btn-outline-primary" title="Kelola Pengumuman">
                        <i class="fas fa-edit"></i>
                      </a>
                    @else
                      <a href="{{ route('backend.berita.index') }}" 
                         class="btn btn-sm btn-outline-primary" title="Kelola Berita">
                        <i class="fas fa-edit"></i>
                      </a>
                    @endif
                    <a href="#" class="btn btn-sm btn-outline-info" title="Preview">
                      <i class="fas fa-eye"></i>
                    </a>
                  </div>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="5" class="text-center py-4 text-muted">
                  <i class="fas fa-inbox fa-2x mb-3"></i>
                  <p>Belum ada konten</p>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div class="card-footer bg-white border-top py-3 text-center">
          <a href="{{ route('backend.berita.index') }}" class="btn btn-sm btn-outline-info me-2">
            <i class="fas fa-newspaper me-1"></i> Semua Berita
          </a>
          <a href="{{ route('backend.announcements.index') }}" class="btn btn-sm btn-outline-warning">
            <i class="fas fa-bullhorn me-1"></i> Semua Pengumuman
          </a>
        </div>
      </div>
    </div>
  </div>

  {{-- ================= STATISTIK & INFORMASI ================= --}}
  <div class="col-lg-4 mb-4">
    {{-- STATISTIK WEBSITE --}}
    <div class="card border-0 shadow-sm mb-4">
      <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">Statistik Website</h5>
        <button class="btn btn-sm btn-link text-decoration-none p-0" 
                id="refresh-stats-btn" title="Refresh statistik">
          <i class="fas fa-redo-alt text-muted"></i>
        </button>
      </div>
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-muted">Total Kunjungan</span>
          <strong class="text-primary" id="total-kunjungan">{{ $totalVisitor ?? 1245 }}</strong>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-muted">Kunjungan Hari Ini</span>
          <strong class="text-success" id="kunjungan-hari-ini">{{ $visitorHariIni ?? 48 }}</strong>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-muted">Halaman Populer</span>
          <span class="badge bg-{{ $popularPage['badge_color'] ?? 'info' }}">
                    {{ $popularPage['title'] ?? 'Beranda' }}
                </span>
        </div>
        <div class="progress mb-3" style="height: 6px;">
          <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $visitTrend['value'] ?? 0 }}%"></div>
        </div>
        <small class="text-muted d-flex justify-content-between align-items-center">
          <span>{{ $visitTrend['message'] ?? 'Tidak ada data tren kunjungan' }}</span>
          <span class="text-primary" id="stat-update-time">{{ $sessionDuration->format('H:i') }}</span>
        </small>
      </div>
    </div>

    {{-- AKTIVITAS TERAKHIR --}}
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white border-bottom">
        <h5 class="mb-0 fw-bold">Aktivitas Terakhir</h5>
      </div>
      <div class="card-body p-0">
        <div class="list-group list-group-flush">
          @forelse($aktivitasTerakhir as $aktivitas)
          <div class="list-group-item border-0 py-3">
            <div class="d-flex">
              <div class="flex-shrink-0">
                <div class="avatar avatar-sm rounded-circle bg-light d-flex align-items-center justify-content-center">
                  <i class="fas fa-{{ $aktivitas->icon }} text-{{ $aktivitas->color }}"></i>
                </div>
              </div>
              <div class="flex-grow-1 ms-3">
                <p class="mb-0 text-sm">{{ $aktivitas->deskripsi }}</p>
                <small class="text-muted">{{ $aktivitas->waktu }}</small>
              </div>
            </div>
          </div>
          @empty
          <div class="list-group-item border-0 py-3 text-center text-muted">
            <i class="fas fa-history mb-2"></i>
            <p class="mb-0">Belum ada aktivitas</p>
          </div>
          @endforelse
        </div>
        <div class="card-footer bg-white border-top py-3 text-center">
          <a href="{{ route('backend.website-statistics.index') }}" class="btn btn-sm btn-outline-primary">
            <i class="fas fa-chart-bar me-1"></i> Lihat Detail Statistik
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- ================= QUICK ACTIONS ================= --}}
<div class="row mt-4">
  <div class="col-12">
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white border-bottom">
        <h5 class="mb-0 fw-bold">Aksi Cepat</h5>
      </div>
      <div class="card-body">
        <div class="row g-3">
          <div class="col-md-3 col-6">
            <a href="{{ route('backend.dashboard.tambah-berita') }}"  class="card action-card border-0 text-center h-100 text-decoration-none">
              <div class="card-body py-4">
                <div class="icon-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" 
                    style="width: 60px; height: 60px; border-radius: 50%;">
                  <i class="fas fa-plus text-white" style="font-size: 1.5rem;"></i>
                </div>
                <h6 class="mb-0">Tambah Berita</h6>
                <small class="text-muted">Publikasi berita baru</small>
              </div>
            </a>
          </div>
          <div class="col-md-3 col-6">
            <a href="{{ route('backend.dashboard.tambah-galeri') }}" class="card action-card border-0 text-center h-100 text-decoration-none">
              <div class="card-body py-4">
                <div class="icon-circle bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" 
                    style="width: 60px; height: 60px; border-radius: 50%;">
                  <i class="fas fa-upload text-white" style="font-size: 1.5rem;"></i>
                </div>
                <h6 class="mb-0">Upload Foto</h6>
                <small class="text-muted">Tambah galeri baru</small>
              </div>
            </a>
          </div>
          <div class="col-md-3 col-6">
            <a href="{{ route('backend.dashboard.tambah-pengumuman') }}" class="card action-card border-0 text-center h-100 text-decoration-none">
              <div class="card-body py-4">
                <div class="icon-circle bg-warning bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" 
                    style="width: 60px; height: 60px; border-radius: 50%;">
                  <i class="fas fa-bullhorn text-white" style="font-size: 1.5rem;"></i>
                </div>
                <h6 class="mb-0">Buat Pengumuman</h6>
                <small class="text-muted">Informasi penting</small>
              </div>
            </a>
          </div>
          <div class="col-md-3 col-6">
            <a href="{{ route('backend.settings.index') }}" class="card action-card border-0 text-center h-100 text-decoration-none">
              <div class="card-body py-4">
                <div class="icon-circle bg-info bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" 
                    style="width: 60px; height: 60px; border-radius: 50%;">
                  <i class="fas fa-cog text-white" style="font-size: 1.5rem;"></i>
                </div>
                <h6 class="mb-0">Pengaturan</h6>
                <small class="text-muted">Konfigurasi website</small>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('styles')
<style>
.card {
  border-radius: 12px;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
}

.action-card {
  transition: all 0.3s ease;
}

.action-card:hover {
  background-color: #f8f9fa;
  transform: translateY(-5px);
}

.icon-circle {
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
}

.avatar {
  width: 36px;
  height: 36px;
}

.table th {
  font-weight: 600;
  font-size: 0.75rem;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.badge {
  padding: 0.35em 0.65em;
  font-weight: 500;
}

.progress {
  border-radius: 10px;
}

/* Loading animation for statistics */
.stat-loading {
  opacity: 0.7;
}

@keyframes pulse {
  0% { opacity: 1; }
  50% { opacity: 0.5; }
  100% { opacity: 1; }
}

.pulse {
  animation: pulse 1.5s infinite;
}

#refresh-stats-btn:hover i {
  color: var(--bs-primary) !important;
  transform: rotate(90deg);
  transition: transform 0.3s ease;
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  console.log('Dashboard script loaded');
  
  // ================= AUTO-REFRESH STATISTIK =================
  let refreshInterval;
  
  // Refresh button handler
  const refreshBtn = document.getElementById('refresh-stats-btn');
  if (refreshBtn) {
    refreshBtn.addEventListener('click', function(e) {
      e.preventDefault();
      refreshStatistik();
    });
  }
  
  function refreshStatistik() {
    console.log('Refreshing statistics...');
    
    // Add loading animation
    const statElements = ['total-kunjungan', 'kunjungan-hari-ini'];
    statElements.forEach(id => {
      const el = document.getElementById(id);
      if (el) el.classList.add('pulse', 'stat-loading');
    });
    
    // Add rotating animation to refresh button
    if (refreshBtn) {
      const icon = refreshBtn.querySelector('i');
      if (icon) {
        icon.style.transition = 'transform 0.5s ease';
        icon.style.transform = 'rotate(180deg)';
      }
    }
    
    fetch('{{ route("backend.dashboard.statistics") }}')
      .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.json();
      })
      .then(data => {
        console.log('Statistics data:', data);
        
        if (data.success) {
          // Update counter dengan animasi
          animateCounter('kunjungan-hari-ini', data.kunjungan_hari_ini);
          animateCounter('total-kunjungan', data.total_kunjungan);
          
          // Update waktu
          const updateTimeEl = document.getElementById('stat-update-time');
          if (updateTimeEl) {
            const now = new Date();
            updateTimeEl.textContent = now.getHours().toString().padStart(2, '0') + ':' + 
                                      now.getMinutes().toString().padStart(2, '0');
          }
        }
      })
      .catch(error => {
        console.error('Error refreshing statistics:', error);
      })
      .finally(() => {
        // Remove loading animation
        statElements.forEach(id => {
          const el = document.getElementById(id);
          if (el) el.classList.remove('pulse', 'stat-loading');
        });
        
        // Reset refresh button icon
        if (refreshBtn) {
          const icon = refreshBtn.querySelector('i');
          if (icon) {
            setTimeout(() => {
              icon.style.transform = 'rotate(0deg)';
            }, 300);
          }
        }
      });
  }
  
  // Animate counter
  function animateCounter(elementId, targetValue) {
    const element = document.getElementById(elementId);
    if (!element) return;
    
    let current = parseInt(element.textContent.replace(/,/g, '')) || 0;
    const increment = targetValue > current ? 1 : -1;
    const duration = 800; // ms
    const difference = Math.abs(targetValue - current);
    const stepTime = difference > 0 ? Math.abs(Math.floor(duration / difference)) : 0;
    
    if (stepTime === 0) {
      element.textContent = targetValue.toLocaleString();
      return;
    }
    
    const timer = setInterval(() => {
      current += increment;
      element.textContent = current.toLocaleString();
      
      if (current === targetValue) {
        clearInterval(timer);
      }
    }, stepTime);
  }
  
  // Start auto-refresh setiap 60 detik
  function startAutoRefresh() {
    // Refresh pertama kali
    refreshStatistik();
    
    // Set interval untuk refresh otomatis
    refreshInterval = setInterval(refreshStatistik, 60000); // 60 detik
    
    console.log('Auto-refresh started (60 seconds interval)');
  }
  
  // Stop auto-refresh (jika diperlukan)
  function stopAutoRefresh() {
    if (refreshInterval) {
      clearInterval(refreshInterval);
      console.log('Auto-refresh stopped');
    }
  }
  
  // Start auto-refresh ketika halaman loaded
  startAutoRefresh();
  
  // Optional: Stop auto-refresh ketika tab tidak aktif
  document.addEventListener('visibilitychange', function() {
    if (document.hidden) {
      stopAutoRefresh();
    } else {
      startAutoRefresh();
    }
  });
});
</script>
@endsection
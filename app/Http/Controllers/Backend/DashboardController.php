<?php 

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;
use App\Models\Gallery;
use App\Models\Announcement;
use App\Models\AgendaSekolah;
use App\Models\WebsiteStatistic;
use App\Models\WebsiteVisitor;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Gunakan cache untuk performa
            $cacheKey = 'dashboard_stats_' . auth()->id();
            $cacheTime = 300; // 5 menit
            
            $dashboardData = Cache::remember($cacheKey, $cacheTime, function () {
                return $this->getDashboardData();
            });
            
            // Tambahkan real-time data yang tidak di-cache
            $dashboardData['kontenTerbaru'] = $this->getKontenTerbaru();
            
            // Data statistik halaman (tidak di-cache agar real-time)
            $dashboardData['popularPage'] = $this->getPopularPage();
            $dashboardData['visitTrend'] = $this->getVisitTrend();
            $dashboardData['bounceRate'] = $this->getBounceRate();
            $dashboardData['sessionDuration'] = $this->getSessionDuration();
            
            // Aktivitas terakhir dari database
            $dashboardData['aktivitasTerakhir'] = $this->getAktivitasTerakhir();
            
            return view('backend.dashboard', $dashboardData);
            
        } catch (\Exception $e) {
            Log::error('Dashboard error: ' . $e->getMessage());
            
            // Fallback jika ada error
            return view('backend.dashboard', $this->getFallbackData());
        }
    }
    
    /**
     * Get dashboard data dengan statistik lengkap
     */
    private function getDashboardData()
    {
        // Statistik konten dari database
        $totalBerita = Berita::count();
        $beritaBulanIni = Berita::whereMonth('created_at', now()->month)->count();
        
        $totalGaleri = Gallery::count();
        $fotoTerbaru = Gallery::whereDate('created_at', '>=', now()->subDays(30))->count();
        
        $totalPengumuman = Announcement::count();
        $pengumumanAktif = Announcement::where('status', 'active')->count();
        
        $totalAgenda = AgendaSekolah::count();
        $agendaMendatang = AgendaSekolah::where('tanggal', '>=', now())->count();
        
        // Statistik website dari model WebsiteStatistic
        $websiteStats = [];
        if (class_exists('App\Models\WebsiteStatistic')) {
            $websiteStats = WebsiteStatistic::where('is_visible', true)
                ->orderBy('sort_order')
                ->get()
                ->keyBy('name');
        }
        
        // Visitor statistics
        $visitorStats = [
            'today' => 0,
            'today_unique' => 0,
            'this_month' => 0,
            'total' => 0,
            'pageviews_today' => 0
        ];
        
        if (class_exists('App\Models\WebsiteVisitor')) {
            try {
                $visitorStats = [
                    'today' => $this->getStatisticValue($websiteStats, 'visitor_hari_ini', 0),
                    'today_unique' => WebsiteVisitor::today()->unique()->count(),
                    'this_month' => $this->getStatisticValue($websiteStats, 'visitor_bulan_ini', 0),
                    'total' => $this->getStatisticValue($websiteStats, 'total_visitor', 0),
                    'pageviews_today' => $this->getStatisticValue($websiteStats, 'pageview_hari_ini', 0)
                ];
            } catch (\Exception $e) {
                Log::warning('Error getting visitor stats: ' . $e->getMessage());
            }
        }
        
        // Dashboard statistics
        $totalKunjungan = $visitorStats['total'];
        $kunjunganHariIni = $visitorStats['today'];
        $pageViews = $visitorStats['pageviews_today'];
        
        // Analytics stats
        $bounceRate = $this->getStatisticValue($websiteStats, 'bounce_rate', 45);
        $avgSession = $this->getStatisticValue($websiteStats, 'avg_session_duration', 180);
        
        // Statistik untuk footer (akan digunakan di View Composer)
        $this->setFooterStatistics($pageViews, $visitorStats['today'], $visitorStats['this_month'], $visitorStats['total']);
        
        return [
            'totalBerita' => $totalBerita,
            'beritaBulanIni' => $beritaBulanIni,
            'totalGaleri' => $totalGaleri,
            'fotoTerbaru' => $fotoTerbaru,
            'totalPengumuman' => $totalPengumuman,
            'pengumumanAktif' => $pengumumanAktif,
            'totalAgenda' => $totalAgenda,
            'agendaMendatang' => $agendaMendatang,
            'totalKunjungan' => $totalKunjungan,
            'kunjunganHariIni' => $kunjunganHariIni,
            'pageViews' => $pageViews,
            'bounceRate' => $bounceRate,
            'avgSession' => $avgSession,
            'websiteStats' => $websiteStats,
            'visitorStats' => $visitorStats,
            'pageviewHariIni' => $pageViews,
            'visitorHariIni' => $visitorStats['today'],
            'visitorBulanIni' => $visitorStats['this_month'],
            'totalVisitor' => $visitorStats['total']
        ];
    }
    
    /**
     * Get popular page for dashboard
     */
    private function getPopularPage()
    {
        if (class_exists('App\Models\WebsiteStatistic')) {
            try {
                return WebsiteStatistic::getMostPopularPage('today');
            } catch (\Exception $e) {
                Log::warning('Error getting popular page: ' . $e->getMessage());
            }
        }
        
        // Fallback jika tidak ada data
        return [
            'page' => '/',
            'visits' => 0,
            'title' => 'Beranda',
            'badge_color' => 'primary'
        ];
    }
    
    /**
     * Get visit trend
     */
    private function getVisitTrend()
    {
        if (class_exists('App\Models\WebsiteStatistic')) {
            try {
                $result = WebsiteStatistic::calculateVisitTrend('daily');
                
                // Jika result sudah array, format message yang konsisten
                if (is_array($result)) {
                    $value = $result['value'] ?? 0;
                    $isIncrease = $result['is_increase'] ?? true;
                    $trendText = $isIncrease ? 'meningkat' : 'menurun';
                    
                    return [
                        'value' => $value,
                        'is_increase' => $isIncrease,
                        'message' => "Tren kunjungan {$trendText} " . abs($value) . "%"
                    ];
                }
                
                // Jika result string, parse ke array
                if (is_string($result)) {
                    preg_match('/(meningkat|menurun)\s*(\d+)%/i', $result, $matches);
                    $value = isset($matches[2]) ? (int)$matches[2] : 15;
                    $isIncrease = isset($matches[1]) ? ($matches[1] === 'meningkat') : true;
                    $trendText = $isIncrease ? 'meningkat' : 'menurun';
                    
                    return [
                        'value' => $value,
                        'is_increase' => $isIncrease,
                        'message' => "Tren kunjungan {$trendText} " . abs($value) . "%"
                    ];
                }
                
            } catch (\Exception $e) {
                Log::warning('Error calculating visit trend: ' . $e->getMessage());
            }
        }
        
        // Fallback - return array dengan message yang konsisten
        return [
            'value' => 15,
            'is_increase' => true,
            'message' => 'Tren kunjungan meningkat 15%'
        ];
    }
    
    /**
     * Get bounce rate
     */
    private function getBounceRate()
    {
        if (class_exists('App\Models\WebsiteStatistic')) {
            try {
                return WebsiteStatistic::calculateBounceRate('today');
            } catch (\Exception $e) {
                Log::warning('Error calculating bounce rate: ' . $e->getMessage());
            }
        }
        
        return 45; // Default
    }
    
    /**
     * Get session duration
     */
    private function getSessionDuration()
    {
        if (class_exists('App\Models\WebsiteStatistic')) {
            try {
                $result = WebsiteStatistic::calculateAvgSessionDuration('today');
                // Pastikan selalu mengembalikan objek Carbon
                return $result instanceof \DateTime ? $result : \Carbon\Carbon::createFromTimestamp(0)->addSeconds($result['seconds'] ?? 180);
            } catch (\Exception $e) {
                Log::warning('Error calculating session duration: ' . $e->getMessage());
            }
        }
        
        // Return objek Carbon sebagai fallback
        return \Carbon\Carbon::createFromTime(0, 3, 0); // 0 jam, 3 menit
    }
    
    /**
     * Set statistics untuk footer (agar bisa diakses global)
     */
    private function setFooterStatistics($pageviewHariIni, $visitorHariIni, $visitorBulanIni, $totalVisitor)
    {
        // Simpan dalam session agar bisa diakses oleh View Composer
        session([
            'footer_pageview_hari_ini' => $pageviewHariIni,
            'footer_visitor_hari_ini' => $visitorHariIni,
            'footer_visitor_bulan_ini' => $visitorBulanIni,
            'footer_total_visitor' => $totalVisitor
        ]);
    }
    
    /**
     * Get content terbaru (tidak di-cache)
     */
    private function getKontenTerbaru()
    {
        $latestBerita = Berita::with('kategori')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function($item) {
                $item->type = 'berita';
                return $item;
            });
        
        $latestPengumuman = Announcement::orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function($item) {
                $item->type = 'pengumuman';
                return $item;
            });
        
        return $latestBerita->merge($latestPengumuman)
            ->sortByDesc('created_at')
            ->take(8);
    }
    
    /**
     * Get aktivitas terakhir dari database
     */
    private function getAktivitasTerakhir()
    {
        try {
            // Coba ambil dari ActivityLog jika ada
            if (class_exists('App\Models\ActivityLog')) {
                $activities = ActivityLog::with(['causer', 'subject'])
                    ->recent(4)
                    ->get();
                
                if ($activities->count() > 0) {
                    return $activities->map(function($activity) {
                        return (object) [
                            'icon' => $activity->icon,
                            'color' => $activity->color,
                            'deskripsi' => $activity->formatted_description ?? $activity->description,
                            'waktu' => $activity->time_ago ?? $activity->created_at->diffForHumans()
                        ];
                    });
                }
            }
            
        } catch (\Exception $e) {
            Log::warning('Cannot get activity logs from database: ' . $e->getMessage());
        }
        
        // Fallback ke data default jika tidak ada data di database
        return $this->getDefaultAktivitas();
    }
    
    /**
     * Get default aktivitas (fallback)
     */
    private function getDefaultAktivitas()
    {
        return collect([
            (object) [
                'icon' => 'newspaper',
                'color' => 'info',
                'deskripsi' => 'Berita baru ditambahkan',
                'waktu' => '2 jam yang lalu'
            ],
            (object) [
                'icon' => 'image',
                'color' => 'success',
                'deskripsi' => 'Foto galeri diupload',
                'waktu' => '5 jam yang lalu'
            ],
            (object) [
                'icon' => 'user',
                'color' => 'primary',
                'deskripsi' => 'Admin login ke sistem',
                'waktu' => 'Hari ini'
            ],
            (object) [
                'icon' => 'cog',
                'color' => 'warning',
                'deskripsi' => 'Pengaturan diperbarui',
                'waktu' => 'Kemarin'
            ]
        ]);
    }
    
    /**
     * Get fallback data untuk error handling
     */
    private function getFallbackData()
    {
        return [
            'totalBerita' => 0,
            'beritaBulanIni' => 0,
            'totalGaleri' => 0,
            'fotoTerbaru' => 0,
            'totalPengumuman' => 0,
            'pengumumanAktif' => 0,
            'totalAgenda' => 0,
            'agendaMendatang' => 0,
            'kontenTerbaru' => collect(),
            'aktivitasTerakhir' => $this->getDefaultAktivitas(),
            'totalKunjungan' => 0,
            'kunjunganHariIni' => 0,
            'websiteStats' => collect(),
            'visitorStats' => [
                'today' => 0,
                'today_unique' => 0,
                'this_month' => 0,
                'total' => 0,
                'pageviews_today' => 0
            ],
            'pageViews' => 0,
            'bounceRate' => 45,
            'avgSession' => 180,
            'pageviewHariIni' => 0,
            'visitorHariIni' => 0,
            'visitorBulanIni' => 0,
            'totalVisitor' => 0,
            'popularPage' => [
                'page' => '/',
                'visits' => 0,
                'title' => 'Beranda',
                'badge_color' => 'primary'
            ],
            'visitTrend' => [
                'value' => 15,
                'is_increase' => true,
                'message' => 'Tren kunjungan meningkat 15%'
            ],
            'sessionDuration' => [
                'seconds' => 180,
                'formatted' => '3 menit',
                'percentage' => 60
            ]
        ];
    }
    
    /**
     * Get statistic value dengan fallback
     */
    private function getStatisticValue($websiteStats, $name, $default = 0)
    {
        if (is_array($websiteStats) && isset($websiteStats[$name])) {
            return $websiteStats[$name]->value ?? $default;
        }
        
        if ($websiteStats instanceof \Illuminate\Support\Collection && isset($websiteStats[$name])) {
            return $websiteStats[$name]->value ?? $default;
        }
        
        return $default;
    }
    
    /**
     * API untuk statistik realtime
     */
    public function getStatistics(Request $request)
    {
        try {
            // Increment kunjungan hari ini di session (untuk demo)
            $today = now()->format('Y-m-d');
            $sessionKey = 'visits_' . $today;
            $todayVisits = session($sessionKey, 0);
            $todayVisits++;
            session([$sessionKey => $todayVisits]);
            
            // Update total kunjungan di session
            $totalVisits = session('total_visits', 0);
            $totalVisits++;
            session(['total_visits' => $totalVisits]);
            
            // Jika ada model WebsiteStatistic, update juga di sana
            $websiteStats = [];
            if (class_exists('App\Models\WebsiteStatistic')) {
                try {
                    // Increment pageview hari ini
                    $pageviewStat = WebsiteStatistic::where('name', 'pageview_hari_ini')->first();
                    if ($pageviewStat && $pageviewStat->is_auto_increment) {
                        $oldValue = $pageviewStat->value;
                        $pageviewStat->increment('value');
                        $todayVisits = $pageviewStat->value;
                        
                        // Log perubahan
                        if (method_exists($pageviewStat, 'logChange')) {
                            $pageviewStat->logChange(
                                'auto_increment', 
                                $oldValue, 
                                $pageviewStat->value, 
                                "Auto increment dari dashboard"
                            );
                        }
                    }
                    
                    // Get semua website statistics values untuk response
                    $stats = WebsiteStatistic::whereIn('name', [
                        'pageview_hari_ini',
                        'visitor_hari_ini',
                        'visitor_bulan_ini',
                        'total_visitor',
                        'bounce_rate',
                        'avg_session_duration'
                    ])->get();
                    
                    foreach ($stats as $stat) {
                        $websiteStats[$stat->name] = $stat->value;
                    }
                    
                } catch (\Exception $e) {
                    Log::warning('Failed to update website statistics: ' . $e->getMessage());
                }
            }
            
            // Hitung statistik konten real-time
            $beritaHariIni = Berita::whereDate('created_at', now()->toDateString())->count();
            $pengumumanHariIni = Announcement::whereDate('created_at', now()->toDateString())->count();
            $agendaHariIni = AgendaSekolah::whereDate('created_at', now()->toDateString())->count();
            
            // Get real-time statistics
            $popularPage = $this->getPopularPage();
            $visitTrend = $this->getVisitTrend();
            $bounceRate = $this->getBounceRate();
            $sessionDuration = $this->getSessionDuration();
            
            // Update session untuk View Composer
            $this->setFooterStatistics(
                $websiteStats['pageview_hari_ini'] ?? $todayVisits,
                $websiteStats['visitor_hari_ini'] ?? 0,
                $websiteStats['visitor_bulan_ini'] ?? 0,
                $websiteStats['total_visitor'] ?? $totalVisits
            );
            
            // Clear cache untuk refresh data
            Cache::forget('dashboard_stats_' . auth()->id());
            
            return response()->json([
                'success' => true,
                'kunjungan_hari_ini' => $todayVisits,
                'total_kunjungan' => $totalVisits,
                'berita_hari_ini' => $beritaHariIni,
                'pengumuman_hari_ini' => $pengumumanHariIni,
                'agenda_hari_ini' => $agendaHariIni,
                'website_stats' => $websiteStats,
                'popular_page' => $popularPage,
                'visit_trend' => $visitTrend,
                'bounce_rate' => $bounceRate,
                'session_duration' => $sessionDuration,
                'updated_at' => now()->format('H:i:s')
            ]);
            
        } catch (\Exception $e) {
            Log::error('Dashboard API error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'kunjungan_hari_ini' => session('visits_' . now()->format('Y-m-d'), 0),
                'total_kunjungan' => session('total_visits', 0),
                'updated_at' => now()->format('H:i:s')
            ], 500);
        }
    }
    
    /**
     * Get dashboard statistics summary (untuk widget)
     */
    public function getDashboardSummary(Request $request)
    {
        try {
            $stats = [];
            
            // Content statistics
            $stats['total_berita'] = Berita::count();
            $stats['berita_bulan_ini'] = Berita::whereMonth('created_at', now()->month)->count();
            $stats['total_pengumuman'] = Announcement::count();
            $stats['pengumuman_aktif'] = Announcement::where('status', 'active')->count();
            $stats['total_galeri'] = Gallery::count();
            $stats['total_agenda'] = AgendaSekolah::count();
            
            // Website statistics dari model
            if (class_exists('App\Models\WebsiteStatistic')) {
                $websiteStats = WebsiteStatistic::where('is_visible', true)
                    ->whereIn('name', [
                        'pageview_hari_ini',
                        'visitor_hari_ini',
                        'visitor_bulan_ini',
                        'total_visitor',
                        'bounce_rate',
                        'avg_session_duration'
                    ])
                    ->get();
                
                foreach ($websiteStats as $stat) {
                    $stats[$stat->name] = $stat->value;
                }
            }
            
            return response()->json([
                'success' => true,
                'data' => $stats,
                'updated_at' => now()->format('Y-m-d H:i:s')
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Refresh dashboard cache
     */
    public function refreshCache(Request $request)
    {
        try {
            Cache::forget('dashboard_stats_' . auth()->id());
            
            return response()->json([
                'success' => true,
                'message' => 'Dashboard cache berhasil di-refresh'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get statistics for footer (untuk View Composer)
     */
    public function getFooterStatistics()
    {
        try {
            if (class_exists('App\Models\WebsiteStatistic')) {
                $stats = WebsiteStatistic::whereIn('name', [
                    'pageview_hari_ini',
                    'visitor_hari_ini',
                    'visitor_bulan_ini',
                    'total_visitor'
                ])->get()->keyBy('name');
                
                return [
                    'pageviewHariIni' => $stats['pageview_hari_ini']->value ?? 0,
                    'visitorHariIni' => $stats['visitor_hari_ini']->value ?? 0,
                    'visitorBulanIni' => $stats['visitor_bulan_ini']->value ?? 0,
                    'totalVisitor' => $stats['total_visitor']->value ?? 0
                ];
            }
            
        } catch (\Exception $e) {
            Log::warning('Error getting footer statistics: ' . $e->getMessage());
        }
        
        return [
            'pageviewHariIni' => session('footer_pageview_hari_ini', 0),
            'visitorHariIni' => session('footer_visitor_hari_ini', 0),
            'visitorBulanIni' => session('footer_visitor_bulan_ini', 0),
            'totalVisitor' => session('footer_total_visitor', 0)
        ];
    }

    /**
     * Redirect to Berita with modal flag
     */
    public function redirectToBeritaWithModal()
    {
        // Set session flag untuk auto-show modal
        session()->flash('show_berita_modal', true);
        
        return redirect()->route('backend.berita.index');
    }

    /**
     * Redirect to Pengumuman with modal flag
     */
    public function redirectToPengumumanWithModal()
    {
        // Set session flag untuk auto-show modal
        session()->flash('show_pengumuman_modal', true);
        
        return redirect()->route('backend.announcements.index');
    }

    /**
     * Redirect to Gallery with modal flag
     */
    public function redirectToGalleryWithModal()
    {
        // Set session flag untuk auto-show modal
        session()->flash('show_gallery_modal', true);
        
        return redirect()->route('backend.galleries.index');
    }
    
    /**
     * Redirect to Agenda with modal flag
     */
    public function redirectToAgendaWithModal()
    {
        // Set session flag untuk auto-show modal
        session()->flash('show_agenda_modal', true);
        
        return redirect()->route('backend.agenda-sekolah.index');
    }
}
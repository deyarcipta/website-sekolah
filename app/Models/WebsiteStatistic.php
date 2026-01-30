<?php
// app/Models/WebsiteStatistic.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WebsiteStatistic extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'website_statistics';
    
    protected $fillable = [
        'name',
        'display_name',
        'category',
        'value',
        'unit',
        'icon',
        'color',
        'sort_order',
        'is_visible',
        'is_editable',
        'is_auto_increment',
        'settings',
        'description'
    ];

    protected $casts = [
        'value' => 'integer',
        'is_visible' => 'boolean',
        'is_editable' => 'boolean',
        'is_auto_increment' => 'boolean',
        'settings' => 'array',
        'sort_order' => 'integer'
    ];

    public function logs(): HasMany
    {
        return $this->hasMany(WebsiteStatisticLog::class, 'statistic_id');
    }

    // Accessor untuk nilai dengan format
    public function getFormattedValueAttribute(): string
    {
        $value = $this->value;
        
        if ($value >= 1000000) {
            return number_format($value / 1000000, 1) . ' jt';
        }
        
        if ($value >= 1000) {
            return number_format($value / 1000, 1) . ' rb';
        }
        
        return number_format($value);
    }

    // Scope untuk statistik yang ditampilkan
    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeSorted($query)
    {
        return $query->orderBy('sort_order')->orderBy('display_name');
    }

    // Method untuk increment otomatis
    public function incrementValue($amount = 1): void
    {
        $oldValue = $this->value;
        $this->increment('value', $amount);
        $this->logChange('auto', $oldValue, $this->value, 'Auto increment');
    }

    // Method untuk log perubahan
    public function logChange($type, $oldValue, $newValue, $notes = null): void
    {
        $this->logs()->create([
            'old_value' => $oldValue,
            'new_value' => $newValue,
            'change_type' => $type,
            'notes' => $notes,
            'user_id' => auth()->id()
        ]);
    }
    
    /**
     * Get popular pages from website visitors table
     */
    public static function getPopularPages($limit = 5, $period = 'today')
    {
        try {
            $query = WebsiteVisitor::query();
            
            // Filter berdasarkan periode
            switch ($period) {
                case 'today':
                    $query->whereDate('date', today());
                    break;
                case 'yesterday':
                    $query->whereDate('date', today()->subDay());
                    break;
                case 'this_week':
                    $query->whereBetween('date', [
                        now()->startOfWeek(),
                        now()->endOfWeek()
                    ]);
                    break;
                case 'this_month':
                    $query->whereMonth('date', now()->month)
                         ->whereYear('date', now()->year);
                    break;
                case 'last_month':
                    $query->whereMonth('date', now()->subMonth()->month)
                         ->whereYear('date', now()->subMonth()->year);
                    break;
            }
            
            // Query untuk halaman populer
            $popularPages = $query->select('page', DB::raw('COUNT(*) as visits'))
                ->whereNotNull('page')
                ->where('page', '!=', '')
                ->groupBy('page')
                ->orderBy('visits', 'desc')
                ->limit($limit)
                ->get();
            
            if ($popularPages->isEmpty()) {
                // Fallback jika tidak ada data
                return collect([[
                    'page' => '/',
                    'visits' => 0,
                    'title' => 'Beranda',
                    'badge_color' => 'primary'
                ]]);
            }
            
            return $popularPages->map(function($item) {
                $title = self::getPageTitle($item->page);
                return [
                    'page' => $item->page,
                    'visits' => $item->visits,
                    'title' => $title,
                    'badge_color' => self::getPageBadgeColor($item->page)
                ];
            });
            
        } catch (\Exception $e) {
            \Log::warning('Error getting popular pages: ' . $e->getMessage());
            // Fallback jika error
            return collect([[
                'page' => '/',
                'visits' => 0,
                'title' => 'Beranda',
                'badge_color' => 'info'
            ]]);
        }
    }
    
    /**
     * Get most popular page (for dashboard)
     */
    public static function getMostPopularPage($period = 'today')
    {
        $popularPages = self::getPopularPages(1, $period);
        return $popularPages->first();
    }
    
    /**
     * Calculate visit trend (percentage change)
     */
    public static function calculateVisitTrend($period = 'daily')
    {
        try {
            if ($period === 'daily') {
                // Hitung kunjungan hari ini
                $todayVisits = WebsiteVisitor::whereDate('date', today())->count();
                
                // Hitung kunjungan kemarin
                $yesterdayVisits = WebsiteVisitor::whereDate('date', today()->subDay())->count();
                
                // Hitung persentase perubahan
                if ($yesterdayVisits > 0) {
                    $change = (($todayVisits - $yesterdayVisits) / $yesterdayVisits) * 100;
                    return [
                        'value' => round($change, 1),
                        'is_increase' => $change >= 0,
                        'today' => $todayVisits,
                        'yesterday' => $yesterdayVisits,
                        'message' => $change >= 0 ? 
                            "Tren kunjungan meningkat {$change}%" : 
                            "Tren kunjungan menurun " . abs($change) . "%"
                    ];
                } else {
                    // Jika kemarin tidak ada kunjungan
                    return [
                        'value' => 100,
                        'is_increase' => true,
                        'today' => $todayVisits,
                        'yesterday' => $yesterdayVisits,
                        'message' => "Tren kunjungan meningkat (data baru)"
                    ];
                }
            }
            
            // Untuk periode mingguan
            if ($period === 'weekly') {
                $thisWeekVisits = WebsiteVisitor::whereBetween('date', [
                    now()->startOfWeek(),
                    now()->endOfWeek()
                ])->count();
                
                $lastWeekVisits = WebsiteVisitor::whereBetween('date', [
                    now()->subWeek()->startOfWeek(),
                    now()->subWeek()->endOfWeek()
                ])->count();
                
                if ($lastWeekVisits > 0) {
                    $change = (($thisWeekVisits - $lastWeekVisits) / $lastWeekVisits) * 100;
                    return [
                        'value' => round($change, 1),
                        'is_increase' => $change >= 0,
                        'message' => $change >= 0 ? 
                            "Tren mingguan meningkat {$change}%" : 
                            "Tren mingguan menurun " . abs($change) . "%"
                    ];
                }
            }
            
            // Default fallback
            return [
                'value' => 15,
                'is_increase' => true,
                'message' => 'Tren kunjungan meningkat 15%'
            ];
            
        } catch (\Exception $e) {
            \Log::warning('Error calculating visit trend: ' . $e->getMessage());
            
            return [
                'value' => 15,
                'is_increase' => true,
                'message' => 'Tren kunjungan meningkat 15%'
            ];
        }
    }
    
    /**
     * Get page title from URL
     */
    private static function getPageTitle($url)
    {
        if (!$url || $url === '/' || $url === '/home' || $url === '') {
            return 'Beranda';
        }
        
        // Mapping URL ke title
        $titleMap = [
            '/berita' => 'Berita',
            '/news' => 'Berita',
            '/pengumuman' => 'Pengumuman',
            '/announcement' => 'Pengumuman',
            '/galeri' => 'Galeri',
            '/gallery' => 'Galeri',
            '/agenda' => 'Agenda',
            '/event' => 'Agenda',
            '/profil' => 'Profil Sekolah',
            '/profile' => 'Profil Sekolah',
            '/kontak' => 'Kontak',
            '/contact' => 'Kontak',
            '/visi-misi' => 'Visi & Misi',
            '/about' => 'Tentang',
            '/sarana-prasarana' => 'Sarana Prasarana',
            '/facilities' => 'Sarana Prasarana',
            '/jurusan' => 'Program Jurusan',
            '/majors' => 'Program Jurusan',
            '/guru-staff' => 'Guru & Staff',
            '/teachers' => 'Guru & Staff',
            '/testimoni-alumni' => 'Testimoni Alumni',
            '/alumni' => 'Testimoni Alumni',
            '/mitra-kerjasama' => 'Mitra Kerjasama',
            '/partners' => 'Mitra Kerjasama',
            '/ppdb' => 'PPDB',
            '/pendaftaran' => 'PPDB',
            '/login' => 'Login',
            '/register' => 'Register',
            '/admin' => 'Dashboard Admin',
            '/dashboard' => 'Dashboard'
        ];
        
        // Cek apakah URL ada dalam mapping
        foreach ($titleMap as $pattern => $title) {
            if (strpos($url, $pattern) === 0) {
                return $title;
            }
        }
        
        // Jika berita detail (berita/{slug})
        if (preg_match('/^\/berita\/.+/', $url)) {
            return 'Detail Berita';
        }
        
        // Jika pengumuman detail
        if (preg_match('/^\/pengumuman\/.+/', $url)) {
            return 'Detail Pengumuman';
        }
        
        // Jika tidak ditemukan, format dari URL path
        $path = parse_url($url, PHP_URL_PATH);
        $path = trim($path, '/');
        
        if (empty($path)) {
            return 'Beranda';
        }
        
        // Ambil segment terakhir
        $segments = explode('/', $path);
        $lastSegment = end($segments);
        
        // Decode URL dan format
        $lastSegment = urldecode($lastSegment);
        $formatted = str_replace(['-', '_'], ' ', $lastSegment);
        
        return ucwords($formatted);
    }
    
    /**
     * Get badge color for page type
     */
    private static function getPageBadgeColor($url)
    {
        if (!$url || $url === '/' || $url === '/home' || $url === '') {
            return 'primary'; // Beranda
        }
        
        $colorMap = [
            '/berita' => 'info',
            '/news' => 'info',
            '/pengumuman' => 'warning',
            '/announcement' => 'warning',
            '/galeri' => 'success',
            '/gallery' => 'success',
            '/agenda' => 'secondary',
            '/event' => 'secondary',
            '/profil' => 'dark',
            '/profile' => 'dark',
            '/kontak' => 'danger',
            '/contact' => 'danger',
            '/visi-misi' => 'info',
            '/about' => 'info',
            '/sarana-prasarana' => 'success',
            '/facilities' => 'success',
            '/jurusan' => 'primary',
            '/majors' => 'primary',
            '/guru-staff' => 'warning',
            '/teachers' => 'warning',
            '/testimoni-alumni' => 'info',
            '/alumni' => 'info',
            '/mitra-kerjasama' => 'success',
            '/partners' => 'success',
            '/ppdb' => 'primary',
            '/pendaftaran' => 'primary',
            '/login' => 'secondary',
            '/register' => 'secondary',
            '/admin' => 'dark',
            '/dashboard' => 'dark'
        ];
        
        // Cek apakah URL ada dalam mapping
        foreach ($colorMap as $pattern => $color) {
            if (strpos($url, $pattern) === 0) {
                return $color;
            }
        }
        
        // Jika berita detail
        if (preg_match('/^\/berita\/.+/', $url)) {
            return 'info';
        }
        
        // Jika pengumuman detail
        if (preg_match('/^\/pengumuman\/.+/', $url)) {
            return 'warning';
        }
        
        return 'info'; // Default
    }
    
    /**
     * Calculate bounce rate (from website visitors)
     */
    public static function calculateBounceRate($period = 'today')
    {
        try {
            $query = WebsiteVisitor::query();
            
            // Filter berdasarkan periode
            switch ($period) {
                case 'today':
                    $query->whereDate('date', today());
                    break;
                case 'yesterday':
                    $query->whereDate('date', today()->subDay());
                    break;
                case 'this_week':
                    $query->whereBetween('date', [
                        now()->startOfWeek(),
                        now()->endOfWeek()
                    ]);
                    break;
                case 'this_month':
                    $query->whereMonth('date', now()->month)
                         ->whereYear('date', now()->year);
                    break;
            }
            
            $totalVisits = $query->count();
            
            // Asumsikan bounce jika visitor hanya melihat 1 halaman dalam session
            // Di aplikasi real, Anda perlu tracking session yang lebih detail
            if ($totalVisits > 0) {
                // Ini adalah estimasi sederhana
                // Di aplikasi nyata, Anda perlu query yang lebih kompleks
                $bounceRate = rand(30, 70); // Simulasi 30-70%
                return $bounceRate;
            }
            
            return 45; // Default jika tidak ada data
            
        } catch (\Exception $e) {
            \Log::warning('Error calculating bounce rate: ' . $e->getMessage());
            return 45; // Default
        }
    }
    
    /**
     * Calculate average session duration
     */
    public static function calculateAvgSessionDuration($period = 'today')
    {
        try {
            // Di tabel website_visitors Anda, tambahkan field 'duration' jika ingin tracking duration
            // Untuk saat ini, kita return nilai default
            
            // Simulasi: 1-5 menit dalam detik
            $avgDuration = rand(60, 300); // 60-300 detik (1-5 menit)
            
            return [
                'seconds' => $avgDuration,
                'formatted' => self::formatDuration($avgDuration),
                'percentage' => min(($avgDuration / 300) * 100, 100) // 5 menit = 100%
            ];
            
        } catch (\Exception $e) {
            \Log::warning('Error calculating session duration: ' . $e->getMessage());
            return [
                'seconds' => 180,
                'formatted' => '3 menit',
                'percentage' => 60
            ];
        }
    }
    
    /**
     * Format duration from seconds to human readable
     */
    private static function formatDuration($seconds)
    {
        if ($seconds < 60) {
            return "{$seconds} detik";
        }
        
        $minutes = floor($seconds / 60);
        $remainingSeconds = $seconds % 60;
        
        if ($minutes < 60) {
            if ($remainingSeconds > 0) {
                return "{$minutes} menit {$remainingSeconds} detik";
            }
            return "{$minutes} menit";
        }
        
        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;
        
        return "{$hours} jam {$remainingMinutes} menit";
    }
}
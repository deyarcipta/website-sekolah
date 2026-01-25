<?php
// app/Http\Controllers\Backend\WebsiteStatisticsBackendController.php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\WebsiteStatistic;
use App\Models\WebsiteStatisticLog;
use App\Models\WebsiteVisitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;

class WebsiteStatisticsBackendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statistics = WebsiteStatistic::sorted()->get();
        $recentLogs = WebsiteStatisticLog::with(['statistic', 'user'])
            ->latest()
            ->take(5)
            ->get();
            
        $todayVisitors = WebsiteVisitor::today()->count();
        $todayUniqueVisitors = WebsiteVisitor::today()->unique()->count();
        $monthVisitors = WebsiteVisitor::thisMonth()->count();
        
        $visitorStats = [
            'today' => $todayVisitors,
            'today_unique' => $todayUniqueVisitors,
            'this_month' => $monthVisitors,
            'total' => WebsiteVisitor::count()
        ];
        
        $categories = WebsiteStatistic::distinct('category')->pluck('category');
        
        return view('backend.website-statistics.index', compact(
            'statistics', 
            'recentLogs', 
            'visitorStats',
            'categories'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WebsiteStatistic $websiteStatistic)
    {
        return response()->json([
            'success' => true,
            'data' => $websiteStatistic
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'display_name' => 'required|string|max:255',
            'name' => 'required|string|max:100|unique:website_statistics,name',
            'category' => 'required|string|max:50',
            'value' => 'required|integer|min:0',
            'unit' => 'nullable|string|max:20',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'is_visible' => 'boolean',
            'is_editable' => 'boolean',
            'is_auto_increment' => 'boolean',
            'sort_order' => 'integer',
        ]);
        
        $statistic = WebsiteStatistic::create($request->all());
        
        // Log perubahan
        $statistic->logChange('create', 0, $statistic->value, 'Data statistik dibuat');
        
        return response()->json([
            'success' => true,
            'message' => 'Statistik berhasil ditambahkan',
            'data' => $statistic
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WebsiteStatistic $websiteStatistic)
    {
        if (!$websiteStatistic->is_editable) {
            return response()->json([
                'success' => false,
                'message' => 'Statistik ini tidak dapat diubah manual'
            ], 403);
        }
        
        $request->validate([
            'display_name' => 'required|string|max:255',
            'value' => 'required|integer|min:0',
            'unit' => 'nullable|string|max:20',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'is_visible' => 'boolean',
            'is_editable' => 'boolean',
            'is_auto_increment' => 'boolean',
            'sort_order' => 'integer'
        ]);
        
        $oldValue = $websiteStatistic->value;
        
        $websiteStatistic->update($request->all());
        
        // Log perubahan jika nilai berubah
        if ($oldValue != $websiteStatistic->value) {
            $websiteStatistic->logChange(
                'manual', 
                $oldValue, 
                $websiteStatistic->value, 
                $request->notes ?? 'Perubahan manual'
            );
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Statistik berhasil diperbarui',
            'data' => $websiteStatistic
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WebsiteStatistic $websiteStatistic)
    {
        $websiteStatistic->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Statistik berhasil dihapus'
        ]);
    }

    /**
     * Update value of a statistic
     */
    public function updateValue(Request $request, WebsiteStatistic $websiteStatistic)
    {
        if (!$websiteStatistic->is_editable) {
            return response()->json([
                'success' => false,
                'message' => 'Statistik ini tidak dapat diubah manual'
            ], 403);
        }
        
        $request->validate([
            'value' => 'required|integer|min:0',
            'notes' => 'nullable|string|max:500'
        ]);
        
        $oldValue = $websiteStatistic->value;
        $websiteStatistic->update(['value' => $request->value]);
        
        $websiteStatistic->logChange(
            'manual_update', 
            $oldValue, 
            $websiteStatistic->value, 
            $request->notes ?? 'Perubahan nilai manual'
        );
        
        return response()->json([
            'success' => true,
            'message' => 'Nilai statistik berhasil diperbarui',
            'data' => $websiteStatistic
        ]);
    }

    /**
     * Increment statistic value
     */
    public function increment(Request $request, WebsiteStatistic $websiteStatistic)
    {
        if (!$websiteStatistic->is_auto_increment) {
            return response()->json([
                'success' => false,
                'message' => 'Statistik ini tidak dapat di-increment otomatis'
            ], 403);
        }
        
        $amount = $request->amount ?? 1;
        $oldValue = $websiteStatistic->value;
        $websiteStatistic->increment('value', $amount);
        
        $websiteStatistic->logChange(
            'auto_increment', 
            $oldValue, 
            $websiteStatistic->value, 
            "Auto increment sebanyak {$amount}"
        );
        
        return response()->json([
            'success' => true,
            'message' => 'Statistik berhasil di-increment',
            'data' => $websiteStatistic
        ]);
    }

    /**
     * Reset statistic value to 0
     */
    public function reset(Request $request, WebsiteStatistic $websiteStatistic)
    {
        $request->validate([
            'notes' => 'nullable|string|max:500'
        ]);
        
        $oldValue = $websiteStatistic->value;
        $websiteStatistic->update(['value' => 0]);
        
        $websiteStatistic->logChange(
            'reset', 
            $oldValue, 
            0, 
            $request->notes ?? 'Reset nilai'
        );
        
        return response()->json([
            'success' => true,
            'message' => 'Statistik berhasil direset',
            'data' => $websiteStatistic
        ]);
    }

    /**
     * Reset daily statistics
     */
    public function resetDaily(Request $request)
    {
        DB::beginTransaction();
        
        try {
            // Reset semua statistik harian
            $dailyStatistics = WebsiteStatistic::where('category', 'daily')->get();
            
            foreach ($dailyStatistics as $statistic) {
                $oldValue = $statistic->value;
                $statistic->update(['value' => 0]);
                
                $statistic->logChange(
                    'reset_daily', 
                    $oldValue, 
                    0, 
                    'Reset statistik harian'
                );
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Statistik harian berhasil direset',
                'reset_count' => $dailyStatistics->count()
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mereset statistik harian: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Refresh visitor statistics from actual database
     */
    public function refreshVisitors(Request $request)
    {
        try {
            // Update visitor hari ini
            $todayVisitors = WebsiteVisitor::today()->unique()->count();
            $todayStat = WebsiteStatistic::where('name', 'visitor_hari_ini')->first();
            if ($todayStat) {
                $oldValue = $todayStat->value;
                $todayStat->update(['value' => $todayVisitors]);
                $todayStat->logChange('refresh', $oldValue, $todayVisitors, 'Refresh from database');
            }
            
            // Update visitor bulan ini
            $monthVisitors = WebsiteVisitor::thisMonth()->unique()->count();
            $monthStat = WebsiteStatistic::where('name', 'visitor_bulan_ini')->first();
            if ($monthStat) {
                $oldValue = $monthStat->value;
                $monthStat->update(['value' => $monthVisitors]);
                $monthStat->logChange('refresh', $oldValue, $monthVisitors, 'Refresh from database');
            }
            
            // Update total visitor
            $totalVisitors = WebsiteVisitor::unique()->count();
            $totalStat = WebsiteStatistic::where('name', 'total_visitor')->first();
            if ($totalStat) {
                $oldValue = $totalStat->value;
                $totalStat->update(['value' => $totalVisitors]);
                $totalStat->logChange('refresh', $oldValue, $totalVisitors, 'Refresh from database');
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Data pengunjung berhasil direfresh',
                'data' => [
                    'today' => $todayVisitors,
                    'month' => $monthVisitors,
                    'total' => $totalVisitors
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal refresh data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update order of statistics
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'statistics' => 'required|array',
            'statistics.*.id' => 'required|exists:website_statistics,id',
            'statistics.*.sort_order' => 'required|integer'
        ]);
        
        DB::beginTransaction();
        
        try {
            foreach ($request->statistics as $item) {
                WebsiteStatistic::where('id', $item['id'])
                    ->update(['sort_order' => $item['sort_order']]);
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Urutan statistik berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui urutan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get visitor statistics for specific period
     */
    public function visitorStats(Request $request)
    {
        $period = $request->period ?? 'today';
        $startDate = null;
        $endDate = now();
        
        switch ($period) {
            case 'today':
                $startDate = today();
                break;
            case 'yesterday':
                $startDate = today()->subDay();
                $endDate = today();
                break;
            case 'this_week':
                $startDate = now()->startOfWeek();
                break;
            case 'this_month':
                $startDate = now()->startOfMonth();
                break;
            case 'last_month':
                $startDate = now()->subMonth()->startOfMonth();
                $endDate = now()->subMonth()->endOfMonth();
                break;
            case 'custom':
                $startDate = Carbon::parse($request->start_date);
                $endDate = Carbon::parse($request->end_date);
                break;
        }
        
        $visitors = WebsiteVisitor::when($startDate, function ($query) use ($startDate, $endDate) {
            return $query->whereBetween('date', [$startDate, $endDate]);
        })->get();
        
        $stats = [
            'total' => $visitors->count(),
            'unique' => $visitors->where('is_unique', true)->count(),
            'by_browser' => $visitors->groupBy('browser')->map->count(),
            'by_os' => $visitors->groupBy('os')->map->count(),
            'by_device' => $visitors->groupBy('device')->map->count(),
            'by_country' => $visitors->groupBy('country')->map->count(),
            'top_pages' => $visitors->groupBy('page')->map->count()->sortDesc()->take(10),
            'referrers' => $visitors->whereNotNull('referrer')->groupBy('referrer')->map->count()->sortDesc()->take(10)
        ];
        
        return response()->json([
            'success' => true,
            'data' => $stats,
            'period' => [
                'start' => $startDate?->format('Y-m-d'),
                'end' => $endDate->format('Y-m-d')
            ]
        ]);
    }

    /**
     * Get logs of statistic changes
     */
    public function logs(Request $request)
    {
        $logs = WebsiteStatisticLog::with(['statistic', 'user'])
            ->when($request->statistic_id, function ($query, $statisticId) {
                return $query->where('statistic_id', $statisticId);
            })
            ->when($request->date, function ($query, $date) {
                return $query->whereDate('created_at', $date);
            })
            ->latest()
            ->paginate(20);
            
        return response()->json([
            'success' => true,
            'data' => $logs
        ]);
    }

    /**
     * Get dashboard statistics
     */
    public function dashboardStats()
    {
        $today = today();
        
        $stats = [
            'pageviews_today' => WebsiteStatistic::where('name', 'pageview_hari_ini')->first()->value ?? 0,
            'visitors_today' => WebsiteStatistic::where('name', 'visitor_hari_ini')->first()->value ?? 0,
            'visitors_month' => WebsiteStatistic::where('name', 'visitor_bulan_ini')->first()->value ?? 0,
            'total_visitors' => WebsiteStatistic::where('name', 'total_visitor')->first()->value ?? 0,
            
            'today_actual' => WebsiteVisitor::today()->count(),
            'today_unique_actual' => WebsiteVisitor::today()->unique()->count(),
            'month_actual' => WebsiteVisitor::thisMonth()->count(),
            
            'avg_session' => WebsiteStatistic::where('name', 'avg_session_duration')->first()->value ?? 0,
            'bounce_rate' => WebsiteStatistic::where('name', 'bounce_rate')->first()->value ?? 0,
        ];
        
        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Export statistics to CSV
     */
    public function exportCsv()
    {
        $statistics = WebsiteStatistic::sorted()->get();
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="website-statistics-' . date('Y-m-d') . '.csv"',
        ];
        
        $callback = function() use ($statistics) {
            $file = fopen('php://output', 'w');
            
            // Header
            fputcsv($file, [
                'Nama Statistik',
                'Kode',
                'Kategori',
                'Nilai',
                'Satuan',
                'Status Tampil',
                'Bisa Edit',
                'Auto Increment',
                'Deskripsi',
                'Dibuat',
                'Diperbarui'
            ]);
            
            // Data
            foreach ($statistics as $statistic) {
                fputcsv($file, [
                    $statistic->display_name,
                    $statistic->name,
                    ucfirst($statistic->category),
                    $statistic->value,
                    $statistic->unit ?? '-',
                    $statistic->is_visible ? 'Ya' : 'Tidak',
                    $statistic->is_editable ? 'Ya' : 'Tidak',
                    $statistic->is_auto_increment ? 'Ya' : 'Tidak',
                    $statistic->description ?? '',
                    $statistic->created_at->format('Y-m-d H:i:s'),
                    $statistic->updated_at->format('Y-m-d H:i:s')
                ]);
            }
            
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }

    /**
     * Export statistics to PDF (placeholder)
     */
    public function exportPdf()
    {
        return response()->json([
            'success' => false,
            'message' => 'Export PDF belum tersedia. Silakan gunakan export CSV.'
        ]);
    }

    /**
     * Export statistics to Excel (placeholder)
     */
    public function exportExcel()
    {
        return response()->json([
            'success' => false,
            'message' => 'Export Excel belum tersedia. Silakan gunakan export CSV.'
        ]);
    }

    /**
     * Get all categories
     */
    public function categories()
    {
        $categories = WebsiteStatistic::distinct('category')->pluck('category');
        
        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }
}
<?php
// app/Http/Middleware/TrackWebsiteVisitor.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\WebsiteVisitor;
use App\Models\WebsiteStatistic;

class TrackWebsiteVisitor
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        // Track visitor jika bukan request API dan bukan admin
        if (!$request->is('api/*') && !$request->is('admin/*') && !$request->is('backend/*')) {
            $this->trackVisitor($request);
            $this->incrementPageview();
        }
        
        return $response;
    }
    
    protected function trackVisitor(Request $request)
    {
        try {
            $data = [
                'session_id' => session()->getId(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'page' => $request->path(),
                'referrer' => $request->header('referer'),
            ];
            
            WebsiteVisitor::recordVisit($data);
            
            // Update visitor statistics
            $this->updateVisitorStats();
            
        } catch (\Exception $e) {
            // Log error but don't break the application
            \Log::error('Visitor tracking failed: ' . $e->getMessage());
        }
    }
    
    protected function incrementPageview()
    {
        try {
            $pageviewStat = WebsiteStatistic::where('name', 'pageview_hari_ini')->first();
            if ($pageviewStat && $pageviewStat->is_auto_increment) {
                $pageviewStat->incrementValue();
            }
        } catch (\Exception $e) {
            \Log::error('Pageview increment failed: ' . $e->getMessage());
        }
    }
    
    protected function updateVisitorStats()
    {
        try {
            // Update visitor hari ini
            $todayVisitors = WebsiteVisitor::today()->unique()->count();
            $visitorStat = WebsiteStatistic::where('name', 'visitor_hari_ini')->first();
            if ($visitorStat) {
                $oldValue = $visitorStat->value;
                if ($todayVisitors > $oldValue) {
                    $visitorStat->update(['value' => $todayVisitors]);
                    $visitorStat->logChange('auto', $oldValue, $todayVisitors, 'Auto update from visitor tracking');
                }
            }
            
            // Update visitor bulan ini
            $monthVisitors = WebsiteVisitor::thisMonth()->unique()->count();
            $monthStat = WebsiteStatistic::where('name', 'visitor_bulan_ini')->first();
            if ($monthStat) {
                $oldValue = $monthStat->value;
                if ($monthVisitors > $oldValue) {
                    $monthStat->update(['value' => $monthVisitors]);
                    $monthStat->logChange('auto', $oldValue, $monthVisitors, 'Auto update from visitor tracking');
                }
            }
            
            // Update total visitor
            $totalVisitors = WebsiteVisitor::unique()->count();
            $totalStat = WebsiteStatistic::where('name', 'total_visitor')->first();
            if ($totalStat) {
                $oldValue = $totalStat->value;
                if ($totalVisitors > $oldValue) {
                    $totalStat->update(['value' => $totalVisitors]);
                    $totalStat->logChange('auto', $oldValue, $totalVisitors, 'Auto update from visitor tracking');
                }
            }
            
        } catch (\Exception $e) {
            \Log::error('Visitor stats update failed: ' . $e->getMessage());
        }
    }
}
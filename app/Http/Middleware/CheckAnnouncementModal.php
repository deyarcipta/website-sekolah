<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Announcement;
use Illuminate\Support\Facades\View;

class CheckAnnouncementModal
{
    public function handle(Request $request, Closure $next)
    {
        // Hanya cek untuk request non-ajax dan non-api
        if (!$request->ajax() && !$request->expectsJson()) {
            try {
                // Cek cookie terlebih dahulu
                $hiddenAnnouncements = [];
                foreach ($request->cookies() as $key => $value) {
                    if (str_starts_with($key, 'announcement_') && str_contains($key, '_hidden')) {
                        $id = str_replace(['announcement_', '_hidden'], '', $key);
                        $hiddenAnnouncements[] = $id;
                    }
                }
                
                // Query untuk pengumuman modal aktif
                $activeModalAnnouncement = Announcement::where('show_as_modal', true)
                    ->where('show_on_frontend', true)
                    ->where('status', 'published')
                    ->where(function($query) use ($hiddenAnnouncements) {
                        if (!empty($hiddenAnnouncements)) {
                            $query->whereNotIn('id', $hiddenAnnouncements);
                        }
                    })
                    ->where(function($query) {
                        $query->whereNull('start_date')
                              ->orWhere('start_date', '<=', now());
                    })
                    ->where(function($query) {
                        $query->whereNull('end_date')
                              ->orWhere('end_date', '>=', now());
                    })
                    ->orderBy('created_at', 'desc')
                    ->first();
                
                // Jika ada pengumuman modal, tambahkan ke view share
                if ($activeModalAnnouncement) {
                    View::share('activeAnnouncementModal', $activeModalAnnouncement);
                    
                    \Log::info('Announcement Modal Found:', [
                        'id' => $activeModalAnnouncement->id,
                        'title' => $activeModalAnnouncement->title
                    ]);
                } else {
                    \Log::info('No Active Announcement Modal Found or user has hidden it');
                }
            } catch (\Exception $e) {
                \Log::error('Error in CheckAnnouncementModal:', [
                    'error' => $e->getMessage()
                ]);
            }
        }
        
        return $next($request);
    }
}
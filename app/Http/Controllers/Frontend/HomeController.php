<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\SettingHelper;
use App\Models\KeunggulanSekolah;
use App\Models\Major;
use App\Models\TestimoniAlumni;
use App\Models\Berita;
use App\Models\Announcement;
use App\Models\AgendaSekolah;
use App\Models\Gallery;

class HomeController extends Controller
{
    /**
     * Get active modal announcement for homepage only
     */
    public function getHomepageModalAnnouncement()
    {
        try {
            // Query SEDERHANA untuk homepage saja
            $activeModalAnnouncement = Announcement::where('show_as_modal', true)
                ->where('show_on_frontend', true)
                ->where('status', 'active')
                ->where(function($query) {
                    $query->whereNull('start_date')
                          ->orWhere('start_date', '<=', now());
                })
                ->where(function($query) {
                    $query->whereNull('end_date')
                          ->orWhere('end_date', '>=', now());
                })
                ->orderBy('sort_order', 'asc')
                ->orderBy('created_at', 'desc')
                ->first();
            
            return $activeModalAnnouncement;
            
        } catch (\Exception $e) {
            \Log::error('Error getting homepage modal announcement: ' . $e->getMessage());
            return null;
        }
    }

    public function index()
    {
        $keunggulan = KeunggulanSekolah::where('is_active', true)
            ->orderBy('urutan')
            ->get();

        $majors = Major::where('is_active', true)
            ->orderBy('order')
            ->get();

        $testimoniAlumni = TestimoniAlumni::active()->ordered()->get();

        $berita = Berita::where('is_published', true)
            ->whereNull('archived_at')
            ->with('kategori')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();
        
        // Get homepage modal announcement
        $activeAnnouncementModal = $this->getHomepageModalAnnouncement();
        
        $agendaSekolah = AgendaSekolah::where('is_published', true)
            ->orderBy('tanggal', 'desc')  // Tanggal terbaru di atas
            ->orderBy('waktu', 'desc')    // Jika tanggal sama, waktu terbaru di atas
            ->orderBy('urutan', 'asc')    // Kemudian urutan manual
            ->take(5)
            ->get();

        $galleries = Gallery::where('is_published', 1)
            ->ordered()
            ->get();

        return view('frontend.home', compact(
            'keunggulan', 
            'majors', 
            'testimoniAlumni', 
            'berita', 
            'activeAnnouncementModal',
            'agendaSekolah',
            'galleries'
        ));
    }
}
<?php 

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;
use App\Models\Gallery;
use App\Models\Announcement;
use App\Models\AgendaSekolah;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Statistik website
            $totalBerita = Berita::count();
            $beritaBulanIni = Berita::whereMonth('created_at', now()->month)->count();
            
            $totalGaleri = Gallery::count();
            $fotoTerbaru = Gallery::whereDate('created_at', '>=', now()->subDays(30))->count();
            
            $totalPengumuman = Announcement::count();
            $pengumumanAktif = Announcement::where('status', 'active')->count();
            
            $totalAgenda = AgendaSekolah::count();
            $agendaMendatang = AgendaSekolah::where('tanggal', '>=', now())->count();
            
            // Konten terbaru (berita + pengumuman)
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
            
            $kontenTerbaru = $latestBerita->merge($latestPengumuman)
                ->sortByDesc('created_at')
                ->take(8);
            
            // Aktivitas terakhir
            $aktivitasTerakhir = collect([
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
            
            return view('backend.dashboard', compact(
                'totalBerita',
                'beritaBulanIni',
                'totalGaleri',
                'fotoTerbaru',
                'totalPengumuman',
                'pengumumanAktif',
                'totalAgenda',
                'agendaMendatang',
                'kontenTerbaru',
                'aktivitasTerakhir',
            ));
            
        } catch (\Exception $e) {
            // Fallback jika ada error
            return view('backend.dashboard', [
                'totalBerita' => 0,
                'beritaBulanIni' => 0,
                'totalGaleri' => 0,
                'fotoTerbaru' => 0,
                'totalPengumuman' => 0,
                'pengumumanAktif' => 0,
                'totalAgenda' => 0,
                'agendaMendatang' => 0,
                'kontenTerbaru' => collect(),
                'aktivitasTerakhir' => collect(),
            ]);
        }
    }

    /**
     * API untuk statistik realtime
     */
    public function getStatistics(Request $request)
    {
        try {
            $today = now()->format('Y-m-d');
            $sessionKey = 'visits_' . $today;
            
            // Increment kunjungan hari ini
            $todayVisits = session($sessionKey, 0);
            $todayVisits++;
            session([$sessionKey => $todayVisits]);
            
            // Update total kunjungan
            $totalVisits = session('total_visits', 1245);
            $totalVisits++;
            session(['total_visits' => $totalVisits]);
            
            // Hitung statistik konten real-time
            $beritaHariIni = Berita::whereDate('created_at', now()->toDateString())->count();
            $pengumumanHariIni = Announcement::whereDate('created_at', now()->toDateString())->count();
            $agendaHariIni = AgendaSekolah::whereDate('created_at', now()->toDateString())->count();
            
            return response()->json([
                'success' => true,
                'kunjungan_hari_ini' => $todayVisits,
                'total_kunjungan' => $totalVisits,
                'berita_hari_ini' => $beritaHariIni,
                'pengumuman_hari_ini' => $pengumumanHariIni,
                'agenda_hari_ini' => $agendaHariIni,
                'updated_at' => now()->format('H:i:s')
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'kunjungan_hari_ini' => session('visits_' . now()->format('Y-m-d'), 0),
                'total_kunjungan' => session('total_visits', 0),
                'updated_at' => now()->format('H:i:s')
            ]);
        }
    }

    public function redirectToBeritaWithModal()
    {
        // Set session flag untuk auto-show modal
        session()->flash('show_berita_modal', true);
        
        return redirect()->route('backend.berita.index');
    }

    public function redirectToPengumumanWithModal()
    {
        // Set session flag untuk auto-show modal
        session()->flash('show_pengumuman_modal', true);
        
        return redirect()->route('backend.announcements.index');
    }

    public function redirectToGalleryWithModal()
    {
        // Set session flag untuk auto-show modal
        session()->flash('show_gallery_modal', true);
        
        return redirect()->route('backend.galleries.index');
    }
    
}
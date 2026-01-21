<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\KategoriBerita;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DetailInformasiController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua berita yang published dan tidak diarsip
        $berita = Berita::where('is_published', true)
            ->whereNull('archived_at')
            ->with('kategori')
            ->orderBy('created_at', 'desc')
            ->paginate(6);
        
        $kategori = KategoriBerita::where('is_active', true)->get();
        
        return view('frontend.detail-informasi.index', compact('berita', 'kategori'));
    }
    
    public function show($slug)
    {
        $berita = Berita::where('slug', $slug)
            ->where('is_published', true)
            ->whereNull('archived_at')
            ->with('kategori')
            ->firstOrFail();
        
        // Increment views
        $berita->increment('views');
        
        // Berita terkait (3 berita terbaru lainnya)
        $relatedBerita = Berita::where('id', '!=', $berita->id)
            ->where('is_published', true)
            ->whereNull('archived_at')
            ->with('kategori')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
        
        // Berita sebelumnya dan selanjutnya
        $previous = Berita::where('id', '<', $berita->id)
            ->where('is_published', true)
            ->whereNull('archived_at')
            ->orderBy('id', 'desc')
            ->first();
        
        $next = Berita::where('id', '>', $berita->id)
            ->where('is_published', true)
            ->whereNull('archived_at')
            ->orderBy('id', 'asc')
            ->first();
        
        return view('frontend.detail-informasi.show', compact(
            'berita', 
            'relatedBerita', 
            'previous', 
            'next'
        ));
    }
    
    public function kategori($slug)
    {
        $kategori = KategoriBerita::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
        
        $berita = Berita::where('kategori_id', $kategori->id)
            ->where('is_published', true)
            ->whereNull('archived_at')
            ->with('kategori')
            ->orderBy('created_at', 'desc')
            ->paginate(6);
        
        return view('frontend.detail-informasi.kategori', compact('berita', 'kategori'));
    }
}
<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Display a listing of the galleries.
     */
    public function index(Request $request)
    {
        // Get search parameter
        $search = $request->query('search');
        
        // Base query - only published galleries ordered properly
        $query = Gallery::with(['images'])
            ->where('is_published', true)
            ->ordered();
        
        // Apply search if exists
        if ($search) {
            $query->search($search);
        }
        
        // Get galleries with pagination
        $galleries = $query->paginate(8);
        
        // Get latest galleries for sidebar or featured
        $latestGalleries = Gallery::with(['images'])
            ->where('is_published', true)
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();
        
        return view('frontend.gallery.index', compact(
            'galleries', 
            'latestGalleries',
            'search'
        ));
    }

    /**
     * Display the specified gallery.
     */
    public function show($slug)
    {
        $gallery = Gallery::with(['images'])
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();
        
        // Get other galleries (excluding current) for related section
        $relatedGalleries = Gallery::with(['images'])
        ->where('is_published', true)
        ->where('id', '!=', $gallery->id)
        ->ordered()
        ->paginate(4); // 4 items per page
        
        // Get next gallery (by urutan or tanggal)
        $nextGallery = Gallery::where('is_published', true)
            ->where(function($query) use ($gallery) {
                $query->where('urutan', '>', $gallery->urutan)
                      ->orWhere(function($q) use ($gallery) {
                          $q->where('urutan', '=', $gallery->urutan)
                            ->where('tanggal', '>', $gallery->tanggal)
                            ->orWhere(function($q2) use ($gallery) {
                                $q2->where('urutan', '=', $gallery->urutan)
                                   ->where('tanggal', '=', $gallery->tanggal)
                                   ->where('id', '>', $gallery->id);
                            });
                      });
            })
            ->ordered()
            ->first();
        
        // Get previous gallery (by urutan or tanggal)
        $previousGallery = Gallery::where('is_published', true)
            ->where(function($query) use ($gallery) {
                $query->where('urutan', '<', $gallery->urutan)
                      ->orWhere(function($q) use ($gallery) {
                          $q->where('urutan', '=', $gallery->urutan)
                            ->where('tanggal', '<', $gallery->tanggal)
                            ->orWhere(function($q2) use ($gallery) {
                                $q2->where('urutan', '=', $gallery->urutan)
                                   ->where('tanggal', '=', $gallery->tanggal)
                                   ->where('id', '<', $gallery->id);
                            });
                      });
            })
            ->ordered('desc')
            ->first();
        
        return view('frontend.gallery.show', compact(
            'gallery',
            'relatedGalleries',
            'nextGallery',
            'previousGallery'
        ));
    }
    
    /**
     * Helper function to get YouTube ID from URL
     */
    private function getYoutubeId($url)
    {
        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $url, $matches);
        return $matches[1] ?? null;
    }
}
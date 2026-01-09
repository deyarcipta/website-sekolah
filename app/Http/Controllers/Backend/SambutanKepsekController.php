<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SambutanKepsek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SambutanKepsekController extends Controller
{
    public function index()
    {
        $sambutan = SambutanKepsek::first();
        
        if (!$sambutan) {
            $sambutan = new SambutanKepsek();
        }
        
        return view('backend.sambutan-kepsek.index', compact('sambutan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'deskripsi' => 'required|string',
        ]);
        
        try {
            DB::beginTransaction();
            
            // Menggunakan helper HtmlHelper jika tersedia
            if (class_exists('App\Helpers\HtmlHelper')) {
                $cleanContent = \App\Helpers\HtmlHelper::sanitizeHtml($request->deskripsi);
            } else {
                // Fallback jika helper tidak tersedia
                $allowedTags = '<p><br><strong><em><u><ul><ol><li><h1><h2><h3><h4><h5><h6><table><thead><tbody><tr><th><td><blockquote><pre><code><a><img><span><div><hr>';
                $cleanContent = strip_tags($request->deskripsi, $allowedTags);
            }
            
            $sambutan = SambutanKepsek::first();
            
            if ($sambutan) {
                $sambutan->update(['deskripsi' => $cleanContent]);
            } else {
                SambutanKepsek::create(['deskripsi' => $cleanContent]);
            }
            
            DB::commit();
            
            // Return JSON response untuk AJAX request
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Sambutan kepala sekolah berhasil disimpan.'
                ]);
            }
            
            // Return redirect untuk non-AJAX request
            return redirect()->route('backend.sambutan-kepsek.index')
                ->with('success', 'Sambutan kepala sekolah berhasil disimpan.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Return JSON response untuk AJAX request
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }
            
            // Return redirect untuk non-AJAX request
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }
}
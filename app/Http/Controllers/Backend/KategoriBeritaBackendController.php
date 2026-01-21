<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\KategoriBerita;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriBeritaBackendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori = KategoriBerita::orderBy('urutan')->get();
        return view('backend.kategori-berita.index', compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100|unique:kategori_berita,nama',
            'slug' => 'nullable|string|max:100|unique:kategori_berita,slug',
            'warna' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:50',
            'deskripsi' => 'nullable|string',
            'urutan' => 'integer|min:0',
            'is_active' => 'boolean'
        ]);

        try {
            $data = $request->all();
            
            // Generate slug if not provided
            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['nama']);
            }
            
            // Generate unique slug if already exists
            $originalSlug = $data['slug'];
            $counter = 1;
            while (KategoriBerita::where('slug', $data['slug'])->exists()) {
                $data['slug'] = $originalSlug . '-' . $counter++;
            }
            
            $data['is_active'] = $request->has('is_active');
            
            KategoriBerita::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Kategori berita berhasil ditambahkan.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $kategori = KategoriBerita::findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $kategori
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $kategori = KategoriBerita::findOrFail($id);
            
            $validated = $request->validate([
                'nama' => 'required|string|max:100|unique:kategori_berita,nama,' . $id,
                'slug' => 'nullable|string|max:100|unique:kategori_berita,slug,' . $id,
                'warna' => 'nullable|string|max:7',
                'icon' => 'nullable|string|max:50',
                'deskripsi' => 'nullable|string',
                'urutan' => 'integer|min:0',
                'is_active' => 'boolean'
            ]);
            
            $data = $request->all();
            $data['is_active'] = $request->has('is_active');
            
            // Update slug only if nama changed or slug is provided
            if ($kategori->nama != $request->nama || $request->has('slug')) {
                if (empty($data['slug'])) {
                    $data['slug'] = Str::slug($data['nama']);
                }
                
                // Generate unique slug if already exists
                $originalSlug = $data['slug'];
                $counter = 1;
                while (KategoriBerita::where('slug', $data['slug'])->where('id', '!=', $id)->exists()) {
                    $data['slug'] = $originalSlug . '-' . $counter++;
                }
            }

            $kategori->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Kategori berita berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $kategori = KategoriBerita::findOrFail($id);
            
            // Cek apakah kategori masih digunakan
            if ($kategori->berita()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kategori tidak dapat dihapus karena masih digunakan oleh ' . $kategori->berita()->count() . ' berita.'
                ], 400);
            }
            
            $kategori->delete();

            return response()->json([
                'success' => true,
                'message' => 'Kategori berita berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update urutan kategori.
     */
    public function updateUrutan(Request $request)
    {
        try {
            $urutan = $request->input('urutan');
            
            foreach ($urutan as $item) {
                KategoriBerita::where('id', $item['id'])->update(['urutan' => $item['urutan']]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Urutan kategori berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
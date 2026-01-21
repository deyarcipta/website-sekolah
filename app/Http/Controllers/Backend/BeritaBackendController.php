<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\KategoriBerita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class BeritaBackendController extends Controller
{
    public function index(Request $request)
{
    // Query dasar
    $query = Berita::query();
    
    // Filter pencarian
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('judul', 'like', "%{$search}%")
              ->orWhere('konten', 'like', "%{$search}%")
              ->orWhere('ringkasan', 'like', "%{$search}%")
              ->orWhere('penulis', 'like', "%{$search}%");
        });
    }
    
    // PERBAIKAN 1: Filter kategori (tidak wajib)
    if ($request->filled('kategori')) {
        $query->where('kategori_id', $request->kategori);
    }
    // Jika tidak memilih kategori, tetap tampilkan semua berita
    
    // Filter status
    if ($request->filled('status')) {
        switch ($request->status) {
            case 'published':
                $query->where('is_published', true)
                      ->whereNull('archived_at');
                break;
            case 'draft':
                $query->where('is_published', false)
                      ->whereNull('archived_at');
                break;
            case 'archived':
                $query->whereNotNull('archived_at');
                break;
            case 'featured':
                $query->where('is_featured', true)
                      ->whereNull('archived_at');
                break;
            case 'headline':
                $query->where('is_headline', true)
                      ->whereNull('archived_at');
                break;
        }
    } else {
        // Default: tidak menampilkan yang diarsip
        $query->whereNull('archived_at');
    }
    
    // Urutkan
    $query->orderBy('urutan')->orderBy('created_at', 'desc');
    
    // Paginasi
    $berita = $query->paginate(10);
    
    // Statistik
    $totalBerita = Berita::count();
    $publishedCount = Berita::where('is_published', true)->whereNull('archived_at')->count();
    $draftCount = Berita::where('is_published', false)->whereNull('archived_at')->count();
    $archivedCount = Berita::whereNotNull('archived_at')->count();
    
    $kategori = KategoriBerita::all();
    
    return view('backend.berita.index', compact(
        'berita',
        'totalBerita',
        'publishedCount',
        'draftCount',
        'archivedCount',
        'kategori'
    ));
}

public function store(Request $request)
    {
        \Log::info('Store Berita Request Data:', $request->all());
        
        $validator = \Validator::make($request->all(), [
            'kategori_id' => 'nullable|exists:kategori_berita,id',
            'judul' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:berita,slug',
            'konten' => 'required|string',
            'ringkasan' => 'nullable|string|max:500',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'gambar_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:1024',
            'penulis' => 'nullable|string|max:100',
            'sumber' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'is_headline' => 'nullable|boolean',
            'is_published' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'urutan' => 'nullable|integer|min:0'
        ]);

        if ($validator->fails()) {
            \Log::error('Validation failed:', $validator->errors()->toArray());
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();
        
        try {
            DB::beginTransaction();

            // Generate slug if not provided
            if (empty($validated['slug'])) {
                $slug = Str::slug($validated['judul']);
                $count = 1;
                $originalSlug = $slug;
                
                while (Berita::where('slug', $slug)->exists()) {
                    $slug = $originalSlug . '-' . $count;
                    $count++;
                }
                $validated['slug'] = $slug;
            }

            // Handle main image upload
            if ($request->hasFile('gambar')) {
                $path = $request->file('gambar')->store('berita', 'public');
                $validated['gambar'] = $path;
            }

            // Handle thumbnail upload
            if ($request->hasFile('gambar_thumbnail')) {
                $path = $request->file('gambar_thumbnail')->store('berita/thumbnails', 'public');
                $validated['gambar_thumbnail'] = $path;
            }

            // Handle checkbox boolean values
            $validated['is_featured'] = $request->has('is_featured') ? 1 : 0;
            $validated['is_headline'] = $request->has('is_headline') ? 1 : 0;
            $validated['is_published'] = $request->has('is_published') ? 1 : 0;

            // Convert meta_keywords string to array
            if (isset($validated['meta_keywords']) && !empty($validated['meta_keywords'])) {
                $keywordsArray = explode(',', $validated['meta_keywords']);
                $keywordsArray = array_map('trim', $keywordsArray);
                $keywordsArray = array_filter($keywordsArray);
                $validated['meta_keywords'] = json_encode($keywordsArray);
            } else {
                $validated['meta_keywords'] = null;
            }

            // Set default values
            $validated['views'] = 0;
            $validated['likes'] = 0;
            $validated['shares'] = 0;
            $validated['urutan'] = $validated['urutan'] ?? 0;

            // If published_at is not set but is_published is true, set to now
            if ($validated['is_published'] && empty($validated['published_at'])) {
                $validated['published_at'] = now();
            }

            \Log::info('Final data for create:', $validated);

            $berita = Berita::create($validated);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Berita berhasil ditambahkan',
                'data' => $berita
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Store berita error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        \Log::info('Update Berita Request Data for ID ' . $id . ':', $request->all());
        
        $berita = Berita::findOrFail($id);

        $validator = \Validator::make($request->all(), [
            'kategori_id' => 'nullable|exists:kategori_berita,id',
            'judul' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:berita,slug,' . $id,
            'konten' => 'required|string',
            'ringkasan' => 'nullable|string|max:500',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'gambar_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:1024',
            'penulis' => 'nullable|string|max:100',
            'sumber' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'is_headline' => 'nullable|boolean',
            'is_published' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'archived_at' => 'nullable|date',
            'urutan' => 'nullable|integer|min:0'
        ]);

        if ($validator->fails()) {
            \Log::error('Validation failed:', $validator->errors()->toArray());
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        try {
            DB::beginTransaction();

            // Generate slug if not provided
            if (empty($validated['slug'])) {
                $slug = Str::slug($validated['judul']);
                $count = 1;
                $originalSlug = $slug;
                
                if ($slug !== $berita->slug) {
                    while (Berita::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                        $slug = $originalSlug . '-' . $count;
                        $count++;
                    }
                }
                $validated['slug'] = $slug;
            }

            // Handle main image upload
            if ($request->hasFile('gambar')) {
                // Delete old image if exists
                if ($berita->gambar) {
                    Storage::disk('public')->delete($berita->gambar);
                }
                $path = $request->file('gambar')->store('berita', 'public');
                $validated['gambar'] = $path;
            } else {
                // Keep old image if not uploading new one
                unset($validated['gambar']);
            }

            // Handle thumbnail upload
            if ($request->hasFile('gambar_thumbnail')) {
                // Delete old thumbnail if exists
                if ($berita->gambar_thumbnail) {
                    Storage::disk('public')->delete($berita->gambar_thumbnail);
                }
                $path = $request->file('gambar_thumbnail')->store('berita/thumbnails', 'public');
                $validated['gambar_thumbnail'] = $path;
            } else {
                // Keep old thumbnail if not uploading new one
                unset($validated['gambar_thumbnail']);
            }

            // Handle checkbox boolean values
            $validated['is_featured'] = $request->has('is_featured') ? 1 : 0;
            $validated['is_headline'] = $request->has('is_headline') ? 1 : 0;
            $validated['is_published'] = $request->has('is_published') ? 1 : 0;

            // Convert meta_keywords string to array
            if (isset($validated['meta_keywords']) && !empty($validated['meta_keywords'])) {
                $keywordsArray = explode(',', $validated['meta_keywords']);
                $keywordsArray = array_map('trim', $keywordsArray);
                $keywordsArray = array_filter($keywordsArray);
                $validated['meta_keywords'] = json_encode($keywordsArray);
            } else {
                $validated['meta_keywords'] = $berita->meta_keywords;
            }

            // If published_at is not set but is_published is true and previously was false, set to now
            if ($validated['is_published'] && !$berita->is_published && empty($validated['published_at'])) {
                $validated['published_at'] = now();
            }

            // If unpublishing, remove from featured and headline
            if (!$validated['is_published']) {
                $validated['is_featured'] = 0;
                $validated['is_headline'] = 0;
            }

            // Set urutan if not provided
            $validated['urutan'] = $validated['urutan'] ?? $berita->urutan;

            \Log::info('Final data for update:', $validated);

            $berita->update($validated);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Berita berhasil diperbarui',
                'data' => $berita
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Update berita error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        $berita = Berita::with('kategori')->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $berita
        ]);
    }

    public function generateSlug(Request $request)
    {
        $request->validate(['judul' => 'required|string']);
        
        $slug = Str::slug($request->judul);
        $count = 1;
        $originalSlug = $slug;
        
        while (Berita::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }
        
        return response()->json([
            'success' => true,
            'slug' => $slug
        ]);
    }
    
    public function uploadImage(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048' // 2MB
            ]);
            
            $file = $request->file('file');
            
            // Generate nama file yang unik
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $filename = 'berita/content/' . Str::slug($originalName) . '-' . time() . '.' . $extension;
            
            // Simpan file
            $path = Storage::disk('public')->put($filename, file_get_contents($file));
            
            if (!$path) {
                return response()->json([
                    'error' => 'Failed to save file'
                ], 500);
            }
            
            // Get full URL
            $url = Storage::url($filename);
            $fullUrl = asset($url);
            
            return response()->json([
                'location' => $fullUrl
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Tangani error validasi
            return response()->json([
                'error' => $e->validator->errors()->first()
            ], 400);
            
        } catch (\Exception $e) {
            // Log error untuk debugging
            \Log::error('Image upload error: ' . $e->getMessage());
            
            return response()->json([
                'error' => 'Failed to upload image: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);

        try {
            DB::beginTransaction();

            // Delete images
            if ($berita->gambar) {
                Storage::disk('public')->delete($berita->gambar);
            }
            if ($berita->gambar_thumbnail) {
                Storage::disk('public')->delete($berita->gambar_thumbnail);
            }

            $berita->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Berita berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateUrutan(Request $request)
    {
        $validated = $request->validate([
            'urutan' => 'required|array',
            'urutan.*.id' => 'required|exists:berita,id',
            'urutan.*.urutan' => 'required|integer'
        ]);

        try {
            DB::beginTransaction();

            foreach ($validated['urutan'] as $item) {
                Berita::where('id', $item['id'])->update(['urutan' => $item['urutan']]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Urutan berita berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function archive($id)
    {
        $berita = Berita::findOrFail($id);

        $berita->update([
            'archived_at' => now(),
            'is_featured' => false,
            'is_headline' => false
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berita berhasil diarsipkan'
        ]);
    }

    public function restore($id)
    {
        $berita = Berita::withTrashed()->findOrFail($id);

        $berita->update([
            'archived_at' => null
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berita berhasil dipulihkan'
        ]);
    }

    public function toggleStatus($id, $status)
    {
        $berita = Berita::findOrFail($id);

        switch ($status) {
            case 'featured':
                $berita->update(['is_featured' => !$berita->is_featured]);
                $message = $berita->is_featured ? 'Berita ditandai sebagai featured' : 'Berita dihapus dari featured';
                break;
            case 'headline':
                $berita->update(['is_headline' => !$berita->is_headline]);
                $message = $berita->is_headline ? 'Berita ditandai sebagai headline' : 'Berita dihapus dari headline';
                break;
            case 'published':
                $berita->update(['is_published' => !$berita->is_published]);
                $message = $berita->is_published ? 'Berita dipublikasikan' : 'Berita diubah ke draft';
                break;
            default:
                return response()->json([
                    'success' => false,
                    'message' => 'Status tidak valid'
                ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }
}
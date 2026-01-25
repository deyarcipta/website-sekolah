<?php
// app/Http\Controllers/Backend/GalleryBackendController.php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class GalleryBackendController extends Controller
{
    // Index page
    public function index(Request $request)
    {
        $query = Gallery::query();
        
        // Search
        if ($request->has('search') && $request->search != '') {
            $query->search($request->search);
        }
        
        // Status filter
        if ($request->has('status') && $request->status != '') {
            $query->where('is_published', $request->status == 'published');
        }
        
        // Get data with images count
        $galleries = $query->withCount('images')->ordered()->paginate(10);
        
        // Stats
        $totalGalleries = Gallery::count();
        $publishedCount = Gallery::where('is_published', true)->count();
        $draftCount = Gallery::where('is_published', false)->count();
        
        return view('backend.galleries.index', compact(
            'galleries',
            'totalGalleries',
            'publishedCount',
            'draftCount'
        ));
    }

    // Store gallery - FIXED VERSION
    public function store(Request $request)
    {
        // Log request untuk debugging
        \Log::info('Gallery Store Request', [
            'input' => $request->all(),
            'files' => $request->hasFile('images') ? count($request->file('images')) : 0,
            'has_images' => $request->hasFile('images'),
            'has_cover' => $request->hasFile('cover_image')
        ]);

        // Validasi untuk mode multipart/form-data
        $validator = Validator::make($request->all(), [
            'judul' => 'required|max:200',
            'tanggal' => 'required|date',
            'deskripsi' => 'nullable',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_published' => 'boolean',
            'urutan' => 'integer|min:0',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'captions' => 'nullable|array' // Untuk captions gambar baru
        ], [
            'judul.required' => 'Judul galeri wajib diisi',
            'tanggal.required' => 'Tanggal galeri wajib diisi',
            'tanggal.date' => 'Format tanggal tidak valid',
            'cover_image.image' => 'File cover harus berupa gambar',
            'cover_image.mimes' => 'Format cover harus jpeg, png, jpg, gif, atau webp',
            'cover_image.max' => 'Ukuran cover maksimal 2MB',
            'images.required' => 'Minimal upload 1 gambar',
            'images.min' => 'Minimal upload 1 gambar',
            'images.*.image' => 'Semua file harus berupa gambar',
            'images.*.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau webp',
            'images.*.max' => 'Ukuran gambar maksimal 5MB',
            'urutan.integer' => 'Urutan harus berupa angka',
            'urutan.min' => 'Urutan minimal 0'
        ]);

        if ($validator->fails()) {
            \Log::error('Gallery Store Validation Failed', ['errors' => $validator->errors()->toArray()]);
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            // Create gallery
            $data = [
                'judul' => $request->judul,
                'tanggal' => $request->tanggal,
                'deskripsi' => $request->deskripsi,
                'is_published' => $request->boolean('is_published'),
                'urutan' => $request->urutan ?? 0
            ];
            
            if ($request->boolean('is_published')) {
                $data['published_at'] = now();
            }
            
            // Upload cover image if exists
            if ($request->hasFile('cover_image')) {
                $coverFile = $request->file('cover_image');
                $coverName = 'gallery-cover-' . time() . '-' . Str::random(5) . '.' . $coverFile->getClientOriginalExtension();
                $coverPath = $coverFile->storeAs('galleries', $coverName, 'public');
                $data['cover_image'] = $coverPath;
            }
            
            $gallery = Gallery::create($data);
            
            // Upload multiple images
            if ($request->hasFile('images')) {
                $urutan = 0;
                $images = $request->file('images');
                
                // Debug: Log images
                \Log::info('Uploading images', [
                    'count' => count($images),
                    'files' => array_map(function($file) {
                        return [
                            'name' => $file->getClientOriginalName(),
                            'size' => $file->getSize(),
                            'type' => $file->getMimeType()
                        ];
                    }, $images)
                ]);
                
                foreach ($images as $index => $image) {
                    $filename = 'gallery-' . $gallery->id . '-' . time() . '-' . $index . '.' . $image->getClientOriginalExtension();
                    $path = $image->storeAs('gallery-images/' . $gallery->id, $filename, 'public');
                    
                    // Ambil caption jika ada
                    $caption = null;
                    if ($request->has('captions')) {
                        // Cari caption berdasarkan index file
                        $captionKey = array_keys($images)[$index]; // Key dari array files
                        if (isset($request->captions[$captionKey])) {
                            $caption = $request->captions[$captionKey];
                        }
                    }
                    
                    GalleryImage::create([
                        'gallery_id' => $gallery->id,
                        'image' => $path,
                        'caption' => $caption,
                        'urutan' => $urutan++
                    ]);
                }
            }
            
            DB::commit();
            
            \Log::info('Gallery created successfully', ['gallery_id' => $gallery->id]);
            
            return response()->json([
                'success' => true,
                'message' => 'Galeri berhasil dibuat',
                'redirect' => route('backend.galleries.index')
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Gallery Store Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    // Edit gallery
    public function edit($id)
    {
        $gallery = Gallery::with(['images' => function($query) {
            $query->orderBy('urutan', 'asc');
        }])->findOrFail($id);
        
        // Format data untuk response
        $data = [
            'id' => $gallery->id,
            'judul' => $gallery->judul,
            'deskripsi' => $gallery->deskripsi,
            'tanggal' => $gallery->tanggal,
            'urutan' => $gallery->urutan,
            'is_published' => $gallery->is_published,
            'cover_image' => $gallery->cover_image,
            'images' => $gallery->images->map(function($image) {
                return [
                    'id' => $image->id,
                    'image' => $image->image,
                    'caption' => $image->caption,
                    'urutan' => $image->urutan
                ];
            })
        ];
        
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    // Update gallery - FIXED VERSION
    public function update(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);
        
        // Log request untuk debugging
        \Log::info('Gallery Update Request', [
            'gallery_id' => $id,
            'input' => $request->except(['images', 'cover_image']),
            'files_count' => $request->hasFile('images') ? count($request->file('images')) : 0,
            'has_deleted_images' => $request->has('deleted_images'),
            'has_captions' => $request->has('captions')
        ]);

        // Validasi untuk update
        $validator = Validator::make($request->all(), [
            'judul' => 'required|max:200',
            'tanggal' => 'required|date',
            'deskripsi' => 'nullable',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_published' => 'boolean',
            'urutan' => 'integer|min:0',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'captions' => 'nullable|array',
            'captions.*' => 'nullable|string|max:500',
            'deleted_images' => 'nullable|string' // JSON string array of image IDs
        ], [
            'judul.required' => 'Judul galeri wajib diisi',
            'tanggal.required' => 'Tanggal galeri wajib diisi',
            'tanggal.date' => 'Format tanggal tidak valid',
            'cover_image.image' => 'File cover harus berupa gambar',
            'cover_image.mimes' => 'Format cover harus jpeg, png, jpg, gif, atau webp',
            'cover_image.max' => 'Ukuran cover maksimal 2MB',
            'images.*.image' => 'Semua file harus berupa gambar',
            'images.*.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau webp',
            'images.*.max' => 'Ukuran gambar maksimal 5MB',
            'captions.*.max' => 'Caption maksimal 500 karakter',
            'urutan.integer' => 'Urutan harus berupa angka',
            'urutan.min' => 'Urutan minimal 0'
        ]);

        if ($validator->fails()) {
            \Log::error('Gallery Update Validation Failed', ['errors' => $validator->errors()->toArray()]);
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            // Update gallery data
            $data = [
                'judul' => $request->judul,
                'tanggal' => $request->tanggal,
                'deskripsi' => $request->deskripsi,
                'is_published' => $request->boolean('is_published'),
                'urutan' => $request->urutan ?? $gallery->urutan
            ];
            
            // Update slug jika judul berubah
            if ($gallery->judul != $request->judul) {
                $data['slug'] = null; // akan di-generate ulang oleh model
            }
            
            // Update published_at
            if ($request->boolean('is_published') && !$gallery->published_at) {
                $data['published_at'] = now();
            } elseif (!$request->boolean('is_published') && $gallery->published_at) {
                $data['published_at'] = null;
            }
            
            // Upload/update cover image
            if ($request->hasFile('cover_image')) {
                // Delete old cover
                if ($gallery->cover_image && Storage::disk('public')->exists($gallery->cover_image)) {
                    Storage::disk('public')->delete($gallery->cover_image);
                }
                
                $coverFile = $request->file('cover_image');
                $coverName = 'gallery-cover-' . time() . '-' . Str::random(5) . '.' . $coverFile->getClientOriginalExtension();
                $coverPath = $coverFile->storeAs('galleries', $coverName, 'public');
                $data['cover_image'] = $coverPath;
            }
            
            $gallery->update($data);
            
            // Update captions for existing images
            if ($request->has('captions')) {
                $captions = $request->captions;
                \Log::info('Updating captions', ['captions' => $captions]);
                
                foreach ($captions as $imageId => $caption) {
                    // Skip jika key adalah untuk gambar baru (mengandung 'new_')
                    if (str_contains($imageId, 'new_')) {
                        continue;
                    }
                    
                    if ($image = GalleryImage::find($imageId)) {
                        $image->update(['caption' => $caption ?? null]);
                    }
                }
            }
            
            // Delete selected images
            if ($request->has('deleted_images') && $request->deleted_images) {
                $deletedImages = json_decode($request->deleted_images, true);
                \Log::info('Deleting images', ['image_ids' => $deletedImages]);
                
                if (is_array($deletedImages) && count($deletedImages) > 0) {
                    foreach ($deletedImages as $imageId) {
                        if ($image = GalleryImage::find($imageId)) {
                            // Delete file
                            if (Storage::disk('public')->exists($image->image)) {
                                Storage::disk('public')->delete($image->image);
                            }
                            $image->delete();
                        }
                    }
                }
            }
            
            // Add new images
            if ($request->hasFile('images')) {
                $lastOrder = $gallery->images()->max('urutan') ?? -1;
                $images = $request->file('images');
                
                \Log::info('Adding new images', [
                    'count' => count($images),
                    'last_order' => $lastOrder
                ]);
                
                foreach ($images as $index => $image) {
                    $filename = 'gallery-' . $gallery->id . '-' . time() . '-' . $index . '.' . $image->getClientOriginalExtension();
                    $path = $image->storeAs('gallery-images/' . $gallery->id, $filename, 'public');
                    
                    // Ambil caption untuk gambar baru
                    $caption = null;
                    if ($request->has('captions')) {
                        $captionKey = array_keys($images)[$index];
                        if (isset($request->captions[$captionKey])) {
                            $caption = $request->captions[$captionKey];
                        }
                    }
                    
                    GalleryImage::create([
                        'gallery_id' => $gallery->id,
                        'image' => $path,
                        'caption' => $caption,
                        'urutan' => ++$lastOrder
                    ]);
                }
            }
            
            DB::commit();
            
            \Log::info('Gallery updated successfully', ['gallery_id' => $gallery->id]);
            
            return response()->json([
                'success' => true,
                'message' => 'Galeri berhasil diperbarui',
                'redirect' => route('backend.galleries.index')
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Gallery Update Error', [
                'gallery_id' => $id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    // Delete gallery
    public function destroy($id)
    {
        try {
            $gallery = Gallery::with('images')->findOrFail($id);
            
            \Log::info('Deleting gallery', ['gallery_id' => $id, 'title' => $gallery->judul]);
            
            // Delete cover image
            if ($gallery->cover_image && Storage::disk('public')->exists($gallery->cover_image)) {
                Storage::disk('public')->delete($gallery->cover_image);
            }
            
            // Delete all gallery images
            foreach ($gallery->images as $image) {
                if (Storage::disk('public')->exists($image->image)) {
                    Storage::disk('public')->delete($image->image);
                }
            }
            
            // Delete directory if exists
            $directory = 'gallery-images/' . $gallery->id;
            if (Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->deleteDirectory($directory);
            }
            
            $gallery->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Galeri berhasil dihapus'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Gallery Delete Error', [
                'gallery_id' => $id,
                'message' => $e->getMessage()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    // Toggle status
    public function toggleStatus($id, $status)
    {
        try {
            $gallery = Gallery::findOrFail($id);
            
            $isPublished = $status == 'publish';
            $gallery->update([
                'is_published' => $isPublished,
                'published_at' => $isPublished ? now() : null
            ]);
            
            $action = $isPublished ? 'dipublikasikan' : 'diubah ke draft';
            
            \Log::info('Gallery status toggled', [
                'gallery_id' => $id,
                'status' => $status,
                'new_status' => $isPublished ? 'published' : 'draft'
            ]);
            
            return response()->json([
                'success' => true,
                'message' => "Galeri berhasil $action"
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Gallery Toggle Status Error', [
                'gallery_id' => $id,
                'status' => $status,
                'message' => $e->getMessage()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    // Update gallery order
    public function updateOrder(Request $request)
    {
        try {
            $order = $request->input('order', []);
            
            \Log::info('Updating gallery order', ['order' => $order]);
            
            foreach ($order as $item) {
                if (isset($item['id']) && isset($item['urutan'])) {
                    Gallery::where('id', $item['id'])->update(['urutan' => $item['urutan']]);
                }
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Urutan galeri berhasil diperbarui'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Gallery Update Order Error', [
                'message' => $e->getMessage(),
                'order' => $request->input('order')
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    // Update image order
    public function updateImageOrder(Request $request, $id)
    {
        try {
            $gallery = Gallery::findOrFail($id);
            $order = $request->input('order', []);
            
            \Log::info('Updating image order', [
                'gallery_id' => $id,
                'order' => $order
            ]);
            
            foreach ($order as $item) {
                if (isset($item['id']) && isset($item['urutan'])) {
                    GalleryImage::where('id', $item['id'])
                                ->where('gallery_id', $gallery->id)
                                ->update(['urutan' => $item['urutan']]);
                }
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Urutan gambar berhasil diperbarui'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Image Update Order Error', [
                'gallery_id' => $id,
                'message' => $e->getMessage()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    // Get gallery for modal edit (alias untuk edit)
    public function getGallery($id)
    {
        return $this->edit($id);
    }
}
<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Sarpras;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class SarprasBackendController extends Controller
{
    // Show the form for editing sarpras
    public function index()
    {
        $sarpras = Sarpras::firstOrCreate([]);
        return view('backend.sarpras.index', compact('sarpras'));
    }

    // Store or update sarpras data
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'hero_title' => 'nullable|string|max:255',
                'hero_background' => 'nullable|image|max:5120',
                'opening_paragraph' => 'required|string',

                'learning_title' => 'nullable|string|max:255',
                'learning_description' => 'required|string',
                'learning_features' => 'nullable|array',
                'learning_features.*' => 'nullable|string',
                'learning_image' => 'nullable|image|max:2048',

                'facilities_title' => 'nullable|string|max:255',
                'facility_title' => 'nullable|array',
                'facility_title.*' => 'nullable|string',
                'facility_desc' => 'nullable|array',
                'facility_desc.*' => 'nullable|string',

                'gallery_title' => 'nullable|string|max:255',
                'gallery_images' => 'nullable|array',
                'gallery_images.*' => 'nullable|image|max:2048',
                'existing_gallery_images' => 'nullable|array',
                'existing_gallery_images.*' => 'nullable|string',
            ]);
            
            $sarpras = Sarpras::firstOrCreate([]);
            
            /** HERO */
            $sarpras->hero_title = $validated['hero_title'] ?? $sarpras->hero_title;
            
            if ($request->hasFile('hero_background')) {
                if ($sarpras->hero_background) {
                    Storage::delete('public/' . $sarpras->hero_background);
                }
                $sarpras->hero_background = $request->file('hero_background')->store('sarpras', 'public');
            }
            
            /** OPENING */
            $sarpras->opening_paragraph = $validated['opening_paragraph'];
            
            /** LEARNING */
            $sarpras->learning_title = $validated['learning_title'] ?? $sarpras->learning_title;
            $sarpras->learning_description = $validated['learning_description'];
            
            if (!empty($validated['learning_features'])) {
                $sarpras->learning_features = array_values(array_filter($validated['learning_features']));
            }
            
            if ($request->hasFile('learning_image')) {
                if ($sarpras->learning_image) {
                    Storage::delete('public/' . $sarpras->learning_image);
                }
                $sarpras->learning_image = $request->file('learning_image')->store('sarpras', 'public');
            }
            
            /** FACILITIES */
            $sarpras->facilities_title = $validated['facilities_title'] ?? $sarpras->facilities_title;
            
            $facilityTitles = $request->input('facility_title', []);
            $facilityDescs  = $request->input('facility_desc', []);
            
            $items = [];
            foreach ($facilityTitles as $i => $title) {
                if (!empty($title) || !empty($facilityDescs[$i])) {
                    $items[] = [
                        'title' => $title ?? 'Fasilitas ' . ($i + 1),
                        'desc' => $facilityDescs[$i] ?? 'Deskripsi fasilitas ' . ($i + 1),
                    ];
                }
            }
            
            if (empty($items)) {
                $items = [
                    ['title' => 'Fasilitas 1', 'desc' => 'Deskripsi fasilitas 1'],
                    ['title' => 'Fasilitas 2', 'desc' => 'Deskripsi fasilitas 2'],
                    ['title' => 'Fasilitas 3', 'desc' => 'Deskripsi fasilitas 3'],
                ];
            }
            
            $sarpras->facilities_items = $items;
            
            /** GALLERY */
            $sarpras->gallery_title = $validated['gallery_title'] ?? $sarpras->gallery_title;
            
            $gallery = [];
            $existingImages = $request->input('existing_gallery_images', []);
            $newImages = $request->file('gallery_images', []);
            
            foreach ($existingImages as $index => $existingImage) {
                if (isset($newImages[$index]) && $newImages[$index]->isValid()) {
                    $path = 'storage/' . $newImages[$index]->store('sarpras/gallery', 'public');
                    $gallery[] = $path;
                    
                    if (strpos($existingImage, 'storage/') === 0) {
                        $oldPath = str_replace('storage/', 'public/', $existingImage);
                        Storage::delete($oldPath);
                    }
                } else {
                    $gallery[] = $existingImage;
                }
            }
            
            $existingCount = count($existingImages);
            $newCount = count($newImages);
            
            for ($i = $existingCount; $i < $newCount; $i++) {
                if (isset($newImages[$i]) && $newImages[$i]->isValid()) {
                    $path = 'storage/' . $newImages[$i]->store('sarpras/gallery', 'public');
                    $gallery[] = $path;
                }
            }
            
            if (empty($gallery)) {
                $gallery = [
                    'assets/img/sarpras.png',
                    'assets/img/sarpras.png',
                    'assets/img/sarpras.png',
                ];
            }
            
            $sarpras->gallery_images = $gallery;
            
            /** SAVE */
            $sarpras->save();

            return response()->json([
                'success' => true,
                'message' => 'Data Sarpras berhasil disimpan',
                'data' => [
                    'facilities_count' => count($items),
                    'gallery_count' => count($gallery)
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error($e);
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    // Remove hero background image
    public function removeHeroImage(Request $request) // TAMBAHKAN Request $request parameter
    {
        try {
            $sarpras = Sarpras::first();
            
            if ($sarpras && $sarpras->hero_background) {
                Storage::delete('public/' . $sarpras->hero_background);
                $sarpras->hero_background = null;
                $sarpras->save();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Hero background berhasil dihapus'
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    // Remove learning image
    public function removeLearningImage(Request $request) // TAMBAHKAN Request $request parameter
    {
        try {
            $sarpras = Sarpras::first();
            
            if ($sarpras && $sarpras->learning_image) {
                Storage::delete('public/' . $sarpras->learning_image);
                $sarpras->learning_image = null;
                $sarpras->save();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Gambar lingkungan belajar berhasil dihapus'
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    // Add facilities item via AJAX
    public function addFacilitiesItem(Request $request)
    {
        try {
            $sarpras = Sarpras::firstOrCreate([]);
            $currentItems = $sarpras->facilities_items ?? [];
            
            // Tambahkan item baru
            $newIndex = count($currentItems) + 1;
            $currentItems[] = [
                'title' => 'Fasilitas ' . $newIndex,
                'desc'  => 'Deskripsi fasilitas ' . $newIndex,
            ];
            
            $sarpras->facilities_items = $currentItems;
            $sarpras->save();
            
            return response()->json([
                'success' => true,
                'new_count' => count($currentItems),
                'html' => view('backend.sarpras.partials.facility-item', [
                    'index' => count($currentItems) - 1,
                    'item' => end($currentItems)
                ])->render(),
                'message' => 'Item fasilitas berhasil ditambahkan'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    // Remove facilities item via AJAX
    public function removeFacilitiesItem($index)
    {
        try {
            $sarpras = Sarpras::first();
            
            if ($sarpras) {
                $currentItems = $sarpras->facilities_items ?? [];
                
                if (isset($currentItems[$index])) {
                    // Hapus item pada index tertentu
                    array_splice($currentItems, $index, 1);
                    
                    // Reset index jika tidak ada item
                    if (empty($currentItems)) {
                        $currentItems = [
                            [
                                'title' => 'Fasilitas 1',
                                'desc'  => 'Deskripsi fasilitas 1',
                            ]
                        ];
                    }
                    
                    $sarpras->facilities_items = $currentItems;
                    $sarpras->save();
                    
                    return response()->json([
                        'success' => true,
                        'new_count' => count($currentItems),
                        'message' => 'Item fasilitas berhasil dihapus'
                    ]);
                }
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    // Add gallery image slot via AJAX
    public function addGallery(Request $request)
    {
        try {
            $sarpras = Sarpras::firstOrCreate([]);
            $currentImages = $sarpras->gallery_images ?? [];
            
            // Tambahkan slot gambar baru (default)
            $currentImages[] = 'assets/img/sarpras.png';
            
            $sarpras->gallery_images = $currentImages;
            $sarpras->save();
            
            return response()->json([
                'success' => true,
                'new_count' => count($currentImages),
                'html' => view('backend.sarpras.partials.gallery-item', [
                    'index' => count($currentImages) - 1,
                    'image' => 'assets/img/sarpras.png'
                ])->render(),
                'message' => 'Slot gallery berhasil ditambahkan'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    // Remove gallery image slot via AJAX
    public function removeGallery($index)
    {
        try {
            $sarpras = Sarpras::first();
            
            if ($sarpras) {
                $currentImages = $sarpras->gallery_images ?? [];
                
                if (isset($currentImages[$index])) {
                    // Hapus gambar dari storage jika bukan default
                    $imagePath = $currentImages[$index];
                    if (strpos($imagePath, 'storage/') === 0) {
                        $storagePath = str_replace('storage/', 'public/', $imagePath);
                        Storage::delete($storagePath);
                    }
                    
                    // Hapus item dari array dan re-index
                    unset($currentImages[$index]);
                    $currentImages = array_values($currentImages); // Re-index array
                    
                    // Reset jika tidak ada gambar
                    if (empty($currentImages)) {
                        $currentImages = ['assets/img/sarpras.png'];
                    }
                    
                    $sarpras->gallery_images = $currentImages;
                    $sarpras->save();
                    
                    return response()->json([
                        'success' => true,
                        'new_count' => count($currentImages),
                        'message' => 'Gambar gallery berhasil dihapus'
                    ]);
                }
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    // Reset gallery image to default (keep the slot) via AJAX
    public function removeGalleryImage($index)
    {
        try {
            $sarpras = Sarpras::first();
            
            if ($sarpras) {
                $currentImages = $sarpras->gallery_images ?? [];
                
                if (isset($currentImages[$index])) {
                    // Hapus gambar dari storage jika bukan default
                    $imagePath = $currentImages[$index];
                    if (strpos($imagePath, 'storage/') === 0) {
                        $storagePath = str_replace('storage/', 'public/', $imagePath);
                        Storage::delete($storagePath);
                    }
                    
                    // Reset ke gambar default
                    $currentImages[$index] = 'assets/img/sarpras.png';
                    
                    $sarpras->gallery_images = $currentImages;
                    $sarpras->save();
                    
                    return response()->json([
                        'success' => true,
                        'message' => 'Gambar gallery berhasil direset ke default'
                    ]);
                }
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
}
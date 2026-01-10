<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\VisiMisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class VisiMisiBackendController extends Controller
{
    /**
     * Display the visi-misi index form.
     */
    public function index()
    {
        $visiMisi = VisiMisi::first();
        
        if (!$visiMisi) {
            $visiMisi = VisiMisi::createDefault();
        }
        
        return view('backend.visi-misi.index', compact('visiMisi'));
    }
    
    /**
     * Store or update visi-misi data.
     */
    public function store(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'hero_title' => 'nullable|string|max:100',
            'hero_background' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'opening_paragraph' => 'required|string',
            
            // Cards
            'card1_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'card1_label' => 'required|string|max:50',
            'card2_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'card2_label' => 'required|string|max:50',
            'card3_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'card3_label' => 'required|string|max:50',
            
            // Visi
            'visi_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'visi_title' => 'required|string|max:100',
            'visi_description' => 'required|string',
            'visi_items' => 'nullable|array',
            'visi_items.*' => 'string|max:500',
            
            // Misi
            'misi_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'misi_title' => 'required|string|max:100',
            'misi_description' => 'required|string',
            'misi_items' => 'nullable|array',
            'misi_items.*' => 'string|max:500',
        ]);
        
        if ($validator->fails()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }
            
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        try {
            // Get or create visi-misi record
            $visiMisi = VisiMisi::first();
            
            if (!$visiMisi) {
                $visiMisi = new VisiMisi();
            }
            
            // Handle file uploads for hero background
            if ($request->hasFile('hero_background')) {
                // Delete old image if exists
                if ($visiMisi->hero_background && Storage::disk('public')->exists($visiMisi->hero_background)) {
                    Storage::disk('public')->delete($visiMisi->hero_background);
                }
                
                $path = $request->file('hero_background')->store('visi-misi/hero', 'public');
                $visiMisi->hero_background = $path;
            }
            
            // Handle file uploads for cards
            for ($i = 1; $i <= 3; $i++) {
                $field = "card{$i}_image";
                
                if ($request->hasFile($field)) {
                    // Delete old image if exists
                    if ($visiMisi->$field && Storage::disk('public')->exists($visiMisi->$field)) {
                        Storage::disk('public')->delete($visiMisi->$field);
                    }
                    
                    $path = $request->file($field)->store("visi-misi/cards", 'public');
                    $visiMisi->$field = $path;
                }
                
                // Update card label
                $labelField = "card{$i}_label";
                if ($request->has($labelField)) {
                    $visiMisi->$labelField = $request->$labelField;
                }
            }
            
            // Handle visi image upload
            if ($request->hasFile('visi_image')) {
                // Delete old image if exists
                if ($visiMisi->visi_image && Storage::disk('public')->exists($visiMisi->visi_image)) {
                    Storage::disk('public')->delete($visiMisi->visi_image);
                }
                
                $path = $request->file('visi_image')->store('visi-misi/visi', 'public');
                $visiMisi->visi_image = $path;
            }
            
            // Handle misi image upload
            if ($request->hasFile('misi_image')) {
                // Delete old image if exists
                if ($visiMisi->misi_image && Storage::disk('public')->exists($visiMisi->misi_image)) {
                    Storage::disk('public')->delete($visiMisi->misi_image);
                }
                
                $path = $request->file('misi_image')->store('visi-misi/misi', 'public');
                $visiMisi->misi_image = $path;
            }
            
            // Update text fields
            $visiMisi->hero_title = $request->hero_title ?? 'Visi & Misi';
            $visiMisi->opening_paragraph = $request->opening_paragraph;
            
            // Update visi
            $visiMisi->visi_title = $request->visi_title;
            $visiMisi->visi_description = $request->visi_description;
            $visiMisi->visi_items = $request->visi_items ? json_encode(array_values($request->visi_items)) : null;
            
            // Update misi
            $visiMisi->misi_title = $request->misi_title;
            $visiMisi->misi_description = $request->misi_description;
            $visiMisi->misi_items = $request->misi_items ? json_encode(array_values($request->misi_items)) : null;
            
            // Save
            $visiMisi->save();
            
            $successMessage = 'Visi & Misi berhasil diperbarui!';
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $successMessage,
                    'data' => $visiMisi
                ]);
            }
            
            return redirect()->route('backend.visi-misi.index')
                ->with('success', $successMessage);
                
        } catch (\Exception $e) {
            $errorMessage = 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage();
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage,
                    'error' => $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()
                ->with('error', $errorMessage)
                ->withInput();
        }
    }
    
    /**
     * Update visi-misi data (alternative to store).
     */
    public function update(Request $request)
    {
        return $this->store($request);
    }
    
    /**
     * Remove card image
     */
    public function removeCardImage(Request $request, $cardNumber)
    {
        try {
            $visiMisi = VisiMisi::firstOrFail();
            $field = "card{$cardNumber}_image";
            
            if (!in_array($cardNumber, [1, 2, 3])) {
                throw new \Exception('Nomor kartu tidak valid');
            }
            
            if ($visiMisi->$field && Storage::disk('public')->exists($visiMisi->$field)) {
                Storage::disk('public')->delete($visiMisi->$field);
                $visiMisi->$field = null;
                $visiMisi->save();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Gambar kartu berhasil dihapus'
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Gambar tidak ditemukan'
            ], 404);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus gambar: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Remove visi image
     */
    public function removeVisiImage(Request $request)
    {
        try {
            $visiMisi = VisiMisi::firstOrFail();
            
            if ($visiMisi->visi_image && Storage::disk('public')->exists($visiMisi->visi_image)) {
                Storage::disk('public')->delete($visiMisi->visi_image);
                $visiMisi->visi_image = null;
                $visiMisi->save();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Gambar visi berhasil dihapus'
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Gambar tidak ditemukan'
            ], 404);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus gambar: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Remove misi image
     */
    public function removeMisiImage(Request $request)
    {
        try {
            $visiMisi = VisiMisi::firstOrFail();
            
            if ($visiMisi->misi_image && Storage::disk('public')->exists($visiMisi->misi_image)) {
                Storage::disk('public')->delete($visiMisi->misi_image);
                $visiMisi->misi_image = null;
                $visiMisi->save();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Gambar misi berhasil dihapus'
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Gambar tidak ditemukan'
            ], 404);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus gambar: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Remove hero background
     */
    public function removeHeroBackground(Request $request)
    {
        try {
            $visiMisi = VisiMisi::firstOrFail();
            
            if ($visiMisi->hero_background && Storage::disk('public')->exists($visiMisi->hero_background)) {
                Storage::disk('public')->delete($visiMisi->hero_background);
                $visiMisi->hero_background = null;
                $visiMisi->save();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Background hero berhasil dihapus'
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Gambar tidak ditemukan'
            ], 404);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus background: ' . $e->getMessage()
            ], 500);
        }
    }
}
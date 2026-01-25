<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Kontak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class KontakBackendController extends Controller
{
    /**
     * Display the kontak index form.
     */
    public function index()
    {
        $kontak = Kontak::getData();
        
        return view('backend.kontak.index', compact('kontak'));
    }
    
    /**
     * Store or update kontak data.
     */
    public function store(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'hero_title' => 'required|string|max:100',
            'hero_background' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            
            // Opening paragraph
            'opening_paragraph' => 'required|string',
            
            // Contact information
            'address' => 'required|string',
            'phone' => 'required|string|max:50',
            'email' => 'required|email|max:100',
            'map_embed_url' => 'required|string',
            
            // Staff 1
            'staff1_name' => 'required|string|max:100',
            'staff1_position' => 'required|string|max:100',
            'staff1_phone' => 'required|string|max:50',
            'staff1_email' => 'required|email|max:100',
            'staff1_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            
            // Staff 2
            'staff2_name' => 'required|string|max:100',
            'staff2_position' => 'required|string|max:100',
            'staff2_phone' => 'required|string|max:50',
            'staff2_email' => 'required|email|max:100',
            'staff2_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            
            // Social media
            'facebook_url' => 'nullable|url|max:200',
            'instagram_url' => 'nullable|url|max:200',
            'youtube_url' => 'nullable|url|max:200',
            
            // Contact image
            'contact_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'hero_title.required' => 'Judul hero wajib diisi.',
            'hero_background.image' => 'Background hero harus berupa gambar.',
            'hero_background.mimes' => 'Background hero harus berformat: jpeg, png, jpg, atau gif.',
            'hero_background.max' => 'Background hero maksimal 5MB.',
            
            'opening_paragraph.required' => 'Paragraf pembuka wajib diisi.',
            
            'address.required' => 'Alamat wajib diisi.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'map_embed_url.required' => 'URL embed Google Maps wajib diisi.',
            
            'staff1_name.required' => 'Nama staff 1 wajib diisi.',
            'staff1_position.required' => 'Jabatan staff 1 wajib diisi.',
            'staff1_phone.required' => 'Telepon staff 1 wajib diisi.',
            'staff1_email.required' => 'Email staff 1 wajib diisi.',
            'staff1_image.image' => 'Foto staff 1 harus berupa gambar.',
            'staff1_image.mimes' => 'Foto staff 1 harus berformat: jpeg, png, jpg, atau gif.',
            'staff1_image.max' => 'Foto staff 1 maksimal 2MB.',
            
            'staff2_name.required' => 'Nama staff 2 wajib diisi.',
            'staff2_position.required' => 'Jabatan staff 2 wajib diisi.',
            'staff2_phone.required' => 'Telepon staff 2 wajib diisi.',
            'staff2_email.required' => 'Email staff 2 wajib diisi.',
            'staff2_image.image' => 'Foto staff 2 harus berupa gambar.',
            'staff2_image.mimes' => 'Foto staff 2 harus berformat: jpeg, png, jpg, atau gif.',
            'staff2_image.max' => 'Foto staff 2 maksimal 2MB.',
            
            'facebook_url.url' => 'URL Facebook tidak valid.',
            'instagram_url.url' => 'URL Instagram tidak valid.',
            'youtube_url.url' => 'URL YouTube tidak valid.',
            
            'contact_image.image' => 'Gambar kontak harus berupa gambar.',
            'contact_image.mimes' => 'Gambar kontak harus berformat: jpeg, png, jpg, atau gif.',
            'contact_image.max' => 'Gambar kontak maksimal 2MB.',
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
                ->withInput()
                ->with('error', 'Validasi gagal! Silakan periksa kembali data yang diinput.');
        }
        
        try {
            // Get or create kontak record
            $kontak = Kontak::first();
            
            if (!$kontak) {
                $kontak = new Kontak();
            }
            
            // Handle file uploads for hero background
            if ($request->hasFile('hero_background')) {
                // Delete old image if exists
                if ($kontak->hero_background && Storage::disk('public')->exists($kontak->hero_background)) {
                    Storage::disk('public')->delete($kontak->hero_background);
                }
                
                $path = $request->file('hero_background')->store('kontak/hero', 'public');
                $kontak->hero_background = $path;
            }
            
            // Handle file upload for contact image
            if ($request->hasFile('contact_image')) {
                // Delete old image if exists
                if ($kontak->contact_image && Storage::disk('public')->exists($kontak->contact_image)) {
                    Storage::disk('public')->delete($kontak->contact_image);
                }
                
                $path = $request->file('contact_image')->store('kontak', 'public');
                $kontak->contact_image = $path;
            }
            
            // Handle file upload for staff 1 image
            if ($request->hasFile('staff1_image')) {
                // Delete old image if exists
                if ($kontak->staff1_image && Storage::disk('public')->exists($kontak->staff1_image)) {
                    Storage::disk('public')->delete($kontak->staff1_image);
                }
                
                $path = $request->file('staff1_image')->store('kontak/staff', 'public');
                $kontak->staff1_image = $path;
            }
            
            // Handle file upload for staff 2 image
            if ($request->hasFile('staff2_image')) {
                // Delete old image if exists
                if ($kontak->staff2_image && Storage::disk('public')->exists($kontak->staff2_image)) {
                    Storage::disk('public')->delete($kontak->staff2_image);
                }
                
                $path = $request->file('staff2_image')->store('kontak/staff', 'public');
                $kontak->staff2_image = $path;
            }
            
            // Update text fields
            $kontak->hero_title = $request->hero_title;
            $kontak->opening_paragraph = $request->opening_paragraph;
            
            // Update contact information
            $kontak->address = $request->address;
            $kontak->phone = $request->phone;
            $kontak->email = $request->email;
            $kontak->map_embed_url = $request->map_embed_url;
            
            // Update staff 1
            $kontak->staff1_name = $request->staff1_name;
            $kontak->staff1_position = $request->staff1_position;
            $kontak->staff1_phone = $request->staff1_phone;
            $kontak->staff1_email = $request->staff1_email;
            
            // Update staff 2
            $kontak->staff2_name = $request->staff2_name;
            $kontak->staff2_position = $request->staff2_position;
            $kontak->staff2_phone = $request->staff2_phone;
            $kontak->staff2_email = $request->staff2_email;
            
            // Update social media
            $kontak->facebook_url = $request->facebook_url;
            $kontak->instagram_url = $request->instagram_url;
            $kontak->youtube_url = $request->youtube_url;
            
            // Save
            $kontak->save();
            
            $successMessage = 'Data kontak berhasil disimpan!';
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $successMessage,
                    'data' => $kontak
                ]);
            }
            
            return redirect()->route('backend.kontak.index')
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
     * Update kontak data (alternative to store).
     */
    public function update(Request $request)
    {
        return $this->store($request);
    }
    
    /**
     * Remove hero background
     */
    public function removeHeroBackground(Request $request)
    {
        try {
            $kontak = Kontak::first();
            
            if (!$kontak) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data kontak tidak ditemukan'
                ], 404);
            }
            
            if ($kontak->hero_background && Storage::disk('public')->exists($kontak->hero_background)) {
                Storage::disk('public')->delete($kontak->hero_background);
                $kontak->hero_background = null;
                $kontak->save();
                
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
    
    /**
     * Remove contact image
     */
    public function removeContactImage(Request $request)
    {
        try {
            $kontak = Kontak::first();
            
            if (!$kontak) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data kontak tidak ditemukan'
                ], 404);
            }
            
            if ($kontak->contact_image && Storage::disk('public')->exists($kontak->contact_image)) {
                Storage::disk('public')->delete($kontak->contact_image);
                $kontak->contact_image = null;
                $kontak->save();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Gambar kontak berhasil dihapus'
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
     * Remove staff image
     */
    public function removeStaffImage(Request $request, $staffNumber)
    {
        try {
            $kontak = Kontak::first();
            
            if (!$kontak) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data kontak tidak ditemukan'
                ], 404);
            }
            
            if (!in_array($staffNumber, [1, 2])) {
                throw new \Exception('Nomor staff tidak valid');
            }
            
            $field = "staff{$staffNumber}_image";
            
            if ($kontak->$field && Storage::disk('public')->exists($kontak->$field)) {
                Storage::disk('public')->delete($kontak->$field);
                $kontak->$field = null;
                $kontak->save();
                
                return response()->json([
                    'success' => true,
                    'message' => "Gambar staff {$staffNumber} berhasil dihapus"
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
}
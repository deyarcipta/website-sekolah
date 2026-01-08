<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function tinymceUpload(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            
            // Generate nama file unik
            $fileName = 'tinymce_' . time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            
            // Simpan di folder public/uploads/tinymce
            $path = 'uploads/tinymce';
            $filePath = $file->storeAs($path, $fileName, 'public');
            
            // Return URL untuk TinyMCE
            $url = Storage::url($filePath);
            
            return response()->json([
                'location' => asset($url)
            ]);
        }
        
        return response()->json(['error' => 'Upload failed'], 400);
    }
}
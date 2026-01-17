<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Major;
use Illuminate\Http\Request;

class MajorController extends Controller
{
    public function show($slug)
    {
        $major = Major::with(['teachers', 'achievements'])
                     ->where('slug', $slug)
                     ->where('is_active', true)
                     ->firstOrFail();
        
        // Untuk SEO
        $metaTitle = $major->meta_title ?? $major->name . ' - SMK Wisata Indonesia Jakarta';
        $metaDescription = $major->meta_description ?? strip_tags($major->description);
        
        return view('frontend.majors', compact('major', 'metaTitle', 'metaDescription'));
    }
    
    public function index()
    {
        $majors = Major::where('is_active', true)
                      ->orderBy('order')
                      ->get();
        
        return view('frontend.majors', compact('majors'));
    }
}
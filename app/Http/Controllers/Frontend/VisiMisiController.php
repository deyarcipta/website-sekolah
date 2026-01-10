<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\VisiMisi;
use Illuminate\Http\Request;

class VisiMisiController extends Controller
{
    /**
     * Display the visi-misi page.
     */
    public function index()
    {
        // Ambil data dari model VisiMisi
        $visiMisi = VisiMisi::first();
        
        // Jika tidak ada data, buat data default
        if (!$visiMisi) {
            $visiMisi = VisiMisi::createDefault();
        }
        
        // Decode JSON untuk items jika perlu
        if (!is_array($visiMisi->visi_items)) {
            $visiMisi->visi_items = json_decode($visiMisi->visi_items, true) ?? [];
        }
        
        if (!is_array($visiMisi->misi_items)) {
            $visiMisi->misi_items = json_decode($visiMisi->misi_items, true) ?? [];
        }
        
        return view('frontend.visi-misi', compact('visiMisi'));
    }
}
<?php
// app/Http/Controllers/Frontend/GuruStaffController.php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\GuruStaff;
use App\Models\GuruStaffDeskripsi;

class GuruStaffController extends Controller
{
    public function index()
    {
        // Ambil data dengan urutan
        $kepalaSekolah = GuruStaff::where('tipe', 'kepala_sekolah')
            ->where('is_active', true)
            ->orderBy('urutan')
            ->get();
            
        $wakilKepala = GuruStaff::where('tipe', 'wakil_kepala_sekolah')
            ->where('is_active', true)
            ->orderBy('urutan')
            ->get();
            
        $kepalaJurusan = GuruStaff::where('tipe', 'kepala_jurusan')
            ->where('is_active', true)
            ->orderBy('urutan')
            ->get();
            
        $guru = GuruStaff::where('tipe', 'guru')
            ->where('is_active', true)
            ->orderBy('urutan')
            ->get();
            
        $staff = GuruStaff::where('tipe', 'staff')
            ->where('is_active', true)
            ->orderBy('urutan')
            ->get();
        
        $description = GuruStaffDeskripsi::getDeskripsi();

        return view('frontend.gurustaff', compact(
            'kepalaSekolah',
            'wakilKepala',
            'kepalaJurusan',
            'guru',
            'staff',
            'description'
        ));
    }
}
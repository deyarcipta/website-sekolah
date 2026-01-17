<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\SettingHelper;
use App\Models\KeunggulanSekolah;
use App\Models\Major;

class HomeController extends Controller
{
    public function index()
    {
        $keunggulan = KeunggulanSekolah::where('is_active', true)
            ->orderBy('urutan')
            ->get();

        // Ambil data jurusan yang aktif dan diurutkan
        $majors = Major::where('is_active', true)
            ->orderBy('order')
            ->get();

        return view('frontend.home', compact('keunggulan', 'majors'));
    }
}
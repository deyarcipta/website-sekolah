<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\SettingHelper;
use App\Models\KeunggulanSekolah;

class HomeController extends Controller
{
    public function index()
    {
        $keunggulan = KeunggulanSekolah::where('is_active', true)
        ->orderBy('urutan')
        ->get();

        return view('frontend.home', compact('keunggulan'));
    }
}
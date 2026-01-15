<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sarpras;

class SarprasController extends Controller
{
    public function index()
    {
        $sarpras = Sarpras::first();

        return view('frontend.sarpras', compact('sarpras'));
    }
}

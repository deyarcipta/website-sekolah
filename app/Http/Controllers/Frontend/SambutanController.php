<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SambutanKepsek;

class SambutanController extends Controller
{
    public function index()
    {
        $sambutan = SambutanKepsek::first();
        return view('frontend.sambutan', compact('sambutan'));
    }
}

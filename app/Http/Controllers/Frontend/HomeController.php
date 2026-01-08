<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\SettingHelper;

class HomeController extends Controller
{
    public function index()
    {
        
        return view('frontend.home');
    }
}
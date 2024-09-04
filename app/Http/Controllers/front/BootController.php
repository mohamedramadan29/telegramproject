<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\admin\Boot;
use Illuminate\Http\Request;

class BootController extends Controller
{
    public function index()
    {
        $boots = Boot::all();
        return view('front.Boots.index', compact('boots'));
    }
}

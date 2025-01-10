<?php

namespace App\Http\Controllers;

use App\Models\Skpd;
use Illuminate\Http\Request;

class SkpdController extends Controller
{
    public function index()
    {
        $skpd = Skpd::get();
        return view('superadmin.skpd.index', compact('skpd'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class KeuanganController extends Controller
{
    public function index():View
    {
        return view('keuangan.index');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class PenjualanController extends Controller
{
    public function index():View
    {
        return view('penjualan.index');
    }

    public function handphone(): View
    {
        return view('penjualan.handphone.index');
    }
}

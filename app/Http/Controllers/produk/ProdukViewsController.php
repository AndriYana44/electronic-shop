<?php

namespace App\Http\Controllers\produk;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProdukViewsController extends Controller
{
    public function index(): View
    {
        return view('produk.index');
    }

    public function pulsa(): View
    {
        return view('produk.pulsa.index');
    }

    public function aksesoris(): View
    {
        return view('produk.aksesoris.index');
    }

    public function servis(): View
    {
        return view('produk.servis.index');
    }
}

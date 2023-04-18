<?php

namespace App\Http\Controllers\produk;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProdukHandphoneController extends Controller
{
    public function index(): View
    {
        return view('produk.handphone.index');
    }

    public function store(request $request)
    {
        $input = $request->all();
        dd($input);
    }
}

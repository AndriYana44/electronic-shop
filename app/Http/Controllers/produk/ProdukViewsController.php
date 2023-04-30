<?php

namespace App\Http\Controllers\produk;

use App\Http\Controllers\Controller;
use App\Models\produk\Cart;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProdukViewsController extends Controller
{
    public function index(): View
    {
        return view('produk.index');
    }

    public function cart(Request $request)
    {
        $cart = new Cart();
        $cart->name = $request->name;
        $cart->price = $request->total;
        $cart->kategori_items = $request->kategori;
        $cart->jumlah = $request->jml;
        $cart->save();

        return back()->with('success', 'Di tambahkan ke cart!');
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

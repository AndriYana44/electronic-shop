<?php

namespace App\Http\Controllers\produk;

use App\Http\Controllers\Controller;
use App\Models\produk\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProdukViewsController extends Controller
{
    public function index(): View
    {
        return view('produk.index');
    }

    public function cart(Request $request)
    {
        $checkDataIfExist = DB::table('item_cart')
            ->select(DB::raw('count(id) as jml'))
            ->where([
                'name' => $request->name,
                'kategori_item' => $request->kategori
            ])->get();
        
        if($checkDataIfExist->first()->jml > 0) {
            $cart = Cart::where('id_kategori_item', $request->id_varian);
            $dataCart = $cart->get();
            $cart->update([
                'jumlah' => $dataCart->first()->jumlah + $request->jml,
            ]);
        }else{
            $cart = new Cart();
            $cart->id_kategori_item = $request->id_varian;
            $cart->name = $request->name;
            $cart->price = $request->harga;
            $cart->kategori_item = $request->kategori;
            $cart->jumlah = $request->jml;
            $cart->save();
        }

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

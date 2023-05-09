<?php

namespace App\Http\Controllers;

use App\Models\produk\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $data = DB::table('item_cart as c')
        ->select('c.id' ,'c.id_kategori_item', 'c.name', 'c.kategori_item', 'c.price', 'v.varian', 'h.picture',
            DB::raw('sum(jumlah) as jumlah, sum(c.price*jumlah) as total'))
        ->leftJoin('item_handphone_varian as v', 'v.id', '=', 'c.id_kategori_item')
        ->leftJoin('item_handphone as h', 'h.id', '=', 'v.handphone_id')
        ->groupBy('c.id', 'c.id_kategori_item', 'c.name', 'c.kategori_item', 'c.price', 'v.varian', 'h.picture')
        ->get();

        return view('cart.index', [
            'data' => $data,
        ]);
    }

    public function changeDataCart(Request $request, $id)
    {
        $cart = Cart::find($id);
        $cart->update([
            'jumlah' => $request->jml,
        ]);
        $data = Cart::all();

        return $data->toJson();
    }

    public function deleteDataCart($id) 
    {
        $delete = Cart::find($id)->delete();
        $data = Cart::all();
        return $data->toJson();
    }
}

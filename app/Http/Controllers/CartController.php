<?php

namespace App\Http\Controllers;

use App\Models\produk\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function changeDataCart(Request $request)
    {
        $cart = Cart::where('id_kategori_item', $request->id);
        $cart->update([
            'jumlah' => $request->jml,
        ]);
        $data = $cart->get();

        return $data->toJson();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\produk\Cart;
use App\Models\produk\handphone\HandphoneSold;
use App\Models\produk\handphone\HandphoneVarian;
use App\Models\produk\ProdukHandphone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $data = DB::table('item_cart as c')
        ->select(DB::raw('
            c.id, c.id_kategori_item, h.id as handphone_id, v.id as varian_id,
            c.name, c.kategori_item, c.price, v.varian, h.picture,
            sum(jumlah) as jumlah, sum(c.price*jumlah) as total'))
        ->leftJoin('item_handphone_varian as v', 'v.id', '=', 'c.id_kategori_item')
        ->leftJoin('item_handphone as h', 'h.id', '=', 'v.handphone_id')
        ->groupBy(DB::raw('1,2,3,4,5,6,7,8,9'))
        ->get();

        return view('cart.index', [
            'data' => $data,
        ]);
    }

    public function insert(Request $request)
    {
        $checkDataIfExist = DB::table('item_cart')
            ->select(DB::raw('count(id) as jml'))
            ->where([
                'id_kategori_item' => $request->id_varian
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

    public function checkout(Request $request)
    {
        for($i=0; $i<count($request->id); $i++) {
            if(strtolower($request->kategori[$i]) == 'handphone') {
                // insert data ke table item_handphone_sold
                HandphoneSold::insert([
                    'handphone_id' => $request->handphone_id[$i],
                    'handphone_varian_id' => $request->varian_id[$i],
                    'sold_at_price' => $request->price[$i],
                    'jumlah' => $request->jml[$i]
                ]);
                
                // mencari data untuk update stok pada field available_items
                $data = HandphoneVarian::where('id', $request->varian_id[$i]);
                $dataItems = $data->get();
                $availableItems = $dataItems->first()->available_items;
                $data->update(['available_items' => $availableItems-$request->jml[$i]]);
                
                // menghapus data pada cart
                Cart::find($request->id[$i])->delete();
            }elseif(strtolower($request->kategori[$i]) == 'aksesoris') {
                dd('fitur belum tersedia');
            }
        }

        return back()->with(['success' => 'Item berhasil di checkout!']);
    }
}

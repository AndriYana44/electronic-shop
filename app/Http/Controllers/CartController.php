<?php

namespace App\Http\Controllers;

use App\Models\produk\aksesoris\AksesorisSold;
use App\Models\produk\aksesoris\AksesorisVarian;
use App\Models\produk\Cart;
use App\Models\produk\handphone\HandphoneSold;
use App\Models\produk\handphone\HandphoneVarian;
use App\Models\produk\ProdukHandphone;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $data = new Collection();
        foreach( DB::select('
            select c.id
                , c.id_kategori_item
                , h.id as handphone_id
                , v.id as handphone_varian_id
                , aks.id as aksesoris_id
                , aks_v.id as aksesoris_varian_id
                , c.name
                , c.kategori_item
                , c.price
                , v.varian
                , h.picture
                , aks_v.varian as varian_aksesoris
                , aks.picture as aksesoris_picture
                , sum(jumlah) as jumlah
                , sum(c.price*jumlah) as total
            from item_cart as c
            left join item_handphone_varian as v
            on v.id = c.id_kategori_item and c.kategori_item = "handphone"
            left join item_handphone as h
            on h.id = v.handphone_id
            left join item_aksesoris_varian as aks_v
            on aks_v.id = c.id_kategori_item and c.kategori_item = "aksesoris"
            left join item_aksesoris as aks
            on aks.id = aks_v.aksesoris_id
            group by 1,2,3,4,5,6,7,8,9,10,11,12,13
        ') as $d) { $data->push($d); }

        return view('cart.index', [
            'data' => $data,
        ]);
    }

    public function insert(Request $request)
    {
        $checkDataIfExist = DB::table('item_cart')
        ->select(DB::raw('count(id) as jml'))
        ->where([
            'id_kategori_item' => $request->id_varian,
            'kategori_item' => $request->kategori
        ])->get();
            
        if($checkDataIfExist->first()->jml > 0) {
            if(strtolower($request->kategori) == 'handphone') {
                $checkStokItems = HandphoneVarian::where('id', $request->id_varian)->get();
            }else if(strtolower($request->kategori) == 'aksesoris') {
                $checkStokItems = AksesorisVarian::where('id', $request->id_varian)->get();
            }

            
            $cart = Cart::where('id_kategori_item', $request->id_varian);
            $dataCart = $cart->get();
            $jml = $dataCart->first()->jumlah + $request->jml;
            $max_item = $checkStokItems->first()->available_items;
            if($jml > $max_item) {
                $jml = $max_item;
            }
            $cart->update([
                'jumlah' => $jml,
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
                    'handphone_id' => $request->produk_id[$i],
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
                // insert data ke table item_handphone_sold
                AksesorisSold::insert([
                    'aksesoris_id' => $request->produk_id[$i],
                    'aksesoris_varian_id' => $request->varian_id[$i],
                    'sold_at_price' => $request->price[$i],
                    'jumlah' => $request->jml[$i]
                ]);
                
                // mencari data untuk update stok pada field available_items
                $data = AksesorisVarian::where('id', $request->varian_id[$i]);
                $dataItems = $data->get();
                $availableItems = $dataItems->first()->available_items;
                $data->update(['available_items' => $availableItems-$request->jml[$i]]);
                
                // menghapus data pada cart
                Cart::find($request->id[$i])->delete();
            }
        }

        return back()->with(['success' => 'Item berhasil di checkout!']);
    }
}

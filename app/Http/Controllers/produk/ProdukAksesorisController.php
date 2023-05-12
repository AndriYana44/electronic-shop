<?php

namespace App\Http\Controllers\produk;

use App\Http\Controllers\Controller;
use App\Models\produk\aksesoris\Aksesoris;
use App\Models\produk\aksesoris\AksesorisVarian;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class ProdukAksesorisController extends Controller
{
    public function index(Request $request)
    {
        $item_detail = Aksesoris::with('varian')->get();
        $cart = new Collection();
        foreach(DB::select('
            select c.id_kategori_item
                , c.name
                , c.kategori_item
                , c.price
                , coalesce(hv.varian, av.varian) as varian
                , sum(jumlah) as jumlah
                , sum(c.price*jumlah) as total
            from item_cart as c
            left join item_handphone_varian as hv on hv.id = c.id_kategori_item
                and c.kategori_item = "handphone"
            left join item_aksesoris_varian as av on av.id = c.id_kategori_item
                and c.kategori_item = "aksesoris"
            group by 1,2,3,4,5
        ') as $d) { $cart->push($d); }

        $filtered = null;
        if($request->itemFiltered != null) {
            $filtered = $request->itemFiltered;
            $item_filtered = Aksesoris::with('varian')->where('name', $filtered)->get();
        }

        return view('produk.aksesoris.index', [
            'item_list' => $item_detail,
            'item_display' => $filtered == null || $filtered == 'All items' ? $item_detail : $item_filtered,
            'item_filtered' => $filtered,
            'item_detail' => $item_detail,
            'cart' => $cart
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'picture' => 'required|image:jpeg,png,jpg|max:2048'
        ]);
        $imageName = time().'.'.$request->picture->extension();
        $request->picture->move(public_path('picture/aksesoris'), $imageName);

        $dataItem = new Aksesoris();
        $dataItem->kategori = $request->kategori;
        $dataItem->name = $request->nama;
        $dataItem->keterangan = $request->keterangan;
        $dataItem->picture = $imageName;
        $dataItem->save();

        foreach($request->varian as $key => $varian) {
            $harga = explode(',', $request->harga[$key]);
            $harga = implode('', $harga);

            AksesorisVarian::insert([
                'aksesoris_id' => $dataItem->id,
                'varian' => $varian,
                'price' => $harga,
                'available_items' => $request->stok[$key]
            ]);
        }

        return redirect('/produk/aksesoris');
    }

    public function delete($id)
    {
        $item = Aksesoris::find($id);
        if(file_exists(public_path("picture/aksesoris/" . $item->picture))) {
            unlink(public_path('picture/aksesoris/' . $item->picture));
        }
        $item->delete();

        return Redirect::back()->with(
            'success', 'Item berhasil di hapus!'
        );
    }
}

<?php

namespace App\Http\Controllers\produk;

use App\Http\Controllers\Controller;
use App\Models\produk\handphone\HandphoneSold;
use App\Models\produk\Cart;
use App\Models\produk\handphone\HandphoneVarian;
use App\Models\produk\ProdukHandphone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProdukHandphoneController extends Controller
{
    public function index(request $request): View
    {
        $item_detail = ProdukHandphone::with('varian')->get();
        $cart = DB::table('item_cart as c')
            ->select('c.id_kategori_item', 'c.name', 'c.kategori_item', 'c.price', 'v.varian',
                DB::raw('sum(jumlah) as jumlah, sum(c.price*jumlah) as total'))
            ->leftJoin('item_handphone_varian as v', 'v.id', '=', 'c.id_kategori_item')
            ->groupBy('c.id_kategori_item', 'c.name', 'c.kategori_item', 'c.price', 'v.varian')
            ->get();

        $filtered = null;
        if($request->itemFiltered != null) {
            $filtered = $request->itemFiltered;
            $item_filtered = ProdukHandphone::with('varian')->where('name', $filtered)->get();
        }
        return view('produk.handphone.index', [
            'item_list' => $item_detail,
            'item_display' => $filtered == null || $filtered == 'All items' ? $item_detail : $item_filtered,
            'item_filtered' => $filtered,
            'item_detail' => $item_detail,
            'cart' => $cart
        ]);
    }

    public function store(request $request)
    {
        $request->validate([
            'picture' => 'required|image:jpeg,png,jpg|max:2048'
        ]);
        $imageName = time().'.'.$request->picture->extension();
        $request->picture->move(public_path('picture/handphone'), $imageName);

        $dataItem = new ProdukHandphone();
        $dataItem->name = $request->nama;
        $dataItem->spesification = $request->spesifikasi;
        $dataItem->picture = $imageName;
        $dataItem->save();

        foreach($request->varian as $key => $varian) {
            $harga = explode(',', $request->harga[$key]);
            $harga = implode('', $harga);

            DB::table('item_handphone_varian')->insert([
                'handphone_id' => $dataItem->id,
                'varian' => $varian,
                'price' => $harga,
                'available_items' => $request->stok[$key]
            ]);
        }

        return redirect('/produk/handphone');
    }

    public function checkout(Request $request, $id)
    {
        // insert data ke table item_handphone_sold
        HandphoneSold::insert([
            'handphone_id' => $request->id_handphone,
            'handphone_varian_id' => $request->id_varian,
            'sold_at_price' => $request->harga,
            'jumlah' => $request->jml
        ]);
        
        // mencari data untuk update stok pada field available_items
        $data = HandphoneVarian::where('id', $request->id_varian);
        $dataItems = $data->get();
        $availableItems = $dataItems->first()->available_items;
        $data->update(['available_items' => $availableItems-$request->jml]);

        return back()->with(['success' => 'Berhasil checkout!']);
    }

    public function update(Request $request, $id)
    {
        $item = ProdukHandphone::find($id);
        // dd($item->picture);
        if($request->picture != null) {
            $request->validate([
                'picture' => 'required|image:jpeg,png,jpg|max:2048'
            ]);

            // delete foto sebelumnya
            unlink(public_path('picture/handphone/' . $item->picture));
            // simpan foto baru
            $imageName = time().'.'.$request->picture->extension();
            $request->picture->move(public_path('picture/handphone'), $imageName);
        }

        $harga = explode(',', $request->harga);
        $harga = implode('', $harga);
        
        $item->update([
            'name' => $request->nama,
            'price' => $harga,
            'spesification' => $request->spesifikasi,
            'picture' => empty($imageName) ? $item->picture : $imageName
        ]);

        return back()->with('success', 'Item berhasil di edit!');
    }

    public function delete($id)
    {
        $item = ProdukHandphone::find($id);
        if(file_exists(public_path("picture/handphone/" . $item->picture))) {
            unlink(public_path('picture/handphone/' . $item->picture));
        }
        $item->delete();

        return Redirect::back()->with(
            'success', 'Item berhasil di hapus!'
        );
    }

    public function getDetailHandphone($id)
    {
        $data = ProdukHandphone::with('varian')->where('id', $id)->get();
        return $data->toJson();
    }

    public function getVarianHandphone($id)
    {
        $data = HandphoneVarian::with('handphone')->where('id', $id)->get();
        return $data->toJson();
    }
}

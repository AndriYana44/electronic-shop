<?php

namespace App\Http\Controllers\produk;

use App\Http\Controllers\Controller;
use App\Models\produk\Cart;
use App\Models\produk\ProdukHandphone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProdukHandphoneController extends Controller
{
    public function index(request $request): View
    {
        $item_list = DB::table('item_handphone')->get()->all();

        $cart = Cart::all();
        $filtered = null;
        if($request->itemFiltered != null) {
            $filtered = $request->itemFiltered;
            $item_filtered = DB::table('item_handphone')
                ->where('name', $filtered)
                ->get();
        }
        return view('produk.handphone.index', [
            'item_list' => $item_list,
            'item_display' => $filtered == null || $filtered == 'All items' ? $item_list : $item_filtered,
            'item_filtered' => $filtered,
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

        $harga = explode(',', $request->harga);
        $harga = implode('', $harga);

        DB::table('item_handphone')->insert([
            'name' => $request->nama,
            'price' => $harga,
            'spesification' => $request->spesifikasi,
            'picture' => $imageName,
            'available_items' => $request->stok
        ]);

        return redirect('/produk/handphone');
    }

    public function checkout(Request $request, $id)
    {
        dd($request->all());
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
            'available_items' => $request->stok,
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
}

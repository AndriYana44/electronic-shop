<?php

namespace App\Http\Controllers\produk;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProdukHandphoneController extends Controller
{
    public function index(): View
    {
        $item_list = DB::table('item_handphone')->get()->all();
        return view('produk.handphone.index', [
            'item_list' => $item_list
        ]);
    }

    public function store(request $request)
    {
        $request->validate([
            'picture' => 'required|image:jpeg,png,jpg|max:2048'
        ]);
        $imageName = time().'.'.$request->picture->extension();
        $request->picture->move(public_path('picture/handphone'), $imageName);

        DB::table('item_handphone')->insert([
            'name' => $request->nama,
            'price' => $request->harga,
            'spesification' => $request->spesifikasi,
            'picture' => $imageName,
            'available_items' => $request->stok
        ]);

        return redirect('/produk/handphone');
    }
}

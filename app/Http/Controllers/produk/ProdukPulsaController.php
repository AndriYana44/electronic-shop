<?php

namespace App\Http\Controllers\produk;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProdukPulsaController extends Controller
{
    public function index(Request $request): View
    {
        $item_list = DB::table('item_pulsa_saldo')     
            ->get()->all();
        $item_nominal = DB::table('item_pulsa_saldo')
            ->leftJoin('item_pulsa', 'item_pulsa.saldo_id', '=', 'item_pulsa_saldo.id')
            ->orderBy('price')
            ->get();
        $filtered = null;
        if($request->filter != null) {
            $filtered = DB::table('item_pulsa_saldo')
                ->select('*')
                ->where('operator', $request->filter)
                ->get();

        }
        return view('produk.pulsa.index', [
            'item_list' => $item_list,
            'item_dislay' => $request->filter == null || $request->filter == 'All Items' ? $item_list: $filtered,
            'item_filtered' => $request->filter,
            'item_nominal' => $item_nominal
        ]);
    }

    public function store(Request $request)
    {
        DB::table('item_pulsa')->insert([
            'saldo_id' => $request->operator,
            'nominal' => $request->nominal,
            'price' => $request->harga,
        ]);

        return redirect('/produk/pulsa');
    }

    public function store_saldo(Request $request)
    {
        $request->validate([
            'picture' => 'required|image:jpeg,png,jpg|max:2048'
        ]);
        $imageName = time().'.'.$request->picture->extension();
        $request->picture->move(public_path('picture/pulsa'), $imageName);

        DB::table('item_pulsa_saldo')->insert([
            'operator' => $request->operator,
            'saldo' => $request->saldo,
            'picture' => $imageName
        ]);

        return redirect('/produk/pulsa');
    }

    public function checkout(Request $request)
    {
        $pulsa_id = DB::table('item_pulsa')
            ->where('id', $request->id_items)
            ->get();
            
        $pulsa_saldo_id = DB::table('item_pulsa_saldo')
            ->where('id', $pulsa_id->first()->saldo_id)
            ->get();

        if($request->save_number != null) {
            DB::table('contact')->insert([
                'name' => $request->nama,
                'no_tlp' => $request->no_tlp
            ]);
        }

        DB::table('item_pulsa_sold')->insert([
            'pulsa_id' => $pulsa_id->first()->id,
            'pulsa_saldo_id' => $pulsa_saldo_id->first()->id,
            'sold_at_price' => $request->price,
            'no_hp' => $request->no_tlp
        ]);

        return redirect('/produk/pulsa');
    }
}

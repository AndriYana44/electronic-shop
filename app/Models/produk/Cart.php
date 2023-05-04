<?php

namespace App\Models\produk;

use App\Models\produk\handphone\HandphoneVarian;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'item_cart';
    protected $guarded = ['id'];

    public function itemHandphone()
    {
        return $this->hasMany(HandphoneVarian::class, 'id', 'id_kategori_item');
    }
}

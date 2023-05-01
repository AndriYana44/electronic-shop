<?php

namespace App\Models\produk;

use App\Models\produk\handphone\HandphoneVarian;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukHandphone extends Model
{
    use HasFactory;
    protected $table = 'item_handphone';
    protected $guarded = ['id'];

    public $timestamps = true;

    public function varian()
    {
        return $this->hasMany(HandphoneVarian::class, 'handphone_id', 'id')->orderBy('price');
    }
}

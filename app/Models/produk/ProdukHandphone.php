<?php

namespace App\Models\produk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukHandphone extends Model
{
    use HasFactory;
    protected $table = 'item_handphone';
    protected $guarded = ['id', 'sold_items', 'sold_at_price'];
}

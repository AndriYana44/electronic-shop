<?php

namespace App\Models\produk\handphone;

use App\Models\produk\ProdukHandphone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HandphoneVarian extends Model
{
    use HasFactory;
    protected $table = 'item_handphone_varian';
    protected $guarded = ['id'];

    public function handphone() 
    {
        return $this->belongsTo(ProdukHandphone::class, 'handphone_id', 'id');
    }
}

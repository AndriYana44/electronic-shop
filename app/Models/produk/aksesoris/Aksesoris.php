<?php

namespace App\Models\produk\aksesoris;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aksesoris extends Model
{
    use HasFactory;
    protected $table = 'item_aksesoris';
    protected $guarded = ['id'];

    public function varian()
    {
        return $this->hasMany(AksesorisVarian::class, 'aksesoris_id', 'id')->orderBy('price');
    }
}

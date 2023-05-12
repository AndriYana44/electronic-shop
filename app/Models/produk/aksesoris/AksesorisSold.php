<?php

namespace App\Models\produk\aksesoris;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AksesorisSold extends Model
{
    use HasFactory;
    protected $table = 'item_aksesoris_sold';
    protected $guarded = ['id'];
}

<?php

namespace App\Models\produk\handphone;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HandphoneSold extends Model
{
    use HasFactory;
    protected $table = 'item_handphone_sold';
    protected $guarded = ['id'];
    public $timestamps = true;
}

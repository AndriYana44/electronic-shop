<?php

namespace App\Models\produk\aksesoris;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AksesorisVarian extends Model
{
    use HasFactory;
    protected $table = 'item_aksesoris_varian';
    protected $guarded = ['id'];

    public function item()
    {
        return $this->BelongsTo(Aksesoris::class, 'aksesoris_id', 'id');
    }
}

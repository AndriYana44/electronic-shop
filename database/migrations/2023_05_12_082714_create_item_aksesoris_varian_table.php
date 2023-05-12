<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('item_aksesoris_varian', function (Blueprint $table) {
            $table->id();
            $table->integer('aksesoris_id');
            $table->string('varian');
            $table->string('price');
            $table->integer('available_items')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_aksesoris_varian');
    }
};

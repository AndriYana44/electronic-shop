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
        Schema::create('item_handphone', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('price');
            $table->text('spesification');
            $table->string('picture');
            $table->integer('available_items');
            $table->integer('sold_items')->nullable()->default(0);
            $table->string('sold_at_price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_handphone');
    }
};

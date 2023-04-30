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
        Schema::create('item_pulsa_sold', function (Blueprint $table) {
            $table->id();
            $table->integer('pulsa_id');
            $table->integer('pulsa_saldo_id');
            $table->string('sold_at_price')->nullable();
            $table->string('no_hp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_pulsa_sold');
    }
};

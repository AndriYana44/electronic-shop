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
        Schema::table('item_handphone', function (Blueprint $table) {
            $table->dropColumn('price');
            $table->dropColumn('sold_items');
            $table->dropColumn('sold_at_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item_handphone', function(Blueprint $table) {
            $table->string('price');
            $table->string('sold_items');
            $table->string('sold_at_price');
        });
    }
};

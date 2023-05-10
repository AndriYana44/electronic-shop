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
        Schema::table('item_handphone', function(Blueprint $table) {
            $table->dropColumn('available_items');
        });

        Schema::table('item_handphone_varian', function(Blueprint $table) {
            $table->integer('available_items')->after('price')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item_handphone', function(Blueprint $table) {
            $table->integer('available_items')->after('spesification')->default(0);
        });

        Schema::table('item_handphone_varian', function(Blueprint $table) {
            $table->dropColumn('available_items');
        });
    }
};

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
        Schema::table('item_cart', function(Blueprint $table) {
            $table->integer('id_kategori_item')->after('id');
            $table->renameColumn('kategori_items', 'kategori_item');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item_cart', function(Blueprint $table) {
            $table->dropColumn('id_kategori_item');
            $table->renameColumn('kategori_item', 'kategori_items');
        });
    }
};

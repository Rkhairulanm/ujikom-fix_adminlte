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
        Schema::table('detailpenjualans', function (Blueprint $table) {
            $table->unsignedBigInteger('penjualan_id')->after('detail_id');
            $table->unsignedBigInteger('produk_id')->after('penjualan_id');
            $table->foreign('penjualan_id')->references('penjualan_id')->on('penjualans')->onDelete('cascade');
            $table->foreign('produk_id')->references('produk_id')->on('produks')->onDelete('cascade');

            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detailpenjualans', function (Blueprint $table) {
            $table->dropForeign('detailpenjualans_penjualan_id_foreign');
            $table->dropForeign('detailpenjualans_produk_id_foreign');
            $table->dropColumn('penjualan_id');
            $table->dropColumn('produk_id');
            //
        });
    }
};

<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('detailpenjualans', function (Blueprint $table) {
            DB::unprepared('
                CREATE TRIGGER trigger_update_stok_produk AFTER INSERT ON detailpenjualans FOR EACH ROW
                BEGIN
                    DECLARE jumlah_produk INT;
                    SET jumlah_produk = (SELECT jumlah FROM detailpenjualans WHERE detail_id = NEW.detail_id);
                    UPDATE produks SET stok = stok - jumlah_produk WHERE produk_id = NEW.produk_id;
                END
            ');

            DB::unprepared('
                CREATE TRIGGER trigger_update_stok_produk_hapus AFTER DELETE ON detailpenjualans FOR EACH ROW
                BEGIN
                    DECLARE jumlah_produk INT;
                    SET jumlah_produk = (SELECT jumlah FROM detailpenjualans WHERE detail_id = OLD.detail_id);
                    UPDATE produks SET stok = stok + jumlah_produk WHERE produk_id = OLD.produk_id;
                END
            ');

            DB::unprepared('
                CREATE TRIGGER trigger_update_stok_produk_ubah AFTER UPDATE ON detailpenjualans FOR EACH ROW
                BEGIN
                    DECLARE jumlah_produk_lama INT;
                    DECLARE jumlah_produk_baru INT;
                    SET jumlah_produk_lama = (SELECT jumlah FROM detailpenjualans WHERE detail_id = OLD.detail_id);
                    SET jumlah_produk_baru = (SELECT jumlah FROM detailpenjualans WHERE detail_id = NEW.detail_id);
                    UPDATE produks SET stok = (stok + jumlah_produk_lama) - jumlah_produk_baru WHERE produk_id = NEW.produk_id;
                END
            ');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detailpenjualans', function (Blueprint $table) {
            DB::unprepared('DROP TRIGGER trigger_update_stok_produk');
            DB::unprepared('DROP TRIGGER trigger_update_stok_produk_hapus');
            DB::unprepared('DROP TRIGGER trigger_update_stok_produk_ubah');
        });
    }
};

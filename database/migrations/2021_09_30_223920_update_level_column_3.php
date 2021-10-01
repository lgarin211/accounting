<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateLevelColumn3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `akuns` CHANGE `level` `level` ENUM('Aktiva', 'Modal', 'Kewajiban', 'BiayaOperasional', 'Penjualan', 'PendapatanLain', 'NonOperasional') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE `akuns` CHANGE `level` `level` ENUM('Aktiva', 'Modal', 'Kewajiban', 'BiayaOperasional', 'Penjualan', 'PendapatanLain') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL");
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->unsignedBigInteger('kelompok_id');
            $table->date('tanggal_beli');
            $table->bigInteger('harga_beli');
            $table->bigInteger('nilai_residu');
            $table->integer('umur_ekonomis');
            $table->text('lokasi');
            $table->string('departemen');
            $table->date('terhitung_tanggal');
            $table->unsignedBigInteger('asset_harta');
            $table->unsignedBigInteger('akumulasi_depresiasi');
            $table->unsignedBigInteger('depresiasi');
            $table->bigInteger('total_penyusutan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assets');
    }
}

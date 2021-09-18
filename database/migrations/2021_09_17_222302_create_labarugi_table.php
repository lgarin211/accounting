<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabarugiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labarugi', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('name');
            $table->foreignId('akun_id')->references('id')->on('akuns')->onDelete('cascade');
            $table->bigInteger('debit');
            $table->bigInteger('kredit');
            $table->string('type');
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
        Schema::dropIfExists('labarugi');
    }
}

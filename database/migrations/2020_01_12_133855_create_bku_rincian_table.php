<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBkuRincianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bku_rincian', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bku_id');
            $table->foreign('bku_id')->references('id')->on('bku');
            $table->unsignedBigInteger('sts_id')->nullable();
            $table->foreign('sts_id')->references('id')->on('sts');
            $table->string('no_aktivitas');
            $table->string('tipe');
            $table->date('tanggal');
            $table->integer('penerimaan');
            $table->integer('pengeluaran');
            $table->string('kode_unit_kerja');
            $table->foreign('kode_unit_kerja')->references('kode')->on('unit_kerja');
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
        Schema::dropIfExists('bku_rincian');
    }
}

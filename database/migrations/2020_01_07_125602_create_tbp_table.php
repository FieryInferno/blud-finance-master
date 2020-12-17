<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbp', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('nomor');
            $table->date('tanggal');
            $table->string('kode_unit_kerja');
            $table->foreign('kode_unit_kerja')->references('kode')->on('unit_kerja');
            $table->string('keterangan');
            $table->unsignedBigInteger('rekening_bendahara_id');
            $table->foreign('rekening_bendahara_id')->references('id')->on('rekening_bendahara');
            $table->unsignedBigInteger('kepala_skpd');
            $table->foreign('kepala_skpd')->references('id')->on('pejabat_unit');
            $table->unsignedBigInteger('bendahara_penerima');
            $table->foreign('bendahara_penerima')->references('id')->on('pejabat_unit');
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
        Schema::dropIfExists('tbp');
    }
}

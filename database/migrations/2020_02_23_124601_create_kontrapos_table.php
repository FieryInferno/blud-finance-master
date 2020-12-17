<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKontraposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kontrapos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nomor');
            $table->boolean('nomor_otomatis');
            $table->date('tanggal');
            $table->string('kode_unit_kerja');
            $table->foreign('kode_unit_kerja')->references('kode')->on('unit_kerja');
            $table->text('keterangan');
            $table->unsignedBigInteger('rekening_bendahara');
            $table->foreign('rekening_bendahara')->references('id')->on('rekening_bendahara');
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
        Schema::dropIfExists('kontra_pos');
    }
}

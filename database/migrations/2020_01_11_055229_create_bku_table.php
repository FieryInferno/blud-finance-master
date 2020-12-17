<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBkuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bku', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('nomor');
            $table->date('tanggal');
            $table->string('kode_unit_kerja');
            $table->foreign('kode_unit_kerja')->references('kode')->on('unit_kerja');
            $table->string('keterangan');
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
        Schema::dropIfExists('bku');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePihakKetigaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pihak_ketiga', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode');
            $table->string('kode_unit_kerja');
            $table->foreign('kode_unit_kerja')->references('kode')->on('unit_kerja');
            $table->string('nama');
            $table->string('nama_perusahaan');
            $table->string('alamat');
            $table->string('nama_bank');
            $table->string('no_rekening');
            $table->string('npwp');
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
        Schema::dropIfExists('pihak_ketiga');
    }
}

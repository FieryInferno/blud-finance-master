<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpdRincianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spd_rincian', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('spd_id');
            $table->foreign('spd_id')->references('id')->on('spd');
            $table->string('kode_kegiatan');
            $table->foreign('kode_kegiatan')->references('kode')->on('kegiatan');
            $table->string('nama_kegiatan');
            $table->integer('anggaran');
            $table->integer('spd_sebelumnya');
            $table->integer('nominal');
            $table->integer('total_spd');
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
        Schema::dropIfExists('spd_rincian');
    }
}

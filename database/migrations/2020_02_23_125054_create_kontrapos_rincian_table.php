<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKontraposRincianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kontrapos_rincian', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('kontrapos_id');
            $table->foreign('kontrapos_id')->references('id')->on('kontrapos');
            $table->unsignedBigInteger('sp2d_id');
            $table->foreign('sp2d_id')->references('id')->on('sp2d');
            $table->unsignedBigInteger('kegiatan_id');
            $table->foreign('kegiatan_id')->references('id')->on('kegiatan');
            $table->decimal('nominal', 13, 2);
            $table->string('kode_akun');
            $table->foreign('kode_akun')->references('kode_akun')->on('akun');
            $table->decimal('realisasi_sp2d', 13, 2);
            $table->string('sumber_dana');
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
        Schema::dropIfExists('kontrapos_rincian');
    }
}

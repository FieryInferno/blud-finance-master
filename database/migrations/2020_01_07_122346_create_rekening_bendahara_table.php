<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekeningBendaharaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekening_bendahara', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('jenis');
            $table->string('nama_akun_bendahara');
            $table->string('kode_akun');
            $table->foreign('kode_akun')->references('kode_akun')->on('akun');
            $table->string('kode_unit_kerja');
            $table->foreign('kode_unit_kerja')->references('kode')->on('unit_kerja');
            $table->string('nama_bank');
            $table->string('rekening_bank');
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
        Schema::dropIfExists('rekening_bendahara');
    }
}

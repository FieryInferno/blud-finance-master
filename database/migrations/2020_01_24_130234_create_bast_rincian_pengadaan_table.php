<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBastRincianPengadaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bast_rincian_pengadaan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bast_id');
            $table->foreign('bast_id')->references('id')->on('bast');
            $table->string('kode_akun');
            $table->foreign('kode_akun')->references('kode_akun')->on('akun');
            $table->string('uraian')->nullable();
            $table->string('satuan');
            $table->integer('unit');
            $table->integer('harga');
            $table->string('bukti_transaksi')->nullable();
            $table->string('kondisi')->nullable();
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
        Schema::dropIfExists('bast_rincian_pengadaan');
    }
}

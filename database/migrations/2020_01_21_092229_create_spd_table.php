<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spd', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nomor');
            $table->boolean('nomor_otomatis');
            $table->date('tanggal');
            $table->string('triwulan');
            $table->string('bulan_awal');
            $table->string('bulan_akhir');
            $table->string('kode_unit_kerja');
            $table->foreign('kode_unit_kerja')->references('kode')->on('unit_kerja');
            $table->text('keterangan');
            $table->string('nomor_dpa');
            $table->integer('sisa_spd');
            $table->unsignedBigInteger('bendahara_pengeluaran');
            $table->foreign('bendahara_pengeluaran')->references('id')->on('pejabat_unit');
            $table->unsignedBigInteger('kuasa_bud');
            $table->foreign('kuasa_bud')->references('id')->on('pejabat_unit');
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
        Schema::dropIfExists('spd');
    }
}

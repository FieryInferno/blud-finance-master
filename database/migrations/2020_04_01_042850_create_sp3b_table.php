<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSp3bTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sp3b', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nomor');
            $table->date('tanggal');
            $table->string('triwulan');
            $table->string('kode_unit_kerja');
            $table->foreign('kode_unit_kerja')->references('kode')->on('unit_kerja');
            $table->unsignedBigInteger('bendahara_penerimaan');
            $table->foreign('bendahara_penerimaan')->references('id')->on('rekening_bendahara');
            $table->unsignedBigInteger('bendahara_pengeluaran');
            $table->foreign('bendahara_pengeluaran')->references('id')->on('rekening_bendahara');
            $table->string('keterangan');
            $table->unsignedBigInteger('pejabat_unit');
            $table->foreign('pejabat_unit')->references('id')->on('pejabat_unit');
            $table->boolean('is_verified')->nullable();
            $table->date('date_verified')->nullable();
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
        Schema::dropIfExists('sp3b');
    }
}

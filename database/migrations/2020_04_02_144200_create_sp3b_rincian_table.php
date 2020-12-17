<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSp3bRincianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sp3b_rincian', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sp3b_id');
            $table->foreign('sp3b_id')->references('id')->on('sp3b');
            $table->string('nomor');
            $table->unsignedBigInteger('kegiatan_id')->nullable()->default(null);
            $table->foreign('kegiatan_id')->references('id')->on('kegiatan');
            $table->unsignedBigInteger('kegiatan_id_apbd')->nullable()->default(null);
            $table->foreign('kegiatan_id_apbd')->references('id')->on('kegiatan');
            $table->string('kode_akun')->nullable()->default(null);
            $table->foreign('kode_akun')->references('kode_akun')->on('akun');
            $table->string('kode_akun_apbd')->nullable()->default(null);
            $table->foreign('kode_akun_apbd')->references('kode_akun')->on('akun');
            $table->decimal('pendapatan', 13, 2)->nullable()->default(null);
            $table->decimal('pengeluaran', 13, 2)->nullable()->default(null);
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
        Schema::dropIfExists('sp3b_rincian');
    }
}

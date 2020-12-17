<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJurnalPenyesuaianRincianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurnal_penyesuaian_rincian', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('jurnal_penyesuaian_id');
            $table->foreign('jurnal_penyesuaian_id')->references('id')->on('jurnal_penyesuaian');
            $table->string('kode_akun');
            $table->foreign('kode_akun')->references('kode_akun')->on('akun');
            $table->unsignedBigInteger('kegiatan_id')->nullable();
            $table->foreign('kegiatan_id')->references('id')->on('kegiatan');
            $table->decimal('debet', 13, 2);
            $table->decimal('kredit', 13, 2);
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
        Schema::dropIfExists('jurnal_penyesuaian_rincian');
    }
}

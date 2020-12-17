<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSp2dTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sp2d', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nomor');
            $table->boolean('nomor_otomatis');
            $table->unsignedBigInteger('spp_id');
            $table->foreign('spp_id')->references('id')->on('spp');
            $table->date('tanggal');
            $table->string('kode_unit_kerja');
            $table->foreign('kode_unit_kerja')->references('kode')->on('unit_kerja');
            $table->unsignedBigInteger('bast_id');
            $table->foreign('bast_id')->references('id')->on('bast');
            $table->string('sisa_spd_total');
            $table->string('sisa_spd_kegiatan');
            $table->string('sisa_kas');
            $table->string('sisa_pagu_pengajuan');
            $table->string('keterangan');
            $table->unsignedBigInteger('bendahara_pengeluaran');
            $table->foreign('bendahara_pengeluaran')->references('id')->on('pejabat_unit');
            $table->unsignedBigInteger('pptk');
            $table->foreign('pptk')->references('id')->on('pejabat_unit');
            $table->unsignedBigInteger('akun_bendahara');
            $table->foreign('akun_bendahara')->references('id')->on('rekening_bendahara');
            $table->unsignedBigInteger('pihak_ketiga_id');
            $table->foreign('pihak_ketiga_id')->references('id')->on('pihak_ketiga');
            $table->unsignedBigInteger('pemimpin_blud');
            $table->foreign('pemimpin_blud')->references('id')->on('pejabat_unit');
            $table->integer('nominal_sumber_dana');
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
        Schema::dropIfExists('sp2d');
    }
}

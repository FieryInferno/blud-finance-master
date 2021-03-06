<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSetupJurnalAnggaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setup_jurnal_anggaran', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('setup_jurnal_id');
            $table->foreign('setup_jurnal_id')->references('id')->on('setup_jurnal');
            $table->string('elemen_anggaran');
            $table->foreign('elemen_anggaran')->references('kode_akun')->on('akun');
            $table->string('jenis_anggaran'); // D / K      
            $table->string('nominal_anggaran');
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
        Schema::dropIfExists('setup_jurnal_anggaran');
    }
}

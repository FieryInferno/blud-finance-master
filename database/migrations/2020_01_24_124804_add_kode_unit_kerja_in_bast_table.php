<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKodeUnitKerjaInBastTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bast', function (Blueprint $table) {
            $table->string('kode_unit_kerja');
            $table->foreign('kode_unit_kerja')->references('kode')->on('unit_kerja');
            $table->unsignedBigInteger('pihak_ketiga_id');
            $table->foreign('pihak_ketiga_id')->references('id')->on('pihak_ketiga');
            $table->string('kode_kegiatan');
            $table->foreign('kode_Kegiatan')->references('kode')->on('kegiatan');
            $table->unsignedBigInteger('pembuat_komitmen');
            $table->foreign('pembuat_komitmen')->references('id')->on('pejabat_unit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bast', function (Blueprint $table) {
            //
        });
    }
}

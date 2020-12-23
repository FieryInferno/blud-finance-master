<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GantiForeignKeyKodeKegiatan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('spd_rincian', function (Blueprint $table) {
            $table->dropForeign(['kode_kegiatan']);
            $table->dropColumn('kode_kegiatan');
            $table->string('kodeSubKegiatan')->after('spd_id');
            $table->foreign('kodeSubKegiatan')->references('kodeSubKegiatan')->on('subKegiatan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('spd_rincian', function (Blueprint $table) {
            //
        });
    }
}

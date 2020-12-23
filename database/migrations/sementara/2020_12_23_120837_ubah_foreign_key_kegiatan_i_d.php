<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UbahForeignKeyKegiatanID extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bast', function (Blueprint $table) {
            $table->dropForeign(['kegiatan_id']);
            $table->dropColumn('kegiatan_id');
            $table->unsignedBigInteger('idSubKegiatan');
            $table->foreign('idSubKegiatan')->references('idSubKegiatan')->on('subKegiatan');
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

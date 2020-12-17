<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKontraposIdInBkuRincianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bku_rincian', function (Blueprint $table) {
            $table->unsignedBigInteger('kontrapos_id')->nullable()->after('setor_pajak_pajak_id');
            $table->foreign('kontrapos_id')->references('id')->on('kontrapos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bku_rincian', function (Blueprint $table) {
            //
        });
    }
}

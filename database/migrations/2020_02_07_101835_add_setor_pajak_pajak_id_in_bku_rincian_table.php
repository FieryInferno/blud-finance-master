<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSetorPajakPajakIdInBkuRincianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bku_rincian', function (Blueprint $table) {
            $table->unsignedBigInteger('setor_pajak_pajak_id')->nullable()->after('sp2d_id');
            $table->foreign('setor_pajak_pajak_id')->references('id')->on('setor_pajak_pajak');
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

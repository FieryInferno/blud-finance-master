<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSp2dIdInBkuRincianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bku_rincian', function (Blueprint $table) {
            $table->unsignedBigInteger('sp2d_id')->nullable()->after('sts_id');
            $table->foreign('sp2d_id')->references('id')->on('sp2d');
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

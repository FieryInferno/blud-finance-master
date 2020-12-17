<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeAnggatanInSpdRincianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('spd_rincian', function (Blueprint $table) {
            DB::statement('ALTER TABLE spd_rincian MODIFY anggaran  BIGINT(15)');
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

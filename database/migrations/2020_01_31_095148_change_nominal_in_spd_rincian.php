<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNominalInSpdRincian extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('spd_rincian', function (Blueprint $table) {
            DB::statement("ALTER TABLE spd_rincian MODIFY spd_sebelumnya  BIGINT(15), MODIFY nominal BIGINT(15), MODIFY total_spd BIGINT(15)");

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

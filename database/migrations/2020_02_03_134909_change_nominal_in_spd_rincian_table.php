<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNominalInSpdRincianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('spd_rincian', function (Blueprint $table) {
            DB::statement("ALTER TABLE spd_rincian MODIFY anggaran  DECIMAL(13,2), MODIFY spd_sebelumnya  DECIMAL(13,2), MODIFY nominal  DECIMAL(13,2), MODIFY total_spd  DECIMAL(13,2)");
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

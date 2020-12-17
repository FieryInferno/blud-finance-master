<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNominalSumberDanaInSppTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('spp', function (Blueprint $table) {
            DB::statement("ALTER TABLE spp MODIFY nominal_sumber_dana  DECIMAL(13,2)");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('spp', function (Blueprint $table) {
            //
        });
    }
}

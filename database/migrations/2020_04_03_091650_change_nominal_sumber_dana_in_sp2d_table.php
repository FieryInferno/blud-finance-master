<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNominalSumberDanaInSp2dTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sp2d', function (Blueprint $table) {
            DB::statement("ALTER TABLE sp2d MODIFY nominal_sumber_dana  DECIMAL(13,2)");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sp2d', function (Blueprint $table) {
            //
        });
    }
}

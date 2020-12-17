<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNominalInStsSumberDanaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sts_sumber_dana', function (Blueprint $table) {
           // DB::statement("ALTER TABLE sts_sumber_dana MODIFY nominal  DECIMAL(13,2)");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sts_sumber_dana', function (Blueprint $table) {
            //
        });
    }
}

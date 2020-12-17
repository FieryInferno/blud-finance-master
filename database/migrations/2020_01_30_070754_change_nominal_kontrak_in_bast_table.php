<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNominalKontrakInBastTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bast', function (Blueprint $table) {
            DB::statement('ALTER TABLE bast MODIFY nominal  BIGINT(15)');
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

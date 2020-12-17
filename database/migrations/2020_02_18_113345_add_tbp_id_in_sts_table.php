<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTbpIdInStsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sts', function (Blueprint $table) {
            $table->unsignedBigInteger('tbp_id')->nullable();
            $table->foreign('tbp_id')->references('id')->on('tbp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sts', function (Blueprint $table) {
            //
        });
    }
}

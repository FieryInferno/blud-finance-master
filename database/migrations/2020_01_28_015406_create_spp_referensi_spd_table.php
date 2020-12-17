<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSppReferensiSpdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spp_referensi_spd', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('spp_id');
            $table->foreign('spp_id')->references('id')->on('spp');
            $table->unsignedBigInteger('spd_id');
            $table->foreign('spd_id')->references('id')->on('spd');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spp_referensi_spd');
    }
}

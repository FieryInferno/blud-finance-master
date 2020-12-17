<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSppPajakTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spp_pajak', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('spp_id');
            $table->foreign('spp_id')->references('id')->on('spp');
            $table->unsignedBigInteger('pajak_id');
            $table->foreign('pajak_id')->references('id')->on('pajak');
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
        Schema::dropIfExists('spp_pajak');
    }
}

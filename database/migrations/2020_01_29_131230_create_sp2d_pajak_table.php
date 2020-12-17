<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSp2dPajakTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sp2d_pajak', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sp2d_id');
            $table->foreign('sp2d_id')->references('id')->on('sp2d');
            $table->unsignedBigInteger('pajak_id');
            $table->foreign('pajak_id')->references('id')->on('pajak');
            $table->integer('nominal');
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
        Schema::dropIfExists('sp2d_pajak');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSetorPajakPajakTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setor_pajak_pajak', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('setor_pajak_id');
            $table->foreign('setor_pajak_id')->references('id')->on('setor_pajak');
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
        Schema::dropIfExists('setor_pajak_pajak');
    }
}

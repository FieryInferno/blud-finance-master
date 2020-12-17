<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbpSumberDanaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbp_sumber_dana', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tbp_id');
            $table->foreign('tbp_id')->references('id')->on('tbp');
            $table->string('kode_akun');
            $table->foreign('kode_akun')->references('kode_akun')->on('akun');
            $table->integer('nominal');
            $table->unsignedBigInteger('sumber_dana_id');
            $table->foreign('sumber_dana_id')->references('id')->on('sumber_dana');
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
        Schema::dropIfExists('tbp_sumber_dana');
    }
}

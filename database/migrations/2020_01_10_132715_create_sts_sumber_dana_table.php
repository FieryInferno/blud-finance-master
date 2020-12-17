<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStsSumberDanaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sts_sumber_dana', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sts_id');
            $table->foreign('sts_id')->references('id')->on('sts');
            $table->unsignedBigInteger('sumber_dana_id');
            $table->foreign('sumber_dana_id')->references('id')->on('sumber_dana');
            $table->string('kode_akun');
            $table->foreign('kode_akun')->references('kode_akun')->on('akun');
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
        Schema::dropIfExists('sts_sumber_dana');
    }
}

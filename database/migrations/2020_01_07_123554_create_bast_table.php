<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBastTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bast', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('no_kontrak');
            $table->date('tgl_kontrak');
            $table->string('no_pemeriksaan');
            $table->date('tgl_pemeriksaan');
            $table->string('no_penerimaan');
            $table->date('tgl_penerimaan');
            $table->integer('nominal');
            $table->string('setup_jurnal');
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
        Schema::dropIfExists('bast');
    }
}

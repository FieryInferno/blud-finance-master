<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableMapAkunFinance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('map_akun_finance', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode_akun');
            $table->string('kode_akun_1')->nullable();
            $table->string('kode_akun_2')->nullable();
            $table->string('kode_akun_3')->nullable();
            $table->timestamps();

            $table->foreign('kode_akun')->references('kode_akun')->on('akun');
            $table->foreign('kode_akun_1')->references('kode_akun')->on('akun');
            $table->foreign('kode_akun_2')->references('kode_akun')->on('akun');
            $table->foreign('kode_akun_3')->references('kode_akun')->on('akun');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('map_akun_finance');
    }
}

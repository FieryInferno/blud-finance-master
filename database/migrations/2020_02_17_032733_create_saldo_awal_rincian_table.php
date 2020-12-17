<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaldoAwalRincianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saldo_awal_rincian', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('saldo_awal_id');
            $table->foreign('saldo_awal_id')->references('id')->on('saldo_awal');
            $table->unsignedBigInteger('akun_id');
            $table->foreign('akun_id')->references('id')->on('akun');
            $table->decimal('debet', 13, 2);
            $table->decimal('kredit', 13, 2);
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
        Schema::dropIfExists('saldo_awal_rincian');
    }
}

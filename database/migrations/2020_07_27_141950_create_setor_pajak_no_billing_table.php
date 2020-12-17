<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSetorPajakNoBillingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setor_pajak_no_billing', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('setor_pajak_pajak_id');
            $table->foreign('setor_pajak_pajak_id')->references('id')->on('setor_pajak_pajak')->onDelete('cascade');
            $table->string('no_billing');
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
        Schema::dropIfExists('setor_pajak_no_billing');
    }
}

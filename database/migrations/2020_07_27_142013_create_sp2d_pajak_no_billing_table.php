<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSp2dPajakNoBillingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sp2d_pajak_no_billing', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sp2d_pajak_id');
            $table->foreign('sp2d_pajak_id')->references('id')->on('sp2d_pajak')->onDelete('cascade');
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
        Schema::dropIfExists('sp2d_pajak_no_billing');
    }
}

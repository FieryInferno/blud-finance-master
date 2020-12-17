<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSppPajakNoBillingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spp_pajak_no_billing', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('spp_pajak_id');
            $table->foreign('spp_pajak_id')->references('id')->on('spp_pajak')->onDelete('cascade');
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
        Schema::dropIfExists('spp_pajak_no_billing');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNtpnAndNpwpInSetorPajakTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('setor_pajak', function (Blueprint $table) {
            $table->string('ntpn')->after('nominal_sumber_dana')->nullable();
            $table->string('npwp')->after('ntpn')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('setor_pajak', function (Blueprint $table) {
            //
        });
    }
}

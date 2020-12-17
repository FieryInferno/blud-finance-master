<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNominalInBkuRincianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bku_rincian', function (Blueprint $table) {
            DB::statement("ALTER TABLE bku_rincian MODIFY penerimaan  DECIMAL(13,2), MODIFY pengeluaran  DECIMAL(13,2)");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bku_rincian', function (Blueprint $table) {
            //
        });
    }
}

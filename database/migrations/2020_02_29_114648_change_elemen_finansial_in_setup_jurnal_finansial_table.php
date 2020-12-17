<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeElemenFinansialInSetupJurnalFinansialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('setup_jurnal_finansial', function (Blueprint $table) {
            $table->dropForeign('setup_jurnal_finansial_elemen_finansial_foreign');
            DB::statement("ALTER TABLE setup_jurnal_finansial MODIFY elemen_finansial VARCHAR(191)");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('setup_jurnal_finansial', function (Blueprint $table) {
            //
        });
    }
}

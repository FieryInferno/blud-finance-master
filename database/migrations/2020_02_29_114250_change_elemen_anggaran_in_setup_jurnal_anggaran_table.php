<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeElemenAnggaranInSetupJurnalAnggaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('setup_jurnal_anggaran', function (Blueprint $table) {
            $table->dropForeign('setup_jurnal_anggaran_elemen_anggaran_foreign');
            DB::statement("ALTER TABLE setup_jurnal_anggaran MODIFY elemen_anggaran VARCHAR(191)");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('setup_jurnal_anggaran', function (Blueprint $table) {
            //
        });
    }
}

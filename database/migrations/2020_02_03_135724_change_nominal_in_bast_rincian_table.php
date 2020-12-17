<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNominalInBastRincianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bast_rincian', function (Blueprint $table) {
            DB::statement("ALTER TABLE bast_rincian_pengadaan MODIFY harga  DECIMAL(13,2)");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bast_rincian', function (Blueprint $table) {
            //
        });
    }
}

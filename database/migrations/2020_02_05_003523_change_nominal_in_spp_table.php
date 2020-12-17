<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNominalInSppTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('spp', function (Blueprint $table) {
            DB::statement("ALTER TABLE spp MODIFY sisa_spd_total  DECIMAL(13,2), MODIFY sisa_spd_kegiatan  DECIMAL(13,2), MODIFY sisa_kas  DECIMAL(13,2), MODIFY sisa_pagu_pengajuan  DECIMAL(13,2)");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('spp', function (Blueprint $table) {
            //
        });
    }
}

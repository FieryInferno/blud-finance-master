<?php

use App\Models\PrefixPenomoran;
use Illuminate\Database\Seeder;

class NomorJurnalPenyesuaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PrefixPenomoran::create([
            'formulir' => 'Form Jurnal Penyesuaian',
            'format_penomoran' => '{nomor:5}/{unit_kerja}/JP/{tahun}'
        ]);
    }
}

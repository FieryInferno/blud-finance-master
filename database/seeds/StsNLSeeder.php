<?php

use App\Models\PrefixPenomoran;
use Illuminate\Database\Seeder;

class StsNLSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PrefixPenomoran::create([
            'formulir' => 'Form STS-NL',
            'format_penomoran' => '{nomor:5}/1.02.01.{unit_kerja}/STS-NL/{tahun}',
        ]);
    }
}

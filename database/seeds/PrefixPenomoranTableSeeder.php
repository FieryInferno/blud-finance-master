<?php

use App\Models\PrefixPenomoran;
use Illuminate\Database\Seeder;

class PrefixPenomoranTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $prefixPenomoran = [
            [
                'formulir' => 'Form Kontra Pos',
                'format_penomoran' => '{nomor:5}/1.02.01.{unit_kerja}/CP-{keperluan}/{tahun}'
            ],
            [
                'formulir' => 'Form Daftar Penguji',
                'format_penomoran' => '{nomor:5}/DP/{tahun}',
            ],
            [
                'formulir' => 'Form BUD',
                'format_penomoran' => '{nomor:5}/1.02.01.{unit_kerja}/BKU/{tahun}',
            ],
            [
                'formulir' => 'Form Pemindahbukuan',
                'format_penomoran' => '{nomor:5}',
            ],
            [
                'formulir' => 'Form Setoran Pajak',
                'format_penomoran' => '{nomor:5}/SSP/{tahun}',
            ],
            [
                'formulir' => 'Form Setoran Sisa Uang Persediaan',
                'format_penomoran' => '{nomor:5}/SSU-{keperluan}/{tahun}',
            ],
            [
                'formulir' => 'Form Setoran Potongan SP2D',
                'format_penomoran' => '{nomor:5}/SSP-SP2D GJ/{tahun}',
            ],
            [
                'formulir' => 'Form Setoran Pajak SP2D',
                'format_penomoran' => '{nomor:5}/SSP-SP2D/{tahun}',
            ],
            [
                'formulir' => 'Form SPJ Pendapatan',
                'format_penomoran' => '{nomor:5}/SPJPENDAPATAN/{tahun}',
            ],
            [
                'formulir' => 'Form Panjar',
                'format_penomoran' => '{nomor:5}/PANJAR-{keperluan}/BLUD-PKM/{tahun}',
            ],
            [
                'formulir' => 'Form SPJ Panjar',
                'format_penomoran' => '{nomor:5}/SPJPANJAR/BLUD-PKM/{tahun}',
            ],
            [
                'formulir' => 'Form STS',
                'format_penomoran' => '{nomor:5}/1.02.01.{unit_kerja}/STS/{tahun}',
            ],
            [
                'formulir' => 'Form SPD',
                'format_penomoran' => '{nomor:5}/{unit_kerja}/SPD-{beban}/{tahun}',
            ],
            [
                'formulir' => 'Form TBP',
                'format_penomoran' => '{nomor:4}/{unit_kerja}/TBP/{tahun}',
            ],
            [
                'formulir' => 'Form SPP',
                'format_penomoran' => '{nomor:5}/SPP-{keperluan}/BLUD-PKM.1.02.01.{unit_kerja}/{tahun}',
            ],
            [
                'formulir' => 'Form SPM',
                'format_penomoran' => '{nomor:5}/SPM-{keperluan}/BLUD-PKM.1.02.01.{unit_kerja}/{tahun}',
            ],
            [
                'formulir' => 'Form SP2D',
                'format_penomoran' => '{nomor:5}/SP2D-{keperluan}/BLUD-PKM.1.02.01.{unit_kerja}/{tahun}',
            ],
            [
                'formulir' => 'Form Belanja',
                'format_penomoran' => '{nomor:5}/BLJ/{tahun}',
            ],
            [
                'formulir' => 'Form SPJ Administratif',
                'format_penomoran' => '{nomor:5}/1.02.01.{unit_kerja}/SPJ-A/BLUD-PKM/{tahun}',
            ],
            [
                'formulir' => 'Form Setoran Sisa Panjar',
                'format_penomoran' => '{nomor:5}/Setor Sisa Panjar-{keperluan}/BLUD-PKM/{tahun}',
            ],
            [
                'formulir' => 'Form Memo Penyesuaian',
                'format_penomoran' => '{nomor:5}/1.02.01.{unit_kerja}/MP/{tahun}',
            ],
            [
                'formulir' => 'Form Verifikasi SPP',
                'format_penomoran' => '{nomor:5}/VERSPP-{keperluan}/BLUD-PKM/{tahun}',
            ],
            [
                'formulir' => 'Form Verifikasi SPM',
                'format_penomoran' => '{nomor:5}/VERSPPM-{keperluan}/BLUD-PKM/{tahun}',
            ],
            [
                'formulir' => 'Form Verifikasi SPJ',
                'format_penomoran' => '{nomor:5}/VERSPJ-{keperluan}/BLUD-PKM/{tahun}',
            ],
            [
                'formulir' => 'Form SKPD/SKRD',
                'format_penomoran' => '{nomor:5}/SKP-R/{tahun}',
            ],
            [
                'formulir' => 'BKU Pengeluaran',
                'format_penomoran' => '{nomor:5}',
            ],
            [
                'formulir' => 'BKU Penerimaan',
                'format_penomoran' => '{nomor:5}',
            ],
            [
                'formulir' => 'Form SPJ Fungsional',
                'format_penomoran' => '{nomor:5}/1.02.01.{unit_kerja}/SPJ-F/{tahun}',
            ],
            [
                'formulir' => 'Form Penarikan Tunai',
                'format_penomoran' => '{nomor:5}/{unit_kerja}/BLUD/PKM/{tahun}',
            ],
            [
                'formulir' => 'Form Pengembalian Tunai',
                'format_penomoran' => '{nomor:5}/{tahun}',
            ],
            
        ];

        foreach($prefixPenomoran as $index => $data) {
            PrefixPenomoran::create(['formulir' => $data['formulir'], 'format_penomoran' => $data['format_penomoran']]);
        }
    }
}

<?php

use App\Models\RekeningBendahara;
use Illuminate\Database\Seeder;

class RekeningBendaharaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rekening = [
            [
                'jenis' => 'Penerimaan',
                'nama_akun_bendahara' => 'Kas di Bendahara Penerimaan BLUD Dinas Kesehatan',
                'kode_akun' => '1.1.1.05.03',
                'kode_unit_kerja' => '06',
                'nama_bank' => 'Bank Jatim',
                'rekening_bank' => 'Kas di Bendahara Penerimaan BLUD'
            ],
            [
                'jenis' => 'Penerimaan',
                'nama_akun_bendahara' => 'Kas di Bendahara Pengeluaraan BLUD Dinas Kesehatan',
                'kode_akun' => '1.1.1.05.04',
                'kode_unit_kerja' => '06',
                'nama_bank' => 'Bank Jatim',
                'rekening_bank' => 'Kas di Bendahara Penerimaan BLUD Puskemas Dinoyo'
            ],
        ];

        foreach($rekening as $index => $data) {
            RekeningBendahara::create([
                'jenis' => $data['jenis'], 
                'nama_akun_bendahara' => $data['nama_akun_bendahara'],
                'kode_akun' => $data['kode_akun'],
                'kode_unit_kerja' => $data['kode_unit_kerja'],
                'nama_bank' => $data['nama_bank'],
                'rekening_bank' => $data['rekening_bank']
            ]);
        }
    }
}

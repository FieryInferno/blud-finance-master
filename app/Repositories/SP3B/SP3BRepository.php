<?php

namespace App\Repositories\SP3B;

use App\Models\Sp3b;
use App\Repositories\Repository;

class SP3BRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Sp3b::class;
    }

    /**
     * Get detail sp3b
     * 
     * @return void
     */
    public function getDetailSp3b($id = null, $triwulan = null, $kodeUniKerja = null)
    {
        $sp3b = Sp3b::with([
            'sp3bRincian.akun', 'sp3bRincian.akunApbd', 'sp3bRincian.kegiatan', 'sp3bRincian.kegiatanApbd',
            'unitKerja'
        ]);
            if ($id){
                $sp3b->where('id', '=', $id);
            }

            if ($kodeUniKerja){
                $sp3b->where('kode_unit_kerja', $kodeUniKerja);
            }

            if ($triwulan) {
                $sp3b->where('triwulan', $triwulan);
            }

        return $sp3b->first();
    }
}

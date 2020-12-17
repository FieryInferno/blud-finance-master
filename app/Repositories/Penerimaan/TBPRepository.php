<?php

namespace App\Repositories\Penerimaan;

use App\Models\Tbp;
use App\Models\TbpRincian;
use App\Repositories\Repository;

class TBPRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Tbp::class;
    }

    /**
     * Get Last data of tbp
     *
     * @return void
     */
    public function getLastTbp($kodeUnit)
    {
        return Tbp::where('nomor_otomatis', true)
            ->where('kode_unit_kerja', $kodeUnit)
            ->orderBy('id', 'desc')
            ->first();
    }

    /**
     * Get jurnal tbp
     *
     * @param [type] $kodeUnit
     * @return void
     */
    public function getJurnalTbp($kodeUnit = null)
    {
        $TbpRincian = TbpRincian::with(['tbp.unitKerja', 'akun']);
            if ($kodeUnit){
                $TbpRincian->whereHas('tbp', function ($query) use($kodeUnit) {
                    $query->where('kode_unit_kerja', $kodeUnit);
                });
            }
        return $TbpRincian->get();
    }
}

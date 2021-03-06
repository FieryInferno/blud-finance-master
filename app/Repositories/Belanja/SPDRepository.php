<?php

namespace App\Repositories\Belanja;

use App\Models\Spd;
use App\Repositories\Repository;

class SPDRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Spd::class;
    }

    /**
     * Get Last data of spd
     *
     * @return void
     */
    public function getLastSpd($kodeUnit)
    {
        return Spd::where('nomor_otomatis', true)
            ->where('kode_unit_kerja', $kodeUnit)
            ->orderBy('id', 'desc')
            ->first();
    }

    /**
     * Get total nominal spd by kode kegiatan
     *
     * @param [type] $kodeKegiatan
     * @return void
     */
    public function getTotalSpdKegiatan($kodeSubKegiatan, $kodeUnitKerja)
    {
        $totalSpd = 0;

        $spd = Spd::with(['spdRincian' => function ($query) use($kodeSubKegiatan) {
            $query->where('kodeSubKegiatan', $kodeSubKegiatan);
        }])
            ->where('kode_unit_kerja', $kodeUnitKerja)
            ->get();

        foreach ($spd as $item) {
            foreach ($item->spdRincian as $rincian) {
                if ($rincian->kodeSubKegiatan == $kodeSubKegiatan){
                    $totalSpd += $rincian->nominal;
                }
            }
        }

        return $totalSpd;
    }
}

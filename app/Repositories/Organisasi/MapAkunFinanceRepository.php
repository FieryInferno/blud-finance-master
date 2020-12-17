<?php

namespace App\Repositories\Organisasi;

use App\Models\MapAkunFinance;
use App\Repositories\Repository;

class MapAkunFinanceRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return MapAkunFinance::class;
    }

    /**
     * Get map akun data
     *
     * @param [String] $kodeAkun
     * @return void
     */
    public function getMapAkun($kodeAkun, $relation)
    {
        return MapAkunFinance::where('kode_akun', $kodeAkun)
            ->orWhere('kode_akun_1', $kodeAkun)
            ->orWhere('kode_akun_2', $kodeAkun)
            ->orWhere('kode_akun_3', $kodeAkun)
            ->with([$relation])
            ->first();
    }
}

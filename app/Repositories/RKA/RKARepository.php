<?php

namespace App\Repositories\RKA;

use App\Models\Rka;
use App\Models\Akun;
use App\Repositories\Repository;

class RKARepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Rka::class;
    }

    /**
     * Get Akun Id
     *
     * @param [type] $kodeAkun
     * @return void
     */
    public function getAkunId($kodeAkun)
    {
        $akun = Akun::where('kode_akun', $kodeAkun)->first();
        return $akun;
    }

    public function getRbaUpdate($kodeUnit, $status, $kodeRka)
    {
        $rka = Rka::where('kode_unit_kerja', $kodeUnit)
            ->where('tipe', $status)
            ->where('kode_rka', $kodeRka)
            ->first();

        return $rka;
    }
}

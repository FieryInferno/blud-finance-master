<?php

namespace App\Repositories\Akutansi;

use App\Models\SaldoAwalRincian;
use App\Repositories\Repository;

class SaldoAwalRincianRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return SaldoAwalRincian::class;
    }

    public function deleteAll($saldoAwalId)
    {
        return SaldoAwalRincian::where('saldo_awal_id', $saldoAwalId)->delete();
    }
}

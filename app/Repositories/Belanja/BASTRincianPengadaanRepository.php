<?php

namespace App\Repositories\Belanja;

use App\Repositories\Repository;
use App\Models\BastRincianPengadaan;

class BASTRincianPengadaanRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return BastRincianPengadaan::class;
    }

    /**
     * Delete all rincian spd
     *
     * @param [type] $tbpId
     * @return void
     */
    public function deleteAll($bastId)
    {
        return BastRincianPengadaan::where('bast_id', $bastId)->delete();
    }
}

<?php

namespace App\Repositories\Belanja;

use App\Models\SpdRincian;
use App\Repositories\Repository;

class SPDRincianRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return SpdRincian::class;
    }
    /**
     * Delete all rincian spd
     *
     * @param [type] $tbpId
     * @return void
     */
    public function deleteAll($spdId)
    {
        return SpdRincian::where('spd_id', $spdId)->delete();
    }
}

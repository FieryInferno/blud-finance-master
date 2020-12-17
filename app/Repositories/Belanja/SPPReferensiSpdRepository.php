<?php

namespace App\Repositories\Belanja;

use App\Models\SppReferensiSpd;
use App\Repositories\Repository;

class SPPReferensiSpdRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return SppReferensiSpd::class;
    }

    /**
     * Delete all spp referensi spd
     *
     * @return void
     */
    public function deleteAll($sppId)
    {
        return SppReferensiSpd::where('spp_id', $sppId)->delete();
    }
}

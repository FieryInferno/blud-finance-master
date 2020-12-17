<?php

namespace App\Repositories\Belanja;

use App\Models\SppPajakNoBilling;
use App\Repositories\Repository;

class SPPPajakNoBillingRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return SppPajakNoBilling::class;
    }

    /**
     * Delete all spp pajak no billing
     *
     * @return void
     */
    public function deleteAll($sppPajakId)
    {
        return SppPajakNoBilling::where('spp_pajak_id', $sppPajakId)->delete();
    }
    
}

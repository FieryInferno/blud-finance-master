<?php

namespace App\Repositories\Belanja;

use App\Models\Sp2dPajakNoBilling;
use App\Repositories\Repository;

class Sp2dPajakNoBillingRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Sp2dPajakNoBilling::class;
    }

    /**
     * Delete all sp2d pajak no billing
     *
     * @return void
     */
    public function deleteAll($sppPajakId)
    {
        return Sp2dPajakNoBilling::where('sp2d_pajak_id', $sppPajakId)->delete();
    }
    
}

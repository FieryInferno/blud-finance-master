<?php

namespace App\Repositories\Belanja;

use App\Models\SetorPajakNoBilling;
use App\Repositories\Repository;

class SetorPajakPajakNoBillingRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return SetorPajakNoBilling::class;
    }

    /**
     * Delete all setor pajak pajak no billing
     *
     * @return void
     */
    public function deleteAll($sppPajakId)
    {
        return SetorPajakNoBilling::where('setor_pajak_pajak_id', $sppPajakId)->delete();
    }
    
}

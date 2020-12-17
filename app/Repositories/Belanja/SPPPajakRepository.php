<?php

namespace App\Repositories\Belanja;

use App\Models\SppPajak;
use App\Repositories\Repository;

class SPPPajakRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return SppPajak::class;
    }

    /**
     * Delete all spp pajak
     *
     * @return void
     */
    public function deleteAll($sppId)
    {
        return SppPajak::where('spp_id', $sppId)->delete();
    }
    
}

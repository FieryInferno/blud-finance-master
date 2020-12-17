<?php

namespace App\Repositories\Belanja;

use App\Models\Sp2dPajak;
use App\Repositories\Repository;

class SP2DPajakRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Sp2dPajak::class;
    }

    /**
     * Delete all sp2d pajak
     *
     * @return void
     */
    public function deleteAll($sp2dId)
    {
        return Sp2dPajak::whereIn('sp2d_id', $sp2dId)->delete();
    }
    
}

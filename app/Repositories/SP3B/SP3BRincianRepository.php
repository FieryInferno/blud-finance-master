<?php

namespace App\Repositories\SP3B;

use App\Models\Sp3bRincian;
use App\Repositories\Repository;

class SP3BRincianRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Sp3bRincian::class;
    }

    public function deleteSp3bRincian($sp3bId) 
    {
        return Sp3bRincian::where('sp3b_id', $sp3bId)->delete();
    }
}

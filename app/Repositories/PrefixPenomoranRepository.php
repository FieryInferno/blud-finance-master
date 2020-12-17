<?php

namespace App\Repositories;

use App\Models\Bidang;
use App\Models\PrefixPenomoran;
use App\Repositories\Repository;

class PrefixPenomoranRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return PrefixPenomoran::class;
    }
}

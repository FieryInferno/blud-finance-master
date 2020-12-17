<?php

namespace App\Repositories\Pengaturan;

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

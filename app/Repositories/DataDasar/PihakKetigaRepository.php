<?php

namespace App\Repositories\DataDasar;

use App\Models\PihakKetiga;
use App\Repositories\Repository;

class PihakKetigaRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return PihakKetiga::class;
    }
}

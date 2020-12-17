<?php

namespace App\Repositories\DataDasar;

use App\Models\Pajak;
use App\Repositories\Repository;

class PajakRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Pajak::class;
    }
}

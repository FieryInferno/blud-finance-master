<?php

namespace App\Repositories\Organisasi;

use App\Repositories\Repository;
use App\Models\RekeningBendahara;

class RekeningBendaharaRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return RekeningBendahara::class;
    }
}

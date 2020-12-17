<?php

namespace App\Repositories\Akutansi;

use App\Models\SetupJurnal;
use App\Repositories\Repository;

class SetupJurnalRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return SetupJurnal::class;
    }
}

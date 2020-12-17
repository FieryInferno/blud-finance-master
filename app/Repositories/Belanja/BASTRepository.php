<?php

namespace App\Repositories\Belanja;

use App\Models\Bast;
use App\Repositories\Repository;

class BASTRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Bast::class;
    }
}

<?php

namespace App\Repositories\Akutansi;

use App\Models\SetupJurnalFinansial;
use App\Repositories\Repository;

class SetupJurnalFinansialRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return SetupJurnalFinansial::class;
    }

    public function deleteAll($setupJurnalId)
    {
        return SetupJurnalFinansial::where('setup_jurnal_id', $setupJurnalId)->delete();
    }
}

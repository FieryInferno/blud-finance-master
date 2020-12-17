<?php

namespace App\Repositories\Akutansi;

use App\Models\SetupJurnalAnggaran;
use App\Repositories\Repository;

class SetupJurnalAnggaranRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return SetupJurnalAnggaran::class;
    }

    public function deleteAll($setupJurnalId)
    {
        return SetupJurnalAnggaran::where('setup_jurnal_id', $setupJurnalId)->delete();
    }
}

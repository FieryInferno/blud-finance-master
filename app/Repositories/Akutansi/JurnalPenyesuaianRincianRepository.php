<?php

namespace App\Repositories\Akutansi;

use App\Models\JurnalPenyesuaianRincian;
use App\Repositories\Repository;

class JurnalPenyesuaianRincianRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return JurnalPenyesuaianRincian::class;
    }

    public function deleteAll($jurnalPenyesuaianId)
    {
        return JurnalPenyesuaianRincian::where('jurnal_penyesuaian_id', $jurnalPenyesuaianId)->delete();
    }
}

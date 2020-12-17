<?php

namespace App\Repositories\DataDasar;

use App\Models\MapKegiatan;
use App\Repositories\Repository;

class MapKegiatanRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return MapKegiatan::class;
    }

    public function getMapKegiatan($kegiatanId, $kodeUnitKerja) 
    {
        return MapKegiatan::with(['apbd'])
            ->where('kegiatan_id_blud', $kegiatanId)
            ->where('kode_unit_kerja', $kodeUnitKerja)
            ->first();
    }
}

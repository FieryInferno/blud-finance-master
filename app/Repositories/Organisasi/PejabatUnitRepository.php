<?php

namespace App\Repositories\Organisasi;

use App\Models\PejabatUnit;
use App\Repositories\Repository;

class PejabatUnitRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return PejabatUnit::class;
    }

    /**
     * Get spesific jabata
     *
     * @param [String] $unitKerja
     * @param [BigInt] $jabatanId
     * @return void
     */
    public function getPejabat($unitKerja, $jabatanId)
    {
        $pejabat = PejabatUnit::where('kode_unit_kerja', $unitKerja)
            ->where('jabatan_id', $jabatanId)
            ->first();
        return $pejabat;
    }
    
    /**
     * Get all pejabat
     *
     * @param [type] $unitKerja
     * @return void
     */
    public function getAllPejabat($unitKerja)
    {
        $pejabat = PejabatUnit::with(['jabatan'])
            ->where('kode_unit_kerja', $unitKerja)
            ->get();
        return $pejabat;
    }

    
}

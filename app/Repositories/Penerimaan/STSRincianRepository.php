<?php

namespace App\Repositories\Penerimaan;

use App\Models\StsRincian;
use App\Repositories\Repository;
use Illuminate\Support\Facades\DB;

class STSRincianRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return StsRincian::class;
    }

    /**
     * Delete all rincian tbp
     *
     * @param [type] $tbpId
     * @return void
     */
    public function deleteAll($tbpId)
    {
        return StsRincian::where('sts_id', $tbpId)->delete();
    }

    public function getAllRincian($kodeUnitKerja, $tanggalAwal, $tanggalAkhir)
    {
        return StsRincian::whereHas('sts', function ($query) use ($kodeUnitKerja, $tanggalAwal, $tanggalAkhir){
            $query->where('kode_unit_kerja', $kodeUnitKerja)
                ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir]);
        })->with(['sts.unitKerja', 'akun'])
            ->get();

    }

    public function getKodeAkun()
    {
        return DB::table('sts_rincian')->distinct()->get(['kode_akun'])->pluck('kode_akun');
    }
}

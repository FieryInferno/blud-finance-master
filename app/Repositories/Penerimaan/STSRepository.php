<?php

namespace App\Repositories\Penerimaan;

use App\Models\SetorPajakPajak;
use App\Models\Sts;
use App\Repositories\Repository;
use Illuminate\Support\Facades\DB;

class STSRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Sts::class;
    }

    /**
     * Get Last data of sts
     *
     * @return void
     */
    public function getLatsSts($kodeUnit)
    {
        return Sts::where('nomor_otomatis', true)
            ->where('nl', false)
            ->where('kode_unit_kerja', $kodeUnit)
            ->orderBy('id', 'desc')
            ->first();
    }

    /**
     * Get Last data of sts nl
     *
     * @return void
     */
    public function getLatsStsNL($kodeUnit)
    {
        return Sts::where('nomor_otomatis', true)
            ->where('nl', true)
            ->where('kode_unit_kerja', $kodeUnit)
            ->orderBy('id', 'desc')
            ->first();
    }

    /**
     * Get all sts
     * 
     * @return void
     */
    public function getAllStsBku($unitKerja, $tanggalAwal, $tanggalAkhir)
    {
        return Sts::where('kode_unit_kerja', $unitKerja)
            ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
            ->with(['bkuRincian.bku', 'rincianSts'])
            ->get();
    }

    /**
     * @return void
     */
    public function getStsByMonth($unitKerja, $month)
    {
        $year = env('TAHUN_ANGGARAN', 2020);
        return Sts::where('kode_unit_kerja', $unitKerja)
            ->whereRaw(DB::raw("DATE_FORMAT(tanggal, '%m') = {$month}"))
            ->whereRaw(DB::raw("DATE_FORMAT(tanggal, '%Y') = {$year}"))
            ->with(['bkuRincian.bku', 'rincianSts'])
            ->get();
    }

    /**
     * @return void
     */
    public function getStsUntilMonth($unitKerja, $month)
    {
        $year = env('TAHUN_ANGGARAN', 2020);
        return Sts::where('kode_unit_kerja', $unitKerja)
            ->whereRaw(DB::raw("DATE_FORMAT(tanggal, '%m') <= {$month}"))
            ->whereRaw(DB::raw("DATE_FORMAT(tanggal, '%Y') = {$year}"))
            ->with(['bkuRincian.bku', 'rincianSts'])
            ->get();
    }
}

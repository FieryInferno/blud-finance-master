<?php

namespace App\Repositories\Belanja;

use App\Models\Sp2d;
use App\Repositories\Repository;
use Illuminate\Support\Facades\DB;

class SP2DRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Sp2d::class;
    }

    /**
     * Get Last data of spp
     *
     * @return void
     */
    public function getLastSpp($kodeUnit)
    {
        return Spp::where('nomor_otomatis', true)
            ->where('kode_unit_kerja', $kodeUnit)
            ->orderBy('id', 'desc')
            ->first();
    }

    /**
     * Get total spp
     *
     * @param [type] $kodeKegiatan
     * @return void
     */
    public function getTotalSpp($kodeKegiatan)
    {
        $totalSpp = 0;
        $spp = Spp::with(['bast' => function ($query) use($kodeKegiatan){
            $query->where('kode_kegiatan', $kodeKegiatan);
        }])
            ->get();
        $totalSpp = $spp->sum('nominal_sumber_dana');

        return $totalSpp;
    }

    /**
     * Update nomor 
     *
     * @param [type] $nomor
     * @return void
     */
    public function updateNomor($nomor)
    {
        DB::table('spp')
            ->where('nomor', '>', $nomor)
            ->where('nomor_otomatis', true)
            ->update([
                'nomor' => DB::raw('nomor-1')
            ]);
    }

    /**
     * Get sp2d with bku
     * 
     * @return void
     */
    public function getSp2dBku($unitKerja, $tanggalAwal, $tanggalAkhir)
    {
        return Sp2d::where('kode_unit_kerja', $unitKerja)
            ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
            ->with(['bkuRincian.bku', 'bast.rincianPengadaan', 'sp2dPajak.pajak'])
            ->get();

    }

     /**
     * @return void
     */
    public function getSp2dByMonth($unitKerja, $month)
    {
        $year = env('TAHUN_ANGGARAN', 2020);
        return Sp2d::where('kode_unit_kerja', $unitKerja)
            ->whereRaw(DB::raw("DATE_FORMAT(tanggal, '%m') = {$month}"))
            ->whereRaw(DB::raw("DATE_FORMAT(tanggal, '%Y') = {$year}"))
            ->with(['bkuRincian.bku', 'bast.rincianPengadaan', 'sp2dPajak.pajak'])
            ->get();
    }

    /**
     * @return void
     */
    public function getSp2dUntilMonth($unitKerja, $month)
    {
        $year = env('TAHUN_ANGGARAN', 2020);
        return Sp2d::where('kode_unit_kerja', $unitKerja)
            ->whereRaw(DB::raw("DATE_FORMAT(tanggal, '%m') <= {$month}"))
            ->whereRaw(DB::raw("DATE_FORMAT(tanggal, '%Y') = {$year}"))
            ->with(['bkuRincian.bku', 'bast.rincianPengadaan', 'sp2dPajak.pajak'])
            ->get();
    }

    /**
     * Delete all sp2d
     *
     * @param [type] $id
     * @return void
     */
    public function deleteAll($id)
    {
        return Sp2d::whereIn('id', $id)->delete();
    }
}

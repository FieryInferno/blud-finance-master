<?php

namespace App\Repositories\Belanja;

use App\Models\SetorPajak;
use App\Models\SetorPajakPajak;
use App\Repositories\Repository;
use Illuminate\Support\Facades\DB;

class SetorPajakRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return SetorPajak::class;
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
     * Update nomor setor pajak
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
     * Get all setor pajak with bku
     * 
     * @return void
     */
    public function getSetorPajakBku($unitKerja, $tanggalAwal, $tanggalAkhir)
    {
        return SetorPajakPajak::whereHas('setorPajak', function ($query) use($unitKerja, $tanggalAwal, $tanggalAkhir){
            $query->where('kode_unit_kerja', $unitKerja)
                ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir]);
        })
            ->with(['bkuRincian.bku', 'setorPajak.bast.pihakKetiga'])
            ->get();
    }

     /**
     * @return void
     */
    public function getSetorPajakByMonth($unitKerja, $month)
    {
        $year = env('TAHUN_ANGGARAN', 2020);
        return SetorPajakPajak::whereHas('setorPajak', function ($query) use($unitKerja, $month, $year){
            $query->where('kode_unit_kerja', $unitKerja)
            ->whereRaw(DB::raw("DATE_FORMAT(tanggal, '%m') = {$month}"))
            ->whereRaw(DB::raw("DATE_FORMAT(tanggal, '%Y') = {$year}"));
        })
            ->with(['bkuRincian.bku'])
            ->get();
    }

    public function getSetorPajakUntilThisMonth($unitKerja, $month)
    {
        $year = env('TAHUN_ANGGARAN', 2020);
        return SetorPajakPajak::whereHas('setorPajak', function ($query) use ($unitKerja, $month, $year) {
            $query->where('kode_unit_kerja', $unitKerja)
                ->whereRaw(DB::raw("DATE_FORMAT(tanggal, '%m') <= {$month}"))
                ->whereRaw(DB::raw("DATE_FORMAT(tanggal, '%Y') = {$year}"));
        })
            ->with(['bkuRincian.bku'])
            ->get();
    }

    /**
     * Delete all setor pajak
     *
     * @param [type] $id
     * @return void
     */
    public function deleteAll($id)
    {
        return SetorPajak::whereIn('id', $id)->delete();
    }
}

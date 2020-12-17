<?php

namespace App\Repositories\Belanja;

use App\Models\Spp;
use App\Repositories\Repository;
use Illuminate\Support\Facades\DB;

class SPPRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Spp::class;
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
    public function getTotalSpp($kodeKegiatan, $kodeUnit)
    {
        $totalSpp = 0;
        $spp = Spp::with(['bast' => function ($query) use($kodeKegiatan){
            $query->where('kode_kegiatan', $kodeKegiatan);
        }])
            ->where('kode_unit_kerja', $kodeUnit)
            ->get();
        $totalSpp = $spp->sum('nominal_sumber_dana');

        return $totalSpp;
    }

    /**
     * Get total Spp by rekening
     *
     * @param [type] $kodeUnit
     * @param [type] $kodeAkun
     * @return void
     */
    public function getTotalSppByRekening($kodeUnit, $kodeAkun)
    {
        $totalSpp = 0;
        $spp = Spp::whereHas('bast.rincianPengadaan', function ($query) use ($kodeAkun) {
            $query->where('kode_akun', $kodeAkun);
        })
            ->where('kode_unit_kerja', $kodeUnit)
            ->get();
        $totalSpp = $spp->sum('nominal_sumber_dana');

        return $totalSpp;
    }

    /**
     * update nomor spp when delete spesific spp
     *
     * @param [type] $nomor
     * @param [type] $kodeUnit
     * @return void
     */
    public function updateNomor($nomor, $kodeUnit)
    {
        DB::table('spp')
            ->where('kode_unit_kerja', $kodeUnit)
            ->where('nomor', '>', $nomor)
            ->where('nomor_otomatis', true)
            ->update([
                'nomor' => DB::raw('nomor-1')
            ]);
    }
}

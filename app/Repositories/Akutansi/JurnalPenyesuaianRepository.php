<?php

namespace App\Repositories\Akutansi;

use App\Models\JurnalPenyesuaian;
use App\Models\JurnalPenyesuaianRincian;
use App\Repositories\Repository;

class JurnalPenyesuaianRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return JurnalPenyesuaian::class;
    }

    /**
     * get last saldo awal
     *
     * @param [type] $kodeUnit
     * @return void
     */
    public function getLastJurnalPenyesuaian($kodeUnit)
    {
        return JurnalPenyesuaian::where('nomor_otomatis', true)
            ->where('kode_unit_kerja', $kodeUnit)
            ->orderBy('id', 'desc')
            ->first();
    }

    public function getRincian($kodeUnit, $request = null)
    {
        $jurnalPenyesuaian =  JurnalPenyesuaianRincian::whereHas('jurnalPenyesuaian', function($query) use($kodeUnit, $request){
            if ($kodeUnit) {
                $query->where('kode_unit_kerja', $kodeUnit);
            }

            if ($request->unit_kerja){
                $query->where('kode_unit_kerja', $request->unit_kerja);
            }

            if ($request->start_date && $request->end_date){
                $query->whereBetween('tanggal', [$request->start_date, $request->end_date]);
            }

            if ($request->tanggal_awal && $request->tanggal_akhir) {
                $query->whereBetween('tanggal', [$request->tanggal_awal, $request->tanggal_akhir]);
            }
        });
        if ($request->kode_akun) {
            $jurnalPenyesuaian->whereHas('akun', function ($query) use ($request) {
                $query->where('kode_akun', 'LIKE', '%' . $request->kode_akun);
            });
        }
        return $jurnalPenyesuaian->with(['akun', 'kegiatan', 'jurnalPenyesuaian.unitKerja'])
            ->get();
    }
}

<?php

namespace App\Repositories\Akutansi;

use App\Models\SaldoAwal;
use App\Models\SaldoAwalRincian;
use App\Repositories\Repository;

class SaldoAwalRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return SaldoAwal::class;
    }

    /**
     * get last saldo awal
     *
     * @param [type] $kodeUnit
     * @return void
     */
    public function getLastSaldoAwal($kodeUnit, $tipe)
    {
        return SaldoAwal::where('nomor_otomatis', true)
            ->where('tipe', $tipe)
            ->where('kode_unit_kerja', $kodeUnit)
            ->orderBy('id', 'desc')
            ->first();
    }


    public function getRincianSaldoAwal($kodeUnit, $tipe, $request = null)
    {
       
        $saldoAwalRincian = SaldoAwalRincian::whereHas('saldoAwal', function ($query) use ($tipe, $kodeUnit, $request) {
            $query->where('tipe', $tipe);
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
        if ($request->kode_akun){
            // dd('%' . $request->kode_akun);
            $saldoAwalRincian->whereHas('akun', function ($query) use($request){
                $query->where('kode_akun', 'like', '%'.$request->kode_akun);
            });
            // $saldoAwalRincian->with(['akun' => function ($query) use($request){
            //     $query->where('kode_akun', 'like', '%' . $request->kode_akun);
            // }]);
        }

        return $saldoAwalRincian->with(['akun', 'saldoAwal.unitKerja'])
            ->get();

            
    }

    public function getSaldoAwalNeracaByUnitKerja($kodeUnit)
    {
        return SaldoAwal::where('kode_unit_kerja', $kodeUnit)
            ->where('tipe', SaldoAwal::NERACA)
            ->with(['saldoAwalRincian'])
            ->first();
    }
}

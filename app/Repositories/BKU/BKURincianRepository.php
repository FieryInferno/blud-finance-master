<?php

namespace App\Repositories\BKU;

use App\Models\BkuRincian;
use App\Models\StsRincian;
use App\Repositories\Repository;
use Illuminate\Support\Facades\DB;

class BKURincianRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return BkuRincian::class;
    }

    /**
     * Delete all rincian tbp
     *
     * @param [type] $tbpId
     * @return void
     */
    public function deleteAll($bkuId)
    {
        return BkuRincian::where('bku_id', $bkuId)->delete();
    }

    public function deleteMany($bkuId)
    {
        return BkuRincian::whereIn('bku_id', $bkuId)->delete();
    }

    /**
     * Get al bku rincian
     *
     * @param [type] $kodeUnitKerja
     * @param [type] $tanggalAwal
     * @param [type] $tanggalAkhir
     * @return void
     */
    public function getAllBkuRincian($kodeUnitKerja, $tanggalAwal, $tanggalAkhir, $request = null)
    {
        return BkuRincian::whereHas('bku', function ($query) use($kodeUnitKerja, $tanggalAwal, $tanggalAkhir) {
            $query->where('kode_unit_kerja', $kodeUnitKerja)
                ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir]);
        })->with(['bku', 'sts'])
            ->get();
    }

    /**
     * Get all rincian sts
     *
     * @param [type] $kodeUnitKerja
     * @param [type] $tanggalAwal
     * @param [type] $tanggalAkhir
     * @return void
     */
    public function getAllBkuStsRincian($kodeUnitKerja, $tanggalAwal, $tanggalAkhir)
    {
        return BkuRincian::whereHas('bku', function ($query) use ($kodeUnitKerja, $tanggalAwal, $tanggalAkhir) {
            $query->where('kode_unit_kerja', $kodeUnitKerja)
                ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir]);
        })->with(['bku', 'sts'])
            ->where('tipe', BkuRincian::STS)
            ->get();
    }

    public function getBkuRincian($request, $kodeUnitKerja = null)
    {
        return BkuRincian::whereHas('bku', function ($query) use($kodeUnitKerja, $request) {
            if ($kodeUnitKerja){
                $query->where('kode_unit_kerja', $kodeUnitKerja);
            }
            if ($request->unit_kerja) {
                $query->where('kode_unit_kerja', $request->unit_kerja);
            }

            if ($request->start_date) {
                $query->where('tanggal', '>=', $request->start_date);
            }

            if ($request->end_date) {
                $query->where('tanggal', '<=', $request->end_date);
            }
        })->get();
    }

    public function getRincianSp3b($kodeUnitKerja, $dateStart, $dateEnd)
    {
        return BkuRincian::whereHas('bku', function ($query) use($kodeUnitKerja, $dateStart, $dateEnd) {
            $query->where('kode_unit_kerja', $kodeUnitKerja)
                ->whereBetween('tanggal', [$dateStart, $dateEnd]);
        }) 
            ->whereIn('tipe', [BkuRincian::STS, BkuRincian::KONTRAPOS, BkuRincian::SP2D])
            ->with([
                'sp2d.bast.rincianPengadaan.akun.mapAkun.map', 'sp2d.bast.kegiatan', 'sts.rincianSts.akun.mapAkun.map', 
                'kontrapos.kontraposRincian.akun.mapAkun.map', 'bku'
            ])
            ->get();

    }

    /**
     * 
     */
    public function getBkuRincianBrop($unitKerja, $tanggalAwal, $tanggalAkhir, $kodeAkun)
    {
        $bkuRincian = BkuRincian::where('tipe', BkuRincian::SP2D)
            ->whereHas('bku', function ($query) use($unitKerja, $tanggalAwal, $tanggalAkhir){
                $query->where('kode_unit_kerja', $unitKerja)
                    ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir]);
            })
            ->whereHas('sp2d.bast.rincianPengadaan', function($query) use($kodeAkun){
                $query->where('kode_akun', $kodeAkun);
            })
            ->with(['sp2d.bast.rincianPengadaan', 'bku']);
        
        return $bkuRincian->get();
            
    }
    
    public function getBkuRincianBropPenerimaan($unitKerja, $tanggalAwal, $tanggalAkhir, $kodeAkun)
    {
        $bkuRincian = BkuRincian::where('tipe', BkuRincian::STS)
            ->whereHas('bku', function ($query) use($unitKerja, $tanggalAwal, $tanggalAkhir){
                $query->where('kode_unit_kerja', $unitKerja)
                    ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir]);
            })
            ->with(['sts.rincianSts', 'bku']);
            if ($kodeAkun){
                $bkuRincian->whereHas('sts.rincianSts', function($query) use($kodeAkun){
                    $query->where('kode_akun', $kodeAkun);
                });
            }
        return $bkuRincian->get();
            
    }

    public function getBkuJurnalUmum($request = null)
    {
        $bkuRincian = BkuRincian::with([
            'bku.unitKerja', 'sts.rincianSts', 'sts.rekeningBendahara',
            'sp2d.bast.rincianPengadaan', 'setorPajak', 'setorPajak.setorPajak.bast.rincianPengadaan', 'setorPajak.setorPajak.rekeningBendahara',
            'kontrapos', 'kontrapos.kontraposRincian', 'kontrapos.rekeningBendahara'
        ]);

        if (auth()->user()->hasRole('Admin')) { } else {
            $bkuRincian->where('kode_unit_kerja', auth()->user()->kode_unit_kerja);
        }

        if ($request){
            $bkuRincian->whereHas('bku', function ($query) use ($request) {
                if ($request->unit_kerja){
                    $query->where('kode_unit_kerja', $request->unit_kerja);
                }
                if ($request->start_date && $request->end_date){
                    $query->whereBetween('tanggal', [$request->start_date, $request->end_date]);
                }
                if ($request->tanggal_awal && $request->tanggal_akhir){
                    $query->whereBetween('tanggal', [$request->tanggal_awal, $request->tanggal_akhir]);
                }
            });
        }

        if ($request->tipe) {
            $bkuRincian->where('tipe', strtoupper($request->tipe));
        }
        return $bkuRincian->get();
    }
}

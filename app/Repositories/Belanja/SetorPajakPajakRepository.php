<?php

namespace App\Repositories\Belanja;

use App\Models\SetorPajakPajak;
use App\Repositories\Repository;
use Symfony\Component\HttpFoundation\Request;

class SetorPajakPajakRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return SetorPajakPajak::class;
    }

    /**
     * Delete all setor pajak pajak
     *
     * @return void
     */
    public function deleteAll($setorPajakId)
    {
        return SetorPajakPajak::whereIn('setor_pajak_id', $setorPajakId)->delete();
    }

    /**
     * Get last number
     *
     * @param [type] $kodeUnitKerja
     * @return void
     */
    public function getLastNomor($kodeUnitKerja)
    {
        $noPajak = SetorPajakPajak::whereHas('setorPajak', function ($query) use ($kodeUnitKerja) {
            $query->where('kode_unit_kerja', $kodeUnitKerja);
        })->orderBy('nomor', 'desc')
            ->first();

        return $noPajak ? $noPajak->nomor+1 : 1;
    }
    

    public function getAllSetorPajak(Request $request, $kodeUnitKerja = null, $id = null)
    {
        $pajak = SetorPajakPajak::with(['setorPajak.spp', 'setorPajak.unitKerja', 'setorPajak.bast.kegiatan', 'pajak']);
        if ($kodeUnitKerja){
            $pajak->whereHas('setorPajak', function ($query) use($kodeUnitKerja, $request){
                $query->where('kode_unit_kerja', $kodeUnitKerja);

                if ($request->start_date) {
                    $query->where('tanggal', '>=', $request->start_date);
                }

                if ($request->end_date) {
                    $query->where('tanggal', '<=', $request->end_date);
                }
            });
        }else {
            $pajak->whereHas('setorPajak', function ($query) use ($request) {
                if ($request->unit_kerja) {
                    $query->where('kode_unit_kerja', $request->unit_kerja);
                }

                if ($request->start_date) {
                    $query->where('tanggal', '>=', $request->start_date);
                }

                if ($request->end_date) {
                    $query->where('tanggal', '<=', $request->end_date);
                }
            });
        }
        if ($id){
            $pajak->whereNotIn('id', $id);
        }
        return $pajak->get();
    }

    public function getAllSetorPajakPotongan(Request $request, $kodeUnitKerja = null, $id = null)
    {
        $pajak = SetorPajakPajak::with(['setorPajak.spp', 'setorPajak.unitKerja', 'setorPajak.bast.kegiatan', 'pajak']);
        if ($kodeUnitKerja) {
            $pajak->whereHas('setorPajak', function ($query) use ($kodeUnitKerja, $request) {
                $query->where('kode_unit_kerja', $kodeUnitKerja);

                if ($request->start_date) {
                    $query->where('tanggal', '>=', $request->start_date);
                }

                if ($request->end_date) {
                    $query->where('tanggal', '<=', $request->end_date);
                }
            });
        } else {
            $pajak->whereHas('setorPajak', function ($query) use ($request) {
                if ($request->unit_kerja) {
                    $query->where('kode_unit_kerja', $request->unit_kerja);
                }

                if ($request->start_date) {
                    $query->where('tanggal', '>=', $request->start_date);
                }

                if ($request->end_date) {
                    $query->where('tanggal', '<=', $request->end_date);
                }
            });
        }
        if ($id) {
            $pajak->whereNotIn('id', $id);
        }
        $pajak->where('is_information', false);
        return $pajak->get();
    }
}

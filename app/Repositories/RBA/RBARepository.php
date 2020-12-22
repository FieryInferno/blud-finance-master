<?php

namespace App\Repositories\RBA;

use App\Models\Rba;
use App\Models\Akun;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Auth;

class RBARepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Rba::class;
    }

    /**
     * Get Akun Id
     *
     * @param [type] $kodeAkun
     * @return void
     */
    public function getAkunId($kodeAkun)
    {
        $akun = Akun::where('kode_akun', $kodeAkun)->first();
        return $akun;
    }

    /**
     * Get data rba update
     *
     * @param [type] $kodeUnit
     * @param [type] $status
     * @param [type] $kodeRba
     * @return void
     */
    public function getRbaUpdate($id, $status, $kodeRba)
    {
        $rba = Rba::where('id', $id)
            ->where('tipe', $status)
            ->where('kode_rba', $kodeRba)
            ->first();

        return $rba;
    }

    /**
     * Get Rba By UnitKerja, Tipe and Kode
     *
     * @param [type] $unitKerja
     * @param [type] $tipe
     * @param [type] $kodeRba
     * @return void
     */
    public function getRba($unitKerja, $tipe, $kodeRba)
    {
        $rba = Rba::with(['rincianSumberDana.akun'])
            ->where('kode_unit_kerja', $unitKerja)
            ->where('tipe', $tipe)
            ->where('kode_rba', $kodeRba)
            ->first();
            
        return $rba;
    }

    /**
     * Get Rba By UnitKerja, Tipe and Kode
     *
     * @param [type] $unitKerja
     * @param [type] $tipe
     * @param [type] $kodeRba
     * @return void
     */
    public function getRba221($unitKerja, $tipe, $kodeRba)
    {
        $rba = Rba::with(['rincianSumberDana.akun', 'mapSubKegiatan.subKegiatanBlud'])
            ->where('kode_unit_kerja', $unitKerja)
            // ->where('tipe', $tipe)
            ->where('kode_rba', $kodeRba)
            ->get();

        return $rba;
    }

    /**
     * get Rba 1
     *
     * @param [type] $unitKerja
     * @return void
     */
    public function getRba1($unitKerja)
    {
        $rba = Rba::with('rincianAnggaran')
            ->where('kode_unit_kerja', $unitKerja)
            ->where('kode_rba', Rba::KODE_RBA_1)
            ->where('status_anggaran_id', Auth::user()->statusAnggaran->id)
            ->first();

        if (!$rba) {
            $rba = Rba::with('rincianAnggaran')
                ->where('kode_unit_kerja', $unitKerja)
                ->where('kode_rba', Rba::KODE_RBA_1)
                // ->where('status_anggaran_id', Auth::user()->statusAnggaran->id)
                ->first(); 
        }

        return $rba;
    }

    /**
     * Get akun by kegiatan
     *
     * @param [type] $unitKerja
     * @param [type] $kodeKegiatan
     * @return void
     */
    public function getRba221ByKegiatan($unitKerja, $kodeKegiatan)
    {
        $rba = Rba::whereHas('mapKegiatan.blud', function ($query) use ($kodeKegiatan){
            $query->where('kode', $kodeKegiatan);
        })->with('rincianAnggaran.akun')
            ->where('kode_rba', Rba::KODE_RBA_221)
            ->where('kode_unit_kerja', $unitKerja)
            ->orderBy('id', 'desc')
            ->first();

        return $rba;
    }

    /**
     * Get rba 221 by kode rekening
     *
     * @param [type] $unitKerja
     * @param [type] $kodeAkun
     * @return void
     */
    public function getRba221ByRekening($unitKerja, $akunId)
    {
        $rba = Rba::with(['rincianSumberDana' => function ($query) use ($akunId) {
                    $query->whereIn('akun_id', $akunId);
                }])
                ->where('kode_unit_kerja', $unitKerja)
                ->where('kode_rba', Rba::KODE_RBA_221)
                ->where('status_anggaran_id', Auth::user()->statusAnggaran->id)
                ->get();
        
        return $rba;
    }

    /**
     * Undocumented function
     *
     * @param [type] $kodeUnitKerja
     * @return void
     */
    public function getAnggaran($kodeUnitKerja)
    {
        return Rba::where('kode_unit_kerja', $kodeUnitKerja)
            ->where('kode_rba', Rba::KODE_RBA_221)
            ->with(['rincianSumberDana.akun', 'unitKerja', 'mapKegiatan.blud'])
            ->orderBy('id', 'desc')
            ->first();
    }

    /**
     * Get Rba By UnitKerja, Tipe and Kode
     *
     * @param [type] $unitKerja
     * @param [type] $kodeRba
     * @return void
     */
    public function getDetailRba221($unitKerja, $mapKegiatanId = null)
    {
        $rba = Rba::with(['rincianSumberDana.akun', 'mapKegiatan.blud', 'statusAnggaran'])
            ->where('kode_unit_kerja', $unitKerja)
            ->where('kode_rba', Rba::KODE_RBA_221)
            ->where('map_kegiatan_id', $mapKegiatanId)
            ->orderBy('id', 'desc');

        return $rba->first();
    }

    public function getDetailRba1($unitKerja)
    {
        $rba = Rba::with(['rincianSumberDana.akun', 'statusAnggaran'])
            ->where('kode_unit_kerja', $unitKerja)
            ->where('kode_rba', Rba::KODE_RBA_1)
            ->orderBy('id', 'desc');

        return $rba->first();
    }

    /**
     * Undocumented function
     *
     * @param [type] $unitKerja
     * @return void
     */
    public function getKegiatanRba221($unitKerja)
    {
        $rba = Rba::with(['mapKegiatan.blud'])
            ->where('kode_unit_kerja', $unitKerja)
            ->where('kode_rba', Rba::KODE_RBA_221);
        return $rba->get();
    }

    /**
     * Get anggaran rba1
     *
     * @param [type] $kodeUnit
     * @return void
     */
    public function getAnggaranRba1($kodeUnit)
    {
        $rba = Rba::with(['rincianSumberDana', 'rincianAnggaran'])
            ->where('kode_unit_kerja', $kodeUnit)
            ->where('kode_rba', Rba::KODE_RBA_1)
            ->orderBy('id', 'desc')
            ->first();
        
        return $rba;
    }

    /**
     * Get anggaran rba 221
     *
     * @param [type] $kodeUnit
     * @return void
     */
    public function getAnggaranRba221($kodeUnit)
    {
        $rba = Rba::with(['rincianSumberDana', 'rincianAnggaran'])
            ->where('kode_unit_kerja', $kodeUnit)
            ->where('kode_rba', Rba::KODE_RBA_221)
            ->orderBy('id', 'desc')
            ->first();

        return $rba;
    }

    /**
     * Get anggaran rba 31
     *
     * @param [type] $kodeUnit
     * @return void
     */
    public function getAnggaranRba311($kodeUnit)
    {
        $rba = Rba::with(['rincianSumberDana', 'rincianAnggaran'])
            ->where('kode_unit_kerja', $kodeUnit)
            ->where('kode_rba', Rba::KODE_RBA_31)
            ->orderBy('id', 'desc')
            ->first();

        return $rba;
    }
}

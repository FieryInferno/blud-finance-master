<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Organisasi\UnitKerjaRepository;
use App\Repositories\RBA\RBARepository;

class LaporanController extends Controller
{

    /**
     * Unit kerja repository.
     * 
     * @var UnitKerjaRepository
     */
    private $unitKerja;

    /**
     * Rba Repository
     * 
     * @var RbaRepository
     */
    private $rba;

    /**
     * Constructor.
     */
    public function __construct(
        UnitKerjaRepository $unitKerja,
        RBARepository $rba
    )
    {
        $this->unitKerja = $unitKerja;
        $this->rba = $rba;
    }

    /**
     * Index
     *
     * @return void
     */
    public function index()
    {
        if (auth()->user()->hasRole('Admin')) {
            $unitKerja = $this->unitKerja->get();
        } else {
            $where = function ($query) {
                $query->where('kode', auth()->user()->kode_unit_kerja);
            };
            $unitKerja = $this->unitKerja->get(['*'], $where);
        }
        return view('admin.laporan.index', compact('unitKerja'));
    }


    /**
     * Get detaill rekening rba 221 by unit kerja
     * 
     * @param Request $request
     */
    public function getDataRekeningPengeluaran(Request $request)
    {
        $unitKerja = $request->unit_kerja;
        if ($request->kegiatan){
            $rba = $this->rba->getKegiatanRba221($unitKerja);
            $response = [];

            $rba->map(function ($item) use(&$response){
                $kodeKegiatan = $item->mapKegiatan->blud->kode_bidang.'.'. $item->mapKegiatan->blud->kode_program.'.'. $item->mapKegiatan->blud->kode;
                $response[] = [
                    'map_kegiatan_id' => $item->map_kegiatan_id,
                    'nama_kegiatan' => $item->mapKegiatan->blud->nama_kegiatan,
                    'kode_kegiatan' => $kodeKegiatan
                ];
            });

            $response = collect($response);
            $response = $response->unique('kode_kegiatan')->values()->all();
        }else {
            $mapKegiatanId = $request->map_kegiatan;
            $rba = $this->rba->getDetailRba221($unitKerja, $mapKegiatanId);
            $response = [];

            $rba->rincianSumberDana->map(function ($item) use(&$response){
                $response[] = [
                    'kode_akun' => $item->akun->kode_akun,
                    'nama_akun' => $item->akun->nama_akun
                ];
            });

            $response = collect($response);
            $response = $response->unique('kode_akun')->values()->all();
        }

        return response()->json([
            'data' => $response,
            'status' => 'success'
        ], 200);
    }

    public function getDataRekeningPenerimaan(Request $request)
    {
        $unitKerja = $request->unit_kerja;
        $rba = $this->rba->getDetailRba1($unitKerja);
        $response = [];

        $rba->rincianSumberDana->map(function ($item) use (&$response) {
            $response[] = [
                'kode_akun' => $item->akun->kode_akun,
                'nama_akun' => $item->akun->nama_akun
            ];
        });

        $response = collect($response);
        $response = $response->unique('kode_akun')->values()->all();

        return response()->json([
            'data' => $response,
            'status' => 'success'
        ], 200);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Models\Rba;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\RBA\RBARepository;
use App\Http\Requests\Belanja\BastRequest;
use App\Repositories\Belanja\BASTRepository;
use App\Repositories\Organisasi\UnitKerjaRepository;
use App\Repositories\Belanja\BASTRincianPengadaanRepository;
use App\Repositories\Belanja\SPPRepository;
use App\Repositories\DataDasar\AkunRepository;
use App\Repositories\DataDasar\PihakKetigaRepository;
use App\Repositories\Organisasi\KegiatanRepository;
use App\Repositories\Organisasi\PejabatUnitRepository;

class BASTController extends Controller
{
    /**
     * Unit kerja repository.
     * 
     * @var UnitKerjaRepository
     */
    private $unitKerja;

    /**
     * Bast Repository
     * 
     * @var BASTRepository
     */
    private $bast;

    /**
     * Bast Repository
     * 
     * @var BASTRincianPengadaanRepository
     */
    private $rincianPengadaan;

    /**
     * RBA repository.
     * 
     * @var RBARepository
     */
    private $rba;

    /**
     * Kegiatan repository.
     * 
     * @var RBARepository
     */
    private $kegiatan;

    /**
     * Pejabat unit repository.
     * 
     * @var PejabatUnitRepository
     */
    private $pejabatUnit;

    /**
     * Pihak ketiga repository.
     * 
     * @var PihakKetigaRepository
     */
    private $pihakKetiga;

    /**
     * Akun repository.
     * 
     * @var AkunRepository
     */
    private $akun;


    /**
     * SPPRepository
     *
     * @var SPPRepository
     */
    private $spp;

    /**
     * Constructor.
     */
    public function __construct(
        UnitKerjaRepository $unitKerja,
        BASTRepository $bast,
        BASTRincianPengadaanRepository $rincianPengadaan,
        RBARepository $rba,
        KegiatanRepository $kegiatan,
        PejabatUnitRepository $pejabat,
        PihakKetigaRepository $pihakKetiga,
        AkunRepository $akun,
        SPPRepository $spp
    ) {
        $this->unitKerja = $unitKerja;
        $this->bast = $bast;
        $this->rincianPengadaan = $rincianPengadaan;
        $this->rba = $rba;
        $this->kegiatan = $kegiatan;
        $this->pejabatUnit = $pejabat;
        $this->pihakKetiga = $pihakKetiga;
        $this->akun = $akun;
        $this->spp = $spp;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $unitKerja = $this->unitKerja->get();

        $where = function ($query) use ($request) {
            if (!auth()->user()->hasRole('Admin')) {
                $query->where('kode_unit_kerja', auth()->user()->kode_unit_kerja);
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
        };
        $bast = $this->bast->get(['*'], $where, ['rincianPengadaan', 'unitKerja']);

        foreach ($bast as $value) {
            foreach ($value->rincianPengadaan as $item) {
                $value->total_rincian += ((float) $item->harga) * $item->unit;
            }
        }

        return view('admin.bast.index', compact('bast', 'unitKerja'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (auth()->user()->hasRole('Admin')) {
            $unitKerja = $this->unitKerja->get();
        } else {
            $where = function ($query) {
                $query->where('kode', auth()->user()->kode_unit_kerja);
            };
            $unitKerja = $this->unitKerja->get(['*'], $where);
        }
        return view('admin.bast.create', compact('unitKerja'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BastRequest $request)
    {
        try {
            DB::beginTransaction();

            $bast = $this->bast->create([
                'nomor'             => $request->nomor,
                'no_kontrak'        => $request->nomor_kontrak, 
                'tgl_kontrak'       => $request->tanggal_kontrak, 
                'no_pemeriksaan'    => $request->nomor_pemeriksaan, 
                'tgl_pemeriksaan'   => $request->tanggal_pemeriksaan, 
                'no_penerimaan'     => $request->nomor_penerimaan, 
                'tgl_penerimaan'    => $request->tanggal_penerimaan, 
                'nominal'           => parse_format_number($request->nominal_kontrak),
                'kode_unit_kerja'   => $request->unit_kerja,
                'pihak_ketiga_id'   => $request->pihak_ketiga,
                'idSubKegiatan'     => $request->subKegiatan,
                'pembuat_komitmen'  => $request->pejabat_pembuat_komitmen
            ]);

            if (!$bast) {
                throw new Exception("Error create BAST");
            }

            foreach ($request['kode_akun'] as $key => $value) {
                $rincianBast = $this->rincianPengadaan->create([
                    'bast_id' => $bast->id,
                    'kode_akun' => $request->kode_akun[$key],
                    'uraian' => $request->uraian[$key],
                    'satuan' => $request->satuan[$key],
                    'unit' => $request->unit[$key],
                    'harga' => parse_format_number($request->harga[$key]),
                    'bukti_transaksi' => $request->bukti_transaksi[$key],
                    'kondisi' => $request->kondisi[$key],
                ]);

                if (!$rincianBast) {
                    throw new Exception("Error create rincian BAST");
                }
            }

            DB::commit();
            return response()->json(['status' => 'oke', 'bast' => $bast], 200);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'data' => $e->getMessage(),
                'line' => $e->getLine(),
            ], 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (auth()->user()->hasRole('Admin')) {
            $unitKerja = $this->unitKerja->get();
        } else {
            $where = function ($query) {
                $query->where('kode', auth()->user()->kode_unit_kerja);
            };
            $unitKerja = $this->unitKerja->get(['*'], $where);
        }
        

        $bast = $this->bast->find($id, ['*'], ['unitKerja', 'rincianPengadaan', 'pihakKetiga', 'kegiatan']);

        $rba = $this->rba->getRba221($bast->kode_unit_kerja, auth()->user()->status, Rba::KODE_RBA_221);

        $kodeKegiatan = [];
        foreach ($rba as  $item) {
            if (! in_array($item->mapKegiatan->blud->kode, $kodeKegiatan)){
                array_push($kodeKegiatan, $item->mapKegiatan->blud->kode);
            }
        }

        $whereKegiatan = function ($query) use($kodeKegiatan){
            $query->whereIn('kode', $kodeKegiatan);
        };
        $where = function ($query) use($bast){
            $query->where('kode_unit_kerja', $bast->kode_unit_kerja);
        };

        $pejabatUnit = $this->pejabatUnit->get(['*'], $where, ['jabatan']);
        $pihakKetiga =  $this->pihakKetiga->get(['*'], $where);

        $whereAkun = function ($query) use ($bast) {
            $query->whereIn('kode_akun', $bast->rincianPengadaan->pluck('kode_akun')->toArray());
        };
        $akun = $this->akun->get(['*'], $whereAkun);
        return view('admin.bast.edit', compact('bast', 'unitKerja', 'pejabatUnit', 'pihakKetiga', 'akun'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BastRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $bast = $this->bast->update([
                'nomor' => $request->nomor,
                'no_kontrak' => $request->nomor_kontrak, 
                'tgl_kontrak' => $request->tanggal_kontrak, 
                'no_pemeriksaan' => $request->nomor_pemeriksaan, 
                'tgl_pemeriksaan' => $request->tanggal_pemeriksaan, 
                'no_penerimaan' => $request->nomor_penerimaan, 
                'tgl_penerimaan' => $request->tanggal_penerimaan, 
                'nominal' => parse_format_number($request->nominal_kontrak),
                'kode_unit_kerja' => $request->unit_kerja,
                'pihak_ketiga_id' => $request->pihak_ketiga,
                'kegiatan_id' => $request->kegiatan,
                'pembuat_komitmen' => $request->pejabat_pembuat_komitmen
            ], $id);

            $this->rincianPengadaan->deleteAll($id);
            foreach ($request['kode_akun'] as $key => $value) {
                $rincianBast = $this->rincianPengadaan->create([
                    'bast_id' => $id,
                    'kode_akun' => $request->kode_akun[$key],
                    'uraian' => $request->uraian[$key],
                    'satuan' => $request->satuan[$key],
                    'unit' => $request->unit[$key],
                    'harga' => parse_format_number($request->harga[$key]),
                    'bukti_transaksi' => $request->bukti_transaksi[$key],
                    'kondisi' => $request->kondisi[$key],
                ]);

                if (!$rincianBast) {
                    throw new Exception("Error update rincian BAST");
                }
            }

            DB::commit();
            return response()->json(['status' => 'oke', 'bast' => $bast], 200);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'data' => $e->getMessage(),
                'line' => $e->getLine(),
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $bast = $this->bast->find($request->id);

            if (!$bast) {
                throw new \Exception('Data tidak ditemukan');
            }

            $this->rincianPengadaan->deleteAll($request->id);
            
            $bast->delete();
            return redirect()->back()
                ->with(['success' => 'Data berhasil dihapus']);
        }catch (\Exception $e){
            return redirect()->back()
                ->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Get data sts
     *
     * @return void
     */
    public function getData(Request $request)
    {
        $spp    = $this->spp->get(['*']);
        $bastId = $spp->pluck('bast_id');
        $where  = function ($query) use($request, $bastId){
            $query->where('kode_unit_kerja', $request->kode_unit_kerja)
                ->where('tgl_kontrak', '<', $request->tanggal)
                ->whereNotIn('id', $bastId);
        };

        $bast   = $this->bast->get(['*'], $where, ['pihakKetiga', 'subKegiatan']);

        $response   = [
            'data'  => $bast
        ];

        return response()->json($response, 200);
    }

    /**
     * Report Sts By Id
     *
     * @param [type] $id
     * @return void
     */
    public function report($id)
    {
        //
    }

    public function getKegiatanBast(Request $request)
    {
        try {
            $bast   = $this->bast->find($request->bast_id, ['*'], ['rincianPengadaan.akun', 'subKegiatan.kegiatan']);

            if (! $bast){
                throw new \Exception('Bast not found');
            }

            $totalAllKegiatan   = 0;
            foreach ($bast->rincianPengadaan as $value) {
                $totalAllKegiatan += ((float) $value->harga * $value->unit);
            }

            $rincian    = $bast ? $bast->rincianPengadaan : null;

            $response   = [
                'data'  => [
                    'total'     => $totalAllKegiatan,
                    'bast'      => $bast,
                    'rincian'   => $rincian,
                ],
                'total_data'    => $bast->count()
            ];

            return response()->json($response, 200);
        }catch(\Exception $e){
            $response = [
                'message' => $e->getMessage(),
                'total_data' => 0
            ];

            return response()->json($response, 200);
        }
    }
}

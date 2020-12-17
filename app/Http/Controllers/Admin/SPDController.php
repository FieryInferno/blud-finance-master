<?php

namespace App\Http\Controllers\Admin;

use App\Models\Rba;
use Illuminate\Http\Request;
use App\Models\PrefixPenomoran;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Controllers\Controller;
use App\Repositories\RBA\RBARepository;
use App\Http\Requests\Belanja\SpdRequest;
use App\Repositories\Belanja\SPDRepository;
use App\Repositories\Belanja\SPDRincianRepository;
use App\Repositories\Organisasi\PejabatUnitRepository;
use App\Repositories\Organisasi\UnitKerjaRepository;
use App\Repositories\Pengaturan\PrefixPenomoranRepository;

class SPDController extends Controller
{
    /**
     * Unit kerja repository.
     * 
     * @var UnitKerjaRepository
     */
    private $unitKerja;

    /**
     * Unit kerja repository.
     * 
     * @var RbaRepository
     */
    private $rba;

    /**
     * Spd repository.
     * 
     * @var SPDRepository
     */
    private $spd;

    /**
     * Spd repository.
     * 
     * @var SPDRincianRepository
     */
    private $spdRincian;

    /**
     * Prefix penomoran repository.
     * 
     * @var PrefixPenomoranRepository
     */
    private $prefixPenomoran;

    /**
     * Sumber dana Repository
     * 
     * @var PejabatUnitRepository
     */
    private $pejabatUnit;

    /**
     * Constructor.
     */
    public function __construct(
        UnitKerjaRepository $unitKerja,
        RBARepository $rba,
        SPDRepository $spd,
        SPDRincianRepository $spdRincian,
        PrefixPenomoranRepository $prefixPenomoran,
        PejabatUnitRepository $pejabatUnit
    ) {
        $this->unitKerja = $unitKerja;
        $this->rba = $rba;
        $this->spd = $spd;
        $this->spdRincian = $spdRincian;
        $this->prefixPenomoran = $prefixPenomoran;
        $this->pejabatUnit = $pejabatUnit;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $prefix = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_SPD);
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
        $spd = $this->spd->get(['*'], $where, ['unitKerja', 'spdRincian']);

        $prefixPenomoran = explode('/', $prefix->format_penomoran);
        $spd->map(function ($item) use($prefixPenomoran){
            $item->total_nominal = $item->spdRincian->sum('nominal');
            if ($item->nomor_otomatis) {
                $nomorFix = nomor_fix($prefixPenomoran, $item->nomor, $item->kode_unit_kerja);
                $item->nomorfix = $nomorFix;
            } else {
                $item->nomorfix = $item->nomor;
            }
        });

        $totalAllSpd = $spd->sum(function ($item){
            return $item->spdRincian->sum('nominal');
        });

        return view('admin.spd.index', compact('spd', 'totalAllSpd', 'unitKerja'));
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
        return view('admin.spd.create', compact('unitKerja'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SpdRequest $request)
    {
        try {
            DB::beginTransaction();

            $nomorOtomatis = true;

            if (!$request->nomor) {
                $spd = $this->spd->getLastSpd($request->unit_kerja);
                if ($spd) {
                    $nomor = $spd->nomor + 1;
                } else {
                    $nomor = 1;
                }
            } else {
                $nomor = $request->nomor;
                $nomorOtomatis = false;
            }

            $spd = $this->spd->create([
                'nomor' => $nomor, 
                'nomor_otomatis' => $nomorOtomatis, 
                'tanggal' => $request->tanggal, 
                'triwulan' => $request->triwulan, 
                'bulan_awal' => $request->bulan_awal, 
                'bulan_akhir' => $request->bulan_akhir, 
                'kode_unit_kerja' => $request->unit_kerja,
                'keterangan' => $request->keterangan, 
                'sisa_spd' => parse_format_number($request->sisa_spd),
                'nomor_dpa' => $request->nomor_dpa,
                'bendahara_pengeluaran' => $request->bendahara_pengeluaran, 
                'kuasa_bud' => $request->kuasa_bud
            ]);

            if (!$spd) {
                throw new Exception("Error create spd");
            }

            foreach ($request['kode_kegiatan'] as $key => $value) {
                $rincianSpd = $this->spdRincian->create([
                    'spd_id' => $spd->id, 
                    'kode_kegiatan' => $request->kode_kegiatan[$key], 
                    'nama_kegiatan' => $request->nama_kegiatan[$key], 
                    'anggaran' => parse_format_number($request->anggaran[$key]), 
                    'spd_sebelumnya' => parse_format_number($request->spd_sebelumnya[$key]), 
                    'nominal' => parse_format_number($request->nominal[$key]), 
                    'total_spd' => parse_format_number($request->total_spd[$key])
                ]);

                if (!$rincianSpd) {
                    throw new Exception("Error create rincian Spd");
                }
            }

            DB::commit();
            return response()->json(['status' => 'oke', 'spd' => $spd], 200);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'data' => $e->getMessage()
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
        $prefix = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_SPD);
        $prefixPenomoran = explode('/', $prefix->format_penomoran);
        $spd = $this->spd->findBy('id', '=', $id, ['*'], ['unitKerja', 'spdRincian']);

        if ($spd->nomor_otomatis) {
            $nomorFix = nomor_fix($prefixPenomoran, $spd->nomor, $spd->kode_unit_kerja);
            $spd->nomorfix = $nomorFix;
        } else {
            $spd->nomorfix = $spd->nomor;
        }

        if (auth()->user()->hasRole('Admin')) {
            $unitKerja = $this->unitKerja->get();
        } else {
            $where = function ($query) {
                $query->where('kode', auth()->user()->kode_unit_kerja);
            };
            $unitKerja = $this->unitKerja->get(['*'], $where);
        }

        $wherePejabatUnit = function ($query) use ($spd) {
            $query->where('kode_unit_kerja', $spd->kode_unit_kerja);
        };

        $pejabatUnit = $this->pejabatUnit->get(['*'], $wherePejabatUnit, ['jabatan']);
        return view('admin.spd.edit', compact('spd', 'unitKerja', 'pejabatUnit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SpdRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $spd = $this->spd->find($id);

            if (!$spd) {
                throw new Exception("Spd not found");
            }

            $this->spd->update([
                'tanggal' => $request->tanggal,
                'triwulan' => $request->triwulan,
                'bulan_awal' => $request->bulan_awal,
                'bulan_akhir' => $request->bulan_akhir,
                'kode_unit_kerja' => $request->unit_kerja,
                'keterangan' => $request->keterangan,
                'sisa_spd' => parse_format_number($request->sisa_spd),
                'nomor_dpa' => $request->nomor_dpa,
                'bendahara_pengeluaran' => $request->bendahara_pengeluaran,
                'kuasa_bud' => $request->kuasa_bud
            ], $id);

            $this->spdRincian->deleteAll($spd->id);

            foreach ($request['kode_kegiatan'] as $key => $value) {
                $rincianSpd = $this->spdRincian->create([
                    'spd_id' => $spd->id,
                    'kode_kegiatan' => $request->kode_kegiatan[$key],
                    'nama_kegiatan' => $request->nama_kegiatan[$key],
                    'anggaran' => parse_format_number($request->anggaran[$key]),
                    'spd_sebelumnya' => parse_format_number($request->spd_sebelumnya[$key]),
                    'nominal' => parse_format_number($request->nominal[$key]),
                    'total_spd' => parse_format_number($request->total_spd[$key])
                ]);

                if (!$rincianSpd) {
                    throw new Exception("Error create rincian Spd");
                }
            }

            DB::commit();
            return response()->json(['status' => 'oke', 'spd' => $spd], 200);

        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'data' => $e->getMessage()
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
            $spd = $this->spd->find($request->id);

            if (!$spd) {
                throw new \Exception('Data tidak ditemukan');
            }

            $this->spdRincian->deleteAll($spd->id);

            $spd->delete();

            return redirect()->back()
                ->with(['success' => 'Data berhasil dihapus']);

        } catch (\Exception $e) {
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
        $where = function ($query) use ($request) {
            $query->where('kode_unit_kerja', $request->kode_unit_kerja);
        };

        $prefix = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_SPD);

        $spd = $this->spd->get(['*'], $where);

        $prefixPenomoran = explode('/', $prefix->format_penomoran);
        $spd->map(function ($item) use ($prefixPenomoran) {
            $item->total_nominal = $item->spdRincian->sum('nominal');
            if ($item->nomor_otomatis) {
                $nomorFix = nomor_fix($prefixPenomoran, $item->nomor, $item->kode_unit_kerja);
                $item->nomorfix = $nomorFix;
            } else {
                $item->nomorfix = $item->nomor;
            }
        });

        $response = [
            'data' => $spd
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
        $prefix = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_SPD);
        $prefixPenomoran = explode('/', $prefix->format_penomoran);
        $spd = $this->spd->findBy('id', '=', $id, ['*'], ['unitKerja', 'spdRincian.kegiatan', 'bendaharaPengeluaran', 'kuasaBud']);
        $unitKerja = strtolower(str_replace(' ', '_', $spd->unitKerja->nama_unit));

        if ($spd->nomor_otomatis) {
            $nomorFix = nomor_fix($prefixPenomoran, $spd->nomor, $spd->kode_unit_kerja);
            $spd->nomorfix = $nomorFix;
        } else {
            $spd->nomorfix = $spd->nomor;
        }

        $spd->total_nominal = $spd->spdRincian->sum('nominal');

        $rba = $this->rba->getRba221($spd->kode_unit_kerja, auth()->user()->status, Rba::KODE_RBA_221);

        $totalAnggaran = $rba->sum(function ($item) {
            return $item->rincianSumberDana->sum('nominal');
        });

        $this->spd->makeModel();

        $whereSpd = function ($query) use ($spd) {
            $query->where('kode_unit_kerja', $spd->kode_unit_kerja);
        };
        $allSpd = $this->spd->get(['*'], $whereSpd, ['spdRincian']);

        $totalSpd = $allSpd->sum(function ($item) {
            return $item->spdRincian->sum('nominal');
        });

        $this->spd->makeModel();

        $whereSpd = function ($query) use ($spd) {
            $query->where('kode_unit_kerja', $spd->kode_unit_kerja);
            $query->where('tanggal', '<', $spd->tanggal);
        };
        $spdBefore = $this->spd->get(['*'], $whereSpd, ['spdRincian']);

        $totalSpdBefore = $spdBefore->sum(function ($item) {
            return $item->spdRincian->sum('nominal');
        });

        $pdf = PDF::loadview('admin.report.form_spd', compact('spd', 'totalAnggaran', 'totalSpd', 'totalSpdBefore'));
        return $pdf->stream('report-spd-'.$unitKerja.'.pdf', ['Attachment' => false]);
    }

    /**
     * Get sisa SPD
     *
     * @return void
     */
    public function getSisaSpd(Request $request)
    {
        $unitKerja = $request->unit_kerja;
        $rba = $this->rba->getRba221($unitKerja, auth()->user()->status, Rba::KODE_RBA_221);
       
        $totalNominal = $rba->sum(function ($item) {
            return $item->rincianSumberDana->sum('nominal');
        });

        $whereSpd = function ($query) use($unitKerja){
            $query->where('kode_unit_kerja', $unitKerja);
        };

        $spd = $this->spd->get(['*'], $whereSpd, ['spdRincian']);

        $totalSpd = $spd->sum(function ($item){
            return $item->spdRincian->sum('nominal');
        });

        $response = [
            'data' => $totalNominal - $totalSpd
        ];

        return response()->json($response, 200);
    }
}

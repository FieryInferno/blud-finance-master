<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\PrefixPenomoran;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Controllers\Controller;
use App\Http\Requests\Pendapatan\StsRequest;
use App\Repositories\BKU\BKURincianRepository;
use App\Repositories\DataDasar\SumberDanaRepository;
use App\Repositories\Organisasi\PejabatUnitRepository;
use App\Repositories\Organisasi\RekeningBendaharaRepository;
use App\Repositories\Organisasi\UnitKerjaRepository;
use App\Repositories\Penerimaan\STSRepository;
use App\Repositories\Penerimaan\STSRincianRepository;
use App\Repositories\Penerimaan\STSSumberDanaRepository;

use App\Repositories\PrefixPenomoranRepository;

class StsController extends Controller
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
     * @var PrefixPenomoranRepository
     */
    private $prefixPenomoran;

    /**
     * Sumber dana Repository
     * 
     * @var SumberDanaRepository
     */
    private $sumberDana;

    /**
     * Sumber dana Repository
     * 
     * @var PejabatUnitRepository
     */
    private $pejabatUnit;

    /**
     * Sts repository.
     * 
     * @var STSRepository
     */
    private $sts;

    /**
     * Sts rincian repository.
     * 
     * @var STSRincianRepository
     */
    private $stsRincian;

    /**
     * Sts sumber dana repository.
     * 
     * @var STSSumberDanaRepository
     */
    private $stsSumberDana;

    /**
     * Sts sumber dana repository.
     * 
     * @var RekeningBendaharaRepository
     */
    private $rekeningBendahara;

    /**
     * Bku rincian repository.
     * 
     * @var BKURincianRepository
     */
    private $bkuRincian;

    /**
     * Constructor.
     */
    public function __construct(
        UnitKerjaRepository $unitKerja, 
        STSRepository $sts,
        STSRincianRepository $stsRincian,
        STSSumberDanaRepository $stsSumberDana,
        PrefixPenomoranRepository $prefixPenomoran,
        SumberDanaRepository $sumberDana,
        PejabatUnitRepository $pejabatUnit,
        RekeningBendaharaRepository $rekeningBendahara,
        BKURincianRepository $bkuRincian
    )
    {
        $this->unitKerja = $unitKerja;
        $this->sts = $sts;
        $this->stsRincian = $stsRincian;
        $this->stsSumberDana = $stsSumberDana;
        $this->prefixPenomoran = $prefixPenomoran;
        $this->sumberDana = $sumberDana;
        $this->pejabatUnit = $pejabatUnit;
        $this->rekeningBendahara = $rekeningBendahara;
        $this->bkuRincian = $bkuRincian;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $prefix = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_STS);
        $this->prefixPenomoran->makeModel();
        $prefixNl = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_STSNL);
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
        $sts = $this->sts->get(['*'], $where, ['unitKerja']);

        $prefixPenomoran = explode('/', $prefix->format_penomoran);
        $prefixPenomoranNl = explode('/', $prefixNl->format_penomoran);
        
        $sts->map(function ($item) use ($prefixPenomoran, $prefixPenomoranNl) {

            $item->total_nominal = $item->sumberDanaSts->sum('nominal');
            if ($item->nomor_otomatis) {
                if ($item->nl){
                    $nomorFix = nomor_fix($prefixPenomoranNl, $item->nomor, $item->kode_unit_kerja);
                }else {
                    $nomorFix = nomor_fix($prefixPenomoran, $item->nomor, $item->kode_unit_kerja);

                }
                $item->nomorfix = $nomorFix;
            } else {
                $item->nomorfix = $item->nomor;
            }

        });

        $totalAllSts = $sts->sum(function($item){
            return $item->sumberDanaSts->sum('nominal');
        });
        return view('admin.sts.index', compact('sts', 'prefix', 'totalAllSts', 'unitKerja'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sumberDana =$this->sumberDana->get();
        if (auth()->user()->hasRole('Admin')) {
            $unitKerja = $this->unitKerja->get();
        } else {
            $where = function ($query) {
                $query->where('kode', auth()->user()->kode_unit_kerja);
            };
            $unitKerja = $this->unitKerja->get(['*'], $where);
        }
        return view('admin.sts.create', compact('unitKerja', 'sumberDana'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StsRequest $request)
    {
        try {
            DB::beginTransaction();

            $nomorOtomatis = true;
            if (!$request->nomor) {
                $sts = $this->sts->getLatsStsNL($request->unit_kerja);
                if ($sts) {
                    $nomor = $sts->nomor + 1;
                } else {
                    $nomor = 1;
                }
            } else {
                $nomor = $request->nomor;
                $nomorOtomatis = false;
            }

            $sts = $this->sts->create([
                'nomor' => $nomor,
                'tanggal' => $request->tanggal,
                'kode_unit_kerja' => $request->unit_kerja,
                'keterangan' => $request->keterangan,
                'rekening_bendahara_id' => $request->rekening_bendahara,
                'kepala_skpd' => $request->kepala_skpd,
                'bendahara_penerima' => $request->bendahara_penerima,
                'nomor_otomatis' => $nomorOtomatis,
                'nl' => true
            ]);

            if (!$sts) {
                throw new Exception("Error create sts");
            }

            foreach ($request->kode_akun as $key => $value) {
                $rincianSts = $this->stsRincian->create([
                    'sts_id' => $sts->id,
                    'kode_akun' => $request->kode_akun[$key],
                    'nominal' => parse_format_number($request->tarif[$key])
                ]);

                if (!$rincianSts) {
                    throw new Exception("Error create rincian sts");
                }
            }

            foreach ($request->sumber_dana as $key => $value) {
                $stsSumberDana = $this->stsSumberDana->create([
                    'sts_id' => $sts->id,
                    'kode_akun' => $request->kode_rekening_sumber_dana[$key],
                    'sumber_dana_id' => $request->sumber_dana[$key],
                    'nominal' => parse_format_number($request->nominal[$key])
                ]);
                if (!$stsSumberDana) {
                    throw new Exception("Error create sumber dana sts");
                }
            }

            DB::commit();
            return response()->json(['status' => 'oke', 'tbp' => $sts], 200);

        } catch (\Exception $e) {
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
        $prefix = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_STS);
        $prefixPenomoran = explode('/', $prefix->format_penomoran);
        $sts = $this->sts->findBy('id', '=', $id, ['*'], ['unitKerja', 'rekeningBendahara', 'rincianSts.akun', 'kepalaSkpd', 'bendaharaPenerima']);

        $nomorFix = nomor_fix($prefixPenomoran, $sts->nomor, $sts->kode_unit_kerja);
        if ($sts->nomor_otomatis) {
            $sts->nomorfix = $nomorFix;
        } else {
            $sts->nomorfix = $sts->nomor;
        }

        $sumberDana = $this->sumberDana->get();

        if (auth()->user()->hasRole('Admin')) {
            $unitKerja = $this->unitKerja->get();
        } else {
            $where = function ($query) {
                $query->where('kode', auth()->user()->kode_unit_kerja);
            };
            $unitKerja = $this->unitKerja->get(['*'], $where);
        }

        $wherePejabatUnit = function ($query) use($sts){
            $query->where('kode_unit_kerja', $sts->kode_unit_kerja);
        };

        $pejabatUnit = $this->pejabatUnit->get(['*'], $wherePejabatUnit);

        $whereBendahara = function ($query) use ($sts) {
            $query->where('kode_unit_kerja', $sts->kode_unit_kerja);
        };
        $rekeningBendahara = $this->rekeningBendahara->get(['*'], $whereBendahara);

        return view('admin.sts.edit', compact('unitKerja', 'sumberDana', 'sts', 'pejabatUnit', 'rekeningBendahara'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StsRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $sts = $this->sts->find($id);

            if (!$sts) {
                throw new Exception("Tbp not found");
            }

            $this->sts->update([
                'tanggal' => $request->tanggal,
                'kode_unit_kerja' => $request->unit_kerja,
                'keterangan' => $request->keterangan,
                'rekening_bendahara_id' => $request->rekening_bendahara,
                'kepala_skpd' => $request->kepala_skpd,
                'bendahara_penerima' => $request->bendahara_penerima,
                'nl' => true
            ], $id);

            $this->stsRincian->deleteAll($sts->id);
            $this->stsSumberDana->deleteAll($sts->id);

            foreach ($request->kode_akun as $key => $value) {
                $rincianSts = $this->stsRincian->create([
                    'sts_id' => $sts->id,
                    'kode_akun' => $request->kode_akun[$key],
                    'nominal' => parse_format_number($request->tarif[$key])
                ]);

                if (!$rincianSts) {
                    throw new Exception("Error create rincian sts");
                }
            }

            foreach ($request->sumber_dana as $key => $value) {
                $stsSumberDana = $this->stsSumberDana->create([
                    'sts_id' => $sts->id,
                    'kode_akun' => $request->kode_rekening_sumber_dana[$key],
                    'sumber_dana_id' => $request->sumber_dana[$key],
                    'nominal' => parse_format_number($request->nominal[$key])
                ]);
                if (!$stsSumberDana) {
                    throw new Exception("Error create sumber dana tbp");
                }
            }

            DB::commit();
            return response()->json(['status' => 'oke', 'tbp' => $sts], 200);
        } catch (\Exception $e) {
            DB::rollBack();
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
            DB::beginTransaction();
            $sts = $this->sts->find($request->id);

            if (! $sts){
                throw new \Exception('Data tidak ditemukan');
            }

            $this->stsRincian->deleteAll($sts->id);
            $this->stsSumberDana->deleteAll($sts->id);

            $sts->delete();

            DB::commit();
            return redirect()->back()
                ->with(['success' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with(['error' => 'Error hapus STS, STS telah di bku kan']);
        }
    }

    /**
     * Get data sts
     *
     * @return void
     */
    public function getData(Request $request)
    {
        try {
            $prefix = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_STS);
            $prefixPenomoran = explode('/', $prefix->format_penomoran);

            $kodeUnitKerja = $request->kode_unit_kerja;

            $whereBkuRincian = function ($query) {
                $query->whereNotNull('sts_id');
            };
            $bkuRincian = $this->bkuRincian->get(['*'], $whereBkuRincian);
            
            $stsId = $bkuRincian->pluck('sts_id')->unique();

            $whereSts = function ($query) use ($kodeUnitKerja, $stsId) {
                $query->where('tanggal', '<=', date('Y-m-d'))
                    ->where('kode_unit_kerja', $kodeUnitKerja)
                    ->whereNotIn('id', $stsId);
            };

            $sts = $this->sts->get(['*'], $whereSts, ['rincianSts.akun', 'unitKerja']);
            $sts->map(function ($item) use ($prefixPenomoran) {
                
                if ($item->nomor_otomatis) {
                    $nomorFix = nomor_fix($prefixPenomoran, $item->nomor, $item->kode_unit_kerja);
                    $item->nomorfix = $nomorFix;
                } else {
                    $item->nomorfix = $item->nomor;
                }
                $item->total_nominal = $item->sumberDanaSts->sum('nominal');
            });
            $sts = $sts->sortBy('tanggal');

            return response()->json([
                'status_code' => 200,
                'data' => $sts->values()->all(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => $e->getCode(),
                'data' => $e->getMessage(),
            ]);
        }
        
    }

    /**
     * Report Sts By Id
     *
     * @param [type] $id
     * @return void
     */
    public function report($id)
    {
        $sts = $this->sts->findBy('id', '=', $id, ['*'], ['unitKerja', 'rekeningBendahara', 'rincianSts.akun', 'kepalaSkpd', 'bendaharaPenerima']);
        if ($sts->nl){
            $prefix = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_STSNL);
        }else {
            $prefix = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_STS);
        }
        $prefixPenomoran = explode('/', $prefix->format_penomoran);

        if ($sts->nomor_otomatis) {
            $nomorFix = nomor_fix($prefixPenomoran, $sts->nomor, $sts->kode_unit_kerja);
            $sts->nomorfix = $nomorFix;
        } else {
            $sts->nomorfix = $sts->nomor;
        }
        $sts->total_nominal = $sts->sumberDanaSts->sum('nominal');

        // dd($sts);
        $pdf = PDF::loadview('admin.report.form_sts', compact('sts'));
        return $pdf->stream('report-rba.pdf', ['Attachment' => false]); 
    }

    /**
     * Report Sts By Id
     *
     * @param [type] $id
     * @return void
     */
    public function reportExcel($id)
    {
        $prefix = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_STS);
        $prefixPenomoran = explode('/', $prefix->format_penomoran);
        $sts = $this->sts->findBy('id', '=', $id, ['*'], ['unitKerja', 'rekeningBendahara', 'rincianSts.akun', 'kepalaSkpd', 'bendaharaPenerima']);

        if ($sts->nomor_otomatis) {
            $nomorFix = nomor_fix($prefixPenomoran, $sts->nomor, $sts->kode_unit_kerja);
            $sts->nomorfix = $nomorFix;
        } else {
            $sts->nomorfix = $sts->nomor;
        }
        $sts->total_nominal = $sts->sumberDanaSts->sum('nominal');

        $contents = \View::make('admin.report.form_sts_excel')->with('sts', $sts);
        return \Response::make($contents, 200)
            ->header('Content-Type', 'application/vnd-ms-excel')
            ->header('Content-Disposition', 'attachment; filename=report_sts.xls');
    }
}

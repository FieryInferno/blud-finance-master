<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\PrefixPenomoran;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Pendapatan\TbpRequest;
use App\Repositories\DataDasar\SumberDanaRepository;
use App\Repositories\Organisasi\PejabatUnitRepository;
use App\Repositories\Organisasi\RekeningBendaharaRepository;
use App\Repositories\Penerimaan\TBPRepository;
use App\Repositories\Organisasi\UnitKerjaRepository;
use App\Repositories\Penerimaan\STSRepository;
use App\Repositories\Penerimaan\STSRincianRepository;
use App\Repositories\Penerimaan\STSSumberDanaRepository;
use App\Repositories\Penerimaan\TBPRincianRepository;
use App\Repositories\Penerimaan\TBPSumberDanaRepository;
use App\Repositories\PrefixPenomoranRepository;
use Illuminate\Support\Facades\Auth;

class TbpController extends Controller
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
     * @var TBPRepository
     */
    private $tbp;

    /**
     * Unit kerja repository.
     * 
     * @var TBPRincianRepository
     */
    private $tbpRincian;

    /**
     * Unit kerja repository.
     * 
     * @var TBPSumberDanaRepository
     */
    private $tbpSumberDana;

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
     * Constructor.
     */
    public function __construct(
        UnitKerjaRepository $unitKerja, 
        TBPRepository $tbp,
        TBPRincianRepository $tbpRincian,
        TBPSumberDanaRepository $tbpSumberDana,
        STSRepository $sts,
        STSRincianRepository $stsRincian,
        STSSumberDanaRepository $stsSumberDana,
        PrefixPenomoranRepository $prefixPenomoran,
        SumberDanaRepository $sumberDana,
        PejabatUnitRepository $pejabatUnit,
        RekeningBendaharaRepository $rekeningBendahara
    )
    {
        $this->unitKerja = $unitKerja;
        $this->tbp = $tbp;
        $this->tbpRincian = $tbpRincian;
        $this->tbpSumberDana = $tbpSumberDana;
        $this->sts = $sts;
        $this->stsRincian = $stsRincian;
        $this->stsSumberDana = $stsSumberDana;
        $this->prefixPenomoran = $prefixPenomoran;
        $this->sumberDana = $sumberDana;
        $this->pejabatUnit = $pejabatUnit;
        $this->rekeningBendahara = $rekeningBendahara;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $prefix = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_TBP);
        $unitKerja = $this->unitKerja->get();
        
        $where = function ($query) use ($request){
            if (! auth()->user()->hasRole('Admin')) { 
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
        
        $tbp = $this->tbp->get(['*'], $where, ['unitKerja']);
        $prefixPenomoran = explode('/', $prefix->format_penomoran);
        $tbp->map(function ($item) use($prefixPenomoran){
            
            $item->total_nominal = $item->sumberDanaTbp->sum('nominal');
            if ($item->nomor_otomatis) {
                $nomorFix = nomor_fix($prefixPenomoran, $item->nomor, $item->kode_unit_kerja);
                $item->nomorfix = $nomorFix;
            } else {
                $item->nomorfix = $item->nomor;
            }

        });

        $totalAllTbp = $tbp->sum(function ($item){
            return  $item->sumberDanaTbp->sum('nominal');
        });

        return view('admin.tbp.index', compact('tbp', 'prefix', 'totalAllTbp', 'unitKerja'));
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
        return view('admin.tbp.create', compact('unitKerja', 'sumberDana'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TbpRequest $request)
    {
        try {
            DB::beginTransaction();
            
            $nomorOtomatis = true;
            if ( ! $request->nomor){
                $tbp = $this->tbp->getLastTbp($request->unit_kerja);
                if ($tbp){
                    $nomor = $tbp->nomor + 1;
                }else {
                    $nomor = 1;
                }
            }else {
                $nomor = $request->nomor;
                $nomorOtomatis = false;
            }
            
            $tbp = $this->tbp->create([
                'nomor' => $nomor, 
                'tanggal' => $request->tanggal, 
                'kode_unit_kerja' => $request->unit_kerja, 
                'keterangan' => $request->keterangan, 
                'rekening_bendahara_id' => $request->rekening_bendahara, 
                'kepala_skpd' => $request->kepala_skpd,
                'bendahara_penerima' => $request->bendahara_penerima,
                'nomor_otomatis' => $nomorOtomatis
            ]);

            if (!$tbp){
                throw new Exception("Error create tbp");
                
            }

            foreach ($request->kode_akun as $key => $value) {
                $rincianTbp = $this->tbpRincian->create([
                    'tbp_id' => $tbp->id, 
                    'kode_akun' => $request->kode_akun[$key], 
                    'nominal' => parse_format_number($request->tarif[$key])
                ]);

                if (!$rincianTbp) {
                    throw new Exception("Error create rincian tbp");
                }
            }

            foreach ($request->sumber_dana as $key => $value) {
                $tbpSumberDana = $this->tbpSumberDana->create([
                    'tbp_id' => $tbp->id,
                    'kode_akun' => $request->kode_rekening_sumber_dana[$key],
                    'sumber_dana_id' => $request->sumber_dana[$key], 
                    'nominal' => parse_format_number($request->nominal[$key])
                ]);
                if (!$tbpSumberDana) {
                    throw new Exception("Error create sumber dana tbp");
                }
            }


            if (!$request->nomor) {
                $sts = $this->sts->getLatsSts($request->unit_kerja);
                if ($sts) {
                    $nomorSts = $sts->nomor + 1;
                } else {
                    $nomorSts = 1;
                }
            } else {
                $nomorSts = $request->nomor;
            }

            $sts = $this->sts->create([
                'nomor' => $nomorSts,
                'tanggal' => $request->tanggal_sts,
                'kode_unit_kerja' => $request->unit_kerja,
                'keterangan' => $request->keterangan,
                'rekening_bendahara_id' => $request->rekening_bendahara,
                'kepala_skpd' => $request->kepala_skpd,
                'bendahara_penerima' => $request->bendahara_penerima,
                'nomor_otomatis' => $nomorOtomatis
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
            return response()->json(['status' => 'oke', 'tbp' => $tbp], 200);

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
        $prefix = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_TBP);
        $prefixPenomoran = explode('/', $prefix->format_penomoran);
        $tbp = $this->tbp->findBy('id', '=', $id, ['*'], ['unitKerja', 'rekeningBendahara', 'rincianTbp.akun', 'kepalaSkpd', 'bendaharaPenerima']);

        if ($tbp->nomor_otomatis){
            $nomorFix = nomor_fix($prefixPenomoran, $tbp->nomor, $tbp->kode_unit_kerja);
            $tbp->nomorfix = $nomorFix;
        }else {
            $tbp->nomorfix = $tbp->nomor;
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

        $wherePejabatUnit = function ($query) use($tbp){
            $query->where('kode_unit_kerja', $tbp->kode_unit_kerja);
        };

        $pejabatUnit = $this->pejabatUnit->get(['*'], $wherePejabatUnit);

        $whereBendahara = function ($query) use($tbp){
            $query->where('kode_unit_kerja', $tbp->kode_unit_kerja);
        };
        $rekeningBendahara = $this->rekeningBendahara->get(['*'], $whereBendahara);

        return view('admin.tbp.edit', compact('unitKerja', 'sumberDana', 'tbp', 'pejabatUnit', 'rekeningBendahara'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TbpRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $tbp = $this->tbp->find($id);
            
            if (! $tbp) {
                throw new Exception("Tbp not found");
                
            }

            $this->tbp->update([
                'tanggal' => $request->tanggal,
                'kode_unit_kerja' => $request->unit_kerja,
                'keterangan' => $request->keterangan,
                'rekening_bendahara_id' => $request->rekening_bendahara,
                'kepala_skpd' => $request->kepala_skpd,
                'bendahara_penerima' => $request->bendahara_penerima,
            ], $id);

            $this->tbpRincian->deleteAll($tbp->id);
            $this->tbpSumberDana->deleteAll($tbp->id);

            foreach ($request->kode_akun as $key => $value) {
                $rincianTbp = $this->tbpRincian->create([
                    'tbp_id' => $tbp->id,
                    'kode_akun' => $request->kode_akun[$key],
                    'nominal' => parse_format_number($request->tarif[$key])
                ]);

                if (!$rincianTbp) {
                    throw new Exception("Error create rincian tbp");
                }
            }

            foreach ($request->sumber_dana as $key => $value) {
                $tbpSumberDana = $this->tbpSumberDana->create([
                    'tbp_id' => $tbp->id,
                    'kode_akun' => $request->kode_rekening_sumber_dana[$key],
                    'sumber_dana_id' => $request->sumber_dana[$key],
                    'nominal' => parse_format_number($request->nominal[$key])
                ]);
                if (!$tbpSumberDana) {
                    throw new Exception("Error create sumber dana tbp");
                }
            }

            DB::commit();
            return response()->json(['status' => 'oke', 'tbp' => $tbp], 200);

        } catch (\Exception $e) {
            DB::rollBack();
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
            DB::beginTransaction();
            $tbp = $this->tbp->find($request->id);

            if (! $tbp){
                throw new \Exception('Data tidak ditemukan');
            }

            $this->tbpRincian->deleteAll($tbp->id);
            $this->tbpSumberDana->deleteAll($tbp->id);

            $deleteTbp = $tbp->delete();

            if (! $deleteTbp){
                throw new \Exception('Harap Hapus Sts Terlebih Dahulu');
            }
            
            DB::commit();
            return redirect()->back()
                ->with(['success' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with(['error' => 'Gagal hapus TBP, harap cek STS yang berhubungan']);
        }
    }

    /**
     * Report tbp by Id
     *
     * @param [type] $id
     * @return void
     */
    public function report($id)
    {
        $prefix = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_TBP);
        $prefixPenomoran = explode('/', $prefix->format_penomoran);
        $tbp = $this->tbp->findBy('id', '=', $id, ['*'], ['unitKerja', 'rekeningBendahara', 'rincianTbp.akun', 'kepalaSkpd', 'bendaharaPenerima']);

        if ($tbp->nomor_otomatis) {
            $nomorFix = nomor_fix($prefixPenomoran, $tbp->nomor, $tbp->kode_unit_kerja);
            $tbp->nomorfix = $nomorFix;
        } else {
            $tbp->nomorfix = $tbp->nomor;
        }
        $tbp->total_nominal = $tbp->sumberDanaTbp->sum('nominal');

        $pdf = PDF::loadview('admin.report.form_tbp', compact('tbp'));
        return $pdf->stream('report-tbp.pdf', ['Attachment' => false]);
    }

    /**
     * Report tbp by Id
     *
     * @param [type] $id
     * @return void
     */
    public function reportExcel($id)
    {
        $prefix = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_TBP);
        $prefixPenomoran = explode('/', $prefix->format_penomoran);
        $tbp = $this->tbp->findBy('id', '=', $id, ['*'], ['unitKerja', 'rekeningBendahara', 'rincianTbp.akun', 'kepalaSkpd', 'bendaharaPenerima']);

        if ($tbp->nomor_otomatis) {
            $nomorFix = nomor_fix($prefixPenomoran, $tbp->nomor, $tbp->kode_unit_kerja);
            $tbp->nomorfix = $nomorFix;
        } else {
            $tbp->nomorfix = $tbp->nomor;
        }
        $tbp->total_nominal = $tbp->sumberDanaTbp->sum('nominal');

        $contents = \View::make('admin.report.form_tbp_excel')->with('tbp', $tbp);
        return \Response::make($contents, 200)
            ->header('Content-Type', 'application/vnd-ms-excel')
            ->header('Content-Disposition', 'attachment; filename=report_tbp.xls');
    }
}

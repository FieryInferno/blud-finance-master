<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\PrefixPenomoran;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Bku\BkuRequest;
use App\Models\Bku;
use App\Repositories\BKU\BKURepository;
use App\Repositories\BKU\BKURincianRepository;
use App\Repositories\PrefixPenomoranRepository;
use App\Repositories\Akutansi\SaldoAwalRepository;
use App\Repositories\Organisasi\UnitKerjaRepository;
use App\Repositories\Organisasi\PejabatUnitRepository;

class BkuController extends Controller
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
     * Unit kerja repository.
     * 
     * @var BkuRepository
     */
    private $bku;

    /**
     * Unit kerja repository.
     * 
     * @var BkuRincianRepository
     */
    private $bkuRincian;

    /**
     * Saldo awal repository
     * 
     * @var SaldoAwalRepository
     */
    private $saldoAwal;

    /**
     * Pejabat unit repository
     * 
     *  @var PejabatUnitRepository
     */
    private $pejabatUnit;

    /**
     * Constructor.
     */
    public function __construct(
        UnitKerjaRepository $unitKerja, 
        PrefixPenomoranRepository $prefixPenomoran,
        BKURepository $bku,
        BKURincianRepository $bkuRincian,
        SaldoAwalRepository $saldoAwal,
        PejabatUnitRepository $pejabatUnit
    )
    {
        $this->unitKerja = $unitKerja;
        $this->prefixPenomoran = $prefixPenomoran;
        $this->bku = $bku;
        $this->bkuRincian = $bkuRincian;
        $this->saldoAwal = $saldoAwal;
        $this->pejabatUnit = $pejabatUnit;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $prefix = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_BKU_PENERIMAAN);
        
        if (auth()->user()->hasRole('Admin')) {
            $bkuRincian = $this->bkuRincian->getBkuRincian($request);

        } else {
            $where = function ($query) {
                $query->where('kode_unit_kerja', auth()->user()->kode_unit_kerja);
            };
            $bkuRincian = $this->bkuRincian->getBkuRincian($request, auth()->user()->kode_unit_kerja);
        }
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
        $bku = $this->bku->get(['*'], $where, ['unitKerja', 'bkuRincian']);
        $prefixPenomoran = explode('/', $prefix->format_penomoran);
        $bku->map(function ($item) use ($prefixPenomoran) {
            
            
            $item->total_penerimaan = $item->bkuRincian->sum('penerimaan');
            $item->total_pengeluaran = $item->bkuRincian->sum('pengeluaran');
            
            if ($item->nomor_otomatis){
                $nomorFix = nomor_fix($prefixPenomoran, $item->nomor, $item->kode_unit_kerja);
                $item->nomorfix = $nomorFix;
            }else {
                $item->nomorfix = $item->nomor;
            }

        });

        $totalSts = 0;
        $totalSp2d = 0;
        $totalSetorPajak = 0;
        foreach ($bkuRincian as $value) {
            if (! is_null($value->sts_id)){
                $totalSts += $value->penerimaan;
            }else if (! is_null($value->sp2d_id)){
                $totalSp2d += $value->pengeluaran;
            }else if (! is_null($value->setor_pajak_pajak_id)){
                $totalSetorPajak += $value->pengeluaran;
            }
        }
        
        return view('admin.bku.index', compact(
            'bku', 'prefix', 'totalSts', 'totalSp2d', 'totalSetorPajak', 'unitKerja'
        ));
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
        return view('admin.bku.create', compact('unitKerja'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BkuRequest $request)
    {
        try {
            DB::beginTransaction();

            $nomorOtomatis = true;
            if (!$request->nomor) {
                $bku = $this->bku->getLastBku($request->unit_kerja);
                if ($bku) {
                    $nomor = $bku->nomor + 1;
                } else {
                    $nomor = 1;
                }
            } else {
                $nomor = $request->nomor;
                $nomorOtomatis = false;
            }

            $bku = $this->bku->create([
                'nomor' => $nomor,
                'tanggal' => $request->tanggal_bku,
                'kode_unit_kerja' => $request->unit_kerja,
                'keterangan' => $request->keterangan,
                'nomor_otomatis' => $nomorOtomatis
            ]);

            if (!$bku) {
                throw new Exception("Error create tbp");
            }

            foreach ($request->tipe as $key => $value) {
                $stsId = isset($request->sts_id[$key]) ? $request->sts_id[$key] : null;
                $sp2dId = isset($request->sp2d_id[$key]) ? $request->sp2d_id[$key] : null;
                $setorPajakId = isset($request->setor_pajak_id[$key]) ? $request->setor_pajak_id[$key] : null;
                $kontraposId = isset($request->kontrapos_id[$key]) ? $request->kontrapos_id[$key] : null;
                $penerimaan = isset($request->setor_pajak_id[$key]) ? parse_format_number($request->pengeluaran[$key]) : parse_format_number($request->penerimaan[$key]);
                $pengeluaran = parse_format_number($request->pengeluaran[$key]);
                
                $rincianBku = $this->bkuRincian->create([
                    'bku_id' => $bku->id,
                    'no_aktivitas' => $request->no_aktivitas[$key], 
                    'tipe' => $request->tipe[$key],
                    'sts_id' => $stsId,
                    'sp2d_id' => $sp2dId,
                    'setor_pajak_pajak_id' => $setorPajakId,
                    'kontrapos_id' => $kontraposId,
                    'tanggal' => $request->tanggal[$key], 
                    'penerimaan' => $penerimaan, 
                    'pengeluaran'  => $pengeluaran, 
                    'kode_unit_kerja' => $request->kode_unit_kerja[$key]
                ]);

                if (!$rincianBku) {
                    throw new Exception("Error create rincian tbp");
                }
            }

            DB::commit();
            return response()->json(['status' => 'oke', 'bku' => $bku], 200);

        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'data' => $e->getMessage(),
                'line' => $e->getLine()
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
        $prefix = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_BKU_PENERIMAAN);
        $prefixPenomoran = explode('/', $prefix->format_penomoran);
        $bku = $this->bku->findBy('id', '=', $id, ['*'], ['unitKerja', 'bkuRincian.unitKerja']);

        if ($bku->nomor_otomatis) {
            $nomorFix = nomor_fix($prefixPenomoran, $bku->nomor, $bku->kode_unit_kerja);
            $bku->nomorfix = $nomorFix;
        } else {
            $bku->nomorfix = $bku->nomor;
        }

        $unitKerja = $this->unitKerja->get();

        return view('admin.bku.edit', compact('unitKerja', 'bku'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BkuRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            if (!$request->nomor) {
                $bku = $this->bku->getLastBku($request->unit_kerja);
                if ($bku) {
                    $nomor = $bku->nomor + 1;
                } else {
                    $nomor = 1;
                }
            } else {
                $nomor = $request->nomor;
            }

            $this->bku->update([
                'tanggal' => $request->tanggal_bku,
                'kode_unit_kerja' => $request->unit_kerja,
                'keterangan' => $request->keterangan,
            ], $id);

            $this->bkuRincian->deleteAll($id);

            foreach ($request->tipe as $key => $value) {
                $stsId = isset($request->sts_id[$key]) ? $request->sts_id[$key] : null;
                $sp2dId = isset($request->sp2d_id[$key]) ? $request->sp2d_id[$key] : null;
                $setorPajakId = isset($request->setor_pajak_id[$key]) ? $request->setor_pajak_id[$key] : null;
                $kontraposId = isset($request->kontrapos_id[$key]) ? $request->kontrapos_id[$key] : null;
                $penerimaan = isset($request->setor_pajak_id[$key]) ? parse_format_number($request->pengeluaran[$key]) : parse_format_number($request->penerimaan[$key]);
                $pengeluaran = parse_format_number($request->pengeluaran[$key]);
                $rincianBku = $this->bkuRincian->create([
                    'bku_id' => $id,
                    'no_aktivitas' => $request->no_aktivitas[$key],
                    'tipe' => $request->tipe[$key],
                    'sts_id' => $stsId,
                    'sp2d_id' => $sp2dId,
                    'setor_pajak_pajak_id' => $setorPajakId,
                    'kontrapos_id' => $kontraposId,
                    'tanggal' => $request->tanggal[$key],
                    'penerimaan' => $penerimaan,
                    'pengeluaran'  => $pengeluaran,
                    'kode_unit_kerja' => $request->kode_unit_kerja[$key]
                ]);

                if (!$rincianBku) {
                    throw new Exception("Error create rincian tbp");
                }
            }

           
            DB::commit();
            return response()->json(['status' => 'oke', 'bku' => 'success'], 200);

        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'data' => $e->getMessage(),
                'line' => $e->getLine()
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
            $bku = $this->bku->find($request->id);

            if (!$bku) {
                throw new \Exception('Data tidak ditemukan');
            }

            $this->bkuRincian->deleteAll($bku->id);

            $bku->delete();

            return redirect()->back()
                ->with(['success' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with(['error' => $e->getMessage()]);
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
        $prefix = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_BKU_PENERIMAAN);
        $prefixPenomoran = explode('/', $prefix->format_penomoran);
        $bku = $this->bku->findBy('id', '=', $id, ['*'], [
            'unitKerja', 'bkuRincian.unitKerja', 'bkuRincian.sts.unitKerja', 'bkuRincian.sp2d.unitKerja', 
            'bkuRincian.setorPajak.pajak', 'bkuRincian.kontrapos.unitKerja'
            ]);

        $where = function ($query) use($bku) {
            $query->where('kode_unit_kerja', $bku->kode_unit_kerja);
        };
        $saldoAwal = $this->saldoAwal->get(['*'], $where, ['saldoAwalRincian']);

        $saldoAwal = $saldoAwal->sum(function ($item) {
            return $item->saldoAwalRincian->sum('debet');
        });

        if ($bku->nomor_otomatis) {
            $nomorFix = nomor_fix($prefixPenomoran, $bku->nomor, $bku->kode_unit_kerja);
            $bku->nomorfix = $nomorFix;

        } else {
            $bku->nomorfix = $bku->nomor;
        }

        $totalPenerimaan = 0;
        $totalPengeluaran = 0;

        foreach ($bku->bkuRincian as $value) {
            $totalPenerimaan += $value->penerimaan;
            $totalPengeluaran += $value->pengeluaran;
        }

        $datetime = new \DateTime($bku->tanggal);
        $yesterday = date('Y-m-d', strtotime('yesterday', strtotime($bku->tanggal)));
        $bku->yesterday = $yesterday;

        $date = Carbon::createFromDate(date('Y'), date('m'), date('d'));
        $startOfYear = $date->copy()->startOfYear()->format('Y-m-d');

        $bkuYesterDay = $this->bku->reportBku($bku->kode_unit_kerja, $startOfYear, $bku->yesterday);
        $bkuToday = $this->bku->reportBku($bku->kode_unit_kerja, $startOfYear, $bku->tanggal);
       
        $totalPenerimaanYesterday = $bkuYesterDay->sum(function ($item) {
            return $item->bkuRincian->sum('penerimaan');
        });

        $totalPengeluaranYesterday = $bkuYesterDay->sum(function ($item) {
            return $item->bkuRincian->sum('pengeluaran');
        });

        $totalPenerimaanToday = $bkuToday->sum(function ($item) {
            return $item->bkuRincian->sum('penerimaan');
        });

        $totalPengeluaranToday = $bkuToday->sum(function ($item) {
            return $item->bkuRincian->sum('pengeluaran');
        });

        $kontraPos = 0;

        $pejabat = $this->pejabatUnit->getAllPejabat($bku->kode_unit_kerja);
        $ppk = clone $pejabat;
        $ppk = $ppk->where('jabatan_id', 2)->first();
        
        $pdf = PDF::loadview('admin.report.form_bku', compact(
            'bku', 'totalPenerimaan', 'totalPengeluaran', 'totalPenerimaanYesterday', 'totalPengeluaranYesterday',
            'totalPenerimaanToday', 'totalPengeluaranToday', 'saldoAwal', 'ppk'
        ));
        return $pdf->stream('report-bku.pdf', ['Attachment' => false]);
    }

    /**
     * Report tbp by Id
     *
     * @param [type] $id
     * @return void
     */
    public function reportExcel($id)
    {
        $prefix = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_BKU_PENERIMAAN);
        $prefixPenomoran = explode('/', $prefix->format_penomoran);
        $bku = $this->bku->findBy('id', '=', $id, ['*'], ['unitKerja', 'bkuRincian.unitKerja', 'bkuRincian.sts.unitKerja']);

        if ($bku->nomor_otomatis) {
            $nomorFix = nomor_fix($prefixPenomoran, $bku->nomor, $bku->kode_unit_kerja);
            $bku->nomorfix = $nomorFix;

        } else {
            $bku->nomorfix = $bku->nomor;
        }

        $datetime = new \DateTime('yesterday');
        $bku->yesterday = $datetime->format('Y-m-d');

        $contents = \View::make('admin.report.form_bku_excel')->with('bku', $bku);
        return \Response::make($contents, 200)
            ->header('Content-Type', 'application/vnd-ms-excel')
            ->header('Content-Disposition', 'attachment; filename=report_bku.xls');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Models\Rba;
use Illuminate\Http\Request;
use App\Models\PrefixPenomoran;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repositories\RBA\RBARepository;
use App\Http\Requests\Belanja\SppRequest;
use App\Repositories\Belanja\SPDRepository;
use App\Repositories\Belanja\SPPRepository;
use App\Repositories\Belanja\BASTRepository;
use App\Repositories\Belanja\SP2DRepository;
use App\Repositories\DataDasar\AkunRepository;
use App\Repositories\Penerimaan\STSRepository;
use App\Repositories\DataDasar\PajakRepository;
use App\Repositories\PrefixPenomoranRepository;
use App\Repositories\Belanja\SPPPajakRepository;
use App\Repositories\Belanja\SP2DPajakRepository;
use App\Repositories\Akutansi\SaldoAwalRepository;
use App\Repositories\Belanja\SPDRincianRepository;
use App\Repositories\Organisasi\UnitKerjaRepository;
use App\Repositories\DataDasar\PihakKetigaRepository;
use App\Repositories\Organisasi\PejabatUnitRepository;
use App\Repositories\Belanja\SetorPajakPajakRepository;
use App\Repositories\Belanja\SPPReferensiSpdRepository;
use App\Repositories\Organisasi\RekeningBendaharaRepository;
use App\Repositories\Belanja\SPPPajakNoBillingRepository;
use Illuminate\Support\Facades\Auth;

class SPPController extends Controller
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
     * SPP Repository
     * 
     * @var SPPRepository
     */
    private $spp;

    /**
     * SPP Pajak Repository
     * 
     * @var SPPPajakRepository
     */
    private $sppPajak;
    
    /**
     * SPP Referensi Spd Repository
     * 
     * @var SPPPReferensiSpdRepository
     */
    private $sppSpd;

    /**
     * SP2D Repository
     * 
     * @var SP2DRepository
     */
    private $sp2d;

    /**
     * SP2D Pajak Repository
     * 
     * @var SP2DajakRepository
     */
    private $sp2dPajak;

    /**
     * SetorPajak Repository
     * 
     * @var SetorPajakRepository
     */
    private $setorPajak;

    /**
     * SetorPajak Pajak Repository
     * 
     * @var SetorPajakPajakRepository
     */
    private $setorPajakPajak;

    /**
     * SPD Repository
     * 
     * @var SPDRepository
     */
    private $spd;

    /**
     * SPD Repository
     * 
     * @var SPDRincianRepository
     */
    private $spdRincian;

    /**
     * STS Repository
     * 
     * @var STSRepository
     */
    private $sts;

    /**
     * RBA Repository
     * 
     * @var RBARepository
     */
    private $rba;

    /**
     * PAJAK Repository
     * 
     * @var PAJAKRepository
     */
    private $pajak;

    /**
     * PAJAK Repository
     * 
     * @var PrefixPenomoranRepository
     */
    private $prefixPenomoran;

    /**
     * Rekening Bendahara Repository
     * 
     * @var RekeningBendaharaRepository
     */
    private $rekeningBendahara;

    /**
     * Pejabat unit Repository
     *
     * @var PejabatUnitRepository
     */
    private $pejabatUnit;

    /**
     * Pihak Ketiga Repository
     *
     * @var PihakKetigaRepository
     */
    private $pihakKetiga;

    /**
     * Akun Repository
     *
     * @var AkunRepository
     */
    private $akun;

    /**
     * Saldo awal repository
     *
     * @var SaldoAwalRepository
     */
    private $saldoAwal;

    /**
     * SPP Pajak No Billing Repository
     *
     * @var SPPPajakNoBillingRepository
     */
    private $sppPajakNoBilling;

    /**
     * Constructor.
     */
    public function __construct(
        UnitKerjaRepository $unitKerja,
        BASTRepository $bast,
        SPPRepository $spp,
        SPDRepository $spd,
        SPDRincianRepository $spdRincian,
        STSRepository $sts,
        RBARepository $rba,
        PajakRepository $pajak,
        SPPPajakRepository $sppPajak,
        SPPReferensiSpdRepository $sppSpd,
        PrefixPenomoranRepository $prefixPenomoran,
        SP2DRepository $sp2d,
        SP2DPajakRepository $sp2dPajak,
        SetorPajakPajakRepository $setorPajak,
        SetorPajakPajakRepository $setorPajakPajak,
        RekeningBendaharaRepository $rekeningBendahara,
        PejabatUnitRepository $pejabatUnit,
        PihakKetigaRepository $pihakKetiga,
        AkunRepository $akun,
        SaldoAwalRepository $saldoAwal,
        SPPPajakNoBillingRepository $sppPajakNoBilling
    ) {
        $this->unitKerja = $unitKerja;
        $this->bast = $bast;
        $this->spp = $spp;
        $this->spd = $spd;
        $this->spdRincian = $spdRincian;
        $this->sts = $sts;
        $this->rba = $rba;
        $this->pajak = $pajak;
        $this->sppPajak = $sppPajak;
        $this->sppSpd = $sppSpd;
        $this->prefixPenomoran = $prefixPenomoran;
        $this->sp2d = $sp2d;
        $this->sp2dPajak = $sp2dPajak;
        $this->setorPajak = $setorPajak;
        $this->setorPajakPajak = $setorPajakPajak;
        $this->rekeningBendahara = $rekeningBendahara;
        $this->pejabatUnit = $pejabatUnit;
        $this->pihakKetiga = $pihakKetiga;
        $this->akun = $akun;
        $this->saldoAwal = $saldoAwal;
        $this->sppPajakNoBilling = $sppPajakNoBilling;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $prefix = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_SPP);
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
        $spp = $this->spp->get(['*'], $where, ['unitKerja', 'bast.kegiatan']);

        $prefixPenomoran = explode('/', $prefix->format_penomoran);
        $spp->map(function ($item) use ($prefixPenomoran) {
            if ($item->nomor_otomatis) {
                $nomorFix = nomor_fix($prefixPenomoran, $item->nomor, $item->kode_unit_kerja);
                $item->nomorfix = $nomorFix;
            } else {
                $item->nomorfix = $item->nomor;
            }
        });
        
        return view('admin.spp.index', compact('spp', 'unitKerja'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pajak = $this->pajak->get(['*'], null, ['akun']);

        if (auth()->user()->hasRole('Admin')) {
            $unitKerja = $this->unitKerja->get();
        } else {
            $where = function ($query) {
                $query->where('kode', auth()->user()->kode_unit_kerja);
            };
            $unitKerja = $this->unitKerja->get(['*'], $where);
        }

        return view('admin.spp.create', compact('unitKerja', 'pajak'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SppRequest $request)
    {
        try {
            DB::beginTransaction();

            $nomorOtomatis = true;

            if (!$request->nomor) {
                $spp = $this->spp->getLastSpp($request->unit_kerja);
                if ($spp) {
                    $nomor = $spp->nomor + 1;
                } else {
                    $nomor = 1;
                }
            } else {
                $nomor = $request->nomor;
                $nomorOtomatis = false;
            }

            $spp = $this->spp->create([
                'nomor' => $nomor,
                'nomor_otomatis' => $nomorOtomatis,
                'tanggal' => $request->tanggal,
                'kode_unit_kerja' => $request->unit_kerja,
                'bast_id' => $request->bast,
                'sisa_spd_total' => parse_format_number($request->sisa_spd_total),
                'sisa_spd_kegiatan' => parse_format_number($request->sisa_spd_kegiatan),
                'sisa_kas' => parse_format_number($request->sisa_kas),
                'sisa_pagu_pengajuan' => parse_format_number($request->sisa_pagu_pengajuan),
                'keterangan' => $request->keterangan,
                'pihak_ketiga_id' => $request->pihak_ketiga,
                'bendahara_pengeluaran' => $request->bendahara_pengeluaran,
                'pptk' => $request->pptk,
                'akun_bendahara' => $request->akun_bendahara,
                'pemimpin_blud' => $request->pemimpin_blud,
                'nominal_sumber_dana' => $request->nominal_sumber_dana
            ]);

            if (! $spp){
                throw new \Exception('Error create spp');
            }

            if ($request->pajak_id){
                for($i = 0; $i < count($request->pajak_id); $i++){
                    $information = false;
                    if (isset($request->pungutan_pajak_informasi[$i])){
                        $information = true;
                    }
                    $sppPajak = $this->sppPajak->create([
                        'spp_id' => $spp->id,
                        'pajak_id' => $request->pajak_id[$i],
                        'nominal' => parse_format_number($request->nominal_pajak[$i]),
                        'is_information' => $information
                    ]);

                    if (! $sppPajak){
                        throw new \Exception('Error create spp pajak');
                    }
                    $pajakId = $request->pajak_id[$i];

                    //TODO:Cek request billing ? 
                    $billingData = $request->billing[$pajakId];
                    foreach($billingData as $bill) {
                        if($bill) {
                            $attributes = [
                                'spp_pajak_id' => $sppPajak->id,
                                'no_billing' => $bill
                            ];
                            
                            $createBilling = $this->sppPajakNoBilling->create($attributes);

                            if( ! $createBilling) {
                                throw new \Exception('Error create spp pajak no billing');
                            }
                        }
                    }
                }
            }

            for ($i = 0; $i < count($request->spd_id); $i++) {
                $sppSpd = $this->sppSpd->create([
                    'spp_id' => $spp->id,
                    'spd_id' => $request->spd_id[$i]
                ]);

                if (!$sppSpd) {
                    throw new \Exception('Error create spp referensi spd');
                }
            }

            DB::commit();
            return response()->json(['status' => 'oke', 'spd' => $spp], 200);
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
        $prefix = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_SPP);
        $prefixPenomoran = explode('/', $prefix->format_penomoran);
        $this->prefixPenomoran->makeModel();
        $spp = $this->spp->find($id, ['*'], ['bast.rincianPengadaan.akun', 'bast.kegiatan', 'referensiPajak.pajak.akun', 'referensiSpd.spd.spdRincian', 'referensiPajak.noBilling']);
        
        $selectedPajak = [];
        foreach ($spp->referensiPajak as $key => $value) {
            $selectedPajak[] =  $value->pajak->id;
        }

        if ($spp->nomor_otomatis) {
            $nomorFix = nomor_fix($prefixPenomoran, $spp->nomor, $spp->kode_unit_kerja);
            $spp->nomorfix = $nomorFix;
        } else {
            $spp->nomorfix = $spp->nomor;
        }

        $prefix = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_SPD);
        $prefixPenomoran = explode('/', $prefix->format_penomoran);

        foreach ($spp->referensiSpd as $value) {
            if ($value->spd->nomor_otomatis) {
                $nomorFix = nomor_fix($prefixPenomoran, $value->spd->nomor, $value->spd->kode_unit_kerja);
                $value->spd->nomorfix = $nomorFix;
            } else {
                $value->spd->nomorfix = $value->spd->nomor;
            }
            $value->spd->total = $value->spd->spdRincian->sum('nominal');
        }
        

        $where = function ($query) use ($spp) {
            $query->where('kode_unit_kerja', $spp->kode_unit_kerja);
        };

        $pejabatUnit = $this->pejabatUnit->get(['*'], $where);

        $rekeningBendahara = $this->rekeningBendahara->get(['*'], $where);

        if (auth()->user()->hasRole('Admin')) {
            $unitKerja = $this->unitKerja->get();
        } else {
            $where = function ($query) {
                $query->where('kode_unit_kerja', auth()->user()->kode_unit_kerja);
            };
            $whereUnitKerja = function ($query) {
                $query->where('kode', auth()->user()->kode_unit_kerja);
            };
            $unitKerja = $this->unitKerja->get(['*'], $whereUnitKerja);
        }

        $pajak = $this->pajak->get(['*'], null, ['akun']);

        $bast = $this->bast->get(['*'], $where, ['kegiatan']);

        $pihakKetiga = $this->pihakKetiga->get(['*'], $where);

        $spd = $this->spd->get(['*'], $where, ['spdRincian']);

        $this->prefixPenomoran->makeModel();
        $prefix = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_SPD);
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

        $bills = [];
        foreach($spp->referensiPajak as $key => $item) {
            $pajakId = $item->pajak->id;

            $i = 1;
            foreach($item->noBilling as $billing) {
                $bills["billing[{$pajakId}][{$i}]"] = $billing->no_billing;
                $i++;
            }
        }
        
        return view('admin.spp.edit', compact(
            'spp', 'pejabatUnit', 'rekeningBendahara', 'unitKerja', 'pajak', 'bast', 'pihakKetiga',
            'spd', 'selectedPajak', 'bills'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SppRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->spp->update([
                'tanggal' => $request->tanggal,
                'kode_unit_kerja' => $request->unit_kerja,
                'bast_id' => $request->bast,
                'sisa_spd_total' => parse_format_number($request->sisa_spd_total),
                'sisa_spd_kegiatan' => parse_format_number($request->sisa_spd_kegiatan),
                'sisa_kas' => parse_format_number($request->sisa_kas),
                'sisa_pagu_pengajuan' => parse_format_number($request->sisa_pagu_pengajuan),
                'keterangan' => $request->keterangan,
                'pihak_ketiga_id' => $request->pihak_ketiga,
                'bendahara_pengeluaran' => $request->bendahara_pengeluaran,
                'pptk' => $request->pptk,
                'akun_bendahara' => $request->akun_bendahara,
                'pemimpin_blud' => $request->pemimpin_blud,
                'nominal_sumber_dana' => $request->nominal_sumber_dana
            ], $id);

            $this->sppSpd->deleteAll($id);
            
            if ($request->pajak_id) {
                $this->sppPajak->deleteAll($id);
                
                for ($i = 0; $i < count($request->pajak_id); $i++) {
                    $information = false;
                    if (isset($request->pungutan_pajak_informasi[$i])) {
                        $information = true;
                    }
                    $pajakId = $request->pajak_id[$i];

                    $sppPajak = $this->sppPajak->create([
                        'spp_id' => $id,
                        'pajak_id' => $pajakId,
                        'nominal' => parse_format_number($request->nominal_pajak[$i]),
                        'is_information' => $information
                    ]);

                    if (!$sppPajak) {
                        throw new \Exception('Error create spp pajak');
                    }

                    $this->sppPajakNoBilling->deleteAll($sppPajak->id);
                    
                    $billingData = $request->billing[$pajakId];
                    if($billingData) {
                        foreach($billingData as $bill) {
                            if($bill) {
                                $attributes = [
                                    'spp_pajak_id' => $sppPajak->id,
                                    'no_billing' => $bill
                                ];
                                
                                $createBilling = $this->sppPajakNoBilling->create($attributes);
    
                                if( ! $createBilling) {
                                    throw new \Exception('Error create spp pajak no billing');
                                }
                            }
                        }
                    }
                }
            }

            for ($i = 0; $i < count($request->spd_id); $i++) {
                $sppSpd = $this->sppSpd->create([
                    'spp_id' => $id,
                    'spd_id' => $request->spd_id[$i]
                ]);

                if (!$sppSpd) {
                    throw new \Exception('Error create spp referensi spd');
                }
            }

            DB::commit();

        }catch(\Exception $e){
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
            $id = $request->id;
            $spp = $this->spp->find($id);
            if ($spp->nomor_otomatis){
                $this->spp->updateNomor($spp->nomor, $spp->kode_unit_kerja);
            }
            $this->sppPajak->deleteAll($spp->id);
            $this->sppSpd->deleteAll($spp->id);
            $spp->delete();

            return redirect()->back()
                ->with(['success' => 'Data berhasil dihapus']);
        }catch(\Exception $e){
            return response()->json([
                'data' => $e->getMessage(),
                'line' => $e->getLine(),
            ], 400);
        }
    }

    /**
     * Get data sts
     *
     * @return void
     */
    public function getData(Request $request)
    {
        //
    }

    /**
     * Report SPP By Id
     *
     * @param [int] $id
     * @return void
     */
    public function reportSpp($id)
    {
        $prefixSpp = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_SPP);
        $prefixPenomoran = explode('/', $prefixSpp->format_penomoran);

        $this->prefixPenomoran->makeModel();

        $prefixSpd = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_SPD);
        $prefixPenomoranSpd = explode('/', $prefixSpd->format_penomoran);

        $spp = $this->spp->find($id, ['*'], [
            'unitKerja', 'sppPemimpinBlud', 'bast.kegiatan.program', 'bast.rincianPengadaan.akun', 'referensiSpd.spd.spdRincian',
            'referensiPajak.pajak', 'sppPptk', 'bendaharaPengeluaran', 'pihakKetiga'
        ]);

        $pejabatPpk = $this->pejabatUnit->getPejabat($spp->kode_unit_kerja, 2);

        

        if ($spp->nomor_otomatis){
            if ($spp->nomor_otomatis) {
                $nomorspp = nomor_fix($prefixPenomoran, $spp->nomor, $spp->kode_unit_kerja);
                $spp->nomorspp = $nomorspp;
            } else {
                $spp->nomorspd = $spp->nomor;
            }
        }

        $spp->referensiSpd->map(function ($item) use($prefixPenomoranSpd){
            $item->spd->totalspd = $item->spd->spdRincian->sum('nominal');
            if ($item->spd->nomor_otomatis){
                $nomorspd = nomor_fix($prefixPenomoranSpd, $item->spd->nomor, $item->spd->kode_unit_kerja);
                $item->spd->nomorspd = $nomorspd;
            }else {
                $item->spd->nomorspd = $item->spd->nomor;
            }
        });

        $pdf = PDF::loadview('admin.report.form_spp', compact('spp', 'pejabatPpk'));
        return $pdf->stream('report_spp.pdf', ['Attachment' => false]);
    }

    /**
     * Report SPM by Id
     *
     * @param [int] $id
     * @return void
     */
    public function reportSpm($id)
    {
        $spm = $this->spp->find($id, ['*'], [
            'unitKerja', 'sppPemimpinBlud', 'bast.kegiatan', 'bast.rincianPengadaan.akun', 'referensiSpd.spd',
            'referensiPajak.pajak', 'referensiPajak.noBilling'
            ]);

        $prefix = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_SPD);
        $prefixPenomoran = explode('/', $prefix->format_penomoran);

        $this->prefixPenomoran->makeModel();
        $prefixSpp = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_SPP);
        $prefixPenomoranSpp = explode('/', $prefixSpp->format_penomoran);

        $this->prefixPenomoran->makeModel();
        $prefixSpm = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_SPM);
        $prefixPenomoranSpm = explode('/', $prefixSpm->format_penomoran);

        $spm->referensiSpd->map(function ($item) use($prefixPenomoran){
            if ($item->spd->nomor_otomatis){
                $nomorSpd = nomor_fix($prefixPenomoran, $item->spd->nomor, $item->spd->kode_unit_kerja);
                $item->spd->nomorspd = $nomorSpd;
            }else {
                $item->spd->nomorspd = $item->spd->nomor;
            }
        });

        if ($spm->nomor_otomatis){
            $nomorSpp = nomor_fix($prefixPenomoranSpp, $spm->nomor, $spm->kode_unit_kerja);
            $nomorSpm = nomor_fix($prefixPenomoranSpm, $spm->nomor, $spm->kode_unit_kerja);
            $spm->nomorspp = $nomorSpp;
            $spm->nomorspm = $nomorSpm;
        }else {
            $spm->nomorspp = $spm->nomor;
            $spm->nomorspm = $spm->nomor;
        }

        $totalPotongan = 0;
        $spm->referensiPajak->map(function ($item) use(&$totalPotongan) {
            if (! $item->is_information){
                $totalPotongan += $item->nominal;
            }
        });

        $pdf = PDF::loadview('admin.report.form_spm', compact('spm', 'totalPotongan'))->setPaper('a4', 'landscape');
        return $pdf->stream('report_spm.pdf', ['Attachment' => false]);
    }

    /**
     * Get pagu
     *
     * @return void
     */
    public function getPagu(Request $request)
    {
        $totalSpd = 0;

        $where = function ($query) use($request) {
            $query->where('kode_unit_kerja', $request->kode_unit_kerja);
        };

        $spd = $this->spd->get(['*'], $where, ['spdRincian']);

        $totalSpd = $spd->sum(function ($item){
            return $item->spdRincian->sum('nominal');
        });

        $totalSpp = 0;

        $spp = $this->spp->get(['*'], $where);
        $totalSpp = $spp->sum('nominal_sumber_dana');

        $totalSts = 0;

        $sts = $this->sts->get(['*'], $where, ['sumberDanaSts']);

        $totalSts = $sts->sum(function ($item){
            return $item->sumberDanaSts->sum('nominal');
        });

        $where = function ($query) use ($request) {
            $query->where('kode_unit_kerja', $request->kode_unit_kerja);
        };
        $saldoAwal = $this->saldoAwal->get(['*'], $where, ['saldoAwalRincian']);

        $saldoAwal = $saldoAwal->sum(function ($item) {
            return $item->saldoAwalRincian->sum('debet');
        });

        $totalPaguRba = 0;

        $whereRba = function ($query) use($request) {
            $query->where('kode_unit_kerja', $request->kode_unit_kerja)
                ->where('kode_rba', Rba::KODE_RBA_221)
                ->where('status_anggaran_id', Auth::user()->statusAnggaran->id);

        };
        $rba = $this->rba->get(['*'], $whereRba, ['rincianSumberDana']);

        if (!$rba) {
            $whereRba = function ($query) use ($request) {
                $query->where('kode_unit_kerja', $request->kode_unit_kerja)
                    ->where('kode_rba', Rba::KODE_RBA_221);
            };
            $rba = $this->rba->get(['*'], $whereRba, ['rincianSumberDana']);
        }

        $totalPaguRba = $rba->sum(function ($item){
            return $item->rincianSumberDana->sum('nominal');
        });

        $totalKontraPos = 0; // di ambil dari kontrapos

        $response = [
            'data' => [
                'spd_total' => ($totalSpd - $totalSpp),
                'sisa_kas' => ($totalSts + $saldoAwal - $totalSpp),
                'sisa_pagu' => ($totalPaguRba + $totalKontraPos) - $totalSpp
            ]
        ];

        return response()->json($response, 200);
    }

    /**
     * Get pagu kegiatan
     *
     * @return void
     */
    public function getPaguKegiatan(Request $request)
    {
        $bast   = $this->bast->find($request->bast_id, ['id', 'idSubKegiatan', 'kode_unit_kerja', 'tgl_kontrak'], ['rincianPengadaan', 'subKegiatan']);

        $kodeSubKegiatan    = $bast ? $bast->subKegiatan->kodeSubKegiatan : '';
        $kodeUnitKerja      = $bast ? $bast->kode_unit_kerja : '';
        $tanggal            = $bast ? $bast->tgl_kontrak : '';
        $totalBast          = 0;
        if ($bast->rincianPengadaan){
            foreach ($bast->rincianPengadaan as $value) {
                $totalBast  += ($value->unit * $value->harga);
            }
        }

        $kodeRekening       = $bast->rincianPengadaan ? $bast->rincianPengadaan->pluck('kode_akun') : null;
        
        $akunId             = $this->akun->getAkunId($kodeRekening);

        $paguRbaByRekening  = $this->rba->getRba221ByRekening($kodeUnitKerja, $akunId);

        $totalPaguRba       = $paguRbaByRekening->sum(function ($item) {
            return $item->rincianSumberDana->sum('nominal');
        });

        $nominalPak = $paguRbaByRekening->sum(function ($item) {
            return $item->rincianSumberDana->sum('nominal_pak');
        });

        $totalPaguRba   += $nominalPak;

        $totalSpd       = 0;
        $totalSpd       = $this->spd->getTotalSpdKegiatan($kodeSubKegiatan, $kodeUnitKerja);

        $totalSpp       = 0;
        $totalSpp       = $this->spp->getTotalSpp($kodeSubKegiatan, $kodeUnitKerja);

        if (!$kodeRekening) {
            $totalSppPerRekening    = 0;
        }else {
            $totalSppPerRekening    = $this->spp->getTotalSppByRekening($kodeUnitKerja, $kodeRekening);
        }

        $totalKontraPos = 0;

        $response   = [
            'data'  => [
                'sisa_spd_kegiatan' => ($totalSpd - $totalSpp),
                'tanggal_bast'      => $tanggal,
                'sisa_pagu'         => ($totalPaguRba + $totalKontraPos) - $totalSppPerRekening 
            ]
        ];

        return response()->json($response, 200);
    }
}

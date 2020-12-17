<?php

namespace App\Http\Controllers\Admin;

use App\Models\PrefixPenomoran;
use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Controllers\Controller;
use App\Models\Rba;
use App\Repositories\BKU\BKURepository;
use App\Repositories\BKU\BKURincianRepository;
use App\Repositories\DataDasar\AkunRepository;
use App\Repositories\DataDasar\MapKegiatanRepository;
use App\Repositories\Organisasi\PejabatUnitRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Repositories\Penerimaan\STSRepository;
use App\Repositories\Organisasi\UnitKerjaRepository;
use App\Repositories\Penerimaan\STSRincianRepository;
use App\Repositories\Penerimaan\TBPRepository;
use App\Repositories\Pengaturan\PrefixPenomoranRepository;
use App\Repositories\RBA\RBARepository;
use Carbon\Carbon;

class ReportBendaharaPenerimaController extends Controller
{
    /**
     * Unit kerja repository
     *
     * @var UnitKerjaRepository
     */
    private $unitKerja;

    /**
     * Sts repository
     *
     * @var StsRepository
     */
    private $sts;

    /**
     * Sts Rincian repository
     *
     * @var StsRepository
     */
    private $stsRincian;

    /**
     * Prefix Penomoran repository
     *
     * @var PrefixPenomoranRepository
     */
    private $prefixPenomoran;

    /**
     * BKU Rincian Repository
     *
     * @var BKURincianRepository
     */
    private $bkuRincian;

    /**
     * PejabatUnitRepository
     *
     * @var PejabatUnitRepository
     */
    private $pejabatUnit;

    /**
     * Bku Repository
     * 
     * @var BkuRepository
     */
    private $bku;

    /**
     * Tbp Repository
     * 
     * @var TBPRepository
     */
    private $tbp;
    
    /**
     * Akun Repository
     * 
     * @var AkunRepository
     */
    private $akun;

    /**
     * RBA Repository
     * 
     * @var RBARepository
     */
    private $rba;

    /**
     * Map kegiatan repository
     * 
     * @var MapKegiatanRepository
     */
    private $mapKegiatan;

    public function __construct(
        UnitKerjaRepository $unitKerja,
        STSRepository $sts,
        PrefixPenomoranRepository $prefixPenomoran,
        STSRincianRepository $stsRincian,
        BKURincianRepository $bkuRincian,
        PejabatUnitRepository $pejabatUnit,
        BKURepository $bku,
        TBPRepository $tbp,
        AkunRepository $akun,
        RBARepository $rba,
        MapKegiatanRepository $mapKegiatan
    )
    {
        $this->unitKerja = $unitKerja;
        $this->sts = $sts;
        $this->prefixPenomoran = $prefixPenomoran;
        $this->stsRincian = $stsRincian;
        $this->bkuRincian = $bkuRincian;
        $this->pejabatUnit = $pejabatUnit;
        $this->bku = $bku;
        $this->tbp = $tbp;
        $this->akun = $akun;
        $this->rba = $rba;
        $this->mapKegiatan = $mapKegiatan;
    }

    /**
     * Register sts view
     *
     * @return void
     */
    public function registerStsView()
    {
        $unitKerja = $this->unitKerja->get();

        return view('admin.report_bendahara_penerima.register_sts', compact('unitKerja'));
    }

    /**
     * Register sts
     *
     * @return void
     */
    public function registerSts(Request $request)
    {
        $prefix = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_STS);
        $this->prefixPenomoran->makeModel();
        $prefixNl = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_STSNL);

        $stsRincian = $this->stsRincian->getAllRincian($request->kode_unit_kerja, $request->tanggal_awal, $request->tanggal_akhir);

        $prefixPenomoran = explode('/', $prefix->format_penomoran);
        $prefixPenomoranNl = explode('/', $prefixNl->format_penomoran);
        $stsRincian->map(function ($item) use($prefixPenomoran, $prefixPenomoranNl){
            if ($item->sts->nomor_otomatis) {
                if ($item->sts->nl) {
                    $nomorFix = nomor_fix($prefixPenomoranNl, $item->sts->nomor, $item->sts->kode_unit_kerja);
                } else {
                    $nomorFix = nomor_fix($prefixPenomoran, $item->sts->nomor, $item->sts->kode_unit_kerja);
                }
                $item->sts->nomorfix = $nomorFix;
            } else {
                $item->sts->nomorfix = $item->sts->nomor;
            }
        });
        $contents = \View::make('admin.report.form_register_sts_excel', compact('stsRincian', 'request'));
        return \Response::make($contents, 200)
            ->header('Content-Type', 'application/vnd-ms-excel')
            ->header('Content-Disposition', 'attachment; filename=report-register-sts.xls');
    }

    /**
     * Report PDF Register Sts
     *
     * @param Request $request
     * @return void
     */
    public function registerStsPdf(Request $request)
    {
        $prefix = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_STS);
        $this->prefixPenomoran->makeModel();
        $prefixNl = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_STSNL);

        $where = function ($query) use($request) {
            $query->where('kode_unit_kerja', $request->unit_kerja)
                ->whereBetween('tanggal', [$request->tanggal_awal, $request->tanggal_akhir]);
        };

        $sts = $this->sts->get(['*'], $where, ['rincianSts.akun', 'unitKerja', 'bendaharaPenerima', 'kepalaSkpd']);
        $prefixPenomoran = explode('/', $prefix->format_penomoran);
        $prefixPenomoranNl = explode('/', $prefixNl->format_penomoran);
        $sts->map(function ($item) use ($prefixPenomoran, $prefixPenomoranNl) {
            if ($item->nomor_otomatis) {
                if ($item->nl) {
                    $nomorFix = nomor_fix($prefixPenomoranNl, $item->nomor, $item->kode_unit_kerja);
                } else {
                    $nomorFix = nomor_fix($prefixPenomoran, $item->nomor, $item->kode_unit_kerja);
                }
                $item->nomorfix = $nomorFix;
            } else {
                $item->nomorfix = $item->nomor;
            }
            $item->total_nominal = $item->rincianSts->sum('nominal');
        });

        $pejabat = $this->pejabatUnit->getAllPejabat($request->unit_kerja);

        $kepalaSkpd = clone $pejabat;
        $kepalaSkpd = $kepalaSkpd->where('jabatan_id', 1)->first();
        
        $bendaharaPenerimaan = clone $pejabat;
        $bendaharaPenerimaan = $bendaharaPenerimaan->where('jabatan_id', 4)->first();

        $totalSts = $sts->sum(function ($item) {
            return $item->rincianSts->sum('nominal');
        });

        /** Collect data STS */
        $collect = collect($sts);
        $dataSts = $collect->chunk(10);
        $dataSts->toArray();
        $countStsChunk = count($dataSts);

        $pdf = PDF::loadview('admin.report.form_register_sts', compact(
            'sts', 'request', 'kepalaSkpd', 'bendaharaPenerimaan', 'totalSts', 'dataSts', 'countStsChunk'
        ));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('report_register_sts.pdf', ['Attachment' => false]);
    }

    public function registerTbpPdf(Request $request)
    {
        $prefix = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_TBP);
        $where = function ($query) use($request) {
            $query->where('kode_unit_kerja', $request->unit_kerja)
                ->whereBetween('tanggal', [$request->tanggal_awal, $request->tanggal_akhir]);
        };

        $tbp = $this->tbp->get(['*'], $where, ['rincianTbp.akun', 'unitKerja', 'bendaharaPenerima', 'kepalaSkpd']);
        $prefixPenomoran = explode('/', $prefix->format_penomoran);
        $tbp->map(function ($item) use ($prefixPenomoran){
            if ($item->nomor_otomatis) {
                $nomorFix = nomor_fix($prefixPenomoran, $item->nomor, $item->kode_unit_kerja);
            } else {
                $nomorFix = $item->nomor;
            }
            $item->nomorfix = $nomorFix;
            $item->total_nominal = $item->rincianTbp->sum('nominal');
        });

        $pejabat = $this->pejabatUnit->getAllPejabat($request->unit_kerja);

        $kepalaSkpd = clone $pejabat;
        $kepalaSkpd = $kepalaSkpd->where('jabatan_id', 1)->first();
        
        $bendaharaPenerimaan = clone $pejabat;
        $bendaharaPenerimaan = $bendaharaPenerimaan->where('jabatan_id', 4)->first();

        $totalTbp = $tbp->sum(function ($item) {
            return $item->rincianTbp->sum('nominal');
        });
        
        /** Collect data STS */
        $collect = collect($tbp);
        $dataTbp = $collect->chunk(10);
        $dataTbp->toArray();
        $countTbpChunk = count($dataTbp);

        $pdf = PDF::loadview('admin.report.form_register_tbp', compact(
            'tbp', 'request', 'kepalaSkpd', 'bendaharaPenerimaan', 'totalTbp', 'dataTbp', 'countTbpChunk'
        ));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('report_register_tbp.pdf', ['Attachment' => false]);
    }

    /**
     * Bku Bendahara view
     *
     * @return void
     */
    public function bkuBendaharaView()
    {
        $unitKerja = $this->unitKerja->get();

        return view('admin.report_bendahara_penerima.bku_bendahara', compact('unitKerja'));
    }

    /**
     * Bku Bendahara view
     *
     * @return void
     */
    public function bkuBendahara(Request $request)
    {
        $firstMonth = Carbon::parse($request->tanggal_awal)->format('m');
        $previousMonth = Carbon::parse($request->tanggal_awal)->startOfMonth()->subMonth()->format('m');
        $lastMonth = Carbon::parse($request->tanggal_akhir)->format('m');

        $prefixSts = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_STS);
        $this->prefixPenomoran->makeModel();
        $prefixNl = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_STSNL);
        $this->prefixPenomoran->makeModel();
        $prefixBku = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_BKU_PENERIMAAN);

        $prefixPenomoranSts = explode('/', $prefixSts->format_penomoran);
        $prefixPenomoranNl = explode('/', $prefixNl->format_penomoran);
        $prefixPenomoranBku = explode('/', $prefixBku->format_penomoran);

        $stsFirstMonth = $this->sts->getStsByMonth($request->unit_kerja, $firstMonth);

        $penerimaanFirstMonth = 0;
        $pengeluaranFirstMonth = 0;
        $stsFirstMonth->map(function ($item) use(&$penerimaanFirstMonth, &$pengeluaranFirstMonth){
            if ($item->bkuRincian){
                $pengeluaranFirstMonth += $item->rincianSts->sum('nominal');
            }
            $penerimaanFirstMonth += $item->rincianSts->sum('nominal');
        });

        $penerimaanPreviousMonth = 0;
        $pengeluaranPreviousMonth = 0;
        if ($firstMonth != '01'){
            $stsPreviousMonth = $this->sts->getStsByMonth($request->unit_kerja, $previousMonth);
            $stsPreviousMonth->map(function ($item) use(&$penerimaanPreviousMonth, &$pengeluaranPreviousMonth){
                if ($item->bkuRincian){
                    $pengeluaranPreviousMonth += $item->rincianSts->sum('nominal');
                }
                $penerimaanPreviousMonth += $item->rincianSts->sum('nominal');
            });
        }

        $sts = $this->sts->getAllStsBku($request->unit_kerja, $request->tanggal_awal, $request->tanggal_akhir);
        $sts->map(function ($item) use($prefixPenomoranBku) {
            if ($item->bkuRincian){
                if ($item->bkuRincian->bku->nomor_otomatis){
                    $nomorFix = nomor_fix($prefixPenomoranBku, $item->bkuRincian->bku->nomor, $item->kode_unit_kerja);
                    $nomorfix = $nomorFix;
                }else {
                    $nomorfix = $item->bkuRincian->bku->nomor;
                }
                $item->nomorbku = $nomorfix;
            }
            $item->nominal = $item->rincianSts->sum('nominal');
        });

        $pejabat = $this->pejabatUnit->getAllPejabat($request->unit_kerja);
        $bendaharaPenerimaan = clone $pejabat;
        $bendaharaPenerimaan = $bendaharaPenerimaan->where('jabatan_id', 4)->first();

        $kepalaSkpd = clone $pejabat;
        $kepalaSkpd = $kepalaSkpd->where('jabatan_id', 1)->first();

        $unitKerja = $this->unitKerja->findBy('kode', '=', $request->unit_kerja, ['*']);

        /** Collect data STS */
        $sts = $sts->sortBy('nomorbku')->values()->all();
        $collect = collect($sts);
        $dataSts = $collect->chunk(14);
        $dataSts->toArray();
        $countStsChunk = count($dataSts);

        $pdf = PDF::loadview('admin.report.form_bku_bendahara', compact(
            'request', 'bendaharaPenerimaan', 'unitKerja', 'kepalaSkpd', 'sts', 'dataSts', 'countStsChunk',
            'firstMonth', 'lastMonth', 'penerimaanFirstMonth', 'pengeluaranFirstMonth',
            'penerimaanPreviousMonth', 'pengeluaranPreviousMonth'
        ));
        return $pdf->stream('bku_bendahara_penerima.pdf', ['Attachment' => false]);

    }

    /**
     * SPJ Fungsional
     * 
     * @return void
     */
    public function spjFungsional(Request $request)
    {
        $month = Carbon::parse($request->tanggal_pelaporan)->format('m');
        $thisMonth = Carbon::parse($request->tanggal_awal)->format('m');
        $previousMonth = Carbon::parse($request->tanggal_awal)->startOfMonth()->subMonth()->format('m');

        $pejabat = $this->pejabatUnit->getAllPejabat($request->unit_kerja);
        $bendaharaPenerimaan = clone $pejabat;
        $bendaharaPenerimaan = $bendaharaPenerimaan->where('jabatan_id', 4)->first();

        $kepalaSkpd = clone $pejabat;
        $kepalaSkpd = $kepalaSkpd->where('jabatan_id', 1)->first();

        $stsThisMonth = $this->sts->getStsByMonth($request->unit_kerja, $thisMonth);

        $pendapatanThisMonth = [];
        $pengeluaranThisMonth = [];
        foreach ($stsThisMonth as  $sts) {
            foreach ($sts->rincianSts as  $rincian) {
                if ($sts->bkuRincian){
                    if (isset($pengeluaranThisMonth[$rincian->kode_akun])){
                        $pengeluaranThisMonth[$rincian->kode_akun] += $rincian->nominal;
                    }else {
                        $pengeluaranThisMonth[$rincian->kode_akun] = $rincian->nominal;
                    }
                }
                if (isset($pendapatanThisMonth[$rincian->kode_akun])){
                    $pendapatanThisMonth[$rincian->kode_akun] += $rincian->nominal;
                }else {
                    $pendapatanThisMonth[$rincian->kode_akun] = $rincian->nominal;
                }
            }
        }

        $pendapatanPreviousMonth = [];
        $pengeluaranPreviousMonth = [];
        if ($thisMonth != '01') {
            $stsPreviousMonth = $this->sts->getStsByMonth($request->unit_kerja, $previousMonth);
            foreach ($stsPreviousMonth as  $sts) {
                foreach ($sts->rincianSts as  $rincian) {
                    if ($sts->bkuRincian){
                        if (isset($pengeluaranPreviousMonth[$rincian->kode_akun])){
                            $pengeluaranPreviousMonth[$rincian->kode_akun] += $rincian->nominal;
                        }else {
                            $pengeluaranPreviousMonth[$rincian->kode_akun] = $rincian->nominal;
                        }
                    }
                    if (isset($pendapatanPreviousMonth[$rincian->kode_akun])){
                        $pendapatanPreviousMonth[$rincian->kode_akun] += $rincian->nominal;
                    }else {
                        $pendapatanPreviousMonth[$rincian->kode_akun] = $rincian->nominal;
                    }
                }
            }
        }

        $kodeAkun = $this->stsRincian->getKodeAkun();
        $whereAkun = function ($query) use($kodeAkun) {
            $query->whereIn('kode_akun', $kodeAkun);
        };
        $akun = $this->akun->get(['*'], $whereAkun);
        

        $whereRba = function ($query) use($request) {
            $query->where('kode_unit_kerja', $request->unit_kerja)
                ->where('kode_rba', Rba::KODE_RBA_1);
        };
        $rba = $this->rba->get(['*'], $whereRba, ['rincianAnggaran.akun']);
        
        $anggaran = [];

        $rba->map(function ($item) use(&$anggaran) {
            foreach ($item->rincianAnggaran as $key => $value) {
                $anggaran[$value->akun->kode_akun] = $value->tarif * $value->volume;
            }
        });
        
        $unitKerja = $this->unitKerja->findBy('kode', '=', $request->unit_kerja, ['*']);

        $pdf = PDF::loadview('admin.report.form_spj_pendapatan_fungsional', compact(
            'request', 'bendaharaPenerimaan', 'unitKerja', 'kepalaSkpd', 'month', 'akun', 'pendapatanThisMonth',
            'pengeluaranThisMonth', 'pendapatanPreviousMonth', 'pengeluaranPreviousMonth', 'anggaran'
        ))->setPaper('a4', 'landscape');
        return $pdf->stream('spj_fungsional.pdf', ['Attachment' => false]);
    }

    /**
     * Buku rincian
     * 
     * @return void
     */
    public function bukuRincian(Request $request)
    {
        $akun = $this->rba->getAkunId($request->kode_rekening);
        // $mapKegiatan =
        $unitKerja = $this->unitKerja->findBy('kode', '=', $request->unit_kerja);
        $rba = $this->rba->getDetailRba1($unitKerja->kode);
        $anggaran = $rba->rincianSumberDana->where('akun_id', $akun->id)->first();

        if ($rba->status_perubahan == Rba::STATUS_PERUBAHAN_PERUBAHAN) {
            $totalAnggaran = $anggaran->nominal_pak;
        } else {
            $totalAnggaran = $anggaran->nominal;
        }
        
        $mapKegiatan = $this->mapKegiatan->find($request->map_kegiatan, ['*'], ['blud']);

        $bropPenerimaan = $this->bkuRincian->getBkuRincianBropPenerimaan($unitKerja->kode, $request->tanggal_awal, $request->tanggal_akhir, $akun->kode_akun);

        $pejabat = $this->pejabatUnit->getAllPejabat($request->unit_kerja);
        $bendaharaPengeluaran = clone $pejabat;
        $bendaharaPengeluaran = $bendaharaPengeluaran->where('jabatan_id', 4)->first();

        $kepalaSkpd = clone $pejabat;
        $kepalaSkpd = $kepalaSkpd->where('jabatan_id', 1)->first();
        $pdf = PDF::loadview('admin.report.form_buku_robbp', compact(
            'akun', 'unitKerja', 'totalAnggaran', 'mapKegiatan', 'bropPenerimaan', 'bendaharaPengeluaran',
            'kepalaSkpd', 'request'
        ));
        return $pdf->stream('report_buku_robbp', ['Attachment' => false]);
    }

    /**
     * Rincian objek penerimaan
     *
     * @return void
     */
    public function objekPenerimaanView()
    {
        $unitKerja = $this->unitKerja->get();

        return view('admin.report_bendahara_penerima.objek_penerimaan', compact('unitKerja'));
    }

    /**
     * Rincian objek penerimaan
     *
     * @return void
     */
    public function objekPenerimaan(Request $request)
    {
        $prefixBku = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_BKU_PENERIMAAN);
        $prefixPenomoranBku = explode('/', $prefixBku->format_penomoran);

        $this->prefixPenomoran->makeModel();
        $prefixSts = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_STS);
        $prefixPenomoranSts = explode('/', $prefixSts->format_penomoran);

        $this->prefixPenomoran->makeModel();
        $prefixNl = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_STSNL);
        $prefixPenomoranStsNL = explode('/', $prefixNl->format_penomoran);


        $bkuRincian = $this->bkuRincian->getAllBkuRincian($request->kode_unit_kerja, $request->tanggal_awal, $request->tanggal_akhir);
        $bkuRincian->map(function ($item) use($prefixPenomoranBku, $prefixPenomoranSts, $prefixPenomoranStsNL){
            if ($item->bku->nomor_otomatis){
                $nomorBku = nomor_fix($prefixPenomoranBku, $item->bku->nomor, $item->bku->kode_unit_kerja);
                $item->bku->nomorbku = $nomorBku;
            }else {
                $item->bku->nomorbku = $item->bku->nomor;
            }

            if ($item->sts->nomor_otomatis) {
                if ($item->sts->nl) {
                    $nomorSts = nomor_fix($prefixPenomoranStsNL, $item->sts->nomor, $item->sts->kode_unit_kerja);
                } else {
                    $nomorSts = nomor_fix($prefixPenomoranSts, $item->sts->nomor, $item->sts->kode_unit_kerja);
                }
                $item->sts->nomorsts = $nomorSts;
            } else {
                $item->sts->nomorsts = $item->sts->nomor;
            }
        });
        $contents = \View::make('admin.report.form_bppop_excel', compact('bkuRincian'));
        return \Response::make($contents, 200)
            ->header('Content-Type', 'application/vnd-ms-excel')
            ->header('Content-Disposition', 'attachment; filename=report-bppop.xls');
    }
}

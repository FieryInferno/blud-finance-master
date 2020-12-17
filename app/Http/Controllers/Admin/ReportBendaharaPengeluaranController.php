<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Controllers\Controller;
use App\Models\PrefixPenomoran;
use App\Models\Rba;
use App\Repositories\Belanja\SetorPajakPajakRepository;
use App\Repositories\Belanja\SetorPajakRepository;
use App\Repositories\Belanja\SP2DRepository;
use App\Repositories\BKU\BKURincianRepository;
use App\Repositories\DataDasar\MapKegiatanRepository;
use App\Repositories\DataDasar\PajakRepository;
use App\Repositories\Organisasi\PejabatUnitRepository;
use App\Repositories\Organisasi\UnitKerjaRepository;
use App\Repositories\Pengaturan\PrefixPenomoranRepository;
use App\Repositories\RBA\RBARepository;
use Illuminate\Support\Carbon;

class ReportBendaharaPengeluaranController extends Controller
{

    /**
     * Unit kerja repository
     * 
     * @var unitKerjaRepository
     */
    private $unitKerja;

    /**
     * Pejabat unit repository
     * 
     * @var PejabatUnitRepository
     */
    private $pejabatUnit;

    /**
     * Sp2d Repository
     * 
     * @var Sp2dRepository
     */
    private $sp2d;

    /**
     * Setor pajak pajak repository
     * 
     * @var SetorPajakPajakRepository
     * 
     */
    private $setorPajak;

    /**
     * Bku rincian repository
     * 
     * @var BkuRincianRepository
     */
    private $bkuRincian;

    /**
     * Prefix penomoran repository
     * 
     * @var prefixPenomoranRepository
     */
    private $prefixPenomoran;

    /**
     * Rba repository
     * 
     * @var RbaRepository
     */
    private $rba;

    /**
     * Pajak repository
     * 
     * @var PajakRepository
     */
    private $pajak;

    private $mapKegiatan;

    /**
     * Constructor
     */
    function __construct(
        RBARepository $rba,
        SP2DRepository $sp2d,
        UnitKerjaRepository $unitKerja,
        PejabatUnitRepository $pejabatUnit,
        SetorPajakRepository $setorPajak,
        BKURincianRepository $bkuRincian,
        PrefixPenomoranRepository $prefixPenomoran,
        PajakRepository $pajak,
        MapKegiatanRepository $mapKegiatan
    )
    {
        $this->rba = $rba;
        $this->sp2d = $sp2d;
        $this->unitKerja = $unitKerja;
        $this->pejabatUnit = $pejabatUnit;
        $this->setorPajak = $setorPajak;
        $this->bkuRincian = $bkuRincian;
        $this->prefixPenomoran = $prefixPenomoran;
        $this->pajak = $pajak;
        $this->mapKegiatan = $mapKegiatan;
    }

    /**
     * Report bkuBendahara pengeluaran
     * 
     * @return void
     */
    function bkuBendahara(Request $request)
    {
        $firstMonth = Carbon::parse($request->tanggal_awal)->format('m');
        $previousMonth = Carbon::parse($request->tanggal_awal)->startOfMonth()->subMonth()->format('m');
        $lastMonth = Carbon::parse($request->tanggal_akhir)->format('m');

        $prefixBku = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_BKU_PENERIMAAN);
        
        $prefixPenomoranBku = explode('/', $prefixBku->format_penomoran);

        $bkuPengeluaran = [];
        $sp2d = $this->sp2d->getSp2dBku($request->unit_kerja, $request->tanggal_awal, $request->tanggal_akhir);
        $setorPajak = $this->setorPajak->getSetorPajakBku($request->unit_kerja, $request->tanggal_awal, $request->tanggal_akhir);

        $sp2dPreviousMonth = $this->sp2d->getSp2dUntilMonth($request->unit_kerja, $previousMonth);
        $setorPajakPreviousMonth = $this->setorPajak->getSetorPajakUntilThisMonth($request->unit_kerja, $previousMonth);

        $setorPajak->map(function ($item) use($prefixPenomoranBku){
            if ($item->bkuRincian){
                if ($item->bkuRincian->bku->nomor_otomatis){
                    $nomorFix = nomor_fix($prefixPenomoranBku, $item->bkuRincian->bku->nomor, $item->kode_unit_kerja);
                    $nomorfix = $nomorFix;
                }else {
                    $nomorfix = $item->bkuRincian->bku->nomor;
                }
                $item->nomorbku = $nomorfix;
                $item->uraian = $item->bkuRincian->bku->keterangan;
            }else {
                $item->uraian = 'setor pajak';
            }
            $item->tanggal = $item->setorPajak->tanggal;
        });

        $sp2d->map(function ($item) use($prefixPenomoranBku){
            if ($item->bkuRincian){
                if ($item->bkuRincian->bku->nomor_otomatis){
                    $nomorFix = nomor_fix($prefixPenomoranBku, $item->bkuRincian->bku->nomor, $item->kode_unit_kerja);
                    $nomorfix = $nomorFix;
                }else {
                    $nomorfix = $item->bkuRincian->bku->nomor;
                }
                $item->nomorbku = $nomorfix;
            }
            $totalNominal = 0;
            foreach ($item->bast->rincianPengadaan as $rincianBast) {
                $totalNominal += ($rincianBast->unit * $rincianBast->harga);
            }
            $item->nominal = $totalNominal;
        });

        foreach ($setorPajak as $key => $value) {
            $bkuPengeluaran[] = [
                'nomorbku' => isset($value->nomorbku) ? $value->nomorbku : '',
                'tanggal' => $value->tanggal,
                'uraian' => isset($value->uraian) ? $value->uraian : '',
                'nominal' => $value->nominal
            ];
        }
        $setorPajakData = (collect($bkuPengeluaran)->sum('nominal'));
        foreach ($sp2d as $key => $value) {
            $bkuPengeluaran[] = [
                'nomorbku' => isset($value->nomorbku) ? $value->nomorbku : '',
                'tanggal' => $value->tanggal,
                'uraian' => $value->keterangan,
                'nominal' => $value->nominal
            ];
        }

        $penerimaanPreviousMonth = 0;
        $pengeluaranPreviousMonth = 0;
        $setorPajakDataPrevious = 0;
        if ($previousMonth != 12) {
            foreach ($setorPajakPreviousMonth as $key => $value) {
                if ($value->bkuRincian){
                    $pengeluaranPreviousMonth += $value->nominal;
                }
                $penerimaanPreviousMonth += $value->nominal;
                $setorPajakDataPrevious += $value->nominal;
            }

            foreach ($sp2dPreviousMonth as $key => $value) {
                if ($value->bkuRincian){
                    $pengeluaranPreviousMonth += $value->nominal_sumber_dana;
                }
                $penerimaanPreviousMonth += $value->nominal_sumber_dana;
            }
        }
        

        $bkuPengeluaran = collect($bkuPengeluaran);
        $bkuPengeluaran = $bkuPengeluaran->sortBy('tanggal')->values()->all();

        $bkuPengeluaran = collect($bkuPengeluaran);
        $dataBkuPengeluaran = $bkuPengeluaran->chunk(9);
        $dataBkuPengeluaran->toArray();
        $countBkuPengeluaranChunk = count($dataBkuPengeluaran);

        $pejabat = $this->pejabatUnit->getAllPejabat($request->unit_kerja);
        $bendaharaPengeluaran = clone $pejabat;
        $bendaharaPengeluaran = $bendaharaPengeluaran->where('jabatan_id', 5)->first();

        $kepalaSkpd = clone $pejabat;
        $kepalaSkpd = $kepalaSkpd->where('jabatan_id', 1)->first();

        $unitKerja = $this->unitKerja->findBy('kode', '=', $request->unit_kerja, ['*']);

        $pdf = PDF::loadview('admin.report.form_bku_bendahara_pengeluaran', compact(
            'request', 'bendaharaPengeluaran', 'unitKerja', 'firstMonth', 'lastMonth', 'previousMonth', 'kepalaSkpd',
            'dataBkuPengeluaran', 'countBkuPengeluaranChunk', 'penerimaanPreviousMonth', 'pengeluaranPreviousMonth',
            'setorPajakData', 'setorPajakDataPrevious'
        ));
        return $pdf->stream('bku_bendahara_pengeluaran.pdf', ['Attachment' => false]);
    }

    public function spjPengeluaran(Request $request)
    {
        $firstMonth = Carbon::parse($request->tanggal_awal)->format('m');
        $previousMonth = Carbon::parse($request->tanggal_awal)->startOfMonth()->subMonth()->format('m');
        $lastMonth = Carbon::parse($request->tanggal_akhir)->format('m');
        $pejabat = $this->pejabatUnit->getAllPejabat($request->unit_kerja);
        $bendaharaPengeluaran = clone $pejabat;
        $bendaharaPengeluaran = $bendaharaPengeluaran->where('jabatan_id', 5)->first();

        $kepalaSkpd = clone $pejabat;
        $kepalaSkpd = $kepalaSkpd->where('jabatan_id', 1)->first();

        $unitKerja = $this->unitKerja->findBy('kode', '=', $request->unit_kerja, ['*']);

        $sp2d = $this->sp2d->getSp2dBku($request->unit_kerja, $request->tanggal_awal, $request->tanggal_akhir);
        $setorPajak = $this->setorPajak->getSetorPajakBku($request->unit_kerja, $request->tanggal_awal, $request->tanggal_akhir);

        $sp2dPreviousMonth = $this->sp2d->getSp2dByMonth($request->unit_kerja, $previousMonth);
        $setorPajakPreviousMonth = $this->setorPajak->getSetorPajakByMonth($request->unit_kerja, $previousMonth);
        
        $anggaran = $this->rba->getAnggaran($unitKerja->kode);

        $dataAnggaran = [];
        $anggaran->rincianSumberDana->map(function ($item) use(&$dataAnggaran) {
            if (isset($dataAnggaran[$item->akun->kode_akun])){
                $dataAnggaran[$item->akun->kode_akun]['nominal'] += $item->nominal;
            }else {
                $dataAnggaran[$item->akun->kode_akun] = 
                [
                    'nominal' => $item->nominal,
                    'nama_akun' => $item->akun->nama_akun,
                    'penerimaan_now' => 0,
                    'pengeluaran_now' => 0,
                    'penerimaan_previous' => 0,
                    'pengeluaran_previous' => 0
                ];
                
            }
        });

        $pajakPenerimaan = [];
        $pajakPengeluaran = [];

        foreach ($sp2d as $dataSp2d) {
            foreach ($dataSp2d->bast->rincianPengadaan as $key => $value) {
                if ($dataSp2d->bkuRincian){
                    $dataAnggaran[$value->kode_akun]['pengeluaran_now'] += $value->unit * $value->harga;
                    $dataAnggaran[$value->kode_akun]['penerimaan_now'] += $value->unit * $value->harga;
                }else {
                    $dataAnggaran[$value->kode_akun]['penerimaan_now'] += $value->unit * $value->harga;
                }
            }
            if($dataSp2d->sp2dPajak){
                foreach ($dataSp2d->sp2dPajak as $pajak) {
                    if ($dataSp2d->bkuRincian){
                        if (isset($pajakPenerimaan['now'][$pajak->pajak->kode_pajak])) {
                            $pajakPenerimaan['now'][$pajak->pajak->kode_pajak] += $pajak->nominal;
                        } else {
                            $pajakPenerimaan['now'][$pajak->pajak->kode_pajak] = $pajak->nominal;
                        }
                        if (isset($pajakPengeluaran['now'][$pajak->pajak->kode_pajak])) {
                            $pajakPengeluaran['now'][$pajak->pajak->kode_pajak] += $pajak->nominal;
                        } else {
                            $pajakPengeluaran['now'][$pajak->pajak->kode_pajak] = $pajak->nominal;
                        }
                    }else {
                        if (isset($pajakPenerimaan['now'][$pajak->pajak->kode_pajak])){
                            $pajakPenerimaan['now'][$pajak->pajak->kode_pajak] += $pajak->nominal;
                        }else {
                            $pajakPenerimaan['now'][$pajak->pajak->kode_pajak] = $pajak->nominal;
                        }
                    }
                }
            }
        }

        foreach ($sp2dPreviousMonth as $dataSp2d) {
            foreach ($dataSp2d->bast->rincianPengadaan as $key => $value) {
                if ($dataSp2d->bkuRincian) {
                    $dataAnggaran[$value->kode_akun]['pengeluaran_previous'] += $value->unit * $value->harga;
                    $dataAnggaran[$value->kode_akun]['penerimaan_previous'] += $value->unit * $value->harga;
                } else {
                    $dataAnggaran[$value->kode_akun]['penerimaan_previous'] += $value->unit * $value->harga;
                }
            }
            if ($dataSp2d->sp2dPajak) {
                foreach ($dataSp2d->sp2dPajak as $pajak) {
                    if ($dataSp2d->bkuRincian) {
                        if (isset($pajakPenerimaan['previous'][$pajak->pajak->kode_pajak])) {
                            $pajakPenerimaan['previous'][$pajak->pajak->kode_pajak] += $pajak->nominal;
                        } else {
                            $pajakPenerimaan['previous'][$pajak->pajak->kode_pajak] = $pajak->nominal;
                        }
                        if (isset($pajakPengeluaran['previous'][$pajak->pajak->kode_pajak])) {
                            $pajakPengeluaran['previous'][$pajak->pajak->kode_pajak] += $pajak->nominal;
                        } else {
                            $pajakPengeluaran['previous'][$pajak->pajak->kode_pajak] = $pajak->nominal;
                        }
                    } else {
                        if (isset($pajakPenerimaan['previous'][$pajak->pajak->kode_pajak])) {
                            $pajakPenerimaan['previous'][$pajak->pajak->kode_pajak] += $pajak->nominal;
                        } else {
                            $pajakPenerimaan['previous'][$pajak->pajak->kode_pajak] = $pajak->nominal;
                        }
                    }
                }
            }
        } 

        $pajakPenerimaan = collect($pajakPenerimaan);
        $pajakPengeluaran = collect($pajakPengeluaran);
        $pajak = $this->pajak->get();
        $dataPajak = collect($pajakPenerimaan);
        $dataAnggaran = collect($dataAnggaran);
        $totalNominal = $dataAnggaran->sum('nominal');
        $totalPenerimaanNow = $dataAnggaran->sum('penerimaan_now');
        $totalPengeluaranNow = $dataAnggaran->sum('pengeluaran_now');
        $totalPenerimaanPrevious = $dataAnggaran->sum('penerimaan_previous');
        $totalPengeluaranPrevious = $dataAnggaran->sum('pengeluaran_previous');

        $pdf = PDF::loadview('admin.report.form_spj_belanja_fungsional', compact(
            'unitKerja', 'kepalaSkpd', 'bendaharaPengeluaran', 'request', 'dataAnggaran', 'totalNominal',
            'anggaran', 'totalPenerimaanNow', 'totalPengeluaranNow', 'totalPenerimaanPrevious', 'totalPengeluaranPrevious',
            'dataPajak', 'pajakPenerimaan', 'pajakPengeluaran', 'pajak'
        ))->setPaper('a4', 'landscape');
        return $pdf->stream('spj_fungsional_bendahara_pengeluaran.pdf', ['Attachment' => false]);
    }

    public function registerBendaharaPengeluaran(Request $request)
    {
        $prefixSpp = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_SPP);
        $prefixPenomoranSpp = explode('/', $prefixSpp->format_penomoran);
        $this->prefixPenomoran->makeModel();
        $prefixSpm = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_SPM);
        $prefixPenomoranSpm = explode('/', $prefixSpm->format_penomoran);
        $this->prefixPenomoran->makeModel();
        $prefixSp2d = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_SP2D);
        $prefixPenomoranSp2d = explode('/', $prefixSp2d->format_penomoran);


        $where = function ($query) use($request) {
            $query->whereBetween('tanggal', [$request->tanggal_awal, $request->tanggal_akhir])
                ->where('kode_unit_kerja', $request->unit_kerja);
        };
        $sp2d = $this->sp2d->get(['*'], $where, ['unitKerja']);

        $sp2d->map(function ($item) use($prefixPenomoranSpp, $prefixPenomoranSpm, $prefixPenomoranSp2d){
            if ($item->nomor_otomatis) {
                $nomorFixSPP = nomor_fix($prefixPenomoranSpp, $item->nomor, $item->kode_unit_kerja);
                $nomorSpp = $nomorFixSPP;

                $nomorFixSPM = nomor_fix($prefixPenomoranSpm, $item->nomor, $item->kode_unit_kerja);
                $nomorSpm = $nomorFixSPM;

                $nomorFixSP2D = nomor_fix($prefixPenomoranSp2d, $item->nomor, $item->kode_unit_kerja);
                $nomorSp2d = $nomorFixSP2D;
            } else {
                $nomorSpp = $item->nomor;
                $nomorSpm = $item->nomor;
                $nomorSp2d = $item->nomor;
            }
            $item->nomorspp = $nomorSpp;
            $item->nomorspm = $nomorSpm;
            $item->nomors2d = $nomorSp2d;
        });

        $pejabat = $this->pejabatUnit->getAllPejabat($request->unit_kerja);
        $bendaharaPengeluaran = clone $pejabat;
        $bendaharaPengeluaran = $bendaharaPengeluaran->where('jabatan_id', 5)->first();

        $kepalaSkpd = clone $pejabat;
        $kepalaSkpd = $kepalaSkpd->where('jabatan_id', 1)->first();
        

        $pdf = PDF::loadview('admin.report.form_register_spp_spm_sp2d', compact(
            'sp2d', 'request', 'bendaharaPengeluaran', 'kepalaSkpd'
            )
        )->setPaper('a4', 'landscape');
        return $pdf->stream('report_register_spp_spm_sp2d.pdf', ['Attachment' => false]);
    }

    public function brop(Request $request)
    {
        $akun = $this->rba->getAkunId($request->kode_rekening);
        // $mapKegiatan =
        $unitKerja = $this->unitKerja->findBy('kode', '=', $request->unit_kerja);
        $rba = $this->rba->getDetailRba221($unitKerja->kode, $request->map_kegiatan);
        $anggaran = $rba->rincianSumberDana->where('akun_id', $akun->id)->first();

        if ($rba->status_perubahan == Rba::STATUS_PERUBAHAN_PERUBAHAN){
            $totalAnggaran = $anggaran->nominal_pak;
        }else {
            $totalAnggaran = $anggaran->nominal;
        }

        $mapKegiatan = $this->mapKegiatan->find($request->map_kegiatan,['*'], ['blud']);

        $brop = $this->bkuRincian->getBkuRincianBrop($unitKerja->kode, $request->tanggal_awal, $request->tanggal_akhir, $akun->kode_akun);

        $pejabat = $this->pejabatUnit->getAllPejabat($request->unit_kerja);
        $bendaharaPengeluaran = clone $pejabat;
        $bendaharaPengeluaran = $bendaharaPengeluaran->where('jabatan_id', 5)->first();

        $kepalaSkpd = clone $pejabat;
        $kepalaSkpd = $kepalaSkpd->where('jabatan_id', 1)->first();

        $pdf = PDF::loadview('admin.report.form_robbp', compact(
            'request', 'unitKerja', 'brop', 'mapKegiatan', 'kepalaSkpd', 'bendaharaPengeluaran', 'akun',
            'totalAnggaran', 'brop'
        ));
        return $pdf->stream('report_robbp', ['Attachment' => false]);
    }

    public function bukuPajak(Request $request)
    {
        $unitKerja = $this->unitKerja->findBy('kode', '=', $request->unit_kerja);

        $prefixBku = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_BKU_PENERIMAAN);
        $prefixPenomoranBku = explode('/', $prefixBku->format_penomoran);
        
        $setorPajak = $this->setorPajak->getSetorPajakBku($request->unit_kerja, $request->tanggal_awal, $request->tanggal_akhir);

        $setorPajak->map(function ($item) use ($prefixPenomoranBku) {
            if ($item->bkuRincian) {
                if ($item->bkuRincian->bku->nomor_otomatis) {
                    $nomorFix = nomor_fix($prefixPenomoranBku, $item->bkuRincian->bku->nomor, $item->kode_unit_kerja);
                    $nomorfix = $nomorFix;
                } else {
                    $nomorfix = $item->bkuRincian->bku->nomor;
                }
                $item->nomorbku = $nomorfix;
                $item->uraian = $item->bkuRincian->bku->keterangan;
                $item->tanggal = $item->bkuRincian->bku->tanggal;
                $item->penerimaan = $item->nominal;
                $item->pengeluaran = $item->nominal;
            } else {
                $item->nomorbku = '';
                $item->uraian = 'setor pajak';
                $item->tanggal = $item->setorPajak->tanggal;
                $item->penerimaan = $item->nominal;
            }
        });

        $pejabat = $this->pejabatUnit->getAllPejabat($request->unit_kerja);
        $bendaharaPengeluaran = clone $pejabat;
        $bendaharaPengeluaran = $bendaharaPengeluaran->where('jabatan_id', 5)->first();

        $kepalaSkpd = clone $pejabat;
        $kepalaSkpd = $kepalaSkpd->where('jabatan_id', 1)->first();

        $pdf = PDF::loadview('admin.report.form_buku_pembantu_pajak', compact(
            'request', 'bendaharaPengeluaran', 'kepalaSkpd', 'unitKerja', 'setorPajak'
        ));
        return $pdf->stream('report_buku_pembantu_pajak', ['Attachment' => false]);
    }
}

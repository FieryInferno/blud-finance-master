<?php

namespace App\Http\Controllers\Admin;

use App\Models\SaldoAwal;
use Illuminate\Http\Request;
use App\Models\PrefixPenomoran;
use App\Http\Controllers\Controller;
use App\Repositories\Akutansi\JurnalPenyesuaianRepository;
use App\Repositories\Penerimaan\TBPRepository;
use App\Repositories\PrefixPenomoranRepository;
use App\Repositories\Akutansi\SaldoAwalRepository;
use App\Repositories\Akutansi\SetupJurnalAnggaranRepository;
use App\Repositories\Akutansi\SetupJurnalFinansialRepository;
use App\Repositories\Akutansi\SetupJurnalRepository;
use App\Repositories\BKU\BKURincianRepository;
use App\Repositories\Organisasi\MapAkunFinanceRepository;
use App\Repositories\Organisasi\UnitKerjaRepository;

class JurnalUmumController extends Controller
{

    /**
     * Saldo Awal Repository
     *
     * @var SaldoAwalRepository
     */
    private $saldoAwal;

    /**
     * Tbp Repository
     *
     * @var TBPRepository
     */
    private $tbp;

    /**
     * Prefix Penomoran repository
     *
     * @var PrefixPenomoranRepository
     */
    private $prefixPenomoran;

    /**
     * Bku Rincian repository
     *
     * @var BKURincianRepository
     */
    private $bkuRincian;

    /**
     * Setup Jurnal Anggaran Repository
     *
     * @var SetupJurnalAnggaranRepository
     */
    private $setupJurnal;

    /**
     * Map Akun Finance Repository
     *
     * @var MapAkunFinance
     */
    private $mapAkunFinance;

    /**
     * Jurnal penyesuaian re
     *
     * @var [type]
     */
    private $jurnalPenyesuaian;

    private $unitKerja;

    /**
     * Constructor
     */
    public function __construct(
        SaldoAwalRepository $saldoAwal,
        TBPRepository $tbp,
        PrefixPenomoranRepository $prefixPenomoran,
        BKURincianRepository $bkuRincian,
        SetupJurnalRepository $setupJurnal,
        MapAkunFinanceRepository $mapAkunFinance,
        JurnalPenyesuaianRepository $jurnalPenyesuaian,
        UnitKerjaRepository $unitKerja
    )
    {
        $this->saldoAwal = $saldoAwal;
        $this->tbp = $tbp;
        $this->prefixPenomoran = $prefixPenomoran;
        $this->bkuRincian = $bkuRincian;
        $this->setupJurnal = $setupJurnal;
        $this->mapAkunFinance = $mapAkunFinance;
        $this->jurnalPenyesuaian = $jurnalPenyesuaian;
        $this->unitKerja = $unitKerja;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function index(Request $request)
    {
        $prefixSaldoAwalLo = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_SALDOAWAL_LO);
        $this->prefixPenomoran->makeModel();
        $prefixSaldoAwalNeraca = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_SALDOAWAL_NERACA);
        $this->prefixPenomoran->makeModel();
        $prefixSts = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_STS);
        $this->prefixPenomoran->makeModel();
        $prefixStsNL = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_STSNL);
        $this->prefixPenomoran->makeModel();
        $prefixSP2D = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_SP2D);
        $this->prefixPenomoran->makeModel();
        $prefixSetorPajak = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_SETORAN_PAJAK);
        $this->prefixPenomoran->makeModel();
        $prefixJurnalPenyesuaian = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_JURNAL_PENYESUAIAN);

        $bkuRincian = $this->bkuRincian->getBkuJurnalUmum($request);

        $jurnalUmum = [];
        $jurnalKontrapos = [];
        $rekeningBendahara = ['rekening_bendahara', 'rekening_bendahara1', 'rekening_bendahara2', 'rekening_bendahara3'];
        foreach ($bkuRincian as $rincian) {
            $jurnal = $this->setupJurnal->findBy('formulir', '=', strtolower($rincian->tipe), ['*'], ['anggaran', 'finansial']);
            $this->setupJurnal->makeModel();
            if ($rincian->sts){
                if ($request->tipe && $request->tipe == 'sts' || ! $request->tipe){
                    foreach($rincian->sts->rincianSts as $rincianSts){
                        foreach ($jurnal->anggaran as $anggaran) {
                            $cekKodeAkun = preg_replace('/[0-9]+/', '', $anggaran->elemen_anggaran);
                            if ($cekKodeAkun == 'rekening_bendahara'){
                                $kodeAkun = $rincian->sts->rekeningBendahara->kode_akun;
                            }else {
                                $kodeAkun = $rincianSts->kode_akun;
                            }
                            array_push($jurnalUmum, [
                                'tanggal' => $rincian->bku->tanggal,
                                'tipe' => $rincian->tipe,
                                'nomor' => $rincian->no_aktivitas,
                                'kode_unit_kerja' => $rincian->bku->kode_unit_kerja,
                                'unit_kerja' => $rincian->bku->unitKerja->nama_unit,
                                'kode_akun' => $kodeAkun,
                                'elemen' => $anggaran->elemen_anggaran,
                                'nominal' => $rincianSts->nominal,
                                'jenis' => $anggaran->jenis_anggaran,
                            ]);
                        }
                        foreach ($jurnal->finansial as $finansial) {
                            $cekKodeAkun = preg_replace('/[0-9]+/', '', $finansial->elemen_finansial);
                            if ($cekKodeAkun == 'rekening_bendahara'){
                                $kodeAkun = $rincian->sts->rekeningBendahara->kode_akun;
                            }else {
                                $kodeAkun = $rincianSts->kode_akun;
                            }
                            array_push($jurnalUmum, [
                                'tanggal' => $rincian->bku->tanggal,
                                'tipe' => $rincian->tipe,
                                'nomor' => $rincian->no_aktivitas,
                                'kode_unit_kerja' => $rincian->bku->kode_unit_kerja,
                                'unit_kerja' => $rincian->bku->unitKerja->nama_unit,
                                'kode_akun' => $kodeAkun,
                                'elemen' => $finansial->elemen_finansial,
                                'nominal' => $rincianSts->nominal,
                                'jenis' => $finansial->jenis_finansial,
                            ]);
                        }
    
                    }
                }
            }else if ($rincian->sp2d){
                if ($request->tipe && $request->tipe == 'sp2d' || !$request->tipe) {
                    foreach($rincian->sp2d->bast->rincianPengadaan as $rincianBast){
                        foreach ($jurnal->anggaran as $anggaran) {
                            $cekKodeAkun = preg_replace('/[0-9]+/', '', $anggaran->elemen_anggaran);
                            if ($cekKodeAkun == 'rekening_bendahara'){
                                $kodeAkun = $rincian->sp2d->rekeningBendahara->kode_akun;
                            }else {
                                $kodeAkun = $rincianBast->kode_akun;
                            }
                            array_push($jurnalUmum, [
                                'tanggal' => $rincian->bku->tanggal,
                                'tipe' => $rincian->tipe,
                                'nomor' => $rincian->no_aktivitas,
                                'kode_unit_kerja' => $rincian->bku->kode_unit_kerja,
                                'unit_kerja' => $rincian->bku->unitKerja->nama_unit,
                                'kode_akun' => $kodeAkun,
                                'elemen' => $anggaran->elemen_anggaran,
                                'nominal' => ($rincianBast->harga * $rincianBast->unit),
                                'jenis' => $anggaran->jenis_anggaran,
                            ]);
                        }
                        foreach ($jurnal->finansial as $finansial) {
                            $cekKodeAkun = preg_replace('/[0-9]+/', '', $finansial->elemen_finansial);
                            if ($cekKodeAkun == 'rekening_bendahara'){
                                $kodeAkun = $rincian->sp2d->rekeningBendahara->kode_akun;
                            }else {
                                $kodeAkun = $rincianBast->kode_akun;
                            }
                            array_push($jurnalUmum, [
                                'tanggal' => $rincian->bku->tanggal,
                                'tipe' => $rincian->tipe,
                                'nomor' => $rincian->no_aktivitas,
                                'kode_unit_kerja' => $rincian->bku->kode_unit_kerja,
                                'unit_kerja' => $rincian->bku->unitKerja->nama_unit,
                                'kode_akun' => $kodeAkun,
                                'elemen' => $finansial->elemen_finansial,
                                'nominal' => ($rincianBast->harga * $rincianBast->unit),
                                'jenis' => $finansial->jenis_finansial,
                            ]);
                        }
                    }
                }
            }else if ($rincian->setorPajak){
                if ($request->tipe && $request->tipe == 'setor_pajak' || !$request->tipe) {
                    foreach($rincian->setorPajak->setorPajak->bast->rincianPengadaan as $rincianSetorPajak){
                        foreach ($jurnal->anggaran as $anggaran) {
                            $cekKodeAkun = preg_replace('/[0-9]+/', '', $anggaran->elemen_anggaran);
                            if ($cekKodeAkun == 'rekening_bendahara'){
                                $kodeAkun = $rincian->setorPajak->setorPajak->rekeningBendahara->kode_akun;
                            }else {
                                $kodeAkun = $rincianSetorPajak->kode_akun;
                            }
                            array_push($jurnalUmum, [
                                'tanggal' => $rincian->bku->tanggal,
                                'tipe' => $rincian->tipe,
                                'nomor' => $rincian->no_aktivitas,
                                'kode_unit_kerja' => $rincian->bku->kode_unit_kerja,
                                'unit_kerja' => $rincian->bku->unitKerja->nama_unit,
                                'kode_akun' => $kodeAkun,
                                'elemen' => $anggaran->elemen_anggaran,
                                'nominal' => ($rincianSetorPajak->harga * $rincianSetorPajak->unit),
                                'jenis' => $anggaran->jenis_anggaran,
                            ]);
                        }
                        foreach ($jurnal->finansial as $finansial) {
                            $cekKodeAkun = preg_replace('/[0-9]+/', '', $finansial->elemen_finansial);
                            if ($cekKodeAkun == 'rekening_bendahara'){
                                $kodeAkun = $rincian->setorPajak->setorPajak->rekeningBendahara->kode_akun;
                            }else {
                                $kodeAkun = $rincianSetorPajak->kode_akun;
                            }
                            array_push($jurnalUmum, [
                                'tanggal' => $rincian->setorPajak->setorPajak->tanggal,
                                'tipe' => $rincian->tipe,
                                'nomor' => $rincian->no_aktivitas,
                                'kode_unit_kerja' => $rincian->bku->kode_unit_kerja,
                                'unit_kerja' => $rincian->bku->unitKerja->nama_unit,
                                'kode_akun' => $kodeAkun,
                                'elemen' => $finansial->elemen_finansial,
                                'nominal' => ($rincianBast->harga * $rincianBast->unit),
                                'jenis' => $finansial->jenis_finansial,
                            ]);
                        }
                    }
                }
            }else if ($rincian->kontrapos) {
                if ($request->tipe && $request->tipe == 'kontrapos' || !$request->tipe) {
                    foreach($rincian->kontrapos->kontraposRincian as $rincianKontrapos){
                        foreach ($jurnal->anggaran as $anggaran) {
                            $cekKodeAkun = preg_replace('/[0-9]+/', '', $anggaran->elemen_anggaran);
                            if ($cekKodeAkun == 'rekening_bendahara'){
                                $kodeAkun = $rincian->kontrapos->rekeningBendahara->kode_akun;
                            }else {
                                $kodeAkun = $rincianKontrapos->kode_akun;
                            }
                            array_push($jurnalKontrapos, [
                                'tanggal' => $rincian->bku->tanggal,
                                'tipe' => $rincian->tipe,
                                'nomor' => $rincian->no_aktivitas,
                                'kode_unit_kerja' => $rincian->bku->kode_unit_kerja,
                                'unit_kerja' => $rincian->bku->unitKerja->nama_unit,
                                'kode_akun' => $kodeAkun,
                                'elemen' => $anggaran->elemen_anggaran,
                                'nominal' => $rincianKontrapos->nominal,
                                'jenis' => $anggaran->jenis_anggaran,
                            ]);
                        }
                        foreach ($jurnal->finansial as $finansial) {
                            $cekKodeAkun = preg_replace('/[0-9]+/', '', $finansial->elemen_finansial);
                            if ($cekKodeAkun == 'rekening_bendahara'){
                                $kodeAkun = $rincian->kontrapos->rekeningBendahara->kode_akun;
                            }else {
                                $kodeAkun = $rincianKontrapos->kode_akun;
                            }
                            array_push($jurnalKontrapos, [
                                'tanggal' => $rincian->bku->tanggal,
                                'tipe' => $rincian->tipe,
                                'nomor' => $rincian->no_aktivitas,
                                'kode_unit_kerja' => $rincian->bku->kode_unit_kerja,
                                'unit_kerja' => $rincian->bku->unitKerja->nama_unit,
                                'kode_akun' => $kodeAkun,
                                'elemen' => $finansial->elemen_finansial,
                                'nominal' => $rincianKontrapos->nominal,
                                'jenis' => $finansial->jenis_finansial,
                            ]);
                        }
    
                    }
                }
            }
        }

        $forgetedIndex = [];
        $jurnalUmum = collect($jurnalUmum);
        $allJurnalUmum = $jurnalUmum->map(function ($item, $index) use(&$forgetedIndex, $request){
            $relationName = 'akun'.preg_replace('/[^0-9]/', '', $item['elemen']);
            $columnSelect = 'kode_akun_'.preg_replace('/[^0-9]/', '', $item['elemen']);
            if ($item['elemen'] == 'rekening_bendahara' || $item['elemen'] == 'kode_akun') {
                $columnSelect = 'kode_akun';
            }
            $mapAkun = $this->mapAkunFinance->getMapAkun($item['kode_akun'], $relationName);

            if ($request->kode_akun){
                if ($mapAkun && preg_match("/^{$request->kode_akun}/m", $mapAkun->{$columnSelect})) {
                    $item['kode_map_akun'] = $mapAkun->{$columnSelect};
                    $item['nama_map_akun'] = $mapAkun->{$relationName}->nama_akun;
                    return $item;
                } else {
                    $forgetedIndex[] = $index;
                }
            }else {
                if ($mapAkun){
                    $item['kode_map_akun'] = $mapAkun->{$columnSelect};
                    $item['nama_map_akun'] = $mapAkun->{$relationName}->nama_akun;
                    return $item;
                }else {
                    $forgetedIndex[] = $index;
                }
            }
        });
        $allJurnalUmum = $allJurnalUmum->sortBy('tipe');
        $allJurnalUmum = $allJurnalUmum->forget($forgetedIndex)->values()->all();

        $forgetLo = [];
        $saldoAwalLo = collect([]);
        if ($request->tipe && $request->tipe == 'saldo_awal_lo' || !$request->tipe) {

            $prefixPenomoranSaldoAwalLo = explode('/', $prefixSaldoAwalLo->format_penomoran);


            $saldoAwalLo = $this->saldoAwal->getRincianSaldoAwal(auth()->user()->kode_unit_kerja, SaldoAwal::LO, $request);
            $saldoAwalLo->map(function ($item) use ($prefixPenomoranSaldoAwalLo) {

                if ($item->saldoAwal->nomor_otomatis) {
                    $nomorFix = nomor_fix($prefixPenomoranSaldoAwalLo, $item->saldoAwal->nomor, $item->saldoAwal->kode_unit_kerja);
                    $item->nomorfix = $nomorFix;
                } else {
                    $item->nomorfix = $item->nomor;
                }
            });
        }
        if ($request->kode_akun) {
            $saldoAwalLo = $saldoAwalLo->map(function ($item, $indexLo) use ($request, &$forgetLo) {
                if (preg_match("/^{$request->kode_akun}/m", $item->akun->kode_akun)) {
                    return $item;
                }else {
                    $forgetLo[] = $indexLo;
                }
            });
        }
        $saldoAwalLo = $saldoAwalLo->forget($forgetLo)->values()->all();

        $saldoAwalNeraca = collect([]);
        if ($request->tipe && $request->tipe == 'saldo_awal_neraca' || !$request->tipe) {

            $prefixPenomoranSaldoAwalNeraca = explode('/', $prefixSaldoAwalNeraca->format_penomoran);

            $this->saldoAwal->makeModel();
            $saldoAwalNeraca = $this->saldoAwal->getRincianSaldoAwal(auth()->user()->kode_unit_kerja, SaldoAwal::NERACA, $request);
            $saldoAwalNeraca->map(function ($item) use ($prefixPenomoranSaldoAwalNeraca) {

                if ($item->saldoAwal->nomor_otomatis) {
                    $nomorFix = nomor_fix($prefixPenomoranSaldoAwalNeraca, $item->saldoAwal->nomor, $item->saldoAwal->kode_unit_kerja);
                    $item->nomorfix = $nomorFix;
                } else {
                    $item->nomorfix = $item->nomor;
                }
            });
        }

        $forgetNeraca = [];
        if ($request->kode_akun){
            $saldoAwalNeraca = $saldoAwalNeraca->map(function ($item, $indexNeraca) use($request, &$forgetNeraca) {
                if (preg_match("/^{$request->kode_akun}/m", $item->akun->kode_akun)){
                    return $item;
                }else {
                    $forgetNeraca[] = $indexNeraca;
                }
            });
        }
        $saldoAwalNeraca = $saldoAwalNeraca->forget($forgetNeraca)->values()->all();

        $jurnalPenyesuaian = collect([]);
        if ($request->tipe && $request->tipe == 'jurnal_penyesuaian' || !$request->tipe) {

            $prefixPenomoranJurnalPenyesuaian = explode('/', $prefixJurnalPenyesuaian->format_penomoran);

            $jurnalPenyesuaian = $this->jurnalPenyesuaian->getRincian(auth()->user()->kode_unit_kerja, $request);
            $jurnalPenyesuaian->map(function ($item) use($prefixPenomoranJurnalPenyesuaian){
                if ($item->jurnalPenyesuaian->nomor_otomatis) {
                    $nomorFix = nomor_fix($prefixPenomoranJurnalPenyesuaian, $item->jurnalPenyesuaian->nomor, $item->jurnalPenyesuaian->kode_unit_kerja);
                    $item->nomorfix = $nomorFix;
                } else {
                    $item->nomorfix = $item->nomor;
                }
            });
        }

        $unitKerja = $this->unitKerja->get();

        return view('admin.jurnal_umum.index', compact(
            'saldoAwalLo', 'saldoAwalNeraca', 'allJurnalUmum','jurnalPenyesuaian', 'unitKerja'
        ));
    }
}

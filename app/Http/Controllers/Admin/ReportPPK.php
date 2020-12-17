<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rba;
use App\Models\SaldoAwal;
use App\Models\User;
use App\Repositories\Akutansi\JurnalPenyesuaianRepository;
use App\Repositories\Akutansi\SaldoAwalRepository;
use App\Repositories\Akutansi\SetupJurnalRepository;
use App\Repositories\BKU\BKURincianRepository;
use App\Repositories\DataDasar\AkunRepository;
use App\Repositories\Organisasi\MapAkunFinanceRepository;
use App\Repositories\Organisasi\PejabatUnitRepository;
use App\Repositories\Organisasi\UnitKerjaRepository;
use App\Repositories\RBA\RBARepository;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

class ReportPPK extends Controller
{
    /**
     * Unit kerja repository
     *
     * @var UnitKerjaRepository
     */
    private $unitKerja;

    /**
     * Pejabat unit repository
     *
     * @var PejabatUnitRepository
     */
    private $pejabatUnit;

    /**
     * Undocumented variable
     *
     * @var [type]
     */
    private $rba;

    /**
     * Akun repository
     *
     * @var AkunRepository
     */
    private $akun;

    /**
     * Bku rincian repository
     *
     * @var BkuRincianRepository
     */
    private $bkuRincian;

    /**
     * Setup jurnal repository
     *
     * @var SetupJurnalRepository
     */
    private $setupJurnal;

    /**
     * Map akun finance repository
     *
     * @var MapAkunFinanceRepository
     */
    private $mapAkunFinance;

    /**
     * Saldo awal repository
     *
     * @var SaldoAwalRepository
     */
    private $saldoAwal;

    /**
     * Jurnal penyesuaian repository
     *
     * @var JurnalPenyesuaianRepository
     */
    private $jurnalPenyesuaian;

    public function __construct(
        UnitKerjaRepository $unitKerja,
        PejabatUnitRepository $pejabatUnit,
        RBARepository $rba,
        AkunRepository $akun,
        BKURincianRepository $bkuRincian,
        SetupJurnalRepository $setupJurnal,
        MapAkunFinanceRepository $mapAkunFinance,
        SaldoAwalRepository $saldoAwal,
        JurnalPenyesuaianRepository $jurnalPenyesuaian
    )
    {
       $this->unitKerja = $unitKerja;
       $this->pejabatUnit = $pejabatUnit;
       $this->rba = $rba;
       $this->akun = $akun;
       $this->bkuRincian = $bkuRincian;
       $this->setupJurnal = $setupJurnal;
       $this->mapAkunFinance = $mapAkunFinance;
       $this->saldoAwal = $saldoAwal;
       $this->jurnalPenyesuaian = $jurnalPenyesuaian;
    }

    public function penjabaranRealisasiAnggaran(Request $request)
    {
        $statusPerubahan = auth()->user()->statusAnggaran->status_perubahan;
        $fieldNominal = 'nominal';
        if ($statusPerubahan == 'PERUBAHAN'){
            $fieldNominal = 'nominal_pak';
        }
        $unitKerja = $this->unitKerja->findBy('kode', '=', $request->unit_kerja);

        $rba1 =  $this->rba->getAnggaranRba1($unitKerja->kode);
        $rba2 =  $this->rba->getAnggaranRba221($unitKerja->kode);
        $rba31 =  $this->rba->getAnggaranRba311($unitKerja->kode);
        $bkuRincian = $this->bkuRincian->getBkuJurnalUmum($request);
        $jurnalUmum = [];
        $jurnalKontrapos = [];
        $rekeningBendahara = ['rekening_bendahara', 'rekening_bendahara1', 'rekening_bendahara2', 'rekening_bendahara3'];
        foreach ($bkuRincian as $rincian) {
            $jurnal = $this->setupJurnal->findBy('formulir', '=', strtolower($rincian->tipe), ['*'], ['anggaran', 'finansial']);
            $this->setupJurnal->makeModel();
            if ($rincian->sts) {
                if ($request->tipe && $request->tipe == 'sts' || !$request->tipe) {
                    foreach ($rincian->sts->rincianSts as $rincianSts) {
                        foreach ($jurnal->anggaran as $anggaran) {
                            $cekKodeAkun = preg_replace('/[0-9]+/', '', $anggaran->elemen_anggaran);
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->sts->rekeningBendahara->kode_akun;
                            } else {
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
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->sts->rekeningBendahara->kode_akun;
                            } else {
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
            } else if ($rincian->sp2d) {
                if ($request->tipe && $request->tipe == 'sp2d' || !$request->tipe) {
                    foreach ($rincian->sp2d->bast->rincianPengadaan as $rincianBast) {
                        foreach ($jurnal->anggaran as $anggaran) {
                            $cekKodeAkun = preg_replace('/[0-9]+/', '', $anggaran->elemen_anggaran);
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->sp2d->rekeningBendahara->kode_akun;
                            } else {
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
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->sp2d->rekeningBendahara->kode_akun;
                            } else {
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
            } else if ($rincian->setorPajak) {
                if ($request->tipe && $request->tipe == 'setor_pajak' || !$request->tipe) {
                    foreach ($rincian->setorPajak->setorPajak->bast->rincianPengadaan as $rincianSetorPajak) {
                        foreach ($jurnal->anggaran as $anggaran) {
                            $cekKodeAkun = preg_replace('/[0-9]+/', '', $anggaran->elemen_anggaran);
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->setorPajak->setorPajak->rekeningBendahara->kode_akun;
                            } else {
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
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->setorPajak->setorPajak->rekeningBendahara->kode_akun;
                            } else {
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
                                'nominal' => ($rincianSetorPajak->harga * $rincianSetorPajak->unit),
                                'jenis' => $finansial->jenis_finansial,
                            ]);
                        }
                    }
                }
            } else if ($rincian->kontrapos) {
                if ($request->tipe && $request->tipe == 'kontrapos' || !$request->tipe) {
                    foreach ($rincian->kontrapos->kontraposRincian as $rincianKontrapos) {
                        foreach ($jurnal->anggaran as $anggaran) {
                            $cekKodeAkun = preg_replace('/[0-9]+/', '', $anggaran->elemen_anggaran);
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->kontrapos->rekeningBendahara->kode_akun;
                            } else {
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
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->kontrapos->rekeningBendahara->kode_akun;
                            } else {
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
        $allJurnalUmum = $jurnalUmum->map(function ($item, $index) use (&$forgetedIndex, $request) {
            $relationName = 'akun' . preg_replace('/[^0-9]/', '', $item['elemen']);
            $columnSelect = 'kode_akun_' . preg_replace('/[^0-9]/', '', $item['elemen']);
            if ($item['elemen'] == 'rekening_bendahara' || $item['elemen'] == 'kode_akun') {
                $columnSelect = 'kode_akun';
            }
            $mapAkun = $this->mapAkunFinance->getMapAkun($item['kode_akun'], $relationName);

            if ($request->kode_akun) {
                if ($mapAkun && preg_match("/^{$request->kode_akun}/m", $mapAkun->{$columnSelect})) {
                    $item['kode_map_akun'] = $mapAkun->{$columnSelect};
                    $item['nama_map_akun'] = $mapAkun->{$relationName}->nama_akun;
                    return $item;
                } else {
                    $forgetedIndex[] = $index;
                }
            } else {
                if ($mapAkun) {
                    $item['kode_map_akun'] = $mapAkun->{$columnSelect};
                    $item['nama_map_akun'] = $mapAkun->{$relationName}->nama_akun;
                    return $item;
                } else {
                    $forgetedIndex[] = $index;
                }
            }
        });


        $saldoAwalLo = $this->saldoAwal->getRincianSaldoAwal($unitKerja->kode, SaldoAwal::LO, $request);
        $saldoAwalNeraca = $this->saldoAwal->getRincianSaldoAwal($unitKerja->kode, SaldoAwal::NERACA, $request);

        foreach ($saldoAwalNeraca as $key => $value) {
            $allJurnalUmum->push([
                "tanggal" => '',
                "tipe" => "Saldo Awal Neraca",
                "nomor" => '',
                "kode_unit_kerja" => $unitKerja->kode,
                "unit_kerja" => $unitKerja->nama_unit,
                "kode_akun" => '',
                "elemen" => "kode_akun",
                "nominal" => $value->debet > 0 ? $value->debet : $value->kredit,
                "jenis" => '',
                "kode_map_akun" => $value->akun->kode_akun,
                "nama_map_akun" => ''
            ]);
        }

        foreach ($saldoAwalLo as $key => $value) {
            $allJurnalUmum->push([
                "tanggal" => '',
                "tipe" => "Saldo Awal Lo",
                "nomor" => '',
                "kode_unit_kerja" => $unitKerja->kode,
                "unit_kerja" => $unitKerja->nama_unit,
                "kode_akun" => '',
                "elemen" => "kode_akun",
                "nominal" => $value->debet > 0 ? $value->debet : $value->kredit,
                "jenis" => '',
                "kode_map_akun" => $value->akun->kode_akun,
                "nama_map_akun" => ''
            ]);
        }
        $jurnalPenyesuaian = $this->jurnalPenyesuaian->getRincian($unitKerja->kode, $request);
        foreach ($jurnalPenyesuaian as $key => $value) {
            $allJurnalUmum->push([
                "tanggal" => '',
                "tipe" => "Jurnal Penyesuaian",
                "nomor" => '',
                "kode_unit_kerja" => $unitKerja->kode,
                "unit_kerja" => $unitKerja->nama_unit,
                "kode_akun" => '',
                "elemen" => "kode_akun",
                "nominal" => $value->debet,
                "jenis" => '',
                "kode_map_akun" => $value->akun->kode_akun,
                "nama_map_akun" => ''
            ]);
        }

        $allJurnalUmum = $allJurnalUmum->sortBy('tipe');
        $allJurnalUmum = $allJurnalUmum->forget($forgetedIndex)->values()->all();

        $anggaranKolom6  = 0; 
        $realisasiKolom6  = 0; 
        $anggaranKolom12 = 0;
        $realisasiKolom12 = 0;
        $anggaranKolom18 = 0;
        $realisasiKolom18 = 0;
        $anggaranKolom19 = 0;
        $realisasiKolom19 = 0;
        $anggaranKolom20 = 0;
        $realisasiKolom20 = 0;
        $anggaranKolom21 = 0;
        $realisasiKolom21 = 0;
        $anggaranKolom22 = 0;
        $realisasiKolom22 = 0;
        $anggaranKolom31 = 0;
        $realisasiKolom31 = 0;


        $rba1->rincianSumberDana->map(function ($item) use(&$anggaranKolom6, $fieldNominal){
            if ($item->akun->tipe == 4 && $item->akun->kelompok == 1 && $item->akun->jenis == 4 && $item->akun->objek == 16){
                $anggaranKolom6 += $item->$fieldNominal;
            }
        });

        $rba2->rincianSumberDana->map(function ($item) use (&$anggaranKolom12, $fieldNominal) {
            if (preg_match("/^5.1/m", $item->akun->kode_akun) || preg_match("/^5.2.1/m", $item->akun->kode_akun) || preg_match("/^5.2.2/m", $item->akun->kode_akun)) {
                $anggaranKolom12 += $item->$fieldNominal;
            }
        });

        $rba2->rincianSumberDana->map(function ($item) use (&$anggaranKolom18, $fieldNominal) {
            if (preg_match("/^5.2.3.01/m", $item->akun->kode_akun)) {
                $anggaranKolom18 += $item->$fieldNominal;
            }
        });
        
        $rba2->rincianSumberDana->map(function ($item) use (&$anggaranKolom19, $fieldNominal) {
            for ($i = 3; $i <= 25; $i++) {
                if (strlen($i) == 1) {
                    $i = '0' . $i;
                }
                if (preg_match("/^5.2.3.$i/m", $item->akun->kode_akun)) {
                    $anggaranKolom19 += $item->$fieldNominal;
                }
            }
        });
        
        $rba2->rincianSumberDana->map(function ($item) use (&$anggaranKolom20, $fieldNominal) {
            if (preg_match("/^5.2.3.26/m", $item->akun->kode_akun)) {
                $anggaranKolom20 += $item->$fieldNominal;
            }
        });
        
        if ($rba31){
            $rba31->rincianSumberDana->map(function ($item) use (&$anggaranKolom31, $fieldNominal) {
                if (preg_match("/^6.1.1/m", $item->akun->kode_akun)) {
                    $anggaranKolom31 += $item->$fieldNominal;
                }
            });
        }

        foreach ($allJurnalUmum as $item) {
            if (preg_match("/^4.1.4.16/m", $item['kode_map_akun'])) {
                $realisasiKolom6 += $item['nominal'];
            } elseif (preg_match("/^5.1/m", $item['kode_map_akun']) || preg_match("/5.2.1/m", $item['kode_map_akun']) || preg_match("/5.2.2/m", $item['kode_map_akun']) && ($item['tipe'] == 'SP2D' || $item['tipe'] == 'STS')) {
                $realisasiKolom12 += $item['nominal'];
            } elseif (preg_match("/^5.2.3.01/m", $item['kode_map_akun'])) {
                $realisasiKolom18 += $item['nominal'];
            } elseif (preg_match("/^6.1.1/m", $item['kode_map_akun'])) {
                $realisasiKolom31 += $item['nominal'];
            } elseif (preg_match("/^5.2.3.26/m", $item['kode_map_akun'])){
                $realisasiKolom20 += $item['nominal'];
            } else {
                $realisasiKolom19 += $this->checkRealisasi19($item);
            }
        }

        $pejabat = $this->pejabatUnit->getAllPejabat($request->unit_kerja);

        $kepalaSkpd = clone $pejabat;
        $kepalaSkpd = $kepalaSkpd->where('jabatan_id', 1)->first();
        $anggaranKolom24 = $anggaranKolom18+$anggaranKolom19;
        $realisasiKolom24 = $realisasiKolom18+$realisasiKolom19;

        $pdf = PDF::loadview('admin.report.form_realisasi_anggaran', compact(
            'request', 'unitKerja', 'kepalaSkpd', 'realisasiKolom6', 'anggaranKolom6',
            'realisasiKolom12', 'anggaranKolom12', 'realisasiKolom18', 'anggaranKolom18',
            'realisasiKolom19', 'anggaranKolom19', 'anggaranKolom24', 'realisasiKolom24',
            'anggaranKolom31', 'realisasiKolom31', 'realisasiKolom20', 'anggaranKolom20'
        ));
        return $pdf->stream('report_realisasi_anggaran.pdf', ['Attachment' => false]);
    }

    private function checkRealisasi19($mapAkun){
        for ($i = 3; $i <= 25; $i++) {
            if (strlen($i) == 1) {
                $i = '0' . $i;
            }
            if (preg_match("/^5.2.3.$i/m", $mapAkun['kode_map_akun'])) {
                return $mapAkun['nominal'];
            }
        }
        return 0;
    }

    public function penjabaranApbd(Request $request)
    {
        $unitKerja = $this->unitKerja->findBy('kode', '=', $request->unit_kerja);

        $rba1 =  $this->rba->getAnggaranRba1($unitKerja->kode);
        $akunId = $rba1->rincianAnggaran->pluck('akun_id')->toArray();

        $reportRba1 = [];
        $allKodeAkunRba1 = [];
        foreach ($rba1->rincianAnggaran as $item) {
            if (!in_array($item->akun->kode_akun, $allKodeAkunRba1)) {
                array_push($allKodeAkunRba1, $item->akun->kode_akun);
            }
        }

        // get unique kode akun 
        $dataKode = [];
        foreach ($allKodeAkunRba1 as $item) {
            $kode = substr($item, 0, 8);
            if (!in_array($kode, $dataKode)) {
                $dataKode[] = $kode;
            }
        }

        // get parent from unique kode akun
        $kodeParent = [];
        foreach ($dataKode as $kode) {
            $explode = explode('.', $kode);
            $parents = $this->akun->getAkunParent($explode[0], $explode[1], $explode[2], $explode[3])->pluck('kode_akun')->toArray();
            foreach ($parents as $akunParent) {
                array_push($kodeParent, $akunParent);
            }
        }
        $whereAllKodeAKun1 = collect($allKodeAkunRba1)->merge(collect($kodeParent))->sort();

        $whereAkun = function ($query) use ($whereAllKodeAKun1) {
            $query->whereIn('kode_akun', $whereAllKodeAKun1);
        };

        $akunRba1 = $this->akun->get(['*'], $whereAkun)->sortBy('kode_akun');


        foreach ($whereAllKodeAKun1 as $item) {
            $reportRba1["{$item}"] = 0;
            if ($rba1->statusAnggaran->status_perubahan == Rba::STATUS_PERUBAHAN_PERUBAHAN) {
                $reportRba1["{$item}_pak"] = 0;
            }

            foreach ($rba1->rincianSumberDana as $dataRba) {
                if (preg_match("/{$item}/m", $dataRba->akun->kode_akun)) {
                    $reportRba1["{$item}"] += $dataRba->nominal;
                    if ($rba1->statusAnggaran->status_perubahan  == Rba::STATUS_PERUBAHAN_PERUBAHAN) {
                        $reportRba1["{$item}_pak"] += $dataRba->nominal_pak;
                    }
                }
            }
        }

        $rba1->total_all = $rba1->rincianSumberDana->sum('nominal');
        if ($rba1->statusAnggaran->status_perubahan == Rba::STATUS_PERUBAHAN_PERUBAHAN) {
            $rba1->total_all = $rba1->rincianSumberDana->sum('nominal_pak');
        }

        $rba2 =  $this->rba->getAnggaranRba221($unitKerja->kode);
        $akunId = $rba2->rincianAnggaran->pluck('akun_id')->toArray();

        $reportRba2 = [];
        $allKodeAkunRba2 = [];
        foreach ($rba2->rincianAnggaran as $item) {
            if (!in_array($item->akun->kode_akun, $allKodeAkunRba2)) {
                array_push($allKodeAkunRba2, $item->akun->kode_akun);
            }
        }

        // get unique kode akun 
        $dataKodeRba2 = [];
        foreach ($allKodeAkunRba2 as $item) {
            $kode = substr($item, 0, 8);
            if (!in_array($kode, $dataKode)) {
                $dataKodeRba2[] = $kode;
            }
        }

        // get parent from unique kode akun
        $kodeParentRba2 = [];
        foreach ($dataKodeRba2 as $kode) {
            $explode = explode('.', $kode);
            $parents = $this->akun->getAkunParent($explode[0], $explode[1], $explode[2], $explode[3])->pluck('kode_akun')->toArray();
            foreach ($parents as $akunParent) {
                array_push($kodeParentRba2, $akunParent);
            }
        }

        $whereAllKodeAKun2 = collect($allKodeAkunRba2)->merge(collect($kodeParentRba2))->sort();

        $whereAkun2 = function ($query) use ($whereAllKodeAKun2) {
            $query->whereIn('kode_akun', $whereAllKodeAKun2);
        };

        $this->akun->makeModel();
        $akunRba2 = $this->akun->get(['*'], $whereAkun2)->sortBy('kode_akun');

        foreach ($whereAllKodeAKun2 as $item) {
            $reportRba2["{$item}"] = 0;
            if ($rba1->statusAnggaran->status_perubahan == Rba::STATUS_PERUBAHAN_PERUBAHAN) {
                $reportRba2["{$item}_pak"] = 0;
            }

            foreach ($rba2->rincianSumberDana as $dataRba) {
                if (preg_match("/{$item}/m", $dataRba->akun->kode_akun)) {
                    $reportRba2["{$item}"] += $dataRba->nominal;
                    if ($rba2->statusAnggaran->status_perubahan  == Rba::STATUS_PERUBAHAN_PERUBAHAN) {
                        if (isset($reportRba2["{$item}_pak"])){
                            $reportRba2["{$item}_pak"] += $dataRba->nominal_pak;
                        }else {
                            $reportRba2["{$item}_pak"] = 0;
                            $reportRba2["{$item}_pak"] += $dataRba->nominal_pak;
                        }
                    }
                }
            }
        }

        $rba2->total_all = $rba2->rincianSumberDana->sum('nominal');
        if ($rba2->statusAnggaran->status_perubahan == Rba::STATUS_PERUBAHAN_PERUBAHAN) {
            $rba2->total_all = $rba2->rincianSumberDana->sum('nominal_pak');
        }


        $bkuRincian = $this->bkuRincian->getBkuJurnalUmum($request);

        $jurnalUmum = [];
        $jurnalKontrapos = [];
        $rekeningBendahara = ['rekening_bendahara', 'rekening_bendahara1', 'rekening_bendahara2', 'rekening_bendahara3'];
        foreach ($bkuRincian as $rincian) {
            $jurnal = $this->setupJurnal->findBy('formulir', '=', strtolower($rincian->tipe), ['*'], ['anggaran', 'finansial']);
            $this->setupJurnal->makeModel();
            if ($rincian->sts) {
                if ($request->tipe && $request->tipe == 'sts' || !$request->tipe) {
                    foreach ($rincian->sts->rincianSts as $rincianSts) {
                        foreach ($jurnal->anggaran as $anggaran) {
                            $cekKodeAkun = preg_replace('/[0-9]+/', '', $anggaran->elemen_anggaran);
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->sts->rekeningBendahara->kode_akun;
                            } else {
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
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->sts->rekeningBendahara->kode_akun;
                            } else {
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
            } else if ($rincian->sp2d) {
                if ($request->tipe && $request->tipe == 'sp2d' || !$request->tipe) {
                    foreach ($rincian->sp2d->bast->rincianPengadaan as $rincianBast) {
                        foreach ($jurnal->anggaran as $anggaran) {
                            $cekKodeAkun = preg_replace('/[0-9]+/', '', $anggaran->elemen_anggaran);
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->sp2d->rekeningBendahara->kode_akun;
                            } else {
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
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->sp2d->rekeningBendahara->kode_akun;
                            } else {
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
            } else if ($rincian->setorPajak) {
                if ($request->tipe && $request->tipe == 'setor_pajak' || !$request->tipe) {
                    foreach ($rincian->setorPajak->setorPajak->bast->rincianPengadaan as $rincianSetorPajak) {
                        foreach ($jurnal->anggaran as $anggaran) {
                            $cekKodeAkun = preg_replace('/[0-9]+/', '', $anggaran->elemen_anggaran);
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->setorPajak->setorPajak->rekeningBendahara->kode_akun;
                            } else {
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
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->setorPajak->setorPajak->rekeningBendahara->kode_akun;
                            } else {
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
                                'nominal' => ($rincianSetorPajak->harga * $rincianSetorPajak->unit),
                                'jenis' => $finansial->jenis_finansial,
                            ]);
                        }
                    }
                }
            } else if ($rincian->kontrapos) {
                if ($request->tipe && $request->tipe == 'kontrapos' || !$request->tipe) {
                    foreach ($rincian->kontrapos->kontraposRincian as $rincianKontrapos) {
                        foreach ($jurnal->anggaran as $anggaran) {
                            $cekKodeAkun = preg_replace('/[0-9]+/', '', $anggaran->elemen_anggaran);
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->kontrapos->rekeningBendahara->kode_akun;
                            } else {
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
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->kontrapos->rekeningBendahara->kode_akun;
                            } else {
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
        $allJurnalUmum = $jurnalUmum->map(function ($item, $index) use (&$forgetedIndex) {
            $relationName = 'akun' . preg_replace('/[^0-9]/', '', $item['elemen']);
            $columnSelect = 'kode_akun_' . preg_replace('/[^0-9]/', '', $item['elemen']);
            if ($item['elemen'] == 'rekening_bendahara' || $item['elemen'] == 'kode_akun') {
                $columnSelect = 'kode_akun';
            }
            $mapAkun = $this->mapAkunFinance->getMapAkun($item['kode_akun'], $relationName);

            if ($mapAkun) {
                $item['kode_map_akun'] = $mapAkun->{$columnSelect};
                $item['nama_map_akun'] = $mapAkun->{$relationName}->nama_akun;
                return $item;
            } else {
                $forgetedIndex[] = $index;
            }
        });
        
        $saldoAwalLo = $this->saldoAwal->getRincianSaldoAwal($unitKerja->kode, SaldoAwal::LO, $request);
        $saldoAwalNeraca = $this->saldoAwal->getRincianSaldoAwal($unitKerja->kode, SaldoAwal::NERACA, $request);

        foreach ($saldoAwalNeraca as $key => $value) {
            $allJurnalUmum->push([
                "tanggal" => '',
                "tipe" => "Saldo Awal Neraca",
                "nomor" => '',
                "kode_unit_kerja" => $unitKerja->kode,
                "unit_kerja" => $unitKerja->nama_unit,
                "kode_akun" => '',
                "elemen" => "kode_akun",
                "nominal" => $value->debet > 0 ? $value->debet : $value->kredit,
                "jenis" => '',
                "kode_map_akun" => $value->akun->kode_akun,
                "nama_map_akun" => ''
            ]);
        }

        foreach ($saldoAwalLo as $key => $value) {
            $allJurnalUmum->push([
                "tanggal" => '',
                "tipe" => "Saldo Awal Lo",
                "nomor" => '',
                "kode_unit_kerja" => $unitKerja->kode,
                "unit_kerja" => $unitKerja->nama_unit,
                "kode_akun" => '',
                "elemen" => "kode_akun",
                "nominal" => $value->debet > 0 ? $value->debet : $value->kredit,
                "jenis" => '',
                "kode_map_akun" => $value->akun->kode_akun,
                "nama_map_akun" => ''
            ]);
        }
        $jurnalPenyesuaian = $this->jurnalPenyesuaian->getRincian($unitKerja->kode, $request);
        foreach ($jurnalPenyesuaian as $key => $value) {
            $allJurnalUmum->push([
                "tanggal" => '',
                "tipe" => "Jurnal Penyesuaian",
                "nomor" => '',
                "kode_unit_kerja" => $unitKerja->kode,
                "unit_kerja" => $unitKerja->nama_unit,
                "kode_akun" => '',
                "elemen" => "kode_akun",
                "nominal" => $value->debet,
                "jenis" => '',
                "kode_map_akun" => $value->akun->kode_akun,
                "nama_map_akun" => ''
            ]);
        }

        $allJurnalUmum = $allJurnalUmum->sortBy('tipe');
        $allJurnalUmum = $allJurnalUmum->forget($forgetedIndex)->values()->all();
        $allJurnalUmum = collect($allJurnalUmum);

        $dataJurnalUmum = [];
        $realisasi = [];
        $akunRealisasi = [];
        foreach ($allJurnalUmum as $data) {
            if (isset($dataJurnalUmum[$data['kode_map_akun']])){
                $dataJurnalUmum[$data['kode_map_akun']] += $data['nominal'];
            }else {
                $dataJurnalUmum[$data['kode_map_akun']] = $data['nominal'];
                array_push($akunRealisasi, $data['kode_map_akun']);
            }
        }
        
        $kodeParentRealisasi = [];
        foreach ($akunRealisasi as $kode) {
            $explode = explode('.', $kode);
            $parents = $this->akun->getAkunParent($explode[0], $explode[1], $explode[2], $explode[3])->pluck('kode_akun')->toArray();
            foreach ($parents as $akunParent) {
                array_push($kodeParentRealisasi, $akunParent);
            }
        }

        
        $allAkunRealisasi = array_merge($akunRealisasi, $kodeParentRealisasi);
        $allAkunRealisasi = collect($allAkunRealisasi)->sort()->values()->all();
        // dd($allAkunRealisasi);
        
        foreach ($allAkunRealisasi as $item) {
            $realisasi[$item] = 0;
            foreach ($dataJurnalUmum as $key => $value) {
                if (preg_match("/^{$item}/m", $key)) {
                    $realisasi[$item] += $dataJurnalUmum[$key];
                }
            }
        }
        
        $pdf = PDF::loadview('admin.report.form_penjabaran_apbd', compact(
            'request', 'unitKerja', 'rba1', 'akunRba1', 'reportRba1', 'rba2', 'akunRba2', 'reportRba2',
            'allJurnalUmum','realisasi'
        ))->setPaper('a4', 'landscape');
        return $pdf->stream('report_penjabaran_apbd.pdf', ['Attachment' => false]);
    }

    public function laporanOperasional(Request $request)
    {
        $unitKerja = $this->unitKerja->findBy('kode', '=', $request->unit_kerja);

        $pejabat = $this->pejabatUnit->getAllPejabat($request->unit_kerja);

        $bkuRincian = $this->bkuRincian->getBkuJurnalUmum($request);

        $jurnalUmum = [];
        $jurnalKontrapos = [];
        $rekeningBendahara = ['rekening_bendahara', 'rekening_bendahara1', 'rekening_bendahara2', 'rekening_bendahara3'];
        foreach ($bkuRincian as $rincian) {
            $jurnal = $this->setupJurnal->findBy('formulir', '=', strtolower($rincian->tipe), ['*'], ['anggaran', 'finansial']);
            $this->setupJurnal->makeModel();
            if ($rincian->sts) {
                if ($request->tipe && $request->tipe == 'sts' || !$request->tipe) {
                    foreach ($rincian->sts->rincianSts as $rincianSts) {
                        foreach ($jurnal->anggaran as $anggaran) {
                            $cekKodeAkun = preg_replace('/[0-9]+/', '', $anggaran->elemen_anggaran);
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->sts->rekeningBendahara->kode_akun;
                            } else {
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
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->sts->rekeningBendahara->kode_akun;
                            } else {
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
            } else if ($rincian->sp2d) {
                if ($request->tipe && $request->tipe == 'sp2d' || !$request->tipe) {
                    foreach ($rincian->sp2d->bast->rincianPengadaan as $rincianBast) {
                        foreach ($jurnal->anggaran as $anggaran) {
                            $cekKodeAkun = preg_replace('/[0-9]+/', '', $anggaran->elemen_anggaran);
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->sp2d->rekeningBendahara->kode_akun;
                            } else {
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
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->sp2d->rekeningBendahara->kode_akun;
                            } else {
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
            } else if ($rincian->setorPajak) {
                if ($request->tipe && $request->tipe == 'setor_pajak' || !$request->tipe) {
                    foreach ($rincian->setorPajak->setorPajak->bast->rincianPengadaan as $rincianSetorPajak) {
                        foreach ($jurnal->anggaran as $anggaran) {
                            $cekKodeAkun = preg_replace('/[0-9]+/', '', $anggaran->elemen_anggaran);
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->setorPajak->setorPajak->rekeningBendahara->kode_akun;
                            } else {
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
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->setorPajak->setorPajak->rekeningBendahara->kode_akun;
                            } else {
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
                                'nominal' => ($rincianSetorPajak->harga * $rincianSetorPajak->unit),
                                'jenis' => $finansial->jenis_finansial,
                            ]);
                        }
                    }
                }
            } else if ($rincian->kontrapos) {
                if ($request->tipe && $request->tipe == 'kontrapos' || !$request->tipe) {
                    foreach ($rincian->kontrapos->kontraposRincian as $rincianKontrapos) {
                        foreach ($jurnal->anggaran as $anggaran) {
                            $cekKodeAkun = preg_replace('/[0-9]+/', '', $anggaran->elemen_anggaran);
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->kontrapos->rekeningBendahara->kode_akun;
                            } else {
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
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->kontrapos->rekeningBendahara->kode_akun;
                            } else {
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
        $allJurnalUmum = $jurnalUmum->map(function ($item, $index) use (&$forgetedIndex) {
            $relationName = 'akun' . preg_replace('/[^0-9]/', '', $item['elemen']);
            $columnSelect = 'kode_akun_' . preg_replace('/[^0-9]/', '', $item['elemen']);
            if ($item['elemen'] == 'rekening_bendahara' || $item['elemen'] == 'kode_akun') {
                $columnSelect = 'kode_akun';
            }
            $mapAkun = $this->mapAkunFinance->getMapAkun($item['kode_akun'], $relationName);

            if ($mapAkun) {
                $item['kode_map_akun'] = $mapAkun->{$columnSelect};
                $item['nama_map_akun'] = $mapAkun->{$relationName}->nama_akun;
                return $item;
            } else {
                $forgetedIndex[] = $index;
            }
        });

        $saldoAwalLo = $this->saldoAwal->getRincianSaldoAwal($unitKerja->kode, SaldoAwal::LO, $request);
        $saldoAwalNeraca = $this->saldoAwal->getRincianSaldoAwal($unitKerja->kode, SaldoAwal::NERACA, $request);

        foreach ($saldoAwalNeraca as $key => $value) {
            $allJurnalUmum->push([
                "tanggal" => '',
                "tipe" => "Saldo Awal Neraca",
                "nomor" => '',
                "kode_unit_kerja" => $unitKerja->kode,
                "unit_kerja" => $unitKerja->nama_unit,
                "kode_akun" => '',
                "elemen" => "kode_akun",
                "nominal" => $value->debet > 0 ? $value->debet : $value->kredit,
                "jenis" => '',
                "kode_map_akun" => $value->akun->kode_akun,
                "nama_map_akun" => ''
            ]);
        }

        foreach ($saldoAwalLo as $key => $value) {
            $allJurnalUmum->push([
                "tanggal" => '',
                "tipe" => "Saldo Awal Lo",
                "nomor" => '',
                "kode_unit_kerja" => $unitKerja->kode,
                "unit_kerja" => $unitKerja->nama_unit,
                "kode_akun" => '',
                "elemen" => "kode_akun",
                "nominal" => $value->debet > 0 ? $value->debet : $value->kredit,
                "jenis" => '',
                "kode_map_akun" => $value->akun->kode_akun,
                "nama_map_akun" => ''
            ]);
        }
        $jurnalPenyesuaian = $this->jurnalPenyesuaian->getRincian($unitKerja->kode, $request);
        foreach ($jurnalPenyesuaian as $key => $value) {
            $allJurnalUmum->push([
                "tanggal" => '',
                "tipe" => "Jurnal Penyesuaian",
                "nomor" => '',
                "kode_unit_kerja" => $unitKerja->kode,
                "unit_kerja" => $unitKerja->nama_unit,
                "kode_akun" => '',
                "elemen" => "kode_akun",
                "nominal" => $value->debet,
                "jenis" => '',
                "kode_map_akun" => $value->akun->kode_akun,
                "nama_map_akun" => ''
            ]);
        }

        $allJurnalUmum = $allJurnalUmum->sortBy('tipe');
        $allJurnalUmum = $allJurnalUmum->forget($forgetedIndex)->values()->all();

        $jasaLayananPrevious = 0;
        $jasaLayananNow = 0;

        $bebanBarangJasaNowDebet = 0;
        $bebanBarangJasaNowKredit = 0;
        $bebanBarangJasaPreviousDebet = 0;
        $bebanBarangJasaPreviousKredit = 0;

        $bebanPemeliharaanNow = 0;
        $bebanPemeliharaanPrevious = 0;

        $bebanPerjalananDinasNow = 0;
        $bebanPerjalananDinasPrevious = 0;

        foreach ($allJurnalUmum as $item) {
            if (preg_match("/^8.1.4.16/m", $item['kode_map_akun']) && $item['tipe'] == 'STS') {
                $jasaLayananNow += $item['nominal'];
            } elseif(preg_match("/^8.1.4.16/m", $item['kode_map_akun']) && $item['tipe'] == 'Saldo Awal Lo'){
                $jasaLayananPrevious += $item['nominal'];
            } elseif (preg_match("/9.1.2/m", $item['kode_map_akun']) && ($item['tipe'] == 'SP2D')) {
                $bebanBarangJasaNowDebet += $item['nominal'];
            } elseif (preg_match("/^9.1.2.16/m", $item['kode_map_akun']) || preg_match("/^9.1.2.12/m", $item['kode_map_akun']) && ($item['tipe'] == 'SP2D')) {
                $bebanBarangJasaNowKredit += $item['nominal'];
            } elseif (preg_match("/^9.1.2/m", $item['kode_map_akun']) && $item['tipe'] == 'Saldo Awal Lo' ) {
                $bebanBarangJasaPreviousDebet += $item['nominal'];
            } elseif (preg_match("/^9.1.2.16/m", $item['kode_map_akun']) || preg_match("/^9.1.2.12/m", $item['kode_map_akun']) && $item['tipe'] == 'Saldo Awal Lo') {
                $bebanBarangJasaPreviousKredit += $item['nominal'];
            } elseif (preg_match("/^9.1.2.18/m", $item['kode_map_akun']) && ($item['tipe'] == 'SP2D' || $item['tipe'] == 'Kontrapos')) {
                $bebanPemeliharaanNow += $item['nominal'];
            } elseif (preg_match("/^9.1.2.18/m", $item['kode_map_akun']) && ($item['tipe'] == 'Saldo Awal Lo')) {
                $bebanPemeliharaanPrevious += $item['nominal'];
            } elseif (preg_match("/^9.1.2.16/m", $item['kode_map_akun']) && ($item['tipe'] == 'SP2D' || $item['tipe'] == 'Kontrapos')){
                $bebanPerjalananDinasNow += $item['nominal'];
            } elseif (preg_match("/^9.1.2.16/m", $item['kode_map_akun']) && ($item['tipe'] == 'Saldo Awal Lo')) {
                $bebanPerjalananDinasPrevious += $item['nominal'];
            }
        }
        $bebanBarangJasaNow = $bebanBarangJasaNowDebet-$bebanBarangJasaNowKredit;
        $bebanBarangJasaPrevious = $bebanBarangJasaPreviousDebet-$bebanBarangJasaPreviousKredit;

        $kepalaSkpd = clone $pejabat;
        $kepalaSkpd = $kepalaSkpd->where('jabatan_id', 1)->first();

        $pdf = PDF::loadview('admin.report.form_laporan_operasional', compact(
            'unitKerja', 'request', 'kepalaSkpd', 'jasaLayananPrevious', 'jasaLayananNow',
            'bebanBarangJasaNow', 'bebanBarangJasaPrevious', 'bebanPemeliharaanNow', 'bebanPemeliharaanPrevious',
            'bebanPerjalananDinasNow', 'bebanPerjalananDinasPrevious'
        ));
        return $pdf->stream('report_laporan_operasional.pdf', ['Attachment' => false]);
    }

    public function laporanEkuitas(Request $request)
    {
        $unitKerja = $this->unitKerja->findBy('kode', '=', $request->unit_kerja);
        $bkuRincian = $this->bkuRincian->getBkuJurnalUmum($request);

        $jurnalUmum = [];
        $jurnalKontrapos = [];
        $rekeningBendahara = ['rekening_bendahara', 'rekening_bendahara1', 'rekening_bendahara2', 'rekening_bendahara3'];
        foreach ($bkuRincian as $rincian) {
            $jurnal = $this->setupJurnal->findBy('formulir', '=', strtolower($rincian->tipe), ['*'], ['anggaran', 'finansial']);
            $this->setupJurnal->makeModel();
            if ($rincian->sts) {
                if ($request->tipe && $request->tipe == 'sts' || !$request->tipe) {
                    foreach ($rincian->sts->rincianSts as $rincianSts) {
                        foreach ($jurnal->anggaran as $anggaran) {
                            $cekKodeAkun = preg_replace('/[0-9]+/', '', $anggaran->elemen_anggaran);
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->sts->rekeningBendahara->kode_akun;
                            } else {
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
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->sts->rekeningBendahara->kode_akun;
                            } else {
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
            } else if ($rincian->sp2d) {
                if ($request->tipe && $request->tipe == 'sp2d' || !$request->tipe) {
                    foreach ($rincian->sp2d->bast->rincianPengadaan as $rincianBast) {
                        foreach ($jurnal->anggaran as $anggaran) {
                            $cekKodeAkun = preg_replace('/[0-9]+/', '', $anggaran->elemen_anggaran);
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->sp2d->rekeningBendahara->kode_akun;
                            } else {
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
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->sp2d->rekeningBendahara->kode_akun;
                            } else {
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
            } else if ($rincian->setorPajak) {
                if ($request->tipe && $request->tipe == 'setor_pajak' || !$request->tipe) {
                    foreach ($rincian->setorPajak->setorPajak->bast->rincianPengadaan as $rincianSetorPajak) {
                        foreach ($jurnal->anggaran as $anggaran) {
                            $cekKodeAkun = preg_replace('/[0-9]+/', '', $anggaran->elemen_anggaran);
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->setorPajak->setorPajak->rekeningBendahara->kode_akun;
                            } else {
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
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->setorPajak->setorPajak->rekeningBendahara->kode_akun;
                            } else {
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
            } else if ($rincian->kontrapos) {
                if ($request->tipe && $request->tipe == 'kontrapos' || !$request->tipe) {
                    foreach ($rincian->kontrapos->kontraposRincian as $rincianKontrapos) {
                        foreach ($jurnal->anggaran as $anggaran) {
                            $cekKodeAkun = preg_replace('/[0-9]+/', '', $anggaran->elemen_anggaran);
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->kontrapos->rekeningBendahara->kode_akun;
                            } else {
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
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->kontrapos->rekeningBendahara->kode_akun;
                            } else {
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
        $allJurnalUmum = $jurnalUmum->map(function ($item, $index) use (&$forgetedIndex) {
            $relationName = 'akun' . preg_replace('/[^0-9]/', '', $item['elemen']);
            $columnSelect = 'kode_akun_' . preg_replace('/[^0-9]/', '', $item['elemen']);
            if ($item['elemen'] == 'rekening_bendahara' || $item['elemen'] == 'kode_akun') {
                $columnSelect = 'kode_akun';
            }
            $mapAkun = $this->mapAkunFinance->getMapAkun($item['kode_akun'], $relationName);

            if ($mapAkun) {
                $item['kode_map_akun'] = $mapAkun->{$columnSelect};
                $item['nama_map_akun'] = $mapAkun->{$relationName}->nama_akun;
                return $item;
            } else {
                $forgetedIndex[] = $index;
            }
        });

        $saldoAwalLo = $this->saldoAwal->getRincianSaldoAwal($unitKerja->kode, SaldoAwal::LO, $request);
        $saldoAwalNeraca = $this->saldoAwal->getRincianSaldoAwal($unitKerja->kode, SaldoAwal::NERACA, $request);

        foreach ($saldoAwalNeraca as $key => $value) {
            $allJurnalUmum->push([
                "tanggal" => '',
                "tipe" => "Saldo Awal Neraca",
                "nomor" => '',
                "kode_unit_kerja" => $unitKerja->kode,
                "unit_kerja" => $unitKerja->nama_unit,
                "kode_akun" => '',
                "elemen" => "kode_akun",
                "nominal" => $value->debet > 0 ? $value->debet : $value->kredit,
                "jenis" => $value->debet > 0 ? 'DEBET' : 'KREDIT',
                "kode_map_akun" => $value->akun->kode_akun,
                "nama_map_akun" => ''
            ]);
        }

        foreach ($saldoAwalLo as $key => $value) {
            $allJurnalUmum->push([
                "tanggal" => '',
                "tipe" => "Saldo Awal Lo",
                "nomor" => '',
                "kode_unit_kerja" => $unitKerja->kode,
                "unit_kerja" => $unitKerja->nama_unit,
                "kode_akun" => '',
                "elemen" => "kode_akun",
                "nominal" => $value->debet > 0 ? $value->debet : $value->kredit,
                "jenis" => $value->debet > 0 ? 'DEBET' : 'KREDIT',
                "kode_map_akun" => $value->akun->kode_akun,
                "nama_map_akun" => ''
            ]);
        }
        $jurnalPenyesuaian = $this->jurnalPenyesuaian->getRincian($unitKerja->kode, $request);
        foreach ($jurnalPenyesuaian as $key => $value) {
            $allJurnalUmum->push([
                "tanggal" => '',
                "tipe" => "Jurnal Penyesuaian",
                "nomor" => '',
                "kode_unit_kerja" => $unitKerja->kode,
                "unit_kerja" => $unitKerja->nama_unit,
                "kode_akun" => '',
                "elemen" => "kode_akun",
                "nominal" => $value->debet,
                "jenis" => '',
                "kode_map_akun" => $value->akun->kode_akun,
                "nama_map_akun" => ''
            ]);
        }

        $allJurnalUmum = $allJurnalUmum->sortBy('tipe');
        $allJurnalUmum = $allJurnalUmum->forget($forgetedIndex)->values()->all();

        $ekuitasDebet = 0;
        $ekuitasKredit = 0;
        $surplusDefisit = 0;
        foreach ($allJurnalUmum as $item) {
            if (preg_match("/^3.1.1/m", $item['kode_map_akun']) && $item['tipe'] == 'Saldo Awal Neraca') {
                if ($item['jenis'] == 'DEBET'){
                    $ekuitasDebet += $item['nominal'];
                }else {
                    $ekuitasKredit += $item['nominal'];
                }
            } elseif((preg_match("/^8/m", $item['kode_map_akun']) || preg_match("/9/m", $item['kode_map_akun'])) && 
                ($item['tipe'] == 'STS' || $item['tipe'] == 'SP2D' || $item['tipe'] == 'Jurnal Penyesuaian' || $item['tipe'] == 'Kontrapos')){
                    $surplusDefisit += $item['nominal'];
            }
        }

        $ekuitas = $ekuitasDebet-$ekuitasKredit;

        $pejabat = $this->pejabatUnit->getAllPejabat($request->unit_kerja);
        $kepalaSkpd = clone $pejabat;
        $kepalaSkpd = $kepalaSkpd->where('jabatan_id', 1)->first();

        $pdf = PDF::loadview('admin.report.form_laporan_perubahan_ekuitas', compact(
            'request', 'unitKerja', 'kepalaSkpd', 'ekuitas', 'surplusDefisit'
        ));
        return $pdf->stream('report_laporan_perubahan_ekuitas.pdf', ['Attachment' => false]);   
    }
    
    public function laporanNeraca(Request $request)
    {
        $unitKerja = $this->unitKerja->findBy('kode', '=', $request->unit_kerja);
        $bkuRincian = $this->bkuRincian->getBkuJurnalUmum($request);

        $bkuRincian = $this->bkuRincian->getBkuJurnalUmum($request);

        $jurnalUmum = [];
        $jurnalKontrapos = [];
        $rekeningBendahara = ['rekening_bendahara', 'rekening_bendahara1', 'rekening_bendahara2', 'rekening_bendahara3'];
        foreach ($bkuRincian as $rincian) {
            $jurnal = $this->setupJurnal->findBy('formulir', '=', strtolower($rincian->tipe), ['*'], ['anggaran', 'finansial']);
            $this->setupJurnal->makeModel();
            if ($rincian->sts) {
                if ($request->tipe && $request->tipe == 'sts' || !$request->tipe) {
                    foreach ($rincian->sts->rincianSts as $rincianSts) {
                        foreach ($jurnal->anggaran as $anggaran) {
                            $cekKodeAkun = preg_replace('/[0-9]+/', '', $anggaran->elemen_anggaran);
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->sts->rekeningBendahara->kode_akun;
                            } else {
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
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->sts->rekeningBendahara->kode_akun;
                            } else {
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
            } else if ($rincian->sp2d) {
                if ($request->tipe && $request->tipe == 'sp2d' || !$request->tipe) {
                    foreach ($rincian->sp2d->bast->rincianPengadaan as $rincianBast) {
                        foreach ($jurnal->anggaran as $anggaran) {
                            $cekKodeAkun = preg_replace('/[0-9]+/', '', $anggaran->elemen_anggaran);
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->sp2d->rekeningBendahara->kode_akun;
                            } else {
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
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->sp2d->rekeningBendahara->kode_akun;
                            } else {
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
            } else if ($rincian->setorPajak) {
                if ($request->tipe && $request->tipe == 'setor_pajak' || !$request->tipe) {
                    foreach ($rincian->setorPajak->setorPajak->bast->rincianPengadaan as $rincianSetorPajak) {
                        foreach ($jurnal->anggaran as $anggaran) {
                            $cekKodeAkun = preg_replace('/[0-9]+/', '', $anggaran->elemen_anggaran);
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->setorPajak->setorPajak->rekeningBendahara->kode_akun;
                            } else {
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
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->setorPajak->setorPajak->rekeningBendahara->kode_akun;
                            } else {
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
                                'nominal' => ($rincianSetorPajak->harga * $rincianSetorPajak->unit),
                                'jenis' => $finansial->jenis_finansial,
                            ]);
                        }
                    }
                }
            } else if ($rincian->kontrapos) {
                if ($request->tipe && $request->tipe == 'kontrapos' || !$request->tipe) {
                    foreach ($rincian->kontrapos->kontraposRincian as $rincianKontrapos) {
                        foreach ($jurnal->anggaran as $anggaran) {
                            $cekKodeAkun = preg_replace('/[0-9]+/', '', $anggaran->elemen_anggaran);
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->kontrapos->rekeningBendahara->kode_akun;
                            } else {
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
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->kontrapos->rekeningBendahara->kode_akun;
                            } else {
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
        $allJurnalUmum = $jurnalUmum->map(function ($item, $index) use (&$forgetedIndex) {
            $relationName = 'akun' . preg_replace('/[^0-9]/', '', $item['elemen']);
            $columnSelect = 'kode_akun_' . preg_replace('/[^0-9]/', '', $item['elemen']);
            if ($item['elemen'] == 'rekening_bendahara' || $item['elemen'] == 'kode_akun') {
                $columnSelect = 'kode_akun';
            }
            $mapAkun = $this->mapAkunFinance->getMapAkun($item['kode_akun'], $relationName);

            if ($mapAkun) {
                $item['kode_map_akun'] = $mapAkun->{$columnSelect};
                $item['nama_map_akun'] = $mapAkun->{$relationName}->nama_akun;
                return $item;
            } else {
                $forgetedIndex[] = $index;
            }
        });
        
        $saldoAwalLo = $this->saldoAwal->getRincianSaldoAwal($unitKerja->kode, SaldoAwal::LO, $request);
        $saldoAwalNeraca = $this->saldoAwal->getRincianSaldoAwal($unitKerja->kode, SaldoAwal::NERACA, $request);
        $kasPPTKPrevious = 0;

        foreach ($saldoAwalNeraca as $key => $value) {
            $allJurnalUmum->push([
                "tanggal" => '',
                "tipe" => "Saldo Awal Neraca",
                "nomor" => '',
                "kode_unit_kerja" => $unitKerja->kode,
                "unit_kerja" => $unitKerja->nama_unit,
                "kode_akun" => '',
                "elemen" => "kode_akun",
                "nominal" => $value->debet > 0 ? $value->debet : $value->kredit,
                "jenis" => '',
                "kode_map_akun" => $value->akun->kode_akun,
                "nama_map_akun" => ''
            ]);
            if (preg_match("/^1.1.1.05/", $value->akun->kode_akun)) {
                $nominal = $value->debet > 0 ? $value->debet : $value->kredit;
                $kasPPTKPrevious += $nominal;
            }
        }

        foreach ($saldoAwalLo as $key => $value) {
            $allJurnalUmum->push([
                "tanggal" => '',
                "tipe" => "Saldo Awal Lo",
                "nomor" => '',
                "kode_unit_kerja" => $unitKerja->kode,
                "unit_kerja" => $unitKerja->nama_unit,
                "kode_akun" => '',
                "elemen" => "kode_akun",
                "nominal" => $value->debet > 0 ? $value->debet : $value->kredit,
                "jenis" => '',
                "kode_map_akun" => $value->akun->kode_akun,
                "nama_map_akun" => ''
            ]);
        }
        $jurnalPenyesuaian = $this->jurnalPenyesuaian->getRincian($unitKerja->kode, $request);
        foreach ($jurnalPenyesuaian as $key => $value) {
            $allJurnalUmum->push([
                "tanggal" => '',
                "tipe" => "Jurnal Penyesuaian",
                "nomor" => '',
                "kode_unit_kerja" => $unitKerja->kode,
                "unit_kerja" => $unitKerja->nama_unit,
                "kode_akun" => '',
                "elemen" => "kode_akun",
                "nominal" => $value->debet,
                "jenis" => '',
                "kode_map_akun" => $value->akun->kode_akun,
                "nama_map_akun" => ''
            ]);
        }

        $allJurnalUmum = $allJurnalUmum->sortBy('tipe');
        $allJurnalUmum = $allJurnalUmum->forget($forgetedIndex)->values()->all();
        $allJurnalUmum = collect($allJurnalUmum);

        $kasDebetNow = 0;
        $kasKreditNow = 0;

        $kasPPTKNow = 0;

        $kasDebetPrevious = 0;
        $kasKreditPrevious = 0;

        $persediaanNow = 0;
        $persediaanPrevious = 0;

        $tanahNow = 0;
        $tanahPrevious = 0;

        $peralatanMesinNow = 0;
        $peralatanMesinPrevious = 0;

        $gedungBangunanNow = 0;
        $gedungBangunanPrevious = 0;

        $jalanIrigasiNow = 0;
        $jalanIrigasiPrevious = 0;

        $asetTetapLainNow = 0;
        $asetTetapLainPrevious = 0;

        $akumulasiPenyusutanNow = 0;
        $akumulasiPenyusutanPrevious = 0;

        $utangJangkaPendekNow = 0;
        $utangJangkaPendekPrevious = 0;

        $ekuitasNow = 0;
        $ekuitasPrevious = 0;


        foreach ($allJurnalUmum as $item) {
            if (preg_match("/^1.1.1.02/m", $item['kode_map_akun']) && ($item['tipe'] == 'STS' || $item['tipe'] == 'SP2D' || $item['tipe'] == 'Kontrapos')) {
               $kasDebetNow += $item['nominal'];
            } elseif (preg_match("/^1.1.1.03/m", $item['kode_map_akun']) && ($item['tipe'] == 'STS' || $item['tipe'] == 'SP2D' || $item['tipe'] == 'Kontrapos')) {
                $kasKreditNow += $item['nominal'];
            } elseif (preg_match("/^1.1.1.02/m", $item['kode_map_akun']) && ($item['tipe'] == 'Saldo Awal Neraca')) {
                $kasDebetPrevious += $item['nominal'];
            } elseif (preg_match("/^1.1.1.03/m", $item['kode_map_akun']) && ($item['tipe'] == 'Saldo Awal Neraca')) {
                $kasKreditPrevious += $item['nominal'];
            } elseif (preg_match("/^1.1.1.05/m", $item['kode_map_akun'])){
                $kasPPTKNow += $item['nominal'];
            } elseif (preg_match("/^1.1.7/m", $item['kode_map_akun']) && ($item['tipe'] == 'SP2D' || $item['tipe'] == 'Jurnal Penyesuaian')) {
                $persediaanNow += $item['nominal'];
            } elseif (preg_match("/^1.1.7/m", $item['kode_map_akun']) && ($item['tipe'] == 'Saldo Awal Neraca')) {
                $persediaanPrevious += $item['nominal'];
            } elseif (preg_match("/^1.3.1/m", $item['kode_map_akun']) && ($item['tipe'] == 'SP2D' || $item['tipe'] == 'Jurnal Penyesuaian')) {
                $tanahNow += $item['nominal'];
            } elseif (preg_match("/^1.3.1/m", $item['kode_map_akun']) && ($item['tipe'] == 'Saldo Awal Neraca')) {
                $tanahPrevious += $item['nominal'];
            } elseif (preg_match("/^1.3.2/m", $item['kode_map_akun']) && ($item['tipe'] == 'SP2D' || $item['tipe'] == 'Jurnal Penyesuaian')) {
                $peralatanMesinNow += $item['nominal'];
            } elseif (preg_match("/1.3.2/m", $item['kode_map_akun']) && ($item['tipe'] == 'Saldo Awal Neraca')) {
                $peralatanMesinPrevious += $item['nominal'];
            } elseif (preg_match("/^1.3.3/m", $item['kode_map_akun']) && ($item['tipe'] == 'SP2D' || $item['tipe'] == 'Jurnal Penyesuaian')) {
                $gedungBangunanNow += $item['nominal'];
            } elseif (preg_match("/^1.3.3/m", $item['kode_map_akun']) && ($item['tipe'] == 'Saldo Awal Neraca')) {
                $gedungBangunanPrevious += $item['nominal'];
            } elseif (preg_match("/1.3.4/m", $item['kode_map_akun']) && ($item['tipe'] == 'SP2D' || $item['tipe'] == 'Jurnal Penyesuaian')) {
                $jalanIrigasiNow += $item['nominal'];
            } elseif (preg_match("/^1.3.4/m", $item['kode_map_akun']) && ($item['tipe'] == 'Saldo Awal Neraca')) {
                $jalanIrigasiPrevious += $item['nominal'];
            } elseif (preg_match("/^1.3.5/m", $item['kode_map_akun']) && ($item['tipe'] == 'SP2D' || $item['tipe'] == 'Jurnal Penyesuaian')) {
                $asetTetapLainNow += $item['nominal'];
            } elseif (preg_match("/^1.3.5/m", $item['kode_map_akun']) && ($item['tipe'] == 'Saldo Awal Neraca')) {
                $asetTetapLainPrevious += $item['nominal'];
            } elseif (preg_match("/^1.3.8/m", $item['kode_map_akun']) && ($item['tipe'] == 'SP2D' || $item['tipe'] == 'Jurnal Penyesuaian')) {
                if (strtoupper($item['jenis']) == 'DEBET'){
                    $akumulasiPenyusutanNow += $item['nominal'];
                }else {
                    $akumulasiPenyusutanNow -= $item['nominal'];
                }
            } elseif (preg_match("/^1.3.8/m", $item['kode_map_akun']) && ($item['tipe'] == 'Saldo Awal Neraca')) {
                if (strtoupper($item['jenis']) == 'DEBET') {
                    $akumulasiPenyusutanPrevious += $item['nominal'];
                } else {
                    $akumulasiPenyusutanPrevious -= $item['nominal'];
                }
            } elseif (preg_match("/^2.1.5/m", $item['kode_map_akun']) && ($item['tipe'] == 'SP2D' || $item['tipe'] == 'Jurnal Penyesuaian')) {
                $utangJangkaPendekNow += $item['nominal'];
            } elseif (preg_match("/^2.1.5/m", $item['kode_map_akun']) && ($item['tipe'] == 'Saldo Awal Neraca')) {
                $utangJangkaPendekPrevious += $item['nominal'];
            } elseif (($item['tipe'] == 'SP2D' || $item['tipe'] == 'STS' || $item['tipe'] == 'Kontrapos' || $item['tipe'] == 'Jurnal Penyesuaian')) {
                if (preg_match("/^8/m", $item['kode_map_akun']) || preg_match("/3.1.1/m", $item['kode_map_akun'])){
                    $ekuitasNow += $item['nominal'];
                }else if(preg_match("/^9/m", $item['kode_map_akun'])){
                    $ekuitasNow -= $item['nominal'];
                }
            } elseif (preg_match("/^3.1.1/m", $item['kode_map_akun']) && ($item['tipe'] == 'Saldo Awal Neraca')) {
                $ekuitasPrevious += $item['nominal'];
            }
        }

        $kasNow = $kasDebetNow - $kasKreditNow;
        $kasPrevious = $kasDebetPrevious - $kasKreditPrevious;

        $pejabat = $this->pejabatUnit->getAllPejabat($request->unit_kerja);
        $kepalaSkpd = clone $pejabat;
        $kepalaSkpd = $kepalaSkpd->where('jabatan_id', 1)->first();

        $pdf = PDF::loadview('admin.report.form_neraca', compact(
            'request', 'unitKerja', 'kepalaSkpd', 'kasNow', 'kasPrevious',
            'persediaanNow', 'persediaanPrevious', 'tanahNow', 'tanahPrevious', 'peralatanMesinNow',
            'peralatanMesinPrevious', 'gedungBangunanNow', 'gedungBangunanPrevious', 'jalanIrigasiNow',
            'jalanIrigasiPrevious', 'asetTetapLainNow', 'asetTetapLainPrevious', 'akumulasiPenyusutanNow',
            'akumulasiPenyusutanPrevious', 'utangJangkaPendekNow', 'utangJangkaPendekPrevious', 'ekuitasNow',
            'ekuitasPrevious', 'kasPPTKNow', 'kasPPTKPrevious'
        ));
        return $pdf->stream('report_laporan_neraca.pdf', ['Attachment' => false]);
    }

    public function laporanSal(Request $request)
    {
        $unitKerja = $this->unitKerja->findBy('kode', '=', $request->unit_kerja);

        $pejabat = $this->pejabatUnit->getAllPejabat($request->unit_kerja);
        $kepalaSkpd = clone $pejabat;
        $kepalaSkpd = $kepalaSkpd->where('jabatan_id', 1)->first();

        $pdf = PDF::loadview('admin.report.form_laporan_perubahan_sal', compact(
            'unitKerja', 'kepalaSkpd', 'request'
        ));
        return $pdf->stream('report_laporan_perubahan_sal.pdf', ['Attachment' => false]); 
    }

    public function arusKas(Request $request)
    {
        $unitKerja = $this->unitKerja->findBy('kode', '=', $request->unit_kerja);

        $bkuRincian = $this->bkuRincian->getBkuJurnalUmum($request);
        $jurnalUmum = [];
        $jurnalKontrapos = [];
        $rekeningBendahara = ['rekening_bendahara', 'rekening_bendahara1', 'rekening_bendahara2', 'rekening_bendahara3'];
        foreach ($bkuRincian as $rincian) {
            $jurnal = $this->setupJurnal->findBy('formulir', '=', strtolower($rincian->tipe), ['*'], ['anggaran', 'finansial']);
            $this->setupJurnal->makeModel();
            if ($rincian->sts) {
                if ($request->tipe && $request->tipe == 'sts' || !$request->tipe) {
                    foreach ($rincian->sts->rincianSts as $rincianSts) {
                        foreach ($jurnal->anggaran as $anggaran) {
                            $cekKodeAkun = preg_replace('/[0-9]+/', '', $anggaran->elemen_anggaran);
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->sts->rekeningBendahara->kode_akun;
                            } else {
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
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->sts->rekeningBendahara->kode_akun;
                            } else {
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
            } else if ($rincian->sp2d) {
                if ($request->tipe && $request->tipe == 'sp2d' || !$request->tipe) {
                    foreach ($rincian->sp2d->bast->rincianPengadaan as $rincianBast) {
                        foreach ($jurnal->anggaran as $anggaran) {
                            $cekKodeAkun = preg_replace('/[0-9]+/', '', $anggaran->elemen_anggaran);
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->sp2d->rekeningBendahara->kode_akun;
                            } else {
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
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->sp2d->rekeningBendahara->kode_akun;
                            } else {
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
            } else if ($rincian->setorPajak) {
                if ($request->tipe && $request->tipe == 'setor_pajak' || !$request->tipe) {
                    foreach ($rincian->setorPajak->setorPajak->bast->rincianPengadaan as $rincianSetorPajak) {
                        foreach ($jurnal->anggaran as $anggaran) {
                            $cekKodeAkun = preg_replace('/[0-9]+/', '', $anggaran->elemen_anggaran);
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->setorPajak->setorPajak->rekeningBendahara->kode_akun;
                            } else {
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
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->setorPajak->setorPajak->rekeningBendahara->kode_akun;
                            } else {
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
            } else if ($rincian->kontrapos) {
                if ($request->tipe && $request->tipe == 'kontrapos' || !$request->tipe) {
                    foreach ($rincian->kontrapos->kontraposRincian as $rincianKontrapos) {
                        foreach ($jurnal->anggaran as $anggaran) {
                            $cekKodeAkun = preg_replace('/[0-9]+/', '', $anggaran->elemen_anggaran);
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->kontrapos->rekeningBendahara->kode_akun;
                            } else {
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
                            if ($cekKodeAkun == 'rekening_bendahara') {
                                $kodeAkun = $rincian->kontrapos->rekeningBendahara->kode_akun;
                            } else {
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
        $allJurnalUmum = $jurnalUmum->map(function ($item, $index) use (&$forgetedIndex, $request) {
            $relationName = 'akun' . preg_replace('/[^0-9]/', '', $item['elemen']);
            $columnSelect = 'kode_akun_' . preg_replace('/[^0-9]/', '', $item['elemen']);
            if ($item['elemen'] == 'rekening_bendahara' || $item['elemen'] == 'kode_akun') {
                $columnSelect = 'kode_akun';
            }
            $mapAkun = $this->mapAkunFinance->getMapAkun($item['kode_akun'], $relationName);

            if ($request->kode_akun) {
                if ($mapAkun && preg_match("/^{$request->kode_akun}/m", $mapAkun->{$columnSelect})) {
                    $item['kode_map_akun'] = $mapAkun->{$columnSelect};
                    $item['nama_map_akun'] = $mapAkun->{$relationName}->nama_akun;
                    return $item;
                } else {
                    $forgetedIndex[] = $index;
                }
            } else {
                if ($mapAkun) {
                    $item['kode_map_akun'] = $mapAkun->{$columnSelect};
                    $item['nama_map_akun'] = $mapAkun->{$relationName}->nama_akun;
                    return $item;
                } else {
                    $forgetedIndex[] = $index;
                }
            }
        });


        $saldoAwalLo = $this->saldoAwal->getRincianSaldoAwal($unitKerja->kode, SaldoAwal::LO, $request);
        $saldoAwalNeraca = $this->saldoAwal->getRincianSaldoAwal($unitKerja->kode, SaldoAwal::NERACA, $request);

        foreach ($saldoAwalNeraca as $key => $value) {
            $allJurnalUmum->push([
                "tanggal" => '',
                "tipe" => "Saldo Awal Neraca",
                "nomor" => '',
                "kode_unit_kerja" => $unitKerja->kode,
                "unit_kerja" => $unitKerja->nama_unit,
                "kode_akun" => '',
                "elemen" => "kode_akun",
                "nominal" => $value->debet > 0 ? $value->debet : $value->kredit,
                "jenis" => '',
                "kode_map_akun" => $value->akun->kode_akun,
                "nama_map_akun" => ''
            ]);
        }

        foreach ($saldoAwalLo as $key => $value) {
            $allJurnalUmum->push([
                "tanggal" => '',
                "tipe" => "Saldo Awal Lo",
                "nomor" => '',
                "kode_unit_kerja" => $unitKerja->kode,
                "unit_kerja" => $unitKerja->nama_unit,
                "kode_akun" => '',
                "elemen" => "kode_akun",
                "nominal" => $value->debet > 0 ? $value->debet : $value->kredit,
                "jenis" => '',
                "kode_map_akun" => $value->akun->kode_akun,
                "nama_map_akun" => ''
            ]);
        }
        $jurnalPenyesuaian = $this->jurnalPenyesuaian->getRincian($unitKerja->kode, $request);
        foreach ($jurnalPenyesuaian as $key => $value) {
            $allJurnalUmum->push([
                "tanggal" => '',
                "tipe" => "Jurnal Penyesuaian",
                "nomor" => '',
                "kode_unit_kerja" => $unitKerja->kode,
                "unit_kerja" => $unitKerja->nama_unit,
                "kode_akun" => '',
                "elemen" => "kode_akun",
                "nominal" => $value->debet,
                "jenis" => '',
                "kode_map_akun" => $value->akun->kode_akun,
                "nama_map_akun" => ''
            ]);
        }

        $allJurnalUmum = $allJurnalUmum->sortBy('tipe');
        $allJurnalUmum = $allJurnalUmum->forget($forgetedIndex)->values()->all();

        $kolom4 = 0;
        $kolom13 = 0;
        $kolom34 = 0;
        $kolom35 = 0;
        $kolom36 = 0;
        $kolom69 = 0;

        foreach ($allJurnalUmum as $item) {
            if (preg_match("/^4.1.4.16/m", $item['kode_map_akun'])) {
                $kolom4 += $item['nominal'];
            } elseif(preg_match("/^5.1/m", $item['kode_map_akun']) || preg_match("/^5.2.1/m", $item['kode_map_akun']) || preg_match("/^5.2.2/m", $item['kode_map_akun'])){
                $kolom13 += $item['nominal'];
            } elseif (preg_match("/^5.2.3.01/m", $item['kode_map_akun'])) {
                $kolom13 += $item['nominal'];
            } elseif (preg_match("/^5.2.3.26/m", $item['kode_map_akun'])) {
                $kolom36 += $item['nominal'];
            } elseif (preg_match("/^1.1.1/m", $item['kode_map_akun'])) {
                $kolom69 += $item['nominal'];
            }else {
                $kolom35 += $this->checkRealisasi19($item);
            }
        }

        $pejabat = $this->pejabatUnit->getAllPejabat($request->unit_kerja);
        $kepalaSkpd = clone $pejabat;
        $kepalaSkpd = $kepalaSkpd->where('jabatan_id', 1)->first();

        $pdf = PDF::loadview('admin.report.form_laporan_arus_kas', compact(
            'unitKerja', 'kepalaSkpd', 'request', 'kolom4', 'kolom13', 'kolom34', 'kolom35',
            'kolom36', 'kolom69'
        ));
        return $pdf->stream('report_laporan_arus_kas.pdf', ['Attachment' => false]);   
    }
}

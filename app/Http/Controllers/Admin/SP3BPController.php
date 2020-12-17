<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\BkuRincian;
use iio\libmergepdf\Merger;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\SP3B\SP3BRequest;
use App\Http\Requests\SP3B\VerifikasiSp3bRequest;
use App\Repositories\Akutansi\SaldoAwalRepository;
use App\Repositories\SP3B\SP3BRepository;
use App\Repositories\BKU\BKURincianRepository;
use App\Repositories\DataDasar\MapKegiatanRepository;
use App\Repositories\Organisasi\PejabatUnitRepository;
use App\Repositories\Organisasi\UnitKerjaRepository;
use App\Repositories\Pengaturan\PrefixPenomoranRepository;
use App\Repositories\SP3B\SP3BRincianRepository;

class SP3BPController extends Controller
{
    /**
     * UnitkerjaRepository
     * @var unitKerjaRepository
     */
    protected $unitKerja;

    /**
     * BkuRincian
     * @var BkuRincianRepository
     */
    protected $bkuRician;

    /**
     * Prefix penomoran repository
     * 
     * @var PrefixPenomoranRepository
     */
    protected $prefixPenomoran;

    /**
     * Map kegiatan repository
     * 
     * @var MapKegiatanRepository
     */
    protected $mapKegiatan;

    /**
     * Sp3b repository
     * 
     * @var Sp3bRepository
     */
    protected $sp3b;

    /**
     * SP3BRincian repository
     * 
     * @var SP3BRincianRepository
     */
    protected $sp3bRincian;

    /**
     * Saldo awal repository
     * 
     * @var SaldoAwalRepository
     */
    private $saldoAwal;

    /**
     * Pejabat unit repository
     * 
     * @var PejabatUnitRepository
     */
    private $pejabatUnit;

    public function __construct(
        UnitKerjaRepository $unitKerja,
        BKURincianRepository $bkuRician,
        PrefixPenomoranRepository $prefixPenomoran,
        MapKegiatanRepository $mapKegiatan,
        SP3BRepository $sp3b,
        SP3BRincianRepository $sp3bRincian,
        SaldoAwalRepository $saldoAwal,
        PejabatUnitRepository $pejabatUnit
    )
    {
        $this->unitKerja = $unitKerja;
        $this->bkuRician = $bkuRician;
        $this->prefixPenomoran = $prefixPenomoran;
        $this->mapKegiatan = $mapKegiatan;
        $this->sp3b = $sp3b;
        $this->sp3bRincian = $sp3bRincian;
        $this->saldoAwal = $saldoAwal;
        $this->pejabatUnit = $pejabatUnit;
    }

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
                $query->where('created_at', '>=', $request->start_date);
            }

            if ($request->end_date) {
                $query->where('created_at', '<=', $request->end_date);
            }
        };
        $sp3b = $this->sp3b->get(['*'], $where, ['unitKerja']);

        $totalAllPendapatan = 0;
        $totalAllPengeluaran = 0;
        $sp3b->map(function($item) use(&$totalAllPendapatan, &$totalAllPengeluaran) {
            $item->total_pendapatan = $item->sp3bRincian->sum('pendapatan');
            $item->total_pengeluaran = $item->sp3bRincian->sum('pengeluaran');
            $totalAllPendapatan += $item->sp3bRincian->sum('pendapatan');
            $totalAllPengeluaran += $item->sp3bRincian->sum('pengeluaran');
        });

        return view('admin.sp3bp.index', compact('sp3b', 'unitKerja', 'totalAllPendapatan', 'totalAllPengeluaran'));
    }

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
        return view('admin.sp3bp.create', compact('unitKerja'));
    }

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
        $sp3b = $this->sp3b->find($id, ['*'], [
            'sp3bRincian.akun', 'sp3bRincian.akunApbd', 'sp3bRincian.kegiatan', 'sp3bRincian.kegiatanApbd'
        ]);

        $totalPendapatan = 0;
        $totalPengeluaran = 0;
        $sp3b->sp3bRincian->map(function ($item) use(&$totalPendapatan, &$totalPengeluaran){
            $totalPendapatan += $item->pendapatan;
            $totalPengeluaran += $item->pengeluaran;
        });

        return view('admin.sp3bp.edit', compact('sp3b', 'unitKerja', 'totalPendapatan', 'totalPengeluaran'));
    }

    public function store(SP3BRequest $request)
    {
        try {
            if (count($request->nomor_rincian) < 1) {
                throw new \Exception('Rincian kosong, tidak dapat menyimpan sp3b');
            } 
            DB::beginTransaction();
            $sp3b = $this->sp3b->create([
                'nomor' => $request->nomor,
                'tanggal' => $request->tanggal,
                'triwulan' => $request->triwulan,
                'kode_unit_kerja' => $request->unit_kerja,
                'bendahara_penerimaan' => $request->bendahara_penerimaan,
                'bendahara_pengeluaran' => $request->bendahara_pengeluaran,
                'keterangan' => $request->keterangan,
                'pejabat_unit' => $request->pejabat_unit,
            ]);
            if (! $sp3b) {
                throw new \Exception('Error create sp3b');
            }

            for ($i = 0; $i < count($request->nomor_rincian); $i++) {
                $data = [
                    'sp3b_id' => $sp3b->id,
                    'nomor' => $request->nomor_rincian[$i],
                ];

                if (! empty($request->kegiatan_id[$i])) {
                    $data['kegiatan_id'] = $request->kegiatan_id[$i];
                }

                if (! empty($request->kegiatan_id_apbd[$i])) {
                    $data['kegiatan_id_apbd'] = $request->kegiatan_id_apbd[$i];
                }

                if (! empty($request->kode_akun[$i])){
                    $data['kode_akun'] = $request->kode_akun[$i];
                }

                if (! empty($request->kode_akun_apbd[$i])){
                    $data['kode_akun_apbd'] = $request->kode_akun_apbd[$i];
                }

                if ($request->pendapatan[$i]) {
                    $data['pendapatan'] = parse_format_number($request->pendapatan[$i]);
                }
                
                if ($request->pengeluaran[$i]) {
                    $data['pengeluaran'] = parse_format_number($request->pengeluaran[$i]);
                }

                $sp3bRincian = $this->sp3bRincian->create($data);
                if (!$sp3bRincian) {
                    throw new \Exception('Error create sp3b rincian');
                }
            }
            DB::commit();
            return response()->json(['status' => 'oke', 'sp3b' => $sp3b], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'data' => $e->getMessage(),
                'line' => $e->getLine(),
            ], 400);
        }
    }

    public function update(SP3BRequest $request, $id)
    {
        try {
            $sp3b = $this->sp3b->find($id);
            if (!$sp3b) {
                throw new \Exception('Error create sp3b');
            }
            
            $sp3b = $this->sp3b->update([
                'nomor' => $request->nomor,
                'tanggal' => $request->tanggal,
                'triwulan' => $request->triwulan,
                'kode_unit_kerja' => $request->unit_kerja,
                'bendahara_penerimaan' => $request->bendahara_penerimaan,
                'bendahara_pengeluaran' => $request->bendahara_pengeluaran,
                'keterangan' => $request->keterangan,
                'pejabat_unit' => $request->pejabat_unit,
            ], $id);

            $this->sp3bRincian->deleteSp3bRincian($id);

            for ($i = 0; $i < count($request->nomor_rincian); $i++) {
                $data = [
                    'sp3b_id' => $id,
                    'nomor' => $request->nomor_rincian[$i],
                ];

                if (!empty($request->kegiatan_id[$i])) {
                    $data['kegiatan_id'] = $request->kegiatan_id[$i];
                }

                if (!empty($request->kegiatan_id_apbd[$i])) {
                    $data['kegiatan_id_apbd'] = $request->kegiatan_id_apbd[$i];
                }

                if (!empty($request->kode_akun[$i])) {
                    $data['kode_akun'] = $request->kode_akun[$i];
                }

                if (!empty($request->kode_akun_apbd[$i])) {
                    $data['kode_akun_apbd'] = $request->kode_akun_apbd[$i];
                }

                if ($request->pendapatan[$i]) {
                    $data['pendapatan'] = parse_format_number($request->pendapatan[$i]);
                }

                if ($request->pengeluaran[$i]) {
                    $data['pengeluaran'] = parse_format_number($request->pengeluaran[$i]);
                }

                $sp3bRincian = $this->sp3bRincian->create($data);
                if (!$sp3bRincian) {
                    throw new \Exception('Error create sp3b rincian');
                }
            }

        } catch (\Throwable $e) {
            return response()->json([
                'data' => $e->getMessage()
            ], 400);
        }
    }

    public function verificationView(Request $request)
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
                $query->where('created_at', '>=', $request->start_date);
            }

            if ($request->end_date) {
                $query->where('created_at', '<=', $request->end_date);
            }
        };
        $sp3b = $this->sp3b->get(['*'], $where, ['unitKerja']);

        $totalAllPendapatan = 0;
        $totalAllPengeluaran = 0;
        $sp3b->map(function ($item) use (&$totalAllPendapatan, &$totalAllPengeluaran) {
            $item->total_pendapatan = $item->sp3bRincian->sum('pendapatan');
            $item->total_pengeluaran = $item->sp3bRincian->sum('pengeluaran');
            $totalAllPendapatan += $item->sp3bRincian->sum('pendapatan');
            $totalAllPengeluaran += $item->sp3bRincian->sum('pengeluaran');
        });

        return view('admin.sp3bp.form-verification', compact(
            'sp3b', 'unitKerja', 'totalAllPendapatan', 'totalAllPengeluaran'
        ));
    }

    public function verification(VerifikasiSp3bRequest $request)
    {
    
        $sp3b = $this->sp3b->find($request->id);
        
        if (!$sp3b) {
            throw new \Exception('Gagal verifikasi sp3b$sp3b');
        }
        if ($request->status_verifikasi == 1){
            $sp3b->update([
                'is_verified' => true,
                'date_verified' => $request->tanggal,
            ]);
            return redirect()->back()
                ->with(['success' => 'Data sp3b berhasil di verifikasi ']);
        }else {
            $sp3b->update([
                'is_verified' => false,
                'date_verified' => null,
            ]);
            return redirect()->back()
                ->with(['success' => 'Verifikasi sp3b berhasil dibatalkan']);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $sp3b = $this->sp3b->find($request->id);

            if (!$sp3b) {
                throw new \Exception('Data tidak ditemukan');
            }

            $this->sp3bRincian->deleteSp3bRincian($sp3b->id);

            $sp3b->delete();

            return redirect()->back()
                ->with(['success' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with(['error' => $e->getMessage()]);
        }
    }

    public function reportSp3b($id, $jenis = null)
    {    
        $sp3b = $this->sp3b->getDetailSp3b($id);
        $saldoAwal = $this->saldoAwal->getSaldoAwalNeracaByUnitKerja($sp3b->kode_unit_kerja);

        $totalSaldoAwal = $saldoAwal ? $saldoAwal->saldoAwalRincian->sum('debet') : 0;

        if ($sp3b->triwulan != '1') {
            for ($i = 1; $i <= $sp3b->triwulan - 1; $i++){
                $sp3bPrevious = $this->sp3b->getDetailSp3b(null, $i, $sp3b->kode_unit_kerja);
                $totalPendapatanPrevious = 0;
                $totalPengeluaranPrevious  = 0;
                $sp3bPrevious->sp3bRincian->map(function ($item) use (&$totalPendapatanPrevious, &$totalPengeluaranPrevious) {
                    $totalPendapatanPrevious += $item->pendapatan;
                    $totalPengeluaranPrevious += $item->pengeluaran;
                });
                $totalSaldoAwal = $totalSaldoAwal + $totalPendapatanPrevious - $totalPengeluaranPrevious;
            }
        }

        $bulan = strlen($sp3b->triwulan) == 1 ? '0'.$sp3b->triwulan : $sp3b->triwulan;

        $totalPendapatan = 0;
        $totalPengeluaran = 0;
        $sp3b->sp3bRincian->map(function ($item) use(&$totalPendapatan, &$totalPengeluaran){
            $totalPendapatan += $item->pendapatan;
            $totalPengeluaran += $item->pengeluaran;
        });

        $m = new Merger();

        $rincianSp3bData = [];
        $akunPendapatan = [];
        $akunBelanja = [];

        $indexBelanja = 0;
        $indexPengeluaran = 0;
        
        foreach($sp3b->sp3bRincian->whereNotNull('kode_akun_apbd') as $item) {
            /** Pendapatan */
            if( ! $item->kegiatan) {
                if (isset($rincianSp3bData['pendapatan']) && isset($rincianSp3bData['pendapatan'][$item->kode_akun_apbd])){
                    $rincianSp3bData['pendapatan'][$item->kode_akun_apbd] += (float)$item->pendapatan;
                }else{
                    $rincianSp3bData['pendapatan'][$item->kode_akun_apbd] = $item->pendapatan;
                    $akunPendapatan[$item->kode_akun_apbd] =  $item->akunApbd->nama_akun;
                }
            }else {
                if (isset($rincianSp3bData['belanja']) && isset($rincianSp3bData['belanja'][$item->kode_akun_apbd])) {
                    $rincianSp3bData['belanja'][$item->kode_akun_apbd] += $item->pengeluaran;
                } else {
                    $rincianSp3bData['belanja'][$item->kode_akun_apbd] = (float)$item->pengeluaran;
                    $akunBelanja[$item->kode_akun_apbd] =  $item->akunApbd->nama_akun;
                }
            }
        }

        $rincianSp3b = [];

        foreach ($rincianSp3bData as $key => $value) {
            if ($key == 'pendapatan') {
                foreach ($value as $keyValue => $valueRincian) {
                    $rincianSp3b['pendapatan'][] = [
                        'nominal' =>  $valueRincian,
                        'kode_akun_apbd' => $keyValue,
                        'nama_akun_apbd' => $akunPendapatan[$keyValue]
                    ];
                }
                
            }else {
                foreach ($value as $keyValue => $valueRincian) {
                    $rincianSp3b['belanja'][] = [
                        'nominal' =>  $valueRincian,
                        'kode_akun_apbd' => $keyValue,
                        'nama_akun_apbd' => $akunBelanja[$keyValue]
                    ];
                }
            }
        }

        $allRincianSp3b = [];

        foreach ($sp3b->sp3bRincian as $key => $item) {
            if (isset($allRincianSp3b[$item->akun->kode_akun])){
                $allRincianSp3b[$item->akun->kode_akun]['pendapatan'] += $item->pendapatan;
                $allRincianSp3b[$item->akun->kode_akun]['pengeluaran'] += $item->pengeluaran;
            }else {
                $allRincianSp3b[$item->akun->kode_akun] = [
                    'kode_kegiatan' => $item->kegiatan ? $item->kegiatan->kode_program . '.' . $item->kegiatan->kode_bidang . '.' . $item->kegiatan->kode : '',
                    'nama_kegiatan' => $item->kegiatan ? $item->kegiatan->nama_kegiatan : '',
                    'kode_kegiatan_apbd' => $item->kegiatanApbd ? $item->kegiatanApbd->kode_program . '.' . $item->kegiatanApbd->kode_bidang . '.' . $item->kegiatanApbd->kode : '',
                    'nama_kegiatan_apbd' => $item->kegiatanApbd ? $item->kegiatanApbd->nama_kegiatan : '',
                    'kode_akun' => $item->akun ? $item->akun->kode_akun : '',
                    'nama_akun' => $item->akun ? $item->akun->nama_akun : '',
                    'kode_akun_apbd' => $item->akunApbd ? $item->akunApbd->kode_akun : '',
                    'nama_akun_apbd' => $item->akunApbd ? $item->akunApbd->nama_akun : '',
                    'pendapatan' => $item->pendapatan,
                    'pengeluaran' => $item->pengeluaran
                ];
            }            
        }
        
        $sp3bPendapatan = isset($rincianSp3b['pendapatan']) ? count($rincianSp3b['pendapatan']) : 0;
        $sp3bBelanja = isset($rincianSp3b['belanja']) ? count($rincianSp3b['belanja']) : 0;
        $highestValue = max($sp3bPendapatan, $sp3bBelanja);

        $view1 = \View::make('admin.report.form_rincian_sp3b', compact(
            'sp3b', 'totalPendapatan', 'totalPengeluaran', 'bulan', 'rincianSp3b', 'highestValue',
            'totalSaldoAwal', 'jenis'
        ))->render();
        $view2 = \View::make('admin.report.form_rekap_sp3b', compact(
            'sp3b', 'totalPendapatan', 'totalPengeluaran', 'rincianSp3b', 'highestValue',
            'allRincianSp3b', 'jenis'
            ))->render();

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view1)->setPaper('a4', 'portrait');
        $m->addRaw($pdf->output());

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view2)->setPaper('a4', 'landscape');
        $m->addRaw($pdf->output());

        $userId = request()->user()->id;
        $path = storage_path() . "/app/public/sp3b_{$userId}.pdf";

        file_put_contents($path, $m->merge());

        return response()->file($path);
    }

    public function reportSptj($id)
    {
        $sp3b = $this->sp3b->getDetailSp3b($id);
        $totalPengeluaran = 0;
        $sp3b->sp3bRincian->map(function ($item) use (&$totalPengeluaran) {
            $totalPengeluaran += $item->pengeluaran;
        });

        $pejabat = $this->pejabatUnit->getAllPejabat($sp3b->kode_unit_kerja);
        $pejabat = $pejabat->where('jabatan_id', 1)->first();

        $pdf = PDF::loadview('admin.report.form_laporan_sptj', compact('sp3b', 'totalPengeluaran', 'pejabat'));
        return $pdf->stream('report_laporan_sptj', ['Attachment' => false]);
    }

    public function dataRincian(Request $request)
    {
        try {
            $unitKerja = $request->unit_kerja;
            $triwulan = $request->triwulan;

            $monthStart = ($triwulan * 3) - 2;
            $monthEnd = $triwulan * 3;

            $dateStart = Carbon::createFromDate(env('TAHUN_ANGGARAN', 2020), $monthStart, 1)->format('Y-m-d');
            $dateEnd = Carbon::createFromDate(env('TAHUN_ANGGARAN', 2020), $monthEnd, 1)->endOfMonth()->format('Y-m-d');


            $rincianSp3b = [];
            $totalPendapatan = 0;
            $totalPengeluaran = 0;
            $rincian = $this->bkuRician->getRincianSp3b($unitKerja, $dateStart, $dateEnd);

            $rincian->map(function ($item) use (&$rincianSp3b, &$totalPendapatan, &$totalPengeluaran) {
                if ($item->tipe == BkuRincian::SP2D) {
                    $mappingKegiatan = $this->mapKegiatan->getMapKegiatan($item->sp2d->bast->kegiatan->id, $item->sp2d->kode_unit_kerja);
                    $kegiatanId = $item->sp2d->bast->kegiatan->id;
                    $kodeKegiatan = $item->sp2d->bast->kegiatan->kode_bidang . '.' . $item->sp2d->bast->kegiatan->kode_program . '.' . $item->sp2d->bast->kegiatan->kode;
                    $namaKegiatan = $item->sp2d->bast->kegiatan->nama_kegiatan;
                    $kegiatanIdApbd = $mappingKegiatan->apbd->id;
                    $kodeKegiatanApbd = $mappingKegiatan->apbd->kode_bidang . '.' . $mappingKegiatan->apbd->kode_program . '.' . $mappingKegiatan->apbd->kode;
                    $namaKegiatanApbd = $mappingKegiatan->apbd->nama_kegiatan;
                    foreach ($item->sp2d->bast->rincianPengadaan as $rincianBast) {
                        if (substr($rincianBast->akun->kode_akun, 0, 1) == 5 || substr($rincianBast->akun->kode_akun, 0, 1) == 4) {
                            $kodeAkun = $rincianBast->akun->kode_akun;
                            $namaAkun = $rincianBast->akun->nama_akun;
                            $kodeAkunApbd = $rincianBast->akun->mapAkun ? $rincianBast->akun->mapAkun->map->kode_akun : null;
                            $namaAkunApbd = $rincianBast->akun->mapAkun ? $rincianBast->akun->mapAkun->map->nama_akun : null;
                        }
                        $rincianSp3b[] = [
                            'nomor' => $item->no_aktivitas,
                            'kegiatan_id' => $kegiatanId,
                            'kode_kegiatan' => $kodeKegiatan,
                            'nama_kegiatan' => $namaKegiatan,
                            'kegiatan_id_apbd' => $kegiatanIdApbd,
                            'kode_kegiatan_apbd' => $kodeKegiatanApbd,
                            'nama_kegiatan_apbd' => $namaKegiatanApbd,
                            'kode_akun' => isset($kodeAkun) ? $kodeAkun : '',
                            'nama_akun' => isset($namaAkun) ? $namaAkun : '',
                            'kode_akun_apbd' => isset($kodeAkunApbd) ? $kodeAkunApbd : '',
                            'nama_akun_apbd' => isset($namaAkunApbd) ? $namaAkunApbd : '',
                            'pengeluaran' => $rincianBast->unit * $rincianBast->harga,
                            'pendapatan' => 0,
                        ];
                        $totalPengeluaran += $rincianBast->unit * $rincianBast->harga;
                    }
                } else if ($item->tipe == BkuRincian::STS) {
                    foreach ($item->sts->rincianSts as $rincianSts) {
                        if (substr($rincianSts->akun->kode_akun, 0, 1) == 5 || substr($rincianSts->akun->kode_akun, 0, 1) == 4) {
                            $kodeAkun = $rincianSts->akun->kode_akun;
                            $namaAkun = $rincianSts->akun->nama_akun;
                            $kodeAkunApbd = $rincianSts->akun->mapAkun ? $rincianSts->akun->mapAkun->map->kode_akun : null;
                            $namaAkunApbd = $rincianSts->akun->mapAkun ? $rincianSts->akun->mapAkun->map->nama_akun : null;
                        }
                        $rincianSp3b[] = [
                            'nomor' => $item->no_aktivitas,
                            'kegiatan_id' => '',
                            'kode_kegiatan' => '',
                            'nama_kegiatan' => '',
                            'kegiatan_id_apbd' => '',
                            'kode_kegiatan_apbd' => '',
                            'nama_kegiatan_apbd' => '',
                            'kode_akun' => isset($kodeAkun) ? $kodeAkun : '',
                            'nama_akun' => isset($namaAkun) ? $namaAkun : '',
                            'kode_akun_apbd' => isset($kodeAkunApbd) ? $kodeAkunApbd : '',
                            'nama_akun_apbd' => isset($namaAkunApbd) ? $namaAkunApbd : '',
                            'pengeluaran' => 0,
                            'pendapatan' => $rincianSts->nominal
                        ];
                        $totalPendapatan += $rincianSts->nominal;

                    }
                } else if ($item->tipe == BkuRincian::KONTRAPOS) {
                    foreach ($item->kontrapos->kontraposRincian as $rincianKontrapos) {
                        if (substr($rincianKontrapos->akun->kode_akun, 0, 1) == 5 || substr($rincianKontrapos->akun->kode_akun, 0, 1) == 4) {
                            $kodeAkun = $rincianKontrapos->akun->kode_akun;
                            $namaAkun = $rincianKontrapos->akun->nama_akun;
                            $kodeAkunApbd = $rincianKontrapos->akun->mapAkun ? $rincianKontrapos->akun->mapAkun->map->kode_akun : null;
                            $namaAkunApbd = $rincianKontrapos->akun->mapAkun ? $rincianKontrapos->akun->mapAkun->map->nama_akun : null;
                        }
                        $rincianSp3b[] = [
                            'nomor' => $item->no_aktivitas,
                            'kegiatan_id' => '',
                            'kode_kegiatan' => '',
                            'nama_kegiatan' => '',
                            'kegiatan_id_apbd' => '',
                            'kode_kegiatan_apbd' => '',
                            'nama_kegiatan_apbd' => '',
                            'kode_akun' => isset($kodeAkun) ? $kodeAkun : '',
                            'nama_akun' => isset($namaAkun) ? $namaAkun : '',
                            'kode_akun_apbd' => isset($kodeAkunApbd) ? $kodeAkunApbd : '',
                            'nama_akun_apbd' => isset($namaAkunApbd) ? $namaAkunApbd : '',
                            'pengeluaran' => 0,
                            'pendapatan' => $rincianKontrapos->nominal
                        ];
                        $totalPendapatan += $rincianKontrapos->nominal;

                    }
                }
            });

            $response = [
                'data' => [
                    'sp3b' => $rincianSp3b,
                    'total' => [
                        'pendapatan' => $totalPendapatan,
                        'pengeluaran' => $totalPengeluaran
                    ]
                ],
                'success' => true
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'line' => $e->getLine(),
                'message' => $e->getMessage()
            ]);
        }
    }
}

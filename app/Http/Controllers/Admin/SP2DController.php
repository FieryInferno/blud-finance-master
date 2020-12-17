<?php

namespace App\Http\Controllers\Admin;

use App\Models\PrefixPenomoran;
use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Controllers\Controller;
use App\Repositories\Belanja\SP2DRepository;
use App\Repositories\BKU\BKURincianRepository;
use App\Repositories\Organisasi\UnitKerjaRepository;
use App\Repositories\Pengembalian\KontraposRincianRepository;
use App\Repositories\PrefixPenomoranRepository;
use Symfony\Component\HttpFoundation\Request;

class SP2DController extends Controller
{
    /**
     * SetorPajak Repository
     * 
     * @var SP2DRepository
     */
    private $sp2d;


    /**
     * PAJAK Repository
     * 
     * @var PrefixPenomoranRepository
     */
    private $prefixPenomoran;

    /**
     * Bku rincian repository.
     * 
     * @var BKURincianRepository
     */
    private $bkuRincian;

    /**
     * KontraposRincianRepository
     *
     * @var KontraposRincianRepository
     */
    private $kontraposRincian;

    /**
     * Unit kerja repository
     * 
     * @var UnitKerjaRepository
     */
    private $unitKerja;

    /**
     * Constructor.
     */
    public function __construct(
        PrefixPenomoranRepository $prefixPenomoran,
        SP2DRepository $sp2d,
        BKURincianRepository $bkuRincian,
        KontraposRincianRepository $kontraposRincian,
        UnitKerjaRepository $unitKerja
    ) {
        $this->sp2d = $sp2d;
        $this->prefixPenomoran = $prefixPenomoran;
        $this->bkuRincian = $bkuRincian;
        $this->kontraposRincian = $kontraposRincian;
        $this->unitKerja = $unitKerja;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $prefix = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_SP2D);

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
        $sp2d = $this->sp2d->get(['*'], $where, ['unitKerja', 'bast.kegiatan']);

        $prefixPenomoran = explode('/', $prefix->format_penomoran);
        $sp2d->map(function ($item) use ($prefixPenomoran) {
            if ($item->nomor_otomatis) {
                $nomorFix = nomor_fix($prefixPenomoran, $item->nomor, $item->kode_unit_kerja);
                $item->nomorfix = $nomorFix;
            } else {
                $item->nomorfix = $item->nomor;
            }
        });

        return view('admin.sp2d.index', compact('sp2d', 'unitKerja'));
    }

    /**
     * Show spesific sp2d
     *
     * @param [type] $id
     * @return void
     */
    public function show($id)
    {
        $prefix = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_SP2D);
        $prefixPenomoran = explode('/', $prefix->format_penomoran);
        $sp2d = $this->sp2d->find($id, ['*'], [
            'bast.pihakKetiga', 'bast.kegiatan', 'bendaharaPengeluaran', 'unitKerja', 'pejabatPptk',
            'pejabatPemimpinBlud', 'rekeningBendahara'
            ]);
        if ($sp2d->nomor_otomatis) {
            $nomorFix = nomor_fix($prefixPenomoran, $sp2d->nomor, $sp2d->kode_unit_kerja);
            $sp2d->nomorfix = $nomorFix;
        } else {
            $sp2d->nomorfix = $sp2d->nomor;
        }

        $bills = [];
        foreach($sp2d->referensiPajak as $key => $item) {
            $pajakId = $item->pajak->id;

            $i = 1;
            foreach($item->noBilling as $billing) {
                $bills["billing[{$pajakId}][{$i}]"] = $billing->no_billing;
                $i++;
            }
        }
        
        return view('admin.sp2d.show', compact('sp2d', 'bills'));
    }

    /**
     * Get data of sp2d
     *
     * @return void
     */
    public function getData(Request $request)
    {
        try {

            $whereBkuRincian = function ($query) {
                $query->whereNotNull('sp2d_id');
            };

            $bkuRincian = $this->bkuRincian->get(['*'], $whereBkuRincian);
            $sp2dId = $bkuRincian->pluck('sp2d_id')->unique();
            $prefix = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_SETORAN_PAJAK_SP2D);

            $where = function ($query) use ($request, $sp2dId) {
                $query->where('kode_unit_kerja', $request->kode_unit_kerja)
                    ->whereNotIn('id', $sp2dId);
            };
            $sp2d = $this->sp2d->get(['*'], $where, ['unitKerja', 'bast.kegiatan']);

            $prefixPenomoran = explode('/', $prefix->format_penomoran);
            $sp2d->map(function ($item) use ($prefixPenomoran) {
                if ($item->nomor_otomatis) {
                    $nomorFix = nomor_fix($prefixPenomoran, $item->nomor, $item->kode_unit_kerja);
                    $item->nomorfix = $nomorFix;
                } else {
                    $item->nomorfix = $item->nomor;
                }
            });

            $response = [
                'data' => $sp2d
            ];

            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => $e->getCode(),
                'data' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Get data sp2d kontrapos
     *
     * @return void
     */
    public function getDataKontrapos(Request $request)
    {
        try {
           
            $prefix = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_SETORAN_PAJAK_SP2D);

            $where = function ($query) use ($request) {
                $query->where('kode_unit_kerja', $request->unit_kerja);
            };
            $sp2d = $this->sp2d->get(['*'], $where, ['unitKerja', 'bast.kegiatan', 'bast.rincianPengadaan.akun']);

            $dataSp2d = [];

            $prefixPenomoran = explode('/', $prefix->format_penomoran);
            $sp2d->map(function ($item) use ($prefixPenomoran) {
                if ($item->nomor_otomatis) {
                    $nomorFix = nomor_fix($prefixPenomoran, $item->nomor, $item->kode_unit_kerja);
                    $item->nomorfix = $nomorFix;
                } else {
                    $item->nomorfix = $item->nomor;
                } 
            });

            $kegiatanId = $this->kontraposRincian->getKegiatanId($request->unit_kerja);

            foreach ($sp2d as $key => $item) {
                foreach ($item->bast->rincianPengadaan as $value) {
                    $dataSp2d[] = [
                        'sp2d_id' => $item->id,
                        'kegiatan_id' => $item->bast->kegiatan->id,
                        'kode_kegiatan' => $item->bast->kegiatan->kode_bidang . '.' . $item->bast->kegiatan->kode_bidang . '.' . $item->bast->kegiatan->kode,
                        'nama_kegiatan' => $item->bast->kegiatan->nama_kegiatan,
                        'kode_akun' => $value->kode_akun,
                        'nama_akun' => $value->akun->nama_akun,
                        'realisasi_sp2d' => $item->nominal_sumber_dana
                    ];
                }
            }

            $response = [
                'data' => $dataSp2d
            ];

            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => $e->getCode(),
                'data' => $e->getMessage(),
            ]);
        }
    }


    /**
     * Report sp2d
     *
     * @param [type] $id
     * @return void
     */
    public function report($id)
    {
        $prefix = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_SP2D);
        $this->prefixPenomoran->makeModel();
        $prefixSpm = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_SPM);

        $prefixPenomoran = explode('/', $prefix->format_penomoran);
        $prefixPenomoranSpm = explode('/', $prefixSpm->format_penomoran);
        $sp2d = $this->sp2d->find($id, ['*'], [
            'bast.pihakKetiga', 'bast.kegiatan', 'bendaharaPengeluaran', 'unitKerja', 'pejabatPptk',
            'pejabatPemimpinBlud', 'rekeningBendahara', 'bast.rincianPengadaan.akun', 'referensiPajak'
        ]);
        if ($sp2d->nomor_otomatis) {
            $nomorFix = nomor_fix($prefixPenomoran, $sp2d->nomor, $sp2d->kode_unit_kerja);
            $sp2d->nomorfix = $nomorFix;
            $sp2d->nomorspm = nomor_fix($prefixPenomoranSpm, $sp2d->nomor, $sp2d->kode_unit_kerja);
        } else {
            $sp2d->nomorfix = $sp2d->nomor;
            $sp2d->nomorspm = $sp2d->nomor;
        }

        $totalRincian = 0;
        foreach ($sp2d->bast->rincianPengadaan as $item) {
            $totalRincian += ((float) $item->harga) * $item->unit;
        }
        $totalPajak = 0;
        foreach ($sp2d->referensiPajak as $key => $value) {
            if (! $value->is_information){
                $totalPajak+= $value->nominal;
            }
        }

        $pdf = PDF::loadview('admin.report.form_sp2d', compact('sp2d', 'totalRincian', 'totalPajak'));
        return $pdf->stream('report_sp2d.pdf', ['Attachment' => false]);    }
}

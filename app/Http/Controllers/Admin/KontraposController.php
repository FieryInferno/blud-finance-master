<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Pengembalian\KontraposRequest;
use App\Models\PrefixPenomoran;
use App\Repositories\BKU\BKURincianRepository;
use App\Repositories\Organisasi\RekeningBendaharaRepository;
use App\Repositories\Organisasi\UnitKerjaRepository;
use App\Repositories\Pengembalian\KontraposRepository;
use App\Repositories\Pengembalian\KontraposRepositoryRincian;
use App\Repositories\Pengembalian\KontraposRincianRepository;
use App\Repositories\PrefixPenomoranRepository;

class KontraposController extends Controller
{
    /**
     * Unit kerja repository.
     * 
     * @var UnitKerjaRepository
     */
    private $unitKerja;

    /**
     * Kontrapos Repository
     *
     * @var KontraposRepository
     */
    private $kontrapos;

    /**
     * Kontrapos Rincian Repository
     *
     * @var KontraposRincianRepository
     */
    private $kontraposRincian;

    /**
     * PrefixPenomoranRepository
     *
     * @var PrefixPenomoranRepository
     */
    private $prefixPenomoran;

    /**
     * RekeningBendaharaRepository
     *
     * @var RekeningBendaharaRepository
     */
    private $rekeningBendahara;

    /**
     * BkuRincianRepository
     *
     * @var BkuRincianRepository
     */
    private $bkuRincian;

    /**
     * constructor
     * 
     */
    public function __construct(
        UnitKerjaRepository $unitKerja,
        KontraposRepository $kontrapos,
        KontraposRincianRepository $kontraposRincian,
        PrefixPenomoranRepository $prefixPenomoran,
        RekeningBendaharaRepository $rekeningBendahara,
        BKURincianRepository $bkuRincian
    )
    {
        $this->unitKerja = $unitKerja;
        $this->kontrapos = $kontrapos;
        $this->kontraposRincian = $kontraposRincian;
        $this->prefixPenomoran = $prefixPenomoran;
        $this->rekeningBendahara = $rekeningBendahara;
        $this->bkuRincian = $bkuRincian;
    }

    /**
     * List all data kontrapos
     *
     * @return void
     */
    public function index()
    {
        $prefix = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_KONTRA_POS);

        if (auth()->user()->hasRole('Admin')) {
            $kontrapos = $this->kontrapos->get(['*'], null, ['unitKerja', 'kontraposRincian']);
        } else {
            $where = function ($query) {
                $query->where('kode_unit_kerja', auth()->user()->kode_unit_kerja);
            };
            $kontrapos = $this->kontrapos->get(['*'], $where, ['unitKerja', 'kontraposRincian']);
        }

        $prefixPenomoran = explode('/', $prefix->format_penomoran);
        $kontrapos->map(function ($item) use ($prefixPenomoran) {
            $item->total_nominal = $item->kontraposRincian->sum('nominal');
            if ($item->nomor_otomatis) {
                $nomorFix = nomor_fix($prefixPenomoran, $item->nomor, $item->kode_unit_kerja);
                $item->nomorfix = $nomorFix;
            } else {
                $item->nomorfix = $item->nomor;
            }
        });

        $totalAllKontrapos = $kontrapos->sum(function ($item) {
            return $item->kontraposRincian->sum('nominal');
        });
        return view('admin.kontrapos.index', compact('kontrapos', 'totalAllKontrapos'));
    }

    /**
     * Form create
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
        return view('admin.kontrapos.create', compact('unitKerja'));
    }

    /**
     * Store 
     *
     * @param KontraposRequest $request
     * @return void
     */
    public function store(KontraposRequest $request)
    {
        try {
            DB::beginTransaction();

            $nomorOtomatis = true;

            if (!$request->nomor) {
                $kontrapos = $this->kontrapos->getLastKontrapos($request->unit_kerja);
                if ($kontrapos) {
                    $nomor = $kontrapos->nomor + 1;
                } else {
                    $nomor = 1;
                }
            } else {
                $nomor = $request->nomor;
                $nomorOtomatis = false;
            }

            $kontrapos = $this->kontrapos->create([
                'nomor' => $nomor,
                'nomor_otomatis' => $nomorOtomatis,
                'tanggal' => $request->tanggal, 
                'kode_unit_kerja' => $request->unit_kerja,
                'keterangan' => $request->keterangan,
                'rekening_bendahara' => $request->rekening_bendahara
            ]);

            if (!$kontrapos) {
                throw new Exception("Error create kontrapos");
            }

            foreach ($request->sp2d_id as $key => $value) {
                $kontraposRincian = $this->kontraposRincian->create([
                    'kontrapos_id' => $kontrapos->id,
                    'sp2d_id' => $request->sp2d_id[$key],
                    'kegiatan_id' => $request->kegiatan_id[$key],
                    'nominal' => parse_format_number($request->nominal[$key]),
                    'kode_akun' => $request->kode_akun[$key],
                    'realisasi_sp2d' => parse_format_number($request->realisasi_sp2d[$key]),
                    'sumber_dana' => $request->sumber_dana[$key],
                ]);

                if (!$kontraposRincian) {
                    throw new Exception("Error create rincian kontrapos");
                }
            }

            DB::commit();
            return response()->json(['status' => 'oke', 'spd' => $kontrapos], 200);
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
        $prefix = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_KONTRA_POS);
        $prefixPenomoran = explode('/', $prefix->format_penomoran);
        $kontrapos = $this->kontrapos->findBy('id', '=', $id, ['*'], ['unitKerja', 'kontraposRincian.akun', 'kontraposRincian.kegiatan']);

        if ($kontrapos->nomor_otomatis) {
            $nomorFix = nomor_fix($prefixPenomoran, $kontrapos->nomor, $kontrapos->kode_unit_kerja);
            $kontrapos->nomorfix = $nomorFix;
        } else {
            $kontrapos->nomorfix = $kontrapos->nomor;
        }

        if (auth()->user()->hasRole('Admin')) {
            $unitKerja = $this->unitKerja->get();
        } else {
            $where = function ($query) {
                $query->where('kode', auth()->user()->kode_unit_kerja);
            };
            $unitKerja = $this->unitKerja->get(['*'], $where);
        }
        $whereRekening = function ($query) use($kontrapos) {
            $query->where('kode_unit_kerja', $kontrapos->kode_unit_kerja);
        };
        $rekeningBendahara = $this->rekeningBendahara->get(['*'], $whereRekening);

        return view('admin.kontrapos.edit', compact('kontrapos', 'unitKerja', 'rekeningBendahara'));
    }

    public function update(KontraposRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $kontrapos = $this->kontrapos->update([
                'tanggal' => $request->tanggal,
                'kode_unit_kerja' => $request->unit_kerja,
                'keterangan' => $request->keterangan,
                'rekening_bendahara' => $request->rekening_bendahara
            ], $id);

            $this->kontraposRincian->deleteAll($id);

            foreach ($request->sp2d_id as $key => $value) {
                $kontraposRincian = $this->kontraposRincian->create([
                    'kontrapos_id' => $id,
                    'sp2d_id' => $request->sp2d_id[$key],
                    'kegiatan_id' => $request->kegiatan_id[$key],
                    'nominal' => parse_format_number($request->nominal[$key]),
                    'kode_akun' => $request->kode_akun[$key],
                    'realisasi_sp2d' => parse_format_number($request->realisasi_sp2d[$key]),
                    'sumber_dana' => $request->sumber_dana[$key],
                ]);

                if (!$kontraposRincian) {
                    throw new Exception("Error create rincian kontrapos");
                }
            }

            DB::commit();
            return response()->json(['status' => 'oke', 'spd' => $kontrapos], 200);
        }catch(\Exception $e) {
            DB::rollback();
            return response()->json([
                'data' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Destroy spesific kontrapos
     *
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request)
    {
        try {
            $kontrapos = $this->kontrapos->find($request->id);

            if (!$kontrapos) {
                throw new \Exception('Data tidak ditemukan');
            }

            $this->kontraposRincian->deleteAll($kontrapos->id);

            $kontrapos->delete();

            return redirect()->back()
                ->with(['success' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with(['error' => $e->getMessage()]);
        }
    }

    public function getData(Request $request)
    {
        try {

            $whereBkuRincian = function ($query) {
                $query->whereNotNull('kontrapos_id');
            };

            $bkuRincian = $this->bkuRincian->get(['*'], $whereBkuRincian);
            $kontraposId = $bkuRincian->pluck('kontrapos_id')->unique();
            $prefix = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_KONTRA_POS);

            $where = function ($query) use ($request, $kontraposId) {
                $query->where('kode_unit_kerja', $request->kode_unit_kerja)
                    ->whereNotIn('id', $kontraposId);
            };
            $kontrapos = $this->kontrapos->get(['*'], $where, ['unitKerja', 'kontraposRincian']);

            $prefixPenomoran = explode('/', $prefix->format_penomoran);
            $kontrapos->map(function ($item) use ($prefixPenomoran) {
                if ($item->nomor_otomatis) {
                    $nomorFix = nomor_fix($prefixPenomoran, $item->nomor, $item->kode_unit_kerja);
                    $item->nomorfix = $nomorFix;
                } else {
                    $item->nomorfix = $item->nomor;
                }
                $item->nominal = $item->kontraposRincian->sum('nominal');
            });

            $response = [
                'data' => $kontrapos
            ];

            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => $e->getCode(),
                'data' => $e->getMessage(),
            ]);
        }
    }
}

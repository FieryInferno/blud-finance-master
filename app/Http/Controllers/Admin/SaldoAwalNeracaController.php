<?php

namespace App\Http\Controllers\Admin;

use App\Models\SaldoAwal;
use Illuminate\Http\Request;
use App\Models\PrefixPenomoran;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repositories\RBA\RBARepository;
use App\Repositories\DataDasar\AkunRepository;
use App\Http\Requests\Akutansi\SaldoAwalRequest;
use App\Repositories\Akutansi\SaldoAwalRepository;
use App\Repositories\Organisasi\UnitKerjaRepository;
use App\Repositories\Akutansi\SaldoAwalRincianRepository;
use App\Repositories\Pengaturan\PrefixPenomoranRepository;

class SaldoAwalNeracaController extends Controller
{
    /**
     * Unit kerja repository.
     * 
     * @var UnitKerjaRepository
     */
    private $unitKerja;

    /**
     * Akun Repository
     *
     * @var AkunRepository
     */
    private $akun;

    /**
     * Saldo Awal Repository
     *
     * @var SaldoAwalRepository
     */
    private $saldoAwal;

    /**
     * Saldo Awal Rincian Repository
     *
     * @var SaldoAwalRincianRepository
     */
    private $saldoAwalRincian;

    /**
     * Rba repository
     *
     * @var RbaRepository
     */
    private $rba;

    /**
     * Prefix penomoran repository
     *
     * @var prefixPenomoranRepository
     */
    private $prefixPenomoran;

    /**
     * Undocumented function
     *
     * @param UnitKerjaRepository $unitKerja
     */
    public function __construct(
        UnitKerjaRepository $unitKerja,
        AkunRepository $akun,
        SaldoAwalRepository $saldoAwal,
        SaldoAwalRincianRepository $saldoAwalRincian,
        RBARepository $rba,
        PrefixPenomoranRepository $prefixPenomoran
    )
    {
        $this->unitKerja = $unitKerja;
        $this->akun = $akun;
        $this->saldoAwal = $saldoAwal;
        $this->saldoAwalRincian = $saldoAwalRincian;
        $this->rba = $rba;
        $this->prefixPenomoran = $prefixPenomoran;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prefix = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_SALDOAWAL_NERACA);

        if (auth()->user()->hasRole('Admin')) {
            $where = function ($query) {
                $query->where('tipe', SaldoAwal::NERACA);
            };
        }else {
            $where = function ($query){
                $query->where('tipe', SaldoAwal::NERACA);
                $query->where('kode_unit_kerja', auth()->user()->kode_unit_kerja);
            };
        }

        $prefixPenomoran = explode('/', $prefix->format_penomoran);

        $saldoAwal = $this->saldoAwal->get(['*'], $where, ['unitKerja', 'saldoAwalRincian']);

        $saldoAwal->map(function ($item) use($prefixPenomoran) {
            $item->debet = $item->saldoAwalRincian->sum('debet');
            $item->kredit = $item->saldoAwalRincian->sum('kredit');

            if ($item->nomor_otomatis) {
                $nomorFix = nomor_fix($prefixPenomoran, $item->nomor, $item->kode_unit_kerja);
                $item->nomorfix = $nomorFix;
            } else {
                $item->nomorfix = $item->nomor;
            }
        });
        
        $totalDebet = 0;
        $totalKredit = 0;

        foreach ($saldoAwal as $key => $value) {
            $totalDebet += $value->debet;
            $totalKredit += $value->kredit;
        }

        return view('admin.saldo_awal_neraca.index', compact('saldoAwal', 'totalDebet', 'totalKredit'));
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
        
        $where = function ($query) {
            $query->where('tipe', 1)
                ->orWhere('tipe', 2)
                ->orWhere('tipe', 3);
        };
        $akunLo = $this->akun->get(['*'], $where)->sortBy('kode_akun');
        return view('admin.saldo_awal_neraca.create', compact('unitKerja', 'akunLo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaldoAwalRequest $request)
    {
        try {
            DB::beginTransaction();

            $nomorOtomatis = true;

            if (!$request->nomor) {
                $saldoAwal = $this->saldoAwal->getLastSaldoAwal($request->unit_kerja, SaldoAwal::NERACA);
                if ($saldoAwal) {
                    $nomor = $saldoAwal->nomor + 1;
                } else {
                    $nomor = 1;
                }
            } else {
                $nomor = $request->nomor;
                $nomorOtomatis = false;
            }

            $saldoAwal = $this->saldoAwal->create([
                'nomor' => $nomor,
                'nomor_otomatis' => $nomorOtomatis,
                'kode_unit_kerja' => $request->unit_kerja,
                'keterangan' => $request->keterangan,
                'tipe' => SaldoAwal::NERACA,
                'tanggal' => $request->tanggal
            ]);

            foreach ($request->kode_akun as $key => $value) {
                $this->saldoAwalRincian->create([
                    'saldo_awal_id' => $saldoAwal->id,
                    'akun_id' => $this->rba->getAkunId($request->kode_akun[$key])->id,
                    'debet' => parse_format_number($request->debet[$key]),
                    'kredit' => parse_format_number($request->kredit[$key]),
                ]);
            }

            DB::commit();
            return response()->json(['status' => 'oke', 'saldo_awal' => $saldoAwal], 200);
        }catch (\Exception $e) {
            DB::rollBack();
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
        if (auth()->user()->hasRole('Admin')) {
            $unitKerja = $this->unitKerja->get();
        } else {
            $where = function ($query) {
                $query->where('kode', auth()->user()->kode_unit_kerja);
            };
            $unitKerja = $this->unitKerja->get(['*'], $where);
        }
        $saldoAwal = $this->saldoAwal->find($id, ['*'], ['saldoAwalRincian.akun']);

        $where = function ($query) {
            $query->where('tipe', 1)
                ->orWhere('tipe', 2)
                ->orWhere('tipe', 3);
        };
        $akunLo = $this->akun->get(['*'], $where)->sortBy('kode_akun');

        $akunId = $saldoAwal->saldoAwalRincian->pluck('akun_id')->toArray();
        
        return view('admin.saldo_awal_neraca.edit', compact('saldoAwal', 'unitKerja', 'akunLo', 'akunId'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SaldoAwalRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $saldoAwal = $this->saldoAwal->update([
                'kode_unit_kerja' => $request->unit_kerja,
                'keterangan' => $request->keterangan,
                'tipe' => SaldoAwal::NERACA,
                'tanggal' => $request->tanggal
            ], $id);

            $this->saldoAwalRincian->deleteAll($id);

            foreach ($request->kode_akun as $key => $value) {
                $this->saldoAwalRincian->create([
                    'saldo_awal_id' => $id,
                    'akun_id' => $this->rba->getAkunId($request->kode_akun[$key])->id,
                    'debet' => parse_format_number($request->debet[$key]),
                    'kredit' => parse_format_number($request->kredit[$key]),
                ]);
            }

            DB::commit();
            return response()->json(['status' => 'oke', 'saldo_awal' => $saldoAwal], 200);

        }catch (\Exception $e) {
            DB::rollBack();
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
            $saldoAwal = $this->saldoAwal->find($request->id);

            if (!$saldoAwal) {
                throw new \Exception('Data tidak ditemukan');
            }

            $this->saldoAwalRincian->deleteAll($saldoAwal->id);

            $saldoAwal->delete();

            return redirect()->back()
                ->with(['success' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with(['error' => $e->getMessage()]);
        }
    }
}

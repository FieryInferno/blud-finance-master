<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DataDasar\AkunRequest;
use App\Models\Rba;
use App\Repositories\Belanja\SPDRepository;
use App\Repositories\DataDasar\SSHRepository;
use App\Repositories\DataDasar\AkunRepository;
use App\Repositories\DataDasar\KategoriAkunRepository;
use App\Repositories\Organisasi\KegiatanRepository;
use App\Repositories\Organisasi\SubKegiatanRepository;
use App\Repositories\RBA\RBARepository;

class AkunController extends Controller
{
    /**
     * Akun repository.
     * 
     * @var AkunRepository
     */
    private $akun;

    /**
     * Kategori repository.
     * 
     * @var KategorRepository
     */
    private $kategori;

    /**
     * SSH repository.
     * 
     * @var SSHRepository
     */
    private $ssh;

    /**
     * SSH repository.
     * 
     * @var RBARepository
     */
    private $rba;

    /**
     * SSH repository.
     * 
     * @var KegiatanRepository
     */
    private $kegiatan;

    /**
     * Spd repository.
     * 
     * @var SPDRepository
     */
    private $spd;
    private $subKegiatan;

    /**
     * Constructor.
     */
    public function __construct(
        AkunRepository $akun,
        KategoriAkunRepository $kategori,
        SSHRepository $ssh,
        RBARepository $rba,
        KegiatanRepository $kegiatan,
        SPDRepository $spd,
        SubKegiatanRepository $subKegiatan
    ) {
        $this->akun         = $akun;
        $this->kategori     = $kategori;
        $this->ssh          = $ssh;
        $this->rba          = $rba;
        $this->kegiatan     = $kegiatan;
        $this->spd          = $spd;
        $this->subKegiatan  = $subKegiatan;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategori = $this->kategori->get();
        $akun = $this->akun->get();
        return view('admin.akun.index', compact('akun', 'kategori')); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AkunRequest $request)
    {
        $akun = $this->akun->create([
            'tipe' => $request->tipe,
            'kelompok' => $request->kelompok,
            'jenis' => $request->jenis,
            'objek' => $request->objek,
            'rincian' => $request->rincian,
            'sub1' => $request->sub1,
            'sub2' => $request->sub2,
            'sub3' => $request->sub3,
            'nama_akun' => $request->nama_akun,
            'kode_akun' => $request->kode_akun,
            'kategori_id' => $request->kategori,
            'pagu' => parse_idr($request->pagu),
            'is_parent' => $request->is_parent
        ]);
        return redirect()->back()
                ->with(['success' => "{$akun->nama_akun} berhasil disimpan"]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AkunRequest $request)
    {
        $akun = $this->akun->find($request->id);
        $akun->tipe = $request->tipe;
        $akun->kelompok = $request->kelompok;
        $akun->jenis = $request->jenis;
        $akun->objek = $request->objek;
        $akun->rincian = $request->rincian;
        $akun->sub1 = $request->sub1;
        $akun->sub2 = $request->sub2;
        $akun->sub3 = $request->sub3;
        $akun->nama_akun = $request->nama_akun;
        $akun->kode_akun = $request->kode_akun;
        $akun->kategori_id = $request->kategori;
        $akun->pagu = parse_idr($request->pagu);
        $akun->is_parent = $request->is_parent;
        $akun->save();
        return redirect()->back()
                ->with(['success' => "{$akun->nama_akun} berhasil disimpan"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->akun->delete($request->id);
        return redirect()->back()
                ->with(['success' => 'Data berhasil dihapus']);
    }

    /**
     * Get akun rba
     *
     * @return void
     */
    public function getAkunRba1(Request $request)
    {
        $unitKerja = $request->unit_kerja;
        $rba = $this->rba->getRba1($unitKerja);
        $akunId = $rba->rincianAnggaran->pluck('akun_id');

        $whereAkun = function ($query) use($akunId){
            $query->whereIn('id', $akunId);
        };
        $akun = $this->akun->get(['*'], $whereAkun);

        $sumberDana = $rba->rincianSumberDana;

        $sumberDana->map(function ($item){
            $item->kode_akun = $this->akun->getKodeAkun($item->akun_id);
        });

        $response = [
            'akun' => $akun,
            'sumber_dana' => $sumberDana
        ];
        return response()->json($response, 200);
    }

    /**
     * Get akun rba
     *
     * @return void
     */
    public function getAkunRba221(Request $request)
    {
        $unitKerja  = $request->unit_kerja;
        $rba        = $this->rba->getRba221($unitKerja, auth()->user()->status, Rba::KODE_RBA_221);

        $whereSpd   = function ($query) use ($unitKerja) {
            $query->where('kode_unit_kerja', $unitKerja);
        };

        $spd        = $this->spd->get(['*'], $whereSpd, ['spdRincian']);

        $totalSpd   = $spd->sum(function ($item) {
            return $item->spdRincian->sum('nominal');
        });

        $anggaran   = $rba->sum(function ($item) {
            return $item->rincianSumberDana->sum('nominal');
        });

        $rba->map(function ($item) use($totalSpd, $anggaran){
            $item->total_nominal    = $anggaran;
            $item->kodeSubKegiatan  = $item->mapSubKegiatan->subKegiatanBlud->kodeSubKegiatan;
            $item->namaSubKegiatan  = $item->mapSubKegiatan->subKegiatanBlud->namaSubKegiatan;
            $item->total_spd        = $totalSpd;
        });
        
        foreach ($rba as $value) {
            unset($value->mapSubKegiatan);
            unset($value->rincianSumberDana);
        }

        $response = [
            'data' => $rba,
        ];

        return response()->json($response, 200);
    }

    /**
     * Get all kegiatan from rba 221
     *
     * @return void
     */
    public function getKegiatanRba221(Request $request)
    {
        $unitKerja  = $request->unit_kerja;
        $rba        = $this->rba->getRba221($unitKerja, auth()->user()->status, Rba::KODE_RBA_221);
        
        $kegiatanId = [];
        foreach ($rba as  $item) {
            if (! in_array($item->mapSubKegiatan->kodeSubKegiatanBlud, $kegiatanId)){
                array_push($kegiatanId, $item->mapSubKegiatan->kodeSubKegiatanBlud);
            }
        }

        $whereSubKegiatan   = function ($query) use($kegiatanId){
            $query->whereIn('kodeSubKegiatan', $kegiatanId);
        };

        $subKegiatan    =  $this->subKegiatan->get(['*'], $whereSubKegiatan);

        $response   = ['data' => $subKegiatan];
        return response()->json($response, 200);
    }

    /**
     * Get akun by kegiatan
     *
     * @return void
     */
    public function getAkunByKegiatan(Request $request)
    {
        $unitKerja          = $request->unit_kerja;
        $subKegiatan        = $this->subKegiatan->find($request->subKegiatan, ['*']);
        
        $kodeSubKegiatan    = $subKegiatan->kodeSubKegiatan;
        $rba                = $this->rba->getRba221ByKegiatan($unitKerja, $kodeSubKegiatan);

        $akunId = [];
        foreach ($rba->rincianAnggaran as $value) {
            if (! in_array($value->akun_id, $akunId)){
                array_push($akunId, $value->akun_id);
            }
        }

        $whereAkun = function ($query) use($akunId){
            $query->whereIn('id', $akunId);
        };
        $akun = $this->akun->get(['*'], $whereAkun)->sortBy('kode_akun')->values()->all();

        $response = [
            'data' => $akun
        ];
        return response()->json($response, 200);
    }
}

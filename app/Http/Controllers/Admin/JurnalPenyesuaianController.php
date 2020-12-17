<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Akutansi\JurnalPenyesuaianRequest;
use App\Models\PrefixPenomoran;
use App\Models\Rba;
use App\Repositories\Akutansi\JurnalPenyesuaianRepository;
use App\Repositories\Akutansi\JurnalPenyesuaianRincianRepository;
use App\Repositories\DataDasar\AkunRepository;
use App\Repositories\Organisasi\UnitKerjaRepository;
use App\Repositories\Pengaturan\PrefixPenomoranRepository;
use App\Repositories\RBA\RBARepository;
use Illuminate\Support\Facades\DB;

class JurnalPenyesuaianController extends Controller
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
     * Rba repository
     *
     * @var RbaRepository
     */
    private $rba;

    /**
     * Saldo penyesuaian repository
     *
     * @var JurnalPenyesuaianRepository
     */
    private $jurnalPenyesuaian;

    /**
     * Jurnal penyesuaian rincian repository
     *
     * @var JurnalPenyesuaianRincianRepository
     */
    private $jurnalPenyesuaianRincian;

    /**
     * Prefix penomoran repository
     *
     * @var PrefixPenomoranRepository
     */
    private $prefixPenomoran;

    public function __construct(
        UnitKerjaRepository $unitKerja,
        AkunRepository $akun,
        RBARepository $rba,
        JurnalPenyesuaianRepository $jurnalPenyesuaian,
        JurnalPenyesuaianRincianRepository $jurnalPenyesuaianRincian,
        PrefixPenomoranRepository $prefixPenomoran
    ) {
        $this->unitKerja = $unitKerja;
        $this->akun = $akun;
        $this->rba = $rba;
        $this->jurnalPenyesuaian = $jurnalPenyesuaian;
        $this->jurnalPenyesuaianRincian = $jurnalPenyesuaianRincian;
        $this->prefixPenomoran = $prefixPenomoran;
    }

    /**
     * Index.
     *
     */
    public function index(Request $request)
    {
        $prefix = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_JURNAL_PENYESUAIAN);
        $where = function ($query) use($request){
            if (auth()->user()->hasRole('Puskesmas')){
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
        $debet = 0;
        $kredit = 0;
        $jurnalPenyesuaian = $this->jurnalPenyesuaian->get(['*'], $where, ['jurnalPenyesuaianRincian', 'unitKerja']);
        $prefixPenomoran = explode('/', $prefix->format_penomoran);
        
        $jurnalPenyesuaian->map(function ($item) use(&$debet, &$kredit, $prefixPenomoran){
            $totalDebet = $item->jurnalPenyesuaianRincian->sum('debet'); 
            $totalKredit = $item->jurnalPenyesuaianRincian->sum('kredit');
            $item->totalDebet = $totalDebet;
            $item->totalKredit = $totalKredit;
            $debet += $totalDebet;
            $kredit += $totalKredit;

            if ($item->nomor_otomatis) {
                $nomorFix = nomor_fix($prefixPenomoran, $item->nomor, $item->kode_unit_kerja);
                $item->nomorfix = $nomorFix;
            } else {
                $item->nomorfix = $item->nomor;
            }
        });

        $unitKerja = $this->unitKerja->get(['*']);

        return view('admin.jurnal_penyesuaian.index', compact('jurnalPenyesuaian', 'debet', 'kredit', 'unitKerja'));
    }

    /**
     * Form create
     *
     * @return void
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
        
        return view('admin.jurnal_penyesuaian.create', compact('unitKerja', 'akun'));
    }

    public function edit($id)
    {
        $prefix = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_JURNAL_PENYESUAIAN);

        $prefixPenomoran = explode('/', $prefix->format_penomoran);

        $jurnalPenyesuaian = $this->jurnalPenyesuaian->find($id, ['*'], ['jurnalPenyesuaianRincian.akun', 'jurnalPenyesuaianRincian.kegiatan']);
        if (auth()->user()->hasRole('Admin')) {
            $unitKerja = $this->unitKerja->get();
        } else {
            $where = function ($query) {
                $query->where('kode', auth()->user()->kode_unit_kerja);
            };
            $unitKerja = $this->unitKerja->get(['*'], $where);
        }
        if ($jurnalPenyesuaian->nomor_otomatis) {
            $nomorFix = nomor_fix($prefixPenomoran, $jurnalPenyesuaian->nomor, $jurnalPenyesuaian->kode_unit_kerja);
            $jurnalPenyesuaian->nomorfix = $nomorFix;
        } else {
            $jurnalPenyesuaian->nomorfix = $jurnalPenyesuaian->nomor;
        }

        return view('admin.jurnal_penyesuaian.edit', compact('unitKerja', 'jurnalPenyesuaian'));
    }

    public function store(JurnalPenyesuaianRequest $request)
    {
        try {
            DB::beginTransaction();

            $nomorOtomatis = true;

            if (! $request->nomor) {
                $jurnalPenyesuaian = $this->jurnalPenyesuaian->getLastJurnalPenyesuaian($request->unit_kerja);
                if ($jurnalPenyesuaian) {
                    $nomor = $jurnalPenyesuaian->nomor + 1;
                } else {
                    $nomor = 1;
                }
            } else {
                $nomor = $request->nomor;
                $nomorOtomatis = false;
            }

            $jurnalPenyesuaian = $this->jurnalPenyesuaian->create([
                'nomor' => $nomor,
                'nomor_otomatis' => $nomorOtomatis,
                'kode_unit_kerja' => $request->unit_kerja,
                'keterangan' => $request->keterangan,
                'basis' => $request->basis,
                'tanggal' => $request->tanggal
            ]);

            foreach ($request->kode_akun as $key => $value) {
                if ($request->kegiatan_id[$key]){
                    $rincian = [
                        'jurnal_penyesuaian_id' => $jurnalPenyesuaian->id,
                        'kegiatan_id' => $request->kegiatan_id[$key],
                        'kode_akun' => $request->kode_akun[$key],
                        'debet' => parse_format_number($request->debet[$key]),
                        'kredit' => parse_format_number($request->kredit[$key]),
                    ];
                }else {
                    $rincian = [
                        'jurnal_penyesuaian_id' => $jurnalPenyesuaian->id,
                        'kode_akun' => $request->kode_akun[$key],
                        'debet' => parse_format_number($request->debet[$key]),
                        'kredit' => parse_format_number($request->kredit[$key]),
                    ];
                }
                $jurnalPenyesuaianRincian = $this->jurnalPenyesuaianRincian->create($rincian);
                if (! $jurnalPenyesuaianRincian) {
                    throw new \Exception("Error create jurnal penyesuaian");
                }

            }

            DB::commit();
            return response()->json(['status' => 'oke', 'saldo_awal' => $jurnalPenyesuaian], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'data' => $e->getMessage()
            ], 400);
        }
    }

    public function update(JurnalPenyesuaianRequest $request, $id)
    {
        try{
            DB::beginTransaction();

            $updateJurnalPenyesuaian = $this->jurnalPenyesuaian->update([
                'kode_unit_kerja' => $request->unit_kerja,
                'keterangan' => $request->keterangan,
                'basis' => $request->basis,
                'tanggal' => $request->tanggal
            ], $id);

            if (! $updateJurnalPenyesuaian) {
                throw new Exception("Error update jurnal penyesuaian");
            }

            $deletedRincian = $this->jurnalPenyesuaianRincian->deleteAll($id);

            if (! $deletedRincian){
                throw new Exception("Error delete rincian");
                
            }

            foreach ($request->kode_akun as $key => $value) {
                if ($request->kegiatan_id[$key]) {
                    $rincian = [
                        'jurnal_penyesuaian_id' => $id,
                        'kegiatan_id' => $request->kegiatan_id[$key],
                        'kode_akun' => $request->kode_akun[$key],
                        'debet' => parse_format_number($request->debet[$key]),
                        'kredit' => parse_format_number($request->kredit[$key]),
                    ];
                } else {
                    $rincian = [
                        'jurnal_penyesuaian_id' => $id,
                        'kode_akun' => $request->kode_akun[$key],
                        'debet' => parse_format_number($request->debet[$key]),
                        'kredit' => parse_format_number($request->kredit[$key]),
                    ];
                }
                $jurnalPenyesuaianRincian = $this->jurnalPenyesuaianRincian->create($rincian);
                if (!$jurnalPenyesuaianRincian) {
                    throw new \Exception("Error update jurnal penyesuaian");
                }
            }

            DB::commit();
            return response()->json(['status' => 'oke', 'saldo_awal' => $updateJurnalPenyesuaian], 200);
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()
                ->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Destroy spesific resource
     *
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request)
    {
        try {
            $jurnalPenyesuaian = $this->jurnalPenyesuaian->find($request->id);

            if (!$jurnalPenyesuaian){
                throw new Exception("Data not found");
            }

            $deleteRincian = $this->jurnalPenyesuaianRincian->deleteAll($request->id);
            
            $jurnalPenyesuaian->delete();

            return redirect()->back()
                ->with(['success' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with(['error' => $e->getMessage()]);
        }
    }

    public function getAkun(Request $request)
    {
        $unitKerja = $request->unit_kerja;
        $allAkun = [];
        if ($request->jenis == 'kas'){
            $whereKas = function ($query) {
                $query->where('tipe', 0)
                    ->orWhere('tipe', 6);
            };
            $akun = $this->akun->get(['*'], $whereKas);

            $whereRba1 = function ($query) use($unitKerja){
                $query->where('kode_unit_kerja', $unitKerja)
                    ->where('kode_rba', Rba::KODE_RBA_1);
            };

            $whereRba2 = function ($query) use ($unitKerja) {
                $query->where('kode_unit_kerja', $unitKerja)
                    ->where('kode_rba', Rba::KODE_RBA_221);
            };
            
            $akunRba = [];
            $rba1 = $this->rba->get(['*'], $whereRba1, ['rincianSumberDana.akun']);
            $this->rba->makeModel();
            $rba2 = $this->rba->get(['*'], $whereRba2, ['rincianSumberDana.akun', 'mapKegiatan.blud']);

            foreach ($akun as $item){
                $allAkun[] = [
                    'kode_akun' => $item->kode_akun,
                    'nama_akun' => $item->nama_akun,
                    'kode_kegiatan' => '',
                    'nama_kegiatan' => '',
                    'is_parent' => $item->is_parent,
                    'kegiatan_id' => '',
                ];
            }

            foreach($rba1 as $rba){
                $rba->rincianSumberDana->map(function ($item) use(&$akunRba){
                    $akunRba[] =  [
                        'kode_akun' => $item->akun->kode_akun,
                        'nama_akun' => $item->akun->nama_akun,
                        'kode_kegiatan' => '',
                        'nama_kegiatan' => '',
                        'is_parent' => $item->akun->is_parent,
                        'kegiatan_id' => '',
                    ];
                });
            }

            foreach ($rba2 as $dataRba) {
                $kodeKegiatan = $dataRba->mapKegiatan->blud->kode_program .'.'. $dataRba->mapKegiatan->blud->kode_bidang .'.'. $dataRba->mapKegiatan->blud->kode;
                $namaKegiatan = $dataRba->mapKegiatan->blud->nama_kegiatan;
                $kegiatanId = $dataRba->mapKegiatan->blud->id;
                $dataRba->rincianSumberDana->map(function ($item) use (&$akunRba, $kodeKegiatan, $namaKegiatan, $kegiatanId) {
                    $akunRba[] =  [
                        'kode_akun' => $item->akun->kode_akun,
                        'nama_akun' => $item->akun->nama_akun,
                        'kode_kegiatan' => $kodeKegiatan,
                        'nama_kegiatan' => $namaKegiatan,
                        'is_parent' => $item->akun->is_parent,
                        'kegiatan_id' => $kegiatanId,
                    ];
                });
            }

            $kodeParent = [];
            foreach ($akunRba as $kode) {
                $explode = explode('.', $kode['kode_akun']);
                $parents = $this->akun->getAkunParent($explode[0], $explode[1], $explode[2], $explode[3])->pluck('kode_akun')->toArray();
                foreach ($parents as $akunParent) {
                    array_push($kodeParent, $akunParent);
                }
            }

            $whereParent = function ($query) use($kodeParent) {
                $query->whereIn('kode_akun', $kodeParent);
            };
            $this->akun->makeModel();
            $akunParent = $this->akun->get(['*'], $whereParent);

            foreach ($akunParent as $parent) {
                $akunRba[] = [
                    'kode_akun' => $parent->kode_akun,
                    'nama_akun' => $parent->nama_akun,
                    'kode_kegiatan' => '',
                    'nama_kegiatan' => '',
                    'is_parent' => $parent->is_parent,
                    'kegiatan_id' => '',
                ];
            }

            $akunRba = collect($akunRba);
            $akunRba = $akunRba->sortBy('kode_akun')->values()->all();

            foreach ($akunRba as $itemAkunRba) {
                $allAkun[] = [
                    'kode_akun' => $itemAkunRba['kode_akun'],
                    'nama_akun' => $itemAkunRba['nama_akun'],
                    'kode_kegiatan' => $itemAkunRba['kode_kegiatan'],
                    'nama_kegiatan' => $itemAkunRba['nama_kegiatan'],
                    'is_parent' => $itemAkunRba['is_parent'],
                    'kegiatan_id' => $itemAkunRba['kegiatan_id']
                ];
            }

        }else{
            $whereKas = function ($query) {
                $query->where('tipe', 1)
                    ->orWhere('tipe', 2)
                    ->orWhere('tipe', 3)
                    ->orWhere('tipe', 8)
                    ->orWhere('tipe', 9);
            };
            $akun = $this->akun->get(['*'], $whereKas);

            foreach ($akun as $item) {
                $allAkun[] = [
                    'kode_akun' => $item->kode_akun,
                    'nama_akun' => $item->nama_akun,
                    'kode_kegiatan' => '',
                    'nama_kegiatan' => '',
                    'is_parent' => $item->is_parent,
                    'kegiatan_id' => '',
                ];
            }
        }

        $response = is_array($allAkun) ? collect($allAkun)->unique('kode_akun')->sortBy('kode_akun')->values()->all() : $allAkun;

        return response()->json([
            'data' => $response,
            'success' => true,
        ], 200);
    }
}

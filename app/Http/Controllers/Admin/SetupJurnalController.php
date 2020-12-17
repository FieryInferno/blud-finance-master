<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Akutansi\SetupJurnalRequest;
use App\Repositories\Akutansi\SetupJurnalAnggaranRepository;
use App\Repositories\Akutansi\SetupJurnalFinansialRepository;
use App\Repositories\Akutansi\SetupJurnalRepository;
use App\Repositories\Organisasi\MapAkunFinanceRepository;
use App\Repositories\Organisasi\RekeningBendaharaRepository;
use Illuminate\Support\Facades\DB;

class SetupJurnalController extends Controller
{
    /**
     * MapAkunFinanceRepository
     *
     * @var MapAkunFinanceRepository
     */
    private $mapAkunFinance;

    /**
     * SetupJurnalRepository
     *
     * @var SetupJurnalRepository
     */
    private $setupJurnal;

    /**
     * SetupJurnalAnggaranRepository
     *
     * @var SetupJurnalAnggaranRepository
     */
    private $setupJurnalAnggaran;

    /**
     * SetupJurnalFinansialRepository
     *
     * @var SetupJurnalFinansialRepository
     */
    private $setupJurnalFinansial;

    /**
     * RekeningBendaharaRepository
     *
     * @var RekeningBendaharaRepository
     */
    private $rekeningBendahara;

    function __construct(
        MapAkunFinanceRepository $mapAkunFinance,
        SetupJurnalRepository $setupJurnal,
        SetupJurnalAnggaranRepository $setupJurnalAnggaran,
        SetupJurnalFinansialRepository $setupJurnalFinansial,
        RekeningBendaharaRepository $rekeningBendahara
    )
    {
        $this->mapAkunFinance = $mapAkunFinance;
        $this->setupJurnal = $setupJurnal;
        $this->setupJurnalAnggaran = $setupJurnalAnggaran;
        $this->setupJurnalFinansial = $setupJurnalFinansial;
        $this->rekeningBendahara = $rekeningBendahara;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function index()
    {
        $setupJurnal = $this->setupJurnal->get(['*']);
        return view('admin.setup_jurnal.index', compact('setupJurnal'));
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function create()
    {
        $formulir = [
            'sts',
            'sp2d',
            'setor pajak',
            'kontrapos',
        ];

        $nominal = [
            'nominal rincian',
            'nominal kotor',
            'nominal pfk',
            'nominal pajak'
        ];

        $elemen = [
            'kode_akun',
            'akun1',
            'akun2',
            'akun3',
            'rekening_bendahara',
            'rekening_bendahara1',
            'rekening_bendahara2',
            'rekening_bendahara3'
        ];

        return view('admin.setup_jurnal.create', compact('formulir', 'nominal', 'elemen'));
    }

    /**
     * Undocumented function
     *
     * @param SetupJurnalRequest $request
     * @return void
     */
    public function store(SetupJurnalRequest $request)
    {
        try {
            DB::beginTransaction();
            $setupJurnal = $this->setupJurnal->create([
                'kode_jurnal' => $request->kode_jurnal,
                'formulir' => $request->formulir,
                'keterangan' => $request->keterangan,
            ]);

            if (! $setupJurnal){
                throw new \Exception('Create setup jurnal gagal');
            }

            if (isset($request->rincian_anggaran)){
                foreach ($request->rincian_anggaran as $key => $value) {
                    if (! is_null($request->rincian_anggaran[$key])){
                        $jurnalAnggaran = $this->setupJurnalAnggaran->create([
                            'setup_jurnal_id' => $setupJurnal->id,
                            'elemen_anggaran' => $request->rincian_anggaran[$key],
                            'jenis_anggaran' => $request->jenis_anggaran[$key],
                            'nominal_anggaran' => $request->nominal_anggaran[$key]
                        ]);

                        if (! $jurnalAnggaran){
                            throw new \Exception('Create setup jurnal anggaran gagal');
                        }
                    }
                }
            }

            if (isset($request->rincian_finansial)){
                foreach ($request->rincian_finansial as $key => $value) {
                    if (! is_null($request->jenis_finansial[$key])){
                        
                        $jurnalFinansial = $this->setupJurnalFinansial->create([
                            'setup_jurnal_id' => $setupJurnal->id,
                            'elemen_finansial' => $request->rincian_finansial[$key],
                            'jenis_finansial' => $request->jenis_finansial[$key],
                            'nominal_finansial' => $request->nominal_finansial[$key]
                        ]);

                        if (! $jurnalFinansial){
                            throw new \Exception('Create setup jurnal finansial gagal');
                        }
                    }
                }
            }

            DB::commit();
            return response()->json(['status' => 'oke', 'setup_jurnal' => $setupJurnal], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'data' => $e->getMessage()
            ], 400);
        }
    }

    public function edit($id)
    {
        $setupJurnal = $this->setupJurnal->find($id, ['*'], ['anggaran', 'finansial']);

        $formulir = [
            'sts',
            'sp2d',
            'setor pajak',
            'kontrapos',
        ];

        $nominal = [
            'nominal rincian',
            'nominal kotor',
            'nominal pfk',
            'nominal pajak'
        ];

        $elemen = [
            'kode_akun',
            'akun1',
            'akun2',
            'akun3',
            'rekening_bendahara',
            'rekening_bendahara1',
            'rekening_bendahara2',
            'rekening_bendahara3'
        ];

        return view('admin.setup_jurnal.edit', compact('setupJurnal', 'elemen', 'formulir', 'nominal'));
    }

    /**
     * Update spesific resource
     *
     * @param SetupJurnalRequest $request
     * @param [type] $id
     * @return void
     */
    public function update(SetupJurnalRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $setupJurnal = $this->setupJurnal->update([
                'kode_jurnal' => $request->kode_jurnal,
                'formulir' => $request->formulir,
                'keterangan' => $request->keterangan,
            ], $id);

            $this->setupJurnalAnggaran->deleteAll($id);
            $this->setupJurnalFinansial->deleteAll($id);

            if (isset($request->rincian_anggaran)){
                foreach ($request->rincian_anggaran as $key => $value) {
                    if (! is_null($request->rincian_anggaran[$key])){
                        $jurnalAnggaran = $this->setupJurnalAnggaran->create([
                            'setup_jurnal_id' => $id,
                            'elemen_anggaran' => $request->rincian_anggaran[$key],
                            'jenis_anggaran' => $request->jenis_anggaran[$key],
                            'nominal_anggaran' => $request->nominal_anggaran[$key]
                        ]);

                        if (! $jurnalAnggaran){
                            throw new \Exception('Create setup jurnal anggaran gagal');
                        }
                    }
                }
            }

            if (isset($request->rincian_finansial)){
                foreach ($request->rincian_finansial as $key => $value) {
                    if (! is_null($request->jenis_finansial[$key])){
                        
                        $jurnalFinansial = $this->setupJurnalFinansial->create([
                            'setup_jurnal_id' => $id,
                            'elemen_finansial' => $request->rincian_finansial[$key],
                            'jenis_finansial' => $request->jenis_finansial[$key],
                            'nominal_finansial' => $request->nominal_finansial[$key]
                        ]);

                        if (! $jurnalFinansial){
                            throw new \Exception('Create setup jurnal finansial gagal');
                        }
                    }
                }
            }


            DB::commit();
            return response()->json(['status' => 'oke', 'setup_jurnal' => $setupJurnal], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'data' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Delete specific resource
     *
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request)
    {
        try {
            $setupJurnal = $this->setupJurnal->find($request->id);

            if (!$setupJurnal) {
                throw new \Exception('Data tidak ditemukan');
            }

            $this->setupJurnalAnggaran->deleteAll($setupJurnal->id);
            $this->setupJurnalFinansial->deleteAll($setupJurnal->id);


            $setupJurnal->delete();

            return redirect()->back()
                ->with(['success' => 'Data berhasil dihapus']);

        } catch (\Exception $e) {
            return redirect()->back()
                ->with(['error' => $e->getMessage()]);
        }
    }
}

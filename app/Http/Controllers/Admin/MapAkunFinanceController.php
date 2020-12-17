<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\DataDasar\AkunRepository;
use App\Http\Requests\DataDasar\MapAkunFinanceRequest;
use App\Repositories\Organisasi\MapAkunFinanceRepository;

class MapAkunFinanceController extends Controller
{
     /**
     * Bidang repository.
     * 
     * @var AkunRepository
     */
    private $akun;

     /**
     * Map akun repository.
     * 
     * @var MapAkunFinanceRepository
     */
    private $mapAkun;

    /**
     * Constructor.
     */
    public function __construct(
        AkunRepository $akun,
        MapAkunFinanceRepository $mapAkun
    ) {
        $this->akun = $akun;
        $this->mapAkun = $mapAkun;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $where = function ($query) {
            $query->where('is_parent', false)
                ->whereIn('tipe', [1, 2, 3, 4, 5, 6]);
        };
        $akun = $this->akun->get(['*'], $where)->sortBy('kode_akun');
        $akun = $akun->values()->all();
        $this->akun->makeModel();

        $where = function ($query) {
            $query->where('is_parent', false);
        };
        $allAkun = $this->akun->get(['*'], $where)->sortBy('kode_akun');
        $allAkun = $allAkun->values()->all();

        $mapAkun = $this->mapAkun->get(['*'], null, ['akun', 'akun1', 'akun2', 'akun3']);
        return view('admin.map_akun_finance.index', compact('akun', 'allAkun', 'mapAkun')); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MapAkunFinanceRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(MapAkunFinanceRequest $request)
    {
        $mapAkun = $this->mapAkun->create([
            'kode_akun' => $request->kode_akun,
            'kode_akun_1' => $request->kode_akun_1,
            'kode_akun_2' => $request->kode_akun_2,
            'kode_akun_3' => $request->kode_akun_3,
        ]);
        return redirect()->back()
                ->with(['success' => 'Pemetaan akun berhasil disimpan']);
    }
   
    /**
     * Update the specified resource in storage.
     *
     * @param MapAkunFinanceRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(MapAkunFinanceRequest $request)
    {
        $mapAkun = $this->mapAkun->update([
            'kode_akun' => $request->kode_akun,
            'kode_akun_1' => $request->kode_akun_1,
            'kode_akun_2' => $request->kode_akun_2,
            'kode_akun_3' => $request->kode_akun_3,
        ], $request->id);
        return redirect()->back()
                ->with(['success' => 'Pemetaan akun berhasil diperbarui']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->mapAkun->delete($request->id);
        return redirect()->back()
                ->with(['success' => 'Data berhasil dihapus']);
    }
}

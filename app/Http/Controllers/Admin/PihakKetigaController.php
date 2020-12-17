<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DataDasar\PihakKetigaRequest;
use App\Repositories\Organisasi\UnitKerjaRepository;
use App\Repositories\DataDasar\PihakKetigaRepository;

class PihakKetigaController extends Controller
{
    /**
     * Pihak ketiga.
     *
     * @var PihakKetigaRepository
     */
    private $pihak;

    /**
     * Unit Kerja.
     *
     * @var UnitKerjaRepository
     */
    private $unitKerja;

    /**
     * Undocumented function
     */
    public function __construct(
        PihakKetigaRepository $pihak,
        UnitKerjaRepository $unitKerja
    ) {
        $this->pihak = $pihak;
        $this->unitKerja = $unitKerja;
    }

    /**
     * Pihak ketiga pages.
     *
     * @return void
     */
    public function index(Request $request)
    {
        if (auth()->user()->hasRole('Admin')) {
            $unitKerja = $this->unitKerja->get();
        } else {
            $unitKerja = $this->unitKerja->get(['*'], function ($query) {
                $query->where('kode', auth()->user()->kode_unit_kerja);
            });
            
        }

        $where = function ($query) use ($request) {
            if (!auth()->user()->hasRole('Admin')) {
                $query->where('kode_unit_kerja', auth()->user()->kode_unit_kerja);
            }

            if ($request->unit_kerja) {
                $query->where('kode_unit_kerja', $request->unit_kerja);
            }

        };

        $pihak = $this->pihak->get(['*'], $where ,['unitKerja']);


        return view('admin.pihak_ketiga.index', compact('unitKerja', 'pihak'));
    }

    /**
     * Store.
     *
     * @return void
     */
    public function store(PihakKetigaRequest $request)
    {
        $this->pihak->create($request->all());
        return redirect()->back()
                ->with(['success' => "Pihak ketiga berhasil disimpan"]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PihakKetigaRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(PihakKetigaRequest $request)
    {
        $data = $request->except('_token', '_method');
        $this->pihak->update($data, $request->id);
        return redirect()->back()
                ->with(['success' => 'Data berhasil diperbarui']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->pihak->delete($request->id);
        return redirect()->back()
                ->with(['success' => 'Data berhasil dihapus']);
    }

    /**
     * Get pihak ketiga data
     *
     * @return void
     */
    public function getData(Request $request)
    {
        $unitKerja = $request->unit_kerja;

        $where = function ($query) use($unitKerja){
            $query->where('kode_unit_kerja', $unitKerja);
        };
        $pihakKetiga = $this->pihak->get(['*'], $where);

        $respose = [
            'data' => $pihakKetiga
        ];

        return response()->json($respose, 200);
    }

    /**
     * Get detail data of pihak ketiga
     *
     * @param Request $request
     * @return void
     */
    public function getDetailData(Request $request)
    {
        $pihakKetiga = $this->pihak->find($request->id);

        $respose = [
            'data' => $pihakKetiga
        ];

        return response()->json($respose, 200);
    }
}

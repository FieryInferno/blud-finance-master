<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\DataDasar\AkunRepository;
use App\Repositories\Organisasi\UnitKerjaRepository;
use App\Http\Requests\Organisasi\RekeningBendaharaRequest;
use App\Models\RekeningBendahara;
use App\Repositories\Organisasi\RekeningBendaharaRepository;

class RekeningBendaharaController extends Controller
{
    /**
     * Rekening Bendahara repository.
     * 
     * @var RekeningBendaharaRepository
     */
    private $rekeningBendahara;

    /**
     * Akun repository.
     * 
     * @var AkunRepository
     */
    private $akun;

    /**
     * Unit kerja repository.
     * 
     * @var UnitKerjaRepository
     */
    private $unitKerja;

    /**
     * Constructor.
     */
    public function __construct(
        RekeningBendaharaRepository $rekeningBendahara,
        AkunRepository $akun,
        UnitKerjaRepository $unitKerja
    ) {
        $this->rekeningBendahara = $rekeningBendahara;
        $this->akun = $akun;
        $this->unitKerja = $unitKerja;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bendahara = $this->rekeningBendahara->get(['*'], null, ['akun', 'unitKerja']);

        $whereAkun = function ($query) {
            $query->where('is_parent', false);
        };
        $akun       = $this->akun->get(['*'], $whereAkun);
        $akun       = collect($akun);
        // $sortedAkun = $akun->sortBy(['tipe', 'kelompok', 'jenis', 'objek', 'rincian', 'sub1']);
        $sortedAkun = $akun->sortBy('kode_akun');
        // dd($sortedAkun);
        $unitKerja  = $this->unitKerja->get();
        return view('admin.rekening_bendahara.index', compact('bendahara', 'sortedAkun', 'unitKerja'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RekeningBendaharaRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RekeningBendaharaRequest $request)
    {
        $bendahara = $this->rekeningBendahara->create($request->all());
        return redirect()->back()
                ->with(['success' => "{$bendahara->nama_akun_bendahara} berhasil disimpan"]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RekeningBendaharaRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(RekeningBendaharaRequest $request)
    {
        $data = $request->only(['jenis', 'nama_akun_bendahara', 'kode_akun', 'kode_unit_kerja', 'nama_bank', 'rekening_bank']);
        $this->rekeningBendahara->update($data, $request->id);
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
        $this->rekeningBendahara->delete($request->id);
        return redirect()->back()
                ->with(['success' => 'Data berhasil dihapus']);
    }


    /**
     * Get rekening bendahara
     *
     * @param Request $request
     * @return void
     */
    public function getData(Request $request)
    {
        $whereRekening = function ($query) use($request){
            $query->where('kode_unit_kerja', $request->unit_kerja);
            if ($request->jenis)
                $query->where('jenis', $request->jenis);
        };

        $rekening = $this->rekeningBendahara->get(['*'], $whereRekening);
        return $rekening;
    }
}

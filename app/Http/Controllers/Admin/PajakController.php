<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DataDasar\PajakRequest;
use App\Repositories\DataDasar\AkunRepository;
use App\Repositories\DataDasar\PajakRepository;

class PajakController extends Controller
{
     /**
     * Akun repository.
     * 
     * @var AkunRepository
     */
    private $akun;

     /**
     * Urusan repository.
     * 
     * @var PajakRepository
     */
    private $pejabat;

    /**
     * Constructor.
     */
    public function __construct(
        AkunRepository $akun,
        PajakRepository $pajak
    ) {
        $this->akun = $akun;
        $this->pajak = $pajak;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $whereAkun = function ($query) {
            $query->where('tipe', 2)
                ->where('is_parent', 0);
        };
        $akun = $this->akun->get(['*'], $whereAkun);
        $pajak = $this->pajak->get();
        return view('admin.pajak.index', compact('akun', 'pajak'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PajakRequest $request)
    {
        $pajak = $this->pajak->create($request->only(['kode_pajak', 'nama_pajak', 'akun_id', 'persen']));
        return redirect()->back()
                ->with(['success' => "{$pajak->nama_pajak} berhasil disimpan"]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PajakRequest $request)
    {
        $this->pajak->update($request->only(['kode_pajak', 'nama_pajak', 'akun_id', 'persen']), $request->id);
        return redirect()->back()
                ->with(['success' => 'Data berhasil diperbarui']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->pajak->delete($request->id);
        return redirect()->back()
                ->with(['success' => 'Data berhasil dihapus']);
    }
}

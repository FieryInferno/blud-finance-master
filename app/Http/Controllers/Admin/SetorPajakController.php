<?php

namespace App\Http\Controllers\Admin;

use App\Models\PrefixPenomoran;
use App\Http\Controllers\Controller;
use App\Repositories\Belanja\SetorPajakPajakRepository;
use App\Repositories\PrefixPenomoranRepository;
use App\Repositories\Belanja\SetorPajakRepository;
use App\Repositories\BKU\BKURincianRepository;
use App\Repositories\DataDasar\PajakRepository;
use App\Repositories\Organisasi\UnitKerjaRepository;
use Symfony\Component\HttpFoundation\Request;

class SetorPajakController extends Controller
{
    /**
     * SetorPajak Repository
     * 
     * @var SetorPajakRepository
     */
    private $setorPajak;


    /**
     * Prefix Penomoran Repository
     * 
     * @var PrefixPenomoranRepository
     */
    private $prefixPenomoran;

    /**
     * PAJAK Repository
     * 
     * @var PajakRepository
     */
    private $pajak;

    /**
     * SetorPajakPajakRepository
     *
     * @var SetorPajakPajakRepository
     */
    private $setorPajakPajak;

    /**
     * Bku rincian repository.
     * 
     * @var BKURincianRepository
     */
    private $bkuRincian;

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
        SetorPajakRepository $setorPajak,
        PajakRepository $pajak,
        SetorPajakPajakRepository $setorPajakPajak,
        BKURincianRepository $bkuRincian,
        UnitKerjaRepository $unitKerja
    ) {
        $this->setorPajak = $setorPajak;
        $this->prefixPenomoran = $prefixPenomoran;
        $this->pajak = $pajak;
        $this->setorPajakPajak = $setorPajakPajak;
        $this->bkuRincian = $bkuRincian;
        $this->unitKerja = $unitKerja;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $unitKerja = $this->unitKerja->get();
        $prefixPajak = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_SETORAN_PAJAK);
        $prefixPenomoranPajak = explode('/', $prefixPajak->format_penomoran);
        $this->prefixPenomoran->makeModel();
        $prefixSpp = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_SPP);
        $prefixPenomoranSpp = explode('/', $prefixSpp->format_penomoran);

        if (auth()->user()->hasRole('Admin')) {
            $setorPajak = $this->setorPajakPajak->getAllSetorPajak($request);
        } else {
            $setorPajak = $this->setorPajakPajak->getAllSetorPajak($request, auth()->user()->kode_unit_kerja);
        }

        $setorPajak->map(function ($item) use($prefixPenomoranPajak, $prefixPenomoranSpp){
            $nomorPajak = nomor_fix($prefixPenomoranPajak, $item->nomor, $item->setorPajak->kode_unit_kerja);
            $item->nomorfix = $nomorPajak;

            if ($item->setorPajak->spp->nomor_otomatis){
                $nomorSpp = nomor_fix($prefixPenomoranSpp, $item->setorPajak->spp->nomor, $item->setorPajak->spp->kode_unit_kerja);
                $item->setorPajak->spp->nomorspp = $nomorSpp;
            }else {
                $item->setorPajak->spp->nomorspp = $item->setorPajak->spp->nomor;
            }
        });
        return view('admin.setor_pajak.index', compact('setorPajak', 'unitKerja'));
    }

    /**
     * Get detail Setor pajak
     *
     * @param [type] $id
     * @return void
     */
    public function show($id)
    {
        $prefix = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_SETORAN_PAJAK);
        $prefixPenomoran = explode('/', $prefix->format_penomoran);
        $setorPajak = $this->setorPajakPajak->find($id, ['*'], [
            'setorPajak.bast.kegiatan', 'setorPajak.bendaharaPengeluaran', 'setorPajak.unitKerja', 'setorPajak.pejabatPptk',
            'setorPajak.pejabatPemimpinBlud', 'setorPajak.rekeningBendahara'
        ]);
        $nomorFix = nomor_fix($prefixPenomoran, $setorPajak->nomor, $setorPajak->kode_unit_kerja);
        $setorPajak->nomorfix = $nomorFix;
        
        $bills = [];
        foreach($setorPajak->setorPajak->referensiPajak as $key => $item) {
            $pajakId = $item->pajak->id;

            $i = 1;
            foreach($item->noBilling as $billing) {
                $bills["billing[{$pajakId}][{$i}]"] = $billing->no_billing;
                $i++;
            }
        }

        return view('admin.setor_pajak.show', compact('setorPajak', 'bills'));
    }

    /**
     * Update setor pajak data
     *
     * @return void
     */
    public function update(Request $request)
    {
        try {
            $this->setorPajakPajak->update([
                'ntpn' => $request->ntpn,
                'npwp' => $request->npwp
            ], $request->id);

            return redirect()->back()
                ->with(['success' => 'Data spp berhasil di verifikasi ']);
        }catch (\Exception $e){
            return redirect()->back()
                ->with(['errors' => 'Data spp berhasil di verifikasi ']);
        }
    }

    public function getData(Request $request)
    {
        try {
            $whereBkuRincian = function ($query) {
                $query->whereNotNull('setor_pajak_pajak_id');
            };
            $bkuRincian = $this->bkuRincian->get(['*'], $whereBkuRincian);

            $setorPajakPajakId = $bkuRincian->pluck('setor_pajak_pajak_id')->unique();

            $prefixPajak = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_SETORAN_PAJAK);
            $prefixPenomoranPajak = explode('/', $prefixPajak->format_penomoran);
            $this->prefixPenomoran->makeModel();
            $prefixSpp = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_SPP);
            $prefixPenomoranSpp = explode('/', $prefixSpp->format_penomoran);

            $setorPajak = $this->setorPajakPajak->getAllSetorPajak($request, $request->kode_unit_kerja, $setorPajakPajakId);

            $setorPajak->map(function ($item) use ($prefixPenomoranPajak, $prefixPenomoranSpp) {
                $nomorPajak = nomor_fix($prefixPenomoranPajak, $item->nomor, $item->setorPajak->kode_unit_kerja);
                $item->nomorfix = $nomorPajak;

                if ($item->setorPajak->spp->nomor_otomatis) {
                    $nomorSpp = nomor_fix($prefixPenomoranSpp, $item->setorPajak->spp->nomor, $item->setorPajak->spp->kode_unit_kerja);
                    $item->setorPajak->spp->nomorspp = $nomorSpp;
                } else {
                    $item->setorPajak->spp->nomorspp = $item->setorPajak->spp->nomor;
                }
            });

            $response = [
                'data' => $setorPajak
            ];

            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => $e->getCode(),
                'data' => $e->getMessage(),
            ]);
        }
    }

    public function getDataPajakPotongan(Request $request)
    {
        try {
            $whereBkuRincian = function ($query) {
                $query->whereNotNull('setor_pajak_pajak_id');
            };
            $bkuRincian = $this->bkuRincian->get(['*'], $whereBkuRincian);

            $setorPajakPajakId = $bkuRincian->pluck('setor_pajak_pajak_id')->unique();

            $prefixPajak = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_SETORAN_PAJAK);
            $prefixPenomoranPajak = explode('/', $prefixPajak->format_penomoran);
            $this->prefixPenomoran->makeModel();
            $prefixSpp = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_SPP);
            $prefixPenomoranSpp = explode('/', $prefixSpp->format_penomoran);

            $setorPajak = $this->setorPajakPajak->getAllSetorPajakPotongan($request, $request->kode_unit_kerja, $setorPajakPajakId);

            $setorPajak->map(function ($item) use ($prefixPenomoranPajak, $prefixPenomoranSpp) {
                $nomorPajak = nomor_fix($prefixPenomoranPajak, $item->nomor, $item->setorPajak->kode_unit_kerja);
                $item->nomorfix = $nomorPajak;

                if ($item->setorPajak->spp->nomor_otomatis) {
                    $nomorSpp = nomor_fix($prefixPenomoranSpp, $item->setorPajak->spp->nomor, $item->setorPajak->spp->kode_unit_kerja);
                    $item->setorPajak->spp->nomorspp = $nomorSpp;
                } else {
                    $item->setorPajak->spp->nomorspp = $item->setorPajak->spp->nomor;
                }
            });

            $response = [
                'data' => $setorPajak
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

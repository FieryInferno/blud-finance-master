<?php

namespace App\Http\Controllers\Admin;

use App\Models\PrefixPenomoran;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repositories\Belanja\SPPRepository;
use App\Repositories\Belanja\SP2DRepository;
use App\Repositories\PrefixPenomoranRepository;
use App\Repositories\Belanja\SP2DPajakRepository;
use App\Http\Requests\Belanja\VerifikasiSppRequest;
use App\Repositories\Belanja\SetorPajakPajakNoBillingRepository;
use App\Repositories\Belanja\SetorPajakPajakRepository;
use App\Repositories\Belanja\SetorPajakRepository;
use App\Repositories\Belanja\Sp2dPajakNoBillingRepository;
use App\Repositories\BKU\BKURepository;
use App\Repositories\BKU\BKURincianRepository;
use App\Repositories\Organisasi\UnitKerjaRepository;
use Symfony\Component\HttpFoundation\Request;

class VerifikasiSPPController extends Controller
{

    /**
     * SPP Repository
     * 
     * @var SPPRepository
     */
    private $spp;

    /**
     * SP2D Repository
     * 
     * @var SP2DRepository
     */
    private $sp2d;

    /**
     * SP2D Pajak Repository
     * 
     * @var SP2DPajakRepository
     */
    private $sp2dPajak;

    /**
     * Setor Pajak Repository
     * 
     * @var SetorPajakRepository
     */
    private $setorPajak;

    /**
     * SP2D Pajak Repository
     * 
     * @var SetorPajakPajakRepository
     */
    private $setorPajakPajak;
 
    /**
     * PAJAK Repository
     * 
     * @var PrefixPenomoranRepository
     */
    private $prefixPenomoran;

    /**
     * Bku Repository
     *
     * @var BKURepository
     */
    private $bku;
    
    /**
     * BKU Rincian Repository
     * 
     * @var BkuRincianRepository
     */
    private $bkuRincian;

    /**
     * Unit Kerja repository
     * 
     * @var UnitKerjaRepository
     */
    private $unitKerja;

    /**
     * Unit Kerja repository
     * 
     * @var UnitKerjaRepository
     */
    private $sp2dPajakNoBilling;

    /**
     * Unit Kerja repository
     * 
     * @var UnitKerjaRepository
     */
    private $setorPajakPajakNoBilling;

    /**
     * Constructor.
     */
    public function __construct(
        SPPRepository $spp,
        PrefixPenomoranRepository $prefixPenomoran,
        SP2DRepository $sp2d,
        SP2DPajakRepository $sp2dPajak,
        SetorPajakRepository $setorPajak,
        SetorPajakPajakRepository $setorPajakPajak,
        BKURepository $bku,
        BKURincianRepository $bkuRincian,
        UnitKerjaRepository $unitKerja,
        Sp2dPajakNoBillingRepository $sp2dPajakNoBilling,
        SetorPajakPajakNoBillingRepository $setorPajakPajakNoBilling
    ) {
        $this->spp = $spp;
        $this->prefixPenomoran = $prefixPenomoran;
        $this->sp2d = $sp2d;
        $this->sp2dPajak = $sp2dPajak;
        $this->setorPajak = $setorPajak;
        $this->setorPajakPajak = $setorPajakPajak;
        $this->bkuRincian = $bkuRincian;
        $this->bku = $bku;
        $this->unitKerja = $unitKerja;
        $this->sp2dPajakNoBilling = $sp2dPajakNoBilling;
        $this->setorPajakPajakNoBilling = $setorPajakPajakNoBilling;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $prefix = $this->prefixPenomoran->findBy('formulir', '=', PrefixPenomoran::FORMULIR_SPP);

        $unitKerja = $this->unitKerja->get();

        $where = function ($query) use ($request) {
            if (!auth()->user()->hasRole('Admin')) {
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
        
        $spp = $this->spp->get(['*'], $where, ['unitKerja', 'bast.kegiatan']);

        $prefixPenomoran = explode('/', $prefix->format_penomoran);
        $spp->map(function ($item) use ($prefixPenomoran) {
            if ($item->nomor_otomatis) {
                $nomorFix = nomor_fix($prefixPenomoran, $item->nomor, $item->kode_unit_kerja);
                $item->nomorfix = $nomorFix;
            } else {
                $item->nomorfix = $item->nomor;
            }
        });
        
        return view('admin.verifikasi_spp.index', compact('spp', 'unitKerja'));
    }

    /**
     * Update status
     *
     * @return void
     */
    public function update(VerifikasiSppRequest $request)
    {
        try {
            DB::beginTransaction();
            $spp = $this->spp->find($request->id, ['*'], ['referensiPajak', 'referensiPajak.noBilling']);
            
            if (!$spp) {
                throw new \Exception('Gagal verifikasi spp');
            }

            $spp->update([
                'is_verified' => true,
                'date_verified' => $request->tanggal,
                // 'no_billing' => $request->no_billing,
                'is_verified' => $request->status_verifikasi
            ]);

            if ($request->status_verifikasi == 1){
                $sp2d = $this->sp2d->create([
                    'nomor' => $spp->nomor,
                    'nomor_otomatis' => $spp->nomor_otomatis,
                    'spp_id' => $spp->id,
                    'tanggal' => $spp->tanggal,
                    'kode_unit_kerja' => $spp->kode_unit_kerja,
                    'bast_id' => $spp->bast_id,
                    'sisa_spd_total' => $spp->sisa_spd_total,
                    'sisa_spd_kegiatan' => $spp->sisa_spd_kegiatan,
                    'sisa_kas' => $spp->sisa_kas,
                    'sisa_pagu_pengajuan' => $spp->sisa_pagu_pengajuan,
                    'keterangan' => $spp->keterangan,
                    'pihak_ketiga_id' => $spp->pihak_ketiga_id,
                    'bendahara_pengeluaran' => $spp->bendahara_pengeluaran,
                    'pptk' => $spp->pptk,
                    'akun_bendahara' => $spp->akun_bendahara,
                    'pemimpin_blud' => $spp->pemimpin_blud,
                    'nominal_sumber_dana' => $spp->nominal_sumber_dana
                ]);

                if (!$sp2d) {
                    throw new \Exception('Error create sp2d');
                }

                foreach ($spp->referensiPajak as $item) {
                    $sp2dPajak = $this->sp2dPajak->create([
                        'sp2d_id' => $sp2d->id,
                        'pajak_id' => $item->pajak_id,
                        'nominal' => $item->nominal,
                        'is_information' => $item->is_information
                    ]);

                    if (!$sp2dPajak) {
                        throw new \Exception('Error create sp2d pajak');
                    }
                    
                    foreach($item->noBilling as $bill) {
                        $attributes = [
                            'sp2d_pajak_id' => $sp2dPajak->id,
                            'no_billing' => $bill->no_billing
                        ];

                        $createSp2dBilling = $this->sp2dPajakNoBilling->create($attributes);

                        if( ! $createSp2dBilling) {
                            throw new \Exception('Error create sp2d pajak no billing');
                        }
                    }
                }

                $nomorPajak = $this->setorPajakPajak->getLastNomor($spp->kode_unit_kerja);
                $setorPajak = $this->setorPajak->create([
                    'nomor' => $spp->nomor,
                    'nomor_otomatis' => $spp->nomor_otomatis,
                    'tanggal' => $spp->tanggal,
                    'spp_id' => $spp->id,
                    'kode_unit_kerja' => $spp->kode_unit_kerja,
                    'bast_id' => $spp->bast_id,
                    'sisa_spd_total' => $spp->sisa_spd_total,
                    'sisa_spd_kegiatan' => $spp->sisa_spd_kegiatan,
                    'sisa_kas' => $spp->sisa_kas,
                    'sisa_pagu_pengajuan' => $spp->sisa_pagu_pengajuan,
                    'keterangan' => $spp->keterangan,
                    'pihak_ketiga_id' => $spp->pihak_ketiga_id,
                    'bendahara_pengeluaran' => $spp->bendahara_pengeluaran,
                    'pptk' => $spp->pptk,
                    'akun_bendahara' => $spp->akun_bendahara,
                    'pemimpin_blud' => $spp->pemimpin_blud,
                    'nominal_sumber_dana' => $spp->nominal_sumber_dana
                ]);

                if (!$setorPajak) {
                    throw new \Exception('Error create setor pajak');
                }

                foreach ($spp->referensiPajak as $key => $item) {
                    $setorPajakPajak = $this->setorPajakPajak->create([
                        'nomor' => $nomorPajak+$key,
                        'setor_pajak_id' => $setorPajak->id,
                        'pajak_id' => $item->pajak_id,
                        'nominal' => $item->nominal,
                        'is_information' => $item->is_information
                    ]);

                    if (!$setorPajakPajak) {
                        throw new \Exception('Error create setor pajak');
                    }

                    foreach($item->noBilling as $bill) {
                        $attributes = [
                            'setor_pajak_pajak_id' => $setorPajakPajak->id,
                            'no_billing' => $bill->no_billing
                        ];

                        $createSetorPajakBilling = $this->setorPajakPajakNoBilling->create($attributes);

                        if( ! $createSetorPajakBilling) {
                            throw new \Exception('Error create setor pajak, pajak no billing');
                        }
                    }
                }
                
            }else {
                $where = function ($query) use($spp) {
                    $query->where('spp_id', $spp->id);
                };

                
                $allSp2d = $this->sp2d->get(['*'], $where);
                $allSetorPajak = $this->setorPajak->get(['*'], $where);

                // get all sp2d id
                $sp2dId = $allSp2d->pluck('id')->unique();

                $whereBkuRincian = function ($query) use($sp2dId){
                    $query->whereIn('sp2d_id', $sp2dId);
                };
                $rincianBku = $this->bkuRincian->get(['*'], $whereBkuRincian);
                $rincianBkuId = $rincianBku->pluck('id');
                $bkuId = $rincianBku->pluck('bku_id')->unique();

                if ($bkuId->count() > 0){
                    $this->bku->deleteAll($bkuId);
                    $this->bkuRincian->deleteMany($rincianBkuId);
                }

                if ($sp2dId->count() > 0){ 
                    $this->sp2dPajak->deleteAll($sp2dId);
                    $this->sp2d->deleteAll($sp2dId);
                }

                $setorPajakId = $allSetorPajak->pluck('id')->unique();

                if ($setorPajakId->count() > 0){
                    $this->setorPajakPajak->deleteAll($setorPajakId);
                    $this->setorPajak->deleteAll($setorPajakId);
                }

            }
            

            DB::commit();
            if ($request->status_verifikasi == 0){
                return redirect()->back()
                    ->with(['success' => 'Verifikasi spp berhasil dibatalkan ']);
            }else {
                    return redirect()->back()
                        ->with(['success' => 'Verifikasi spp berhasil ']);
            }
        }catch (\Exception $e){
            DB::rollback();
            dd($e);
            return redirect()->back()
                ->with(['success' => 'Tidak dapat dibatalkan, Data sudah berada di bku !']);
        }
    }

}

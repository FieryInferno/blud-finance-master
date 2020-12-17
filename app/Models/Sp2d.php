<?php

namespace App\Models;

use App\Models\Bast;
use App\Models\UnitKerja;
use Illuminate\Database\Eloquent\Model;

class Sp2d extends Model
{
    protected $table = 'sp2d';

    protected $guarded = [];

    /**
     * Relation to unit kerja
     *
     * @return void
     */
    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class, 'kode_unit_kerja', 'kode');
    }

    /**
     * Relation to bast
     *
     * @return void
     */
    public function bast()
    {
        return $this->belongsTo(Bast::class);
    }

    /**
     * Relation to sp2d pajak
     *
     * @return void
     */
    public function referensiPajak()
    {
        return $this->hasMany(Sp2dPajak::class);
    }

    /**
     * Relation to bendahara pengeluaran
     *
     * @return void
     */
    public function bendaharaPengeluaran()
    {
        return $this->belongsTo(PejabatUnit::class, 'bendahara_pengeluaran', 'id');
    }

    /**
     * Relation to pptk
     *
     * @return void
     */
    public function pejabatPptk()
    {
        return $this->belongsTo(PejabatUnit::class, 'pptk', 'id');
    }

    /**
     * Relation to pemimpin blud
     *
     * @return void
     */
    public function pejabatPemimpinBlud()
    {
        return $this->belongsTo(PejabatUnit::class, 'pemimpin_blud', 'id');
    }

    /**
     * Relation to rekening bendahara
     *
     * @return void
     */
    public function rekeningBendahara()
    {
        return $this->belongsTo(RekeningBendahara::class, 'akun_bendahara', 'id');
    }

    /**
     * Relation to bku rincian
     */
    public function bkuRincian()
    {
        return $this->hasOne(BkuRincian::class);
    }

    /**
     * Relation to pajak
     */
    public function sp2dPajak()
    {
        return $this->hasMany(Sp2dPajak::class);
    }
}

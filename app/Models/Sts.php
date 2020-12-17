<?php

namespace App\Models;

use App\Models\UnitKerja;
use App\Models\StsRincian;
use App\Models\PejabatUnit;
use App\Models\StsSumberDana;
use App\Models\RekeningBendahara;
use Illuminate\Database\Eloquent\Model;

class Sts extends Model
{
    protected $table = 'sts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nomor', 'tanggal', 'kode_unit_kerja', 'keterangan', 'rekening_bendahara_id', 'kepala_skpd',
        'bendahara_penerima', 'nomor_otomatis', 'nl'
    ];

    /**
     * relation to unit kerja
     *
     * @return void
     */
    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class, 'kode_unit_kerja', 'kode');
    }

    /**
     * relation to rekening bendahara
     *
     * @return void
     */
    public function rekeningBendahara()
    {
        return $this->belongsTo(RekeningBendahara::class);
    }

    /**
     * Relation to rincian
     *
     * @return void
     */
    public function rincianSts()
    {
        return $this->hasMany(StsRincian::class);
    }

    /**
     * Relation to sumber dana
     *
     * @return void
     */
    public function sumberDanaSts()
    {
        return $this->hasMany(StsSumberDana::class);
    }

    /**
     * Relation to bkuRincian
     */
    public function bkuRincian()
    {
        return $this->hasOne(BkuRincian::class, 'sts_id');
    }

    /**
     * Relation to pejabat unit
     *
     * @return void
     */
    public function kepalaSkpd()
    {
        return $this->belongsTo(PejabatUnit::class, 'kepala_skpd', 'id');
    }

    /**
     * Relation to pejabat unit
     *
     * @return void
     */
    public function bendaharaPenerima()
    {
        return $this->belongsTo(PejabatUnit::class, 'bendahara_penerima', 'id');
    }
}

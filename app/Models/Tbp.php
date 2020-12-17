<?php

namespace App\Models;

use App\Models\UnitKerja;
use App\Models\TbpRincian;
use App\Models\RekeningBendahara;
use Illuminate\Database\Eloquent\Model;

class Tbp extends Model
{
    protected $table = 'tbp';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nomor', 'tanggal', 'kode_unit_kerja', 'keterangan', 'rekening_bendahara_id', 'kepala_skpd',
        'bendahara_penerima', 'nomor_otomatis'
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
    public function rincianTbp()
    {
        return $this->hasMany(TbpRincian::class);
    }

    /**
     * Relation to sumber dana
     *
     * @return void
     */
    public function sumberDanaTbp()
    {
        return $this->hasMany(TbpSumberDana::class);
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

<?php

namespace App\Models;

use App\Models\SpdRincian;
use App\Models\PejabatUnit;
use Illuminate\Database\Eloquent\Model;

class Spd extends Model
{
    protected $table = 'spd';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nomor', 'nomor_otomatis', 'tanggal', 'triwulan', 'bulan_awal', 'bulan_akhir', 'kode_unit_kerja',
        'keterangan', 'sisa_spd', 'bendahara_pengeluaran', 'kuasa_bud', 'nomor_dpa'
    ];

    /**
     * Relation to spd rincian
     *
     * @return void
     */
    public function spdRincian()
    {
        return $this->hasMany(SpdRincian::class);
    }

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
     * Relation to unit kerja
     *
     * @return void
     */
    public function bendaharaPengeluaran()
    {
        return $this->belongsTo(PejabatUnit::class, 'bendahara_pengeluaran', 'id');
    }

    /**
     * Relation to unit kerja
     *
     * @return void
     */
    public function kuasaBud()
    {
        return $this->belongsTo(PejabatUnit::class, 'kuasa_bud', 'id');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sp3b extends Model
{
    protected $table = 'sp3b';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Relation to bendahara penerimaan
     */
    public function bendaharaPenerimaan()
    {
        return $this->belongsTo(RekeningBendahara::class, 'bendahara_penerimaan');
    }
    
    /**
     * Relation to bendahara pengeluaran
     */
    public function bendaharaPengeluaran()
    {
        return $this->belongsTo(RekeningBendahara::class, 'bendahara_pengeluaran');
    }

    /**
     * Relation to unit kerja
     */
    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class, 'kode_unit_kerja', 'kode');
    }

    /**
     * Relation to pejabat unit
     */
    public function pejabatUnit()
    {
        return $this->belongsTo(pejabatUnit::class, 'pejabat_unit');
    }

    /**
     * Relation to sp3b rincian
     */
    public function sp3bRincian()
    {
        return $this->hasMany(Sp3bRincian::class);
    }
}
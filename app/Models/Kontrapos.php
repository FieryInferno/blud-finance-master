<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kontrapos extends Model
{
    protected $table = 'kontrapos';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
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
     * Relation to kontrapos rincian
     * 
     * @return void
     */
    public function kontraposRincian()
    {
        return $this->hasMany(KontraposRincian::class);
    }

    /**
     * relation to rekening bendahara
     *
     * @return void
     */
    public function rekeningBendahara()
    {
        return $this->belongsTo(RekeningBendahara::class, 'rekening_bendahara');
    }
}

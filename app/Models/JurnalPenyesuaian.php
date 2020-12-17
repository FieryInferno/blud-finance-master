<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JurnalPenyesuaian extends Model
{
    protected $table = 'jurnal_penyesuaian';

    const KAS = 'kas';
    const AKTUAL = 'aktual';

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
     * relation to jurnal penyesuaian rincian
     *
     * @return void
     */
    public function jurnalPenyesuaianRincian()
    {
        return $this->hasMany(jurnalPenyesuaianRincian::class);
    }

}

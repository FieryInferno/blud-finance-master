<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaldoAwal extends Model
{
    protected $table = 'saldo_awal';

    const LO = 'lo';
    const NERACA = 'neraca';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class, 'kode_unit_kerja', 'kode');
    }

    public function saldoAwalRincian()
    {
        return $this->hasMany(SaldoAwalRincian::class);
    }

}

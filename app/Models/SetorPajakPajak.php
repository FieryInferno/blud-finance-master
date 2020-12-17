<?php

namespace App\Models;


use App\Models\Pajak;
use Illuminate\Database\Eloquent\Model;

class SetorPajakPajak extends Model
{
    protected $table = 'setor_pajak_pajak';

    protected $guarded = [];

    /**
     * Relation to pajak
     *
     * @return void
     */
    public function pajak()
    {
        return $this->belongsTo(Pajak::class);
    }

    /**
     * Relation to setor pajak
     *
     * @return void
     */
    public function setorPajak()
    {
        return $this->belongsTo(SetorPajak::class);
    }

    /**
     * Relation to bku rincian
     * 
     * @return void
     */
    public function bkuRincian()
    {
        return $this->hasOne(BkuRincian::class);
    }

    /**
     * Relation to no billing
     *
     * @return void
     */
    public function noBilling()
    {
        return $this->hasMany(SetorPajakNoBilling::class);
    }
}

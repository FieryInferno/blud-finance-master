<?php

namespace App\Models;


use App\Models\Pajak;
use Illuminate\Database\Eloquent\Model;

class SppPajak extends Model
{
    protected $table = 'spp_pajak';

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
     * Relation to no billing
     *
     * @return void
     */
    public function noBilling()
    {
        return $this->hasMany(SppPajakNoBilling::class);
    }
}

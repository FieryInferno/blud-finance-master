<?php

namespace App\Models;

use App\Models\Spd;
use Illuminate\Database\Eloquent\Model;

class SppReferensiSpd extends Model
{
    protected $table = 'spp_referensi_spd';

    protected $guarded = [];

    /**
     * relation to spd
     *
     * @return void
     */
    public function spd()
    {
        return $this->belongsTo(Spd::class);
    }
}

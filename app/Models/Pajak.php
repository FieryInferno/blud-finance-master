<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pajak extends Model
{
    protected $table = 'pajak';

    protected $guarded = [];

    public function akun()
    {
        return $this->belongsTo(Akun::class, 'akun_id', 'id');
    }
}

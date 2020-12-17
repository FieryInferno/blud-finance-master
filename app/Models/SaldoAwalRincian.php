<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaldoAwalRincian extends Model
{
    protected $table = 'saldo_awal_rincian';


    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Relation to akun
     *
     * @return void
     */
    public function akun()
    {
        return $this->belongsTo(Akun::class, 'akun_id');
    }

    /**
     * relation to saldo awal
     *
     * @return void
     */
    public function saldoAwal()
    {
        return $this->belongsTo(SaldoAwal::class, 'saldo_awal_id');
    }

}

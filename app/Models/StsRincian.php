<?php

namespace App\Models;

use App\Models\Akun;
use Illuminate\Database\Eloquent\Model;

class StsRincian extends Model
{
    protected $table = 'sts_rincian';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sts_id', 'kode_akun', 'nominal'
    ];

    /**
     * relation to akun
     *
     * @return void
     */
    public function akun()
    {
        return $this->belongsTo(Akun::class, 'kode_akun', 'kode_akun');
    }

    public function sts()
    {
        return $this->belongsTo(Sts::class);
    }
}

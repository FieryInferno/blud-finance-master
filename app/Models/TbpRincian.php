<?php

namespace App\Models;

use App\Models\Akun;
use Illuminate\Database\Eloquent\Model;

class TbpRincian extends Model
{
    protected $table = 'tbp_rincian';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tbp_id', 'kode_akun', 'nominal'
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

    /**
     * relation to tbp
     *
     * @return void
     */
    public function tbp()
    {
        return $this->belongsTo(Tbp::class);
    }
}

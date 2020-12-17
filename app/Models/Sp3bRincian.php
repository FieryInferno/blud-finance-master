<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sp3bRincian extends Model
{
    protected $table = 'sp3b_rincian';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Relation to akun
     */
    public function akun()
    {
        return $this->belongsTo(Akun::class, 'kode_akun', 'kode_akun');
    }

    /**
     * Relation to akun
     */
    public function akunApbd()
    {
        return $this->belongsTo(Akun::class, 'kode_akun_apbd', 'kode_akun');
    }

    /**
     * Relation to kegiatan
     */
    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id', 'id');
    }
    
    /**
     * Relation to kegiatan
     */
    public function kegiatanApbd()
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id_apbd', 'id');
    }
}
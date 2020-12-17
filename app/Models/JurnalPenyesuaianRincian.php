<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JurnalPenyesuaianRincian extends Model
{
    protected $table = 'jurnal_penyesuaian_rincian';


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
        return $this->belongsTo(Akun::class, 'kode_akun', 'kode_akun');
    }

    /**
     * relation to saldo awal
     *
     * @return void
     */
    public function jurnalPenyesuaian()
    {
        return $this->belongsTo(JurnalPenyesuaian::class);
    }

    /**
     * Relation to kegiatan
     *
     * @return void
     */
    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class);
    }

}

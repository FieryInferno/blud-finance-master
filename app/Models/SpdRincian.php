<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpdRincian extends Model
{
    protected $table = 'spd_rincian';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'spd_id', 'kode_kegiatan', 'nama_kegiatan', 'anggaran', 'spd_sebelumnya', 'nominal', 'total_spd'
    ];

    /**
     * Relation to kegiatan
     *
     * @return void
     */
    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'kode_kegiatan', 'kode');
    }

}

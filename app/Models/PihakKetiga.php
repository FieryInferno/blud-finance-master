<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PihakKetiga extends Model
{
    protected $table = 'pihak_ketiga';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kode', 'kode_unit_kerja', 'nama', 'nama_perusahaan', 'alamat', 'nama_bank', 'no_rekening', 'npwp'
    ];

    /**
     * Relation to unit kerja.
     *
     * @return void
     */
    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class, 'kode_unit_kerja', 'kode');
    }
}

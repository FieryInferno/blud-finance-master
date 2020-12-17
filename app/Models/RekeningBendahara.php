<?php

namespace App\Models;

use App\Models\Akun;
use Illuminate\Database\Eloquent\Model;

class RekeningBendahara extends Model
{
    protected $table = 'rekening_bendahara';

    const PENDAPATAN = 'pendapatan';
    const PENERIMAAN = 'penerimaan';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'jenis', 'nama_akun_bendahara', 'kode_akun', 'kode_unit_kerja', 'nama_bank', 'rekening_bank'
    ];

    /**
     * Get nama bank
     *
     * @param string $value
     * @return void
     */
    public function getNamaBankAttribute($value)
    {
        return ucwords($value);
    }

    /**
     * Get jenis
     *
     * @param string $value
     * @return void
     */
    public function getJenisAttribute($value)
    {
        return ucwords($value);
    }

    /**
     * Get nama akun bendahara
     *
     * @param string $value
     * @return void
     */
    public function getNamaAkunBendaharaAttribute($value)
    {
        return ucwords($value);
    }

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
     * relation to unit kerja
     *
     * @return void
     */
    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class, 'kode_unit_kerja', 'kode');
    }
}

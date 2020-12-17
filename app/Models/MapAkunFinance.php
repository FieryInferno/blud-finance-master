<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MapAkunFinance extends Model
{
    protected $table = 'map_akun_finance';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kode_akun', 'kode_akun_1', 'kode_akun_2', 'kode_akun_3',
    ];

    /**
     * Relation to akun
     *
     */
    public function akun()
    {
        return $this->belongsTo('App\Models\Akun', 'kode_akun', 'kode_akun');
    }

    /**
     * Relation to akun
     *
     */
    public function akun1()
    {
        return $this->belongsTo('App\Models\Akun', 'kode_akun_1', 'kode_akun');
    }

    /**
     * Relation to akun
     *
     */
    public function akun2()
    {
        return $this->belongsTo('App\Models\Akun', 'kode_akun_2', 'kode_akun');
    }

    /**
     * Relation to akun
     *
     */
    public function akun3()
    {
        return $this->belongsTo('App\Models\Akun', 'kode_akun_3', 'kode_akun');
    }
}

<?php

namespace App\Models;

use App\Models\SumberDana;
use App\Models\TbpRincian;
use Illuminate\Database\Eloquent\Model;

class TbpSumberDana extends Model
{
    protected $table = 'tbp_sumber_dana';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tbp_id', 'kode_akun', 'sumber_dana_id', 'nominal'
    ];

    /**
     * relation to tbp rincian
     *
     * @return void
     */
    public function tbpRincian()
    {
        return $this->belongsTo(TbpRincian::class);
    }

    /**
     * relation to sumber dana
     *
     * @return void
     */
    public function sumberDana()
    {
        return $this->belongsTo(SumberDana::class);
    }
}

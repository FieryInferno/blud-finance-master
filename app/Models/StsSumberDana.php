<?php

namespace App\Models;

use App\Models\SumberDana;
use Illuminate\Database\Eloquent\Model;

class StsSumberDana extends Model
{
    protected $table = 'sts_sumber_dana';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sts_id', 'kode_akun', 'sumber_dana_id', 'nominal'
    ];

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

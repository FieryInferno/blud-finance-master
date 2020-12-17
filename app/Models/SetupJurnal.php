<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SetupJurnal extends Model
{
    protected $table = 'setup_jurnal';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Relation to jurnal anggaran 
     *
     * @return void
     */
    public function anggaran()
    {
        return $this->hasMany(SetupJurnalAnggaran::class);
    }

    /**
     * Relation to jurnal finansial
     *
     * @return void
     */
    public function finansial()
    {
        return $this->hasMany(SetupJurnalFinansial::class);
    }

}

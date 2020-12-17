<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    /**
     * Admin role id.
     * 
     * @var int
     */
    public const ROLE_ADMIN = 'Admin';

    /**
     * Puskesmas role id.
     * 
     * @var int
     */
    public const ROLE_PUSKESMAS = 'Puskesmas';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'role_name'
    ];
}

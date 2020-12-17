<?php

namespace App\Repositories\Penerimaan;

use App\Models\StsSumberDana;
use App\Repositories\Repository;

class STSSumberDanaRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return StsSumberDana::class;
    }

    /**
     * Delete all tbp sumber dana
     *
     * @param [type] $tbpId
     * @return void
     */
    public function deleteAll($tbpId)
    {
        return StsSumberDana::where('sts_id', $tbpId)->delete();
    }
}

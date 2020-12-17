<?php

namespace App\Repositories\Penerimaan;

use App\Models\TbpSumberDana;
use App\Repositories\Repository;

class TBPSumberDanaRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return TbpSumberDana::class;
    }

    /**
     * Delete all tbp sumber dana
     *
     * @param [type] $tbpId
     * @return void
     */
    public function deleteAll($tbpId)
    {
        return TbpSumberDana::where('tbp_id', $tbpId)->delete();
    }
}

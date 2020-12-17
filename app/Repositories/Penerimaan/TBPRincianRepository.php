<?php

namespace App\Repositories\Penerimaan;

use App\Repositories\Repository;
use App\Models\TbpRincian;

class TBPRincianRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return TbpRincian::class;
    }

    /**
     * Delete all rincian tbp
     *
     * @param [type] $tbpId
     * @return void
     */
    public function deleteAll($tbpId)
    {
        return TbpRincian::where('tbp_id', $tbpId)->delete();
    }
}

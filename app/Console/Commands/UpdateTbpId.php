<?php

namespace App\Console\Commands;

use App\Models\Sts;
use App\Models\Tbp;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateTbpId extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:tbp_id';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update tbp in on sts';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $sts = Sts::where('nl', false)->get();

        foreach ($sts as $value) {
            $tbp = Tbp::where('kode_unit_kerja', $value->kode_unit_kerja)
                ->where('keterangan', $value->keterangan)
                ->first();

                if ($tbp){
                    $value->tbp_id = $tbp->id;
                    $value->save();
                }
                
            $this->info('Sts with id '. $value->id . 'has been updated');    
        }
    }
}

<?php

namespace App\Console\Commands;

use App\Models\Bast;
use App\Models\MapKegiatan;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateKegiatanIdBast extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:kegiatan_id';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update kegiatan_id on bast';

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
        $bast = Bast::whereNull('kegiatan_id')->get();
        foreach ($bast as $value) {
            $mapKegiatan = MapKegiatan::where('kode_unit_kerja', $value->kode_unit_kerja)
                ->whereHas('blud', function ($query) use($value) {
                    $query->where('kode', $value->kode_kegiatan);
                })
                ->first();

            $value->kegiatan_id = $mapKegiatan->kegiatan_id_blud;
            $value->save();
        }

    }
}

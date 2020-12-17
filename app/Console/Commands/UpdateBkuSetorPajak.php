<?php

namespace App\Console\Commands;

use App\Models\Bku;
use Illuminate\Console\Command;

class UpdateBkuSetorPajak extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:bku';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $bku = Bku::with(['bkuRincian.setorPajak'])->get();

        foreach ($bku as $item){
            foreach ($item->bkuRincian as $pajak) {
                if ($pajak->setorPajak){
                    $pajak->penerimaan = $pajak->pengeluaran;
                    $pajak->save();
                    $this->info('Pajak ' . $pajak->id . 'has been updated');    
                }
            }
        }
    }
}

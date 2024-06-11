<?php

namespace App\Console\Commands\Mtg\Cron;

use Illuminate\Console\Command;
use App\Services\Admin\MTG\importCsvCollection;
use Illuminate\Support\Facades\Log;

class ImportUserCollectionCsv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mtg:import-user-collection-csv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(importCsvCollection $service)
    {
        Log::info('MTG-Cron: Csv init...');
        $service->import();
        Log::info('MTG-Cron: Csv terminate...');
    }
}

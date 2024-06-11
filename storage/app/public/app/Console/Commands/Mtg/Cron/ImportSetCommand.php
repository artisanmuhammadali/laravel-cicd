<?php

namespace App\Console\Commands\Mtg\Cron;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Services\Admin\MTG\importSets;

class ImportSetCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mtg:import-set-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(importSets $importSets)
    {

        Log::info('MTG-Cron: Set import initiated...');
        $importSets->sets();
        Log::info('MTG-Cron: set import Terminated...');
        return true;
    }
}

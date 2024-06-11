<?php

namespace App\Console\Commands\Mtg\Cron;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Services\Admin\MTG\importCards;

class ImportCardCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mtg:import-card-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(importCards $importCards)
    {
        Log::info('MTG-Cron: Cards import initiated...');
        $importCards->cards();
        Log::info('MTG-Cron: Cars import Terminated...');
        return true;
    }
}

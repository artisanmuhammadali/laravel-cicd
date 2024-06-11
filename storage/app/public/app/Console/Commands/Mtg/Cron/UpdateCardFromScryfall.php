<?php

namespace App\Console\Commands\Mtg\Cron;

use App\Services\Admin\MTG\UpdateCards;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateCardFromScryfall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mtg:update-card-from-scryfall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(UpdateCards $service)
    {
        Log::info('MTG-Cron: Card updation initiated...');
        $service->update();
        Log::info('MTG-Cron: Card updation Terminated...');
        return true;
    }
}

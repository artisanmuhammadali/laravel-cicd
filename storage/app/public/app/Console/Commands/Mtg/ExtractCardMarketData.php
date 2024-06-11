<?php

namespace App\Console\Commands\Mtg;

use App\Models\MTG\CardMarketData;
use Illuminate\Console\Command;

class ExtractCardMarketData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mtg:extract-card-market-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $path = public_path('cardMarket/export-Magic-08-03-2024.csv');
        $file = fopen($path, 'r');
        while (($line = fgetcsv($file)) !== false) {
            $this->importData($line);
        }
        fclose($file);
    }
    public function importData($data)
    {
        if($data[0] != "cardmarketId")
        {
            $market = new CardMarketData();
            $market->name = $data[1] ?? null;
            $market->set_name = $data[4] ?? null;
            $market->set_code = $data[5] ?? null;
            $market->scryfall_id = $data[6] ?? null;
            $market->card_market_id = $data[0] ?? null;
            $market->collector_no = $data[2] ?? null;
            $market->tcgplayer_id = $data[7] ?? null;
            $market->save();
            return $market;
        }
    }
}

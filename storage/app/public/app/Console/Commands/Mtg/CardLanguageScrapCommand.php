<?php

namespace App\Console\Commands\Mtg;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CardLanguageScrapCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mtg:language-scrap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrap languages from scryfall website';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cards = DB::table('mtg_cards')->where('card_type','single')
                        ->where('languages', '[]')
                        ->get(['id','name','collector_number', 'set_code']);



        foreach($cards as $card)
        {


            $card_name_url = 'https://scryfall.com/card/'
                                                        .'/'.$card->set_code
                                                        .'/'.$card->collector_number
                                                        .'/'.Str::Slug($card->name);



        $lang = [];
            $crawler = \Goutte::request('GET', $card_name_url);

            $crawler->filter('.print-langs a')->each(function ($node) {

                array_push($lang, $node->text());

            });

            dd($lang);

        }
        dd('Languages Scrap successfully!');
    }
}

<?php

namespace App\Console\Commands\Mtg;

use App\Models\MTG\MtgCard;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class ImportCardIds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mtg:import-card-ids';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'import mtg cards cardmarket_id , tcgplayer_id from scryfall';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cards = MtgCard::where('card_type','single')->where('mtgo_id',null)->pluck('card_id')->toArray();
        foreach($cards as $card_id)
        {
            $url = 'https://api.scryfall.com/cards/'.$card_id;
            $this->apiCall($url , $card_id);
        }
        return "done";
    }
    public function apiCall($url , $card_id)
    {
        try{
            $client = new Client();
            $response = $client->get($url);
            $response = json_decode($response->getBody()->getContents(), true);
            $card = (object)$response;
            MtgCard::where('card_id',$card_id)->update([
                'mtgo_id'=>$card->mtgo_id ?? null,
                'cardmarket_id'=>$card->cardmarket_id ?? null,
                'tcgplayer_id'=>$card->tcgplayer_id ?? null
            ]);
        }
        catch(Exception $e)
        {
            
        }
        return true;
    }
}

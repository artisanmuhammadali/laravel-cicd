<?php

namespace App\Console\Commands\Mtg;

use App\Models\MTG\MtgCard;
use Illuminate\Console\Command;
use GuzzleHttp\Client;

class CardBorderColorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mtg:card-border-color';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'import card border color from scryfall';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cards = MtgCard::where('card_type','single')->where('border_color',null)->pluck('card_id')->toArray();
        foreach($cards as $card_id)
        {
            $url = 'https://api.scryfall.com/cards/'.$card_id;
            $this->apiCall($url , $card_id);
        }
        return "done";
    }
    public function apiCall($url , $card_id)
    {
        $client = new Client();
        $response = $client->get($url);
        $response = json_decode($response->getBody()->getContents(), true);
        $card = (object)$response;
        if($card->border_color)
        {
            MtgCard::where('card_id',$card_id)->update(['border_color'=>$card->border_color]);
        }
        return true;
    }
}

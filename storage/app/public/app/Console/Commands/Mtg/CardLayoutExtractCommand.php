<?php

namespace App\Console\Commands\Mtg;

use App\Models\MTG\MtgCard;
use App\Models\MTG\MtgCardImage;
use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class CardLayoutExtractCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mtg:card-layout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Extract all cards layout from scryfall';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $card_ids = DB::table('mtg_card_images')->where('value',null)->pluck('mtg_card_id')->toArray();
        $cards = DB::table('mtg_cards')->whereIn('id',$card_ids)->get(['id','card_id']);
        foreach($cards as $card)
        {
            $this->api($card);
        }
        return "done";
    }
    public function api($card)
    {
        $url = 'https://api.scryfall.com/cards/'.$card->card_id;
        $client = new Client();
        $response = $client->get($url);
        $response = json_decode($response->getBody()->getContents(), true);
        if(array_key_exists('card_faces' ,$response))
        {
            foreach($response['card_faces'] as $face)
            {
                if(array_key_exists('image_uris' ,$face))
                {
                    $this->createCardImages($card->id, $face);
                }
            }
        }
        // $item = MtgCard::find($card->id);
        // $item->layout           = $response['layout']  ?? null;
        // $item->save();
        return true;
    }
    public function createCardImages($card_id, $data)
    {
        $images[] = ['mtg_card_id' => $card_id, 'key' => 'png', 'value' => $data['image_uris']['png'] ?? null ];

        MtgCardImage::where('mtg_card_id',$card_id)->update($images);

        return true;
    }
}

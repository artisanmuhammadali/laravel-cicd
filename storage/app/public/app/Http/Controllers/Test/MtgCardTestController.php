<?php

namespace App\Http\Controllers\Test;

use GuzzleHttp\Client;
use App\Models\MTG\MtgSet;
use App\Models\MTG\MtgCard;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\MTG\MtgCardFace;
use App\Models\MTG\MtgCardImage;
use App\Models\MTG\MtgUserCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class MtgCardTestController extends Controller
{
    public function importCards()
    {

        #SET TIME LIMIT OF PHP
        set_time_limit(0);
        // MtgSet::where('imported_at', '!=', null)->update(['imported_at' => null]);

        $set = MtgSet::where('card_count', '>', 1000)
                       ->where('imported_at', null)
                       ->first(['id', 'code', 'imported_at']);

        if(!$set) return 'done... no more sets remains';

        #API CALLL
        $this->getSetCards('https://api.scryfall.com/cards/search?q=set:"'.$set->code.'"&unique=prints');


        #UPDATE SETS IMPORTED AT COLUMN
        $set->update(['imported_at' => now()]);

        #RETURN TO GET NEW SET CODE
        return redirect()->route('import.cards');


    }

    public function getSetCards($url)
    {


        $client = new Client();
        $response = $client->get($url);
        $response = json_decode($response->getBody()->getContents(), true);



        if(count($response['data']) > 0)
        {
            foreach ($response['data'] as $key => $item)
            {
                if($item['digital'] == false)
                {
                    $this->saveCard($item);
                }
            }

            Log::info('loop no');

        }

        if($response['has_more'] == true)
        {
            $this->getSetCards($response['next_page']);
        }



        Log::info($url);

        return true;

    }

    public function saveCard($item)
    {

         // Log::info($item['id']);
        $card = new MtgCard();


        #CREATE SLUG OF CARD
        $slug  = Str::slug($item['name']."-".$item['collector_number']);

        $card->card_id          = $item['id'] ?? null;
        $card->oracle_id        = $item['oracle_id'] ?? null;
        $card->name             = $item['name']  ?? null;
        $card->collector_number = $item['collector_number']  ?? null;
        $card->slug             = $slug;
        $card->set_code         = $item['set']  ?? null;
        $card->released_at      = $item['released_at']  ?? null;
        $card->cmc              = $item['cmc']  ?? null;
        $card->foil             = $item['foil']  ?? null;
        $card->nonfoil          = $item['nonfoil']  ?? null;
        $card->oversized        = $item['oversized']  ?? null;
        $card->rarity           = $item['rarity']  ?? null;
        $card->frame            = $item['frame'] ?? null;
        $card->highres_image    = $item['highres_image']  ?? null;

        $card->legalities       = array_key_exists('legalities', $item) ? json_encode($item['legalities']) : null;
        $card->finishes         = array_key_exists('finishes', $item) ? json_encode($item['finishes']) : null;
        $card->frame_effects    = array_key_exists('frame_effects', $item) ? json_encode($item['frame_effects']) : null;
        $card->promo_types      = array_key_exists('promo_types', $item) ? json_encode($item['promo_types']) : null;

        $card->save();

        #CARD FACED
        if(array_key_exists('card_faces', $item))
        {
            $faced = true;

            $check_image_uri = array_key_exists('image_uris', $item['card_faces']) ? true : false;

            foreach ($item['card_faces'] as $key => $face)
            {
                $this->createCardFace($card->id, $face);
                if($check_image_uri)
                {
                    $this->createCardImages($card->id, $face);
                }
                else
                {
                    $this->createCardImages($card->id, $item);
                }
            }

        }
        else
        {
            $this->createCardFace($card->id, $item);
            $this->createCardImages($card->id, $item);
        }



        #SAVE CARD SECOND TIME
        $card->is_card_faced = $faced ?? false;
        $card->save();

        return true;
    }


    public function createCardFace($card_id, $data)
    {
        MtgCardFace::create([
            'mtg_card_id'  => $card_id,
            'mana_cost'    => $data['mana_cost'] ?? null,
            'oracle_text'  => $data['oracle_text'] ?? null,
            'type_line'    => $data['type_line'] ?? null,
            'power'        => $data['power'] ?? null,
            'toughness'    => $data['toughness'] ?? null,
            'artist'       => $data['artist'] ?? null,
            'colors'       => array_key_exists('colors', $data) ? json_encode($data['colors']) : null
        ]);

        return true;
    }


    public function createCardImages($card_id, $data)
    {
        $images[] = ['mtg_card_id' => $card_id, 'key' => 'png', 'value' => $data['image_uris']['png'] ?? null ];
        $images[] = ['mtg_card_id' => $card_id, 'key' => 'art_crop', 'value' => $data['image_uris']['art_crop'] ?? null ];
        $images[] = ['mtg_card_id' => $card_id, 'key' => 'border_crop', 'value' => $data['image_uris']['border_crop'] ?? null ];
        // dd($images);
        MtgCardImage::insert($images);

        return true;
    }

    public function updateCards()
    {
        set_time_limit(0);
        $q =  MtgCard::withCount('images')->whereHas('images', function ($query) {
                $query->groupBy('mtg_card_id')
                  ->havingRaw('COUNT(*) = 3 OR COUNT(*) = 6');
        })->pluck('card_id')->toArray();
        
        // $q =  MtgCard::withCount('faces')->whereHas('faces', function ($query) {
        //         $query->groupBy('mtg_card_id')
        //       ->havingRaw('COUNT(*) > 2');
        //     })->get();
            dd($q);
        foreach($q as $id)
        {
            $url = "https://api.scryfall.com/cards/".$id;
            // dd($url);
            $this->getSingleCard($url , $id);
            
        }
        return "ok";
    }
    public function getSingleCard($url ,$id)
    {
        $client = new Client();
        $response = $client->get($url);
        $item = json_decode($response->getBody()->getContents(), true);

        $card = MtgCard::where('card_id',$id)->first();
        $images = $this->deleteCardImages($card->id);
        #CARD FACED
        if(array_key_exists('card_faces', $item))
        {
            $check_image_uri = array_key_exists('image_uris', $item['card_faces'][0]) ? true : false;

            foreach ($item['card_faces'] as $key => $face)
            {   
                if($check_image_uri)
                {
                    $this->createCardImages($card->id, $face);
                }
                else
                {
                    $this->createCardImages($card->id, $item);
                }
            }

        }
        else
        {
            $this->createCardImages($card->id, $item);
        }
    }
    public function  deleteCardImages($id)
    {
       return MtgCardImage::where('mtg_card_id',$id)->delete();
        
    }

    public function updateCardName()
    {
        $card_ids = MtgCard::where('is_card_faced',true)->pluck('id')->toArray();
        foreach($card_ids as $id)
        {
            $item = MtgCard::find($id);
            $check = $this->explodeName($item->name);   
            if($check['check']){
                $faces = MtgCardFace::where('mtg_card_id',$id)->get();
                foreach($faces as $key => $face){
                    // dd($key);
                    $face->update(['name'=>$check['names'][$key]]);
                }
                // dd($faces);
            }

        }
        return true;
    }
    public function explodeName($name)
    {
        $arr = explode('//',$name);
        $count = count($arr) == 2 ? true : false;
        return ['check'=>$count , 'names'=>$arr];
    }

    public function getCardValuesToCollections()
    {
        set_time_limit(0);
        MtgUserCollection::chunk(50, function($inspectors) {
            $inspectors->map(function($col){
                updateCollectionByCard($col);
              });
        });

        return 'Successuflly Updated';
    }
}

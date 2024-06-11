<?php

namespace App\Services\Admin\MTG;

use App\Models\MTG\MtgCardImage;
use App\Models\MTG\MtgCardFace;
use App\Models\MTG\MtgCard;
use App\Models\MTG\MtgSet;
use App\Models\MTG\MtgCardLanguage;
use App\Models\MTG\MtgSetLanguage;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class importCards {

    public function cards()
    {
        $start = Carbon::now()->subDays(730);
        $sets = MtgSet::orderBy('created_at','desc')->where('code','!=','fwb')->whereDate('released_at','>=',$start)->get();
        foreach($sets as $set)
        {
            $client = new Client();
            $response = $client->get('https://api.scryfall.com/sets/'.$set->code);
            $response = json_decode($response->getBody()->getContents(), true);
            $count = $set->single_count;
            if($count <= 0 || $count != $response['card_count'])
            {
                $this->getSetCards('https://api.scryfall.com/cards/search?q=set:"'.$set->code.'"&unique=prints&include_extras=true&include_variations=true',$set);
            }
            $set->update(['imported_at' => now()]);
        }
        $this->ifLangNotExist();
        Artisan::call('mtg:shift-images');
        return true;
    }

    public function getSetCards($url,$set)
    {
        try{
            $client = new Client();
            $response = $client->get($url);
            $response = json_decode($response->getBody()->getContents(), true);

            $our_cards = MtgCard::where('card_type','single')->where('set_code',$set->code)->count();

            if(count($response['data']) > 0 && (int)$response['total_cards'] > $our_cards)
            {
                foreach ($response['data'] as $key => $item)
                {
                    if($this->cardExist($item)) continue;
                    if($item['digital'] == false)
                    {
                        $cardd = $this->saveCard($item);
                        $this->importLangs($cardd);
                    }
                }
                
                $this->saveSetLanguages($set);
                // $this->saveSetLegalities($set);

            }

            if($response['has_more'] == true && (int)$response['total_cards'] > $our_cards)
            {
                $this->getSetCards($response['next_page'],$set);
            }
            return true;
        }
        catch(\Exception $e)
        {
            Log::info($e);
        }
    }
    
    public function saveSetLegalities($set)
    {
        $my_array = [];
        $legalities = MtgCard::where('set_code', $set->code)->where('legalities', '!=', null)->pluck('legalities')->toArray();

        foreach($legalities as $legal)
        {
           $legal = json_decode($legal , true); 
           $my_array[] = $legal;
        }
        
        $mergedArray = [];

        foreach ($my_array as $subArray) {
            foreach ($subArray as $key => $value) {
                $mergedArray[] =  $key.':'.$value;
            }
        }
        $arr = array_unique($mergedArray);
        $arr = array_values($arr);

        $set->legalities = json_encode($arr);
        $set->save();
           
    }
    public function saveSetLanguages($set)
    {
        $my_array = [];
        $ids = MtgCard::where('set_code', $set->code)->whereHas('language')->pluck('id')->toArray();
        $languages = MtgCardLanguage::whereIn('mtg_card_id', $ids)->distinct('key')->pluck('value', 'key')->toArray();
            foreach($languages as $key => $lang)
            {
                $already = MtgSetLanguage::where('mtg_set_id',$set->id)->where('key',$key)->first();
                if(!$already)
                {
                    MtgSetLanguage::create([
                        'mtg_set_id' => $set->id,
                        'key'  => $key,
                        'value' => $lang
                    ]);
                }
            }
           
    }

    public function importLangs($card)
    {
        try {
            $client = new Client();
            $url = 'https://api.scryfall.com/cards/search?q=name:'.$card->name.'&unique=prints&include_multilingual=true';
            $response = $client->get($url);
            $response = json_decode($response->getBody()->getContents(), true); 
            $data = (object) $response['data'];
            $matchingElements = [];
            foreach($data as $item){
                if ($item['name'] === $card->name && $item['collector_number'] === $card->collector_number ) {
                   $this->saveLanguage($card->id,$item['lang']);
                }
            }
        } catch (\Exception $e) {
            return;
        }
    }

    public function saveLanguage($id,$lang)
    {
        $fullname = "English";

        switch ($lang)
        {
            case 'en':
                $fullname = "English";
                break;
            case 'es':
                $fullname = "Spanish";
                break;
            case 'fr':
                $fullname = "French";
                break;
            case 'de':
                $fullname = "German";
                break;
            case 'it':
                $fullname = "Italian";
                break;
            case 'pt':
                $fullname = "Portuguese";
                break;
            case 'ja':
                $fullname = "Japanese";
                break;
            case 'jp':
                $fullname = "Japanese";
                break;
            case 'ko':
                $fullname = "Korean";
                break;
            case 'kr':
                $fullname = "Korean";
                break;
            case 'ru':
                $fullname = "Russian";
                break;
            case 'zhs':
                $fullname = "Simplified Chinese";
                break;
            case 'zht':
                $fullname = "Traditional Chinese";
                break;
            case 'he':
                $fullname = "Hebrew";
                break;
            case 'la':
                $fullname = "Latin";
                break;
            case 'grc':
                $fullname = "Ancient Greek";
                break;
            case 'ar':
                $fullname = "Arabic";
                break;
            case 'sa':
                $fullname = "Sanskrit";
                break;
            case 'ph':
                $fullname = "Phyrexian";
                break;

            default:
                $fullname = "English";
                break;
        }

        MtgCardLanguage::create([
            'mtg_card_id' => $id,
            'key'  => $lang,
            'value' => $fullname
        ]);
    }

    public function cardExist($card)
    {
        return MtgCard::where('card_id',$card['id'])->first();
    }


    public function saveCard($item)
    {
        $set = MtgSet::where('code',$item['set'])->first();
        $pakragiya = strpos($item['name'], '"') !== false;
        if($pakragiya)
        {
            sendMail([
                'view' => 'email.test',
                'to' => 'ghias@trisagesolutions.com',
                'subject' => 'Action Required',
                'data' => [
                    'subject'=>'Action Required',
                    'set'=>$item['set'],
                    'card'=>$item['name'],
                ]
            ]);
        }
        if($set && !$pakragiya)
        {
            $active = $set->is_active;

            $card = new MtgCard();
            $slug  = Str::slug($item['name']."-".$item['collector_number']);
            $card->card_id          = $item['id'] ?? null;
            $card->oracle_id        = $item['oracle_id'] ?? null;
            $card->mtgo_id          = $item['mtgo_id'] ?? null;
            $card->cardmarket_id    = $item['cardmarket_id'] ?? null;
            $card->tcgplayer_id     = $item['tcgplayer_id'] ?? null;
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
            $card->layout           = $item['layout']  ?? null;
            $card->highres_image    = $item['highres_image']  ?? null;
            $card->border_color     = array_key_exists('border_color', $item) ? $item['border_color']  : null;

            $card->legalities       = array_key_exists('legalities', $item) ? json_encode($item['legalities']) : null;
            $card->finishes         = array_key_exists('finishes', $item) ? json_encode($item['finishes']) : null;
            $card->frame_effects    = array_key_exists('frame_effects', $item) ? json_encode($item['frame_effects']) : null;
            $card->promo_types      = array_key_exists('promo_types', $item) ? json_encode($item['promo_types']) : null;

            $card->card_type        = 'single';
            $card->weight = 2;
            $card->is_active = $active;
            $card->int_collector_number = $this->convertCollectorNo($item['collector_number']  ?? '0');

            $card->save();

            if(array_key_exists('card_faces', $item))
            {
                $faced = true;
                foreach ($item['card_faces'] as $key => $face)
                {
                    $check_image_uri = array_key_exists('image_uris', $face) ? true : false;
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
            $card->is_card_faced = $faced ?? false;
            $card->save();
            $this->colorOrder($card);
            createCardSeo($card);
            return  $card;
        }
        return true;
    }
    public function createCardFace($card_id, $data)
    {
        MtgCardFace::create([
            'mtg_card_id'  => $card_id,
            'mana_cost'    => $data['mana_cost'] ?? null,
            'oracle_text'  => $data['oracle_text'] ?? null,
            'type_line'    => $data['type_line'] ?? null,
            'power'        => $data['power'] ?? 0,
            'toughness'    => $data['toughness'] ?? 0,
            'artist'       => $data['artist'] ?? null,
            'colors'       => array_key_exists('colors', $data) ? json_encode($data['colors']) : null
        ]);

        return true;
    }


    public function createCardImages($card_id, $data)
    {
        $images[] = ['mtg_card_id' => $card_id, 'key' => 'png', 'value' => $data['image_uris']['png'] ?? null ];

        MtgCardImage::insert($images);

        return true;
    }
    public function convertCollectorNo($collector_no)
    {
        $pattern = '/\d+/';
        preg_match_all($pattern, $collector_no, $matches);
        $numbers = $matches[0];
        if($numbers)
        {
            return (int)implode('',$numbers);
        }
        return 0;
    }
    public function colorOrder($card)
    {
        $faces = $card->faces ? $card->faces : [];
        foreach($faces as $face)
        {
            $array = json_decode($face->colors, true);
            if($array){
                $order = count($array) > 1 ? 7 : colorOrders()[$array[0]];
            }
            else{
                $order = 6;
            }
            $face->color_order = $order;
            $face->save();
        }
    }
    public function ifLangNotExist() 
    {
        $list = MtgCard::where('card_type','single')->whereDoesntHave('language')->pluck('id')->toArray();
        foreach($list as $id)
        {
            $item = MtgCard::find($id);
            if($item->card_type == "single" && $item->language->count() <= 1)
            {
                importCardLanguages($item);
            }
        }
        return true;
    }
}

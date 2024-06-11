<?php

namespace App\Services\Admin\MTG;

use App\Models\MTG\MtgCardImage;
use App\Models\MTG\MtgCardFace;
use App\Models\MTG\MtgCard;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class UpdateCards {

    public function update()
    {
        // $start = Carbon::now()->subDays(2);
        $cards = MtgCard::where('is_active',0)->orderBy('created_at','desc')->get();
        // $cards = MtgCard::where('is_active',0)->orderBy('created_at','desc')->whereDate('created_at','>=',$start)->get();
        foreach($cards as $card)
        {
            $url = 'https://api.scryfall.com/cards/'.$card->card_id;
            $this->apiCall($url , $card);
        }
        $this->ifLangNotExist();
        Artisan::call('mtg:shift-images');
        return true;
    }
    public function apiCall($url,$card)
    {
        try{
            $client = new Client();
            $response = $client->get($url);
            $response = json_decode($response->getBody()->getContents(), true);

            $this->updateCard($response , $card);
            
            return true;
        }
        catch(\Exception $e)
        {
            Log::info($e);
        }
    }
    public function updateCard($item , $card)
    {

            if($card->attributes)
            {
                $attributes = $card->attributes->pluck('name')->toArray();
                $attributes = implode('-',$attributes);
                $slug               = Str::slug($item['name']."-".$attributes);
            }
            else
            {
                $slug               = Str::slug($item['name']."-".$item['collector_number']);
            }
            $card->card_id          = $item['id'] ?? null;
            $card->mtgo_id          = $item['mtgo_id'] ?? null;
            $card->cardmarket_id    = $item['cardmarket_id'] ?? null;
            $card->tcgplayer_id     = $item['tcgplayer_id'] ?? null;
            $card->oracle_id        = $item['oracle_id'] ?? null;
            $card->name             = $item['name']  ?? $card->name;
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
            $card->is_active = $card->is_active;
            $card->int_collector_number = $this->convertCollectorNo($item['collector_number']  ?? '0');

            $card->save();

            $this->updateCardFace($card, $item);

            $card->is_card_faced = $faced ?? false;
            $card->save();
            $this->colorOrder($card);
            createCardSeo($card);
            return  $card;
        return true;
    }
    public function updateCardFace($card, $item)
    {
        $has_face = array_key_exists('card_faces', $item);
        $images = [];
        $faces = DB::table('mtg_card_faces')->where('mtg_card_id',$card->id)->get();
        if($has_face)
        {
            foreach($item['card_faces'] as $key => $itemm)
            {
               $face =  isset($faces[$key]) ? $faces[$key] : null;
               $this->savefaceData($itemm,$card->id,$face = null);
               $images[] = isset($itemm['image_uris']) ? $itemm['image_uris'] : (isset($item['image_uris']) ? $item['image_uris'] : null);
            }
        }
        else{
            $this->savefaceData($item,$card->id,$faces[0]);
            $images[] = isset($item['image_uris']) ? $item['image_uris'] : null;
        }

        $this->updateCardImages($card, $images);

        return true;
    }
    public function updateCardImages($card, $images)
    {
        DB::table('mtg_card_images')->where('mtg_card_id',$card->id)->where('value',null)->delete();
        $default_images = DB::table('mtg_card_images')->where('mtg_card_id',$card->id)->get();

        foreach($images as $key => $image)
        {
            $default_img =  isset($default_images[$key]) ? $default_images[$key] : null;
            $this->saveImageData($image,$card->id,$default_img);
        }
        return true;
    }
    public function saveImageData($data,$card_id,$default_img = null)
    {
        $url = $data && isset($data['png']) ? $data['png'] : null;
        $value = $default_img  ?  $default_img->value : null;
        $this->saveImageUrlToFile($value);
        // $value = $default_img && $default_img->default_url == $url ?  $default_img->value : $url;

        $data = [
            'mtg_card_id' => $card_id,
            'key' => 'png',
            'value' => $url,
            'default_url' => $url,
            'created_at'   => now(),
            'updated_at'   => now(),
        ];
        $query = ['mtg_card_id' => $card_id,'id' => $default_img ? $default_img->id : null ];
        MtgCardImage::updateOrInsert($query ,$data);
    }

    public function saveImageUrlToFile($url = null)
    {
        $filePath = public_path('mtg/sets/media/url.json');
       // Data to append to the file
        $data = $url."\n";

        // Check if the file exists
        if (file_exists($filePath)) {
    // Append data to the file
        file_put_contents($filePath, $data, FILE_APPEND);
        } else {
    // Create the file and write data to it
        file_put_contents($filePath, $data);
        }
    } 

    public function savefaceData($data,$card_id,$face = null)
    {
        $data = [
            'mtg_card_id'  => $card_id,
            'mana_cost'    => $data['mana_cost'] ?? null,
            'oracle_text'  => $data['oracle_text'] ?? null,
            'type_line'    => $data['type_line'] ?? null,
            'power'        => $data['power'] ?? 0,
            'toughness'    => $data['toughness'] ?? 0,
            'artist'       => $data['artist'] ?? null,
            'colors'       => array_key_exists('colors', $data) ? json_encode($data['colors']) : null,
            'created_at'   => now(),
            'updated_at'   => now(),
        ];
        $query = ['id' => $face ? $face->id : null];
        MtgCardFace::updateOrInsert($query,$data);
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

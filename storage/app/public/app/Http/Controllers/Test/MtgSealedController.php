<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Models\MTG\MtgCard;
use App\Models\MTG\MtgCardFace;
use App\Models\MTG\MtgCardImage;
use App\Models\MTG\MtgCardSeo;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Str;

class MtgSealedController extends Controller
{
    public function importSealed()
    {
        $client = new Client([
            'base_uri' => 'https://veryfriendlysharks.co.uk/',
            'auth' => ['skyfall', 'bond007@skyfall'],
        ]);
        $response = $client->get('https://veryfriendlysharks.co.uk/api/sealed-products');
        $response = json_decode($response->getBody()->getContents(), true); 
        // dd($response[0]);
        foreach($response as $item)
        {
            $this->saveSealed($item);
        }

        return "done";
    }
    public function saveSealed($item)
    {
        
        $slug = Str::slug($item['name']);
        // $sealed = new MtgCard();
        // $sealed->name = $item['name'];
        // $sealed->set_code = $item['expansion']['code'];
        // $sealed->slug = $slug;
        // $sealed->card_type = "sealed";
        // $sealed->other_cards_type = $item['type'];
        // $sealed->save();
        

        // $this->saveSealedFace($item , $sealed->id);
        // $this->saveSealedImages($item , $sealed->id , $sealed->name);

        $sealed = MtgCard::where('set_code',$item['expansion']['code'])->where('slug',$slug)->first();

        $this->saveSealedSeo($item , $sealed->id);
        
        return true;
    }
    public function saveSealedFace($item , $id)
    {
        $face = ['mtg_card_id'=>$id ,'name'=>$item['name']];
        
        MtgCardFace::create($face);
        return true;
    }
    public function saveSealedImages($item , $id , $name)
    {
        $file = 'https://veryfriendlysharks.co.uk'.$item['search_image'];
        $images[] = ['mtg_card_id' => $id, 'key' => 'png', 'value' => $file ?? null ];
        $images[] = ['mtg_card_id' => $id, 'key' => 'art_crop', 'value' => $file ?? null ];
        $images[] = ['mtg_card_id' => $id, 'key' => 'border_crop', 'value' => $file ?? null ];
        MtgCardImage::insert($images);
        return true;
    }
    public function saveSealedSeo($item , $id)
    {
        $data = [
            'title'=>$item['title'] ?? null,
            'heading'=>$item['heading1'] ?? null,
            'sub_heading'=>$item['heading2'] ?? null,
            'meta_description'=>$item['meta_description'] ?? null,
            'mtg_card_id'=>$id,
        ];
        MtgCardSeo::create($data);
        return true;
    }
}

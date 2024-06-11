<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MTG\MtgCard;
use App\Models\MTG\MtgCardFace;
use App\Models\MTG\MtgCardImage;
use App\Models\MTG\MtgCardSeo;
use GuzzleHttp\Client;
use Illuminate\Support\Str;

class MtgFullSetController extends Controller
{
    public function importFullSet()
    {
        $client = new Client([
            'base_uri' => 'https://veryfriendlysharks.co.uk/',
            'auth' => ['skyfall', 'bond007@skyfall'],
        ]);
        $response = $client->get('https://veryfriendlysharks.co.uk/api/complete-sets');
        $response = json_decode($response->getBody()->getContents(), true);   
        // dd($response);
        foreach($response as $item)
        {
            $this->saveFullSet($item);
        }

        return "done";
    }
    public function saveFullSet($item)
    {
        
        $slug = Str::slug($item['name']);
        // $fullSet = new MtgCard();
        // $fullSet->name = $item['name'];
        // $fullSet->set_code = $item['expansion']['code'];
        // $fullSet->slug = $slug;
        // $fullSet->card_type = "completed";
        // $fullSet->other_cards_type = $item['type'];
        // $fullSet->save();
        
        // $this->saveFullSetFace($item , $fullSet->id);
        // $this->saveFullSetImages($item , $fullSet->id , $fullSet->name);

        $fullSet = MtgCard::where('set_code',$item['expansion']['code'])->where('slug',$slug)->first();

        $this->saveFullSetSeo($item , $fullSet->id);
        
        return true;
    }
    public function saveFullSetFace($item , $id)
    {
        $face = ['mtg_card_id'=>$id ,'name'=>$item['name']];
        
        MtgCardFace::create($face);
        return true;
    }
    public function saveFullSetImages($item , $id , $name)
    {
        $file = 'https://veryfriendlysharks.co.uk/images/All.svg';
        $images[] = ['mtg_card_id' => $id, 'key' => 'png', 'value' => $file ?? null ];
        $images[] = ['mtg_card_id' => $id, 'key' => 'art_crop', 'value' => $file ?? null ];
        $images[] = ['mtg_card_id' => $id, 'key' => 'border_crop', 'value' => $file ?? null ];
        MtgCardImage::insert($images);
        return true;
    }
    public function saveFullSetSeo($item , $id)
    {
        $data = [
            'title'=>$item['set_title'] ?? null,
            'heading'=>$item['heading1'] ?? null,
            'sub_heading'=>$item['heading2'] ?? null,
            'meta_description'=>$item['meta_description'] ?? null,
            'mtg_card_id'=>$id,
        ];
        MtgCardSeo::create($data);
        return true;
    }
}

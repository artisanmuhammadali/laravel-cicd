<?php

namespace App\Services\Admin\MTG;

use App\Models\MTG\MtgCard;
use App\Models\MTG\MtgCardFace;
use App\Models\MTG\MtgCardImage;
use App\Models\MTG\MtgCardLanguage;
use App\Models\MTG\MtgCardSeo;
use App\Models\MTG\MtgSet;
use Illuminate\Support\Str;


class ProductService {
 
    public function save($request)
    {
        $rows = json_decode($request->csv , true);
        $header=array_shift($rows);
        $combination = $request->except('_token','form_type','csv','data','mtg_card_type' , 'check');
        $newArray = [];
        $errorArray = [];
        $correctData = [];
        $header['mtg_card_id'] = "Image";
        $correctData[] = $header;
        $errorArray[] = $header;
        foreach($rows as $row){
            foreach ($combination as $newIndex => $oldIndex) {
                if (isset($row[$oldIndex])) {
                    $newArray[$newIndex] = $row[$oldIndex];
                    $newArray['card_type'] = $request->mtg_card_type;
                }
            }
            $set = MtgSet::where('code',$newArray['set_code'])->first();
            if($set && !in_array("", $newArray, true))
            {
                $object = (object) $newArray;
                if($request->check)
                {
                    $correctData[] = $object;
                    $correctData = collect($correctData);
                }
                else{
                    $this->saveProduct($object , $set);
                }
            }
            else
            {
                $errorArray[] = (object) $newArray;
                $errorArray = collect($errorArray);
            }
        }
        $arrays = ['total'=>count($rows) , 'correct'=>$correctData];
        $response = (object) $arrays;
        return $response;

    }
    public function saveProduct($data , $set , $type = null)
    {
        $slug = $type == null ? Str::slug($data->name) : $data->slug;
        $card = MtgCard::create([
            'name'=>$data->name,
            'slug'=>$slug,
            'set_code'=>$data->set_code,
            'other_cards_type'=>$data->other_cards_type ?? 'set',
            'card_type'=>$data->card_type,
            'foil'=>$set->foil,
            'nonfoil'=>$set->nonfoil,
            'legalities'=>$set->legalities,
            'weight'=>$data->weight ?? null,
            'rarity'=>$data->rarity ?? null,
            'is_active'=>$data->is_arrival ? 0 :1,
        ]);
        MtgCardSeo::create([
            'mtg_card_id'=>$card->id,
            'title'=>$data->title,
            'meta_description'=>$data->meta_description,
            'heading'=>$data->heading,
            'sub_heading'=>$data->sub_heading,
        ]);
        MtgCardFace::create([
            'mtg_card_id'=>$card->id,
            'name'=>$data->name
        ]);
        MtgCardImage::create([
            'key'=>'png',
            'value'=>$data->image ?? 'https://veryfriendlysharks.co.uk/images/All.svg',
            'mtg_card_id'=>$card->id,
            'is_shifted'=>true,
        ]);

        $languageArray = [];

        if($set->set_languages)
        {
            foreach ($set->set_languages as $key => $value) {
                $languageArray[] = [
                    "key" => $key,
                    "value" => $value,
                    "mtg_card_id" => $card->id,
                ];
            }
            MtgCardLanguage::insert($languageArray);
        }
        else
        {
            MtgCardLanguage::create([
                "key" => 'en',
                "value" => 'English',
                "mtg_card_id" => $card->id,
            ]);
        }
        return true;
    }
}
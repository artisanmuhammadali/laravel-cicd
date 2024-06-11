<?php

namespace App\Services\SW;

use App\Models\SW\SwSet;
use App\Models\SW\SwCard;
use App\Models\SW\SwCardSeo;
use Illuminate\Support\Str;
use App\Models\SW\SwCardLanguage;
use App\Models\SW\SwCardImage;
use App\Models\SW\SwSetSeo;



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
        $card = SwCard::create([
            'name'=>$data->name,
            'slug'=>$slug,
            'sw_set_id'=>$set->id,
            'type'=>$data->other_card_type ?? 'set',
            'card_type'=>$data->card_type,
            'weight'=>$data->weight ?? null,
            'rarity'=>$data->rarity ?? null,
        ]);
        SwCardSeo::create([
            'sw_card_id'=>$card->id,
            'title'=>$data->title,
            'meta_description'=>$data->meta_description,
            'heading'=>$data->heading,
            'sub_heading'=>$data->sub_heading,
        ]);

        $set_seo = SwSetSeo::where('type',$type)->where('sw_set_id',$set->id)->first();
            if(!$set_seo)
            {
                $arr=cardTypeSlug();
                $this_type = array_search($type,$arr);
                $new_type = str_replace('-', ' ', $this_type);
                SwSetSeo::create([
                    'sw_set_id' => $set->id,
                    'title'=> $set->name.' | SWU Expansion Set | VFS Card Market',
                    'heading'=> $set['name'].' '. $new_type,
                    'sub_heading'=> 'Browse SWU ' .$new_type. ' To Buy and Sell Your Cards',
                    'meta_description'=> 'Buy and sell '. $set->name .' SWU ' . $new_type. ' on our UK-Only card market, today! Very Friendly Sharks is easy to use, trusted and safe.',
                    'type' => $type,
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]);
            }
     
        SwCardImage::create([
            'sw_card_id' => $card->id,
            'url' => $data->image ?? 'https://veryfriendlysharks.co.uk/images/All.svg',
            'type' => 'front',
        ]);

            SwCardLanguage::create([
                "key" => 'en',
                "sw_card_id" => $card->id,
            ]);
        return true;
    }
}
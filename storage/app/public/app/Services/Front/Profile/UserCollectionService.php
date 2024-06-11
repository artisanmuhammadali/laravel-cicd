<?php

namespace App\Services\Front\Profile;

use App\Models\MTG\MtgCard;
use App\Models\MTG\MtgCardFace;
use App\Models\MTG\MtgUserCollection;


class UserCollectionService {
    public function searchList($request , $object, $type)
    {
        $limit = $request->limit ?? 10;
        $att = $request->attribute;

        return MtgUserCollection::check()
                                ->where('user_id',$object->id)
                                ->where('publish',1)
                                ->where('price','!=',0)
                                ->where('quantity','!=',0)
                                ->with('card')
        ->where('mtg_card_type',$type)
        ->when($request->fill_lang,function($q)use($request){
            $q->where('language',$request->fill_lang);
        })
        ->when($request->active == '0' || $request->active == '1',function($q)use($request){
            $q->where('publish',$request->active);
        })->when($request->fill_condition,function($q)use($request){
            $q->where('condition',$request->fill_condition);
        })
        ->when($request->fill_pow,function($q)use($request){
            $q->where('price',$request->fill_pow_order,$request->fill_pow);
        })
        ->when($request->fill_char,function($q)use($request){
            foreach($request->fill_char as $spe)
            {
               $q->where($spe,1);
            }
        })
        ->when($request->keyword,function($q)use($request){
            $q->where('card_name', 'like', '%' . $request->keyword . '%');
        })
        ->when($att == 'alphabets' ,function($q)use($request){
            $q->orderBy('card_name',$request->order);
        })
        ->when($att == 'collector_number' ,function($q)use($request){
            $q->orderBy('int_collector_number',$request->order);
        })
        ->when($att == 'cmc' ,function($q)use($request){
            $q->orderBy('cmc',$request->order);
        })
        ->when($att == 'price' ,function($q)use($request){
            $q->orderBy('price',$request->order);
        })
        ->when($att == 'rarity_number' ,function($q)use($request){
            $q->orderByRaw("FIELD(rarity, 'common', 'uncommon', 'rare', 'mythic') $request->order");
        })
        ->when($att == 'released_at' ,function($q)use($request){
            $q->orderBy('released_at',$request->order);
        })
        ->when($att == 'power' ,function($q)use($request){
            $q ->addSelect([
                'min_price' => MtgCardFace::select('power')
                ->whereColumn('mtg_card_id', 'mtg_user_collections.mtg_card_id')
                    ->orderBy('power', $request->order)
                    ->limit(1)
            ])
            ->orderBy('min_price', $request->order);
        })
        ->when($att == 'toughness' ,function($q)use($request){
            $q ->addSelect([
                'min_price' => MtgCardFace::select('toughness')
                    ->whereColumn('mtg_card_id', 'mtg_user_collections.mtg_card_id')
                    ->orderBy('toughness', $request->order)
                    ->limit(1)
            ])
            ->orderBy('min_price', $request->order);
        })
        ->when($att == 'color' ,function($q)use($request){
            $q ->addSelect([
                'min_price' => MtgCardFace::select('color_order')
                ->whereColumn('mtg_card_id', 'mtg_user_collections.mtg_card_id')
                    ->orderBy('color_order', $request->order)
                    ->limit(1)
            ])
            ->orderBy('min_price', $request->order);
        })
        ->when(!$request->ajax() ,function($q){
            $q->orderBy('card_name','asc');
        })
        ->paginate($limit);
    }
    
}
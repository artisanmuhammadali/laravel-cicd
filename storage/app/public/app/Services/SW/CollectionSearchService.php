<?php

namespace App\Services\SW;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use App\Models\MTG\MtgCard;
use App\Models\MTG\MtgSet;
use App\Models\MTG\MtgCardFace;
use App\Models\SW\SwUserCollection;

class CollectionSearchService {

    public function searchList($request,$type,$is_all = null)
    {
        $user  = auth()->user();
        $limit = $request->limit ?? 10;
        $att = $request->attribute;

        $query1 = SwUserCollection::where('user_id',$user->id)
                                    ->where('price','!=',0)
                                    ->where('quantity','!=',0)
                                    ->where('card_type',$type);
        $query2 = clone $query1;
        $query3 = clone $query1;
        $active_items =  $query2->where('publish',1)->get();
        $active_sum = $active_items->sum(function ($item) {
            return $item->price * $item->quantity;
        });
        $inactive_items =  $query3->where('publish',0)->get();
        $inactive_sum = $inactive_items->sum(function ($item) {
            return $item->price * $item->quantity;
        });
        $active_sum  =number_format($active_sum , 2, '.', '');
        $inactive_sum  =number_format($inactive_sum , 2, '.', '');
        $cols = SwUserCollection::where('user_id',$user->id)->with('card')
        ->when($request->rarity && $request->rarity != "all",function($q)use($request){
            $q->where('rarity',$request->rarity);
        })
        ->where('card_type',$type)
        ->when($request->fill_lang,function($q)use($request){
            $q->where('language',$request->fill_lang);
        })
        ->when($request->code,function($q)use($request){
            $q->where('set_code',$request->code);
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
            $q->where('name', 'like', '%' . $request->keyword . '%');
        })
        ->when($att == 'alphabets' ,function($q)use($request){
            $q->orderBy('name',$request->order);
        })
        ->when($att == 'power' ,function($q)use($request){
            $q->orderBy('power',$request->order);
        })
        ->when($att == 'hp' ,function($q)use($request){
            $q->orderBy('hp',$request->order);
        })
        ->when($att == 'cost' ,function($q)use($request){
            $q->orderBy('cost',$request->order);
        })
        ->when($att == 'price' ,function($q)use($request){
            $q->orderBy('price',$request->order);
        })
        ->when($att == 'released_at' ,function($q)use($request){
            $q->orderBy('published_at',$request->order);
        })
        ->when(!$request->ajax() || !$att ,function($q){
            $q->orderBy('created_at','desc')->orderBy('name','asc');
        });

        $cols = $is_all ? $cols->get() : $cols->paginate($limit);
        return $is_all ? $cols : [$cols,$active_sum,$inactive_sum];
    }

    // public function searchList($request)
    // {

    //     $object  = auth()->user();
    //     $coll_ids = $object->collections->pluck('mtg_card_id')->toArray();
    //     $att = $request->attribute;
    //     return MtgCard::active()->with(['set','collections'])
    //             ->whereIn('id',$coll_ids)
    //             ->when($request->fill_name,function($q)use($request){
    //                 $q->where('name', 'like', '%' . $request->fill_name . '%');
    //             })
    //             ->when($att == 'alphabets' ,function($q)use($request){
    //                 $q->orderBy('name',$request->order);
    //             })
    //             ->when($att == 'collector_number' ,function($q)use($request){
    //                 $q->orderBy('int_collector_number',$request->order);
    //             })
    //             ->when($att == 'cmc' ,function($q)use($request){
    //                 $q->orderBy('cmc',$request->order);
    //             })
    //             ->when($att == 'rarity_number' ,function($q)use($request){
    //                 $q->orderByRaw("FIELD(rarity, 'common', 'uncommon', 'rare', 'mythic') $request->order");
    //             })
    //             ->when($att == 'released_at' ,function($q)use($request){
    //                 $q->orderBy('released_at',$request->order);
    //             })
    //             ->when($att == 'power' ,function($q)use($request){
    //                 $q ->addSelect([
    //                     'min_price' => MtgCardFace::select('power')
    //                         ->whereColumn('mtg_card_id', 'mtg_cards.id')
    //                         ->orderBy('power', $request->order)
    //                         ->limit(1)
    //                 ])
    //                 ->orderBy('min_price', $request->order);
    //             })
    //             ->when($att == 'toughness' ,function($q)use($request){
    //                 $q ->addSelect([
    //                     'min_price' => MtgCardFace::select('toughness')
    //                         ->whereColumn('mtg_card_id', 'mtg_cards.id')
    //                         ->orderBy('toughness', $request->order)
    //                         ->limit(1)
    //                 ])
    //                 ->orderBy('min_price', $request->order);
    //             })
    //             ->when($att == 'color' ,function($q)use($request){
    //                 $q ->addSelect([
    //                     'min_price' => MtgCardFace::select('color_order')
    //                         ->whereColumn('mtg_card_id', 'mtg_cards.id')
    //                         ->orderBy('color_order', $request->order)
    //                         ->limit(1)
    //                 ])
    //                 ->orderBy('min_price', $request->order);
    //             })
    //             ->when($request->ajax() == false ,function($q){
    //                 $q->orderBy('name','asc');
    //             })
    //             ->get();
    // }
}

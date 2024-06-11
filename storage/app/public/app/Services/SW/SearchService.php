<?php

namespace App\Services\SW;

use App\Models\SW\SwSet;
use App\Models\SW\SwCard;
use App\Models\User;

class SearchService {
 
    public function generalSearch($request)
    {
        $keyword = $request->keyword;
        $items = SwCard::whereHas('set')->where('name', 'like', '%' . $keyword. '%')->whereNull('parent_id');
        $item_count = $items->count();
        $items = $items->orderBy('created_at','desc')->inRandomOrder()->take(30)->get();
        $sets = SwSet::where('name', 'like', '%' . $keyword. '%');
        $set_count = $sets->count();
        $sets = $sets->orderBy('created_at','desc')->take(10)->get();
        
        $users = User::where('role','!=','admin')->where('status','!=','deleted')->where('user_name', 'like', '%' . $keyword. '%');
        $user_count = $users->count();
        $users = $users->where('role','!=','admin')->take(10)->get();
         
        return [$items,$item_count,$sets,$set_count,$users,$user_count];
    }

    public function searchList($request,$set = null,$type = null)
    {
        $pagination = $request->pagination ? $request->pagination : 9; 
        $pagination = $request->item && $request->item == "versions" ? 1000 : $pagination; 
        $att = $request->attribute;
        return SwCard::where('is_active',1)->whereHas('set')
                ->when($type,function($q)use($type){
                    $q->where('card_type',$type);
                })
                ->when($set,function($q)use($set){
                    $q->where('sw_set_id',$set->id);
                })
                ->when(!$request->item,function($q){
                    $q->whereNull('parent_id');
                })
                ->when($request->item == 'versions',function($q){
                    $q->whereNotNull('parent_id');
                })
                ->when($request->keyword,function($q)use($request){
                    $q->where('name', 'like', '%' . $request->keyword . '%');
                })
                ->when($att == 'alphabets' ,function($q)use($request){
                    $q->orderBy('name',$request->order);
                })
                ->when($att == 'rarity' ,function($q)use($request){
                    $q->orderByRaw("FIELD(rarity, 'common', 'uncommon', 'rare', 'mythic') $request->order");
                })
                ->when($att == 'sw_published_at' ,function($q)use($request){
                    $q->orderBy('sw_published_at',$request->order);
                })
                ->when($att == 'power' ,function($q)use($request){
                    $q->orderBy('power',$request->order);
                })
                ->when($att == 'cost' ,function($q)use($request){
                    $q->orderBy('cost',$request->order);
                })
                ->when($att == 'hp' ,function($q)use($request){
                    $q->orderBy('hp',$request->order);
                })
                ->when($request->ajax() == false ,function($q){
                    $q->orderBy('name','asc');
                })->when(!in_array($att, ['alphabets']) ,function($q){
                    $q->orderBy('name','asc');
                })->paginate($pagination);
    }

    public function detailedSearch($request)
    {
        $pagination = $request->pagination ? $request->pagination : 9; 
        $att = $request->attribute;
        $list= SwCard::whereHas('set')
                ->whereNull('parent_id')
                ->when($request->name, function($q) use($request){
                    $q->when($request->exact_card_name == 'true',function($qu)use($request){
                            $qu->Where('name', $request->name);
                    })->when($request->exact_card_name == 'false',function($qu)use($request){
                        $qu->Where('name', 'like', '%' . $request->name. '%');
                    });
                })->when($request->within_text, function($q) use($request){
                    $q->where('text','like', '%' . $request->within_text. '%');
                })
                ->when($request->strength_value, function($q) use($request){
                    $q->where($request->strength,$request->strength_order,$request->strength_value);
                })->when($request->artist_name, function($q) use($request){
                    $q->where('artist','like', '%' . $request->artist_name. '%');
                })->when($request->rarity,function($q)use($request){
                    $q->whereIn('rarity',$request->rarity);
                })
                ->when($request->type,function($q)use($request){
                    $q->where('type',$request->type);
                })
                ->when($request->language, function($q) use($request){
                        $q->WhereHas('language',function($que) use($request){
                           $que->where('key',$request->language);
                        });
                })
                ->when($request->trait, function($q) use($request){
                    $q->whereJsonContains('traits',$request->trait);
                })
                ->when($request->arena, function($q) use($request){
                    $q->whereJsonContains('arenas',$request->arena);
                })->when($request->set_name, function($q) use($request){
                    $q->when($request->exact_set_name == 'true',function($qu)use($request){
                            $qu->WhereHas('set',function($que) use($request){
                                $que->where('name','like', '%' . $request->set_name. '%');
                            });
                    });
                    $q->when($request->exact_set_name == 'true',function($qu)use($request){
                            $qu->WhereHas('set',function($que) use($request){
                                $que->where('name', $request->set_name);
                            });
                    });
                });
        $count = $list->count();
        $list = $list->paginate($pagination);
        return (object)['list'=>$list,'count'=>$count];
    }
}
<?php

namespace App\Services\Front\Expansions;

use App\Models\MTG\MtgCard;
use App\Models\MTG\MtgCardFace;
use App\Models\MTG\MtgUserCollection;
use Illuminate\Support\Facades\DB;

class SearchService {
 
    public function searchList($request,$set_codes = null,$card_type = null)
    {
        $default = isset($card_type['type']) && $card_type['type'] != "completed" && $card_type['type'] != "sealed" ? 9 : 1000;
        $pagination = $request->pagination ? $request->pagination : $default; 

        $pagination = $request->item && $request->item == "versions" ? 1000 : $pagination; 
        $att = $request->attribute;
        return MtgCard::active()->with(['set','collections'])->whereHas('set')
                ->when($request->keyword,function($q)use($request){
                    $q->whereRaw('LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(name, " // " , " "), "\'s", ""), "s\'", "") ,"-" , " ") ,"," , "")) LIKE ?',['%' . $request->keyword . '%' ]);
                })
                ->when($request->item == "versions",function($q)use($request){
                    $q->where('name',$request->keyword);
                })
                ->when($att == 'alphabets' ,function($q)use($request){
                    $q->orderBy('name',$request->order);
                })
                ->when($att == 'collector_number' ,function($q)use($request){
                    $q->orderBy('int_collector_number',$request->order);
                })
                ->when($att == 'cmc' ,function($q)use($request){
                    $q->orderBy('cmc',$request->order);
                })
                ->when($att == 'rarity_number' ,function($q)use($request){
                    $q->orderByRaw("FIELD(rarity, 'common', 'uncommon', 'rare', 'mythic') $request->order");
                })
                ->when($att == 'released_at' ,function($q)use($request){
                    $q->orderBy('released_at',$request->order);
                })
                ->when($att == 'price' ,function($q)use($request){
                    $q->addSelect([
                        'min_price' => MtgUserCollection::check()
                            ->select(DB::raw('MIN(price) as price'))
                            ->whereColumn('mtg_card_id', 'mtg_cards.id')
                            ->orderBy('price', $request->order)
                            ->limit(1)
                    ])
                    ->orderBy('min_price', $request->order);
                })
                ->when($att == 'power' ,function($q)use($request){
                    $q->addSelect([
                        'min_price' => MtgCardFace::select('power')
                            ->whereColumn('mtg_card_id', 'mtg_cards.id')
                            ->orderBy('power', $request->order)
                            ->limit(1)
                    ])
                    ->orderBy('min_price', $request->order);
                })
                ->when($att == 'toughness' ,function($q)use($request){
                    $q ->addSelect([
                        'min_price' => MtgCardFace::select('toughness')
                            ->whereColumn('mtg_card_id', 'mtg_cards.id')
                            ->orderBy('toughness', $request->order)
                            ->limit(1)
                    ])
                    ->orderBy('min_price', $request->order);
                })
                ->when($att == 'color' ,function($q)use($request){
                    $q ->addSelect([
                        'min_price' => MtgCardFace::select('color_order')
                            ->whereColumn('mtg_card_id', 'mtg_cards.id')
                            ->orderBy('color_order', $request->order)
                            ->limit(1)
                    ])
                    ->orderBy('min_price', $request->order);
                })
                ->when($set_codes ,function($q)use($set_codes){
                    $q->whereIn('set_code',$set_codes);
                })
                ->when($card_type && $card_type['status'] == true,function($q)use($card_type){
                    $q->where('card_type',$card_type['type']);
                })
                ->when($request->ajax() == false ,function($q){
                    $q->orderBy('name','asc');
                })
                ->when($att == 'price' ,function($q){
                    $ids = verifiedUsers();
                    $q->whereHas('collections',function($qu)use($ids){
                        $qu->where('publish',1)
                        ->whereIn('user_id',$ids)
                        ->where('quantity','!=',0);
                    });
                })->when(!in_array($att, ['alphabets']) ,function($q){
                    $q->orderBy('name','asc');
                })->paginate($pagination);
    }

    public function detailedSearch($request)
    {
        $pagination = $request->pagination ? $request->pagination : 9; 
        $att = $request->attribute;
        $list= MtgCard::active()->whereHas('set')
                ->when($request->name, function($q) use($request){
                    $q->when($request->exact_card_name == 'true',function($qu)use($request){
                            $qu->Where('name', $request->name);
                    })->when($request->exact_card_name == 'false',function($qu)use($request){
                        $qu->Where('name', 'like', '%' . $request->name. '%');
                    });
                })->when($request->within_text, function($q) use($request){
                    $q->WhereHas('faces',function($que) use($request){
                        $que->where('oracle_text','like', '%' . $request->within_text. '%');
                    });
                })->when($request->color, function($q) use($request){
                    $q->WhereHas('faces',function($que) use($request){
                    $que->whereIn('color_order',$request->color);
                    });
                })
                ->when($request->strength_value, function($q) use($request){
                    $q->WhereHas('faces',function($que) use($request){
                        $que->where($request->strength,$request->strength_order,$request->strength_value);
                    });
                })->when($request->artist_name, function($q) use($request){
                    $q->WhereHas('faces',function($que) use($request){
                    $que->where('artist','like', '%' . $request->artist_name. '%');
                    });
                })->when($request->category_1,function($q)use($request){
                    $value = 'legal';
                    $q->whereRaw("JSON_UNQUOTE(json_extract(legalities, '$." . $request->category_1 . "')) = ?", [$value]);
                })->when($request->category_2,function($q)use($request){
                    $value = 'legal';
                    $q->whereRaw("JSON_UNQUOTE(json_extract(legalities, '$." . $request->category_2 . "')) = ?", [$value]);
                })->when($request->rarity,function($q)use($request){
                    $q->where('rarity',$request->rarity);
                })
                ->when($request->language, function($q) use($request){
                        $q->WhereHas('language',function($que) use($request){
                        $que->where('key',$request->language);
                        });
                })->when($request->condition, function($q) use($request){
                    $q->WhereHas('collections',function($que) use($request){
                        $que->where('condition',$request->condition)->where('publish',1);
                    });
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
                })
                ->when($request->cmc_value, function($q) use($request){
                    $q->where('cmc',$request->cmc_order,$request->cmc_value);
                })
                ->when($request->special, function($q) use($request){
                    foreach($request->special as $spe)
                    {
                    $q->when(in_array($spe,['art','token']),function($que) use($spe){
                        $que->whereHas('set',function($queu) use($spe){
                            $queu->when($spe == 'token',function($queue){
                                $queue->where('custom_type','Tokens & Emblems');
                            })->when($spe == 'art',function($queue){
                                $queue->where('custom_type','Art Cards');
                            });
                        });
                    })->when($spe == 'oversized',function($que)use($spe){
                        $que->where('oversized',1);
                    })->when($spe == 'double_side',function($que)use($spe){
                        $que->where('is_card_faced',1)->has('faces','>',1);
                    })->when($spe == 'double_face',function($que)use($spe){
                        $que->where('is_card_faced',1)->has('faces','=',1);
                    })
                    ->when($spe == 'other',function($que){
                        $otherTypes = ['Token','Planes','Scheme'];
                        $pattern = implode('|', array_map('preg_quote', $otherTypes));
                        $que->WhereHas('faces',function($queue) use($pattern){
                          $queue->whereRaw("LOWER(type_line) REGEXP ?", [strtolower($pattern)]);
                     });
                    });
                    }
                })
                ->when($request->characterstics, function($q) use($request){
                    foreach($request->characterstics as $spe)
                    {
                        $q->when(in_array($spe,['signed','graded','altered']),function($que) use($spe){
                            $que->whereHas('collections',function($queu) use($spe){
                                $queu->when($spe == 'signed',function($queue){
                                    $queue->where('signed',1);
                                })->when($spe == 'graded',function($queue){
                                    $queue->where('graded',1);
                                })->when($spe == 'altered',function($queue){
                                    $queue->where('altered',1);
                                });
                            });
                        })->when($spe == 'foil',function($que)use($spe){
                            $que->where('foil',1);
                        })->when($spe == 'nonfoil',function($que)use($spe){
                            $que->where('nonfoil',1);
                        })->when($spe == 'etched',function($que)use($spe){
                            $que->where('finishes','like', '%' . $spe. '%');
                        });
                    }
                })
                ->when($request->card_type, function($q) use($request){
                    $types = json_decode($request->card_type);
                    foreach($types as $type)
                    {
                        $q->WhereHas('faces',function($que) use($type){
                            $que->where('type_line','like', '%' . $type->value. '%');
                        });
                    }
                })
                ->when($att == 'alphabets' ,function($q)use($request){
                    $q->orderBy('name',$request->order);
                })
                ->when($att == 'collector_number' ,function($q)use($request){
                    $q->orderBy('int_collector_number',$request->order);
                })
                ->when($att == 'cmc' ,function($q)use($request){
                    $q->orderBy('cmc',$request->order);
                })
                ->when($att == 'rarity_number' ,function($q)use($request){
                    $q->orderByRaw("FIELD(rarity, 'common', 'uncommon', 'rare', 'mythic') $request->order");
                })
                ->when($att == 'released_at' ,function($q)use($request){
                    $q->orderBy('released_at',$request->order);
                })
                ->when($att == 'price' ,function($q)use($request){
                    $q ->addSelect([
                        'min_price' => MtgUserCollection::check()
                            ->select(DB::raw('MIN(price) as price'))
                            ->whereColumn('mtg_card_id', 'mtg_cards.id')
                            ->orderBy('price', $request->order)
                            ->limit(1)
                    ])
                    ->orderBy('min_price', $request->order);
                })
                ->when($att == 'power' ,function($q)use($request){
                    $q ->addSelect([
                        'min_price' => MtgCardFace::select('power')
                            ->whereColumn('mtg_card_id', 'mtg_cards.id')
                            ->orderBy('power', $request->order)
                            ->limit(1)
                    ])
                    ->orderBy('min_price', $request->order);
                })
                ->when($att == 'toughness' ,function($q)use($request){
                    $q ->addSelect([
                        'min_price' => MtgCardFace::select('toughness')
                            ->whereColumn('mtg_card_id', 'mtg_cards.id')
                            ->orderBy('toughness', $request->order)
                            ->limit(1)
                    ])
                    ->orderBy('min_price', $request->order);
                })
                ->when($att == 'color' ,function($q)use($request){
                    $q ->addSelect([
                        'min_price' => MtgCardFace::select('color_order')
                            ->whereColumn('mtg_card_id', 'mtg_cards.id')
                            ->orderBy('color_order', $request->order)
                            ->limit(1)
                    ])
                    ->orderBy('min_price', $request->order);
                })
                ->when($request->ajax() == false ,function($q){
                    $q->orderBy('name','asc');
                })
                ->when($att == 'price' ,function($q){
                    $ids = verifiedUsers();
                    $q->whereHas('collections',function($qu)use($ids){
                        $qu->where('publish',1)
                        ->whereIn('user_id',$ids)
                        ->where('quantity','!=',0);
                    });
                })
                ->where('card_type','single');
        $count = $list->count();
        $list = $list->paginate($pagination);
        return (object)['list'=>$list,'count'=>$count];
    }
}
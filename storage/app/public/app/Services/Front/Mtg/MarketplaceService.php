<?php

namespace App\Services\Front\Mtg;

use App\Models\MTG\MtgCard;
use App\Models\MTG\MtgUserCollection;

class MarketplaceService {

    public function search($request , $type)
    {
        $type = array_key_exists($type , cardTypeSlug()) ? cardTypeSlug()[$type] : 'single';
        $order = request()->order ? request()->order : 'asc';
        $pagination = request()->pagination ? request()->pagination : 50;
        $ids = [];

        if($request->filter == 1 || $request->set_name)
        {
            $ids =  MtgCard::active()
                        ->whereHas('collections',function($q){
                            $ids = verifiedUsers();
                            $q->whereIn('user_id',$ids)->where('quantity','!=',0)->where('publish',1);
                        })->when($request->name, function($q) use($request){
                            $q->when($request->exact_card_name == 'true',function($qu)use($request){
                                    $qu->Where('name', $request->name);
                            })->when($request->exact_card_name == 'false',function($qu)use($request){
                                $qu->whereRaw('LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(name, " // " , " "), "\'s", ""), "s\'", "") ,"-" , " ") ,"," , "")) LIKE ?',['%' . $request->name . '%' ]);
                            });
                        })->when($request->within_text, function($q) use($request){
                            $q->WhereHas('faces',function($que) use($request){
                                $que->where('oracle_text','like', '%' . $request->within_text. '%');
                            });
                        })->when($request->color, function($q) use($request){
                            $q->WhereHas('faces',function($que) use($request){
                            $que->whereIn('color_order',$request->color);
                            });
                        })->when($request->strength_value, function($q) use($request){
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
                        })->when($request->language, function($q) use($request){
                            $q->WhereHas('language',function($que) use($request){
                                $que->where('key',$request->language);
                            });
                        })->when($request->set_name, function($q) use($request){
                            $q->when($request->exact_set_name == 'false',function($qu)use($request){
                                    $qu->WhereHas('set',function($que) use($request){
                                        $que->where('name','like', '%' . $request->set_name. '%');
                                    });
                            });
                            $q->when($request->exact_set_name == 'true',function($qu)use($request){
                                    $qu->WhereHas('set',function($que) use($request){
                                        $que->where('name', $request->set_name);
                                    });
                            });
                        })->when($request->cmc_value, function($q) use($request){
                            $q->where('cmc',$request->cmc_order,$request->cmc_value);
                        })->when($request->special, function($q) use($request){
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
                                })
                                ->when($spe == 'other',function($que){
                                    $otherTypes = ['Token','Planes','Scheme'];
                                    $pattern = implode('|', array_map('preg_quote', $otherTypes));
                                    $que->WhereHas('faces',function($queue) use($pattern){
                                    $queue->whereRaw("LOWER(type_line) REGEXP ?", [strtolower($pattern)]);
                                });
                            });
                            }
                        })->where('card_type',$type)
                        ->pluck('id')->toArray();
        }

        return MtgUserCollection::check()
                        ->where('mtg_card_type',$type)
                        ->when($request->filter == 1 || $request->set_name ,function($q)use($ids){
                            $q->whereIn('mtg_card_id',$ids);
                        })->when($request->fill_lang, function($q) use($request){
                            $q->where('language',$request->fill_lang);
                        })->when($request->fill_condition, function($q) use($request){
                            $q->where('condition',$request->fill_condition);
                        })->when($request->characters, function($q) use($request){
                            $conditions = [];
                            foreach ($request->characters as $column) {
                                $column == "non_foil" ? $conditions['foil'] = 0 : $conditions[$column] = 1;
                            }
                            $q->where($conditions);
                        })
                        ->orderBy('price',$order)->paginate($pagination);
    }
    
}
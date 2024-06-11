<?php

namespace App\Http\Controllers\Front\MTG;

use App\Http\Controllers\Controller;
use App\Models\MTG\MtgCard;
use App\Models\MTG\MtgSet;
use App\Models\MTG\MtgUserCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Services\Front\Expansions\SearchService;

class ExpansionController extends Controller
{
    private $searchService;
    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    public function index()
    {
        $request = request();
        $sets =  DB::table('mtg_sets')
                     ->where('is_active', true)
                     ->where('type', '!=', null)
                     ->when($request->format1,function($q)use($request){
                        $format1 = $request->format1.":legal";
                        $q->whereJsonContains('legalities',$format1);
                     })
                     ->get(['id','slug','code','name','type','icon','released_at'])
                     ->groupBy('type');

        if($request->ajax())
        {
            $html = view('front.mtg.expansion.components.expList',compact('sets'))->render();
            return response()->json(['html'=>$html]);
        }
        return view('front.mtg.expansion.index',compact('sets'));
    }

    public function set($slug)
    {
        $set =  MtgSet::where('slug',$slug)->firstOrFail();
        $childs = MtgSet::active()->where('parent_set_code',$set->code)
                    ->get(['id','slug','code','name','type','icon','custom_type','card_count'])
                    ->groupBy('custom_type');
        return view('front.mtg.expansion.set',compact('set','slug','childs'));
    }

    public function type(Request $request,$slug , $type)
    {
        $route = 'mtg';
        $searchType = '';
        $type = str_replace('&amp;', '&', $type);
        $tab_type = $request->tab_type ?? 'best_price';
        $slugg = in_array($type , setProductTypes()) || in_array($type,customTypes()) ? $slug : $type;
        $set =  MtgSet::where('slug',$slug)->first();
        $set_codes = DB::table('mtg_sets')
                    ->where('is_active', true)
                    ->when(in_array($type,setProductTypes()),function($q)use($set){
                        $q->where('code',$set->code);
                    })
                    ->when(!in_array($type,setProductTypes()),function($q)use($type,$set){
                        $q->where('parent_set_code',$set->code)
                        ->whereRaw('LOWER(REPLACE(REPLACE(REPLACE(custom_type, "&" , ""), " ", "-"), "--", "-")) = ?',$type);
                    })
                    ->pluck('code')->toArray();
        $set_codes = count($set_codes) > 0 ? $set_codes : MtgSet::active()->where('slug',$type)->pluck('code')->toArray();
        $arr=cardTypeSlug();
        $card_type = array_key_exists($type , $arr) ? ['type'=>$arr[$type],'status'=>true]  : ['type'=>$slug,'status'=>false];
        $att = $request->attribute;
        
        $main_set = MtgSet::active()->whereIn('code',$set_codes)->firstOrFail();
        $seo_type = cardTypeSlug();
        $seo_type = array_key_exists($type , $seo_type) ? $seo_type[$type] : 'single';
        $seo = $main_set->type == "child" ? $main_set : $main_set->seo_detail->where('type',$seo_type)->first();
        $list = $this->searchService->searchList($request,$set_codes,$card_type);
        // dd($list);
        if($request->ajax())
        {
            $view = view('front.mtg.expansion.components.expansionTabs',compact('set','list','slug','type','tab_type','request','searchType'))->render();
            return response()->json(['html' => $view]);
        }
        return view('front.mtg.expansion.type',compact('set','main_set','list','slug','type','tab_type','request','seo','searchType','route'));
    }
    public function detail(Request $request,$set_slug , $type , $slug)
    {
        $set_slug = str_replace('&amp;', '&', $set_slug);
        $set_codes = MtgSet::active()->when(in_array($type,setProductTypes()),function($q)use($set_slug){
                            $q->where('slug',$set_slug);
                        })
                        ->when(!in_array($type,setProductTypes()),function($q)use($set_slug,$type){
                            $parent = MtgSet::where('slug',$set_slug)->first();
                            $q->where('parent_set_code',$parent->code)
                            ->whereRaw('LOWER(REPLACE(REPLACE(REPLACE(custom_type, "&" , ""), " ", "-"), "--", "-")) = ?',$type);
                        })
                        ->pluck('code')->toArray();
        $set_codes = count($set_codes) == 0 ? [MtgSet::where('slug' ,$type)->firstOrFail()->code] : $set_codes;
        
        $item = MtgCard::where('slug',$slug)
                        ->whereIn('set_code',$set_codes)
                        ->firstOrFail();
        if(!$item->seo){
            createCardSeo($item);
        }
        if($item->card_type == "single" && $item->language->count() <= 1)
        {
            importCardLanguages($item);
        }
        $item->refresh();
        // sorting
        
        $order = request()->order ? request()->order : 'asc';
        $listings = MtgUserCollection::where('mtg_card_id',$item->id)
        ->check()
        ->when($request->fill_lang, function($q) use($request){
            $q->where('language',$request->fill_lang);
        })
        ->when($request->fill_condition, function($q) use($request){
            $q->where('condition',$request->fill_condition);
        })
        ->when($request->characters, function($q) use($request){
            $conditions = [];
            foreach ($request->characters as $column) {
                $conditions[$column] = 1;
            }
            $q->where($conditions);
        })
        ->where('quantity','!=',0)
        ->orderBy('price',$order);
        $listing_count = $listings->count();
        $collections = $listings->get();
        // dd($listing_count , $collections);
        if(request()->ajax())
        { 
            $view = view('front.components.product-listing',get_defined_vars())->render();
            return response()->json(['html' => $view]);
        }
        return view('front.mtg.expansion.detail',compact('item','listing_count','collections'));
    }

}

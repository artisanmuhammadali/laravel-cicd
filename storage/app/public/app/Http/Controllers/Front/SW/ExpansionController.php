<?php

namespace App\Http\Controllers\Front\SW;

use App\Http\Controllers\Controller;
use App\Models\SW\SwSet;
use App\Models\SW\SwCard;
use App\Models\SW\SwSetSeo;
use App\Models\SW\SwUserCollection;
use Illuminate\Http\Request;
use App\Services\SW\SearchService;


class ExpansionController extends Controller
{
    private $searchService;
    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }
    public function index()
    {
        $sets =  SwSet::where('is_active',1)->get();
        
        return view('front.sw.expansion.index',compact('sets'));
    }

    public function set($slug)
    {
        $set =  SwSet::where('slug',$slug)->firstOrFail();
        return view('front.sw.expansion.set',compact('set','slug'));
    }

    public function type($slug , $type)
    {
        $request = request();
        $pagination = $request->pagination ? $request->pagination : 9;
        $searchType = '';
        $arr=cardTypeSlug();
        $type = array_key_exists($type , $arr) ? $arr[$type]  : null;
        if(!$type)
        {
            abort(404);
        }
        $set =  SwSet::where('slug',$slug)->firstOrFail();
        $seo = SwSetSeo::where('sw_set_id',$set->id)->where('type',$type)->first();
        $list = $this->searchService->searchList($request,$set,$type);
        $tab_type = $request->tab_type ?? 'best_price';

        if($request->ajax())
        {
            $view = view('front.sw.expansion.components.expansionTabs',get_defined_vars())->render();
            return response()->json(['html' => $view]);
        }
        return view('front.sw.expansion.type',get_defined_vars());
        
    }

    public function detail(Request $request,$set_slug, $type , $slug)
    {
        // dd($request);
        $arr=cardTypeSlug();
        $type = array_key_exists($type , $arr) ? $arr[$type]  : null;
        if(!$type)
        {
            abort(404);
        }
        $item = SwCard::where('slug',$slug)->where('card_type',$type)->whereHas('set',function($q)use($set_slug){
            $q->where('slug',$set_slug);
        })->firstOrFail();

        $order = request()->order ? request()->order : 'asc';
        $listings = SwUserCollection::where('sw_card_id',$item->id)
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
        
        return view('front.sw.expansion.detail',compact('item'));
    }
}

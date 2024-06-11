<?php

namespace App\Http\Controllers\Front\SW;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SW\SwCard;
use App\Services\SW\SearchService;

class SearchController extends Controller
{
    private $searchService;
    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }
 
     public function generalSearch(Request $request)
     {
        $tabb = $request->tabb ?? 'item';
        list($items,$item_count,$sets,$set_count,$users,$user_count) = $this->searchService->generalSearch($request);
        $view  = view('front.sw.search.components.searchCard',get_defined_vars())->render();
        return response()->json(['html' => $view]);
     }

     public function detailedSearch(Request $request)
     {
         $att = $request->attribute;
         $searchType = 'detailed';
         $tab_type = $request->tab_type ?? 'best_price';
         $search = $this->searchService->detailedSearch($request);
         
         $list = $search->list;
         $count = $search->count;
         if($request->ajax())
         {
             $view = view('front.sw.expansion.components.expansionTabs',compact('list','tab_type','request'))->render();
             return response()->json(['html' => $view]);
         }
         return  view('front.sw.search.items.list',get_defined_vars());
     }

    public function sepecificSearch(Request $request,$type)
    {
        if($request->keyword)
        {
            $count = 0;
            $detailSearch = 'true';
            $searchType = 'single';
            $tab_type = $request->tab_type ?? 'best_price';
            $pagination = $request->pagination ? $request->pagination : 9;
            if($type == 'items')
            {
                // $count = SwCard::whereNull('parent_id')->count();
                $request->merge(['pagination'=>$pagination]); 
                $list = $this->searchService->searchList($request);
                $count = count($list);

            }
            if($request->ajax())
            {
                $view = view('front.sw.expansion.components.expansionTabs',compact('list','tab_type','request'))->render();
                return response()->json(['html' => $view]);
            }
            return  view('front.sw.search.items.list',get_defined_vars());
        }
        else{
            abort(404);
        }

    }
}

<?php
namespace App\Http\Controllers\Front\MTG;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MTG\MtgCard;
use App\Models\MTG\MtgSet;
use App\Models\User;
use App\Services\Front\Expansions\SearchService;

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
       $keyword = $request->keyword;
       $items = MtgCard::active()->whereHas('set')
                                    ->whereRaw('LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(name, " // " , " "), "\'s", ""), "s\'", "") ,"-" , " ") ,"," , "")) LIKE ?',['%' . $keyword . '%' ]);
       $item_count = $items->count();
       $items = $items->orderBy('created_at','desc')->inRandomOrder()->take(30)->get();
       $sets = MtgSet::active()->where('name', 'like', '%' . $keyword. '%');
       $set_count = $sets->count();
       $sets = $sets->orderBy('created_at','desc')->take(10)->get();
       
       
       $users = User::where('role','!=','admin')->where('status','!=','deleted')->where('user_name', 'like', '%' . $keyword. '%');
       $user_count = $users->count();
       $users = $users->where('role','!=','admin')->take(10)->get();
       $view  = view('front.mtg.search.components.searchCard',get_defined_vars())->render();
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
            $view = view('front.mtg.expansion.components.expansionTabs',compact('list','tab_type','request'))->render();
            return response()->json(['html' => $view]);
        }
        return  view('front.mtg.search.list',get_defined_vars());
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
                $count = MtgCard::active()->with(['set','collections'])->whereHas('set')
                                ->when($request->keyword,function($q)use($request){
                                    $q->whereRaw('LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(name, " // " , " "), "\'s", ""), "s\'", "") ,"-" , " ") ,"," , "")) LIKE ?',['%' . $request->keyword . '%' ]);
                                })
                                ->when($request->item == "versions",function($q)use($request){
                                    $q->where('name',$request->keyword);
                                })->count();
                $request->merge(['pagination'=>$pagination]); 
                $list = $this->searchService->searchList($request);
            }
            if($request->ajax())
            {
                $view = view('front.mtg.expansion.components.expansionTabs',compact('list','tab_type','request'))->render();
                return response()->json(['html' => $view]);
            }
            return  view('front.mtg.search.items.list',get_defined_vars());
        }
        else{
            abort(404);
        }

    }
}

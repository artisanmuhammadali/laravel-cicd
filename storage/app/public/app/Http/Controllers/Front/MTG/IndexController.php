<?php

namespace App\Http\Controllers\Front\MTG;
use App\Models\MTG\MtgSet;
use App\Http\Controllers\Controller;
use App\Models\MTG\MtgStandardSet;
use App\Models\MTG\MtgUserCollection;
use App\Models\User;
use App\Services\Front\Mtg\MarketplaceService;

class IndexController extends Controller
{
    public function index()
    {
        $standard = MtgStandardSet::all();
        $recents = MtgSet::active()->where('type','!=','child')->latest('released_at')->take(8)->get();
        $request = request();
        $limit = 10;
        $latestUsers = MtgUserCollection::check()->where('publish',1)->orderBy('id','desc')->groupBy('user_id')->take(10)->pluck('user_id')->toArray();
        $featuredUsers = MtgUserCollection::check()->where('publish',1)->where('price','>=',10)->orderBy('id','desc')->groupBy('user_id')->take(10)->pluck('user_id')->toArray();
        $page = 'magicTheGathering';
        return view('front.mtg.index',compact('page'),get_defined_vars());
    } 

    public function newlyCollectionType($type)
    {
        $request = request();
        $limit = 50;
        $latestUsers = MtgUserCollection::check()->where('publish',1)->orderBy('id','desc')->groupBy('user_id')->take(50)->pluck('user_id')->toArray();

        $collections = mtgListingCollections($type , 'new', $request , $latestUsers , $limit);

        if($request->ajax()){
            $html = view('front.components.collection.newly-added',get_defined_vars())->render();
            return response()->json(['html'=>$html]);
        }
        return view('front.mtg.newly-collection',get_defined_vars());
    } 

    public function featuredItemsType($type){
        $request = request();
       
        $limit = 50;
        $total_count = 0;
        $latestUsers = MtgUserCollection::check()->where('publish',1)->where('price','>=',5)->orderBy('id','desc')->groupBy('user_id')->take(50)->pluck('user_id')->toArray();

        $collections = mtgListingCollections($type , 'featured', $request , $latestUsers , $limit);

        if($request->ajax()){
            $html = view('front.components.collection.newly-added',get_defined_vars())->render();
            return response()->json(['html'=>$html]);
        }
        return view('front.mtg.featured-items',get_defined_vars());
    } 
    
    public function detailedSearch()
    {
        return view('front.mtg.detailedSearch');
    } 

    public function marketplace($type , MarketplaceService $service)
    {
        $request = request();
        $tab_type = $request->tab_type ?? 'list_view';
        $seo_title = ucwords(str_replace('-' , ' ', $type));
        $title = 'Available MTG ' .  $seo_title .' | VFS Card Market';
        $description = 'Find all of the MTG '.$seo_title.' available on our UK-exclusive card market, today';
        $h1 = 'Available MTG '.$seo_title;
        $collections = $service->search($request , $type);

        if($request->ajax()){
            $html = view('front.mtg.marketplace.components.tabs',get_defined_vars())->render();
            return response()->json(['html'=>$html]);
        }

        return view('front.mtg.marketplace.index',get_defined_vars());
    } 
}

<?php

namespace App\Http\Controllers\User\SW;

use App\Http\Requests\User\SaveCollectionRequest;
use App\Services\SW\CollectionSearchService;
use App\Services\SW\CollectionService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SW\SwCard;
use App\Models\SW\SwSet;
use App\Models\SW\SwUserCollection;
use App\Models\User;

class SwCollectionController extends Controller
{
    private $manageCollection;
    public function __construct(CollectionService $manageCollection)
    {
        $this->manageCollection = $manageCollection;
    }

    public function searchCards(Request $request)
    {
        $list = SwCard::active()->where('name', 'like', '%' . $request->keyword. '%')->where('card_type',$request->card_type)->latest()->get();
        $count = count($list);
        $view  = view('user.sw.collection.search.list',get_defined_vars())->render();
 
        return response()->json(['html' => $view , 'count'=>$count]);
    }

    public function renderViews(Request $request)
    {
        $html = $this->manageCollection->renderList($request);
        return response()->json(['html'=>$html]);
    }
    
    public function index(Request $request ,CollectionSearchService $search,$type= 'single')
    {
        $sets = SwSet::whereHas('cards',function($q)use($type){
            $q->where('card_type',$type);
        })->get(['name','code']);
        $user = User::find(auth()->user()->id);
        $limit = $request->limit ?? 10;
        list($list,$active_sum,$inactive_sum) = $search->searchList($request,$type);
       
        if($request->ajax())
        {
            $view = view('user.sw.collection.components.table',get_defined_vars())->render();
            return response()->json(['html' => $view,'active' => $active_sum,'inactive' => $inactive_sum]);
        }
        if($user->store->kyc_payment == 0)
        {
            checkUseKYCPayment();
            $user->refresh();
        }
        return view('user.sw.collection.index',get_defined_vars());
    }

    public function save(SaveCollectionRequest $request)
    {
        $response = $this->manageCollection->requestHandler($request);
        $msg = $request->id ? "Updated Successfully!" : "Added Successfully!";
       
        if($request->ajax()){
            if($request->form_type == "publish")
            {
                return response()->json(['success' => 'Updated Successfully!']);
            }
            $redirect = route('user.collection.sw.index',$request->card_type);
            return response()->json(['table'=> '1', 'modal'=>$redirect,'success' => $msg ,'response'=>$response]);
        }

        return redirect()->back()->with('success', $msg);
    }

    public function bulkUpload($type)
    {
        $sets = SwSet::whereHas('cards',function($q)use($type){
            $q->where('card_type',$type);
        })->get(['name','code']);

        return view('user.sw.collection.bulk',get_defined_vars());
    }

    public function csvUpload($type)
    {
        // if(route('index') == 'https://beta.veryfriendlysharks.co.uk' || route('index') == 'http://127.0.0.1:8000')
        // {
            $status = ['pending','processing'];
            $list = MtgUserCollectionCsv::where('user_id',auth()->user()->id)->where('mtg_card_type',$type)->latest()->get();
            $pending = MtgUserCollectionCsv::where('user_id',auth()->user()->id)->whereIn('status',$status)->count();
            return view('user.collection.csv',get_defined_vars());    
        // }
        // return redirect()->back()->with('error','This function is currently down for maintenance. Sorry for inconvenience!');
    }
   
    public function edit(Request $request)
    {
        $is_bulk = $request->is_bulk;
        $item = SwUserCollection::find($request->id);
        $html = view('user.sw.collection.components.edit',get_defined_vars())->render();

        return response()->json(['html'=>$html]);
    }

    public function delete(Request $request,CollectionSearchService $search)
    {
        $ids = $request->form_type ? $request->ids : [$request->id];
        $list = $request->is_all ? $search->searchList($request,$request->set_type,'all') : SwUserCollection::whereIn('id',$ids)->get();
        $list->map(function ($listt)use($request) {
            $listt->delete();
       });

       if($request->ajax())
       {
        return response()->json(['success'=>'Collection Deleted Successfully!']);

       }
       return redirect()->back()->with('success', 'Collection Deleted Successfully!');

    }
    public function updatePrice(Request $request,CollectionSearchService $search)
    {
        if(!$request->percent || $request->percent<=0){
            return response()->json(['error' => 'Percentage  is required. and must be greater than 0']);
        }
        if($request->operation == 'decrement' &&  $request->percent > 95)
        {
            return response()->json(['error' => 'Percentage cannot be greater than 95%!']);
        }

        $type = $request->set_type ?? 'single';
        $ids = $request->ids;
        $collections = $request->is_all != 0 ? $search->searchList($request,$type,'all') : SwUserCollection::whereIn('id',$ids)->get(['id','price']);
        $percentage = (float)$request->percent;
        foreach($collections as $collection)
        {
            $obtain = ($percentage/100) * $collection->price;
            $collection->price = $request->operation == 'increment' ? $collection->price + $obtain : $collection->price-$obtain;
            $collection->save();
        }

        return response()->json(['success' => 'Collection Price Updated Successfully!']);
    }
}

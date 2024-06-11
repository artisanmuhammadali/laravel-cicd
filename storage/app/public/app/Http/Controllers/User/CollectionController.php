<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\SaveCollectionRequest;
use App\Models\MTG\MtgCard;
use App\Models\MTG\MtgSet;
use App\Models\MTG\MtgUserCollection;
use App\Models\MTG\MtgUserCollectionCsv;
use App\Models\User;
use App\Models\UserStore;
use Illuminate\Support\Arr;
use App\Services\User\CollectionService;
use Illuminate\Http\Request;
use App\Services\User\CollectionSearchService;
use App\Services\User\MangoPayService;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Facades\Validator;

class CollectionController extends Controller
{
    private $manageCollection;
    private $mangopay;
    public function __construct(CollectionService $manageCollection , MangoPayService $mangopay)
    {
        $this->manageCollection = $manageCollection;
        $this->mangopay = $mangopay;

    }
    public function index(Request $request  ,CollectionSearchService $search ,$type= 'single')
    {
        $sets = MtgSet::active()->whereHas('cards',function($q)use($type){
            $q->where('card_type',$type);
        })->get(['name','code']);
        $user = User::find(auth()->user()->id);
        $limit = $request->limit ?? 10;
        list($list,$active_sum,$inactive_sum) = $search->searchList($request,$type);
        if($user->role == "buyer")
        {
            return redirect()->back()->with('error','Please Register as seller to view collection.');
        }
        if($request->ajax())
        {
            $view = view('user.components.collection.table',get_defined_vars())->render();
            return response()->json(['html' => $view,'active' => $active_sum,'inactive' => $inactive_sum]);
        }
        if($user->store->kyc_payment == 0)
        {
            checkUseKYCPayment();
            $user->refresh();
        }
        return view('user.collection.index',get_defined_vars());
    }

    public function renderViews(Request $request)
    {
        // dd($request->all());
        $html = $this->manageCollection->requestHandler($request);
        return response()->json(['html'=>$html]);

    }
    public function bulkUpload($type)
    {
        $sets = MtgSet::active()->whereHas('cards',function($q)use($type){
            $q->where('card_type',$type);
        })->get(['name','code']);
        return view('user.collection.bulk',get_defined_vars());
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
    public function save(SaveCollectionRequest $request)
    {
                  
        $response = $this->manageCollection->requestHandler($request);

        $msg = $request->id ? "Updated Successfully!" : "Added Successfully!";
        $msg = $request->form_type == "csv" ? "Your file uploaded successfully, However this process may take some time. We will notify you through email once it's done." : $msg;
        if($request->ajax()){
            if($request->form_type == "publish")
            {
                return response()->json(['success' => 'Updated Successfully!' , 'has_inactive'=> !$response]);
            }
            $response = $request->form_type == "csv" ? view('user.components.collection.csvError',get_defined_vars())->render():$response;
            $reload = $request->mtg_card_type ? false : true;
            if($request->is_bulk)
            {
                return response()->json(['success' => $msg]);
            }
            $redirect = route('user.collection.index',$request->card_type);
            return response()->json(['table'=> '1', 'modal'=>$redirect,'success' => $msg , 'reload'=>$reload , 'response'=>$response]);
        }
        return redirect()->back()->with('success', $msg);

    }
    public function edit(Request $request)
    {
        $is_bulk = $request->is_bulk;
        $item = MtgUserCollection::find($request->id);
        $html = view('user.components.collection.edit',get_defined_vars())->render();

        return response()->json(['html'=>$html]);
    }
    public function delete(Request $request,CollectionSearchService $search)
    {
        $ids = $request->form_type ? $request->ids : [$request->id];
        $list = $request->is_all ? $search->searchList($request,$request->set_type,'all') : MtgUserCollection::whereIn('id',$ids)->get();
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
        if($request->type == "popup")
        {
            $p = $request->show_inactive_modal == "on" ? 1 : 0;
            UserStore::where('user_id',auth()->user()->id)->update(['show_inactive_modal'=>$p]);
            return redirect()->back()->with('success','Your setting has updated successfully!');
        }

        if(!$request->percent || $request->percent<=0){
            return response()->json(['error' => 'Percentage  is required. and must be greater than 0']);
        }
        if($request->operation == 'decrement' &&  $request->percent > 95)
        {
            return response()->json(['error' => 'Percentage cannot be greater than 95%!']);
        }

        $type = $request->set_type ?? 'single';
        $ids = $request->ids;
        $collections = $request->is_all != 0 ? $search->searchList($request,$type,'all') : MtgUserCollection::whereIn('id',$ids)->get(['id','price']);
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

<?php

namespace App\Http\Controllers\Front\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\OrderReview;
use App\Models\UserStore;
use App\Models\MTG\MtgUserCollection;
use App\Models\Order;
use App\Services\Front\Profile\UserCollectionService;
use Illuminate\Http\Request;


class ProfileController extends Controller
{
    private $manageCollection;
    public function __construct(UserCollectionService $manageCollection)
    {
        $this->manageCollection = $manageCollection;
    }
    public function index($name,$type = 'single')
    {
        $user = User::where('user_name',$name)->firstOrFail();
        if(!$user || auth()->user() && auth()->user()->user_name == $name  && !request()->view || $user->role == 'admin'){
            return redirect()->route('user.account');
        }
        if($user->status == "deleted")
        {
            abort(404);
        }

        $request = request();
        $count = MtgUserCollection::where('user_id',$user->id)
                                    ->where('mtg_card_type',$type)
                                    ->where('quantity','>','0')
                                    ->where('publish',1)->count();
        $list = $user->block_by_auth || check_auth_block($user->id) ? [] : $this->manageCollection->searchList($request , $user, $type);
        if($request->ajax())
        {
            $html = view('front.user.components.collection-tab',get_defined_vars())->render();
            return response()->json(['html'=>$html]);
        }
        return view('front.user.user-detail', get_defined_vars());
    }

    function renderReviews(Request $request)
    {
        $user = User::where('id',$request->id)->firstOrFail();
        $buyer_orders = Order::where('buyer_id',$request->id)->pluck('id')->toArray();
        $seller_orders = Order::where('seller_id',$request->id)->pluck('id')->toArray();
        $reviews = OrderReview::where('review_to',$user->id)
        ->when($request->sort == 'high',function($q){
            $q->orderBy('rating','desc');
        })
        ->when($request->sort == 'low',function($q){
            $q->orderBy('rating','asc');
        })
        ->when($request->sort == 'recents',function($q){
            $q->orderBy('created_at','desc');
        })
        ->when($request->type == 'buyer',function($q)use($buyer_orders){
            $q->whereIn('order_id',$buyer_orders);
        })
        ->when($request->type == 'seller',function($q)use($seller_orders){
            $q->whereIn('order_id',$seller_orders);
        })->paginate(25);
        $view  = view('front.user.components.reviews',get_defined_vars())->render();

        return response()->json(['html' => $view]);
    }

     public function unsubscribe($email)
    {
        $user = User::where('email',base64_decode($email))->first();
        if(!$user)
        {
            return redirect()->route('index')->with('error','User Not Found');
        }
        UserStore::where('user_id',$user->id)->update(['newsletter'=> null]);
        return redirect()->route('index')->with('success','You have successfully unsubscribed from our newsletter. We’re sad to see you go, but we respect your choice!');
    }
}

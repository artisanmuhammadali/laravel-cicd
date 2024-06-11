<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\User\AccountStatService;
use Carbon\Carbon;
use App\Models\MTG\MtgUserCollection;
use App\Models\Order;

class AccountStatsController extends Controller
{
    public function index(AccountStatService $stats)
    {
        $request = request();

        $type = $request->type ?? 'daily';
        list($start,$end) = $request->has('date') ?  getDateRange($request->date) : [Carbon::now()->subDays(60) ,Carbon::now()] ;
        $date = $start.' to '. $end;

        $user = auth()->user();

        list($dates, $spendingData) = $stats->userSpending($type , $start , $end);
        list($earningDates , $earningData) = $stats->userEarning($type , $start , $end);

        $spendingArray = userStatsArray($dates , $spendingData , 'Spendings');
        $earningArray = userStatsArray($earningDates , $earningData , 'Earnings');
        
        $sale = Order::where('seller_id',$user->id)->where('status','completed');
        $order_sale = $sale->count();

        $purchase = Order::where('buyer_id',$user->id);
        $order_purchase  =$purchase->count();

        $collection = MtgUserCollection::where('user_id',$user->id)->count();

        $spending = $purchase->sum('total');

        $earning = userEarning($user->id);

        $liquidity = liquidityRate('user', $user->id);

        $data = [];
        return view('user.account-stats' ,get_defined_vars());
    }
    public function export(Request $request)
    {
        $type = $request->type;
        $data = json_decode($request->json);
        $html = view('user.components.stats.table-data',get_defined_vars())->render();
        return response()->json(['html'=>$html]);
    }
}

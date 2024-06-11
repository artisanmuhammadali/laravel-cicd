<?php

namespace App\Services\User;

use App\Models\Order;
use App\Models\Postage;
use Carbon\Carbon;

class AccountStatService {

    public function userSpending($type , $start , $end)
    {
        $endDate = Carbon::parse($end);
        $startDate = Carbon::parse($start);
        $data = Order::where('buyer_id',auth()->user()->id)
                ->whereDate('created_at','>=',$startDate)
                ->whereDate('created_at','<=',$endDate)
                ->selectRaw('DATE(created_at) as daily,Date_FORMAT(created_at, "%Y") as yearly,Date_FORMAT(created_at, "%Y/%m") as monthly, SUM(total) as spendings')
                ->groupBy('daily')
                ->orderBy('created_at','desc')->get()->groupBy($type);
        $values = [];
        foreach($data as $spendings)
        {
            $values[] = $spendings->sum('spendings');
        }
        $dates = array_keys($data->toArray());    
        return [$dates , $values];
        
    }
    public function userEarning($type , $start , $end)
    {
        $endDate = Carbon::parse($end);
        $startDate = Carbon::parse($start);
        $data = Order::where('seller_id',auth()->user()->id)
                ->where('status','completed')
                ->whereDate('created_at','>=',$startDate)
                ->whereDate('created_at','<=',$endDate)
                ->selectRaw('DATE(created_at) as daily,Date_FORMAT(created_at, "%Y") as yearly,Date_FORMAT(created_at, "%Y/%m") as monthly, GROUP_CONCAT(DISTINCT postage_id) as postages, SUM(total) as earnings')
                ->groupBy('daily')
                ->orderBy('created_at','desc')->get()->groupBy($type);
        $dates = array_keys($data->toArray());        
        $earningData = [];
        foreach($data as $earnings)
        {
            $sum = $earnings->sum('earnings');
            $postages = $earnings->pluck('postages')->toArray();
            $post = [];
            foreach($postages as $postage)
            {
                $post[] = explode(',',$postage);
            }
            $postage_ids= array_merge(...$post);
            $postages_price = Postage::whereIn('id',$postage_ids)->sum('price');

            $amount = $sum - $postages_price;
            $pspConfig = vsfPspConfig();
            $fee=  $amount* ($pspConfig->platform_fee /100);
            $vat=  ($pspConfig->vat_percentage/100) * $amount;
            $total_commision = $vat + $fee;
            $total= $sum - $total_commision;

            $earningData[] = $total;
        }

        return [$dates , $earningData];
    }
}

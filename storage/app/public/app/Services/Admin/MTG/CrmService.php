<?php

namespace App\Services\Admin\MTG;

use App\Models\Visitor;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Transaction;
use App\Models\Postage;
use App\Models\MTG\MtgUserCollection;
use Carbon\Carbon;

class CrmService {

    public function visitors($type,$start,$end)
    {
       return  Visitor::whereDate('created_at','>=',$start)->whereDate('created_at','<=',$end)->selectRaw('DATE(created_at) as daily,Date_FORMAT(created_at, "%Y") as yearly,Date_FORMAT(created_at, "%Y/%m") as monthly, COUNT(DISTINCT ip) as total_visitors')
        ->groupBy('daily')
        ->orderBy('created_at','desc')->get()->groupBy($type);
    }

    public function visitorCharts()
    {
        $startDate = Carbon::now()->subDays(365);
        $endDate = Carbon::now();
        $data = [];
        while ($startDate->lte($endDate)) {
            $count =  Visitor::whereDate('created_at',$startDate)->groupBy('ip')->get();
            $data[] = [$startDate->timestamp * 1000,$count->count()];
            $startDate->addDay();
        }
        return $data;
    }

    public function rgisteredUsers($type,$start,$end)
    {
       $seller =  User::where('role','seller')->whereDate('created_at','>=',$start)->whereDate('created_at','<=',$end)->selectRaw('DATE(created_at) as daily,Date_FORMAT(created_at, "%Y") as yearly,Date_FORMAT(created_at, "%Y/%m") as monthly, COUNT(id) as total_users')
        ->groupBy('daily')
        ->orderBy('created_at','desc')->get()->groupBy($type);

       $buyer =  User::where('role','buyer')->whereDate('created_at','>=',$start)->whereDate('created_at','<=',$end)->selectRaw('DATE(created_at) as daily,Date_FORMAT(created_at, "%Y") as yearly,Date_FORMAT(created_at, "%Y/%m") as monthly, COUNT(id) as total_users')
        ->groupBy('daily')
        ->orderBy('created_at','desc')->get()->groupBy($type);

       $both =  User::where('role','business')->whereDate('created_at','>=',$start)->whereDate('created_at','<=',$end)->selectRaw('DATE(created_at) as daily,Date_FORMAT(created_at, "%Y") as yearly,Date_FORMAT(created_at, "%Y/%m") as monthly, COUNT(id) as total_users')
        ->groupBy('daily')
        ->orderBy('created_at','desc')->get()->groupBy($type);

       $refered =  User::where('referr_by','!=',null)->whereDate('created_at','>=',$start)->whereDate('created_at','<=',$end)->selectRaw('DATE(created_at) as daily,Date_FORMAT(created_at, "%Y") as yearly,Date_FORMAT(created_at, "%Y/%m") as monthly, COUNT(id) as total_users')
        ->groupBy('daily')
        ->orderBy('created_at','desc')->get()->groupBy($type);

        $referee =  User::whereHas('referredUsers')->whereDate('created_at','>=',$start)->whereDate('created_at','<=',$end)->selectRaw('DATE(created_at) as daily,Date_FORMAT(created_at, "%Y") as yearly,Date_FORMAT(created_at, "%Y/%m") as monthly, COUNT(id) as total_users')
        ->groupBy('daily')
        ->orderBy('created_at','desc')->get()->groupBy($type);

        return [$seller,$buyer,$both,$refered,$referee];
    }

    public function accountRegistrationCharts($start,$end)
    {
        $startDate = Carbon::parse($start);
        $endDate = Carbon::parse($end);
        $sellersData = [];
        $buyerData = [];
        $bothData = [];
        $referedData = [];
        $refereeData = [];
        $dates = [];
        while ($startDate->lte($endDate)) {
            $dates[] = $startDate->format('d/m');
            $count =  User::where('role','seller')->whereDate('created_at',$startDate)->count();
            $sellersData[] = $count;

            $count =  User::where('role','buyer')->whereDate('created_at',$startDate)->count();
            $buyerData[] = $count;

            $count =  User::where('role','business')->whereDate('created_at',$startDate)->count();
            $bothData[] = $count;

            $count =  User::where('referr_by','!=',null)->whereDate('created_at',$startDate)->count();
            $referedData[] = $count;

            $count =  User::whereHas('referredUsers')->whereDate('created_at',$startDate)->count();
            $refereeData[] = $count;

            $startDate->addDay();
        }

        return [$sellersData,$buyerData,$bothData,$referedData,$refereeData,$dates];
    }

    public function deletedUsers($type,$start,$end)
    {
       return  User::onlyTrashed()->whereNotNull('deleted_at')->whereDate('deleted_at','>=',$start)->whereDate('deleted_at','<=',$end)->selectRaw('DATE(deleted_at) as daily,Date_FORMAT(deleted_at, "%Y") as yearly,Date_FORMAT(deleted_at, "%Y/%m") as monthly, COUNT(id) as total_users')
        ->groupBy('daily')
        ->orderBy('deleted_at','desc')->get()->groupBy($type);
    }

    public function deletedUserCharts($start,$end)
    {
        $startDate = Carbon::parse($start);
        $endDate = Carbon::parse($end);
        $usersData = [];
        $dates = [];
        while ($startDate->lte($endDate)) {
            $dates[] = $startDate->format('d/m');
            $count =  User::onlyTrashed()->whereNotNull('deleted_at')->whereDate('deleted_at',$startDate)->count();
            $usersData[] = $count;

            $startDate->addDay();
        }

        return [$usersData,$dates];
    }

    public function collections($type,$start,$end)
    {
       $collections =  MtgUserCollection::where('publish',0)->whereDate('created_at','>=',$start)->whereDate('created_at','<=',$end)->selectRaw('DATE(created_at) as daily,Date_FORMAT(created_at, "%Y") as yearly,Date_FORMAT(created_at, "%Y/%m") as monthly, COUNT(id) as total_collections')
        ->groupBy('daily')
        ->orderBy('created_at','desc')->get()->groupBy($type);
        
       $listings =  MtgUserCollection::where('publish',1)->whereDate('created_at','>=',$start)->whereDate('created_at','<=',$end)->selectRaw('DATE(created_at) as daily,Date_FORMAT(created_at, "%Y") as yearly,Date_FORMAT(created_at, "%Y/%m") as monthly, COUNT(id) as total_collections')
        ->groupBy('daily')
        ->orderBy('created_at','desc')->get()->groupBy($type);

        return [$collections,$listings];
    }

    public function deletedUserList($start,$end)
    {
        return User::whereNotNull('deleted_at')->whereDate('deleted_at','>=',$start)->whereDate('deleted_at','<=',$end)->latest('deleted_at')->get();
    }
   
    public function disputeUserList($start,$end)
    {
        return User::whereHas('sellingOrders',function($q)use($start,$end){
            $q->where('reason','!=',null);
        })->withCount(['sellingOrders' => function ($query) {
            $query->where('reason','!=',null);
        }])->get();
    }
    public function orderCancelUserList($start,$end)
    {
        return User::where('role','!=','admin')->whereHas('cancelledBy')->withCount('cancelledBy')->get();
    }

    public function protectionUserList($start,$end)
    {
        return User::whereIn('role',['buyer','seller','business'])->where(function($que){
            $que->whereHas('reportTo',function($q){
                $q->where('category',4);
              })->orWhereHas('cancelledBy');
        })->get();
    }
    public function reviewUserList($start,$end)
    {
        return User::whereHas('reviews',function($q){
            $q->selectRaw('review_to, AVG(rating) as avg_rating')
            ->groupBy('review_to')
            ->having('avg_rating', '<', 4);
        })->get();
    }

    public function collectionCharts($start,$end)
    {
        $startDate = Carbon::parse($start);
        $endDate = Carbon::parse($end);
        $colelctionsData = [];
        $listingData = [];
        $dates = [];
        while ($startDate->lte($endDate)) {
            $dates[] = $startDate->format('d/m');
            $count =  MtgUserCollection::where('publish',0)->whereDate('created_at',$startDate)->count();
            $colelctionsData[] = $count;
            $count =  MtgUserCollection::where('publish',1)->whereDate('created_at',$startDate)->count();
            $listingData[] = $count;

            $startDate->addDay();
        }

        return [$colelctionsData,$listingData,$dates];
    }

    public function conversionRate($type,$start,$end)
    {
        $visitors = Visitor::whereDate('created_at','>=',$start)->whereDate('created_at','<=',$end)->selectRaw('DATE(created_at) as daily,Date_FORMAT(created_at, "%Y") as yearly,Date_FORMAT(created_at, "%Y/%m") as monthly, COUNT(*) as total_visitors')
        ->groupBy('daily')
        ->orderBy('created_at','desc')->get()->groupBy($type);

        $users = User::whereDate('created_at','>=',$start)->whereDate('created_at','<=',$end)->selectRaw('DATE(created_at) as daily,Date_FORMAT(created_at, "%Y") as yearly,Date_FORMAT(created_at, "%Y/%m") as monthly, COUNT(id) as total_users')
        ->groupBy('daily')
        ->orderBy('created_at','desc')->get()->groupBy($type);

        $data =[];
        foreach($visitors as $key => $v)
        {
            $vis = $v->sum('total_visitors');
            $u = 0;
            if(isset($users[$key]))
            {
              $u = $users[$key]->sum('total_users');
            }

            $data[] = ['key' => $key,'visitors' => $vis,'users' => $u, 'ratio' => ($u/$vis)/100];

        }
        return $data;
    }

    public function conversionRateCharts($start,$end)
    {
        $startDate = Carbon::parse($start);
        $endDate = Carbon::parse($end);
        $userData = [];
        $visitorData = [];
        $percentage = [];
        $dates = [];
        while ($startDate->lte($endDate)) {
            $dates[] = $startDate->format('d/m');
            $count =  User::whereDate('created_at',$startDate)->count();
            $userData[] = $count;

            $count1 = Visitor::whereDate('created_at',$startDate)->groupBy('ip')->count();
            $visitorData[] = $count1;

            $percentage[] = $count1 > 0 ? ($count/$count1)/100 : 0;

            $startDate->addDay();
        }

        return [$userData,$visitorData,$percentage,$dates];
    }
    public function sellerToBuyerRatio($type,$start,$end)
    {
        $sellers = User::where('role','seller')->where('status','active')->whereDate('created_at','>=',$start)->whereDate('created_at','<=',$end)->selectRaw('DATE(created_at) as daily,Date_FORMAT(created_at, "%Y") as yearly,Date_FORMAT(created_at, "%Y/%m") as monthly, COUNT(id) as total_sellers')
        ->groupBy('daily')
        ->orderBy('created_at','desc')->get()->groupBy($type);
        $buyers = User::where('role','buyer')->where('status','active')->whereDate('created_at','>=',$start)->whereDate('created_at','<=',$end)->selectRaw('DATE(created_at) as daily,Date_FORMAT(created_at, "%Y") as yearly,Date_FORMAT(created_at, "%Y/%m") as monthly, COUNT(*) as total_buyers')
        ->groupBy('daily')
        ->orderBy('created_at','desc')->get()->groupBy($type);

        $keys1 = array_keys($sellers->toArray());
        $keys2 = array_keys($buyers->toArray());
        $combinedArray = array_merge($keys1, $keys2);
        $unionOfArrays = array_unique($combinedArray);

        $data = [];

        foreach($unionOfArrays as $date)
        {
            $s = isset($sellers[$date]) ? $sellers[$date]->count() : 0;
            $b = isset($buyers[$date]) ? $buyers[$date]->count() : 0;

            $data[] = ['seller' => $s, 'buyer' => $b, 'area' => $date, 'ratio' => $s>0 ? ($b/$s) * 100 : 0];
        }
        return $data;
    }

    public function sellerToBuyerRatioCharts($start,$end)
    {
        $startDate = Carbon::parse($start);
        $endDate = Carbon::parse($end);
        $buyerData = [];
        $sellersData = [];
        $percentage = [];
        $dates = [];
        while ($startDate->lte($endDate)) {
            $dates[] = $startDate->format('d/m');
            $count1 =  User::where('role','seller')->where('status','active')->whereDate('created_at',$startDate)->count();
            $sellersData[] = $count1;
            $count =  User::where('role','buyer')->where('status','active')->whereDate('created_at',$startDate)->count();
            $buyerData[] = $count;
            $percentage[] = $count1 > 0 ? ($count/$count1)/100 : 0;
            $startDate->addDay();
        }

        return [$buyerData,$sellersData,$percentage,$dates];
    }

    public function garbage()
    {
        return  Visitor::when($type == 'daily',function($q){
            $q->selectRaw('DATE(created_at) as daily,Date_FORMAT(created_at, "%Y") as yearly,Date_FORMAT(created_at, "%Y/%m") as monthly, COUNT(DISTINCT ip) as total_visitors');
        })
        ->when($type == 'monthly',function($q){
            $q->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as visit_date, COUNT(DISTINCT ip) as total_visitors');
        })
        ->when($type == 'yearly',function($q){
            $q->selectRaw('YEAR(created_at) as visit_date, COUNT(DISTINCT ip) as total_visitors');
        })
        ->groupBy($type)
        ->orderBy('created_at','desc')->get()->groupBy($type);
    }
    public function checkout($type,$start,$end)
    {
       return  Order::whereDate('created_at','>=',$start)->whereDate('created_at','<=',$end)->selectRaw('DATE(created_at) as daily,Date_FORMAT(created_at, "%Y") as yearly,Date_FORMAT(created_at, "%Y/%m") as monthly, COUNT(DISTINCT id) as total_checkouts')
        ->groupBy('daily')
        ->orderBy('created_at','desc')->get()->groupBy($type);
    }

    public function checkoutCharts($start , $end)
    {
        $startDate = Carbon::parse($start);
        $endDate = Carbon::parse($end);
        $data = [];
        $dates = [];
        while ($startDate->lte($endDate)) {
            $dates[] = $startDate->format('d/m');
            $count =  Order::whereDate('created_at',$startDate)->count();
            $data[] = $count;

            $startDate->addDay();
        }

        return [$data,$dates];
    }
    public function buyerValue($type,$start,$end)
    {

       $total =   Order::whereDate('created_at','>=',$start)->whereDate('created_at','<=',$end)->selectRaw('DATE(created_at) as daily,Date_FORMAT(created_at, "%Y") as yearly,Date_FORMAT(created_at, "%Y/%m") as monthly, GROUP_CONCAT(DISTINCT buyer_id) as buyers, SUM(total) as total_value')
        ->groupBy('daily')
        ->orderBy('created_at','desc')->get()->groupBy($type);

       $average =   Order::whereDate('created_at','>=',$start)->whereDate('created_at','<=',$end)->selectRaw('DATE(created_at) as daily,Date_FORMAT(created_at, "%Y") as yearly,Date_FORMAT(created_at, "%Y/%m") as monthly, GROUP_CONCAT(DISTINCT buyer_id) as buyers, SUM(total) as total_value')
       ->groupBy('daily')
       ->orderBy('created_at','desc')->get()->groupBy($type);
       return [$total , $average];
    }

    public function buyerValueCharts($start , $end)
    {
        $startDate = Carbon::parse($start);
        $endDate = Carbon::parse($end);
        $totalData = [];
        $totalDates = [];
        $avgData = [];
        $avgDates = [];
        while ($startDate->lte($endDate)) {
            $totalDates[] = $startDate->format('d/m');
            $count =  Order::whereDate('created_at',$startDate)->sum('total');
            $totalData[] = $count;

            $avgDates[] = $startDate->format('d/m');
            $orders =  Order::whereDate('created_at',$startDate);
            $count = $orders->count() ? $orders->count() : 1;
            $avg = $orders->sum('total')/$count;
            $avg =  number_format((float)$avg, 2, '.', '');
            $avgData[] = $avg;

            $startDate->addDay();
        }
        return [$totalData,$totalDates , $avgData , $avgDates];
    }
    public function sellerValue($type,$start,$end)
    {
        $total=  Order::whereDate('created_at','>=',$start)->whereDate('created_at','<=',$end)->selectRaw('DATE(created_at) as daily,Date_FORMAT(created_at, "%Y") as yearly,Date_FORMAT(created_at, "%Y/%m") as monthly,GROUP_CONCAT(DISTINCT postage_id) as postages, SUM(total) as total_value')
        ->groupBy('daily')
        ->orderBy('created_at','desc')->get()->groupBy($type);

        $average=  Order::whereDate('created_at','>=',$start)->whereDate('created_at','<=',$end)->selectRaw('DATE(created_at) as daily,Date_FORMAT(created_at, "%Y") as yearly,Date_FORMAT(created_at, "%Y/%m") as monthly,GROUP_CONCAT(DISTINCT postage_id) as postages,GROUP_CONCAT(DISTINCT seller_id) as sellers, SUM(total) as total_value')
        ->groupBy('daily')
        ->orderBy('created_at','desc')->get()->groupBy($type);
        return [$total , $average];
    }

    public function sellerValueCharts($start , $end)
    {
        $startDate = Carbon::parse($start);
        $endDate = Carbon::parse($end);
        $totalData = [];
        $totalDates = [];
        $avgData = [];
        $avgDates = [];
        while ($startDate->lte($endDate)) {
            $totalDates[] = $startDate->format('d/m');
            $count =  Order::whereDate('created_at',$startDate)->sum('total');
            $totalData[] = $count;

            $avgDates[] = $startDate->format('d/m');
            $orders =  Order::whereDate('created_at',$startDate);
            $postages_id = $orders->pluck('postage_id');

            $postages_price = Postage::whereIn('id',$postages_id)->sum('price');
            $amount = $count - $postages_price;
            $pspConfig = vsfPspConfig();
            $fee=  $amount* ($pspConfig->platform_fee /100);
            $vat=  ($pspConfig->vat_percentage/100) * $amount;
            $total_commision = $vat + $fee;
            $total= $count - $total_commision;
            $seller_ids = $orders->pluck('seller_id')->unique();
            $count = count($seller_ids) ? count($seller_ids) : 1;
            $avg = $total/$count;
            $avg = number_format((float)$avg, 2, '.', '');
            $avgData[] = $avg;

            $startDate->addDay();
        }

        return [$totalData,$totalDates , $avgData , $avgDates];
    }
    public function revenueValue($type,$start,$end)
    {
        $value =  Transaction::whereNotNull('order_id')->whereDate('created_at','>=',$start)->whereDate('created_at','<=',$end)->selectRaw('DATE(created_at) as daily,Date_FORMAT(created_at, "%Y") as yearly,Date_FORMAT(created_at, "%Y/%m") as monthly, SUM(fee) as total_value')
        ->groupBy('daily')
        ->orderBy('created_at','desc')->get()->groupBy($type);

        return $value;
    }

    public function revenueValueCharts($start , $end)
    {
        $startDate = Carbon::parse($start);
        $endDate = Carbon::parse($end);
        $valueData = [];
        $valueDates = [];
        while ($startDate->lte($endDate)) {
            $valueDates[] = $startDate->format('d/m');
            $count =  Transaction::whereNotNull('order_id')->whereDate('created_at',$startDate)->sum('fee');
            $valueData[] = $count;

            $startDate->addDay();
        }

        return [$valueData,$valueDates];
    }


    public function transactionsValue($type,$start,$end)
    {
        $value =  Transaction::whereNotNull('order_id')->whereDate('created_at','>=',$start)->whereDate('created_at','<=',$end)->selectRaw('DATE(created_at) as daily,Date_FORMAT(created_at, "%Y") as yearly,Date_FORMAT(created_at, "%Y/%m") as monthly, SUM(seller_amount) as total_value, SUM(shiping_charges) as total_shipping,SUM(fee) as total_fee')
        ->groupBy('daily')
        ->orderBy('created_at','desc')->get()->groupBy($type);

        $traffic =  Transaction::whereNotNull('order_id')->whereDate('created_at','>=',$start)->whereDate('created_at','<=',$end)->selectRaw('DATE(created_at) as daily,Date_FORMAT(created_at, "%Y") as yearly,Date_FORMAT(created_at, "%Y/%m") as monthly, COUNT(DISTINCT id) as total_traffic')
        ->groupBy('daily')
        ->orderBy('created_at','desc')->get()->groupBy($type);
        return [$value , $traffic];
    }

    public function transactionsValueCharts($start , $end)
    {
        $startDate = Carbon::parse($start);
        $endDate = Carbon::parse($end);
        $valueData = [];
        $gmvData = [];
        $dates = [];
        $trafficData = [];
        while ($startDate->lte($endDate)) {
            $dates[] = $startDate->format('d/m');
            $resluts =  Transaction::whereNotNull('order_id')->whereDate('created_at',$startDate)->selectRaw('SUM(seller_amount) as total_value,SUM(fee) as total_fee, SUM(shiping_charges) as total_shipping')->get();
            $valueData[] = $resluts->sum('total_value') + $resluts->sum('total_fee') - $resluts->sum('total_shipping');
            $gmvData[] = $resluts->sum('total_value') + $resluts->sum('total_fee');

            $count =  Transaction::whereNotNull('order_id')->whereDate('created_at',$startDate)->count();
            $trafficData[] = $count;

            $startDate->addDay();
        }

        return [$valueData,$trafficData,$gmvData , $dates];
    }

    public function ordersValue($type,$start,$end)
    {
        return  Order::whereDate('created_at','>=',$start)->whereDate('created_at','<=',$end)->selectRaw('DATE(created_at) as daily,Date_FORMAT(created_at, "%Y") as yearly,Date_FORMAT(created_at, "%Y/%m") as monthly,GROUP_CONCAT(DISTINCT id) as ids, SUM(total) as total_value')
        ->groupBy('daily')
        ->orderBy('created_at','desc')->get()->groupBy($type);

    }
    public function ordersValueCharts($start , $end)
    {
        $startDate = Carbon::parse($start);
        $endDate = Carbon::parse($end);
        $valueData = [];
        $valueDates = [];
        $rateData = [];
        $rateDates = [];
        while ($startDate->lte($endDate)) {
            $valueDates[] = $startDate->format('d/m');
            $orders =  Order::whereDate('created_at',$startDate);
            $sum = $orders->sum('total');
            $count = $orders->count() ? $orders->count() :1;
            $avg = $sum/$count;
            $valueData[] = number_format((float)$avg, 2, '.', '');

            $complete = 0;
            foreach($orders->get() as $item)
            {
                if($item->status == "completed")
                {
                    $complete++;
                }
            }
            $rate = ($complete / $count) * 100;
            $rateData[] = number_format((float)$rate, 2, '.', '');
            $rateDates[] = $startDate->format('d/m');


            $startDate->addDay();
        }

        return [$valueData,$valueDates , $rateData , $rateDates];
    }
    public function userBuySellOrdersValue($type,$start,$end)
    {
        return  Order::whereDate('created_at','>=',$start)->whereDate('created_at','<=',$end)->selectRaw('DATE(created_at) as daily,Date_FORMAT(created_at, "%Y") as yearly,Date_FORMAT(created_at, "%Y/%m") as monthly,GROUP_CONCAT(DISTINCT id) as ids, SUM(total) as total_value ,  COUNT(DISTINCT id) as total_count')
        ->groupBy('daily')
        ->orderBy('created_at','desc')->get()->groupBy($type);

    }
    public function userBuySellOrdersCharts($start , $end)
    {
        $startDate = Carbon::parse($start);
        $endDate = Carbon::parse($end);
        $valueData = [];
        $dates = [];
        $countData = [];
        $quantityData = [];
        while ($startDate->lte($endDate)) {
            $dates[] = $startDate->format('d/m');
            $orders =  Order::with('detail')->whereDate('created_at',$startDate);
            $sum = $orders->sum('total');
            $count = $orders->count();

            $valueData[] = $sum;
            $countData[] = $count;

            if($orders->count() >= 0)
            {
                $ids = $orders->pluck('id')->toArray();
                $quantityData[]  =OrderDetail::whereIn('order_id',$ids)->sum('quantity');
            }
            $startDate->addDay();
        }

        return [$dates , $valueData,$countData , $quantityData];
    }


}

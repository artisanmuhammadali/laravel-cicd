<?php

namespace App\Http\Controllers\Admin\MTG\CRM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visitor;
use App\Services\Admin\MTG\CrmService;
use Carbon\Carbon;
use App\DataTables\Admin\Mtg\CRM\DeletedAccListDataTable;

class CrmController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Crm_Users',['only',['siteVisit','accountRegistrations','deletedAccounts','deletedAccountsList','disputeUsersList','orderCancelUsersList','protectionUsersList','collectionListings','sellersToBuyers','accountRegistrationConversions']]);
        $this->middleware('permission:Crm_Orders',['only'=>['successCheckout','orders','reviewUsersList']]);
        $this->middleware('permission:Crm_Transactions',['only'=>['buyerSpending','sellerEarning','revenues','transactions']]);
    }
    public function siteVisit(CrmService $crmService,Request $request)
    {
        $type = $request->type ?? 'daily';
        list($start,$end) = getDateRange($request->date);
        $date = $start.' to '. $end;
        $visitors = $crmService->visitors($type,$start,$end);
        $data = $crmService->visitorCharts();

        return view('admin.mtg.crm.visitors', get_defined_vars());
    }
    public function accountRegistrations(CrmService $crmService,Request $request)
    {
        $type = $request->type ?? 'daily';
        list($start,$end) = getDateRange($request->date);
        $date = $start.' to '. $end;
        list($sellers,$buyers,$both,$refered,$referee) = $crmService->rgisteredUsers($type,$start,$end);
        list($sellersData,$buyersData,$bothData,$referedData,$refereeData,$dates) = $crmService->accountRegistrationCharts($start,$end);

        $sellerExcel =[];
        $buyerExcel =[];
        $bothExcel =[];
        $referedExcel =[];
        $refereeExcel =[];
        return view('admin.mtg.crm.registeredUsers', get_defined_vars());
    }
    public function deletedAccounts(CrmService $crmService,Request $request)
    {
        $type = $request->type ?? 'daily';
        list($start,$end) = getDateRange($request->date);
        $date = $start.' to '. $end;
        $users = $crmService->deletedUsers($type,$start,$end);
        list($usersData,$dates) = $crmService->deletedUserCharts($start,$end);
        $totalJson = [];
        return view('admin.mtg.crm.deletedUsers', get_defined_vars());
    }
    public function deletedAccountsList(CrmService $crmService, Request $request)
    {
        list($start,$end) = getDateRange($request->date);
        $date = $start.' to '. $end;
        $users = $crmService->deletedUserList($start,$end);
        $deletedList = [];
        return view('admin.mtg.crm.deletedUsersList', get_defined_vars());
    }
    public function disputeUsersList(CrmService $crmService, Request $request)
    {
        list($start,$end) = getDateRange($request->date);
        $date = $start.' to '. $end;
        $users = $crmService->disputeUserList($start,$end);
        $list = [];
        return view('admin.mtg.crm.disputeUsersList', get_defined_vars());
    }
    public function orderCancelUsersList(CrmService $crmService, Request $request)
    {
        list($start,$end) = getDateRange($request->date);
        $date = $start.' to '. $end;
        $users = $crmService->orderCancelUserList($start,$end);
        $list = [];
        return view('admin.mtg.crm.orderCancelUsersList', get_defined_vars());
    }
    public function protectionUsersList(CrmService $crmService, Request $request)
    {
        list($start,$end) = getDateRange($request->date);
        $date = $start.' to '. $end;
        $users = $crmService->protectionUserList($start,$end);
        $list = [];
        return view('admin.mtg.crm.protectionUsersList', get_defined_vars());
    }
    public function reviewUsersList(CrmService $crmService, Request $request)
    {
        list($start,$end) = getDateRange($request->date);
        $date = $start.' to '. $end;
        $users = $crmService->reviewUserList($start,$end);
        $list = [];
        return view('admin.mtg.crm.reviewUsersList', get_defined_vars());
    }
    public function collectionListings(CrmService $crmService,Request $request)
    {
        $type = $request->type ?? 'daily';
        list($start,$end) = getDateRange($request->date);
        $date = $start.' to '. $end;
        list($colelctions,$listings) = $crmService->collections($type,$start,$end);
        list($colelctionsData,$listingData,$dates) = $crmService->collectionCharts($start,$end);
        $totalJson = [];
        $listingJson = [];
        return view('admin.mtg.crm.collections', get_defined_vars());
    }
    public function accountRegistrationConversions(CrmService $crmService,Request $request)
    {
        $type = $request->type ?? 'daily';
        list($start,$end) = getDateRange($request->date);
        $date = $start.' to '. $end;
        $ratios = $crmService->conversionRate($type,$start,$end);
        list($userData,$visitorData,$percentage,$dates) = $crmService->conversionRateCharts($start,$end);

        return view('admin.mtg.crm.userVisitorRatio', get_defined_vars());
    }
    public function sellersToBuyers(CrmService $crmService,Request $request)
    {
        $type = $request->type ?? 'daily';
        list($start,$end) = getDateRange($request->date);
        $date = $start.' to '. $end;
        $ratios = $crmService->sellerToBuyerRatio($type,$start,$end);
        list($buyerData,$sellersData,$percentage,$dates) = $crmService->sellerToBuyerRatioCharts($start,$end);

        $SellerBuyer=[];
        return view('admin.mtg.crm.sellerToBuyer', get_defined_vars());
    }
    public function successCheckout(CrmService $crmService,Request $request)
    {
        $type = $request->type ?? 'daily';
        list($start,$end) = getDateRange($request->date);
        $date = $start.' to '. $end;
        $list = $crmService->checkout($type,$start,$end);
        list($data, $dates) = $crmService->checkoutCharts($start,$end);

        $SuccessCheckout=[];
        return view('admin.mtg.crm.success-checkout', get_defined_vars());
    }
    public function buyerSpending(CrmService $crmService,Request $request)
    {
        $type = $request->type ?? 'daily';
        list($start,$end) = getDateRange($request->date);
        $date = $start.' to '. $end;
        list($total , $average) = $crmService->buyerValue($type,$start,$end);
        list($totalData, $totalDates , $avgData , $avgDates)= $crmService->buyerValueCharts($start,$end);
        $totalJson = [];
        $avgJson = [];
        return view('admin.mtg.crm.buyer-value', get_defined_vars());
    }
    public function sellerEarning(CrmService $crmService,Request $request)
    {
        $type = $request->type ?? 'daily';
        list($start,$end) = getDateRange($request->date);
        $date = $start.' to '. $end;
        list($total , $average) = $crmService->sellerValue($type,$start,$end);
        list($totalData, $totalDates , $avgData , $avgDates) = $crmService->sellerValueCharts($start,$end);

        $sellerExcel= [];
        $SellerAverage= [];
        return view('admin.mtg.crm.seller-value', get_defined_vars());
    }
    public function revenues(CrmService $crmService,Request $request)
    {
        $type = $request->type ?? 'daily';
        list($start,$end) = getDateRange($request->date);
        $date = $start.' to '. $end;
        $values = $crmService->revenueValue($type,$start,$end);
        list($valueData, $valueDates ) = $crmService->revenueValueCharts($start,$end);

        $RevenueAmount=[];
        return view('admin.mtg.crm.revenue', get_defined_vars());
    }
    public function transactions(CrmService $crmService,Request $request)
    {
        $type = $request->type ?? 'daily';
        list($start,$end) = getDateRange($request->date);
        $date = $start.' to '. $end;
        list($values , $traffic) = $crmService->transactionsValue($type,$start,$end);
        list($valueData , $trafficData,$gmvData , $dates) = $crmService->transactionsValueCharts($start,$end);

        $TransactionAmount=[];
        $GmvAmount=[];
        $TransactionTraffic=[];
        return view('admin.mtg.crm.transactions', get_defined_vars());
    }
    public function orders(CrmService $crmService,Request $request)
    {
        $type = $request->type ?? 'daily';
        list($start,$end) = getDateRange($request->date);
        $date = $start.' to '. $end;
        $values = $crmService->ordersValue($type,$start,$end);
        list($valueData, $valueDates , $rateData , $rateDates) = $crmService->ordersValueCharts($start,$end);

        $buySellValues = $crmService->userBuySellOrdersValue($type,$start,$end);
        list($dates, $buySellData , $countData , $quantityData) = $crmService->userBuySellOrdersCharts($start,$end);

        $AvgJson = [];
        $SuccessJson = [];
        $BuySell = [];

        return view('admin.mtg.crm.orders', get_defined_vars());
    }
    public function export(Request $request)
    {
        $type = $request->type;
        $data = $request->json ?? [];
        $header = $request->has('json') && array_key_exists(0,$data) ? array_keys($data[0]) : [];
        $html = view('admin.components.export.table',get_defined_vars())->render();
        return response()->json(['html'=>$html]);
    }

}

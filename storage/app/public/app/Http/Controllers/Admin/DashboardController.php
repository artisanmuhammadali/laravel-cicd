<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PasswordRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Order;
use App\Models\MTG\MtgCard;
use App\Models\MTG\MtgSet;
use App\Models\Transaction;
use App\DataTables\Admin\UserDataTable;
use App\DataTables\Admin\TransactionDataTable;
use App\Models\MTG\MtgUserCollection;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Artisan;

class DashboardController extends Controller
{
    private $userDatatable;

    public function __construct() {
        $this->userDatatable = new UserDataTable();
    }
    public function index()
    {

        $request = request();
        list($start,$end) = getDateRange($request->date);
        $date = $request->date ? $start.' to '. $end : "";

        $sellers = User::where('role','seller')
        ->where('status','active')
                        ->when($request->date,function($q)use($start,$end){
                            $q->whereBetween('created_at', [$start, $end]);                            
                        })
                        ->count();
        $buyers = User::where('role','buyer')
        ->where('status','active')
                        ->when($request->date,function($q)use($start,$end){
                            $q->whereBetween('created_at', [$start, $end]);                            
                        })
                        ->count();
        $both = User::where('role','business')
        ->where('status','active')
                        ->when($request->date,function($q)use($start,$end){
                            $q->whereBetween('created_at', [$start, $end]);                            
                        })
                        ->count();
        $verified = User::where('role','!=','admin')->where('verified',1)
        ->where('status','active')
                        ->when($request->date,function($q)use($start,$end){
                            $q->whereBetween('created_at', [$start, $end]);                            
                        })
                        ->count();
        $products = MtgCard::when($request->date,function($q)use($start,$end){
                            $q->whereBetween('created_at', [$start, $end]);                            
                        })->whereHas('set')->count();
        $single = MtgCard::where('card_type','single')->whereHas('set')
                        ->when($request->date,function($q)use($start,$end){
                            $q->whereBetween('created_at', [$start, $end]);                            
                        })
                        ->count();
        $sealed = MtgCard::where('card_type','sealed')->whereHas('set')
                        ->when($request->date,function($q)use($start,$end){
                            $q->whereBetween('created_at', [$start, $end]);                            
                        })
                        ->count();
        $completed = MtgCard::where('card_type','completed')->whereHas('set')
                        ->when($request->date,function($q)use($start,$end){
                            $q->whereBetween('created_at', [$start, $end]);                            
                        })
                        ->count();
        $special = MtgSet::where('type','special')
                        ->when($request->date,function($q)use($start,$end){
                            $q->whereBetween('created_at', [$start, $end]);                            
                        })
                        ->count();
        $expansion = MtgSet::where('type','expansion')
                        ->when($request->date,function($q)use($start,$end){
                            $q->whereBetween('created_at', [$start, $end]);                            
                        })->count();
        $orders = Order::when($request->date,function($q)use($start,$end){
                            $q->whereBetween('created_at', [$start, $end]);                            
                        })
                        ->count();
        $order_pending = Order::where('status','pending')
                        ->when($request->date,function($q)use($start,$end){
                            $q->whereBetween('created_at', [$start, $end]);                            
                        })
                        ->count();
        $order_completed = Order::where('status','completed')
                        ->when($request->date,function($q)use($start,$end){
                            $q->whereBetween('created_at', [$start, $end]);                            
                        })
                        ->count();
        $order_cancelled = Order::where('status','cancelled')
                        ->when($request->date,function($q)use($start,$end){
                            $q->whereBetween('created_at', [$start, $end]);                            
                        })
                        ->count();
        $order_dispatched = Order::where('status','dispatched')
                        ->when($request->date,function($q)use($start,$end){
                            $q->whereBetween('created_at', [$start, $end]);                            
                        })
                        ->count();
        $order_refunded = Order::where('status','refunded')
                        ->when($request->date,function($q)use($start,$end){
                            $q->whereBetween('created_at', [$start, $end]);                            
                        })
                        ->count();
        $single_liquidity =collectionStatusRate('single');
        $sealed_liquidity =collectionStatusRate('sealed');
        $completed_liquidity =collectionStatusRate('completed');
        
        $liquidity=liquidityRate();
        // dd($liquidity);
        $mtg = [
            ['Mtg Catalouge'=>'Mtg Expansion','Count'=>$expansion],
            ['Mtg Catalouge'=>'Mtg Special Expansion','Count'=>$special],
            ['Mtg Catalouge'=>'Mtg Products','Count'=>$products],
            ['Mtg Catalouge'=>'Mtg Single Cards','Count'=>$single],
            ['Mtg Catalouge'=>'Mtg Sealed Products','Count'=>$sealed],
            ['Mtg Catalouge'=>'Mtg Complete Sets','Count'=>$completed]
        ];
        $order = [
            ['Order Type'=>'Total Orders','Count'=>$orders],
            ['Order Type'=>'Pending Orders','Count'=>$order_pending],
            ['Order Type'=>'Complete Orders','Count'=>$order_completed],
            ['Order Type'=>'Cancelled Orders','Count'=>$order_cancelled],
            ['Order Type'=>'Dispatched Orders','Count'=>$order_dispatched],
            ['Order Type'=>'Refunded Orders','Count'=>$order_refunded]
        ];
        $users =[
            ['User Type'=>'Sellers','Count'=>$sellers],
            ['User Type'=>'Buyers','Count'=>$buyers],
            ['User Type'=>'Business','Count'=>$both],
            ['User Type'=>'Verified','Count'=>$verified],
        ];
        $liquidityArr = [
            // ['Liquidity Rate of Collections'=>'Total Collections','Count'=>$liquidity->total_no , 'Percentage'=>'100%'],
            // ['Liquidity Rate of Collections'=>'Pending Collections','Count'=>$liquidity->pending_no , 'Percentage'=>$liquidity->pending_per.'%'],
            // ['Liquidity Rate of Collections'=>'Converted To Transaction','Count'=>$liquidity->convert_no , 'Percentage'=>$liquidity->convert_per.'%'],

            ['Liquidity Rate of Collections'=>'Active Single Collection','Count'=>$single_liquidity->active_no , 'Percentage'=>$single_liquidity->active_per.'%'],
            ['Liquidity Rate of Collections'=>'Active Sealed Collection','Count'=>$sealed_liquidity->active_no , 'Percentage'=>$sealed_liquidity->active_per.'%'],
            ['Liquidity Rate of Collections'=>'Active Completed Collection','Count'=>$completed_liquidity->active_no , 'Percentage'=>$completed_liquidity->active_per.'%'],

            ['Liquidity Rate of Collections'=>'InActive Single Collection','Count'=>$single_liquidity->inactive_no , 'Percentage'=>$single_liquidity->inactive_per.'%'],
            ['Liquidity Rate of Collections'=>'InActive Sealed Collection','Count'=>$sealed_liquidity->inactive_no , 'Percentage'=>$sealed_liquidity->inactive_per.'%'],
            ['Liquidity Rate of Collections'=>'InActive Completed Collection','Count'=>$completed_liquidity->inactive_no , 'Percentage'=>$completed_liquidity->inactive_per.'%'],

             ['Liquidity Rate of Collections'=>'Converted Single to Transaction Collection','Count'=>$single_liquidity->convert_no , 'Percentage'=>$single_liquidity->convert_per.'%'],
            ['Liquidity Rate of Collections'=>'Converted Sealed to Transaction Collection','Count'=>$sealed_liquidity->convert_no , 'Percentage'=>$sealed_liquidity->convert_per.'%'],
            ['Liquidity Rate of Collections'=>'Converted Completed to Transaction Collection','Count'=>$completed_liquidity->convert_no , 'Percentage'=>$completed_liquidity->convert_per.'%'],
        ];
        return view('admin.index',get_defined_vars());
    }

    public function profile()
    {
        $user = auth()->user();
        return view('admin.security.profile',get_defined_vars());
    }

    public function userList($type = null)
    {
        $assets = ['data-table'];
        return $this->userDatatable->with('type',$type)->render('admin.user.list', get_defined_vars());
    }
    public function transaction(TransactionDataTable $dataTable)
    {
        $assets = ['data-table'];
        return $dataTable->render('admin.transaction.list', get_defined_vars());
    }

    public function profileSave(Request $request)
    {
        if($request->profile_image)
        {
            $image = uploadFile($request->profile_image,'profile_image','custom');
            $request->merge(['avatar' => $image]);
        }
        User::where('id' , auth()->user()->id)->update($request->except(['_token','profile_image']));
        return redirect()->route('admin.profile')->with('message','Updated Successfully!');
    }

    public function accountSetting()
    {
        $user = auth()->user();
        return view('admin.security.password',get_defined_vars());
    }

    public function securityUpdate(PasswordRequest $request)
    {
        User::where('id' , auth()->user()->id)->update(['password' => Hash::make($request->password)]);

        return redirect()->route('admin.account.settings')->with('message','Updated Successfully!');
    }
    public function runUserInactiveCommand()
    {
        Artisan::call('run:validate-sellers-and-buyers-command');
    }
}

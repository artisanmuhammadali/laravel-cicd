<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\User\UserCollectionDataTable;
use App\DataTables\Admin\User\UserOrderDataTable;
use App\DataTables\Admin\User\UserTransactionDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserStore;
use App\Services\Admin\User\AccountStats;
use Exception;
use \MangoPay\MangoPayApi as MangoPay;
use Illuminate\Support\Facades\Config;
use App\Models\MTG\MtgUserCollection;
use App\Models\Order;
use App\DataTables\Admin\UserDataTable;
use App\DataTables\Admin\User\UserConversationDataTable;
use App\DataTables\Admin\UserProtectionDataTable;
use App\DataTables\Admin\CancelOrderUserDatatable;
use App\DataTables\Admin\User\UserReferalDataTable;
use App\Models\Transaction;
use App\Models\EmailMarketing;
use App\Models\UserEmail;
use App\Models\OrderReview;
use App\Models\SellerProgram;
use App\Services\User\MangoPayService;

use DOMDocument;
class UserController extends Controller
{
    private $mangopay;
    private $userStats;
    private $userDatatable;
    private $userConversationDataTable;


    public function __construct(AccountStats $account) {
        $data = Config::get('helpers.mango_pay');
        $this->mangopay = new MangoPay();
        $this->mangopay->Config->ClientId = $data['client_id'];
        $this->mangopay->Config->ClientPassword = $data['client_password'];
        $this->mangopay->Config->TemporaryFolder = '../../';
        $this->mangopay->Config->BaseUrl = $data['base_url'];

        $this->userStats = $account;
        $this->userDatatable = new UserDataTable();
        $this->userConversationDataTable = new UserConversationDataTable();
        $this->middleware('permission:Users_List|Users_Type',['except' => ['status']]);
        $this->middleware('permission:Users_Status',['only' => ['status']]);
        
    }
    public function list($type = null)
    {
        $status = null;
        $assets = ['data-table'];
        return $this->userDatatable->with(['type'=>$type,'status'=>$status])->render('admin.user.list', get_defined_vars());
    }
    public function status($status)
    {
        $type = null;
        $assets = ['data-table'];
        return $this->userDatatable->with(['type'=>$type,'status'=>$status])->render('admin.user.list', get_defined_vars());
    }
    public function detail($id , $view)
    {
        try {
            $walletAmount = 0.00;
            $user = User::withTrashed()->findOrFail($id);
            if($view == "wallets" && $user->default_wallet != null)
            {
                $wallet = $this->mangopay->Wallets->Get($user->default_wallet->wallet_id);
                $walletAmount =$wallet->Balance->Amount/100;
            }
            if($view == "user-stats")
            {
                $request = request();
                $type = $request->type ?? 'daily';
                list($start,$end) = getDateRange($request->date);
                $date = $start.' to '. $end;
                
                list($spendingDates, $spendingData)  =$this->userStats->userSpending($type , $start , $end , $id); 
                list($earningDates , $earningData) = $this->userStats->userEarning($type , $start , $end , $id); 

                $spendingArray = userStatsArray($spendingDates , $spendingData , 'Spendings');
                $earningArray = userStatsArray($earningDates , $earningData , 'Earnings');

                $sale = Order::where('seller_id',$user->id);
                $order_sale = $sale->count();

                $purchase = Order::where('buyer_id',$user->id);
                $order_purchase  =$purchase->count();

                $collection = MtgUserCollection::where('user_id',$user->id)->count();

                $spending = $purchase->sum('total');

                $earning = userEarning($id);

                $saleRevenue  = userVfsRevenue($id , 'sale');
                $purchaseRevenue = userVfsRevenue($id , 'purchase');

                $liquidity = liquidityRate('user' , $user->id);

                $data = [];
            }
            if($view == "conversation"){
                return $this->userConversationDataTable->with(['id'=>$id])->render('admin.user.detail', get_defined_vars());
            }
            return view('admin.user.detail',get_defined_vars());
        } catch (Exception $e) {
            return redirect()->back()->with('error','User is Deleted');
        }

    }

    public function email($id)
    {
        $user = User::find($id);
        return view('admin.user.email.email', get_defined_vars());
    }
    public function sendEmail(Request $request){
        $validated = $request->validate([
            'id' => 'required',
            'subject' => 'required|max:150',
            'body' => 'required',
        ]);
        $user = User::find($request->id);
        $request->body = str_replace('<figure','<figure style="text-align:center;"',$request->body);
        $request->body = str_replace('<img','<img width="80%" height="auto" style="text-align:center;width: 80% !important;"',$request->body);
        $request->merge(['sent_by' => auth()->user()->id,'newsletter' => 'Single user']);
        $email_mark = EmaiLmarketing::create($request->except('_token','id'));
        UserEmail::create(['email_id' => $email_mark->id, 'user_id' => $request->id]);
        sendMail([
            'view' => 'admin.user.email.preview',
            'to' => $user->email,
            'subject' => $request->subject,
            'data' => [
                'content'=>$request->body,
            ]
           ]);
        return redirect()->route('admin.marketing.list')->with('message','Mail Successfully sent!');
      
    }
    public function collections($id , $view , UserCollectionDataTable $dataTable)
    {
        $user = User::find($id);
        $assets = ['data-table'];
        $active_sum = MtgUserCollection::where('user_id',$user->id)->where('publish',1)->sum('price');
        $inactive_sum = MtgUserCollection::where('user_id',$user->id)->where('publish',0)->sum('price');
        return $dataTable->with('id',$id)->render('admin.user.detail', get_defined_vars());
    }
    public function orders($id , $view , UserOrderDataTable $dataTable)
    {
        $user = User::find($id);
        $assets = ['data-table'];
        return $dataTable->with('id',$id)->render('admin.user.detail', get_defined_vars());
    }
    public function transactions($id , $view , UserTransactionDataTable $dataTable)
    {
        $user = User::find($id);
        $assets = ['data-table'];
        $typee = 'transactions';
        $walletId = $user->default_wallet ? $user->default_wallet->wallet_id : null;
        $pagination = new \MangoPay\Pagination(1 ,50);
            $sorting = new \MangoPay\Sorting();
            $sorting->AddField("CreationDate",\MangoPay\SortDirection::DESC);
            $transactions = $walletId ? $this->mangopay->Wallets->GetTransactions($walletId ,$pagination ,$filter = null, $sorting) : [];
        return $dataTable->with('id',$id)->render('admin.user.detail', get_defined_vars());
    }

    public function referal($id , $view , UserReferalDataTable $dataTable)
    {
        $user = User::find($id);
        $assets = ['data-table'];
        $ids = User::where('referr_by',$id)->pluck('id')->toArray();
        $order_id = Order::whereIn('buyer_id',$ids)->pluck('id')->toArray();
        $commision_sum= Transaction::whereIn('order_id',$order_id)->where('credit_user',$id)->where('type','referal')->sum('amount');
        return $dataTable->with('id',$id)->render('admin.user.detail', get_defined_vars());
    }

    // public function reviews($id , $view , Request $request)
    // {
    //     $user = User::find($id);
    //     $assets = ['data-table'];
    //     $ids = User::where('referr_by',$id)->pluck('id')->toArray();
    //     $order_id = Order::whereIn('buyer_id',$ids)->pluck('id')->toArray();
    //     $commision_sum= Transaction::whereIn('order_id',$order_id)->where('credit_user',$id)->where('type','referal')->sum('amount');
    //     return $dataTable->with('id',$id)->render('admin.user.detail', get_defined_vars());
    // }

    function survey($id , $view)
    {
        $user = User::findorFail($id);
        $user_survey = SellerProgram::where('user_id',$id)->first();
        $survey = json_decode($user_survey->content);
        return view('admin.user.detail', get_defined_vars());
    }
    function reviews($id , $view , Request $request)
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
        if($request->ajax()){
            $view  = view('admin.user.components.reviews',get_defined_vars())->render();
            return response()->json(['html' => $view]);
        }
        else{
            return view('admin.user.detail', get_defined_vars());
        }
    }

     public function restore($id)
    {
        $user = User::withTrashed()->find($id);
        $user->restore();
        $user = User::findOrFail($id);
        $user->status='active';
        $user->deleted_at= null;
        $user->save();

        // $mail_status = "We have Restored your account.";
        // $title = (object)['subject'=>'Account Restored BY ADMIN - VERY FRIENDLY SHARKS','detail'=>""];
        // sendMail([
        //     'view' => 'email.account.account-status',
        //     'to' => $user->email,
        //     'subject' => 'Account Restored',
        //     'data' => [
        //         'user_name' => $user->user_name,
        //         'reason' => "",
        //         'date' => now(),
        //         'status' => $mail_status,
        //         'title'=>$title,
        //     ]
        // ]);
        return redirect()->route('admin.user.detail',[$id , 'info'])->with('message','Info and Status updated Successfully');
    }


    public function edit(Request $request)
    {
        $validated = $request->validate([
            'user_name' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'dob' => 'required',
        ]);
        $referal = 0;
        if($request->receive_referal && $request->receive_referal == 'on')
        {
            $referal = 1;
        }
        $ref_percent = $referal == 0 ? 0 : $request->referal_percentage;
        User::find($request->user_id)->update($request->except(['_token']));
        UserStore::where('user_id',$request->user_id)->update(['referal_percentage' => $ref_percent, 'referal_limit' => $request->referal_limit , 'receive_referal'=>$referal , 'referal_type' =>$request->referal_type ?? 'others' , 'commission_percentage' =>$request->commission_percentage ,'status'=>$request->status]);
        $user = User::find($request->user_id);
        if($request->status){
            $reason = $request->reason ? $request->reason : "admin change your account status for some reason";

            $title = userStatusUpdateTitles($request->status);
            $mail_status = $user->status == "active" ? "We have Activate your account . The reason can be seen here:" : "We’ve temporarily ".ucfirst($user->status)." your  account while investigating your behaviour on the platform. The reason can be seen here:";
            sendMail([
                'view' => 'email.account.account-status',
                'to' => $user->email ?? $user['email'],
                'subject' => $title->subject,
                'data' => [
                    'user_name' => $user->user_name ?? $user['user_name'],
                    'reason' => $reason,
                    'date' => now(),
                    'status' => $mail_status,
                    'title'=>$title
                ]
            ]);
        }
        sendMail([
            'view' => 'email.account.edit',
            'to' => $user->email ?? $user['email'],
            'subject' => 'ACCOUNT EDITED BY ADMIN - VERY FRIENDLY SHARKS',
            'data' => [
                'user_name' => $user->user_name ?? $user['user_name'],
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'referal_limit' => $user->store->referal_limit ?? "",
                'referal_percentage' => $user->store->referal_percentage ?? "",
                'dob' => $user->dob,
                'date' => now()
            ]
        ]);
        return redirect()->route('admin.user.detail',[$user->id , 'info'])->with('message','Info and Status updated Successfully');
    }
    public function delete($id)
    {
        // $user = User::find($id);
        // sendMail([
        //     'view' => 'email.account.account-deleted',
        //     'to' => $user->email ?? $user['email'],
        //     'subject' => 'ACCOUNT DELETED BY ADMIN - VERY FRIENDLY SHARKS',
        //     'data' => [
        //         'user_name' => $user->user_name ?? $user['user_name'],
        //         'date' => now()
        //         ]
        //     ]);
        User::findOrFail($id)->update(['status'=>'deleted']);
            User::find($id)->delete();
        return redirect()->route('admin.user.list')->with('message','User deleted Successfully');
    }
    public function manage(Request $request)
    {
        if($request->referal_percentage >= vsfPspConfig()->platform_fee)
        {
            return redirect()->back()->with('error','Please Enter correct percentage');
        }
        UserStore::where('referal_type',$request->referal_type)->update(['referal_percentage'=>$request->referal_percentage, 'receive_referal'=>$request->receive_referal == 'on' ? "1" : '0']);
        return redirect()->route('admin.user.list')->with('message','User Referal Updated Successfully');
    }


}

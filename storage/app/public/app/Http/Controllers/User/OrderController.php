<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Transaction;
use App\Services\User\OrderService;
use App\Traits\EscrowTransfer;
use Illuminate\Http\Request;
use PDF;
class OrderController extends Controller
{
    use EscrowTransfer;
    private $service;

    public function __construct(OrderService $service)
    {
        $this->service = $service;
    }
    public function index($type , $slug)
    {
        $user = User::find(auth()->user()->id);
        $orders = Order::where('status','dispatched')
                        ->whereRaw('DATEDIFF(NOW(), dispatch_at) > 30')
                        ->get();
        foreach($orders as $order)
        {
            $order->update(['status'=>'completed']);
            $this->service->completed($order , $slug);
        }

        $order = "asc";
        $list = $type == "sell" ? $user->sellingOrders() : $user->buyingOrders();
        $list = $list->where('status',$slug)
                    ->orderBy('created_at','desc')
                    ->paginate(10);
        $navs = ['fa fa-clock' => 'pending', 'fa fa-times' => 'cancelled','fa fa-truck' => 'dispatched','fa fa-undo' => 'refunded','fa fa-check' => 'completed','fa fa-gavel' => 'dispute'];   
        return view('user.order.index',get_defined_vars());
    }
    public function update(Request $request)
    {
        // make separate request 
        $request->validate([
            'status'=>'required',
        ]);
        if($request->status == "dispatched")
        {
            $request->validate([
                'tracking_id'=>'required',
            ]); 
        }
        if($request->status == "dispute")
        {
            $request->validate([
                'reason'=>'required',
            ]); 
        }
        $this->service->process($request);

        return response()->json(['success'=>'Order Status has Changed!']);
    }
    public function detail($id , $type)
    {
        $user = User::find(auth()->user()->id);
        $list = $type == "sell" ? $user->sellingOrders() : $user->buyingOrders();

        $order = $list->where('id',$id)->firstOrFail();
        
        $statuses = $order->status == "pending" ? ['cancelled'] : [];
        $statuses = $type == "buy" ? $statuses : array_merge($statuses , ['dispatched']);

        $statuses = $order->status == "dispatched" ? array_diff($statuses, ['dispatched']) : $statuses;
        $statuses = $order->status == "dispatched" && $type == "buy" ? array_merge($statuses , ['dispute','completed']) : $statuses;
        $con = null;
        if($order->seller && $order->buyer)
        {
            $con = $order->seller_id == auth()->user()->id ? $order->buyer_id : $order->seller_id;
        }
        $user = $order->seller_id == auth()->user()->id ? $order->buyer : $order->seller;
        $transaction = Transaction::where('order_id',$order->id)->where('type','extra');
        $extraPayments = $transaction->get();
        $extraPrice = $extraPayments->sum('seller_amount');
        $extra = $type == "buy" ? $transaction->where('debit_user',$order->buyer_id)->first() : $transaction->where('debit_user',$order->seller_id)->first();
        $extraCondition = !$extra && ($order->status == "pending" || $order->status == "dispatched");
        $btn_show_condition = $order->status == "dispatched" ? diffBwtDates($order->dispatch_at , now()) :0;
        $items_price = $order->detail->sum(function ($item) {
            return $item->price * $item->quantity;
        });
        $main = Transaction::where('order_id',$order->id)->where('type','order-transfer')->first();
        $extraAmt=0;
        return view('user.order.detail',get_defined_vars());
    }
    public function extraPayment(Request $request)
    {
        $request->validate([
            'amount'=>'required',
        ]);
        $order = Order::find($request->order_id);
        $type = $request->type;
        $transaction = Transaction::where('order_id',$order->id)->where('type','extra');
        $main = Transaction::where('order_id',$order->id)->where('type','order-transfer')->first();
        $extra = $type == "buy" ? $transaction->where('debit_user',$order->buyer_id)->first() : $transaction->where('debit_user',$order->seller_id)->first();
        $extraCondition = !$extra && ($order->status == "pending" || $order->status == "dispatched");

        $transaction = Transaction::where('order_id',$order->id)->where('type','extra');
        $extraPayments = $transaction->get();
        $extraPrice = $extraPayments->sum('seller_amount');

        $seller_amount = $main->seller_amount - $main->referee_credit + $extraPrice -  $main->seller_kyc_return;
        if((auth()->user()->id == $order->seller_id && $request->amount > $seller_amount) || (auth()->user()->id == $order->buyer_id && $request->amount > $main->shiping_charges) || $request->amount < 0.01 || !$extraCondition)
        {
            $msg = !$extraCondition ? "You've sent the maximum amount allowed for this order. You won't be able to send more to the seller." : "This Payment cannot be process";
            return response()->json(['error'=>$msg]);
        }
        if(auth()->user()->id == $order->buyer_id && getUserWallet() < (float)$request->amount)
        {
            return response()->json(['error'=>'Insufficient Wallet Funds.']);
        }
        $credit = $type == "buy" ? $order->seller : $order->buyer;
        $debit = $type == "buy" ? $order->buyer : $order->seller;
        $description = $type == "buy" ? 'Extra payment for order to seller' : 'Refund to buyer';
        if($type == "sell")
        {
            if((float)$request->amount == number_format($seller_amount, 2, '.', ''))
            {
                $transfer = $this->transferToUser($debit , $credit , $request->amount ,$description , 0 ,'extra' ,0,0,0);
                $this->service->orderRefundBySeller($order , $request , $transfer);
                $order->update(['status'=>'refunded']);
                return response()->json(['success'=>'Order refunded to buyer!']);
            }
            $transfer = $this->refund($debit , $credit , $description  ,'extra' , $main , 0 , (float)$request->amount);
        }
        else
        {
            $transfer = $this->transferToUser($debit , $credit , $request->amount ,$description , 0 ,'extra' ,0,0,0);
        }
        $seller_amount = $type == "buy" ?  (float)$request->amount : -(float)$request->amount;
        
        Transaction::where('transaction_id',$transfer)->update([
            'order_id'=>$order->id ,
            'seller_amount'=>$seller_amount,
            'parent_id'=>$main->id ?? null
        ]);

        $notify = $type == "sell"  ? $order->buyer : $order->seller;
        $from = $type == "buy"  ? ', buyer has send extra payment for order # '.$order->id : ', seller has partially refund the order # '.$order->id;
        $msg = 'Dear user '.$notify->user_name.$from;
        sendMail([
            'view' => 'email.order.extra-payment',
            'to' => $notify->email,
            'subject' => 'EXTRA PAYMENT FOR ORDER - VERY FRIENDLY SHARKS',
            'data' => [
                'subject'=>'EXTRA PAYMENT FOR ORDER - VERY FRIENDLY SHARKS',
                'message'=>$msg,
                'amount'=>$request->amount,
                'transaction_id'=>$transfer,
                'date'=>now()->format('Y-m-d')
            ]
        ]);
        $msg = $type == "buy" ? 'Extra Payment Successfully Sent to seller!' : 'Order partially refund to buyer!';
        return response()->json(['success'=>$msg]);
    }

    public function bulkDownload(Request $request)
    {
            $type = 'sell';
            $orders = Order::whereIn('id',$request->idd)->get();
            if($request->bulk == 'label')
            {
               $view = 'user.order.pdfLabel';
            }
            else{
                $view = 'user.order.pdfInvoice';
            }
            if(!$request->ajax())
            {
                return view('user.order.pdfLabel',get_defined_vars());
            }
            $pdf = PDF::loadView($view,get_defined_vars())->setPaper('A4');

            $fileName =  time().'.'. 'pdf' ;
            $pdf->save(public_path() . '/' . $fileName);
    
            $pdf = public_path($fileName);
            return response()->download($pdf);
    }
    
}

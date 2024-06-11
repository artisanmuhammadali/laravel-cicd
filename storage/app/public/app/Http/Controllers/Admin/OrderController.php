<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Order;
use App\Models\User;
use App\Services\User\OrderService;
use Illuminate\Http\Request;
use App\Traits\EscrowTransfer;
use App\DataTables\Admin\Mtg\OrderDataTable;
use App\Models\Transaction;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Orders|Order_List|Dispute_Orders');
    }
    use EscrowTransfer;
    public function index(OrderDataTable $dataTable,$type = null)
    {
        $assets = ['data-table'];
        $navs = ['pending', 'cancelled', 'dispatched','refunded','completed'];   
        return $dataTable->with('type',$type)->render('admin.orders.index', get_defined_vars());
    }
    
    public function detail($id)
    {
        $order = Order::find($id);
        $conversation = null;
        $statuses = ['completed'];
        if($order->seller && $order->buyer)
        {
          $conversation = getConvers($order->seller_id,$order->buyer_id);
        }
        $user = $order->seller_id == auth()->user()->id ? $order->buyer : $order->seller;
        $main = Transaction::where('order_id',$order->id)->where('type','order-transfer')->first();
        $transaction = Transaction::where('order_id',$order->id)->where('type','extra');
        $extraPayments = $transaction->get();
        $extraPrice = $extraPayments->sum('seller_amount');
        $show_btns = $order->status != "completed" && $order->status != "cancelled" && $order->status != "refunded";
        $items_price = $order->detail->sum(function ($item) {
                        return $item->price * $item->quantity;
                    });
        return view('admin.orders.detail',get_defined_vars());
    }
    public function update($id , $type , OrderService $service)
    {
        $order_type = $type;
        $request = request();
        $order = Order::find($id);
        $condition = $request->has('refund_amount') ? ($request->refund_amount >= $order->total -$order->total_commision ||$request->refund_amount < 0.01) : false;
        if($condition)
        {
            return redirect()->back()->with('error','Please enter correct amount');
        }
        $type == "cancelled" ? $request->merge(['type'=>'buy']):'' ;
        $transfer_id =$service->$type($order , $request);
        
        Transaction::where('transaction_id',$transfer_id)->update(['order_id'=>$order->id]);
        $order->update(['status'=>$type]);
        $user = "buyer";
        $type = 'buy';
        $email = [
            'cancelled'=>[
                'view'=>'email.order.cancel',
                'subject'=>'ORDER CANCELLED - VERY FRIENDLY SHARKS'
            ],
            'refunded'=>[
                'view'=>'email.order.refund',
                'subject'=>'ORDER REFUNDED - VERY FRIENDLY SHARKS'
            ],
            'completed'=>[
                'view'=>'email.order.complete',
                'subject'=>'ORDER COMPLETED - VERY FRIENDLY SHARKS'
            ]
        ];
        $email = $email[$order_type];
        sendMail([
            'view' => $email['view'],
            'to' => $order->$user->email,
            'subject' => $email['subject'],
            'data' => [
                'order'=>$order,
                'type'=>$type,
            ]
        ]);
        $other = $user == "seller" ? "buyer" : "seller";
        $message = getNotificationMsg($order_type,$order->$other->user_name);

        $type = $order->seller_id == $order->$user->id ? 'sell' : 'buy';
        $route = route('user.order.detail',[$order->id , $type]);

        sendNotification($order->$user->id,$order->$other->id  ,'order',$message ,$order , $route);
        return redirect()->back()->with('success','Order Status has Changed!');
    }
    public function getChat(Request $request)
    {
        $conversation = Conversation::Find($request->id);
        $order = Order::find($conversation->order_id);
        $messages = Message::where('conversation_id', $request->id)->get();

        return view('admin.orders.chat', get_defined_vars());
    }
}

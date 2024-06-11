<?php

namespace App\Services\User;

use App\Jobs\ReturnKycPaymentToUser;
use App\Models\Message;
use App\Models\MTG\MtgUserCollection;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\User;
use App\Services\Admin\User\ReturnKycPaymentService;
use App\Services\Front\SupportService;
use App\Traits\EscrowTransfer;
use Carbon\Carbon;

class OrderService {

    use EscrowTransfer;
    private $supportService;

    public function __construct(SupportService $supportService)
    {
        $this->supportService = $supportService;
    }

    public function process($request)
    {
        $order = Order::find($request->id);
        $order->update(['status'=>$request->status]);
        $fun = $request->status;
        $this->$fun($order , $request);

        return true;
    }
    public function cancelled($order , $request)
    {
        $user = $order->buyer;
        $date1 = Carbon::parse($order->created_at);
        $date2 = Carbon::now();
        $dayDifference = $date1->diffInDays($date2) == 0 ? 1 : $date1->diffInDays($date2)+1;
        
        $description = "Seller Wallet To Buyer Transfer on order cancel";
        $transfer =$this->refundTransaction($order , $description , "cancelled" , false , $request , $dayDifference);
        $parent = Transaction::where('order_id',$order->id)->where('type','order-transfer')->first();
        $child = Transaction::where('transaction_id',$transfer)->first();
        $kyc_fee = ((-1)*$child->seller_amount) == $parent->seller_amount ? (-$parent->seller_kyc_return) : 0;
        $seller_amount = $child->seller_amount < 0 ? $child->seller_amount : (-$child->seller_amount);
        $child->update([
            'order_id'=>$order->id ,
            'seller_amount'=>$seller_amount,
            'parent_id'=>$parent->id ?? null,
            'referee_credit'=>(-$parent->referee_credit),
            'shiping_charges'=>(-$parent->shiping_charges),
            'seller_kyc_return'=>$kyc_fee
        ]);

        $details = $order->detail;
        foreach($details  as $detail)
        {
            $collection = MtgUserCollection::find($detail->mtg_user_collection_id);
            if($collection)
            {
                $collection->quantity = (int)$collection->quantity + (int)$detail->quantity;
                $collection->save();
            }
        }
        $user = $request->type == "buy" ? "seller" : "buyer";
        $type = $request->type == "buy" ? 'sell' : 'buy';
        sendMail([
            'view' => 'email.order.cancle',
            'to' => $order->$user->email,
            'subject' => 'ORDER CANCELLED - VERY FRIENDLY SHARKS',
            'data' => [
                'order'=>$order,
                'type'=>$type,
            ]
        ]);
        $other = $user == "seller" ? "buyer" : "seller";
        $message = getNotificationMsg('cancelled',$order->$other->user_name);
        $type = $order->seller_id == $order->$user->id ? 'sell' : 'buy';
        $route = route('user.order.detail',[$order->id , $type]);
        sendNotification($order->$user->id,$order->$other->id  ,'order',$message ,$order , $route);
        $order->update(['cancelled_at'=>now() ,'cancel_after'=>$dayDifference ,'cancelled_by'=>auth()->user()->id]);
        return true;
    }
    public function dispatched($order , $request)
    {
        $order->update(['tracking_id'=>$request->tracking_id , 'dispatch_at'=>now()]);
        sendMail([
            'view' => 'email.order.dispatch',
            'to' => $order->buyer->email,
            'subject' => 'ORDER DISPATCHED - VERY FRIENDLY SHARKS',
            'data' => [
                'order'=>$order,
            ]
        ]);
        $message = getNotificationMsg('dispatched',$order->seller->user_name);
        $route = route('user.order.detail',[$order->id , 'buy']);
        sendNotification($order->buyer->id,$order->seller->id  ,'order',$message ,$order , $route);
        return true;
    }
    public function dispute($order , $request)
    {
        $order->update(['reason'=>$request->reason]);
        $order->refresh();
        sendMail([
            'view' => 'email.order.dispute',
            'to' => $order->seller->email,
            'subject' => 'ORDER DISPUTE - VERY FRIENDLY SHARKS',
            'data' => [
                'order'=>$order,
            ]
        ]);
        $message = getNotificationMsg('dispute', $order->buyer->user_name);
        $route = route('user.order.detail',[$order->id , 'sell']);
        sendNotification($order->seller->id,$order->buyer->id  ,'order',$message ,$order , $route);

        $issue = 'Order No :'.$order->id. 
        'Seller : '.$order->seller->user_name.
        'Reason :'.$request->reason;

        $request->merge(['email'=>$order->buyer->email ,'subject'=>'Order Dispute Opens' ,'issue'=>$issue , 'tag'=> 'dispute','category'=>5 ,'report_to_id'=>$order->seller_id , 'report_by_id'=>$order->buyer->id ,'order_id'=>$order->id]);
        $this->supportService->create($request);

        return true;
    }
    public function refunded($order , $request)
    {
        $description = "Seller Wallet To Buyer Transfer on order refund";
        $transfer = $this->refundTransaction($order , $description , "refund" , true ,$request , 0);

        $parent = Transaction::where('order_id',$order->id)->where('type','order-transfer')->first();
        $seller_amount = -(float)$request->refund_amount;
        Transaction::where('transaction_id',$transfer)->update([
            'order_id'=>$order->id ,
            'seller_amount'=>$seller_amount,
            'referee_credit'=>(-$parent->referee_credit),
            'parent_id'=>$parent->id ?? null
        ]);
        $user = $order->buyer;
        sendMail([
            'view' => 'email.order.refund',
            'to' => $user->email,
            'subject' => 'ORDER REFUND - VERY FRIENDLY SHARKS',
            'data' => [
                'order'=>$order,
                'refund'=>$request->refund_amount
            ]
        ]);

        $message = getNotificationMsg('refunded', $order->buyer->user_name);
        $route = route('user.order.detail',[$order->id , 'buy']);
        sendNotification($order->buyer->id,null  ,'order',$message ,$order , $route);
        return $transfer;
    }
    public function completed($order , $request)
    {
        $postage = $order->postage;
        $ref_total = $order->total - (float)$postage->price;
        $transaction = Transaction::where('order_id',$order->id)->where('type','order-transfer')->first();
        // $refreeUser = User::find($order->buyer->referr_by);
        $this->refreeCalculation($transaction , $order , $ref_total);
        sendMail([
            'view' => 'email.order.complete',
            'to' => $order->seller->email,
            'subject' => 'ORDER COMPLETED - VERY FRIENDLY SHARKS',
            'data' => [
                'order'=>$order,
            ]
        ]);
        if($transaction->seller_kyc_return > 0)
        {
            $this->sellerPaymentReminder($order , $transaction->seller_kyc_return);
        }
        $message = getNotificationMsg('completed',$order->buyer->user_name);
        $route = route('user.order.detail',[$order->id , 'sell']);
        sendNotification($order->seller->id,$order->buyer->id  ,'order',$message ,$order , $route);
        return true;
    }
    public function refreeCalculation($transaction , $order , $ref_total)
    {
        $refreeUser = User::where('deleted_at',null)->where('id',$order->buyer->referr_by)->first();
        $referr_condition = $refreeUser && (float)$ref_total >= 20.00 ? 1 : 0;
        // $referr_condition2 = $refreeUser && $refreeUser->store->receive_referal ? 1 : 0;
        if($referr_condition)
        {
            $ref_credit = $transaction->referee_credit;
            $refree = $refreeUser->store;
            $refree->vfs_wallet =$refree->vfs_wallet + $ref_credit;
            $refree->vfs_wallet_store =$refree->vfs_wallet_store + $ref_credit;
            $refree->save();
            $debit = $order->seller;
            $credit = $refreeUser;
            $description = "Referral Credit";
            $transfer =$this->transferToUser($debit ,$credit , $transaction->referee_credit , $description  , 0 , 'referal' , 0, 0 , 0);
            Transaction::where('transaction_id',$transfer)->update([
                'order_id'=>$order->id ,
                'seller_amount'=>0,
                'parent_id'=>$transaction->id ?? null
            ]);
            $m = new Message();
            $notify = 'Congratulations! You earned £'.$transaction->referee_credit.' Referral Credit via '.$order->buyer->user_name.'.';
            sendNotification($refreeUser->id,1 , 'message',$notify ,$m , route('user.transaction.list'));
            sendMail([
                'view' => 'email.order.referal',
                'to' => $refreeUser->email,
                'subject' => 'SUCCESSFULLY REFERRAL CREDIT - VERY FRIENDLY SHARKS',
                'data' => [
                    'user_name' => $refreeUser->user_name,
                ]
            ]);
        }
    }
    public function refundTransaction($order , $description , $type , $condition , $request , $day)
    {
        $transaction = $order->transactions->where('order_id',$order->id)->where('type','order-transfer')->first();
        $refund_To_buyer = Transaction::where('order_id',$order->id)->where('debit_user',$order->seller_id)->where('type','extra')->first();
        $extra_amount_to_seller = Transaction::where('order_id',$order->id)->where('debit_user',$order->buyer_id)->where('type','extra')->first();

        $transaction_type = "cancelled";

        $total = $refund_To_buyer ? ($transaction->seller_amount - $refund_To_buyer->amount) : $transaction->seller_amount;
        
        if($request->refund_amount)
        {
            $transaction_type = "refund";
            $total = $request->refund_amount;
        }

        $user = $order->buyer;
        $debit = $order->seller;
        $commision = 0;
        
        $amount = (float)$total;
        $is_admin = User::where('id',auth()->user()->id)
                        ->whereNotIn('role',["buyer","seller","business"])->first();

        if($extra_amount_to_seller && !$is_admin)
        {
            $this->returnExtraAmountToSeller($transaction , $debit , $user , $extra_amount_to_seller , $description , $transaction_type , $order);
        }
        if($day >= 7 || $request->refund_with_fee == "on" || auth()->user()->id == $order->seller_id)
        {
            if($extra_amount_to_seller && $is_admin)
            {
                $this->returnExtraAmountToSeller($transaction , $debit , $user , $extra_amount_to_seller , $description , $transaction_type , $order);
            }
            $debit->store->kyc_refunded_amount = $debit->store->kyc_refunded_amount-$transaction->seller_kyc_return;
            $debit->store->save();
            $final_refund_amount = $refund_To_buyer ? $transaction->seller_amount - $refund_To_buyer->amount : $transaction->seller_amount;
            return $this->refund($debit , $user , $description  ,$transaction_type , $transaction , $transaction->fee , $final_refund_amount);
        }
        
        
        $amount = $is_admin ? $amount : $amount - ($transaction->seller_kyc_return + $transaction->referee_credit);
        if($transaction->seller_kyc_return > 0)
        {
            $this->sellerPaymentReminder($order , $transaction->seller_kyc_return);
        }
        if($transaction->referee_credit > 0)
        {
            $postage = $order->postage;
            $ref_total = $order->total - (float)$postage->price;
            $this->refreeCalculation($transaction , $order , $ref_total);
        }
        return $this->transferToUser($debit ,$user , $amount , $description  , $commision , $transaction_type , $transaction->buyer_referal_debit , 0 , 0);
    }
    public function sellerPaymentReminder($order , $amount)
    {
        $subject = $order->seller->role == "seller" ? 'KYC' : 'KYB'.' PAYMENT REFUNDED - VERY FRIENDLY SHARKS';
        sendMail([
            'view' => 'email.account.return-kyc-payment',
            'to' => $order->seller->email,
            'subject' => $subject,
            'data' => [
                'user'=>$order->seller,
                'amount'=>$amount
            ]
        ]);
    }
    public function returnExtraAmountToSeller($transaction , $debit , $user , $extra_amount_to_seller , $description , $transaction_type , $order)
    {
        $transaction_id =$this->transferToUser($debit ,$user , $extra_amount_to_seller->amount , $description  , 0 , $transaction_type , $transaction->buyer_referal_debit , 0 , 0);
        $parent = Transaction::where('order_id',$order->id)->where('type','order-transfer')->first();
        Transaction::where('transaction_id',$transaction_id)->update([
            'order_id'=>$order->id ,
            'seller_amount'=>(-$extra_amount_to_seller->amount),
            'parent_id'=>$parent->id ?? null
        ]);
    }
    public function orderRefundBySeller($order , $request , $transfer)
    {
        $parent = Transaction::where('order_id',$order->id)->where('type','order-transfer')->first();

        if($parent->seller_kyc_return > 0)
        {
            $this->sellerPaymentReminder($order , $parent->seller_kyc_return);
        }
        if($parent->referee_credit > 0)
        {
            $postage = $order->postage;
            $ref_total = $order->total - (float)$postage->price;
            $this->refreeCalculation($parent , $order , $ref_total);
        }

        $seller_amount = -(float)$request->amount;
        Transaction::where('transaction_id',$transfer)->update([
            'order_id'=>$order->id ,
            'seller_amount'=>$seller_amount,
            'referee_credit'=>(-$parent->referee_credit),
            'parent_id'=>$parent->id ?? null
        ]);
        $user = $order->buyer;
        sendMail([
            'view' => 'email.order.refund',
            'to' => $user->email,
            'subject' => 'ORDER REFUND - VERY FRIENDLY SHARKS',
            'data' => [
                'order'=>$order,
                'refund'=>$request->refund_amount
            ]
        ]);

        $message = getNotificationMsg('refunded', $order->buyer->user_name);
        $route = route('user.order.detail',[$order->id , 'buy']);
        sendNotification($order->buyer->id,null  ,'order',$message ,$order , $route);
        return true;
    }
}


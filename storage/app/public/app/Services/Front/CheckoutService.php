<?php

namespace App\Services\Front;

use App\Models\Cart;
use App\Models\MTG\MtgUserCollection;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserAddress;
use \MangoPay\MangoPayApi as MangoPay;
use Illuminate\Support\Facades\Config;
use App\Traits\EscrowTransfer;

class CheckoutService {

    use EscrowTransfer;

    private $mangopay;

    public function __construct()
    {   
        $data = Config::get('helpers.mango_pay');
        $this->mangopay = new MangoPay();
        $this->mangopay->Config->ClientId = $data['client_id'];
        $this->mangopay->Config->ClientPassword = $data['client_password'];
        $this->mangopay->Config->TemporaryFolder = '../../';
        $this->mangopay->Config->BaseUrl = $data['base_url'];
    }
    public function proceed($request)
    {
        if($this->checkFunds($request->complete_total))
        {
            $user = auth()->user();
            $carts =  Cart::where('user_id',$user->id)->get()->groupBy('seller_id');
            foreach($carts as $key =>$cart)
            {
                $seller = User::find($key);
                $cal = (object)getSellerCartCalculations($key);
                $postage_price = $cal->postage_price;
                $order_price = $cal->price;
                $postage = $cal->postage;
                $seller_price = $order_price+$postage_price;
                $transfer = $this->proceedTransaction($user , $seller  ,$seller_price , $cal->fee , $postage_price);
                $transaction_id = $transfer->transaction_id;
                if($transaction_id == null)
                {
                    return redirect()->back()->with('error','Your Transaction cannot be process at the moment.');
                }
                $address = UserAddress::find($request->address_id);
                $order = new Order();
                $order->seller_id = $key;
                $order->buyer_id = $user->id;
                $order->total = $postage_price + $order_price;
                $order->postage_id = $postage->id;
                $order->address = $request->address;
                $order->street_address = $address->street_number;
                $order->postal_code = $address->postal_code;
                $order->city =  $address->city;
                $order->country =  $address->country;
                $order->transaction_id = $transaction_id  ?? 0;
                $order->save();
                $qty = 0;
                foreach($cart as $crt)
                {
                    $collection = $crt->collection;

                    $qty = $qty + $crt->quantity;
                    $data = [
                    'mtg_card_id' => $crt->collection->card->id,
                    'card_id' => $crt->collection->card->id,
                    'card_type' => get_class($crt->collection->card),
                    'order_id' => $order->id,
                    'quantity' => $crt->quantity,
                    'price' => $crt->price,
                    'mtg_user_collection_id' => $crt->collection_id,
                    'language' => $collection->language,
                    'note' => $collection->note,
                    'condition' => $collection->condition,
                    'foil' => $collection->foil,
                    'signed' => $collection->signed,
                    'altered' => $collection->altered,
                    'graded' => $collection->graded,
                    'image' => $collection->image,
                    'range' => $crt->range,
                    'collection_price' => $collection->price];
                    $collection->orderDetail()->create($data);

                    $collection->quantity = (int)$collection->quantity - $crt->quantity;
                    $collection->save(); 
                }
                Cart::where('user_id',$user->id)->where('seller_id',$key)->delete();

                $message = getNotificationMsg('sale',$order->buyer->user_name);
                $route = route('user.order.detail',[$order->id , 'sell']);
                sendNotification($order->seller->id,$order->buyer->id , 'order',$message ,$order , $route);

                foreach($transfer as $transfer_id)
                {
                    if($transfer_id)
                    {
                        Transaction::where('transaction_id',$transfer_id)->update(['order_id'=>$order->id,'shiping_charges'=>$postage_price]);
                    }
                }
                //order confirmation to buyer
                sendMail([
                    'view' => 'email.order.purchase',
                    'to' => $order->buyer->email,
                    'subject' => 'SUCCESSFUL PURCHASE - VERY FRIENDLY SHARKS ',
                    'data' => [
                        'order'=>$order,
                        'quantity'=>$qty,
                    ]
                ]);
                //order confirmation to seller
                sendMail([
                    'view' => 'email.order.sale',
                    'to' => $order->seller->email,
                    'subject' => 'SUCCESSFUL SALE - VERY FRIENDLY SHARKS',
                    'data' => [
                        'order'=>$order,
                        'quantity'=>$qty,
                    ]
                ]);
            }
            return redirect()->route('checkout.success');
        }
        return redirect()->back()->with('error','Insufficient Wallet Funds.');
    }
    public function checkFunds($total)
    {
        $total = (float) $total;
        try {
            $balance = getUserWallet();
            return $balance >= $total ? true : false;
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function proceedTransaction($user , $seller , $seller_amount , $fee , $postage_val)
    {
        $debit_ref_Wallet = 0;
        $credit_refree_wallet =0;
        $platform_fee = $fee;
        $amount_to_be_paid = $seller->store->kyc_amount - $seller->store->kyc_refunded_amount;
        $kyc_refund = 0;
        if($user->vfs_wallet)
        {
            $vfs_wallet = (float)$seller_amount - $user->vfs_wallet;
            $wallet = $vfs_wallet < 0 ? abs($vfs_wallet) : 0; 
            if($user->vfs_wallet > 0)
            {
                $user->store->update(['vfs_wallet'=>$wallet]);
                $debit_ref_Wallet = (float)$seller_amount - $vfs_wallet;
            }
        }
        $referee = User::where('deleted_at',null)->where('id',$user->referr_by)->first();
        $order_amt = ($seller_amount  - $postage_val)+ $fee;
        if($referee && $order_amt >=20)
        {
            $order_price = (float)$seller_amount - (float)$postage_val;
            $referal_amount = ($referee->store->referal_percentage* $order_price) / 100;
            $max_can_receive = $referee->store->referal_limit - $referee->store->vfs_wallet_store < 0 ? 0 :$referee->store->referal_limit - $referee->store->vfs_wallet_store;
            $referal_amount = $referal_amount < $max_can_receive ? $referal_amount :$max_can_receive;
            $vfs_wallet = $referee->store->receive_referal && $referee->store->vfs_wallet_store <=  $referee->store->referal_limit ? $referal_amount  : 0;
            $credit_refree_wallet = number_format($vfs_wallet, 2, '.', '');
            $platform_fee = $platform_fee - $credit_refree_wallet;
        }
        $condition = $seller->store->kyc_refunded_amount < $seller->store->kyc_amount;
        if($amount_to_be_paid > 0 && $condition)
        {
            $kyc_refund = $platform_fee < $amount_to_be_paid ? $platform_fee : $amount_to_be_paid;
            $platform_fee = $platform_fee < $amount_to_be_paid ? 0 : $platform_fee - $amount_to_be_paid;
            $seller->store->kyc_refunded_amount = $seller->store->kyc_refunded_amount+ $kyc_refund;
            $seller->store->save();
        }
        $description = "Transfer from buyer to seller wallet on purchase";
        $transfer = $this->transferToUser($user ,$seller, $seller_amount , $description ,  $platform_fee, 'order-transfer' , $debit_ref_Wallet , $credit_refree_wallet, $kyc_refund);
        return (object)['transaction_id'=>$transfer];
    }
    
}
<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderReview;
use Illuminate\Http\Request;

class OrderReviewController extends Controller
{
    public function save(Request $request)
    {
        $request->validate([
            'remarks'=>'required',
            'rating'=>'required',
        ]);

        $order = Order::find($request->order_id);

        $review_by = auth()->user()->id == $order->buyer_id ? $order->buyer_id : $order->seller_id;
        $review_to = auth()->user()->id == $order->buyer_id ? $order->seller_id : $order->buyer_id;

        OrderReview::create([
            'order_id'=>$request->order_id,
            'rating'=>$request->rating,
            'remarks'=>$request->remarks,
            'review_by'=>$review_by,
            'review_to'=>$review_to,
        ]);

        return redirect()->back()->with('success','Review Added Successfully!');

    }
}

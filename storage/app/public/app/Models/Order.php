<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Order extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function seller()
    {
        return $this->hasOne(User::class , 'id','seller_id')->withTrashed();
    }
    public function buyer()
    {
        return $this->hasOne(User::class , 'id', 'buyer_id')->withTrashed();
    }
    public function postage()
    {
        return $this->hasOne(Postage::class , 'id', 'postage_id');
    }
    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
    public function ticket()
    {
        return $this->hasOne(Support::class);
    }
    public function delivery()
    {
        return $this->hasOne(UserAddress::class ,'id' , 'address');
    }
    public function detail()
    {
        return $this->hasMany(OrderDetail::class , 'order_id', 'id');
    }
    public function reviews()
    {
        return $this->hasMany(OrderReview::class , 'order_id', 'id');
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class , 'order_id', 'id');
    }
    public function notification()
    {
        return $this->morphOne('App\Models\Notification', 'model');
    }
    public function getReviewedByAuthAttribute()
    {
        return $this->reviews->where('review_by',auth()->user()->id)->first();
    }
    public function getDeliveryAddressAttribute()
    {
        return $this->street_address ? ($this->street_address ." , <br>". $this->postal_code ." , <br>". $this->city ." , <br>". $this->country) : '';
    }
    public function getPlatformFeeAttribute()
    {
        $postage_price = $this->postage ? $this->postage->price : 0;
        $total = $this->total - $postage_price;
        $pspConfig = vsfPspConfig();
        return $total* ($pspConfig->platform_fee /100);
    }
    public function getVatAttribute()
    {
        $postage_price = $this->postage ? $this->postage->price : 0;
        $total = $this->total - $postage_price;
        $pspConfig = vsfPspConfig();
        return ($pspConfig->vat_percentage/100) * $total;
    }
    public function getTotalCommisionAttribute()
    {
        return number_format($this->platform_fee, 2, '.', '');
    }
    public function getSellerAmountAttribute()
    {
        $transaction = Transaction::where('order_id',$this->id)->where('type','extra');
        $extraPayments = $transaction->get();
        $extraPrice = $extraPayments->sum('seller_amount');
        $amt = $this->total -$this->total_commision + $extraPrice;
        return number_format($amt, 2, '.', '');
    }
    protected function dispatchAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value=null) =>   $value == null ? "In Process" : Carbon::parse($value)->format('Y/m/d'),
        );
    }
    public function getRefundAmountAttribute()
    {
        // if($this->transactions)
        // {
        //     return $this->transactions->where('type','refund')->first()->amount;
        // }
        return '0';
    }
}

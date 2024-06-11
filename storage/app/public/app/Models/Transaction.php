<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;


class Transaction extends Model
{
    use HasFactory;
    protected $guarded = [];

     public function creditUser()
    {
        return $this->belongsTo(User::class,'credit_user')->withTrashed();
    }
    public function debitUser()
    {
        return $this->belongsTo(User::class,'debit_user')->withTrashed();
    }
    public function order()
    {
        return $this->belongsTo(Order::class,'order_id' ,'id');
    }
}

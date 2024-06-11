<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable =[
        'receiver_id',
        'sender_id',
        'order_id',
    ];
    public function messages()
    {
        return $this->hasMany(Message::class,'conversation_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class,'sender_id')->withTrashed();
    }
    public function receiver()
    {
        return $this->belongsTo(User::class,'receiver_id')->withTrashed();
    }
   
    public function order()
    {
        return $this->belongsTo(Order::class,'order_id');
    }
}

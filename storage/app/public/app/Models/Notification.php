<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function reciever()
    {
        return $this->hasOne(User::class , 'id' ,'recieve_by')->withTrashed();    
    }
    public function sender()
    {
        return $this->hasOne(User::class , 'id' ,'send_by')->withTrashed();    
    }
    public function model()
    {
        return $this->morphTo();
    }
    public function getSenderNameAttribute()
    {
        if($this->is_admin)
        {
            return 'Admin';
        }
        return $this->sender ? $this->sender->user_name : 'user';
    }
}   

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayoutRequest extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function user()
    {
        return $this->hasOne(User::class, 'id','user_id');
    }
    public function admin()
    {
        return $this->hasOne(User::class , 'id','updated_by');
    }
}

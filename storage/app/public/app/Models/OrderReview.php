<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderReview extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function by()
    {
        return $this->hasOne(User::class , 'id','review_by')->withTrashed();
    }
    public function to()
    {
        return $this->hasOne(User::class , 'id', 'review_to')->withTrashed();
    }
}

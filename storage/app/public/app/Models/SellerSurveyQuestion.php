<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerSurveyQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'parent_id',
        'option',
        'type',
        'status',
        'order',
    ];

    public function answers()
    {
        return $this->hasMany(SellerSurveyQuestion::class,'parent_id');
    }
}



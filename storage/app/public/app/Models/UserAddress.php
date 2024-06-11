<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $guarded = [];
     public function getFullAddressAttribute()
     {
        return $this->street_number ." ,". $this->city ." ,". $this->country;  
     }
}

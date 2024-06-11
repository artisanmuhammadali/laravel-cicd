<?php

namespace App\Models;

use App\Models\MTG\MtgUserCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable =[
        'user_id',
        'seller_id',
        'collection_id',
        'quantity',
        'price',
        'weight',
        'range',
    ];
    public function collection()
    {
        return $this->morphTo();
    }
    public function user()
    {
        return $this->hasOne(User::class);    
    }
}

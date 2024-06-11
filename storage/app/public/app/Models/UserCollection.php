<?php

namespace App\Models;

use App\Models\MTG\MtgCard;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class UserCollection extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function card()
    {
        return $this->belongsTo(MtgCard::class,'mtg_card_id','id');
    }
    public function getImgAttribute()
    {
        return $this->image ? 'https://img.veryfriendlysharks.co.uk/'.$this->image : asset('images/expansion/Placeholder.svg');
        
    }
}

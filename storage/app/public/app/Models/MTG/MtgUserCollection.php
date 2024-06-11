<?php

namespace App\Models\MTG;

use App\Models\BlockUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MtgUserCollection extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function card()
    {
        return $this->belongsTo(MtgCard::class,'mtg_card_id','id');
    }
    public function cart()
    {
        return $this->morphOne('App\Models\Cart', 'collection');
    }
    public function orderDetail()
    {
        return $this->morphOne('App\Models\OrderDetail', 'user_collection');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id')->withTrashed();
    }
    public function getCharFoilAttribute()
    {
        return $this->foil ? asset('images/single/ic-foil-off.png') : ""; 
    }
    public function getCharAlteredAttribute()
    {
        return $this->altered ? asset('images/single/ic-altered-off.png') : ""; 
    }
    public function getCharSignedAttribute()
    {
        return $this->signed ? asset('images/single/ic-signed-off.png') : ""; 
    }
    public function getCharGradedAttribute()
    {
        return $this->graded ? asset('images/single/ic-graded-off.png') : ""; 
    }
    public function getImgAttribute()
    {
        return $this->image ? 'https://img.veryfriendlysharks.co.uk/'.$this->image : asset('images/expansion/Placeholder.svg'); 
    }
    public function getConditionNameAttribute() 
    {
        $conditions = [
                "NM"=>'Near Mint',
                "LP"=>'Light Play',
                "MP"=>'Moderate Play',
                "HP"=>'Heavy Play',
                "DMG"=>'Damaged',
            ];
        return array_key_exists($this->condition , $conditions) ? $conditions[$this->condition] : 'Undefined';
    }
    public function getConditionBgAttribute() 
    {
        $condition_bg = [
                "NM"=>'#5ca2db',
                "LP"=>'#47e7b7',
                "MP"=>'#a4f48e',
                "HP"=>'#3b4856',
                "DMG"=>'#ef7a61',
            ];
        return array_key_exists($this->condition , $condition_bg) ? $condition_bg[$this->condition] : '#5ca2db';
    }

    public function scopeCheck($q)
    {
        $user_ids = User::where('verified',1)->where('deleted_at',null)->where('status','active')->pluck('id')->toArray();
        $block_ids = auth()->user() ?  BlockUser::where('user_id',auth()->user()->id)->pluck('block_user_id')->toArray() : 
        [];
        $ids = array_diff($user_ids , $block_ids);
        return $q->whereIn('user_id',$ids)->where('quantity','!=',0)->where('publish',1);
    }
}

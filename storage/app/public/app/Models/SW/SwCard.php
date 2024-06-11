<?php

namespace App\Models\SW;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\BlockUser;
use App\Models\SW\SwUserCollection;

class SwCard extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function set()
    {
        return $this->belongsTo(SwSet::class,'sw_set_id');
    }
    public function images()
    {
        return $this->hasMany(SwCardImage::class);
    }
    public function language()
    {
        return $this->hasMany(SwCardLanguage::class);
    }

    public function seo()
    {
        return $this->hasOne(SwCardSeo::class ,'sw_card_id','id');

    }

    public function collections()
    {
        return $this->hasMany(SwUserCollection::class,'sw_card_id','id');
    }
    public function getUrlTypeAttribute()
    {
        $index = array_search($this->card_type,cardTypeSlug());
        return $index ? $index : 'single-cards';
    }
    public function getPngImageAttribute(){
        if($this->card_type != "completed")
        {
            $imgg = $this->images ? $this->images->where('type','back')->first() : null;
            $img = $imgg ? $imgg : $this->images->where('type','front')->first();
            return $img ? $img->url : 'https://errors.scryfall.com/soon.jpg';
        }
        else{
            return 'https://beta.veryfriendlysharks.co.uk/upload/expansion/All.svg';
        }
        
    }

    public function getListingCollectionAttribute()
    {
        $user_ids = User::where('verified',1)->where('status','active')->pluck('id')->toArray();
        if(auth()->user()){
            $block_users = BlockUser::where('user_id',auth()->user()->id)->pluck('block_user_id')->toArray();
            $block_by = BlockUser::where('block_user_id',auth()->user()->id)->pluck('user_id')->toArray();
            $block_ids = array_merge($block_by , $block_users);
            $ids = array_diff($user_ids , $block_ids);
            return $this->collections->whereIn('user_id',$ids)->where('quantity','!=',0)->where('publish',1);
        }
        else{
            return $this->collections->whereIn('user_id',$user_ids)->where('quantity','!=',0)->where('publish',1);
        }
    }

    public function getFrontImageAttribute(){
        $img = $this->images ? $this->images->where('type','front')->first() : null;
        return $img ? $img->url : 'https://errors.scryfall.com/soon.jpg';
    }

    public function getBackImageAttribute(){
        $img = $this->images ? $this->images->where('type','back')->first() : null;
        return $img ? $img->url : false;
    }

    public function getBestPriceCardsAttribute()
    {
        if($this->listing_collection){
            return $this->listing_collection->sortBy('price')->values()->take(5);
        }
        return [];
    }
    public function getVersionsAttribute()
    {
        $versions = [];
        if($this->parent_id == null) // this card is parent condition no 1
        {
            $versions = SwCard::where('parent_id',$this->id)->get();
        }
        if($this->parent_id != null) // this card is child condition no 2
        {
            $parent = SwCard::where('id',$this->parent_id)->first();
            $childs = SwCard::where('parent_id',$parent->id)->pluck('id')->toArray();
            $ids  = array_merge($childs , [$parent->id]);
            $siblings_id = array_diff($ids , [$this->id]);
            $versions = SwCard::whereIn('id',$siblings_id)->get();
        }
        return $versions;
        
    }

    
    public function scopeActive($query)
    {
         return $query->where('is_active', true);
    }

    public function getUrlSlugAttribute()
    {
        return  $this->set->slug ? $this->set->slug : null;
    }

    
}

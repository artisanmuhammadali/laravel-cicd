<?php

namespace App\Models\MTG;

use App\Models\MTG\MtgCard;
use App\Models\MTG\MtgSetSeo;
use App\Models\MTG\MtgStandardSet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;


class MtgSet extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function childs()
    {
        return $this->hasMany(MtgSet::class,'parent_set_code','code');
    }
    public function parent()
    {
        return $this->hasOne(MtgSet::class,'code','parent_set_code');
    }
    public function cards()
    {
        return $this->hasMany(MtgCard::class , 'set_code' , 'code');
    }
    public function seo()
    {
        return $this->hasMany(MtgSetSeo::class,'mtg_set_id','id');
    }
    public function scopeActive($query)
    {
         return $query->where('is_active', true);
    }
   public function standardSet()
    {
        return $this->hasMany(MtgStandardSet::class, 'mtg_set_id' , 'id');
    }
    public function language()
    {
        return $this->hasMany(MtgSetLanguage::class,'mtg_set_id','id');
    }
    public function getSetLanguagesAttribute()
    {
        return $this->language->count() > 0 ?  $this->language->pluck('value','key')->toArray() : null;
    }
    public function getSeoDetailAttribute()
    {
        return $this->seo;    
    }
    protected function icon(): Attribute
    {
        return Attribute::make(
            get: fn (string $value=null) =>   $value == null ? "https://veryfriendlysharks.co.uk/images/expansion/Placeholder.svg" : (str_contains($value, 'https://svgs.scryfall.io') ? $value : asset($value)),
        );
    }
    public function getUrlTypeAttribute()
    {
        if($this->custom_type == "singles")
        {
            return $this->slug;
        }
        return Str::slug($this->custom_type);
    }
    public function getFirstSingleCardAttribute()
    {
        return $this->cards->where('card_type','single')->first();
    }
    public function getFirstSealedCardAttribute()
    {
        return $this->cards->where('card_type','sealed')->first();
    }
    public function getFirstCompletedCardAttribute()
    {
        return $this->cards->where('card_type','completed')->first();
    }
    public function getSingleCountAttribute()
    {
        return $this->cards->where('card_type','single')->count();
    }
    public function getTotalInactiveCountAttribute()
    {
        return $this->cards->where('is_active',0)->count();
    }
    public function getInactiveCountAttribute()
    {
        return $this->cards->where('card_type','single')->where('is_active',0)->count();
    }
    public function getSealedCountAttribute()
    {
        return $this->cards->where('card_type','sealed')->count();
    }
    public function getCompletedCountAttribute()
    {
        return $this->cards->where('card_type','completed')->count();
    }


}

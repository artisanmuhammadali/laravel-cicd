<?php

namespace App\Models\SW;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SwSet extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'code',
        'slug',
        'is_active',
        'sw_created_at',
        'sw_updated_at',
        'sw_published_at',
        'published_at',
        'card_type',
        'title',
        'heading',
        'sub_heading',
        'meta_description',
        'banner',
        'icon',
    ];

    public function scopeActive($query)
    {
         return $query->where('is_active', true);
    }
    
    public function cards()
    {
        return $this->hasMany(SwCard::class);
    }


    public function getFirstSingleCardAttribute()
    {
        return $this->cards->where('card_type','single')->where('is_active',1)->whereNull('parent_id')->first();
    }
    public function getSingleCountAttribute()
    {
        return $this->cards->where('card_type','single')->where('is_active',1)->whereNull('parent_id')->count();
    }

    public function getFirstSealedCardAttribute()
    {
        return $this->cards->where('card_type','sealed')->where('is_active',1)->whereNull('parent_id')->first();
    }
    public function getSealedCountAttribute()
    {
        return $this->cards->where('card_type','sealed')->where('is_active',1)->whereNull('parent_id')->count();
    }

    public function getFirstCompletedCardAttribute()
    {
        return $this->cards->where('card_type','completed')->where('is_active',1)->whereNull('parent_id')->first();
    }
    public function getCompletedCountAttribute()
    {
        return $this->cards->where('card_type','completed')->where('is_active',1)->whereNull('parent_id')->count();
    }
}

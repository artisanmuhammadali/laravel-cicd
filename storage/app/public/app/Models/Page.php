<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable =[
        'title',
        'short_title',
        'slug',
        'meta_description',
        'content',
        'appearance_type',
        'status',
        'type',
    ];

    public function contents()
    {
        return $this->hasMany(TableOfContent::class,'page_id');
    }

    public function getShortNameAttribute()
    {
        return $this->short_title ?? $this->title;
    }
}

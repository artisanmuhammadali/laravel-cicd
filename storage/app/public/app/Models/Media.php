<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable =[
        'title',
        'url',
        'slug',
        'status',
        'type',
    ];

    public function getCompleteUrlAttribute()
    {
        return 'https://img.veryfriendlysharks.co.uk/'.$this->url;
    }
}

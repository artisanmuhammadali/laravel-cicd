<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableOfContent extends Model
{
    use HasFactory;

    protected $fillable =[
        'page_id',
        'content',
        'link',
        'status',
    ];
}

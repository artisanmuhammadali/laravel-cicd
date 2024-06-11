<?php

namespace App\Models\SW;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SwCardSeo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'heading',
        'sub_heading',
        'meta_description',
        'sw_card_id',
    ];
}

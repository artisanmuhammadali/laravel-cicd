<?php

namespace App\Models\MTG;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MtgCardAttribute extends Model
{
    use HasFactory;

    protected $fillable=[
        'mtg_card_id',
        'mtg_attribute_id',
    ];
}

<?php

namespace App\Models\MTG;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MtgCardSeo extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function card()
    {
        return $this->belongsTo(MtgCard::class , 'mtg_set_id','id');
    }
}

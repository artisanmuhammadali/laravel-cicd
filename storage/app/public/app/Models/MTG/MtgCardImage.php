<?php

namespace App\Models\MTG;

use App\Models\MTG\MtgCard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MtgCardImage extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function mtgCard()
    {
        $this->belongsTo(MtgCard::class, 'mtg_card_id', 'id');
    }
}

<?php

namespace App\Models\MTG;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;


class MtgCardFace extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function card()
    {
        return $this->belongsTo(MtgCard::class , 'mtg_card_id','id');
    }
    protected function oracleText(): Attribute
    {
        return Attribute::make(
            get: fn (string $value=null) =>   $this->card->card_type !='single' ? MtgCardsOracleText($this->card->card_type) : $value,
        );
    }
}

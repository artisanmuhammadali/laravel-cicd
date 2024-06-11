<?php

namespace App\Models\MTG;
use App\Models\MTG\MtgSet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MtgStandardSet extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function mtgSet()
    {
        return $this->belongsTo(MtgSet::class,'mtg_set_id');
    }
}

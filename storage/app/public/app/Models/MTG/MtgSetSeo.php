<?php

namespace App\Models\Mtg;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MtgSetSeo extends Model
{
    use HasFactory;
    public function set()
    {
        return $this->belongsTo(MtgSet::class , 'mtg_set_id','id');
    }


}

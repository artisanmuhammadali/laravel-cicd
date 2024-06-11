<?php

namespace App\Models\MTG;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MtgAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];
}

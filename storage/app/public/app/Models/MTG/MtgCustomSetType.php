<?php

namespace App\Models\MTG;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MtgCustomSetType extends Model
{
    use HasFactory;
    protected $fillable = ['name','slug'];
}

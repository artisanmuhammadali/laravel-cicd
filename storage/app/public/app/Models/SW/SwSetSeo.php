<?php

namespace App\Models\SW;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SwSetSeo extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'heading',
        'sub_heading',
        'meta_description',
        'sw_set_id',
        'type',
    ];
}

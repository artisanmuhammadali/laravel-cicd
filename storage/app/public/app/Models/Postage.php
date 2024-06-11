<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use PhpOffice\PhpSpreadsheet\Calculation\Logical\Boolean;

class Postage extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected function isTrackable(): Attribute
    {
        return Attribute::make(
            get: fn($value) =>   $value == false ? 'false' : 'true',
        );
    }
    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn($value) =>   number_format($value, 2, '.', ''),
        );
    }

}

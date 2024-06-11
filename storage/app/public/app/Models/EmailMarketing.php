<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailMarketing extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function sender()
    {
        return $this->hasOne(User::class , 'id','sent_by')->withTrashed();
    }
}

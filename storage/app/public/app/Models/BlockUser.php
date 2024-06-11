<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockUser extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class,'block_user_id');
    }
}

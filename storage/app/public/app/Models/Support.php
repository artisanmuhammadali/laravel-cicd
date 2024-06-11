<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    use HasFactory;
    protected $fillable = [
        'category',
	'desk_id',
	'email',
	'subject',
	'issue',
	'attachment',
	'status',
	'report_to_id',
	'report_by_id',
    'order_id',
    ];
    public function reportBy()
    {
        return $this->hasOne(User::class , 'id', 'report_by_id')->withTrashed();
    }
    public function reportTo()
    {
        return $this->hasOne(User::class , 'id', 'report_to_id')->withTrashed();
    }
}

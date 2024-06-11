<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable =[
        'label',
        'timer',
        'start_from',
        'end_on',
        'btn_text',
        'btn_link',
        'text',
        'background',
        'type',
    ];
    public function getViewTimerAttribute()
    {
        return Carbon::parse($this->timer)->format('Y-m-d');    
    }
    public function getViewStartAttribute()
    {
        return Carbon::parse($this->start_From)->format('Y-m-d');    
    }
    public function getViewEndAttribute()
    {
        return Carbon::parse($this->end_on)->format('Y-m-d');    
    }
    public function scopeActive($query)
    {
        $currentDate = Carbon::now()->toDateString();
        $query->whereDate('start_from', '<=', $currentDate)
        ->whereDate('end_on', '>=', $currentDate);
    }
}

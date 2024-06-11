<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\SyncsWithFirebase;

class Message extends Model
{
    use SyncsWithFirebase;
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class,'user_id')->withTrashed();
    }
    public function conversation()
    {
        return $this->belongsTo(Conversation::class,'conversation_id');
    }
    public function notification()
    {
        return $this->morphOne('App\Models\Notification', 'model');
    }
    public function getMediaAttribute()
    {
        return 'https://img.veryfriendlysharks.co.uk/'.$this->file;
    }
}

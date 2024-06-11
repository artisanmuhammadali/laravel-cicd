<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Exception;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index($id)
    {
        try {    
            $notify = Notification::findOrFail($id);
            $notify->is_readed = 1;
            $notify->save();  
            return $notify->route ? redirect($notify->route) : redirect()->back();
        } catch (Exception $e) {
            return redirect()->back();
        }
    }
    public function readAll()
    {
        Notification::where('recieve_by',auth()->user()->id)->update(['is_readed'=>1]);
        return redirect()->back()->with('success','All notifications has been marked as read!');
    }

}

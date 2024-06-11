<?php

namespace App\Http\Controllers\User\MTG;

use App\Http\Controllers\Controller;
use App\Models\BlockUser;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderChatController extends Controller
{
    public function chat(Request $request)
    {
        $messages = [];
        $id = null;

        $conversation_id = null;
        $idss = chatUserIds();
        $chats = User::withTrashed()->other()->when($request->keyword,function($q)use($request){
                 $q->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%$request->keyword%"]);
        })->whereIn('id',$idss)->when(count($idss) > 0,function($q)use($idss){
           $q->orderBy(\DB::raw('FIELD(id, ' . implode(',', $idss) . ')'));
        })->get();

        if($request->ajax())
        {
            $contacts = User::withTrashed()->other()->contactUsers()->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%$request->keyword%"])->get();
            $view = view('user.chat.appendContacts',get_defined_vars())->render();
            return response()->json(['html' => $view]);
        }
       
        if ($request->id) {
            $id = $request->id;

            $blockOther = BlockUser::where('user_id',auth()->user()->id)->where('block_user_id',$id)->first();
            $blockby = BlockUser::where('user_id',$id)->where('block_user_id',auth()->user()->id)->first();
            $alert = $blockOther ? 'Unblock this user to start conversation.':'';
            $alert = !$blockOther && $blockby ? 'You cannot send message to this user.':$alert;
            if($blockOther || $blockby)
            {
                return redirect()->route('user.chat')->with('error',$alert);
            }
            $current_user = User::withTrashed()->where('id', $id)->first();
            $conversation_id = Conversation::where('sender_id', Auth::Id())->where('receiver_id', $id)->pluck('id')->first();
            if (is_null($conversation_id)) {
                $conversation_id = Conversation::where('receiver_id', Auth::Id())->where('sender_id', $id)->pluck('id')->first();
            }
            if (is_null($conversation_id)) {
                $conversation_id = Conversation::create([
                    'sender_id' => Auth::Id(),
                    'receiver_id' => $id
                ]);
                $conversation_id = $conversation_id->id;
            }
        }
        return view('user.chat.index', get_defined_vars());
    }

    public function getChat(Request $request)
    {
        $messages = Message::where('conversation_id', $request->id)->get();

        return view('user.chat.messages', get_defined_vars());
    }

    public function saveChat(Request $request)
    {
        $user = auth()->user();

        $m = new Message();
        $m->conversation_id = $request->con_id;
        $m->user_id = $user->id;
        $m->message = $request->message;
        if($request->media)
        {
            $image = uploadFile($request->media,'media','base64');
            $m->file =  $image;
        }
        $m->ip = $request->ip();
        $m->save();

        $con = $m->conversation;
        $con->updated_at = now();
        $con->save();

        $notify_receiver = User::withTrashed()->find($request->receiver_id);
        $message = getNotificationMsg('message','');
        $message = $message;

        $ids = [$con->sender_id , $con->receiver_id];
        $other_user = auth()->user()->id == $con->sender_id  ? $con->receiver_id: $con->sender_id;
        $receiver = $user->role == "admin" && !in_array($user->id , $ids) ? $other_user : $user->id ;
        $route = route('user.chat').'?id='.$receiver;

        sendNotification($notify_receiver->id,$user->id , 'message',$message ,$m , $route);

        return response()->json('sent');
    }
}

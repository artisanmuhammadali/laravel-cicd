<?php

namespace App\Http\Controllers\Admin\MTG;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function conversation(Request $request)
    {
        $messages = [];
        $id = null;

        $conversation_id = null;
        $idss = chatUserIds();
        $chats = User::other()->when($request->keyword,function($q)use($request){
                 $q->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%$request->keyword%"]);
        })->whereIn('id',$idss)
        ->when(count($idss) > 0,function($q)use($idss){
             $q->orderBy(\DB::raw('FIELD(id, ' . implode(',', $idss) . ')'));
        })->get();

        if($request->ajax())
        {
            $contacts = User::other()->contactUsers()->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%$request->keyword%"])->get();
            $view = view('user.chat.appendContacts',get_defined_vars())->render();
            return response()->json(['html' => $view]);
        }
       
        if ($request->id) {
            $id = $request->id;
            $current_user = User::where('id', $id)->first();
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
        $typee = 'custom';
        return view('admin.mtg.chat.index', get_defined_vars());
    }

    public function chat(Request $request)
    {
        if($request->id == 0)
        {
            return redirect()->back()->with('error','No Chat Exist');
        }
        $messages = [];
        $conversation_id = $request->id;
        $id = $request->id;
        $conversations = Conversation::with('messages')
        ->addSelect([
            'created_att' => Message::select('created_at')
                ->whereColumn('conversation_id', 'conversations.id')
                ->orderBy('created_at', 'desc')
                ->limit(1)
        ])
        ->orderBy('created_att', 'desc')
        ->get();

        if ($request->id) {
            $conversation = Conversation::where('id', $request->id)->first();
        }
        
        return view('admin.mtg.chat.index', get_defined_vars());
    }

    public function getChat(Request $request)
    {
        $conn = Conversation::where('id', $request->id)->firstOrFail();
        $messages = Message::where('conversation_id', $request->id)->get();

        return view('admin.mtg.chat.messages', get_defined_vars());
    }

    public function saveChat(Request $request)
    {
        $user = auth()->user();
        $id = $user->id;

        $m = new Message();
        $m->conversation_id = $request->con_id;
        $m->user_id = $id;
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

        $con = Conversation::find($request->con_id);
        $user_ids = [$con->sender_id , $con->receiver_id];
        foreach($user_ids  as $id)
        {
            $notify_receiver = User::find($id);
            $message = getNotificationMsg('message','');
            $message = $message;
            sendNotification($notify_receiver->id,$user->id , 'message',$message ,$m ,null);
        }
        return response()->json('sent');
    }
}

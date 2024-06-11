<?php

namespace App\Services\Front;

use App\Models\User;
use Config;
use Zendesk\API\HttpClient as ZendeskAPI;
use App\Models\Support;
use App\Models\UserStore;
use Exception;

class SupportService {

    public function create($req)
    {
        try{
            $zendesk = Config::get('helpers.zendesk');
            $subdomain = $zendesk['subdomain'];
            $username  = $zendesk['username'];
            $token     = $zendesk['token'];
            $client = new ZendeskAPI($subdomain);
            $client->setAuth('basic', ['username' => $username, 'token' => $token]);
            
            $checkUser = null;
            $checkUser = checkZendeskUser($req->email);

            if(!$checkUser){
                $checkUser = $client->users()->create(array(
                    'name'  => $req->email,
                    'email' => $req->email,
                    'ticket_restriction' => "requested",
                ));
            }

            $user = User::where('email',$req->email)->first();
            if($user == null){
                $user = ['email'=>$req->email , 'user_name'=>$req->email];
            }
            else{
                $zendesk_id = $checkUser->id ?? $checkUser->user->id;
                $zen_id = $user->store->zendesk_id ? "" :UserStore::where('user_id',$user->id)->update(['zendesk_id'=>$zendesk_id]);
            }

            if($req->hasFile('attachment_file'))
            {
                $name = $req->attachment_file->getClientOriginalName();
                $path = 'upload/support/';
                $fileName = $path.$name;
                $fileUplaod = uploadAttachment($req->attachment_file,'upload/support');
                $attachmentData = array(
                    'file' => getcwd().'/'.$fileUplaod,
                    'name' => $name
                );
                $newTicket = $client->tickets()->attach($attachmentData)->create(array(
                    'subject'  => $req->subject,
                    'requester_id' => $checkUser->id ?? $checkUser->user->id,
                    'comment'  => array(
                        'body' => $req->issue,
                    ),
                    'tags'=>[$req->tag ?? null],
                    'priority' => 'normal',
                    'file' => $attachmentData['file']
                ));
                unlink(getcwd().'/'.$fileUplaod);
            }
            else{

                $newTicket = $client->tickets()->create([
                    'subject'  => $req->subject,
                    'requester_id' => $checkUser->id ?? $checkUser->user->id,
                    'comment'  => [
                        'body' => $req->issue,
                    ],
                    'tags'=>[$req->tag ?? null],
                    'priority' => 'normal'
                ]);
            }
            $status = $newTicket->ticket->status;
            $desk_id = $newTicket->ticket->id;
            sendMail([
                    'view' => 'email.support-ticket',
                    'to' => $user->email ?? $user['email'],
                    'subject' => 'SUPPORT TICKET  - VERY FRIENDLY SHARKS',
                    'data' => [
                        'desk_id' => $desk_id,
                        'email' => $user->email ?? $user['email'],
                        'username' => $user->user_name ?? $user['user_name'],
                        'subject' => $req->subject,
                        'date' => now()
                    ]
                ]);
            $req->merge(['desk_id'=> $desk_id , 'attachment'=>$fileUplaod ?? '', 'status'=>$status]);
            Support::create($req->except('_token','terms','g-recaptcha-response','attachment_file','tag','type','reason'));            
        }
        catch(Exception $e)
        {
        }
        $msg = 'Your Response has been sent to the admin!';
        return $msg;
    }
}

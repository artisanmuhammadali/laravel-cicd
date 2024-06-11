<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Support;
use App\Models\UserStore;
use Exception;
use Illuminate\Support\Facades\Config;
use Zendesk\API\HttpClient as ZendeskAPI;

class SupportController extends Controller
{
    public function list()
    {
        try{
            $zendesk = Config::get('helpers.zendesk');
            $subdomain = $zendesk['subdomain'];
            $username  = $zendesk['username'];
            $token     = $zendesk['token'];
            $client = new ZendeskAPI($subdomain);
            $client->setAuth('basic', ['username' => $username, 'token' => $token]);
            
            $desk = Support::where('email',auth()->user()->email)->first();
            $user = auth()->user();
            $store = UserStore::where('user_id',$user->id)->first();
            if(!$store->zendesk_id)
            {
                $checkUser =checkZendeskUser($user->email);
                if(!$checkUser)
                {
                    $checkUser = $client->users()->create(array(
                        'name'  => $user->user_name,
                        'email' => $user->email,
                        'ticket_restriction' => "requested",
                    ));
                }
                $zendesk_id = $checkUser->id ?? $checkUser->user->id;
                $store->update(['zendesk_id'=>$zendesk_id]);
            }
            $store->refresh();
            $requester_id = $store->zendesk_id;
            $tickets =  $client->users($requester_id)->tickets()->requested();
            $list = $tickets->tickets;
            return view('user.support.list',get_defined_vars());
        }
        catch(Exception $e)
        {
            return redirect()->back()->with('error','Something went wrong.');
        }
    }
}

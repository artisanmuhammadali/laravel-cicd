<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserReferralType;
use App\Http\Requests\Admin\EmailRequest;
use App\Jobs\MarketingEmailJob;
use App\Models\Media;
use App\Models\EmailMarketing;
use App\DataTables\Admin\MarketingEmailDataTable;
use App\DataTables\Admin\UserEmailDataTable;



class MarketingController extends Controller
{
    public function emails(){
        $user_referral_types = UserReferralType::all();
        return view('admin.marketing.email', get_defined_vars());
    }

    public function list(MarketingEmailDataTable $dataTable)
    {
        $assets = ['data-table'];
        return $dataTable->render('admin.marketing.list', get_defined_vars());
    }

    public function detail(UserEmailDataTable $dataTable,$id)
    {
        $email = EmailMarketing::find($id);
        $assets = ['data-table'];
        return $dataTable->with(['id' => $id])->render('admin.marketing.detail', get_defined_vars());
    }


    public function send(EmailRequest $request){
        $validated = $request->validate([
            'subject' => 'required|max:150',
            'body' => 'required',
        ]);
        $users = User::where('role','!=','admin')->when($request->status,function($q)use($request){
               $q->where('status',$request->status);
        })->when($request->role,function($q)use($request){
               $q->where('role',$request->role);
        })->when($request->newsletter == 'on',function($q)use($request){
               $q->whereHas('store',function($que){
                $que->where('newsletter','on');
               });
        })->when($request->referal_type,function($q)use($request){
               $q->whereHas('store',function($que)use($request){
                $que->where('referal_type',$request->referal_type);
               });
        })->when($request->newsletter == 'all',function($q)use($request){
                $q->where('deleted_at',null);
        })->when($request->unverified == 'kyc',function($q)use($request){
                $q->where('kyc_verify',0)->where('role','!=','buyer');
        })->when($request->unverified == 'kyc_ver',function($q)use($request){
            $q->where('kyc_verify',1)->where('role','!=','buyer');
        })->when($request->unverified == 'kyb',function($q)use($request){
                $q->where('ubo_verify',0)->where('role','business');
        })->when($request->unverified == 'kyb_ver',function($q)use($request){
            $q->where('ubo_verify',1)->where('role','business');
        })->get();

        // $users = User::where('id', 231)->get();
        $request->body = str_replace('<figure','<figure style="text-align:center;"',$request->body);
        $request->body = str_replace('<img','<img width="80%" height="auto" style="text-align:center;width: 80% !important;"',$request->body);
       $req_news = $request->newsletter == 'all' ? 'All users' : 'Only marketing users';
       $req_unveri = getVerified($request->unverified);
       $request->merge(['sent_by' => auth()->user()->id,'newsletter' => $req_news,'unverified' => $req_unveri]);
       $email_mark = EmaiLmarketing::create($request->except('_token'));

        MarketingEmailJob::dispatchSync($users,$request->subject,$request->body,$email_mark->id);

        return redirect()->route('admin.marketing.list')->with('message','Mail Successfully sent!');

    }

    public function upload(Request $request)
    {
        $image = null;
        if($request->upload)
        {
            $image = uploadFile($request->upload,'image','custom');
            $media = new Media();
            $media->url = $image;
            $media->save();
            return response()->json(['fileName' => $image, 'uploaded'=> 1,'url' => 'https://img.veryfriendlysharks.co.uk/'.$image]);

        }
        return response()->json(['url' => 'https://img.veryfriendlysharks.co.uk/'.$image]);
    }
}

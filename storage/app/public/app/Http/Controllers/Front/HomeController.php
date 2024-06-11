<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Faq;
use App\Models\Page;
use App\Services\Front\SupportService;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\SupportRequest;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Cookie;
use Jenssegers\Agent\Agent;


class   HomeController extends Controller
{
    private $supportService;
    public function __construct(SupportService $supportService)
    {
        $this->supportService = $supportService;
    }

    public function index()
    {
        $page = 'home';
        return view('front.index',compact('page'));
    }

    

    public function lost()
    {
        return view('front.lost');
    }

    public function help()
    {
        $report_condition = request()->type == "report";
        $report_user = $report_condition ? User::where('user_name',request()->user_name)->firstOrFail() : null;
        return view('front.help',compact('report_condition','report_user'));
    }

    

    public function faqs()
    {
        $faqs = Faq::orderBy('id','desc')->get()->groupBy('category_id');

        return view('front.faqs',get_defined_vars());
    }


    public function referralLink($user_name)
    {
        if(auth()->user())
        {
            return redirect()->route('index');
        }
        $user = User::where('user_name',$user_name)->firstOrFail();
        return view('front.countdown',get_defined_vars());
    }

    public function supportForm(SupportRequest $req)
    {
        try{
            $msg = $this->supportService->create($req);
            return redirect()->back()->with('success',$msg);
        }
        catch(Exception $e)
        {
            return redirect()->back()->with('error','Something Went Wrong.');
        }
    }

    public function testCollectorNumber()
    {
       $cards =  DB::table('mtg_cards')->where('card_type','single')->where('collector_number','2G1c')->first();
       $c  =(int)'2G1';
       dd($cards,$c);
        //   ->update([
        // 'int_collector_number' => DB::raw('CAST(collector_number AS SIGNED)')
        // ]);
        dd(123);

    }

    public function page($slug = null)
    {
        $page = Page::where('slug',$slug)->firstOrFail();
        $bar = $page->contents->count() > 0 ? true : false;
        return view('front.customePage',get_defined_vars());
    }

    public function getVisitorInfo(Request $request)
    {
        $url =url()->previous();
        $now = now();
        $agent = new Agent();
        $device =  $agent->isMobile() ? 'mobile' : ($agent->isTablet() ? 'Tablet' : 'Desktop');
        $ipAddress = request()->ip();
        $visitor = DB::table('visitors')->where('page',$url)->where('ip', $ipAddress)->whereDate('created_at', $now)->first();
        if(!$visitor)
        {
            DB::table('visitors')->insert([
                'ip' => $ipAddress,
                'user_id' => auth()->user()->id ?? null,
                'device' => $device ?? '',
                'page' => $url,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

    }
    public function cookies(Request $request)
    {
        $script = view('front.components.cookies.script',get_defined_vars())->render();
        Cookie::queue('cookies', $request->perimsion, 5256000);
        Cookie::queue('google-cookies', $request->google, 5256000);
        Cookie::queue('meta-cookies', $request->meta, 5256000);
        $html = $request->perimsion == "accept" ? $script : "";
        return response()->json(['script'=>$html]);
    }
    public function success()
    {   
       return view('auth.success');
    }
}

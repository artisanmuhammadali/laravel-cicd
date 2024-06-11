<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Settings');
    }
    public function cms($type = 'general')
    {
        return view('admin.mtg.cms.'.$type,get_defined_vars());
    }

    public function store(Request $request)
    {
        $setting = $request->except('_token');
        foreach ($setting as $key => $value) {
            // if (empty($value)) {
            //     continue;
            // }

            $set = Setting::where('key', $key)->first() ?: new Setting();

            if(in_array($key,['video_2','video_1']))
            {
                $url = $value;
                if (strpos($url, 'watch?v=') !== false) {
                  $value = str_replace('watch?v=', 'embed/', $url);
                 }
            }
            $set->key = $key;
            $set->value = $value == null ? '' : $value;
            $set->save();

            if ($request->hasFile($key)) {
                $existing = Setting::where('key', '=', $key)->first();
                if ($existing) {
                    $image = uploadFile($request->file($key),'file','custom');
                    Setting::where('key', '=', $key)->update([
                        'value' => 'https://img.veryfriendlysharks.co.uk/'.$image,
                    ]);
                }
            }
        }
        return redirect()->back()->with('message', 'The Site Config has been save/updated!');
    }
}

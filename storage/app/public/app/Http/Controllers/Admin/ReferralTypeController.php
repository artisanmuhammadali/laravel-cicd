<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserReferralType;


class ReferralTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Settings_Referral_Type');
    }
    public function index()
    {
        $list = UserReferralType::all();
        return view('admin.referral-type.list',get_defined_vars());
    }
    public function modal(Request $request)
    {
        $id = $request->id;
        $item = $id == null ? null : UserReferralType::findOrFail($id);
        $html = view('admin.referral-type.modal',get_defined_vars())->render();
        return response()->json(['html'=>$html]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
        ]);    
        if($request->id){
            $item = UserReferralType::findOrFail($request->id);
            $item->update($request->except('_token','id'));
            $msg = "Referral type Updated Successfully";
        }
        else{
            UserReferralType::create($request->except('_token','id'));
            $msg = "Referral type Created Successfully!";
        }
        return response()->json(['success'=>$msg]);
    }
    public function delete($id)
    {
        $item = UserReferralType::find($id)->delete();
        return redirect()->back()->with('message',"Deleted Successfully!");
    }
}

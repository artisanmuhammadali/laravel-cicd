<?php

namespace App\Http\Controllers\Admin\MTG;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MTG\MtgStandardSet;
use App\Models\MTG\MtgSet;


class StandardSetController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Mtg_Set');
    }
    public function index()
    {
        
        // active()
        //                     ->where('type','expansion')
        //                     ->whereJsonDoesntContain('legalities','standard:not_legal')
        //                     ->whereJsonContains('legalities','standard:legal')
        //                     ->get();
        $Standard_list = MtgStandardSet::all();
        return view('admin.standard_set.list',get_defined_vars());
    }
     public function modal(Request $request)
    {
        $ignore = MtgStandardSet::all()
                        ->pluck('mtg_set_id')
                        ->toArray();
        $sets = MtgSet::whereNotIn('id',$ignore)
                        ->get();
        $html = view('admin.standard_set.modal',get_defined_vars())->render();
        return response()->json(['html'=>$html]);
    }
    public function store(Request $request)
    {
        MtgStandardSet::create($request->except('_token',));
        return response()->json(['success'=>'Standard Set Created Successfully!']);
    }
    public function delete($id)
    {
        $item = MtgStandardSet::find($id)->delete();
        return redirect()->back()->with('message',"Deleted Successfully!");
    }
}

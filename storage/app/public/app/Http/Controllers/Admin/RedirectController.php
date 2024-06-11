<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Redirect;


class RedirectController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Redirect');
    }
    public function index()
    {
        $list = Redirect::all();
        return view('admin.redirect.list',get_defined_vars());
    }
    public function modal(Request $request)
    {
        $id = $request->id;
        $item = $id == null ? null : Redirect::findOrFail($id);
        $html = view('admin.redirect.modal',get_defined_vars())->render();
        return response()->json(['html'=>$html]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'to'=>'required',
            'from'=>'required',
        ]);    
        if($request->id){
            $item = Redirect::findOrFail($request->id);
            $item->update($request->except('_token','id'));
            $msg = "Redirect Updated Successfully";
        }
        else{
            Redirect::create($request->except('_token','id'));
            $msg = "Redirect Created Successfully!";
        }
        return response()->json(['success'=>$msg]);
    }
    public function delete($id)
    {
        $item = Redirect::find($id)->delete();
        return redirect()->back()->with('message',"Deleted Successfully!");
    }
}

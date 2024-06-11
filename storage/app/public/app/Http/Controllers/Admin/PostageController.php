<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\DataTables\Admin\PostageDataTable;
use App\Models\Postage;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PostageController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Psp_Postage');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(PostageDataTable $dataTable)
    {
        $assets = ['data-table'];
        return $dataTable->render('admin.postage.index', get_defined_vars());
    }
    /**
     * Show the form for creating a new resource.
     */
    public function modal(Request $request)
    {
        $id = $request->id;
        $item = $id == null ? null : Postage::findOrFail($id);
        $html = view('admin.postage.modal',get_defined_vars())->render();
        return response()->json(['html'=>$html]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'price'=>'required',
            'max_order_price'=>'required',
            'weight'=>'required',
            'is_trackable'=>'required',
        ]);    
        if($request->id){
            $item = Postage::findOrFail($request->id);
            $item->update($request->except('_token','id'));
            $msg = "Custom Type Updated Successfully!";
        }
        else{
            Postage::create($request->except('_token','id'));
            $msg = "Custom Type Created Successfully!";
        }
        return response()->json(['success'=>$msg]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Postage::findOrFail($id)->delete();
        return redirect()->back()->with('message','Custom Type Deleted Successfully!');
    }
}

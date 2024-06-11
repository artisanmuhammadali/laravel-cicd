<?php

namespace App\Http\Controllers\Admin\MTG\Setting;

use App\Http\Controllers\Controller;
use App\DataTables\Admin\Mtg\Settings\CustomTypeDataTable;
use App\Models\MTG\Mtg;
use App\Models\MTG\MtgCustomSetType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Settings_Custom_Type');
    }
    public function index(CustomTypeDataTable $dataTable)
    {
        $assets = ['data-table'];
        return $dataTable->render('admin.mtg.settings.customType.index', get_defined_vars());
    }
    /**
     * Show the form for creating a new resource.
     */
    public function modal(Request $request)
    {
        $id = $request->id;
        $item = $id == null ? null : MtgCustomSetType::findOrFail($id);
        $html = view('admin.mtg.settings.customType.modal',get_defined_vars())->render();
        return response()->json(['html'=>$html]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>['required' ,Rule::unique(MtgCustomSetType::class)],
            // 'slug'=>['required' ,Rule::unique(MtgCustomSetType::class)],
        ]);    
        if($request->id){
            $item = MtgCustomSetType::findOrFail($request->id);
            $item->update($request->except('_token','id'));
            $msg = "Custom Type Updated Successfully!";
        }
        else{
            MtgCustomSetType::create($request->except('_token','id'));
            $msg = "Custom Type Created Successfully!";
        }
        return response()->json(['success'=>$msg]);

    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        MtgCustomSetType::findOrFail($id)->delete();
        return redirect()->back()->with('message','Custom Type Deleted Successfully!');
    }
}

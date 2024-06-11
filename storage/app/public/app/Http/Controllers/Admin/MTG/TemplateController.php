<?php

namespace App\Http\Controllers\Admin\MTG;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Admin\Mtg\TemplateDataTable;
use App\Models\MTG\Template;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(TemplateDataTable $dataTable)
    {
        $assets = ['data-table'];
        return $dataTable->render('admin.mtg.templates.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.mtg.templates.create');
    }

        /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Template::create($request->all());

        return redirect()->route('admin.mtg.cms.templates.index')->with('message','Successfully created');
    }

    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $template = Template::findOrFail($id);
        return view('admin.mtg.templates.edit',get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Template::findOrFail($id)->update($request->all());

        return redirect()->route('admin.mtg.cms.templates.index')->with('message','Successfully Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Template::findOrFail($id)->delete();

        return redirect()->route('admin.mtg.cms.templates.index')->with('message','Successfully Deleted!');
    }

    public function templateList(Request $request)
    {
        $templates =  Template::orderBy('created_at','desc')->get();
        $view = view('admin.mtg.templates.tempLists',get_defined_vars())->render();
 
        return response()->json(['html' => $view]);
    }
}

<?php

namespace App\Http\Controllers\Admin\MTG\Setting;

use App\DataTables\Admin\Mtg\Settings\AttributeDataTable;
use App\Http\Controllers\Controller;
use App\Models\MTG\MtgAttribute;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Settings_Attributes');
    }   
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AttributeDataTable $dataTable)
    {
        $assets = ['data-table'];
        return $dataTable->render('admin.mtg.settings.attributes.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        MtgAttribute::create($request->all());

        return redirect()->back()->with('message', 'Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        MtgAttribute::findOrFail($id)->update($request->all());
         $msg = $id ? 'updated Successfully!' : 'Created Successfully!'; 
        return redirect()->back()->with('message', $msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MtgAttribute::findOrFail($id)->delete();

        return redirect()->back()->with('message', 'Deleted Successfully!');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Admin\FaqCategoryDataTable;
use App\Models\FaqCategory;

class FaqCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Cms_Faqs_Category');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FaqCategoryDataTable $dataTable)
    {
        $assets = ['data-table'];
        return $dataTable->render('admin.faq_categories.index', get_defined_vars());
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
        FaqCategory::create($request->all());

        return redirect()->back()->with('message', 'Created Successfully!');
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
        FaqCategory::findOrFail($id)->update($request->all());

        return redirect()->back()->with('message', 'Created Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        FaqCategory::findOrFail($id)->delete();

        return redirect()->back()->with('message', 'Deleted Successfully!');
    }
}

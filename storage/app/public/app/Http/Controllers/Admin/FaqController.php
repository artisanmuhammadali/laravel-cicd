<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Admin\FaqDataTable;
use App\Models\Faq;
use App\Models\FaqCategory;

class FaqController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Cms_Faqs');
    }
     /**
     * Display a listing of the resource.
     */
    public function index(FaqDataTable $dataTable,$type = null)
    {
        $assets = ['data-table'];
        return $dataTable->with('type',$type)->render('admin.faqs.index', get_defined_vars());
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = FaqCategory::get();
        return view('admin.faqs.create',get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Faq::create($request->all());

        return redirect()->route('admin.mtg.cms.faqs.index')->with('message','Successfully created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = FaqCategory::get();
        $faq = Faq::findOrFail($id);
        return view('admin.faqs.edit',get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Faq::findOrFail($id)->update($request->all());

        return redirect()->route('admin.mtg.cms.faqs.index')->with('message','Successfully Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Faq::findOrFail($id)->delete();

        return redirect()->route('admin.mtg.cms.faqs.index')->with('message','Successfully Deleted!');
    }
}

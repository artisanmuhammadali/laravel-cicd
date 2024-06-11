<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SellerSurveyQuestion;
use App\DataTables\Admin\SellerSurveyDataTable;

class SellerSurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SellerSurveyDataTable $dataTable,$type = null)
    {
        $assets = ['data-table'];
        return $dataTable->render('admin.survey.index', get_defined_vars());
    }

   /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.survey.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $q = $this->setSurveyOption($request->question,$request->question_type);
        if($request->question_type == 'Options' && $request->answers)
        {
            foreach($request->answers as $key => $ans)
            {
                $this->setSurveyOption($ans,'answer',null,$q->id,isset($request->is_false[$key]));
            }
        }
        

        return redirect()->route('admin.surveys.index')->with('message','Successfully created!');
    }

    public function setSurveyOption($option,$type,$id=null,$parent_id=null,$is_false = false)
    {
        return SellerSurveyQuestion::updateOrCreate(['id' => $id],[
            'option' => $option,
            'type' => $type,
            'status' => $is_false,
            'parent_id' => $parent_id,
        ]);
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
        $question = SellerSurveyQuestion::with('answers')->findOrFail($id);
        return view('admin.survey.edit',get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $q = $this->setSurveyOption($request->question,$request->question_type,$id);
        $ids = $q->answers ? $q->answers->pluck('id')->toArray() : [];
        SellerSurveyQuestion::whereIn('id',$ids)->delete();
        if($request->question_type == 'Options' && $request->answers)
        {
            foreach($request->answers as $key => $ans)
            {
                $this->setSurveyOption($ans,'answer',null,$q->id,isset($request->is_false[$key]));
            }
        }

        return redirect()->route('admin.surveys.index')->with('message','Successfully Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        SellerSurveyQuestion::findOrFail($id)->delete();

        return redirect()->route('admin.surveys.index')->with('message','Successfully Deleted!');
    }
}

<?php

namespace App\Http\Controllers\Admin\MTG;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Admin\Mtg\MediaDataTable;
use App\Models\Media;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(MediaDataTable $dataTable,$type = null)
    {
        $assets = ['data-table'];
        return $dataTable->with('type',$type)->render('admin.mtg.media.index', get_defined_vars());
    }


    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.mtg.media.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->file)
        {
            $image = uploadFile($request->file,'image','custom');
            $request->merge(['url' => $image]);
        }
        Media::create($request->all());

        return redirect()->route('admin.mtg.cms.media.index')->with('message','Successfully created');
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
        $media = Media::findOrFail($id);
        return view('admin.mtg.media.edit',get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if($request->file)
        {
            $image = uploadFile($request->file,'image','custom');
            $request->merge(['url' => $image]);
        }
        Media::findOrFail($id)->update($request->all());

        return redirect()->route('admin.mtg.cms.media.index')->with('message','Successfully Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Media::findOrFail($id)->delete();

        return redirect()->route('admin.mtg.cms.media.index')->with('message','Successfully Deleted!');
    }

    public function getUrls(Request $request)
    {
       $media =  Media::orderBy('created_at','desc')->get();
       $view = view('admin.mtg.media.mediaUrls',get_defined_vars())->render();

       return response()->json(['html' => $view]);
    }
}

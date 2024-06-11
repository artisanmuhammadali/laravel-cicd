<?php

namespace App\Http\Controllers\Admin\MTG;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Admin\Mtg\PageDataTable;
use App\Models\Page;
use App\Models\TableOfContent;
use App\Models\Media;
use App\Models\Redirect;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Cms_Pages');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(PageDataTable $dataTable,$type = null)
    {
        $assets = ['data-table'];
        return $dataTable->with('type',$type)->render('admin.mtg.pages.index', get_defined_vars());
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.mtg.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->merge(['slug' => Str::slug($request->title)]);
        $request->merge(['appearance_type' => implode(',', $request->types)]);
        Page::create($request->all());

        return redirect()->route('admin.mtg.cms.pages.index')->with('message','Successfully created');
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
        $page = Page::findOrFail($id);
        return view('admin.mtg.pages.edit',get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        // $request->merge(['slug' => Str::slug($request->title)]);
        if($request->types){
            $request->merge(['appearance_type' => implode(',', $request->types)]);
        }
        $page = Page::findOrFail($id);
        if($page->slug != $request->slug)
        {
            $from = route('index').'/'.$page->slug;
            $to = route('index').'/'.$request->slug;
            Redirect::create(['from'=>$from,'to'=>$to]);
        }
        $page->update($request->all());

        if($request->table_content)
        {
            TableOfContent::where('page_id',$id)->whereNotIn('id',$request->con_ids)->delete();
            foreach($request->table_content as $key => $c)
            {
                $conId = isset($request->con_ids[$key]) ? $request->con_ids[$key] :null;
                if($c && $c != '')
                {
                    $t = isset($request->table_target[$key]) ? $request->table_target[$key] : '';
                    // $conId = isset($request->con_ids[$key]) ? $request->con_ids[$key] :null;
                    TableOfContent::updateOrCreate(['id'=>$conId],['content' => $c, 'link' => $t,'page_id' => $id]);
                }
                else{
                    TableOfContent::where('page_id',$id)->where('id',$conId)->delete();
                }
                
            }
        }
       

        return redirect()->route('admin.mtg.cms.pages.index')->with('message','Successfully Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Page::findOrFail($id)->delete();

        return redirect()->route('admin.mtg.cms.pages.index')->with('message','Successfully Deleted!');
    }

    public function upload(Request $request)
    {
        $image = null;
        if($request->upload)
        {
            $image = uploadFile($request->upload,'image','custom');
            $media = new Media();
            $media->url = $image;
            $media->save();
            return response()->json(['fileName' => $image, 'uploaded'=> 1,'url' => 'https://img.veryfriendlysharks.co.uk/'.$image]);

        }
        return response()->json(['url' => 'https://img.veryfriendlysharks.co.uk/'.$image]);
    }

    
    public function toggleStatus(Request $request)
    {
        $blog = Page::where('id',$request->id)->first();
        $blog->status = $request->toggle == 'on' ? 1 : 0;
        $blog->save();

        return response()->json(['success' => 'Changed Successfully!']);
    }
    
    public function pageDesign($slug)
    {
        $page = Page::where('slug',$slug)->first();
        if($page)
        {
            return view('admin.mtg.pages.design',get_defined_vars());
        }
    }
}

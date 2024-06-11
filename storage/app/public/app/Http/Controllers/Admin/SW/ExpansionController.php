<?php

namespace App\Http\Controllers\Admin\SW;
use App\Http\Requests\Admin\SW\ExpansionRequest;
use App\Http\Requests\Admin\SW\ExpansionSeoRequest;
use App\DataTables\Admin\Sw\ExpansionDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\SW\SwSet;
use App\Models\SW\SwSetSeo;
use App\Models\SW\SwCard;

class ExpansionController extends Controller
{
    public function index(ExpansionDataTable $dataTable)
    {
        $assets = ['data-table'];
        return $dataTable->render('admin.sw.expansion.index', get_defined_vars());
    }

    public function create()
    {
       return view('admin.sw.expansion.create',get_defined_vars());
    }

    public function store(ExpansionRequest $request)
    {
        $request->merge(['slug'  => Str::slug($request->name)]);
        SwSet::create($request->all());

        return redirect()->route('admin.sw.expansion.index')->with('message','Created successfully');
    }

    public function seo($id)
    {
        $set = SwSet::findOrFail($id);
        if(request()->type)
        {
            $seo = SwSetSeo::where('sw_set_id',$id)->where('type',request()->type)->first();
        }

        return view('admin.sw.expansion.seo',get_defined_vars());
    }

    public function seoStore(ExpansionSeoRequest $request,$id)
    {
        if($request->type)
        {
            $data =[
                'sw_set_id'=>$id,
                'title'=>$request->title,
                'heading'=>$request->heading,
                'sub_heading'=>$request->sub_heading,
                'meta_description'=>$request->meta_description,
                'type'=>$request->type,
                'created_at'=>now(),
                'updated_at'=>now(),
            ];
            $query = ['sw_set_id'=>$id , 'type'=>$request->type];
            SwSetSeo::updateOrInsert($query , $data);
        }
        else
        {
            $set = SwSet::findOrFail($id);
            $request = $this->saveSetMedia($request,$set->slug);
            $set->update($request->except('_token','banner_img','icon_img'));
        }
        return redirect()->back()->with('message','Updated Successfully');
    }

    public function saveSetMedia($request,$slug)
     {
        if($request->icon_img)
        {
            $image = uploadFile($request->icon_img,$slug.'_icon','custom');
            $request->merge(['icon' => $image]);
        }
        if($request->banner_img)
        {  
            $image = uploadFile($request->banner_img,$slug.'_banner','custom');
            $request->merge(['banner' => $image]);
        }
        
        return $request;
    }
    
    public function active($id)
    {
        $set = SwSet::find($id);
        $set->update(['is_active'=>true]);
        SwCard::where('sw_set_id',$set->id)->update(['is_active'=>true]);
        return redirect()->back()->with('message','Expansion Activated Successfully');
    }

    public function inactive($id)
    {
        $set = SwSet::find($id);
        $set->update(['is_active'=>false]);
        SwCard::where('sw_set_id',$set->id)->update(['is_active'=>false]);

        return redirect()->back()->with('message','Expansion De-Activate Successfully');
    }

    
}

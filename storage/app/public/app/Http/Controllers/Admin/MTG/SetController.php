<?php

namespace App\Http\Controllers\Admin\MTG;

use App\Http\Controllers\Controller;
use App\Models\MTG\MtgSet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\DataTables\Admin\Mtg\SetDataTable;
use App\Http\Requests\Admin\MTG\SetsRequest;
use App\Http\Requests\Admin\MTG\Set\SeoRequest;
use App\Models\MTG\MtgCard;
use App\Models\MTG\MtgSetLanguage;
use App\Models\MTG\MtgSetSeo;
use App\Services\Admin\MTG\SetsServices;
use App\Services\Admin\MTG\importSets;


class SetController extends Controller
{
    private $setsServices;
    public function __construct(SetsServices $setsServices)
    {
        $this->setsServices = $setsServices;
        $this->middleware('permission:Mtg_Set');

    }

    public function index(SetDataTable $dataTable,$type = null)
    {
        $assets = ['data-table'];
        return $dataTable->with('type',$type)->render('admin.mtg.sets.index', get_defined_vars());
    }

    public function create($type)
    {
       return view('admin.mtg.sets.create',get_defined_vars());
    }

    public function store(SetsRequest $request)
    {
        $this->setsServices->createService($request);

        return redirect()->back()->with('message','Set has been created successfully');
    }

    public function edit($id)
    {
       $types = DB::table('mtg_custom_set_types')->get(['id','name','slug']);
       $sets =  DB::table('mtg_sets')->where('id','!=',$id)->get(['id','custom_type','name']);
       $currentSet = MtgSet::findOrFail($id);
       $childIds = $currentSet->childs ? $currentSet->childs->pluck('id')->toArray() : [];

       return view('admin.mtg.sets.edit',get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        $parentSet = MtgSet::findOrFail($id);
        if($parentSet->type == 'child')
        {
            $parentSet->parent_set_code = null;
        }
        $parentSet->type = $request->type;
        $parentSet->save();

        if($request->custom_type)
        {
            foreach($request->custom_type as $key => $type)
            {
                MtgSet::where('id',$key)->update(['parent_set_code' => $parentSet->code,'custom_type' => $type]);
            }
        }
        if($request->type == 'released_at')
        {
            MtgSet::find($id)->update(['released_at'=>$request->released_at]);
        }
        return redirect()->back()->with('message','Data has been updated');
    }

    public function removeChild($id)
    {
        $child = MtgSet::findOrFail($id);
        $child->update(['parent_set_code' => null]);

        return redirect()->back()->with('message','Child has been removed successfully');
    }

    public function seo($id)
    {
        $set = MtgSet::findOrFail($id);
        if(request()->type)
        {
            $seo = MtgSetSeo::where('mtg_set_id',$id)->where('type',request()->type)->first();
        }

        return view('admin.mtg.sets.seo',get_defined_vars());
    }

    public function seoStore(SeoRequest $request,$id)
    {
        $this->setsServices->seoManagement($request,$id);
        return redirect()->back()->with('message','Updated Successfully');
    }
    public function active(Request $request, $id)
    {
        // dd($request->all());
        $set = MtgSet::find($id);
        $set->update(['is_active'=>true,'type'=>$request->type]);
        MtgCard::where('set_code',$set->code)->update(['is_active'=>true]);

        return redirect()->back()->with('message','Set Active Successfully');
    }
    public function inactive($id)
    {
        $set = MtgSet::find($id);
        $set->update(['is_active'=>false]);
        MtgCard::where('set_code',$set->code)->update(['is_active'=>false]);

        return redirect()->back()->with('message','Set De-Activate Successfully');
    }
    public function languages(Request $request)
    {
        if($request->type == "add")
        {
            foreach($request->languages as $key =>$lang)
            {
                $value = languageFromCode($key);
                MtgSetLanguage::create(['mtg_set_id'=>$request->id ,'key'=>$key , 'value'=>$value]);
            }
        }
        else{
            $keys = array_keys($request->languages);
            MtgSetLanguage::where('mtg_set_id',$request->id)->whereNotIn('key',$keys)->delete();

        }
        return redirect()->back()->with('message','Set Languages Updated Successfully');
    }
    public function legality(Request $request)
    {
        $legalities = [];

        if($request->type == "edit")
        {
            $set = MtgSet::findOrFail($request->id);
            if($request->legalities)
            {
                foreach($request->legalities as $key=> $legal)
                {
                    array_push($legalities , $key.':legal');
                }
            }
            $set->legalities = json_encode($legalities);
            $set->save();
        }
        else{
            $set = MtgSet::findOrFail($request->id);
            if($set->legalities)
            {
                $legalities = json_decode($set->legalities);
            }
            if($request->legalities)
            {
                foreach($request->legalities as $key=> $legal)
                {
                    array_push($legalities , $key.':legal');
                }
            }
            $set->legalities = json_encode($legalities);
            $set->save();

        }
        return redirect()->back()->with('message','Set Legalities Updated Successfully');
    }
    public function modal($id)
    {
        $set = MtgSet::find($id);
        $html = view('admin.mtg.sets.modal',get_defined_vars())->render();
        return response()->json(['html'=>$html]);
    }

    public function clone(Request $request)
    {
       $set = MtgSet::where('id',$request->set_id)->firstOrFail();

       $newSet = $set->replicate();
       $newSet->name = $request->name;
       $newSet->code = $request->code;
       $newSet->save();

       foreach($set->language as $lang)
       {
          $newLang = $lang->replicate();
          $newLang->mtg_set_id = $newSet->id;
          $newLang->save();
       }

       foreach($set->seo as $seo)
       {
          $newSeo = $seo->replicate();
          $newSeo->mtg_set_id = $newSet->id;
          $newSeo->save();
       }

       foreach($set->cards as $card)
       {
        $newCard = $card->replicate();
        $newCard->set_code = $newSet->code;
        $newCard->save();

        foreach ($card->images as $image) {
            $newImage = $image->replicate();
            $newImage->mtg_card_id = $newCard->id;
            $newImage->save();
        }
        foreach ($card->faces as $face) {
            $newFace = $face->replicate();
            $newFace->mtg_card_id = $newCard->id;
            $newFace->save();
        }
        foreach ($card->language as $lang) {
            $newLang = $lang->replicate();
            $newLang->mtg_card_id = $newCard->id;
            $newLang->save();
        }
        if($card->seo)
        {
            $newSeo = $card->seo->replicate();
            $newSeo->mtg_card_id = $newCard->id;
            $newSeo->save();
        }
       }


     return redirect()->back()->with('message','Successfully Cloned');
    }
    public function updateApi(importSets $importSets,$code)
    {
        $importSets->updateSet($code);
        
        return redirect()->back()->with('message','Updated Successfully');
    }
    public function updateSetSeo(Request $request)
    {

    }
}

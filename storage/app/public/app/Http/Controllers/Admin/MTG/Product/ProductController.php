<?php

namespace App\Http\Controllers\Admin\MTG\Product;

use App\DataTables\Admin\Mtg\ProductDataTable;
use App\Http\Controllers\Controller;
use App\Models\MTG\MtgCard;
use App\Models\MTG\MtgCardSeo;
use App\Models\MTG\MtgSet;
use App\Models\MTG\MtgCardImage;
use App\Models\MTG\MtgCardLanguage;
use App\Services\Admin\MTG\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\Admin\MTG\UpdateCards;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Mtg_Products');
    }
    public function index(ProductDataTable $dataTable,$type = null, $type2=null)
    {
        $assets = ['data-table'];
        $set = request()->set ? request()->set : null;
        return $dataTable->with(['type'=>$type,'type2' => $type2 , 'set'=>$set])->render('admin.mtg.products.index', get_defined_vars());
    }
    public function create($type,$type2=null)
    {
        $sets = MtgSet::select('id','name','code')->when($type2 == 'new_arrival',function($q){
                $q->where('is_active',0);
        })->get();
        $item = null ;
        return view('admin.mtg.products.create', get_defined_vars());
    }
    
    public function uploadCsv($type)
    {
        return view('admin.mtg.products.csv',get_defined_vars());
    }

    public function renderViews(Request $request)
    {
        if($request->has('form_type'))
        {
            $csvOptions = $request->headRow;
            $ourHeader = [
                'Name'=>'name',
                'Set Code'=>'set_code',
                'Title'=>'title',
                'Meta Description'=>'meta_description',
                'Heading'=>'heading',
                'Sub Heading'=>'sub_heading',
                'Weight'=>'weight'
            ];
            $ourHeader = $request->mtg_card_type == "completed" ? array_merge(['Rarity'=>'rarity'],$ourHeader) : array_merge(['Image'=>'image','Type'=>'other_cards_type'],$ourHeader);
            $view = 'admin.mtg.products.csv-options';
        }
        else{
            $sets = MtgSet::active()->select('id','name','code')->get();
            $id = $request->id;
            $item = $id == null ? null : MtgCard::findOrFail($id);
            $view = 'admin.mtg.products.modal';
        }
        $html = view($view,get_defined_vars())->render();
        return response()->json(['html'=>$html]);
    }
    public function store(Request $request , ProductService $product)
    {
        if($request->form_type == "csv")
        {
            $response = $product->save($request);
            $redirect = count($response->correct) == 1 ? true : false;
            $html = view('admin.mtg.products.csv-error',get_defined_vars())->render();
            return response()->json(['response'=>$html , 'redirect'=>$redirect]);
        }
        else{
            if($request->image)
            {
                // $image = uploadImage($request->image, 'mtg/sets/media');
                // $img = route('index').'/'.$image;
                // $public= public_path($image);
                $image = uploadFile($request->image,'card_image','custom');
                $url = 'https://img.veryfriendlysharks.co.uk/'.$image;
                MtgCardImage::where('mtg_card_id',$request->id)->update(['value'=>$url]);
                // unlink($public);
            }
            MtgCardSeo::updateOrInsert(['mtg_card_id'=>$request->id], $request->except(['id','_token','weight','set_code','image','slug']));
            $card = MtgCard::find($request->id);
            $card->update(['weight'=>$request->weight ?? null , 'set_code'=>$request->set_code , 'slug'=>$request->slug , 'name'=>$request->name ?? $request->heading , 'rarity'=>strtolower($request->rarity) ?? $card->rarity]);

        }
        return response()->json(['success'=>'Card Updated Successfully']);
    }
    public function active($id)
    {
        MtgCard::find($id)->update(['is_active'=>true]);
        return redirect()->back()->with('message','Set Active Successfully');
    }
    public function destroy($id)
    {
        MtgCard::findOrFail($id)->delete();
        return redirect()->back()->with('success','Card Deleted Successfully');
    }
    public function seo($id)
    {
        $sets = MtgSet::select('id','name','code')->get();
        $item = $id == null ? null : MtgCard::findOrFail($id);
        return view('admin.mtg.products.seo',get_defined_vars());
    }
    public function singleCardSave(Request $request , ProductService $product)
    {
        $url = null;
        $set = MtgSet::where('name',$request->set_name)->first();
        if($request->card_type == "sealed")
        {
            $image = uploadFile($request->png_img,'card_image','custom');
            $url = 'https://img.veryfriendlysharks.co.uk/'.$image;
        }
        $request->merge(['set_code'=>$set->code , 'image'=>$url]);

        $product->saveProduct($request , $set , 'single');
        $route = route('admin.mtg.products.index', [$request->card_type,$request->is_arrival ?? null]);
        return response()->json(['success' => 'Card Added Successfully', 'route' => $route]);
        // return redirect()->back()->with('success','Card Added Successfully');
    }
    public function languages(Request $request)
    {
        if($request->type == "add")
        {
            if($request->languages)
            {
                foreach($request->languages as $key =>$lang)
                {
                    $value = languageFromCode($key);
                    MtgCardLanguage::create(['mtg_card_id'=>$request->id ,'key'=>$key , 'value'=>$value]);
                }
            }
        }
        else{
            MtgCardLanguage::where('mtg_card_id',$request->id)->when($request->languages,function($q)use($request){
              $keys = array_keys($request->languages);
              $q->whereNotIn('key',$keys);
            })->delete();
        }
        return redirect()->back()->with('message','card Languages Updated Successfully');
    }
    public function legality(Request $request)
    {
        $legalities = [];
        if($request->type == "edit")
        {
            $card = MtgCard::findOrFail($request->id);
            if($request->legalities)
            {
                foreach($request->legalities as $key=> $legal)
                {
                    $legalities[$key] ="legal";
                }
            }
            $card->legalities = json_encode($legalities , true);
            $card->save();
        }
        else{
            $card = MtgCard::findOrFail($request->id);
            if($card->legalities){
                $legalities = json_decode($card->legalities , true);
            }
            if($request->legalities)
            {
                foreach($request->legalities as $key=> $legal)
                {
                    $legalities[$key] ="legal";
                }
            }
            $card->legalities = json_encode($legalities , true);
            $card->save();

        }
        return redirect()->back()->with('message','Card Legalities Updated Successfully');
    }

    public function updateNew(UpdateCards $service,$id)
    {
        Log::info('Update Single Card from scryfall start');
        $card = MtgCard::where('id',$id)->first();
        $url = 'https://api.scryfall.com/cards/'.$card->card_id;
        $service->apiCall($url,$card);
        Log::info('Update Single Card from scryfall end');

        return redirect()->back()->with('message','Updated Successfully');
    }
}   

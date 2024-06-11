<?php

namespace App\Http\Controllers\Admin\SW;
use App\DataTables\Admin\Sw\ProductDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SW\SwSet;
use App\Models\SW\SwCard;
use App\Models\SW\SwCardSeo;
use App\Services\SW\ProductService;


class ProductController extends Controller
{
    public function index(ProductDataTable $dataTable,$type,$expansion = null)
    {
        $assets = ['data-table'];
        return $dataTable->with(['type'=>$type,'exp'=>$expansion])->render('admin.sw.products.index', get_defined_vars());
    }

    public function create($type,$type2=null)
    {
        if($type == 'sealed' || $type == 'completed')
        {
            $sets = SwSet::select('id','name','code')->get();
            $item = null ;
            return view('admin.sw.products.create', get_defined_vars());
        }
        return redirect()->back();
    }

    public function store(Request $request , ProductService $product)
    {

        $url = null;
        $set = SwSet::where('id',$request->set_id)->first();
        if($request->card_type == "sealed")
        {
            $image = uploadFile($request->png_img,'card_image','custom');
            $url = 'https://img.veryfriendlysharks.co.uk/'.$image;
        }
        $request->merge(['set_id'=>$set->id , 'image'=>$url]);

        $product->saveProduct($request , $set , $request->card_type);
        $route = route('admin.sw.products.index', [$request->card_type,$request->is_arrival ?? null]);
        return response()->json(['success' => 'Card Added Successfully', 'route' => $route]);
    }

    public function seo($id)
    {
        $sets = SwSet::select('id','name','code')->get();
        $item = $id ? SwCard::findOrFail($id) : null;
        return view('admin.sw.products.seo',get_defined_vars());
    }

    public function seoStore(Request $request)
    {
        SwCardSeo::updateOrCreate(['sw_card_id'=>$request->id], $request->all());
        $card = SwCard::find($request->id);
        $card->update(['weight'=>$request->weight ?? 0 , 'sw_set_id'=>$request->set_id , 'slug'=>$request->slug , 'name'=>$request->name ?? $request->heading]);
       
        return response()->json(['success'=>'Card Updated Successfully']);
    }

    public function destroy($id)
    {
        SwCard::findOrFail($id)->delete();
        return redirect()->back()->with('message','Card Deleted Successfully');
    }
}

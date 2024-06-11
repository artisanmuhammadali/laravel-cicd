<?php

namespace App\Http\Controllers\Admin\MTG;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MTG\MtgCard;
use Illuminate\Support\Facades\DB;
use App\Models\MTG\MtgAttribute;
use App\Models\MTG\MtgCardAttribute;
use Illuminate\Support\Str;


class CardController extends Controller
{
    public function index()
    {

        $sets =  DB::table('mtg_sets')->get(['id','code','name']);

        return view('admin.mtg.cards.index',compact('sets'));
    }

    public function appendProducts(Request $request)
    {
        $cards =  MtgCard::when($request->code, function($q) use($request){
            $q->where('set_code',$request->code);
        })->when($request->from_number && $request->to_number, function($q) use($request){
            $q->where('int_collector_number', '>=', $request->from_number)->where('int_collector_number', '<=', $request->to_number);
        })->when($request->from_number && !$request->to_number, function($q) use($request){
            $q->where('int_collector_number', '>=', $request->from_number);
        })->when(!$request->from_number && $request->to_number, function($q) use($request){
            $q->where('int_collector_number', '<=', $request->to_number);
        })->when($request->symbol,function($q)use($request){
            $q->where('collector_number', 'like', '%' . $request->symbol . '%');
        })
        ->when($request->rarity,function($q)use($request){
            $q->where('rarity', 'like', '%' . $request->rarity . '%');
        })
        ->where('card_type','single')->get();
        $view = view('admin.mtg.cards.appendProducts',compact('cards'))->render();

        return response()->json(['html' => $view]);
    }

    public function selectedProducts(Request $request)
    {
        $sets =  DB::table('mtg_sets')->get(['id','code','name']);
        $attributes = MtgAttribute::get();
        if(!$request->ids)
        {
            return redirect()->back()->with('error','please select options.');
        }
        $cards =  MtgCard::with('attributes')->whereIn('id',$request->ids)->get();
        return view('admin.mtg.cards.cardProducts',compact('cards','attributes','sets'));
    }

    public function appendColumns(Request $request)
    {
        $id= $request->id;
        $attributes = MtgAttribute::get();
        $view = view('admin.mtg.cards.components.appendColumn',compact('attributes','id'))->render();

        return response()->json(['columns' => $view]);
    }


    public function attr(Request $request)
    {
        $data = json_decode($request['data']);
        
        $selected = [];
        $copy = $data->copy ?? null;
        $new_set_code = $data->new_set_code ?? null;
        $isfoil = $data->is_foil ?? null;
        $ids = [];
        $attributes = [];
        foreach ($data as $key => $value) {
            if (strpos($key, 'ids') !== false) {
                $ids[] = $value;
            } elseif (preg_match('/attribute\[(\d+)\]\[(\d+)\]/', $key, $matches)) {
                $attributeKey = $matches[1];
                $attributeValue = $matches[2];
                if (!isset($attributes[$attributeKey])) {
                    $attributes[$attributeKey] = [];
                }
                $attributes[$attributeKey][] = $value;
            }
            elseif (preg_match('/selected_attributes\[(\d+)\]/', $key, $match)) {
                $selKey = $match[1];
                $selected[] = $selKey;
            }
        
        }
        return $request->merge(['new_set_code'=> $new_set_code,'copy' => $copy,'is_foil' => $isfoil,'ids' => $ids, 'attribute' => $attributes, 'selected_attributes' => $selected]);
    }
    public function storeProductAttributes(Request $request)
    {
       $request =  $this->attr($request);
        // if($request->selected_attributes && count($request->selected_attributes) > 0)
        // {

            foreach($request->ids as $keyId => $id)
            {
              $att_ids = [];
              $card = MtgCard::where('id',$id)->first();
              if($request->copy)
              {
                $copy_slug = '';
                if($request->selected_attributes && count($request->selected_attributes) > 0)
                {
                foreach($request->selected_attributes as $att)
                {
                   $att_id = $request->attribute[$att][$keyId];
                   $attribute = MtgAttribute::where('id',$att_id)->first();
                   $att_ids[] = $attribute->id;
                   $name = Str::slug($attribute->name);
                   $copy_slug  = $copy_slug .'-'.$name;
                }
                }
                if($card->attributes){
                    foreach($card->attributes as $attribute)
                    {
                        $att_ids[] = $attribute->id;
                        $name = Str::slug($attribute->name);
                        $copy_slug  = $copy_slug .'-'.$name;
                    }
                }

                $copy_slug = Str::slug($card->name).$copy_slug;
                $copy_card = MtgCard::where('slug',$copy_slug)->first();
                if(!$copy_card)
                {
                    $newCard = $card->replicate();
                    $newCard->slug = $copy_slug;
                    if($request->is_foil)
                    {
                        $newCard->foil = 1;
                        $newCard->nonfoil = 0;
                        $newCard->finishes = '["foil"]';
                    }
                    if($request->new_set_code)
                    {
                        $newCard->set_code = $request->new_set_code;
                    }
                    $newCard->save();
                    foreach($att_ids  as $att)
                    {
                        MtgCardAttribute::Create(['mtg_card_id' => $newCard->id, 'mtg_attribute_id' => $att]);
                    }
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
                    $CardSeo = $card->seo;
                    $seo = $CardSeo->replicate();
                    $seo->mtg_card_id = $newCard->id;
                    $seo->save();

                }
              }
              else{
                // MtgCardAttribute::where('mtg_card_id',$id)->whereNotIn('mtg_attribute_id',$request->selected_attributes)->delete();
                $attribute_slug = '';
                if($request->selected_attributes && count($request->selected_attributes) > 0)
                {
                 foreach($request->selected_attributes as $att)
                 {
                     $att_id = $request->attribute[$att][$keyId];
                     $attribute = MtgAttribute::where('id',$att_id)->first();
                     $att_ids[] = $attribute->id;
                     MtgCardAttribute::updateOrCreate(['mtg_card_id' => $id, 'mtg_attribute_id' => $att_id]);
                     $name = Str::slug($attribute->name);
                     $attribute_slug  = $attribute_slug .'-'.$name;
                 }
                 }
                 else{
                    foreach($card->attributes as $attribute)
                    {
                        $att_ids[] = $attribute->id;
                        $name = Str::slug($attribute->name);
                        $attribute_slug  = $attribute_slug .'-'.$name;
                    }
                 }

                 foreach($att_ids  as $att)
                 {
                    MtgCardAttribute::updateOrCreate(['mtg_card_id' => $id, 'mtg_attribute_id' => $att]);
                 }
                 $copy_slug = Str::slug($card->name).$attribute_slug;
                 $copy_card = MtgCard::where('slug',$copy_slug)->first();
                 if(!$copy_card)
                 {
                    $number = $card->collector_number;
                    $card->slug = Str::slug($card->name).$attribute_slug;
                    $card->save();
                 }
              }

            }
        // }
        // else
        // {
        //     foreach($request->ids as $keyId => $id)
        //     {
        //         MtgCardAttribute::where('mtg_card_id',$id)->delete();
        //         $card = MtgCard::where('id',$id)->first();
        //         $card->slug =  Str::slug($card->name);
        //         $card->save();
        //     }
        // }
       return response()->json(['success' => 'Updated Successfully']);
    //   return redirect()->route('admin.mtg.cards.index')->with('message','Successfuly Submitted');
    }
    public function removeAttributes($card_id,$att_id)
    {
        MtgCardAttribute::where('mtg_card_id',$card_id)->where('mtg_attribute_id',$att_id)->delete();
        return response()->json(['success' => 'Update successfully!']);
    }
}

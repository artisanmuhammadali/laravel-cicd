<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Models\MTG\MtgCard;
use App\Models\MTG\MtgSet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AddWeightsToProducts extends Controller
{
    public function sealed($filename , $weight)
    {
        $filePath = public_path('sealedWeight/'.$filename.'.json');
        $jsonContents = File::get($filePath);
        foreach(json_decode($jsonContents) as $id)
        {
            $card = MtgCard::find($id);
            $card ? $card->update(['weight'=>$weight]) : null;
        }

        return "weight added";
    }

    public function completed()
    {
        set_time_limit(0);
        $completes = MtgCard::where('card_type','completed')
                        ->where('rarity','!=',null)
                        ->select('rarity','id','set_code')
                        ->get(); 
        foreach($completes as $complete)
        {   
            $count = MtgCard::where('set_code',$complete->set_code)
                            ->where('card_type','single')
                            ->where('rarity',$complete->rarity)
                            ->count();
            $weight = 2*$count;
            $complete->update(['weight'=>$weight , 'card_count'=>$count]);
        }  

        $sets = MtgCard::where('card_type','completed')
                    ->where('name','like','%'.'full set'.'%')
                    ->where('rarity',null)
                    ->select('rarity','id','set_code','name')
                    ->get(); 
        foreach($sets as $complete)
        {   
            $count = MtgCard::where('set_code',$complete->set_code)
                            ->where('card_type','single')
                            ->count();
            $weight = 2*$count;
            $complete->update(['weight'=>$weight , 'card_count'=>$count , 'rarity'=>'full']);
        } 

        $left = MtgCard::where('card_type','completed')
                    ->where('rarity',null)
                    ->where('name','like','%'.'Basic Lands Set'.'%')
                    ->select('rarity','id','set_code','name')
                    ->get(); 
        foreach($left as $complete)
        {   
            $count = MtgCard::where('set_code',$complete->set_code)
                        ->WhereHas('faces',function($q){
                            $q->where('type_line','like', '%' .'Basic Land'. '%');
                        })->count();
            $weight = 2*$count;
            $complete->update(['weight'=>$weight , 'card_count'=>$count]);
        } 

        $weight = MtgCard::where('card_type','completed')
                    ->where('weight',0)
                    ->select('rarity','id','set_code','name')
                    ->get(); 
        foreach($weight as $complete)
        {   
            $name = str_replace(" Full Set" , "" ,$complete->name );
            $set = MtgSet::where('name',$name)->first();
            if($set)
            {
                $count = MtgCard::where('set_code',$set->code)
                                ->where('card_type','single')
                                ->count();
                $weight = 2*$count;
                $complete->update(['weight'=>$weight , 'card_count'=>$count]);
            }
        }

        return "complete sets weight and count added successfully";
    }
}

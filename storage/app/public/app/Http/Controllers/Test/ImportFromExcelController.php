<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Models\MTG\MtgCard;
use App\Models\MTG\MtgCardFace;
use App\Models\MTG\MtgCardImage;
use App\Models\MTG\MtgCardSeo;
use App\Models\MTG\MtgSet;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class ImportFromExcelController extends Controller
{
    public function import($type ,$filename)
    {
        // dd(MtgCard::whereDate('created_at',today())->delete());
        $tmpName = public_path($filename);
        if(($handle = fopen($tmpName, 'r')) !== FALSE) {
            set_time_limit(0);
            $row = 1;
            while(($data = fgetcsv($handle, 100000, ',')) !== FALSE) {
                if($row == 0){ $row++; continue; }
                try{
                    // dd($data);
                    $code = $type == "sealed" ? $data[0] : $data[2]; 
                    $set=MtgSet::where('code',$code)->first();

                    $name = $type == "sealed" ? $data[5] : $data[6]; 
                    $slug = Str::slug($name);
                    
                    $card = MtgCard::where('slug',$slug)
                                    ->where('card_type',$type)
                                    ->first();
                    if($set && !$card){
                    // dd($data);
                        if($type == "sealed"){
                            $this->createSealed($data , $slug , $set->code);
                        }
                        else{
                            $this->createComplete($data , $slug , $set->code);
                        }
                    }

                }
                catch(\Exception $e){
                    // dd($e,$row);
                }
                $row++;
            }
        }
        return true;


    }
    public function createComplete($data , $slug , $code)
    {
        $completed = MtgCard::where('set_code',$code)->where('slug',$slug)->first();

        // $completed = new MtgCard();
        // $completed->name = $data[6];
        // $completed->set_code = $code;
        // $completed->slug = $slug;
        // $completed->card_type = "completed";
        // $completed->other_cards_type = 'set';
        // $completed->save();

        
        // $face = ['mtg_card_id'=>$completed->id ,'name'=>$data[5]];
        // MtgCardFace::create($face);

        // $images = $this->imagesArray('https://veryfriendlysharks.co.uk/images/All.svg' , $completed->id);
        // MtgCardImage::insert($images);

        $seo = [
            'title'=>$data[7] ?? null,
            'heading'=>$data[9] ?? null,
            'sub_heading'=>$data[10] ?? null,
            'meta_description'=>$data[11] ?? null,
            'mtg_card_id'=>$completed->id,
        ];
        MtgCardSeo::create($seo);

        return true;
    }

    public function createSealed($data , $slug , $code)
    {
        $sealed = MtgCard::where('set_code',$code)->where('slug',$slug)->first();

        // $sealed = new MtgCard();
        // $sealed->name = $data[5];
        // $sealed->set_code = $code;
        // $sealed->slug = $slug;
        // $sealed->card_type = "sealed";
        // $sealed->other_cards_type = $data[6];
        // $sealed->save();

        // $face = ['mtg_card_id'=>$sealed->id ,'name'=>$data[5]];
        // MtgCardFace::create($face);
        // $img = 'https://beta.veryfriendlysharks.co.uk/sealedImages/'.$data[7];
        // $images = $this->imagesArray($img, $sealed->id);
        // MtgCardImage::insert($images);

        $seo = [
            'title'=>$data[8] ?? null,
            'heading'=>$data[10] ?? null,
            'sub_heading'=>$data[11] ?? null,
            'meta_description'=>$data[12] ?? null,
            'mtg_card_id'=>$sealed->id,
        ];
        MtgCardSeo::create($seo);

        return true;
    }
    public function imagesArray($img , $id)
    {
        $images[] = ['mtg_card_id' => $id, 'key' => 'png', 'value' => $img ?? null ];
        $images[] = ['mtg_card_id' => $id, 'key' => 'art_crop', 'value' => $img ?? null ];
        $images[] = ['mtg_card_id' => $id, 'key' => 'border_crop', 'value' => $img ?? null ];
        return $images;
    }
}

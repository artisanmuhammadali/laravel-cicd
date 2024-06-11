<?php

namespace App\Traits\Mtg;

use App\Exports\ExportUserCollectionCsv;
use App\Models\MTG\CardMarketData;
use App\Models\MTG\MtgCard;
use App\Models\MTG\MtgCardLanguage;
use App\Models\MTG\MtgSet;
use App\Models\MTG\MtgSetLanguage;
use App\Models\MTG\MtgUserCollection;
use App\Models\MTG\MtgUserCollectionCsv;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

trait ImportUserCollectionCsvTrait
{
    public function importCsv($data , $path)
    {
        $file = fopen($path, 'r');
        $csvData = [];
        while (($line = fgetcsv($file)) !== false) {
            $csvData[] = $line;
        }
        $this->collection($csvData , $data->id);
        fclose($file);
        return true;
    }
    public function collection($rows , $id)
    {
       $csv = MtgUserCollectionCsv::find($id);
       $header = $rows[0];
       $this->arrangeData($rows , $csv , $header);
       
    }
    public function arrangeData($rows , $csv , $header)
    {
        // dd($header->all());
        Session::forget('success_collection');
        Session::forget('total_collection');
        try{
            $extension = pathinfo($csv->name, PATHINFO_EXTENSION);
            $combination = json_decode($csv->header);
            $newArray = [];
            $success = 0;
            $wrongCount = 0;
            $total = $extension == "csv" ? -1 : 0;
            $wrong = [];
            $successArr = [];
            if($extension == "xlsx")
            {
                $h = array_merge($header->all() , ['Reason']);
                $wrong[] = array_values($h);
                $successArr[] = array_values($header->all());
            }
            if($extension == "csv")
            {
                $successArr[] = array_values($header);
            }
            foreach($rows as $row){
                $total++;
                Session::put('total_collection', $total);
                $row=$this->convertKeysToAlphabetic($row);
                foreach ($combination as $newIndex => $oldIndex) {
                    $newArray[$newIndex] = $row[$oldIndex] ?? null;
                    $newArray['mtg_card_type'] = $csv->mtg_card_type;
                    $newArray['user_id'] = $csv->user_id;
                }
                $newArray = $this->adjustCharsFormat($newArray , $total);
                list($validationType,$data) = $this->validateRow($newArray , $csv->mtg_card_type);
                if($validationType == "success" && $newArray['price'] >= 0.01)
                {
                    unset($newArray['card_name'] ,$newArray['set_name'] ,$newArray['cardmarket_id'] ,$newArray['tcgplayer_id'] ,$newArray['scryfall_id']);
                    if($csv->mtg_card_type == "single"){
                        unset($newArray['collector_number']);
                    }
                    $condition = !in_array($newArray['condition'] , array_keys(getConditions()) ) ? cardMarketConditions($newArray['condition']) : $newArray['condition'];
                    $newArray['condition'] = $condition;
                    $newArray['mtg_card_id'] = $data->id;
                    $name = languageFromName($newArray['language']);
                    $newArray['language'] = $name != false ? $name : $newArray['language'];
                    $success++;
                    Session::put('success_collection', $success);
                    $col = MtgUserCollection::create($newArray);
                    updateCollectionByCard($col);
                    $successArr[] = array_values($row);
                }
                else
                {
                    $wrongCount++;
                    $row['reason'] = $data;
                    $wrong[] = array_values($row);
                }
            }
            $csv->total = $total;
            $csv->success = $success;
            $csv->save();
            if($total - $success > 0)
            {
                $this->saveCsvFile($csv , $wrong , 'wrong');
            }
            if($success > 0)
            {
                $this->saveCsvFile($csv , $successArr , 'success');
            }
        }
        catch(Exception $e)
        {
            Log::info('Error In CSV Import');
            Log::info($e);
        }
    }
    public function convertKeysToAlphabetic($array)
    {
       $keys = range('A', 'Z');
       $result = [];

       foreach ($array as $index => $value) {
           $result[array_shift($keys)] = $value;
       }

       return $result;
    }
    public function validateRow($data , $type)
    {
        $validator = Validator::make($data, [
            'quantity' => 'required|numeric|min:1',
            'card_name' => 'required',
            'set_name' => 'required',
            'collector_number' => 'nullable',
            'condition' => 'required',
            'language' => 'required',
            'price' => 'required|numeric|min:0.01',
            'note' => 'nullable',
        ]);
        if($validator->fails()){
            return ['error','Reason'];
        }
        $name = languageFromName($data['language']);
        $code = languageFromCode($data['language']);
        if($name == false && $code == false)
        {
            return ['error','Undefined Card Language'];
        }
        $condition = !in_array($data['condition'] , array_keys(getConditions()) ) ? cardMarketConditions($data['condition']) : $data['condition'];
        if(!$condition)
        {
            return ['error','Undefined Card Condition'];
        }
        if(array_key_exists('cardmarket_id',$data) || array_key_exists('tcgplayer_id',$data) || array_key_exists('scryfall_id',$data))
        {
            $card = MtgCard::when(array_key_exists('cardmarket_id',$data),function($q)use($data){
                                $q->where('cardmarket_id',$data['cardmarket_id']);
                            })
                            ->when(array_key_exists('tcgplayer_id',$data),function($q)use($data){
                                $q->where('tcgplayer_id',$data['tcgplayer_id']);
                            })
                            ->when(array_key_exists('scryfall_id',$data),function($q)use($data){
                                $q->where('card_id',$data['scryfall_id']);
                            })
                            ->when($type == "single",function($q)use($data){
                                $q->when($data['foil'] == 0,function($qu){
                                    $qu->where('nonfoil',1);
                                });
                                $q->when($data['foil'] == 1,function($qu){
                                    $qu->where('foil',1);
                                });
                            })
                            ->where('card_type',$type)
                            ->first();
            if($card)
            {
                $lang = $this->checkCardLang($card , $data , $type);
                return $lang ? ['success',$card] : ['error','Card Language Does Not Exist'];
            }
        }
        return $this->matchCardMarketRecord($data , $type);
    }
    public function findCard($data , $type)
    {
        $set = MtgSet::where('name',$data['set_name'])->first();
        if(!$set)
        {
            $cardMarketSet = CardMarketData::where('set_name',$data['set_name'])->first();
            if($cardMarketSet)
            {
                $set = MtgSet::where('code',$cardMarketSet->set_code)->first();
            }
        }
        if($set)
        {
            $card = MtgCard::where('name',$data['card_name'])
                    ->when($type == "single",function($q)use($data){
                        $q->where(function($que)use($data){
                            $collector = array_key_exists('collector_number' , $data) ? $data['collector_number'] : null;
                            $que->where('collector_number',$collector);
                        });
                        $q->when($data['foil'] == 0,function($qu){
                            $qu->where('nonfoil',1);
                        });
                        $q->when($data['foil'] == 1,function($qu){
                            $qu->where('foil',1);
                        });
                    })
                    ->where('card_type',$type)
                    ->where('set_code',$set->code)
                    ->first();
            if($card)
            {
                $lang = $this->checkCardLang($card , $data , $type);
                return $lang ? ['success',$card] : ['error','Card Language Does Not Exist'];
            }
            return $this->dataFailureReason($data ,$set, $type);
        }
        return ['error','Set Not Found'];
    }
    public function matchCardMarketRecord($data , $type)
    {
        // check set name , collector no
        $matchs = CardMarketData::where('name',$data['card_name'])
                                    ->where('set_name',$data['set_name'])
                                    ->when($type == "single",function($q)use($data){
                                        $collector = array_key_exists('collector_number' , $data) ? $data['collector_number'] : '';
                                        $q->where('collector_no',$collector);
                                    })
                                    ->get();
        foreach($matchs as $match)
        {
            $card = MtgCard::where('card_id',$match->scryfall_id)->first();
            if(!$card)
            {
                $card = MtgCard::where('cardmarket_id',$match->card_market_id)->first();
            }
            if(!$card)
            {
                $card = MtgCard::where('tcgplayer_id',$match->tcgplayer_id)->first();
            }
            if($card)
            {
                $lang = $this->checkCardLang($card , $data , $type);
                // continue if no language found
                if(!$lang)
                {
                    continue;
                }
                return $lang ? ['success',$card] : ['error','Card Language Does Not Exist'];
            }
        }
        return $this->findCard($data , $type);

    }
    public function saveCsvFile($csv , $data , $name)
    {
        $header = $data[0];
        unset($data[0]);
        $csvData = collect($data);
        $fileName = $name.'_'.$csv->id.time().'.xlsx';
        if($name == "success")
        {
            $csv->success_file = $fileName;
        }
        else
        {
            $csv->wrong_file = $fileName;
        }
        $csv->save();
        $export = new ExportUserCollectionCsv($csvData , $header);
        return Excel::store($export, $fileName, 'public');
    }
    public function checkCardLang($card , $data , $type)
    {
        $language = $data['language'] == "T-Chinese" ? 'zht' : $data['language'];
        $language = $language == "S-Chinese" ? 'zhs' : $language;
        $lang = null;
        if($type == "single"){
            $lang = MtgCardLanguage::where('mtg_card_id',$card->id)
                                    ->where(function($que)use($language){
                                        $que->where('key',$language);
                                        $que->orWhere('value',$language);
                                    })
                                    ->first();
        }
        else
        {
            $set = MtgSet::where('code',$card->set_code)->first();
            if($set)
            {
                $lang = MtgSetLanguage::where('mtg_set_id',$set->id)
                                ->where(function($que)use($language){
                                    $que->where('key',$language);
                                    $que->orWhere('value',$language);
                                })
                                ->first();
            }
        }
        return $lang;
    }
    public function dataFailureReason($data , $set, $type)
    {
        $card = MtgCard::where('name',$data['card_name'])
                        ->where('card_type',$type)
                        ->where('set_code',$set->code)                    
                        ->first();
        if(!$card)
        {
            return ['error','Card Name is not correct'];
        }
        $card = MtgCard::where('name',$data['card_name'])
                    ->when($type == "single",function($q)use($data){
                        $q->when($data['foil'] == 0,function($qu){
                            $qu->where('nonfoil',1);
                        });
                        $q->when($data['foil'] == 1,function($qu){
                            $qu->where('foil',1);
                        });
                    })
                    ->where('card_type',$type)
                    ->where('set_code',$set->code)
                    ->first();
        if(!$card)
        {
            return ['error','Foiling is not correct'];
        }
        $card = MtgCard::where('name',$data['card_name'])
                    ->when($type == "single",function($q)use($data){
                        $q->where(function($que)use($data){
                            $collector = array_key_exists('collector_number' , $data) ? $data['collector_number'] : null;
                            $que->where('collector_number',$collector);
                        });
                    })
                    ->where('card_type',$type)
                    ->where('set_code',$set->code)
                    ->first();
        if(!$card)
        {
            return ['error','Card Collector No is not correct'];
        }
        return ['error','Card Not Found'];
    }
    public function adjustCharsFormat($arr , $count)
    {
        $foil = 0;
        $signed = 0;
        $altered = 0;
        $graded = 0;
        if(array_key_exists('foil' , $arr)){
            if(strtolower($arr['foil']) == "true" || $arr['foil'] == 1){
                $foil = 1;
            }
        }
        if(array_key_exists('signed' , $arr)){
            if(strtolower($arr['signed']) == "true" || $arr['signed'] == 1){
                $signed = 1;
            }
        }
        if(array_key_exists('altered' , $arr)){
            if(strtolower($arr['altered']) == "true"  || $arr['altered'] == 1){
                $altered = 1;
            }
        }
        if(array_key_exists('graded' , $arr)){
            if(strtolower($arr['graded']) == "true"  || $arr['graded'] == 1)
            {
                $graded = 1;
            }
        }
        $arr['foil'] = $foil;
        $arr['signed'] = $signed;
        $arr['altered'] = $altered;
        $arr['graded'] = $graded;
        $price = (float)$arr['price'];
        $arr['price'] = $price;
        return $arr;
    }
}

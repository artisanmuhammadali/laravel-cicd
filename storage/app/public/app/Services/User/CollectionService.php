<?php

namespace App\Services\User;

use App\Models\MTG\MtgCard;
use App\Models\MTG\MtgSet;
use App\Models\MTG\MtgUserCollection;
use App\Models\MTG\MtgUserCollectionCsv;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Services\User\CollectionSearchService;


class CollectionService {
    
    private $search;
    public function __construct(CollectionSearchService $search)
    {
        $this->search = $search;

    }

    public function requestHandler($request)
    {
        $types = [
            'modal'=>'save',
            'bulk'=>'saveBulk',
            'csv'=>'saveCsv',
            'publish'=>'publishCollection',
            'forsale'=>'forsale',
            'bulkList'=>'renderBulkList',
            'csvOptions'=>'renderCsvOption',
        ];
        $funName = $types[$request->form_type];
        return $this->$funName($request);
    }
    public function save($request)
    {
        $request = $this->checkCollectionCharOnUpdate($request);
        $lang = $request->mtg_card_type == "completed" ? json_encode($request->languages) : $request->language;
        $lang = $request->mtg_card_type == "completed" && $lang == "null" ? '{"en":"on"}' : $lang;
        
        $request->merge(['user_id'=>auth()->user()->id , 'language'=>$lang]);
        if($request->photo){
            $imageName = time() . '.' . $request->photo->extension();
            $img = uploadFile($request->photo ,$imageName ,"custom");
            $request->merge(['image'=>$img]);
        }
        if($request->id){
            $msg = "Collection Upadted Successfully";
            $col = MtgUserCollection::findOrFail($request->id);
            $col->update($request->except('_token','form_type','photo' , 'languages','postal_code','city','is_bulk'));
        }   
        else{
            $msg = "Collection Added Sussceefully";
            $col = MtgUserCollection::create($request->except('_token','form_type','photo' , 'languages','postal_code','city','is_bulk'));
            updateCollectionByCard($col);
        }
        return ['type'=>'success' , 'message'=>$msg, 'col' => $col];
    }
    public function saveBulk($request)
    {
        if(!$request->data)
        {
            $type = $request->set_type ?? 'single';
            $ids = $request->ids;
            $collections = $request->is_all != 0 ? $this->search->searchList($request,$type,'all') : MtgUserCollection::whereIn('id',$ids)->get(['id','price']);
            $ids = $collections->pluck('id')->toArray();
    
            MtgUserCollection::whereIn('id',$ids)->update([
                'language' => $request->language ?? DB::raw('language'),
                'condition' => $request->condition ?? DB::raw('condition'),
                'price' => $request->price ?? DB::raw('price'),
                'quantity' => $request->quantity ?? DB::raw('quantity'),
                'foil' => $request->foil,
                'signed' => $request->signed,
                'altered' => $request->altered,
                'graded' => $request->graded,
                'note' => $request->note ?? DB::raw('note'),
            ]);
    
            return ['type'=>'success' , 'message'=>'Collection Added Successfully'];
        }
        $requestData = json_decode($request->data , true);
        $cardType = $requestData['mtg_card_type'];
        $data = [];
        foreach ($requestData as $key => $value) {
            preg_match('/^(.*?)\[(\d+)\]$/', $key, $matches);
            if (count($matches) === 3) {
                $name = $matches[1];
                $index = $matches[2];
                if (!isset($data[$index])) {
                    $data[$index] = [];
                }
                $data[$index][$name] = $value;
                $data[$index]['user_id'] = auth()->user()->id;
                $data[$index]['mtg_card_type'] = $cardType;
                $data[$index]['created_at'] = now();
                $data[$index]['updated_at'] = now();
            }
        }
        $data = array_values($data);
        foreach($data as $item){
            if($item['mtg_card_type'] == "completed" )
            {
                $item['language'] = '{"'.$item['language'].'":"on"}';
            }
            $col = MtgUserCollection::create($item);
            updateCollectionByCard($col);
        }
        return ['type'=>'success' , 'message'=>'Collection Added Successfully'];

    }
    public function saveCsv($request)
    {
        $extension = pathinfo($request->data->getClientOriginalName(), PATHINFO_EXTENSION);
        $fileName = time() . '.' . $extension;
        $filePath = uploadCsv($request->data ,$fileName ,"custom");
        $folder = route('index') == 'https://beta.veryfriendlysharks.co.uk' ? 'beta_csv' : 'csvs';
        $combination = $request->except('_token','form_type','csv','data','mtg_card_type' , 'check');
        $file = 'https://img.veryfriendlysharks.co.uk/'.$folder.'/'.$filePath;
        MtgUserCollectionCsv::create(['user_id'=>auth()->user()->id ,'name'=>$request->data->getClientOriginalName(), 'header'=>json_encode($combination) , 'file'=>$file , 'mtg_card_type'=>$request->mtg_card_type ,'status'=>'pending' ]);
        
        return true;

    }
    
    public function validateRow($data , $type)
    {
        // dd($data);
        $validator = Validator::make($data, [
            'quantity' => 'required',
            'card_name' => 'required',
            'set_name' => 'required',
            'collector_number' => 'nullable',
            'condition' => 'required',
            'language' => 'required',
            'foil' => 'nullable',
            'altered' => 'nullable',
            'graded' => 'nullable',
            'signed' => 'nullable',
            'price' => 'required|numeric|gt:0',
            'note' => 'nullable',
        ]);
        if($validator->fails()){
            return ['error',$validator->errors()];
        }
        $name = languageFromName($data['language']);
        $code = languageFromCode($data['language']);
        if($name == false && $code == false)
        {
            return ['error','Language Undefined'];
        }
        $set = MtgSet::whereName($data['set_name'])->first();
        if($set)
        {
            $card = MtgCard::where('name',$data['card_name'])
                    ->when($type == "single",function($q)use($data){
                        $q->where('collector_number',$data['collector_number']);
                        $q->where('foil',$data['foil']);
                    })
                    ->where('card_type',$type)
                    ->where('set_code',$set->code)
                    ->first();

            return ['success',$card];

        }

    }
    public function renderCsvOption($request)
    {
        $csvOptions = $request->headRow;
        $ourHeader = [
            'Product Name'=>'card_name',
            'Set Name'=>'set_name',
            'Quantity'=>'quantity',
            'Price'=>'price',
            'Language'=>'language',
            'Condition'=>'condition',
            'Foil'=>'foil',
            'Signed ( optional )'=>'signed',
            'Graded ( optional )'=>'graded',
            'Altered ( optional )'=>'altered',
            'Note ( optional )'=>'note',
        ];
        $exception = ['tcgplayer_id','cardmarket_id','scryfall_id','collector_number','graded','altered','signed','note'];
        if($request->mtg_card_type == "single")
        {
            $ourHeader['Collector Number'] = "collector_number";
            $ourHeader['TCG Player Id ( optional )'] = "tcgplayer_id";
            $ourHeader['Card Market Id ( optional )'] = "cardmarket_id";
            $ourHeader['Scryfall Id ( optional )'] = "scryfall_id";
            $exception = ['tcgplayer_id','cardmarket_id','scryfall_id','graded','altered','signed','note'];
        }
        return view('user.components.collection.csvOption',get_defined_vars())->render();
    }
    public function checkCollectionCharOnUpdate($request)
    {
        $foil = $request->foil ? 1 : 0;
        $altered = $request->altered ? 1 : 0;
        $graded = $request->graded ? 1 : 0;
        $signed = $request->signed ? 1 : 0;
        return $request->merge(['foil'=>$foil ,  'altered'=>$altered , 'signed'=>$signed , 'graded'=>$graded]);
    }
    public function publishCollection($request)
    {
        $list = $request->is_all ? $this->search->searchList($request,$request->set_type,'all') : MtgUserCollection::whereIn('id',$request->ids)->get();
        $list->map(function ($listt)use($request) {
             $listt->publish = $request->publish;
             $listt->save();
        });
        return authUserCollectionCount(0 , $request->set_type) >= 1;
    }
    public function forsale($request)
    {
        $item = MtgCard::find($request->id);
        return view('user.components.collection.forsale',get_defined_vars())->render();
    }
    
    public function renderBulkList($request)
    {
        $set = MtgSet::where('code',$request->code)->first();
        $att = $request->attribute;
        $list = MtgCard::active()->with(['set','collections'])
                ->when($request->rarity != "all",function($q)use($request){
                    $q->where('rarity',$request->rarity);
                })
                ->where('card_type',$request->card_type)
        ->when($request->fill_lang,function($q)use($request){
            $q->whereHas('language',function($que)use($request){
                $que->where('key',$request->fill_lang);
            });
        })
        ->when($request->active == '0' || $request->active == '1',function($q)use($request){
            $q->where('is_active',$request->active);
        })
                ->where('set_code',$request->code)
                ->when($request->keyword,function($q)use($request){
                    $q->where('name', 'like', '%' . $request->keyword . '%');
                })
                ->when($att == 'alphabets' ,function($q)use($request){
                    $q->orderBy('name',$request->order);
                })
                ->when($att == 'collector_number' ,function($q)use($request){
                    $q->orderBy('int_collector_number',$request->order);
                })
                ->when($att == 'cmc' ,function($q)use($request){
                    $q->orderBy('cmc',$request->order);
                })
                ->when($att == 'rarity_number' ,function($q)use($request){
                    $q->orderByRaw("FIELD(rarity, 'common', 'uncommon', 'rare', 'mythic') $request->order");
                })
                ->when($att == 'released_at' ,function($q)use($request){
                    $q->orderBy('released_at',$request->order);
                })
                ->when($att == 'power' ,function($q)use($request){
                    $q ->addSelect([
                        'min_price' => MtgCardFace::select('power')
                            ->whereColumn('mtg_card_id', 'mtg_cards.id')
                            ->orderBy('power', $request->order)
                            ->limit(1)
                    ])
                    ->orderBy('min_price', $request->order);
                })
                ->when($att == 'toughness' ,function($q)use($request){
                    $q ->addSelect([
                        'min_price' => MtgCardFace::select('toughness')
                            ->whereColumn('mtg_card_id', 'mtg_cards.id')
                            ->orderBy('toughness', $request->order)
                            ->limit(1)
                    ])
                    ->orderBy('min_price', $request->order);
                })
                ->when($att == 'color' ,function($q)use($request){
                    $q ->addSelect([
                        'min_price' => MtgCardFace::select('color_order')
                            ->whereColumn('mtg_card_id', 'mtg_cards.id')
                            ->orderBy('color_order', $request->order)
                            ->limit(1)
                    ])
                    ->orderBy('min_price', $request->order);
                })
                ->get();
        $count = count($list);
    //    dd($data);
    //     $rarity = $request->rarity;
    //     $set = MtgSet::where('code',$request->code)->first();
    //     $list = MtgCard::active()->where('set_code',$request->code)
    //             ->when($request->rarity != "all",function($q)use($rarity){
    //                 $q->where('rarity',$rarity);
    //             })
    //             ->where('card_type',$request->card_type)
    //             ->get();
    //     $count = count($list);
        return view('user.components.collection.bulk-table',get_defined_vars())->render();
    }
}
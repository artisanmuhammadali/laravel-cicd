<?php

namespace App\Services\SW;

use App\Models\SW\SwCard;
use App\Models\SW\SwSet;
use App\Models\SW\SwUserCollection;
use App\Models\MTG\MtgUserCollectionCsv;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Services\SW\CollectionSearchService;


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
        $lang = $request->card_type == "completed" ? json_encode($request->languages) : $request->language;
        $lang = $request->card_type == "completed" && $lang == "null" ? '{"en":"on"}' : $lang;
        
        $request->merge(['user_id'=>auth()->user()->id , 'language'=>$lang,'sw_card_id' => $request->card_id]);
        if($request->photo){
            $imageName = time() . '.' . $request->photo->extension();
            $img = uploadFile($request->photo ,$imageName ,"custom");
            $request->merge(['image'=>$img]);
        }

        $col = SwUserCollection::updateOrCreate(['id' => $request->id],
            $request->except('_token','form_type','photo' , 'languages','postal_code','city','is_bulk','card_id')
        );

        $this->updateCollectionByCard($col);

        return ['type'=>'success' , 'col' => $col];
    }

    public function updateCollectionByCard($col)
    {
        return tap(SwCard::find($col->sw_card_id), function ($card)use($col) {
            if($card)
            {
                $col->cost = $card->cost;
                $col->hp = $card->hp;
                $col->power = $card->power;
                $col->name = $card->name;
                $col->sub_title = $card->sub_title;
                $col->text = $card->text;
                $col->styled_text = $card->styled_text;
                $col->aspects = $card->aspects;
                $col->keywords = $card->keywords;
                $col->arenas = $card->arenas;
                $col->traits = $card->traits;
                $col->weight = $card->weight;
                $col->epic_action = $card->epic_action;
                $col->styled_epic_action = $card->styled_epic_action;
                $col->deploy_box = $card->deploy_box;
                $col->styled_deploy_box = $card->styled_deploy_box;
                $col->sw_created_at = $card->sw_created_at;
                $col->sw_updated_at = $card->sw_updated_at;
                $col->sw_published_at = $card->sw_published_at;
                $col->published_at = $card->sw_published_at;
                $col->unique = $card->unique;
                $col->hyprspace = $card->hyprspace;
                $col->showcase = $card->showcase;
                $col->rarity = $card->rarity;
                $col->type = $card->type;
                $col->set_code = $card->set_code;
                $col->type2 = $card->type2;
                $col->save();
            }
        });
    
    }
    public function checkCollectionCharOnUpdate($request)
    {
        $foil = $request->foil ? 1 : 0;
        $altered = $request->altered ? 1 : 0;
        $graded = $request->graded ? 1 : 0;
        $signed = $request->signed ? 1 : 0;
        return $request->merge(['foil'=>$foil ,  'altered'=>$altered , 'signed'=>$signed , 'graded'=>$graded]);
    }

    public function saveBulk($request)
    {
        if(!$request->data)
        {
            $type = $request->set_type ?? 'single';
            $ids = $request->ids;
            $collections = $request->is_all != 0 ? $this->search->searchList($request,$type,'all') : SwUserCollection::whereIn('id',$ids)->get(['id','price']);
            $ids = $collections->pluck('id')->toArray();
    
            SwUserCollection::whereIn('id',$ids)->update([
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
        $cardType = $requestData['card_type'];
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
                $data[$index]['card_type'] = $cardType;
                $data[$index]['created_at'] = now();
                $data[$index]['updated_at'] = now();
            }
        }
        $data = array_values($data);
        foreach($data as $item){
            if($item['card_type'] == "completed" )
            {
                $item['language'] = '{"'.$item['language'].'":"on"}';
            }
            $col = SwUserCollection::create($item);
            $this->updateCollectionByCard($col);
        }
        return ['type'=>'success' , 'message'=>'Collection Added Successfully'];

    }
    public function saveCsv($request)
    {
        $extension = pathinfo($request->data->getClientOriginalName(), PATHINFO_EXTENSION);
        $fileName = time() . '.' . $extension;
        $filePath = uploadCsv($request->data ,$fileName ,"custom");
        $folder = route('index') == 'https://beta.veryfriendlysharks.co.uk' ? 'beta_csv' : 'csvs';
        $combination = $request->except('_token','form_type','csv','data','card_type' , 'check');
        $file = 'https://img.veryfriendlysharks.co.uk/'.$folder.'/'.$filePath;
        MtgUserCollectionCsv::create(['user_id'=>auth()->user()->id ,'name'=>$request->data->getClientOriginalName(), 'header'=>json_encode($combination) , 'file'=>$file , 'card_type'=>$request->card_type ,'status'=>'pending' ]);
        
        return true;

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
  
    public function publishCollection($request)
    {
        
        $list = $request->is_all ? $this->search->searchList($request,$request->set_type,'all') : SwUserCollection::whereIn('id',$request->ids)->get();
        $list->map(function ($listt)use($request) {
             $listt->publish = (int)$request->publish;
             $listt->save();
        });
    }

    // used
    
    public function renderList($request)
    {
        if($request->form_type == 'forsale')
        {
            $item = SwCard::find($request->id);
            return view('user.sw.collection.components.forsale',get_defined_vars())->render();
        }
        $set = SwSet::where('code',$request->code)->first();
        $att = $request->attribute;
        $list = SwCard::active()->with(['set','collections'])
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
                ->when($att == 'power' ,function($q)use($request){
                    $q->orderBy('power',$request->order);
                })
                ->when($att == 'hp' ,function($q)use($request){
                    $q->orderBy('hp',$request->order);
                })
                ->when($att == 'cost' ,function($q)use($request){
                    $q->orderBy('cost',$request->order);
                })
                ->when($att == 'price' ,function($q)use($request){
                    $q->orderBy('price',$request->order);
                })
                ->when($att == 'released_at' ,function($q)use($request){
                    $q->orderBy('published_at',$request->order);
                })
                ->get();
        $count = count($list);

        return view('user.sw.collection.components.bulk-table',get_defined_vars())->render();
    }
}
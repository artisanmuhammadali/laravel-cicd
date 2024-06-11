<?php

use App\Models\Cart;
use App\Models\Page;
use App\Models\UserReferralType;
use App\Models\Conversation;
use App\Models\User;
use App\Models\UserKyc;
use App\Models\FaqCategory;
use App\Models\MTG\MtgCard;
use App\Models\MTG\MtgCardFace;
use App\Models\MTG\MtgCardLanguage;
use App\Models\MTG\MtgCardSeo;
use App\Models\MTG\MtgSet;
use App\Models\MTG\MtgSetLanguage;
use App\Models\MTG\MtgSymbol;
use App\Models\MTG\MtgUserCollection;
use App\Models\Notification;
use App\Models\BlockUser;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Postage;
use App\Models\Setting;
use App\Models\Redirect;
use App\Models\UserStore;
use App\Models\Message;
use App\Models\Transaction;
use App\Models\PaymentCard;
use App\Models\Range;
use GuzzleHttp\Client;
use ImageKit\ImageKit;
use Zendesk\API\HttpClient as ZendeskAPI;
use Carbon\Carbon;
use \MangoPay\MangoPayApi as MangoPay;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;

function setTypes()
{
    return [
        'expansion',
        'special',
        'child'
    ];
}
function appearanceType()
{
    return [
        'header',
        'nav',
        'Very Friendly Sharks',
        'Customer Resources',
        'Other Links'
    ];
}
function appearanceTypeVisibleName($name , $type)
{
    $arr = [
        'header'=>'Header',
        'nav'=>'Nav',
        'footer1'=>'Very Friendly Sharks',
        'footer2'=>'Other links',
        'footer3'=>'Customer Resources'
    ];
    return array_key_exists($name , $arr) ? $arr[$name] : $name;
}
function appearanceTypeVisibleNameHandle($name)
{
    $FulNames = [];
    $names = explode(',',$name);
    foreach($names as $app)
    {
        $FulNames[] = appearanceTypeVisibleName($app , "single");   
    }
    return implode(',',$FulNames);
}

function countCardTotal($data)
{
    $total = 0;
    foreach ($data as $key => $item)
    {
        $total += $item->card_count;
    }
    return $total;
}

function uploadFile($file,$name,$type)
{
        $data = Config::get('helpers.image_kit');
        $imageKit = new ImageKit(
            $data['public_key'],
            $data['private_key'],
            $data['endpoint']
        );
        try {
            $file = $type == 'url' ? $file : base64_encode(file_get_contents($file));
            $response = $imageKit->uploadFile([
                'file' => $file, # required, "binary","base64" or "file url"
                'fileName' => $name # required
            ]);

            if($response->error)
            {
                return $type == 'custom' ? media($file, 'mtg/sets/media') : $file;
            }
            return $response->result->name ??  $file;
          } catch (\Exception $e) {
              return media($file, 'mtg/sets/media');
        }
}
function uploadCsv($file,$name,$type)
{
        $data = Config::get('helpers.image_kit');
        $imageKit = new ImageKit(
            $data['public_key'],
            $data['private_key'],
            $data['endpoint']
        );
        $folder = route('index') == 'https://beta.veryfriendlysharks.co.uk' ? 'beta_csv' : 'csvs';
        try {
            $file = $type == 'url' ? $file : base64_encode(file_get_contents($file));
            $response = $imageKit->uploadFile([
                'file' => $file, # required, "binary","base64" or "file url"
                'fileName' => $name, # required
                'folder' => $folder
            ]);

            if($response->error)
            {
                return $type == 'custom' ? media($file, 'mtg/sets/media') : $file;
            }
            return $response->result->name ??  $file;
          } catch (\Exception $e) {
              return media($file, 'mtg/sets/media');
        }
}


function uploadToCdnViaUrl($file,$name)
{
        $data = Config::get('helpers.image_kit');
        $imageKit = new ImageKit(
            $data['public_key'],
            $data['private_key'],
            $data['endpoint']
        );

        try {

            $response = $imageKit->uploadFile([
                'file' => $file,
                'fileName' => $name
            ]);

            return $data = [
                'status' => true,
                'message' => $response->result->name
            ];


          } catch (\Exception $e) {

            return $data = [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
}

function media($file, $path, $type = null)
{
        $imageName = time() . '.' . $file->extension();
        $file->move(public_path($path), $imageName);

        if($type == 'complete')
        {
            return asset($path.'/'.$imageName);
        }
        if($type == 'path')
        {
            return $path.'/'.$imageName;
        }

        return $imageName;
}

function sendMail($data)
{
    try {
        return $mail = Mail::send($data['view'], ['data' => $data['data']], function ($message) use ($data) {
          $message->to($data['to'], $data['to'])
          ->from(config('helpers.mail.from_address'), config('helpers.mail.from_name'))
            ->subject($data['subject']);
        });

    } catch (\Exception $e) {
    }
}
function uploadAttachment($file, $path){
    $name = time().$file->getClientOriginalName();
    $file->move($path,$name);
    return $path.'/'.$name;
}

function getcities()
 {
    $cities =   DB::table('cities')->orderBy('name', 'ASC')->get(['name']);
     return $cities;
 }


 function checkZendeskUser($email)
    {
        $zendesk = Config::get('helpers.zendesk');
        $subdomain = $zendesk['subdomain'];
        $username  = $zendesk['username'];
        $token     = $zendesk['token'];
        $client = new ZendeskAPI($subdomain);
        $client->setAuth('basic', ['username' => $username, 'token' => $token]);
        $apiUsers = $client->users()->findAll();
        $users = $apiUsers->users;

        foreach ($users as $item) {
            if ($item->email == $email) {
                return $item;
            }
        }
    }



function customTypes()
{
    return [
        'art-cards',
        'tokens-&-emblems',
        'masterpieces',
        'minigames',
        'funny',
    ];
}
function setProductTypes()
{
    return [
        'single-cards',
        'sealed-products',
        'complete-sets',
    ];
}
function cardTypeSlug()
{
    return [
        'single-cards'=>'single',
        'sealed-products'=>'sealed',
        'complete-sets'=>'completed',
    ];


}
function getCardManaCost($id)
{
    $face = MtgCardFace::find($id);
    $array = collect(explode('}{', trim($face->mana_cost, '{}')))
    ->map(function ($item) {
        return '{' . $item . '}';
    })
    ->toArray();
    $svgs =  collect($array)->map(function ($item) {
                return DB::table('mtg_symbols')->where('key', $item)->value('value');
            })->all();

    return $svgs;
}
function importCardLanguages($card)
{
    try {
        $client = new Client();
        $url = 'https://api.scryfall.com/cards/search?q=name:'.$card->name.'&unique=prints&include_multilingual=true';
        $response = $client->get($url);
        $response = json_decode($response->getBody()->getContents(), true);
        $data = (object) $response['data'];
        $matchingElements = [];
        foreach($data as $item){
            if ($item['name'] === $card->name && $item['collector_number'] === $card->collector_number ) {
                saveCardLangIfNotExist($item['lang'] , $card->id);
                // $matchingElements[] = $item['lang'];
            }
        }
        return saveSetLangIfNotExist($card->set_code);
    } catch (\Exception $e) {
        return;
    }

}
function saveCardLangIfNotExist($lang, $id)
{

    $fullname = "English";

    switch ($lang)
    {
        case 'en':
            $fullname = "English";
            break;
        case 'es':
            $fullname = "Spanish";
            break;
        case 'fr':
            $fullname = "French";
            break;
        case 'de':
            $fullname = "German";
            break;
        case 'it':
            $fullname = "Italian";
            break;
        case 'pt':
            $fullname = "Portuguese";
            break;
        case 'ja':
            $fullname = "Japanese";
            break;
        case 'jp':
            $fullname = "Japanese";
            break;
        case 'ko':
            $fullname = "Korean";
            break;
        case 'kr':
            $fullname = "Korean";
            break;
        case 'ru':
            $fullname = "Russian";
            break;
        case 'zhs':
            $fullname = "Simplified Chinese";
            break;
        case 'zht':
            $fullname = "Traditional Chinese";
            break;
        case 'he':
            $fullname = "Hebrew";
            break;
        case 'la':
            $fullname = "Latin";
            break;
        case 'grc':
            $fullname = "Ancient Greek";
            break;
        case 'ar':
            $fullname = "Arabic";
            break;
        case 'sa':
            $fullname = "Sanskrit";
            break;
        case 'ph':
            $fullname = "Phyrexian";
            break;

        default:
            $fullname = "English";
            break;
    }
    $query = ['mtg_card_id'=>$id,'key'=>$lang];
    $data = [
        'mtg_card_id' => $id,
        'key'  => $lang,
        'value' => $fullname
    ];
    MtgCardLanguage::updateOrInsert($query , $data);

}
function saveSetLangIfNotExist($code)
{
    $set = MtgSet::where('code',$code)->first();
    $my_array = [];
    $ids = MtgCard::where('set_code', $set->code)->whereHas('language')->pluck('id')->toArray();
    $languages = MtgCardLanguage::whereIn('mtg_card_id', $ids)->distinct('key')->pluck('value', 'key')->toArray();
        foreach($languages as $key => $lang)
        {
            $already = MtgSetLanguage::where('mtg_set_id',$set->id)->where('key',$key)->first();
            if(!$already)
            {
                MtgSetLanguage::create([
                    'mtg_set_id' => $set->id,
                    'key'  => $key,
                    'value' => $lang
                ]);
            }
        }
        
}
function saveCardLanguages($arr , $id)
{
    $languages = json_encode($arr);
    return MtgCard::find($id)->update(['languages'=>$languages]);
}

function colorOrders()
{
    return [
        'W'=>1,
        'U'=>2,
        'B'=>3,
        'R'=>4,
        'G'=>5
    ];
}

function findMtgCard($id)
{
    return MtgCard::find($id);
}
function createCardSeo($card)
{
    $set = MtgSet::where('code',$card->set_code)->first();

    $metaArr = [
        'single'=>' MTG single cards ',
        'sealed'=>' products today ',
        'completed'=>'',
    ];
    $titleArr = [
        'single'=>$set->name,
        'sealed'=>'MTG Sealed Products',
        'completed'=>$set->name,
    ];
    $subHaedArr = [
        'single'=>$card->name,
        'sealed'=>"Browse MTG Sealed Products To Buy and Sell ".$card->other_cards_type ." Products & More",
        'completed'=>"Browse MTG Complete Sets To Buy and Sell Your Magic The Gathering Cards",
    ];

    $meta = "Buy & sell " . $set->name. $metaArr[$card->card_type] ." on our UK-Only card market, today! Very Friendly Sharks is easy to use, with the best prices online.";
    if (strlen($meta) > 156) {
        $meta = "Buy & sell " . $set->name. $metaArr[$card->card_type] ." on our UK-Only card market, today! Very Friendly Sharks is easy to use, trusted & safe.";
    }
    if (strlen($meta) > 156) {
        $meta = "Buy & sell " . $set->name. $metaArr[$card->card_type] ." on our UK-Only card market, today! Very Friendly Sharks is easy to use.";
    }
    if (strlen($meta) > 156) {
        $meta = "Buy & sell " . $set->name. $metaArr[$card->card_type] ." on our UK-Only card market, today!";
    }

    $string = $card->name ." | ". $titleArr[$card->card_type]." | VFS Card Market";
    $title = stringToShort($string,70);
    $heading = $card->name;
    $subheading = $subHaedArr[$card->card_type];

    $exists = MtgCardSeo::where('mtg_card_id',$card->id)->first();
    $detail = $exists ? $exists : new MtgCardSeo();
    $detail->title = $title;
    $detail->meta_description = $meta;
    $detail->heading = $heading;
    $detail->sub_heading = $subheading;
    $detail->mtg_card_id = $card->id;
    $detail->save();
}
function stringToShort($input,$limit)
{
    while (strlen($input) > $limit) {
        $words = explode(' ', $input);
        array_pop($words);
        $input = implode(' ', $words);
    }

    return rtrim($input, " \t\n\r\0\x0B!@#$%^&*()_+[]{}|;':,./<>?\\\"");
}
function getUserName($id)
{
    $user= User::where('id',$id)->first();
    return $user->user_name ?? '';
}
function escrow()
{
    $escrow = [
        'id'=>208886033,
        'wallet_id'=>208886176,
    ];
    return (object)$escrow;
}
function vsfPspConfig()
{
    $keys = ['vfs_platform_fee' , 'referral_credit_percent','referral_credit_limit','vat_percentage'];
    $setting = Setting::whereIn('key',$keys)->pluck('value','key')->toArray();
    $config = [
        'platform_fee'=>array_key_exists('vfs_platform_fee', $setting) ? (float)$setting['vfs_platform_fee'] : 4,
        'referal_percentage'=>array_key_exists('referral_credit_percent', $setting) ? (float)$setting['referral_credit_percent'] : 1.5,
        'referal_limit'=>array_key_exists('referral_credit_limit', $setting) ? (int)$setting['referral_credit_limit'] : 100,
        'vat_percentage'=>array_key_exists('vat_percentage', $setting) ? (int)$setting['vat_percentage'] : 0,
    ];
    return (object)$config;
}

function transactionRecord($credit_id ,$debit_id ,$order_id , $transaction_id , $type , $amount , $seller_amount , $fee , $expenses , $parent, $ref_debit , $ref_credit , $kyc_return)
{
    return Transaction::create([
        'credit_user'=>$credit_id  ?? null,
        'debit_user'=>$debit_id  ?? null,
        'order_id'=>$order_id  ?? null,
        'transaction_id'=>$transaction_id  ?? null,
        'type'=>$type  ?? null,
        'amount'=>$amount ?? null,
        'seller_amount'=>$seller_amount ?? 0,
        'fee'=>$fee ?? 0,
        'expenses'=>$expenses ?? 0,
        'parent_id'=>$parent ?? null,
        'buyer_referal_debit'=>$ref_debit ?? 0,
        'referee_credit'=>$ref_credit ?? 0,
        'seller_kyc_return'=>$kyc_return ?? 0,
    ]);
}
function getKyc($kyc)
{
    $statusArr = [
        'VALIDATION_ASKED'=>'pending',
        'CREATED'=>'pending',
        'VALIDATED'=>'validated',
        'REFUSED'=>'denied',
        'OUT_OF_DATE'=>'denied',
    ];
    $status = $statusArr[$kyc->Status];
    $classArr = [
        'pending'=>'bg-primary',
        'validated'=>'bg-success',
        'denied'=>'bg-danger',
    ];
    $class =  $classArr[$status];
    $noteArr = [
        'pending'=>'This process can take up to 48 hours, sometimes
        more.',
        'denied'=>'There was an issue with the KYC verification of your
        account. Make sure your document is a high-quality photo or scan and that every detail
        is clearly legible, including its colours. Try uploading your rescanned document again or
        contact our support if you get denied again.',
        'validated'=>''
    ];
    $note = $noteArr[$status];
    $object = [
        'name'=>str_replace('_',' ',$kyc->Type),
        'date'=>Carbon::createFromTimestamp($kyc->CreationDate),
        'status'=>$status,
        'class'=>$class,
        'note'=>$note
    ];

    return (object)$object;

}
function getUbo($kyc)
{
    $statusArr = [
        'VALIDATION_ASKED'=>'pending',
        'CREATED'=>'pending',
        'VALIDATED'=>'validated',
        'REFUSED'=>'denied',
        'OUT_OF_DATE'=>'denied',
    ];
    $status = $statusArr[$kyc->Status];
    $classArr = [
        'pending'=>'bg-primary',
        'validated'=>'bg-success',
        'denied'=>'bg-danger',
    ];
    $class =  $classArr[$status];
    $noteArr = [
        'pending'=>'This process can take up to 48 hours, sometimes
        more.',
        'denied'=>'',
        'validated'=>''
    ];
    $note = $noteArr[$status];
    $object = [
        'name'=>'KYB',
        'date'=>Carbon::createFromTimestamp($kyc->CreationDate),
        'status'=>$status,
        'class'=>$class,
        'note'=>$note
    ];

    return (object)$object;

}
function getOrderCount($status , $type)
{
    $column = $type == "sell" ? 'seller_id' : 'buyer_id';
    return Order::where($column , auth()->user()->id)
                ->where('status',$status)
                ->count();
}
function getAllOrderCount($status)
{
    return Order::where('status',$status)
                ->count();
}
function checkCardFoiling($foil , $nonfoil)
{
    switch (true) {
        case ($foil && $nonfoil):
            return 'Both';
        case (!$foil && !$nonfoil):
            return 'Foil';
        case ($foil && !$nonfoil):
            return 'Foil';
        case (!$foil && $nonfoil):
            return 'NonFoil';
        default:
            return 'Both';
    }
}
function checkCardFinishes($finishes)
{
    $finishes = $finishes ? json_decode($finishes) : [];
    return in_array('etched', $finishes) ? ['' , ''] : ['disabled','disable-foil'];
}
function getUserWallet($type = null)
{
    try {
        $mangoPayApi = mangopayApi();
        $user = auth()->user();
        $wallet = $user->default_wallet;
        $clearence = userClearenceAmount();
        if($wallet)
        {   
            $wallet = $mangoPayApi->Wallets->Get($wallet->wallet_id);
            $balance = $wallet->Balance->Amount/100;
            $amount =  $balance < $clearence ? 0:$balance-$clearence;
            return abs($amount) < 1e-10 ? 0.00 : number_format($amount, 2, '.', '');
        }
        return 0.00;
    } catch (Exception $e) {
        return 0.00;
    }
}
function userClearenceAmount()
{
    $user = auth()->user();
    $status = ["completed","cancelled" ,"refunded"];
    $transaction_types = ['order-transfer','extra'];
    $order_ids = Order::where('seller_id',$user->id)->whereNotIn('status',$status)->pluck('id')->toArray();
    $totalAmount = Transaction::whereIn('order_id',$order_ids)->whereIn('type',$transaction_types)->sum('seller_amount');
    $referalAmount = $user->store->vfs_wallet ?? 0;
    return $totalAmount +$referalAmount;
}
function getUserCart($collection_id , $type , $model = null)
{
    $id = auth()->user() ? auth()->user()->id : 0;
    if($type == "quantity" && auth()->user()){
        $cart = Cart::where('user_id',$id)
                    ->where('collection_type',$model)
                    ->where('collection_id',$collection_id)
                    ->first();
        return  $cart ? $cart->quantity : 0;
    }
    if($type == "count"){
        return  Cart::where('user_id',$id)->count();
    }
    if($type == "available-quantity"){
        $cart= Cart::where('user_id','!=',$id)
                ->where('collection_type',$model)
                ->where('collection_id',$collection_id)
                ->sum('quantity');
        $productModel = App::make($model);
        $collection = $productModel::findOrFail($collection_id);
        return  $collection ? (int)$collection->quantity - $cart : 0;
    }
    return 0;
}
function getSellerCartCalculations($id)
{
    $user = auth()->user();
    $postage_price = 0;
    $seller_cart = Cart::where('user_id',$user->id )->where('seller_id',$id)->get();
    $weight = $seller_cart->sum(function ($item) {
                return $item->collection->card->weight;
            });
    $price = $seller_cart->sum(function ($item) {
                    return $item->price*$item->quantity;
                });
    $postage = Postage::where('is_trackable',1)->where('weight','>=',$weight)->orderByRaw("ABS(weight - $weight)");
    $postage = $postage->where('max_order_price','>=',$price)->orderByRaw("ABS(max_order_price - $price)")->first();
    $pspConfig = vsfPspConfig();

    $platformFee = $price* ($pspConfig->platform_fee /100);
    $platformFee = number_format((float)$platformFee, 2, '.', '');
    $fee = $platformFee < 0.01 ? 0.01 : $platformFee;
    if($postage)
    {
        $postage_price =$postage_price+ $postage->price;
    }
    else
    {
        $postage = Postage::where('is_trackable',1)->orderByRaw("ABS(max_order_price - $price)")->first();
        $postage_price = $postage ? $postage_price+ $postage->price : 0;
    }

    return ['postage'=>$postage ,'postage_price' =>$postage_price , 'weight'=>$weight , 'price'=>$price ,'fee'=>$fee];
}
function languageFromName($lang)
{
    $code = false;
    switch ($lang)
    {
        case "English":
            $code = 'en';
            break;
        case "Spanish":
            $code = 'es';
            break;
        case "French":
            $code = 'fr';
            break;
        case "German":
            $code = 'de';
            break;
        case "Italian":
            $code = 'it';
            break;
        case "Portuguese":
            $code = 'pt';
            break;
        case "Japanese":
            $code = 'ja';
            break;
        case "Japanese":
            $code = 'jp';
            break;
        case "Korean":
            $code = 'ko';
            break;
        case "Korean":
            $code = 'kr';
            break;
        case "Russian":
            $code = 'ru';
            break;
        case "Simplified Chinese":
            $code = 'zhs';
            break;
        case "S-Chinese":
            $code = 'zhs';
            break;
        case "Traditional Chinese":
            $code = 'zht';
            break;
        case "T-Chinese":
            $code = 'zht';
            break;
        case "Hebrew":
            $code = 'he';
            break;
        case "Latin":
            $code = 'la';
            break;
        case "Ancient Greek":
            $code = 'grc';
            break;
        case "Arabic":
            $code = 'ar';
            break;
        case "Sanskrit":
            $code = 'sa';
            break;
        case "Phyrexian":
            $code = 'ph';
            break;

        default:
            $code = false;
            break;
    }

    return $code;
}
function languageFromCode($lang)
{
    switch ($lang)
    {
        case 'en':
            $fullname = "English";
            break;
        case 'es':
            $fullname = "Spanish";
            break;
        case 'fr':
            $fullname = "French";
            break;
        case 'de':
            $fullname = "German";
            break;
        case 'it':
            $fullname = "Italian";
            break;
        case 'pt':
            $fullname = "Portuguese";
            break;
        case 'ja':
            $fullname = "Japanese";
            break;
        case 'jp':
            $fullname = "Japanese";
            break;
        case 'ko':
            $fullname = "Korean";
            break;
        case 'kr':
            $fullname = "Korean";
            break;
        case 'ru':
            $fullname = "Russian";
            break;
        case 'zhs':
            $fullname = "Simplified Chinese";
            break;
        case 'zht':
            $fullname = "Traditional Chinese";
            break;
        case 'he':
            $fullname = "Hebrew";
            break;
        case 'la':
            $fullname = "Latin";
            break;
        case 'grc':
            $fullname = "Ancient Greek";
            break;
        case 'ar':
            $fullname = "Arabic";
            break;
        case 'sa':
            $fullname = "Sanskrit";
            break;
        case 'ph':
            $fullname = "Phyrexian";
            break;

        default:
            $fullname = false;
            break;
    }
    return $fullname;
}
function sendNotification($to , $from  , $type, $message ,$data , $route = null)
{
    $is_admin = 0;
    if(auth()->user())
    {
        $is_admin = User::where('id',auth()->user()->id)->whereNotIn('role',['buyer','seller','business'])->first() ? 1 : 0;
    }
    $data->notification()->create([
        'recieve_by'=>$to,
        'send_by'=>$from,
        'type'=>$type,
        'message'=>$message,
        'is_admin'=>$is_admin,
        'route'=>$route,
    ]);
    return true;
}
function getNotificationMsg($type,$name)
{
    $messages = [
        'sale'=>'Has placed an order, view details',
        'dispatched'=>'Has dispatched an order, view details',
        'cancelled'=>'Has cancelled an order',
        'dispute'=>'Has opened a dispute for your order',
        'completed'=>'Has marked an order as completed',
        'refunded'=>'You order is refunded successfully',
        'message'=>'Sent you a message',
    ];
    return  $messages[$type];

}
function getUserNotifications($type)
{
    $id = auth()->user() ? auth()->user()->id : 0;
    $notifications =Notification::where('recieve_by',$id)->where('is_readed',0)->orderBy('created_at','desc')->get();

    if($type == "count"){
        return count($notifications);
    }
    return $notifications;
}
function userReferalTypes()
{
    return UserReferralType::pluck('name')->toArray();
}


function getPages($type)
{
   return Page::where('appearance_type', 'like', '%' . $type . '%')->where('status',1)->get();
}
function getPagesRoute($slug)
{
    $page = Page::where('slug', 'like', '%' . $slug . '%')->where('status',1)->first();
    return $page ? route('page',$page->slug) : '#';
}

function isExistInArray($type,$app)
{
   $arr = explode(',',$type);

   return in_array($app,$arr) ? true : false;
}

function customDate($date, $format)
{
    return Carbon::parse($date)->format($format);
}
function dateFromTimestamp($date)
{
    return Carbon::createFromTimestamp($date);
}
function getCategoryById($id)
{
    $cat =  FaqCategory::where('id',$id)->first();
    return $cat ? $cat->title : '';
}
function allMtgLanguages()
{
    return [
        'en'=> "English",
        'es'=> "Spanish",
        'fr'=> "French",
        'de'=> "German",
        'it'=> "Italian",
        'pt'=> "Portuguese",
        'ja'=> "Japanese",
        'ko'=> "Korean",
        'ru'=> "Russian",
        'zhs'=> "Simplified Chinese",
        'zht'=> "Traditional Chinese",
        'he'=> "Hebrew",
        'la'=> "Latin",
        'grc'=> "Ancient Greek",
        'ar'=> "Arabic",
        'sa'=> "Sanskrit",
        'ph'=> "Phyrexian",
        ];
}
function allMtgLegalities()
{
    return ["standard","future","historic","gladiator","pioneer","explorer","modern","legacy","pauper","vintage","penny","commander","oathbreaker","brawl","historicbrawl","alchemy","paupercommander","duel","oldschool","premodern","predh"];
}
function mtgSetAvaiLang($id)
{
    $all = [
    'en'=> "English",
    'es'=> "Spanish",
    'fr'=> "French",
    'de'=> "German",
    'it'=> "Italian",
    'pt'=> "Portuguese",
    'ja'=> "Japanese",
    'jp'=> "Japanese",
    'ko'=> "Korean",
    'kr'=> "Korean",
    'ru'=> "Russian",
    'zhs'=> "Simplified Chinese",
    'zht'=> "Traditional Chinese",
    'he'=> "Hebrew",
    'la'=> "Latin",
    'grc'=> "Ancient Greek",
    'ar'=> "Arabic",
    'sa'=> "Sanskrit",
    'ph'=> "Phyrexian",
    ];
    $set_langs = MtgSetLanguage::where('mtg_set_id',$id)->pluck('key')->toArray();
    return array_diff($all , $set_langs);;

}
function mtgSetLegality($id)
{
    $set = MtgSet::findOrFail($id);
    $json = json_decode($set->legalities);
    $legalities =[];
    if($json)
    {
        foreach($json as $legal)
        {
            $arr = explode(':' , $legal);
            if($arr[1] == "legal")
            {
                $legalities[] = $arr[0];
            }
        }
    }
   
    return $legalities;
}
function mtgSetAvaiLegality($id)
{
    $legalities =mtgSetLegality($id);
    $all = allMtgLegalities();
    return array_diff($all , $legalities);
}

 function getDateRange($date = null)
{
    if(!$date)
    {
      return [now()->subDays(30),now()];
    }
    $arr = explode(' to ', $date);
    $start = isset($arr[1]) ? $arr[0] : Carbon::parse($arr[0])->subDays(30)->format('Y-m-d');
    $end = isset($arr[1]) ? $arr[1] : $arr[0];
    return [$start,$end];

}
function getFilterTypes($type)
{
   if($type == 'time')
   {
    return ['daily','monthly','yearly'];
   }


}
function sellerEarning($sum , $items , $type)
{
    $ids = [];
    foreach($items as $item)
    {
        $ids[]= explode(',',$item->postages);
    }
    $ids = array_merge(...$ids);
    $postages_price = Postage::whereIn('id',$ids)->sum('price');
    $amount = $sum - $postages_price;
    $pspConfig = vsfPspConfig();
    $fee=  $amount* ($pspConfig->platform_fee /100);
    $vat=  ($pspConfig->vat_percentage/100) * $amount;
    $total_commision = $vat + $fee;
    $total= $sum - $total_commision;

    if($type == "total")
    {
        return $total;
    }
    else{
        $ids = [];
        foreach($items as $item)
        {
            $ids[]= explode(',',$item->sellers);
        }
        $ids = array_merge(...$ids);
        $count = count($ids) ? count($ids) : 1;
        $avg = $total/$count;
        return number_format((float)$avg, 2, '.', '');
    }

    return $sum - $total_commision;
}

function ipStackCall($ipAddress)
{
    try {
        $response = Http::get("http://api.ipstack.com/{$ipAddress}?access_key=".config('helpers.general.location_api_key'));
        if ($response->successful()) {
           return $response->json();
        }
     } catch (\Exception $e) {
        $data['country_name'] = null;
        $data['region_name'] = null;
        $data['city'] = null;
        return $data;
     }
}
function isVisitorExist($ipAddress)
{
    $v = DB::table('visitors')->where('ip', $ipAddress)->first();
    if($v)
    {
        $data['country_name'] = $v->country;
        $data['region_name'] = $v->area;
        $data['city'] = $v->city;
        return $data;
    }
    return null;

}
function avgBuyerSpending($items , $sum)
{
    $ids = [];
    foreach($items as $item)
    {
        $ids[]= explode(',',$item->buyers);
    }
    $ids = array_merge(...$ids);
    $count = count($ids) ? count($ids) : 1;
    $avg = $sum/$count;
    return number_format((float)$avg, 2, '.', '');
}

function avgOrders($items , $sum)
{
    $ids = [];
    foreach($items as $item)
    {
        $ids[]= explode(',',$item->ids);
    }
    $ids = array_merge(...$ids);
    $count = count($ids) ? count($ids) : 1;
    $avg = $sum/$count;
    return number_format((float)$avg, 2, '.', '');
}
function ordersSuccessRate($items , $type)
{
    $ids = [];
    foreach($items as $item)
    {
        $ids[]= explode(',',$item->ids);
    }
    $ids = array_merge(...$ids);
    $orders = Order::whereIn('id',$ids)->get();
    $complete = 0;
    foreach($orders as $item)
    {
        if($item->status == "completed")
        {
            $complete++;
        }
    }
    $count = count($ids) ? count($ids) : 1;

    if($type == "complete")
    {
        return $complete;
    }
    if($type == "total")
    {
        return $count;
    }
    $rate = ($complete / $count) * 100;
    return number_format((float)$rate, 2, '.', '');
}
function ordersQuantity($items)
{
    $ids = [];
    foreach($items as $item)
    {
        $ids[]= explode(',',$item->ids);
    }
    $ids = array_merge(...$ids);
    return OrderDetail::whereIn('order_id',$ids)->sum('quantity');
}
function liquidityRate($type = null , $id = null)
{

    $total_collection = MtgUserCollection::when($type == 'user',function($q)use($id){
                            $q->where('user_id',$id);
                        })
                        ->where('publish',1)->count();
    $convert_to_orders = OrderDetail::when($type == 'user',function($q)use($id){
                                $order_ids = Order::where('seller_id',$id)->pluck('id')->toArray();
                                $q->whereIn('order_id',$order_ids);
                            })
                            ->distinct('mtg_user_collection_id')->count();
    $pending = $total_collection - $convert_to_orders;
    $convert_per = getPercentage($convert_to_orders , $total_collection);
    $pending_per = getPercentage($pending , $total_collection);
    return (object) ['total_no'=>$total_collection ,'pending_no'=>$pending ,'convert_no'=>$convert_to_orders,'convert_per'=>$convert_per , 'pending_per'=>$pending_per];
}

function collectionStatusRate($type)
{
    $total_collection = MtgUserCollection::count();
    $active = MtgUserCollection::where('publish',1)->where('mtg_card_type',$type)->count();
    $inactive = MtgUserCollection::where('publish',0)->where('mtg_card_type',$type)->count();
    $convert_to_orders = OrderDetail::whereHas('userCollection'
    // ,function($q)use($type){
    //     $q->where('mtg_card_type',$type);
    // }
    )
                            ->distinct('user_collection_id')->count();

    $active_per = getPercentage($active , $total_collection);
    $inactive_per = getPercentage($inactive , $total_collection);
    $convert_per = getPercentage($convert_to_orders , $total_collection);
    return (object) ['active_no'=>$active,'active_per'=>$active_per,'inactive_no'=>$inactive,'inactive_per'=>$inactive_per,'convert_no'=>$convert_to_orders,'convert_per'=>$convert_per];
}
function getPercentage($obtain , $total)
{
    $total = $total == 0 ? 1 : $total;
    $percentage = ($obtain / $total) *100;
    return number_format((float)$percentage, 2, '.', '');
}
function userEarning($id)
{
    $sale = Order::where('seller_id',$id)->where('status','completed');
    $ids = $sale->pluck('postage_id')->toArray();
    $sum = $sale->sum('total');
    $postages_price = Postage::whereIn('id',$ids)->sum('price');
    $amount = $sum - $postages_price;
    $pspConfig = vsfPspConfig();
    $fee=  $amount* ($pspConfig->platform_fee /100);
    $vat=  ($pspConfig->vat_percentage/100) * $amount;
    $total_commision = $vat + $fee;
    return $sum - $total_commision;
}
function userVfsRevenue($id , $type)
{
    $sale = Order::when($type=='sale',function($q)use($id){
                    $q->where('seller_id',$id);
                })
                ->when($type=='purchase',function($q)use($id){
                    $q->where('buyer_id',$id);
                })
                ->where('status','completed');
    $ids = $sale->pluck('postage_id')->toArray();
    $sum = $sale->sum('total');
    $postages_price = Postage::whereIn('id',$ids)->sum('price');
    $amount = $sum - $postages_price;
    $pspConfig = vsfPspConfig();
    $fee=  $amount* ($pspConfig->platform_fee /100);
    $vat=  ($pspConfig->vat_percentage/100) * $amount;
    $total_commision = $vat + $fee;
    return $total_commision;
}
function mtgSealedTypes()
{
    return [
        "Booster box",
        "Booster pack",
        "Bundle",
        "Decks",
        "Boxed Set",
        "Life Counter",
        "Deck boxes",
        "Albums",
        "Tournament deck",
        "Playmats",
        "Prerelease",
        "Booster Pack",
    ];
}
function mtgCardsRarity()
{
    return [
        "Common",
        "Uncommon",
        "Mythic",
        "Rare",
    ];
}

function getConvers($seller_id,$buyer_id)
{
    return Conversation::where(function($q)use($seller_id,$buyer_id){
                    $q->where('sender_id',$seller_id)->where('receiver_id',$buyer_id);
    })->orWhere(function($q)use($buyer_id,$seller_id){
        $q->where('sender_id',$buyer_id)->where('receiver_id',$seller_id);
    })->first();
}
function userStatsArray($dates , $data , $type)
{
    $array = [];
    foreach($dates as $key => $date){
        $array[] = ['Area'=>$date , $type=>'£'.$data[$key]];
    }
    return $array;
}
function mtgCardAvaiLang($id)
{
    $languages = [];
    $card = MtgCard::find($id);
    if($card->card_languages)
    {
        $languages = $card->card_languages;
    }
    $all = allMtgLanguages();
    return array_diff($all , $languages);
}
function mtgCardAvaiLegality($id)
{
    $legalities = [];
    $card = MtgCard::find($id);
    if($card->legalities){
        $legalities = array_keys(json_decode($card->legalities , true));
    }
    $all = allMtgLegalities();
    return array_diff($all , $legalities);
}
function verifiedUsers()
{
    $user_ids = User::where('verified',1)->pluck('id')->toArray();
    $block_ids = auth()->user() ?  BlockUser::where('user_id',auth()->user()->id)->pluck('block_user_id')->toArray() : [];
    return array_diff($user_ids , $block_ids);
}
function userStatuses()
{
    return [
        'active',
        'inactive',
        'locked',
        'ban',
        'on-holiday'
    ];
}
function mtgMeldCards()
{
    return MtgCard::where('layout','meld')->pluck('name')->toArray();
}
function launchingTimer()
{
    $timer = Setting::where('key','launching-in-timer')->first();
    if($timer)
    {
        $date = Carbon::parse($timer->value)->format('Y-m-d');   
        return (string)$date; 
    }
    return now()->format('Y-m-d');
}

function chatUserIds()
{
    $authId = auth()->user()->id;
    $conversations = DB::table('conversations')
    ->select('receiver_id as user_id', 'updated_at')
    ->where('sender_id', $authId)
    ->orWhere('receiver_id', $authId)
    ->groupBy('receiver_id')
    ->orderBy('updated_at', 'desc');

$senderIds = DB::table('conversations')
    ->select('sender_id as user_id', 'updated_at')
    ->where('receiver_id', $authId)
    ->groupBy('sender_id')
    ->union($conversations)
    ->orderBy('updated_at', 'desc')
    ->pluck('user_id')->toArray();
    return $senderIds;
}

use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Cookie;

function getDateByType($type,$startDate,$endDate)
{
    if($type == 'monthly')
    {
        $monthsInRange = CarbonPeriod::create($startDate->firstOfMonth(), '1 month', $endDate->firstOfMonth());
        // Extract unique month and year combinations
        $range = collect(iterator_to_array($monthsInRange))->map(function ($date) {
            return $date->format('Y-m');
        })->unique()->values()->all();
    }
    elseif($type == 'yearly')
    {
        $yearsInRange = CarbonPeriod::create($startDate->firstOfYear(), '1 year', $endDate->firstOfYear());
        // Extract unique years
        $range = collect(iterator_to_array($yearsInRange))->map(function ($date) {
            return $date->year;
        })->unique()->values()->all();
    }
    else{
        $datesInRange = iterator_to_array(CarbonPeriod::create($startDate, '1 day', $endDate));
        $range = array_map(function ($date) {
            return $date->format('Y-m-d');
        }, $datesInRange);
    }
   
    return $range;
}
function userStatusUpdateTitles($status)
{
    $titlesArr = [
        'active'=>[
                   'subject'=> 'ACCOUNT ACTIVE BY ADMIN - VERY FRIENDLY SHARKS',
                   'detail'=>'Your account is activated by admin'
        ],
        'inactive'=>[
                    'subject'=> 'ACCOUNT INACTIVE BY ADMIN - VERY FRIENDLY SHARKS',
                    'detail'=>'Your account is inactivated by admin'
        ],
        'ban'=>[
            'subject'=> 'ACCOUNT BAN BY ADMIN - VERY FRIENDLY SHARKS',
            'detail'=> 'Your account is banned by admin'
        ],
        'locked'=>[
                    'subject'=> 'ACCOUNT LOCK BY ADMIN - VERY FRIENDLY SHARKS',
                    'detail'=> 'your account is locked by admin'
        ],
    ];
    return (object)$titlesArr[$status];
}
function helpTicketCategory($index)
{   
    $category = [
        '1'=>    'Technical Issues',
        '2'=>    'Account Issues',
        '3'=>    'Order Issues',
        '4'=>    'Report User',
        '5'=>    'Order Dispute',
        '6'=>    'Others',
    ];
    return array_key_exists($index , $category) ? $category[$index] : 'Others';
}
function canDeleteAccount()
{
    $user = auth()->user();
    $status = ['completed','refunded','cancelled'];
    $sell = $user->sellingOrders->whereNotIn('status',$status)->count();
    $buy = $user->buyingOrders->whereNotIn('status',$status)->count();
    $orders = $buy + $sell;
    $canDelete = $orders;
    return $canDelete;
}
function MtgCardsOracleText($type)
{
    if($type == "single")
    {
        return "";
    }
    $bullet = '<span class="ps-3">&#10687;</span>';
    $sealedOracleText = 'A sealed product comes with its original packaging intact, factory sealed and not maliciously tampered with in any way. It cannot be opened nor resealed. You cannot sell a product on our website as sealed unless these specific requirements apply to it.
        Sealed products can have varying degrees of quality and condition in packaging, so long as the above rules apply.';

    $completeOracleText ='Each set must contain one of each of the card types present in a specific expansion.
                        '.$bullet .' A full set means one of each of the cards in the entire expansion.
                        '.$bullet .' A commons set means one of each of the common cards that appear in a specific expansion.
                        '.$bullet .' An uncommons set means one of each of the uncommons that appear in a specific expansion.
                        '.$bullet .' A rares set means one of each of the rares that appear in a specific expansion.
                        '.$bullet .' A mythics set means one of each of the rares that appear in a specific expansion.
                        '.$bullet .' A basic land set means one of each of the basic lands that appear in a specific expansion.
                        '.$bullet .' A token set means one of each of the tokens that appear in a specific expansion.
                        '.$bullet .' An art card set means one of each of the art cards that appear in a specific expansion.
                        To be able to sell on our website you must have one or all of the above rules when listing a "set" for sale. If your set contains cards with different versions, you must state this in the product notes or notify buyers when they purchase as to avoid yourself issues down the line.';
    // dd($completeOracleText);
    return $type == "sealed" ? $sealedOracleText : $completeOracleText;
}
function vfsWebConfig()
{
    $config = Setting::where('key','web_config')->first();
    return $config && $config->value == "on" ? true : false;
}
function cookies($type)
{
    return Cookie::get($type);
}

function getLanguages()
{
    return [
        'en' => 'English',
        'de' => 'German',
        'fr' => 'French',
        'it' => 'Italian',
        'pt' => 'Portuguese',
        'sp' => 'Spanish',
        'ru' => 'Russian',
        'zhs' => 'Chinese',
        'kr' => 'Korean',
        'ja' => 'Japanese',
        'ph' => 'Phyrexian',

    ];
}
function getConditions()
{
    return [
        'NM' => 'Near Mint',
        'LP' => 'Light Played',
        'MP' => 'Moderate Play',
        'HP' => 'Heavy Play',
        'DMG' => 'Damaged',
    ];  
}
function getCharacteristics()
{
    return [
        'foil' => 'Foil',
        'signed' => 'Signed',
        'altered' => 'Altered',
        'graded' => 'Graded',
    ];  
}
function isCharacterExist($arr)
{
    $data =[];
   foreach(getCharacteristics() as $c => $char)
   {
     if(!in_array($c,$arr))
     {
        $data[] = $c;
     }
   }
   return $data;
}
function createOrUpdateRedirect($before , $after)
{
    $data =[
        'from'=>$before,
        'to'=>$after,
        'created_at'=>now(),
        'updated_at'=>now(),
      ];
     $query = ['to'=>$before];
    return Redirect::updateOrInsert($query , $data);
}
function setUrlSlug($item , $slug)
{
    return  $item->set->type == "child" && $item->set->parent ? $item->set->parent->slug : $slug;
}
function setUrlType($item , $slug)
{
    if($item->set->type == "special" || $item->set->type == "expansion")
    {
        $index = array_search($item->card_type,cardTypeSlug());
        return $index ? $index : 'single-cards';
    }
    if($item->set->custom_type == 'singles')
    {
        return $slug;
    }
    return Str::slug($item->set->custom_type);
}

function getRefelUserAmount($referal_id , $user_id)
{
    $order_id = Order::where('buyer_id',$referal_id)->pluck('id')->toArray();
    return Transaction::whereIn('order_id',$order_id)->where('credit_user',$user_id)->where('type','referal')->sum('amount');
}

function getAdmin()
{
    return User::findOrFail(1);
}
function checkKycFailed()
{
    $user = auth()->user();
    $kycs = UserKyc::where('user_id',$user->id);
    if($kycs->count() > 0)
    {
        if($user->role == "seller")
        {
            $kyc = $kycs->latest()->first();
            // dd($kyc);
            return $kyc->mangopay_response == "Failed" ? 1 : 0;
        }
        if($user->role == "business")
        {
            $kyc = $kycs->latest()->take(3)->get();
            $kyc =  $kyc->where('mangopay_response','Failed')->first();
            return $kyc ? 1 : 0;
        }
    }
    return 0;
}
function getFailedKyc($type)
{
    $kyc = UserKyc::where('user_id',auth()->user()->id)->where('key',$type)->first();
    return [$kyc,$kyc && $kyc->mangopay_response == "Failed" ? 1 : 0];

}
function authUserCollectionCount($publish , $type = null)
{
    return MtgUserCollection::where('user_id',auth()->user()->id)
                                ->when($type != null ,function($q)use($type){
                                    $q->where('mtg_card_type',$type);
                                })
                                ->where('publish',$publish)
                                ->count();
}
function uploadImage($file, $path){
    $name = time().'-'.str_replace(' ', '-', $file->getClientOriginalName());
    $file->move($path,$name);
    return $path.'/'.$name;
}
function mangopayIsoCountryCode()
{
    return ["AF" => "Afghanistan","AL" => "Albania","DZ" => "Algeria","AS" => "American Samoa","AD" => "Andorra","AO" => "Angola","AI" => "Anguilla","AQ" => "Antarctica","AG" => "Antigua and Barbuda","AR" => "Argentina","AM" => "Armenia","AW" => "Aruba","AU" => "Australia","AT" => "Austria","AZ" => "Azerbaijan","BS" => "Bahamas","BH" => "Bahrain","BD" => "Bangladesh","BB" => "Barbados","BY" => "Belarus","BE" => "Belgium","BZ" => "Belize","BJ" => "Benin","BM" => "Bermuda","BT" => "Bhutan","BO" => "Bolivia","BA" => "Bosnia and Herzegovina","BW" => "Botswana","BV" => "Bouvet Island","BR" => "Brazil","IO" => "British Indian Ocean Territory","BN" => "Brunei Darussalam","BG" => "Bulgaria","BF" => "Burkina Faso","BI" => "Burundi","KH" => "Cambodia","CM" => "Cameroon","CA" => "Canada","CV" => "Cape Verde","KY" => "Cayman Islands","CF" => "Central African Republic","TD" => "Chad","CL" => "Chile","CN" => "China","CX" => "Christmas Island","CC" => "Cocos (Keeling) Islands","CO" => "Colombia","KM" => "Comoros","CG" => "Congo","CD" => "Congo, the Democratic Republic of the","CK" => "Cook Islands","CR" => "Costa Rica","CI" => "Cote D'Ivoire","HR" => "Croatia","CU" => "Cuba","CY" => "Cyprus","CZ" => "Czech Republic","DK" => "Denmark","DJ" => "Djibouti","DM" => "Dominica","DO" => "Dominican Republic","EC" => "Ecuador","EG" => "Egypt","SV" => "El Salvador","GQ" => "Equatorial Guinea","ER" => "Eritrea","EE" => "Estonia","ET" => "Ethiopia","FK" => "Falkland Islands (Malvinas)","FO" => "Faroe Islands","FJ" => "Fiji","FI" => "Finland","FR" => "France","GF" => "French Guiana","PF" => "French Polynesia","TF" => "French Southern Territories","GA" => "Gabon","GM" => "Gambia","GE" => "Georgia","DE" => "Germany","GH" => "Ghana","GI" => "Gibraltar","GR" => "Greece","GL" => "Greenland","GD" => "Grenada","GP" => "Guadeloupe","GU" => "Guam","GT" => "Guatemala","GN" => "Guinea","GW" => "Guinea-Bissau","GY" => "Guyana","HT" => "Haiti","HM" => "Heard Island and Mcdonald Islands","VA" => "Holy See (Vatican City State)","HN" => "Honduras","HK" => "Hong Kong","HU" => "Hungary","IS" => "Iceland","IN" => "India","ID" => "Indonesia","IR" => "Iran, Islamic Republic of","IQ" => "Iraq","IE" => "Ireland","IL" => "Israel","IT" => "Italy","JM" => "Jamaica","JP" => "Japan","JO" => "Jordan","KZ" => "Kazakhstan","KE" => "Kenya","KI" => "Kiribati","KP" => "Korea, Democratic People's Republic of","KR" => "Korea, Republic of","KW" => "Kuwait","KG" => "Kyrgyzstan","LA" => "Lao People's Democratic Republic","LV" => "Latvia","LB" => "Lebanon","LS" => "Lesotho","LR" => "Liberia","LY" => "Libyan Arab Jamahiriya","LI" => "Liechtenstein","LT" => "Lithuania","LU" => "Luxembourg","MO" => "Macao","MK" => "Macedonia, the Former Yugoslav Republic of","MG" => "Madagascar","MW" => "Malawi","MY" => "Malaysia","MV" => "Maldives","ML" => "Mali","MT" => "Malta","MH" => "Marshall Islands","MQ" => "Martinique","MR" => "Mauritania","MU" => "Mauritius","YT" => "Mayotte","MX" => "Mexico","FM" => "Micronesia, Federated States of","MD" => "Moldova, Republic of","MC" => "Monaco","MN" => "Mongolia","MS" => "Montserrat","MA" => "Morocco","MZ" => "Mozambique","MM" => "Myanmar","NA" => "Namibia","NR" => "Nauru","NP" => "Nepal","NL" => "Netherlands","NC" => "New Caledonia","NZ" => "New Zealand","NI" => "Nicaragua","NE" => "Niger","NG" => "Nigeria","NU" => "Niue","NF" => "Norfolk Island","MP" => "Northern Mariana Islands","NO" => "Norway","OM" => "Oman","PK" => "Pakistan","PW" => "Palau","PS" => "Palestinian Territory, Occupied","PA" => "Panama","PG" => "Papua New Guinea","PY" => "Paraguay","PE" => "Peru","PH" => "Philippines","PN" => "Pitcairn","PL" => "Poland","PT" => "Portugal","PR" => "Puerto Rico","QA" => "Qatar","RE" => "Reunion","RO" => "Romania","RU" => "Russian Federation","RW" => "Rwanda","SH" => "Saint Helena","KN" => "Saint Kitts and Nevis","LC" => "Saint Lucia","PM" => "Saint Pierre and Miquelon","VC" => "Saint Vincent and the Grenadines","WS" => "Samoa","SM" => "San Marino","ST" => "Sao Tome and Principe","SA" => "Saudi Arabia","SN" => "Senegal","SC" => "Seychelles","SL" => "Sierra Leone","SG" => "Singapore","SK" => "Slovakia","SI" => "Slovenia","SB" => "Solomon Islands","SO" => "Somalia","ZA" => "South Africa","GS" => "South Georgia and the South Sandwich Islands","ES" => "Spain","LK" => "Sri Lanka","SD" => "Sudan","SR" => "Suriname","SJ" => "Svalbard and Jan Mayen","SZ" => "Swaziland","SE" => "Sweden","CH" => "Switzerland","SY" => "Syrian Arab Republic","TW" => "Taiwan, Province of China","TJ" => "Tajikistan","TZ" => "Tanzania, United Republic of","TH" => "Thailand","TL" => "Timor-Leste","TG" => "Togo","TK" => "Tokelau","TO" => "Tonga","TT" => "Trinidad and Tobago","TN" => "Tunisia","TR" => "Turkey","TM" => "Turkmenistan","TC" => "Turks and Caicos Islands","TV" => "Tuvalu","UG" => "Uganda","UA" => "Ukraine","AE" => "United Arab Emirates","GB" => "United Kingdom","US" => "United States","UM" => "United States Minor Outlying Islands","UY" => "Uruguay","UZ" => "Uzbekistan","VU" => "Vanuatu","VE" => "Venezuela","VN" => "Viet Nam","VG" => "Virgin Islands, British","VI" => "Virgin Islands, U.s.","WF" => "Wallis and Futuna","EH" => "Western Sahara","YE" => "Yemen","ZM" => "Zambia","ZW" => "Zimbabwe","AX" => "Åland Islands","BL" => "Saint Barthélemy","BQ" => "Bonaire, Sint Eustatius and Saba","CW" => "Curaçao","GG" => "Guernsey","IM" => "Isle of Man","JE" => "Jersey","ME" => "Montenegro","MF" => "Saint Martin (French part)","RS" => "Serbia","SS" => "South Sudan","SX" => "Sint Maarten (Dutch part)"];
}
function getUserNewlyCollections($num,$id,$type = null)
{
    if($type){
        $typeArr = cardTypeSlug();
        $type = array_key_exists($type , $typeArr) ? $typeArr[$type] :'single' ;
        $cols =  MtgUserCollection::check()->where('publish',1)
            ->whereHas('card',function($que)use($type){
                $que->where('card_type',$type);
            })->where('user_id',$id)->orderBy('id','desc')->take($num)->get();
    }else{
        $cols =  MtgUserCollection::check()->where('publish',1)->where('user_id',$id)->orderBy('id','desc')->take($num)->get();
    }
    return [$cols,count($cols)];

}

function getUserFeaturedCollections($num,$id,$type = null)
{
    if($type){
        $typeArr = cardTypeSlug();
        $type = array_key_exists($type , $typeArr) ? $typeArr[$type] :'single' ;
        $cols =  MtgUserCollection::check()->where('publish',1)
            ->whereHas('card',function($que)use($type){
                $que->where('card_type',$type);
            })->where('price','>=',10)->where('user_id',$id)->orderBy('id','desc')->take($num)->get();
    }else{
        $cols =  MtgUserCollection::check()->where('publish',1)->where('price','>=',10)->where('user_id',$id)->orderBy('id','desc')->take($num)->get();
    }
    return [$cols,count($cols)];

}
function kycShowFilter($kyc)
{
    $first_check = $kyc->Status != "CREATED" ? 1 : 0;
    $second_check = UserKyc::where('kyc_id',$kyc->Id)->first();
    return $first_check && $second_check ? 1 : 0;
}
function getExtraPayment($order)
{
    $transaction = Transaction::where('order_id',$order->id)->where('type','extra');
    $extraPayments = $transaction->get();
    $extraPrice = $extraPayments->sum('seller_amount');

    return [$extraPayments,$extraPrice];
}
function cardMarketConditions($key)
{
    $cons = [
        'MT' => 'NM',
        'NM' => 'NM',
        'EX' => 'LP',
        'GD' => 'MP',
        'LP' => 'LP',
        'PL' => 'HP',
        'PO' => 'DMG',
    ]; 
    return array_key_exists($key , $cons) ? $cons[$key] : null;
}
function csvStatusBadges($status)
{
    $arr = [
        'pending'=>'bg-secondary',
        'processing'=>'bg-primary',
        'Import Successfully'=>'bg-success',
        'Failed'=>'bg-danger',
    ];
    return array_key_exists($status , $arr) ? $arr[$status] : 'bg-secondary';
}
function updateCollectionByCard($col)
{
    return tap(MtgCard::find($col->mtg_card_id), function ($card)use($col) {
        if($card)
        {
            $col->update([
                'rarity' => $card->rarity,
                'cmc' => $card->cmc,
                'card_name' => $card->name,
                'int_collector_number' => $card->int_collector_number,
                'released_at' => $card->released_at,
            ]);
        }
    });
    
}
function diffBwtDates($d1 , $d2)
{
    $startDate = Carbon::createFromDate($d1);
    $endDate = Carbon::createFromDate($d2);

    return $endDate->diffInDays($startDate);
}
function withdrawStatus()
{
    return [
        'pending'=>'bg-primary',
        'rejected'=>'bg-danger',
        'approved'=>'bg-success',
    ];
}
function mangopayApi()
{
    $data = Config::get('helpers.mango_pay');
    $mangoPayApi = new MangoPay();
    $mangoPayApi->Config->ClientId = $data['client_id'];
    $mangoPayApi->Config->ClientPassword = $data['client_password'];
    $mangoPayApi->Config->TemporaryFolder = '../../';
    $mangoPayApi->Config->BaseUrl = $data['base_url'];
    return $mangoPayApi;
}
function checkUseKYCPayment()
{
    try{
        $mangoPayApi = mangopayApi();
        $user = auth()->user();
        $payId = $user->store->kyc_payment_id;
        if(!$user->store->kyc_payment && $payId)
        {
            $payin = $mangoPayApi->PayIns->Get($payId);
            $pay = $payin->Status == "SUCCEEDED" ? 1 : 0;
            $payId = $payin->Status == "SUCCEEDED" ? $payId : null;
            if($pay == 0 && $payin->Status == "FAILED")
            {
                UserStore::where('user_id',auth()->user()->id)->update(['kyc_payment'=>0,'kyc_payment_id'=>null]);
                $user = auth()->user();
                $m = new Message();
                sendNotification($user->id,1 , 'message','Payment for KYC/KYB was not Successfully please try again.' ,$m , route('user.mangopay.kyc.detail'));
            }
            if($pay == 1)
            {
                UserStore::where('user_id',auth()->user()->id)->update(['kyc_payment'=>1,'kyc_payment_id'=>$payId]);
                $m = new Message();
                sendNotification($user->id,1 , 'message','Payment for KYC/KYB Successfully received.' ,$m , route('user.mangopay.kyc.detail'));
                // sendMail([
                //     'view' => 'email.account.receive-kyc-request',
                //     'to' => $user->email,
                //     'subject' => 'Your VFS Account is KYC / KYB Approved!',
                //     'data' => [
                //         'subject'=>'Your VFS Account is KYC / KYB Approved! ',
                //         'name'=>$user->user_name,
                //         'email'=>$user->email,
                //     ]
                // ]);
            }
        }
    }
    catch(Exception $e)
    {
    }
}

function getVerified($val)
{
    $arr =  [
        'kyc' => 'KYC Unverified',
        'kyc_ver' => 'KYC verified',
        'kyb' => 'KYB Unverified',
        'kyb_ver' => 'KYB verified',
    ];
    return array_key_exists($val , $arr) ? $arr[$val] : null;
}
function paymentCards()
{
    return PaymentCard::where('type','CB_VISA_MASTERCARD')->get();
}
function paymentCharges()
{
    return [
        'percentage'=>1.4,
        'additional'=>0.20
    ];
}
function payinSuggestionforCheckout()
{
    return [
        10.00,
        50.00,
        100.00,
        500.00
    ];
}
function calculatePayinServiceCharges($amt)
{
    $percentage = paymentCharges()['percentage'];
    $additional = paymentCharges()['additional'];
    $serviceCharges = ((float)$amt/100)*($percentage)+($additional);
    return number_format($serviceCharges, 2, '.', '');
}
function check_auth_block($userr)
{
    return auth()->user() ? BlockUser::where('user_id',$userr)->where('block_user_id',auth()->user()->id)->first() : false;
}

function getRouteBase()
{
    $currentRoute = Route::current();
    if ($currentRoute && $currentRoute->getName()) {
        $currentRouteName = $currentRoute->getName();
    if (Route::has($currentRouteName)) {
        $routeNameParts = explode('.', $currentRouteName);
        return $routeNameParts[0] ?? 'mtg';
    } else {
        return 'mtg';
    }
    } else {
        return 'mtg';
    }
  
}

function getCardRanges()
{
    return Range::pluck('abbr','name')->toArray();
}

function wsCardsTypes()
{
    return [
        'Leader',
        'Unit',
        'Event',
        'Base',
        'Upgrade',
        'Token Upgrade',
    ];
}

function wsRarity()
{
    return [
        'Rare',
        'Uncommon',
        'Common',
        'Legendary',
        'Special',
    ];
}
function wsCardsTraits()
{
    return [
        "Armor",
        "Bounty Hunter",
        "Capital Ship",
        "Clone",
        "Condition",
        "Creature",
        "Disaster",
        "Droid",
        "Fighter",
        "Force",
        "Fringe",
        "Gambit",
        "Hutt",
        "Imperial",
        "Innate",
        "Inquisitor",
        "Item",
        "Jawa",
        "Jedi",
        "Law",
        "Learned",
        "Lightsaber",
        "Mandalorian",
        "Modification",
        "New Republic",
        "Official",
        "Plan",
        "Rebel",
        "Republic",
        "Resistance",
        "Separatist",
        "Sith",
        "Spectre",
        "Speeder",
        "Supply",
        "Tactic",
        "Tank",
        "Transport",
        "Trick",
        "Trooper",
        "Twi'lek",
        "Underworld",
        "Vehicle",
        "Walker",
        "Weapon",
        "Wookiee"
        ];
}

function mtgListingCollections($card_type , $type ,$request , $latestUsers , $limit)
{
    $total_count = 0;
    $ids = [];
    foreach($latestUsers as $user_id){
        list($collections, $count ) = $type == 'new' ? getUserNewlyCollections(3,$user_id,$card_type) : getUserFeaturedCollections(3,$user_id,$card_type);
        foreach($collections as $collection){
            $ids[] = $collection->id;
            $total_count = $total_count + $count;
            if($total_count >= $limit)
            {
                break;
            }
        }
    }
    $order = request()->order ? request()->order : 'asc';
    $collections = MtgUserCollection::whereIn('id',$ids)
    ->check()
    ->when($request->fill_lang, function($q) use($request){
        $q->where('language',$request->fill_lang);
    })
    ->when($request->fill_condition, function($q) use($request){
        $q->where('condition',$request->fill_condition);
    })
    ->when($request->characters, function($q) use($request){
        $conditions = [];
        foreach ($request->characters as $column) {
            $conditions[$column] = 1;
        }
        $q->where($conditions);
    })
    ->where('quantity','!=',0)
    ->orderBy('price',$order)->get();
    return $collections;

}
function getStarWarIcon()
{
    return asset('images/sw/star-wars-logo-80607D2AC5-seeklogo.com.png');
}

function getCardBaseRoute($val)
{
    $arr = [
        'App\Models\MTG\MtgUserCollection' => 'mtg',
        'App\Models\SW\SwUserCollection' => 'sw',
    ];
    return array_key_exists($val , $arr) ? $arr[$val] : null;
}


function getOrderRanges($abbr)
{
    $range = Range::where('abbr',$abbr)->first();
    return $range->name;
}


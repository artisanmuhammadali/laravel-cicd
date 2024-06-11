<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Models\MTG\MtgCard;
use Illuminate\Http\Request;
use App\Models\MTG\MtgSet;
use App\Models\MTG\MtgCardFace;
use App\Models\MTG\MtgCardImage;
use App\Models\MTG\MtgCardLanguage;
use App\Models\MTG\MtgCardSeo;
use App\Models\MTG\MtgSetLanguage;
use App\Models\Mtg\MtgSetSeo;
use App\Models\MTG\MtgUserCollection;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderReview;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserStore;
use App\Models\UserWallet;
use App\Services\Admin\MTG\importCards;
use App\Traits\MTG\MtgSetsSeo;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Foreach_;
use Illuminate\Support\Str;


class SettingController extends Controller
{
    use MtgSetsSeo;

    public function masterToSingle()
    {
        $slots = [
            [381 , 441],
            [481 , 490]
        ];
        foreach($slots as $key =>$slot)
        {
            MtgCard::where('set_code','mh2')
                    ->whereBetween('int_collector_number',$slot)
                    ->when($key == 0,function($q){
                        $q->where('slug','like','%'.'retro-frame-etched'.'%');
                    })
                    ->when($key == 1,function($q){
                        $q->where('slug','like','%'.'etched'.'%');
                    })
                    ->update(['nonfoil'=>0 , 'finishes'=>'["foil","etched"]']);
        }
        return "done..";
    }

    public function generateSeoOtionsForSets()
    {
        set_time_limit(0);
        
        $childs = MtgSet::where('type','child')->get();
        // dd($childs);

        $expansions = MtgSet::where('type','!=','child')->get();
        // dd($childs , $expansions);
        $this->ExpAndSpecial($expansions);
        $this->otherSetTypes($childs);

        return "done";
        
        
    }
    public function ExpAndSpecial($list)
    {
        foreach($list as $exp)
        {
            $string = $exp->name .' | MTG Expansion Set | VFS Card Market';
            $title = $this->stringToShort($string,70);
            $meta = "Buy & sell all available MTG ".$exp->name." singles & products on the Very Friendly Sharks card market. Easy to use, best prices online, try it today!";
            $meta = $this->setMetaDescription('exp',$meta,156,$exp->name , "singles & products");
            $exp->title = $title;
            $exp->heading = $exp->name;
            $exp->sub_heading = "Select Your Category To Buy & Sell Your MTG Products";
            $exp->meta_description = $meta;
            $exp->save();

            $types = [
                'Magic Singles'=>'singles',
                'Mtg Sealed Products'=>'Sealed Products',
                'Mtg Complete Sets'=>'Complete Sets',
            ];
            
            foreach($types as $key=>$type)
            {
                $string = $exp->name .' | '.$key.' | VFS Card Market';
                $title = $this->stringToShort($string,70);
                $meta = "Buy & sell ".$exp->name." MTG " .$type." on our UK-Only card
                market, today! Very Friendly Sharks is easy to use, with best the prices
                online.";
                $meta = $this->setTypesMetaDesc($meta,156,$exp->name , strtolower($type));
                $heading = $type == "singles" ? "Single Cards" : $type;
                $sub_heading = $this->setTypesSubHead($exp , $type);

                $seo_type = [
                    'singles'=>'single',
                    'Sealed Products'=>'sealed',
                    'Complete Sets'=>'completed',
                ];
                $seo_type =  array_key_exists($type , $seo_type) ? $seo_type[$type] : 'single';

                $expSeo = new MtgSetSeo();
                $expSeo->title = $title;
                $expSeo->heading = $exp->name . " " . $heading;
                $expSeo->sub_heading = $sub_heading;
                $expSeo->meta_description = $meta;
                $expSeo->type = $seo_type;
                $expSeo->mtg_set_id = $exp->id;
                $expSeo->save();
            }
            // $this->productsSeo($exp);

        }
        return true;
    }
    public function productsSeo($set)
    {
        $cards = MtgCard::where('set_code',$set->code)->where('card_type','single')->get();    

        foreach($cards as $card)
        {
            $string = $card->name ." | ". $set->name." | " . "VFS Card Market";
            $title = $this->stringToShort($string,70);


            $meta = "Buy & sell " . $set->name. " MTG single cards on our UK-Only card market, today! Very Friendly Sharks is easy to use, with the best prices online.";
            if (strlen($meta) > 156) {
                $meta = "Buy & sell " . $set->name. " MTG single cards on our UK-Only card market, today! Very Friendly Sharks is easy to use, trusted & safe.";
            }
            if (strlen($meta) > 156) {
                $meta = "Buy & sell " . $set->name. " MTG single cards on our UK-Only card market, today! Very Friendly Sharks is easy to use.";
            }
            if (strlen($meta) > 156) {
                $meta = "Buy & sell " . $set->name. " MTG single cards on our UK-Only card market, today!";
            }

            $detail = new MtgCardSeo();
            $detail->title = $title;
            $detail->meta_description = $meta;
            $detail->heading = $card->name;
            $detail->sub_heading = $card->name;
            $detail->mtg_card_id = $card->id;
            $detail->save();

        }

    }
    public function otherSetTypes($list)
    {
        foreach($list as $child)
        {
            // dd($child);
            $name = $child->custom_type == "Oversized"  ? str_replace('Oversized','',$child->name) : $child->name;
            $name = $child->custom_type == "Promos"  ? str_replace('Promos','',$child->name) : $child->name;

            $title_type = $this->subCatTitle($child);
            $string = $name .' | '.$title_type.' | VFS Card Market';
            $title = $this->stringToShort($string,70);
            $meta_type = $this->subCatMeta($child->custom_type);
            $meta = "Buy & sell ".$child->name." ".$meta_type." on Very Friendly Sharks card market. Easy to use, best prices online, try it today!";
            $meta = $this->setMetaDescription('exp',$meta,156,$child->name , $meta_type);
            $sub_heading = $child->custom_type == "singles" ? $child->name : $child->custom_type;

            $child->title = $title;
            $child->heading = $child->name;            
            $child->sub_heading = "Browse MTG ".$sub_heading." To Buy and Sell Your Magic the Gathering Products";
            $child->meta_description = $meta;
            $child->save();
            // dd($child);
        }
        return true;
    }
    public function subCatTitle($set)
    {
        $type = $set->custom_type;
        $title_name = [
            'Tokens & Emblems'=>'MTG Tokens',
            'Art Cards'=>'MTG Art Cards',
            'Masterpieces'=>'MTG Masterpieces',
            'Oversized'=>'MTG Oversized Cards',
            'Promos'=>'MTG Promos',
            'Funny'=>'MTG Funny',
            'Minigames'=>'MTG Minigames',
            'singles'=>$set->parent->name ?? $set->name,
        ];
        return array_key_exists($type , $title_name) ? $title_name[$type] : null;
    }
    public function subCatMeta($type)
    {
        $title_name = [
            'Tokens & Emblems'=>'MTG tokens & emblems today',
            'Art Cards'=>'and other MTG products, today',
            'Oversized'=>'MTG oversized cards today',
            'Promos'=>'and other MTG products, today',
            'Masterpieces'=>'and other MTG products, today',
            'Funny'=>'and other MTG products, today',
            'Minigames'=>'and other MTG products, today',
            'singles'=>'and other MTG products, today',
        ];
        return array_key_exists($type , $title_name) ? $title_name[$type] : null;
    }
    public function stringToShort($input,$limit)
    {
        while (strlen($input) > $limit) {
            $words = explode(' ', $input);
            array_pop($words);
            $input = implode(' ', $words);
        }

        return rtrim($input, " \t\n\r\0\x0B!@#$%^&*()_+[]{}|;':,./<>?\\\"");
    }

    public function setMetaDescription($type,$meta,$limit,$name,$meta_type)
    {
        if(strlen($meta) > $limit)
        {
            $meta = "Buy & sell all available MTG " .$name. " ".$meta_type. " on the Very Friendly Sharks card market. Easy to use, trusted & safe, try it today!";
        }
        if(strlen($meta) > $limit)
        {
            $meta = "Buy & sell all available MTG ".$name." ".$meta_type. " on the Very Friendly Sharks card market. Easy to use, try it today!";
        }
        if(strlen($meta) > $limit)
        {
            $meta = "Buy & sell all available MTG ".$name. " ".$meta_type. " on the Very Friendly Sharks
            card market. Try it today!";
        }

        return $meta;
        
    }

    public function setTypesMetaDesc($meta,$limit,$name,$meta_type)
    {
        if(strlen($meta) > $limit)
        {
            $meta = "Buy & sell " .$name. " MTG ".$meta_type. " on our UK-Only card market, today! Very Friendly Sharks is easy to use, trusted & safe.";
        }
        if(strlen($meta) > $limit)
        {
            $meta = "Buy & sell ".$name." MTG ".$meta_type. " on our UK-Only card market, today! Very Friendly
            Sharks is easy to use.";
        }
        if(strlen($meta) > $limit)
        {
            $meta = "Buy & sell ".$name. " MTG ".$meta_type. " today on Very Friendly Sharks, the UK-only card market.";
        }

        return $meta;
        
    }
    public function setTypesSubHead($set , $type)
    {
        $sub_headingArr = [
            'singles'=>'Browse MTG Singles To Buy and Sell Your Cards',
            'Sealed Products'=>'Browse MTG '.$set->name.' Sealed Products To Buy and Sell Your Magic Boosters, Boxes, Decks & More.',
            'Complete Sets'=>'Browse Complete MTG Sets To Buy and Sell Your Cards',
        ];
        return array_key_exists($type , $sub_headingArr) ? $sub_headingArr[$type] : null;

    }

    public function generateColorOrders()
    {
        $faces = MtgCardFace::where('colors','!=','[]')->get();
        foreach($faces as $face)
        {
            $string = "";
            $array = json_decode($face->colors, true);
            if(count($array) > 1)
            {
                $order = 7;
            }
            else{
                $order = colorOrders()[$array[0]];
            }
            $face->color_order = $order;
            $face->save();
        }

        dd(123);
    }
    public function addOracleTextOfCards()
    {
        $sealedOracleText = 'A sealed product comes with its original packaging intact, factory sealed and not maliciously tampered with in any way. It cannot be opened nor resealed. You cannot sell a product on our website as sealed unless these specific requirements apply to it.
        Sealed products can have varying degrees of quality and condition in packaging, so long as the above rules apply.';

        $completeOracleText = 'Each set must contain one of each of the card types present in a specific expansion.
        A full set means one of each of the cards in the entire expansion.
        A commons set means one of each of the common cards that appear in a specific
        expansion.
        An uncommons set means one of each of the uncommons that appear in a specific
        expansion.
        A rares set means one of each of the rares that appear in a specific expansion.
        A mythics set means one of each of the rares that appear in a specific expansion.
        A basic land set means one of each of the basic lands that appear in a specific expansion.
        A token set means one of each of the tokens that appear in a specific expansion.
        An art card set means one of each of the art cards that appear in a specific expansion.
        To be able to sell on our website you must have one or all of the above rules when
        listing a "set" for sale.
        If your set contains cards with different versions, you must state this in the product
        notes or notify buyers when they purchase as to avoid yourself issues down the line.';

        $sealedId = DB::table('mtg_cards')->where('card_type','sealed')->pluck('id')->toArray();
        $completeId = DB::table('mtg_cards')->where('card_type','completed')->pluck('id')->toArray();

        DB::table('mtg_card_faces')->whereIn('mtg_card_id',$sealedId)->update(['oracle_text' => $sealedOracleText]);
        DB::table('mtg_card_faces')->whereIn('mtg_card_id',$completeId)->update(['oracle_text' => $completeOracleText]);

        return "done...";
    }

    public function completeRarity()
    {
        $cards = MtgCard::where('card_type','completed')->get(['id','name']);
        $arrayToCheck = ['Rare', 'Commons', 'Uncommons' ,'Mythics'];
        $rarityArr = [
            'Rare'=>'rare',
            'Commons'=>'common',
            'Uncommons'=>'uncommon',
            'Mythics'=>'mythic',
        ];
        foreach ($cards as $card) 
        {
            foreach($arrayToCheck as $value)
            {
                if(Str::contains($card->name, $value))
                {
                    $rarity = $rarityArr[$value];
                    $card->update(['rarity'=>$rarity]);
                }
            }
        }     

        return 'done..';
    }
    public function addSetsLangToSealedAndComplete() 
    {
        MtgCardLanguage::where('key','es')->update(['value'=>'Spanish']);
        $sets = MtgSet::where('languages', '!=', null)->get(['code','languages','id']);

        foreach($sets as $set)
        {

            $languages = json_decode($set->languages, true);

            foreach($languages as $lang)
            {
                
                $this->AddLanguage($lang, $set->code);
            }

        }
        dd('Languages Extract successfully!');
    }

    public function AddLanguage($lang, $code)
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

        $languages = MtgCard::where('set_code',$code)
                    ->where('card_type','!=','single')
                    ->pluck('id')->toArray();
        $newArray = [];

        foreach ($languages as $id) {
            $newArray[] = ['mtg_card_id' => $id, 'key' => $lang ,'value'=>$fullname];
        }
        return  MtgCardLanguage::insert($newArray);
        

    }
    public function updateUsers(importCards $service) 
    {
        set_time_limit(0);
        Notification::where('is_readed',0)->update(['is_readed'=>1]);
        return "done..";
    }
}
<?php

namespace App\Traits\MTG;

use App\Models\MTG\MtgSetSeo;

trait MtgSetsSeo
{
    public function generateSeoOtionsForSet($set)
    {
        if($set->type == "child")
        {
            $this->otherSetTypes($set);
        }
        else
        {
            $this->ExpAndSpecial($set);
        }
        return "done";
        
        
    }
    public function ExpAndSpecial($exp)
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
        return true;
    }
    public function otherSetTypes($child)
    {
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
}

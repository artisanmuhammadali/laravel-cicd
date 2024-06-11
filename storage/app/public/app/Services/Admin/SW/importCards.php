<?php

namespace App\Services\Admin\SW;
use App\Models\SW\SwSet;
use App\Models\SW\SwCard;
use Illuminate\Support\Str;
use App\Models\SW\SwCardLanguage;
use App\Models\SW\SwCardImage;
use App\Models\SW\SwCardSeo;
use App\Models\SW\SwSetSeo;
use GuzzleHttp\Client;

class importCards {
    public $new_cards = 0;
    public function importCards()
    {
        set_time_limit(0);
        $client = new Client();
        $count = 0;
        $page =1;
        $loop = true;
        while ($loop) {
            $response = $client->get('https://admin.starwarsunlimited.com/api/cards?locale=en&orderBy[expansion][id]=asc&sort[0][…]$null]=true&pagination[page]='.$page.'&pagination[pageSize]=250');
            $response = json_decode($response->getBody()->getContents(), true);
            try {
                foreach($response['data'] as $items)
                {
                    $count++;
                    $card = $items['attributes'];
                    list($setId,$setCode) = $this->checkSet($card);
                    $created_card = $this->createCard($items['id'],$card,$setId,null,$setCode);
                    $this->setCardAttributes($card,$created_card->id);
                    
                    $variants = $card['variants']['data'];
                    $this->createVariants($variants,$created_card->id,$setId,$setCode);
                }
              } catch (\Exception $e) {
              
                dd($e->getMessage());
                //   return [$e->getMessage(),$card];
              }

            if(count($response['data']) < 250)
            {
                $loop = false;
            }
            $page++;
        }
        return $this->new_cards;
    }

    public function setCardAttributes($card,$created_card_id)
    {
        $this->createLanguages($card,$created_card_id);
        $this->createImages($card['artFront']['data'],$created_card_id,'front');
        $this->createImages($card['artBack']['data'],$created_card_id,'back');
    }

    public function createVariants($variants, $parentId,$setId,$setCode)
    {
      if(!$variants)
      {
        return false;
      }
      foreach($variants as $item)
      {
        $created_card = $this->createCard($item['id'],$item['attributes'],$setId,$parentId,$setCode);
        $this->setCardAttributes($item['attributes'],$created_card->id);
      }
      return 1;
    }
    public function isCardExist($card)
    {
        return SwCard::where('card_uid',$card['cardUid'])->first();
    }
    public function createCard($cardId,$card,$setId,$parentId = null,$setCode = null)
    {
        $check_card = $this->isCardExist($card);
        if($check_card)
        {
            $cardSeo = $this->checkCardSeoExist($check_card);
            if(!$cardSeo)
            {
                $this->setSeoCard($check_card);
            }
            if($parentId)
            {
                $check_card->parent_id = $parentId;
                $check_card->save();
            }
          return $check_card;
        }
        $this->new_cards++;
        $new_created = SwCard::create([
            'sw_set_id' => $setId == 'not' ? null : $setId,
            'set_code' => $setCode == 'not' ? null : $setCode,
            'name' => $card['title'],
            'slug'  => Str::slug($card['title']."-".$card['cardUid']),
            'sw_card_id' => $cardId,
            'card_number' => $card['cardNumber'],
            'card_uid' => $card['cardUid'],
            'parent_id' => $parentId,
            'artist' => $card['artist'],
            'sub_title' => $card['subtitle'],
            'foil' => $card['hasFoil'] ? 1 : 0,
            'cost' => $card['cost'],
            'hp' => $card['hp'],
            'power' => $card['power'],
            'styled_text' => $card['textStyled'],
            'text' => $card['text'],
            'styled_epic_action' => $card['epicActionStyled'],
            'epic_action' => $card['epicAction'],
            'styled_deploy_box' => $card['deployBoxStyled'],
            'deploy_box' => $card['deployBox'],
            'unique' => $card['unique'] ? 1 : 0,
            'hyperspace' => $card['hyperspace'] ? 1 : 0,
            'showcase' => $card['showcase'] ? 1 : 0,
            'traits' => $this->getArrayOfAttributes($card['traits']['data']),
            'arenas' => $this->getArrayOfAttributes($card['arenas']['data']),
            'keywords' => $this->getArrayOfAttributes($card['keywords']['data']),
            'aspects' => $this->getArrayOfAttributes($card['aspects']['data']),
            'type' => $card['type']['data'] ? $card['type']['data']['attributes']['name'] : null,
            'type2' => $card['type2']['data'] ? $card['type2']['data']['attributes']['name'] : null,
            'rarity' => $card['rarity']['data'] ? $card['rarity']['data']['attributes']['name'] : null,
            'sw_created_at' => $card['createdAt'],
            'sw_updated_at' => $card['updatedAt'],
            'sw_published_at' => $card['publishedAt'],
            'published_at' => $card['publishedAt'],
        ]);
        $this->setSeoCard($new_created);
        return $new_created;
    }

    public function getArrayOfAttributes($attributes)
    {
        
        $array = [];
        if($attributes)
        {
            foreach($attributes as $attr)
            {
               $array[] = $attr['attributes']['name'];
            }
        }
 
        return json_encode($array);
    }

    public function getLocaleArray($card)
    {
      $array = [];
      $array[] = $card['locale'];
      $locale = $card['localizations']['data'];
      foreach($locale as $loc)
      {
        $array[] = $loc['attributes']['locale'];
      }
      return $array;
    }

    public function createImages($image,$cardId,$type)
    {
        if(!$image)
        {
            return false;
        }

        return SwCardImage::create([
         'sw_card_id' => $cardId,
         'url' => $image['attributes']['url'],
         'type' => $type,
        ]);
    }

    public function createLanguages($card,$cardId)
    {
        foreach($this->getLocaleArray($card) as $loc)
        {
            SwCardLanguage::create([
                'sw_card_id' => $cardId,
                'key' => $loc,
            ]);
        }
    }

    public function checkSet($card)
    {
        
        $set = $card['expansion']['data'] ? $card['expansion']['data']['attributes'] : 'not';
        if($set == 'not')
        {
            return ['not','not'];
        }

        $s = SwSet::where('code',$set['code'])->first();

        if(!$s)
        {
            $s = SwSet::create([
                'code' => $set['code'],
                'name' => $set['name'],
                'slug'  => Str::slug($set['name']),
                'sw_created_at' => $set['createdAt'],
                'sw_updated_at' => $set['updatedAt'],
                'sw_published_at' => $set['publishedAt'],
                'published_at' => $set['publishedAt'],
                'title'=> $set['name'].' | SWU Expansion Set | VFS Card Market',
                'heading'=> $set['name'],
                'sub_heading'=> 'Select Your Category To Buy & Sell Your SWU Products',
                'meta_description'=> 'Buy and sell all available SWU '. $set['name'] . ' singles and products on the Very Friendly Sharks card market. Easy to use, trusted and safe, try it today!',
            ]);
            SwSetSeo::create([
                'sw_set_id' => $s->id,
                'title'=> $set['name'].' | SWU Expansion Set | VFS Card Market',
                'heading'=> $set['name'].' Single Cards',
                'sub_heading'=> 'Browse SWU Singles To Buy and Sell Your Cards',
                'meta_description'=> 'Buy and sell '. $s->name .' SWU singles on our UK-Only card market, today! Very Friendly Sharks is easy to use, trusted and safe.',
                'type' => 'single',
                'created_at'=>now(),
                'updated_at'=>now(),
            ]);

        }
      

        return [$s->id,$s->code];
    }

    public  function setSeoCard($item)
    {
        
        $set_name = $item->set ? $item->set->name  : "";
            SwCardSeo::create([
                'sw_card_id'=>$item->id,
                'title'=> $item->name .' | '. $set_name .' | VFS Card Market',
                'meta_description'=> 'Buy & sell ' . $set_name . ' SWU single cards on our UK-Only card market, today! Very Friendly Sharks is easy to use, with the best prices online.',
                'heading'=>$item->name,
                'sub_heading'=>$item->name,
                'created_at'=>now(),
                'updated_at'=>now(),
            ]);
    }

    public function checkCardSeoExist($card)
    {
        return SwCardSeo::where('sw_card_id',$card->id)->first();
    }
    
}

<?php

namespace App\Http\Controllers\Front\SW;
use GuzzleHttp\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SW\SwSet;
use App\Models\SW\SwCard;
use Illuminate\Support\Str;
use App\Models\SW\SwCardLanguage;
use App\Models\SW\SwCardImage;

class IndexController extends Controller
{
    public function index()
    {
        $page = 'starWar';
        return view('front.sw.index',get_defined_vars());
    }

    public function detailedSearch()
    {
        return view('front.sw.detailedSearch');
    }

    public function test()
    {
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
                    $setId = $this->checkSet($card);
                    $created_card = $this->createCard($items['id'],$card,$setId);
                    $this->setCardAttributes($card,$created_card->id);
                    
                    $variants = $card['variants']['data'];
                    $this->createVariants($variants,$created_card->id,$setId);
                }
              } catch (\Exception $e) {
              
                  return [$e->getMessage(),$card];
              }

            if(count($response['data']) < 250)
            {
                $loop = false;
            }
            $page++;
          }
     
      

        dd($count);
    }

    public function setCardAttributes($card,$created_card_id)
    {
        $this->createLanguages($card,$created_card_id);
        $this->createImages($card['artFront']['data'],$created_card_id,'front');
        $this->createImages($card['artBack']['data'],$created_card_id,'back');
    }

    public function createVariants($variants, $parentId,$setId)
    {
      if(!$variants)
      {
        return false;
      }
      foreach($variants as $item)
      {
        $created_card = $this->createCard($item['id'],$item['attributes'],$setId,$parentId);
        $this->setCardAttributes($item['attributes'],$created_card->id);
      }
      return 1;
    }
    public function isCardExist($card)
    {
        return SwCard::where('card_uid',$card['cardUid'])->first();
    }
    public function createCard($cardId,$card,$setId,$parentId = null)
    {
        $check_card = $this->isCardExist($card);
        if($check_card)
        {
            if($parentId)
            {
                $check_card->parent_id = $parentId;
                $check_card->save();
            }
          return $check_card;
        }
        return SwCard::create([
            'sw_set_id' => $setId == 'not' ? null : $setId,
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
            return 'not';
        }

        $s = SwSet::where('code',$set['code'])->first();

        if(!$s)
        {
            $s = SwSet::create(
                ['code' => $set['code'],
                'name' => $set['name'],
                'slug'  => Str::slug($set['name']),
                'sw_created_at' => $set['createdAt'],
                'sw_updated_at' => $set['updatedAt'],
                'sw_published_at' => $set['publishedAt'],
                'published_at' => $set['publishedAt'],
            ]);
        }
      

        return $s->id;
    }
   
}

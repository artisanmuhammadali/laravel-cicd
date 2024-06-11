<?php

namespace App\Services\Admin\MTG;

use App\Models\MTG\MtgSet;
use App\Traits\MTG\MtgSetsSeo;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\DiscordAlerts\Facades\DiscordAlert;


class importSets {
    use MtgSetsSeo;

    public function sets()
    {
        $client = new Client();
        $response = $client->get('https://api.scryfall.com/sets');
        $response = json_decode($response->getBody()->getContents(), true);

        foreach ($response['data'] as $key => $item)
        {
            if($this->cardExist($item)) continue;
            if(!$this->checkReleasedAndDigital($item['digital'])) continue;
            if($this->checkSetType($item['set_type']) == false)
            {
                $this->createSet($item, 'special');
                continue;
            }
            $this->createSet($item, 'expansion');
        }
    }

    public function cardExist($set)
    {
        return MtgSet::where('uuid',$set['id'])->first();
    }

    public function checkReleasedAndDigital($digital)
    {
        return $digital == false ? true : false;
    }
    public function checkSetType($type)
    {
        if($type == 'expansion' || $type == 'core')
        {
            return true;
        }
        return false;
    }

    public function createSet($item, $type,$isUpdate=null)
    {
        if($item['card_count'] >= 1)
        {
            $set = MtgSet::updateOrCreate(
                    ['uuid' => $item['id'],'code' => $item['code']],
                    ['name' => $item['name'],
                    'slug' => Str::Slug($item['name']),
                    'set_type' => $item['set_type'],
                    'card_count' => $item['card_count'],
                    'parent_set_code' => $item['parent_set_code'] ?? null,
                    'icon' => $item['icon_svg_uri'],
                    'type' => $type,
                    'released_at' => !$isUpdate ? $item['released_at'] : DB::raw('released_at'),
                    'released_date' => $item['released_at'],
                    'is_active' => !$isUpdate ? false : DB::raw('is_active'),
                    'foil'=>$item['foil_only'],
                    'nonfoil'=>$item['nonfoil_only'],
            ]);
        }

        if(!$isUpdate)
        {
            $this->generateSeoOtionsForSet($set);
            try {
                $msg = "New Expansion Added ".$item['name'];
                DiscordAlert::message($msg);
            } catch (\Throwable $th) {
            }
        }
    }

    public function updateSet($code)
    {
        $client = new Client();
        $response = $client->get('https://api.scryfall.com/sets/'.$code);
        $response = json_decode($response->getBody()->getContents(), true);

        $item = $this->cardExist($response);
        if($item)
        {
            $type = $this->checkSetType($response['set_type']) == false ? 'special' : 'expansion';
            $this->createSet($response, $type,'update');
        }
        return 1;
    }

}

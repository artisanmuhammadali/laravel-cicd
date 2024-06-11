<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Models\MTG\MtgSymbol;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class MtgSymbolController extends Controller
{
    public function importSymbols()
    {
        $client = new Client();
        $response = $client->get('https://api.scryfall.com/symbology');
        $response = json_decode($response->getBody()->getContents(), true);    
        $data = $response['data'];
        foreach($data as $item)
        {
            $item = ['key'=>$item['symbol'] , 'value'=>$item['svg_uri']];
            MtgSymbol::create($item);
        }
        return true;
    }
}

<?php

namespace App\Http\Controllers\Api\MTG;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MTG\MtgCard;

class SettingController extends Controller
{
    public function averagePrice($id)
    {
        $sign = config('helpers.general.currency');
        $card = MtgCard::findOrFail($id);
        $average = $card->collections->avg('price');
        $average = $average ? $sign . $average : $sign. '0';
        $url = $card->set ? route('mtg.expansion.detail',[$card->url_slug, $card->url_type ,$card->slug]) : '';
        
        return response()->json(['id' => $card->id,'card_name' => $card->name, 'set_name' => $card->set->name ?? 'none','average_price' => $average,'url' => $url]);
    }
}

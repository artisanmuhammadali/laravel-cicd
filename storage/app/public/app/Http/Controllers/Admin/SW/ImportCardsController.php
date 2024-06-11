<?php

namespace App\Http\Controllers\Admin\SW;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SW\SwSet;
use App\Models\SW\SwCard;
use Illuminate\Support\Str;
use App\Models\SW\SwCardLanguage;
use App\Models\SW\SwCardImage;
use GuzzleHttp\Client;
use App\Services\Admin\SW\importCards;

class ImportCardsController extends Controller
{
    private $importService;
    public function __construct(ImportCards $importService)
    {
        $this->importService = $importService;
    }

    public function importCards()
    {
        $new_cards = $this->importService->importCards();
        $msg = $new_cards.' new cards are imported.';
        return redirect()->back()->with('message',$msg);  
    }
}

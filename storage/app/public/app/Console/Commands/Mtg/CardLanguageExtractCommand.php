<?php

namespace App\Console\Commands\Mtg;

use App\Models\MTG\MtgCard;
use App\Models\MTG\MtgCardLanguage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CardLanguageExtractCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mtg:language-extract';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Extract languages from scryfall';

    /**
     * Execute the console command.
     */
    public function handle()
    {


        // $cards = DB::table('mtg_cards')->where('card_type','single')
        //                 ->where('languages',null)
        //                 ->get(['id','name','collector_number']);
        // foreach($cards as $card){
        //     importCardLanguages($card);
        //     Log::info($card->id);

        // }


        $cards = MtgCard::whereDoesntHave('languages')->where('languages', '!=', null)->where('card_type','single')->get(['id','languages']);

        foreach($cards as $card)
        {
            if($card->languages == "[]") continue;

            $languages = json_decode($card->languages, true);

            foreach($languages as $lang)
            {
                $this->AddLanguage($lang, $card->id);
            }


            dd('error');

        }
        dd('Languages Extract successfully!');
    }

    public function AddLanguage($lang, $id)
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

        MtgCardLanguage::create([
            'mtg_card_id' => $id,
            'key'  => $lang,
            'value' => $fullname
        ]);

    }


}

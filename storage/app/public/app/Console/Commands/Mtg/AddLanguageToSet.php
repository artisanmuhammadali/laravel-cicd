<?php

namespace App\Console\Commands\Mtg;

use App\Models\MTG\MtgCard;
use App\Models\MTG\MtgSet;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AddLanguageToSet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mtg:set-languages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set languages from its cards';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sets = MtgSet::where('languages', null)->get(['id','code']);
        foreach($sets as $set)
        {
            $my_array = [];
            $languages = MtgCard::where('set_code', $set->code)->where('languages', '!=', null)->pluck('languages')->toArray();
            if(count($languages) > 0){
                foreach($languages as $lang)
                {
                    $lang = json_decode($lang , true); 
                    $my_array[] = $lang;
                }
                $arr = array_merge(...$my_array);
                $arr =array_unique($arr);
                $arr = array_values($arr);
                $set->languages = json_encode($arr);
                $set->save();
            }
            
        }
        dd('languages updated');
    }
}

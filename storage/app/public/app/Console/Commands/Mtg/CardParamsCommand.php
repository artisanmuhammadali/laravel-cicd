<?php
namespace App\Console\Commands\Mtg;
use App\Models\MTG\MtgCard;
use App\Models\MTG\MtgSet;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CardParamsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mtg:set-params';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set the parameters of legalities and languages';
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $update = DB::table('mtg_sets')->update(['legalities'=>null]);

        $sets = MtgSet::where('legalities', null)->get(['id','code']);
        foreach($sets as $set)
        {
            $my_array = [];
            $legalities = MtgCard::where('set_code', $set->code)->where('legalities', '!=', null)->pluck('legalities')->toArray();

            foreach($legalities as $legal)
            {
               $legal = json_decode($legal , true); 
               $my_array[] = $legal;
            }
            
            $mergedArray = [];

            foreach ($my_array as $subArray) {
                foreach ($subArray as $key => $value) {
                    $mergedArray[] =  $key.':'.$value;
                }
            }
            $arr = array_unique($mergedArray);
            $arr = array_values($arr);

            $set->legalities = json_encode($arr);
            $set->save();
        }
        dd('legalities updated');

        
    }
}







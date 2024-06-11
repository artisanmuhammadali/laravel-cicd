<?php

namespace App\Console\Commands\Mtg;

use App\Models\MTG\MtgCard;
use Illuminate\Console\Command;

class SealedWeightCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mtg:sealed-weight';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Sealed products weight';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tmpName = public_path("sealed-products-weight-1.csv");
        if(($handle = fopen($tmpName, 'r')) !== FALSE) {
            $row = 0;
            while(($data = fgetcsv($handle, 2000, ',')) !== FALSE) {
                if($row == 0){ $row++; continue; }
                try{
                    if($data[3] != "")
                    {
                        $card = MtgCard::where('name',$data[1])->first();
                        if($card)
                        {
                            $card->weight = $data[3] ?? null;
                            $card->save();
                        }
                    }
                    
                }
                catch(\Exception $e){
                    // dd($e,$row);
                }
                $row++;
            }
        }
        return "weight added successfully";
    }
}

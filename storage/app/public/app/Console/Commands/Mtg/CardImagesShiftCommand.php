<?php

namespace App\Console\Commands\Mtg;

use App\Models\MTG\MtgCard;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use App\Models\MTG\MtgCardImage;
use Illuminate\Support\Facades\Log;

class CardImagesShiftCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mtg:shift-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Shift images to ImageKit';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        set_time_limit(0);

        $data = MtgCardImage::where('is_shifted', false)
                ->where('value','!=',null)
                ->take(50000)
                ->get(['id','mtg_card_id','key','value','is_shifted']);


        foreach ($data as $key => $item)
        {
            $card = MtgCard::with('set:code,slug')
                             ->whereId($item->mtg_card_id)
                             ->first(['id','name','set_code', 'collector_number']);

            if(!$card)
            {
                $item->update(['is_shifted' => true]);
                continue;
            }

            if(!isset($card->set->slug))
            {
                continue;
            }


            try {

                #upload image
                $response = uploadToCdnViaUrl($item->value, $this->getSlug($card));
                if($response['status'] == true)
                {
                    $item->update([
                        'value' => 'https://img.veryfriendlysharks.co.uk/'.$response['message'],
                        'is_shifted' => true
                    ]);
                    Log::info($response);
                    continue;
                }
                else{
                    continue;
                }

            }
            catch (\Throwable $th)
            {
                continue;
            }


        }

        dd('Images has been shifted successfully!');
    }


    public function getSlug($card)
    {
        return $image_name = $card->set->slug.'-'
                            .Str::Slug($card->name).'-'
                            .$card->collector_number;
    }

}

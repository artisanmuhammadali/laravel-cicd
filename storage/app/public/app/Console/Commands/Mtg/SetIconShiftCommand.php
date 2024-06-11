<?php

namespace App\Console\Commands\Mtg;

use App\Models\MTG\MtgSet;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class SetIconShiftCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mtg:set-icon-shift';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Shift set icons to ImageKit';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        set_time_limit(0);

        $data = MtgSet::where('is_shifted', false)->get(['id','name','icon','is_shifted']);

        foreach ($data as $item)
        {

            try {

                #upload image
                $response = uploadToCdnViaUrl($item->icon, Str::Slug($item->name));

                if($response['status'] == true)
                {
                    $item->update([
                        'icon' => 'https://img.veryfriendlysharks.co.uk/'.$response['message'],
                        'is_shifted' => true
                    ]);
                    Log::info($response);
                    continue;
                }

            }
            catch (\Throwable $th)
            {
                continue;
            }


        }

        dd('Icons has been shifted successfully!');
    }
}

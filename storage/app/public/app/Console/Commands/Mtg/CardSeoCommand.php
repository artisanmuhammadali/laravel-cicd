<?php

namespace App\Console\Commands\Mtg;

use App\Models\MTG\MtgCard;
use Illuminate\Console\Command;

class CardSeoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mtg:card-seo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Cards Seo';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cards = MtgCard::WhereDoesntHave('seo')->pluck('id')->toArray();
        foreach($cards as $id)
        {
            $card = MtgCard::find($id);
            createCardSeo($card);       
        }
        return "Cards Seo Created...";
}
}

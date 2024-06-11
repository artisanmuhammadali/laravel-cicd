<?php

namespace App\Console\Commands\Mtg;

use App\Models\MTG\MtgCard;
use App\Models\MTG\MtgSet;
use Illuminate\Console\Command;

class RemoveSpeCharFromSetCardName extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mtg:remove-spe-char-from-names';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Remove : ' from mtg sets and cards name";

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sets = MtgSet::select('name','id')->get();
        $cards = MtgCard::select('name','id')->get();
        foreach($sets as $set)
        {
            $name = $this->removeChars($set->name);
            $set->name = $name;
            $set->save();
        }
        foreach($cards as $card)
        {
            $name = $this->removeChars($card->name);
            $card->name = $name;
            $card->save();
        }
        return "done";
    }
    public function removeChars($name)
    {
        $name = str_replace("'","",$name);
        $name = str_replace(":","",$name);
        return $name;
    }
}

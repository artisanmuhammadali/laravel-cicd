<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserStore;
use App\Models\User;
use Carbon\Carbon;

class ValidateSellersAndBuyersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:validate-sellers-and-buyers-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $startDate =  Carbon::now();
        $last =  $startDate->subMonths(6);
        $s = $this->getSellers($startDate, $last);
        $b = $this->getBuyers($startDate, $last);
        $this->validateSellersAndBuyers($s,$b);
    }

    public function validateSellersAndBuyers($s,$b)
    {
        $combinedArray = array_merge($s, $b);
        UserStore::whereIn('user_id',$combinedArray)->update(['status' => 'active']);
        UserStore::whereNotIn('user_id',$combinedArray)->update(['status' => 'inactive']);
    }

    public function getSellers($startDate, $last)
    {
        return User::where('type','seller')->whereHas('collections',function($q)use($last,$startDate){
            $q->where('publish',1)->whereDate('created_at','<=',$startDate)->whereDate('created_at','>=',$last);
        })->orWhereHas('sellingOrders',function($q)use($last,$startDate){
            $q->whereDate('created_at','<=',$startDate)->whereDate('created_at','>=',$last);
        })->pluck('id')->toArray();
    }

    public function getBuyers($startDate, $last)
    {
        return User::where('type','buyer')->whereHas('buyingOrders',function($q)use($last,$startDate){
            $q->whereDate('created_at','<=',$startDate)->whereDate('created_at','>=',$last);
        })->pluck('id')->toArray();
    }
}

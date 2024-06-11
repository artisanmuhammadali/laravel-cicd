<?php

namespace App\Observers;

use App\Models\MTG\MtgUserCollection;
use Illuminate\Support\Facades\Log;
use App\Models\Cart;

class MtgUserCollectionObserver
{
    /**
     * Handle the MtgUserCollection "created" event.
     */
    public function created(MtgUserCollection $mtgUserCollection): void
    {
        //
    }

    /**
     * Handle the MtgUserCollection "updated" event.
     */
    public function updated(MtgUserCollection $mtgUserCollection): void
    {
        //
    }

    /**
     * Handle the MtgUserCollection "deleted" event.
     */
    public function deleted(MtgUserCollection $mtgUserCollection): void
    {
        Cart::where('collection_id',$mtgUserCollection->id)->delete();
        // Log::info($mtgUserCollection);
    }

    /**
     * Handle the MtgUserCollection "restored" event.
     */
    public function restored(MtgUserCollection $mtgUserCollection): void
    {
        //
    }

    /**
     * Handle the MtgUserCollection "force deleted" event.
     */
    public function forceDeleted(MtgUserCollection $mtgUserCollection): void
    {
        //
    }
}

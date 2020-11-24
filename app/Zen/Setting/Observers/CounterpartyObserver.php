<?php

namespace App\Zen\Setting\Observers;

use App\Zen\Setting\Model\Counterparty;

class CounterpartyObserver
{
    /**
     * Handle the counterparty "created" event.
     * @param Counterparty $counterparty
     * @return void
     */
    public function created(Counterparty $counterparty)
    {
        $isExternal = 1;
        if($counterparty -> is_entity && $counterparty -> is_counterparty)
            $isExternal = 0;

        $counterparty -> is_external = $isExternal;
        $counterparty -> save();
    }

    /**
     * Handle the counterparty "updated" event.
     * @param Counterparty $counterparty
     * @return void
     */
    public function updated(Counterparty $counterparty)
    {
        //
    }

    /**
     * Handle the counterparty "deleted" event.
     * @param Counterparty $counterparty
     * @return void
     */
    public function deleted(Counterparty $counterparty)
    {
        //
    }

    /**
     * Handle the counterparty "restored" event.
     * @param Counterparty $counterparty
     * @return void
     */
    public function restored(Counterparty $counterparty)
    {
        //
    }

    /**
     * Handle the counterparty "force deleted" event.
     * @param Counterparty $counterparty
     * @return void
     */
    public function forceDeleted(Counterparty $counterparty)
    {
        //
    }
}

<?php


namespace App\Listeners\System;


class CustomUpdateTrialEndDate
{
    /**
     * Handle the event.
     *
     * @param mixed $event
     * @return void
     */
    public function handle($event)
    {
        $event -> team -> forceFill([
            'trial_ends_at' => $event -> team -> subscription() -> trial_ends_at,
        ]) -> save();

        $event -> team -> customer -> forceFill([
            'trial_ends_at' => $event -> team -> subscription() -> trial_ends_at,
        ]) -> save();
    }

}
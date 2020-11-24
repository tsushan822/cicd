<?php

namespace App\Nova\Actions;

use App\Jobs\NovaAdmin\TenantCurrencySet;
use App\Jobs\Settings\ImportFxRateForNewCustomer;
use App\Zen\System\Model\MainCurrency;
use App\Zen\System\Model\MainFx;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Laravel\Nova\Fields\Date;
use OptimistDigital\MultiselectField\Multiselect;

class ImportFxRateAndSetCurrency extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Disables action log events for this action.
     *
     * @var bool
     */
    public $onlyOnDetail = true;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        //set currency in tenant
        TenantCurrencySet ::dispatch($models[0]->website_id, array_values($fields->currency_items));

        //date field
        $start_date=$fields->start_date;
        $end_date=$fields->end_date;

        //import Fx rate for newly created customer

        ImportFxRateForNewCustomer ::dispatch ($models[0]->website_id, $start_date, $end_date);
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {

        $currency=MainCurrency::all()->pluck('iso_4217_code','id')->toArray();
        $start_date_object=MainFx::where('date','<', date('Y-m-d'))->orderBy('date')
            ->limit(1)
            ->get()->pluck('date')->toArray();
        $start_date=Carbon::parse('2019-05-21')->format('Y-m-d');

        return [

            Date::make('Start Date')->withMeta([
                'placeholder' => $start_date,
            ])->rules('date', 'date_format:Y-m-d','required'),


            Date::make('End Date')->withMeta([
                'value' => Carbon::yesterday()->format('Y-m-d'),
                'placeholder' => 'Select End Date',
            ])->rules('date', 'date_format:Y-m-d', 'before_or_equal:'.'. Carbon::yesterday()->format("Y-m-d") .', 'required'),

            Multiselect
                ::make('Choose Currency', 'currency_items')
                ->options($currency)
                ->saveAsJSON()
                // Optional:
                ->placeholder('Choose Multiple Currency')

        ];
    }
}

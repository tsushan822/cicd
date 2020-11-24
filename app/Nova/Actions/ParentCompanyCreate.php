<?php

namespace App\Nova\Actions;

use App\Jobs\NovaAdmin\TenantCurrencySet;
use App\Jobs\Settings\CreateCounterpartyForNewCustomer;
use App\Nova\Customer;
use App\Zen\Setting\Model\Counterparty;
use App\Zen\System\Model\Customer as tenatCustomer;
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
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use OptimistDigital\MultiselectField\Multiselect;

class ParentCompanyCreate extends Action
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

        CreateCounterpartyForNewCustomer ::dispatch($models[0]->website_id, $fields->short_name, $fields->long_name, $fields->currency_id);
        return Action::message('If Parent company did not exist then certainly you have created one Parent company');
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        $currency=MainCurrency::all()->pluck('iso_4217_code','id')->toArray();
        return [

            Text::make('Short Name')->withMeta([
                'placeholder' => 'Short Name',
            ])->rules('required'),


            Text::make('Long Name')->withMeta([
                'placeholder' => 'Long Name',
            ])->rules('required'),

            Select::make('Currency Id', 'currency_id')->options($currency)->displayUsingLabels()->rules('max:255')
            ];

    }
}

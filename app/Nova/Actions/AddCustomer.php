<?php

namespace App\Nova\Actions;

use App\Jobs\User\AddSuperAdminJob;
use App\Zen\System\Model\BackUp;
use App\Zen\System\Model\Customer;
use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Models\Website;
use Hyn\Tenancy\Repositories\HostnameRepository;
use Hyn\Tenancy\Repositories\WebsiteRepository;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Illuminate\Bus\Queueable;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddCustomer extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Indicates if this action is only available on the resource index view.
     *
     * @var bool
     */
    public $onlyOnIndex = true;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        //
        try {

            $name = $fields->domain_name;
            $customerName = $fields->name;
            $fxRateSource = $fields->fx_rate_source;
            $website = new Website;
            // Implement custom random hash using Laravels Str::random
            $website -> uuid = Str ::random(10);
            app(WebsiteRepository::class) -> create($website);


            $hostname = new Hostname;
            $hostname -> fqdn = $name;
            $hostname = app(HostnameRepository::class) -> create($hostname);
            app(HostnameRepository::class) -> attach($hostname, $website);

            $customer = new Customer;
            $customer -> website_id = $website -> id;
            $customer -> name = $customerName;
            $customer -> database = $website -> uuid;
            $customer -> fx_rate_source = $fxRateSource;
            $customer -> save();

            $backUp = new BackUp;
            $backUp -> customer_id = $customer -> id;
            $backUp -> save();


            $userDetails = config('user.super-admin');
            $userDetails['password'] = bcrypt($userDetails['password']);
            dispatch(new AddSuperAdminJob($website -> id, $userDetails));

            return Action::message('The Customer Has Been Added!');

        } catch (\Exception $e) {

            return Action::danger($e);
        }

    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [

            Text::make('Domain Name')
                ->withMeta(['extraAttributes' => [
                    'placeholder' => 'demo.zentreasury.app']
                ])
                ->sortable()
                ->rules('required','max:255'),

            Text::make('Name')
                ->sortable()
                ->rules('required','max:255'),

            Select::make('Fx Rate Source')->options([
                '0' => 'ecb-rate',
                '1' => 'riksbank'
            ])->displayUsingLabels()->rules('required','max:255')

        ];
    }
}

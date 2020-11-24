<?php

namespace App\Nova;

use App\Nova\Actions\AddCustomer;
use App\Nova\Actions\ImportFxRateAndSetCurrency;
use App\Nova\Actions\ParentCompanyCreate;
/*use Epartment\NovaDependencyContainer\HasDependencies;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;*/

use Hyn\Tenancy\Models\Website;
use Hyn\Tenancy\Traits\UsesSystemConnection;
use Khalin\Nova\Field\Link;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
/*use NovaConditionalFields\Condition;
use OptimistDigital\MultiselectField\Multiselect;*/

class Customer extends Resource
{
    use UsesSystemConnection;

   // use HasDependencies;

    /**
     * Disables action log events for this action.
     *
     * @var bool
     */
    public $withoutActionEvents = true;
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Zen\System\Model\Customer';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name', 'website_id', 'database', 'fx_rate_source', 'enable_euribor_download', 'active_status', 'user_domains', 'created_at', 'updated_at'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            new Panel('Important Details', $this->primaryFields()),
            new Panel('Others', $this->secondaryFields()),
        ];
    }

    public function getCustomerDomain(){
       return Website::find($this->id)->hostnames()->get()->pluck('fqdn')[0];
    }

    /**
     * Get the primary fields for the resource.
     *
     * @return array
     */
    protected function primaryFields()
    {
        return [

            Link::make('Name')
                ->url(function () {
                    return "https://{$this->getCustomerDomain()}";
                })->text($this->getCustomerDomain()),

            Text::make('Fqdn')
                ->withMeta(['extraAttributes' => [
                    'placeholder' => 'demo.zentreasury.app']
                ])
                ->hideFromDetail()
                ->hideFromIndex()
                ->hideWhenUpdating()
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('User Domains')
                ->withMeta(['extraAttributes' => [
                    'placeholder' => 'zentreasury.com, gmail.com']
                ])
                ->sortable()
                ->rules( 'max:255'),

            Select::make('Enable Euribor Download','enable_euribor_download') ->options([
                'data-bond' => 'data-bond',
                '1' => '1'
            ])->help(
                'You can leave the field empty'
            )->displayUsingLabels()->rules('max:255')
                ->sortable()->nullable(),

            Select::make('Fx Rate Source', 'fx_rate_source')->options([
                'ecb-rate' => 'ecb-rate',
                'riksbank' => 'riksbank',
                'data-bond' => 'data-bond'
            ])->help(
                'You can leave the field empty'
            )->displayUsingLabels()->rules('max:255')
                ->sortable()->nullable()
            ,

            HasOne::make('BackUp')

        ];
    }

    /**
     * Get the secondary fields for the resource.
     *
     * @return array
     */
    protected function secondaryFields()
    {
        return [

            Text::make('Database')
                ->readonly()
                ->hideWhenCreating()
                ->sortable(),

            Boolean::make('Active Status')
                ->sortable()
                ->rules('required', 'max:255'),
        ];
    }


    /**
     * Get the cards available for the request.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [
            new Metrics\TotalCustomers(),
            new Metrics\CustomerByPlan()
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            // new ActiveCustomer()
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
          /*  new ImportFxRateAndSetCurrency(),
            new ParentCompanyCreate()*/
        ];
    }

    public static function authorizedToCreate(Request $request)
    {
        return false;
    }

    public function authorizedToDelete(Request $request)
    {
        return false;
    }

    public function authorizedToUpdate(Request $request)
    {
        return false;
    }

    /**
     * Get the value that should be displayed to represent the resource.
     *
     * @return string
     */
    public function title()
    {
        return $this->name;
    }

}

<?php

namespace App\Nova;

use Illuminate\Support\Arr;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use \App\Zen\System\Model\Customer;
class EmailLog extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Zen\System\Model\EmailLog';

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
        'id',
    ];
    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [

            ID::make()->sortable(),

            Text::make('Customer Name', function(){

                if(!empty(Customer::where('website_id','=',$this->website_id)->pluck('name')->toArray()))
                {
                    return Customer::where('website_id','=',$this->website_id)->pluck('name')[0];
                }

                return "Null";
            }),

            Text::make('Receiver', function(){

                preg_match_all("/[._a-zA-Z0-9-]+@[._a-zA-Z0-9-]+/i", $this->header, $matches);

                $allEmails=Arr::flatten($matches);

                return end($allEmails);

            }),


            Textarea::make('Header'),

            Text::make('Subject'),

            Date::make('Sending At'),

            Text::make('Time', function(){

                return $this->sending_at->format('H:i');

            }),

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
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
}

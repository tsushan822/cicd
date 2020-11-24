<?php

namespace App\Nova;

use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;

class MainFx extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Zen\System\Model\MainFx';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';


    //Casts of the model dates
    protected $casts = [
        'date' => 'date',
        'created_at' => 'datetime',
    ];

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','ccy_base_id','ccy_cross_id','source','date','rate_bid'
    ];

    /**
     * The relationship columns that should be searched.
     *
     * @var array
     */
    public static $searchRelations = [
        'baseCurrency' => ['iso_4217_code'],
        'crossCurrency' => ['iso_4217_code'],
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

            Number::make('Ccy Base Id', function () {

                return $this->baseCurrency->iso_4217_code;

            }) ->sortable(),

            Number::make('Ccy Cross Id',function () {

                return $this->crossCurrency->iso_4217_code;

            }) ->sortable(),

            Text::make('Rate Type') ->sortable(),

            Text::make('Source') ->sortable(),

            Boolean::make('Direct Quote')->trueValue('1')
                ->falseValue('0')->sortable(),

            Date::make('Date') ->sortable(),

            Number::make('Rate Bid') ->sortable(),

            DateTime::make('Created At') ->sortable(),

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

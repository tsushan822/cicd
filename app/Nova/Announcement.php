<?php

namespace App\Nova;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;


class Announcement extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Laravel\Spark\Announcement';

    /**
     * The boolean value to decide action events presence
     *
     * @var boolean
     */
    public $withoutActionEvents = true;
    public $incrementing = true;
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
        'body'
    ];
    /**
     * The relationship columns that should be searched.
     *
     * @var array
     */
    public static $searchRelations = [

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

            Boolean::make('For Owner', 'for_owner')->trueValue('1')
                ->falseValue('0'),
            Text::make('Action Text', 'action_text')->rules('required'),
            Boolean::make('Action Url', 'action_url'),
            Textarea::make('Body', 'body')->rules('required')

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
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
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
        return [];
    }

    public static function authorizedToCreate(Request $request)
    {
        return true;
    }

    public function authorizedToDelete(Request $request)
    {
        return true;
    }

    public function authorizedToUpdate(Request $request)
    {
        return true;
    }
}

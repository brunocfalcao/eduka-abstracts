<?php

namespace Eduka\Abstracts;

use App\Nova\Resource;
use Laravel\Nova\Http\Requests\NovaRequest;

abstract class EdukaResource extends Resource
{
    public static $displayInNavigation = false;

    /**
     * The number of results to display in the global search.
     *
     * @var int
     */
    public static $globalSearchResults = 10;

    /**
     * Abstract index query that will sort any column from your Resource.
     * If the column is not specified, then it uses the default behavior.
     * Uses a static property $indexDefaultOrder, with multiple keys.
     *
     * Example:
     * public static $indexDefaultOrder = ['total' => 'desc'];
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        $uriKey = static::uriKey();

        if (! is_null(optional($request)->orderByDirection)) {
            return $query;
        }

        if (! empty(static::$indexDefaultOrder)) {
            $query->getQuery()->orders = [];

            return $query->orderBy(
                key(static::$indexDefaultOrder),
                reset(static::$indexDefaultOrder)
            );
        }

        return $query;
    }
}

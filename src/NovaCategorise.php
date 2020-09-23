<?php

namespace Marshmallow\CategoriseResources;

use Laravel\Nova\Nova;
use Illuminate\Http\Request;

class NovaCategorise extends Nova
{
    public static function availableResourcesGrouped(Request $request)
    {
        return collect(self::availableResources($request))->filter(function ($resource) {
            return $resource::$displayInNavigation;
        })->groupBy(function ($resource) {
            if (property_exists($resource, 'group')) {
                return __(ucwords($resource::$group));
            }
            return __('Other');
        })->sortKeys();
    }
}

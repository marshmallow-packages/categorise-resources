<?php

namespace Marshmallow\CategoriseResources;

use Laravel\Nova\Nova;
use Illuminate\Http\Request;

class NovaCategorise extends Nova
{
    public static function availableResourcesGrouped(Request $request)
    {
        $collections = collect(self::availableResources($request))->filter(function ($resource) {
            return $resource::$displayInNavigation;
        })->groupBy(function ($resource) {
            if (property_exists($resource, 'group')) {
                return __(ucwords($resource::$group));
            }
            return __('Other');
        })->sortKeys();

        /**
         * Order the resources by $priority in there own group.
         */
        foreach ($collections as $key => $collection) {
        	$ordered = $collection->sortBy(function ($resource) {
        		return $resource::$priority ?? 9999;
        	});
        	$collections[$key] = $ordered;
        }

        return $collections;
    }
}

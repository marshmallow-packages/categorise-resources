<?php

namespace Marshmallow\CategoriseResources;

use Laravel\Nova\Nova;
use Illuminate\Http\Request;

class NovaCategorise extends Nova
{
    public static function availableResourcesGrouped(Request $request)
    {
        $collections = collect(self::availableResources($request))->filter(function ($resource) {

            /**
             * Check if this resource should be displayed in the menu.
             */
            return $resource::$displayInNavigation;
        })->sortBy(function ($collection) {

            /**
             * Order the groups by $group_priority property
             */
            return $collection::$group_priority ?? 9999;
        })->groupBy(function ($resource) {

            /**
             * Add this resource to the group name that is
             * provided in the resource property
             */
            if (property_exists($resource, 'group')) {
                return __(ucwords($resource::$group));
            }

            return __('Other');
        });

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

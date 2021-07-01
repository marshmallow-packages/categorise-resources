<?php

namespace Marshmallow\CategoriseResources;

use Laravel\Nova\Nova;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class NovaCategorise extends Nova
{
    public static function availableResourcesGrouped(Request $request)
    {
        $available_resources = self::availableResources($request);
        $group_setup = [];
        foreach ($available_resources as $resource) {
            $current_group = $resource::group();

            if (!array_key_exists($current_group, $group_setup)) {

                $group_priority = ($current_group == 'Other') ? 9999 : 999;

                $group_setup[$current_group] = [
                    'name' => $current_group,
                    'icon' => self::getDefaultIcon(),
                    'priority' => $group_priority,
                    'resources' => [],
                ];
            }

            /**
             * Set the group icon if its available
             */
            if (isset($resource::$group_icon)) {
                $group_setup[$current_group]['icon'] = $resource::$group_icon;
            }

            /**
             * Set the group priority if its available
             */
            if (isset($resource::$group_priority)) {
                $group_setup[$current_group]['priority'] = $resource::$group_priority;
            }


            /**
             * Check if its available for navigation
             */
            if ($resource::availableForNavigation($request)) {
                $resource_priority = (isset($resource::$priority)) ? $resource::$priority : 999;
                $group_setup[$current_group]['resources'][] = [
                    'resource' => $resource,
                    'priority' => $resource_priority,
                ];
            }
        }

        /**
         * Order the groups
         */
        usort($group_setup, function ($a, $b) {
            return $a['priority'] - $b['priority'];
        });

        /**
         * Order the resources in the groups
         */
        foreach ($group_setup as $key => $group) {
            $group_resources = $group['resources'];
            usort($group_resources, function ($a, $b) {
                return $a['priority'] - $b['priority'];
            });

            $group_setup[$key]['resources'] = $group_resources;
        }

        return $group_setup;
    }

    public static function getDefaultIcon()
    {
        return '<svg xmlns="http://www.w3.org/2000/svg" class="sidebar-icon" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0z" fill="none"/><path fill="var(--sidebar-icon)" d="M6 14l3 3v5h6v-5l3-3V9H6v5zm2-3h8v2.17l-3 3V20h-2v-3.83l-3-3V11zm3-9h2v3h-2zM3.502 5.874L4.916 4.46l2.122 2.12-1.414 1.415zm13.458.708l2.123-2.12 1.413 1.416-2.123 2.12z"/></svg>';
    }
}

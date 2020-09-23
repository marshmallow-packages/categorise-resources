<?php

namespace Marshmallow\CategoriseResources;

use Laravel\Nova\Nova;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\ServiceProvider;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views/nova-overrides', 'nova');

        Nova::serving(function (ServingNova $event) {
            Nova::script('nova-categorise-resources', __DIR__ . '/../dist/js/tool.js');
        });

        $service_provider = $this;
        Collection::macro('getCategorisedResourceSvgIcon', function () use ($service_provider) {
        	foreach ($this as $resource_name) {
        		if (isset($resource_name::$group_icon)) {
        			return $resource_name::$group_icon;
        		} else if (Str::lower($resource_name::$group) == 'other') {
        			return $service_provider->getDefaultIconForOthers();
        		}
        	}
        	return $service_provider->getDefaultIconForNoneSet();
		});
    }

    public function getDefaultIconForOthers()
    {
    	return '<svg class="sidebar-icon" viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g id="icon-shape"><path fill="var(--sidebar-icon)" d="M0,2 C0,0.8954305 0.898212381,0 1.99079514,0 L18.0092049,0 C19.1086907,0 20,0.887729645 20,2 L20,4 L0,4 L0,2 Z M1,5 L19,5 L19,18.0081158 C19,19.1082031 18.1073772,20 17.0049107,20 L2.99508929,20 C1.8932319,20 1,19.1066027 1,18.0081158 L1,5 Z M7,7 L13,7 L13,9 L7,9 L7,7 Z" id="Combined-Shape"></path></g></g></svg>';
    }

    public function getDefaultIconForNoneSet()
    {
    	return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="sidebar-icon"><path fill="var(--sidebar-icon)" d="M3 1h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2H3c-1.1045695 0-2-.8954305-2-2V3c0-1.1045695.8954305-2 2-2zm0 2v4h4V3H3zm10-2h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2h-4c-1.1045695 0-2-.8954305-2-2V3c0-1.1045695.8954305-2 2-2zm0 2v4h4V3h-4zM3 11h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2H3c-1.1045695 0-2-.8954305-2-2v-4c0-1.1045695.8954305-2 2-2zm0 2v4h4v-4H3zm10-2h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2h-4c-1.1045695 0-2-.8954305-2-2v-4c0-1.1045695.8954305-2 2-2zm0 2v4h4v-4h-4z"></path></svg>';
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

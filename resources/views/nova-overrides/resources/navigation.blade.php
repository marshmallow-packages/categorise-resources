@if (count(Nova::availableResources(request())))
@foreach (\Marshmallow\CategoriseResources\NovaCategorise::availableResourcesGrouped(request()) as $group => $resources)
<grouped-resource-collapsable header="{{ $group }}" icon="{{ $resources->getCategorisedResourceSvgIcon() }}"
    :last="@json($loop->last)">
    @foreach ($resources as $key => $resource)
    <li class="leading-wide {{ ($loop->last) ? 'mb-6' : 'mb-4' }} text-sm cursor-pointer nc-item" key="{{ $key }}" >
        <router-link :to="{
                    name: 'index',
                    params: {
                        resourceName: '{{ $resource::uriKey() }}'
                    }
                }" class="text-white ml-3 no-underline cursor-pointer dim nc-item-link" >
            {{ $resource::label() }}
        </router-link>
    </li>
    @endforeach
</grouped-resource-collapsable>
@endforeach
@endif

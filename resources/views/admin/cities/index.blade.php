<x-admin.iframe.countries_cities.layout
    title="cities" iframe-id-to-show="{{ \App\Iframes\CityIframe::$iframeCUId }}"
    :route="route('admin.cities.create', ['country' => $country_id])">
    @if($cities->count() > 0)
        @foreach($cities as $city)
            <tr class="border-b-2 border-b-blue-400">
                <td class="py-3 px-6">{{ $city->name }}</td>
                <td class="text-center py-3 px-6">
                    <input type="checkbox" class="w-4 h-4" disabled {{ ($city->is_active) ? 'checked' : '' }}>
                </td>
                <td class="flex justify-center py-3 px-6">
                    <x-svg.crud.edit
                        class="w-6 h-6 hover:cursor-pointer"
                        on-click="showCountryCityCUIframe('{{ \App\Iframes\CityIframe::$iframeCUId }}', '{{ route('admin.cities.city.edit', ['city' => $city->id])}}')"/>
                    <x-svg.crud.delete
                        class="w-6 h-6 hover:cursor-pointer"
                        on-click="submitDelete('{{ \App\Iframes\CityIframe::$iframeDId }}', '{{ route('admin.cities.city.delete', ['city' => $city->id]) }}')"/>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="3" class="text-center">No Data Found!</td>
        </tr>
    @endif
</x-admin.iframe.countries_cities.layout>

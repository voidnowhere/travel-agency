<x-admin.iframe.countries_cities.layout
    title="Cities" iframe-id-to-show="{{ \App\Iframes\CityIframe::$iframeId }}"
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
                        on-click="showCountryCRUDIframe('{{ \App\Iframes\CityIframe::$iframeId }}', '{{ route('admin.cities.city.edit', ['city' => $city->id])}}')"/>
                    <x-svg.crud.delete class="w-6 h-6 hover:cursor-pointer"
                                       :form-action="route('admin.cities.city.edit', ['city' => $city->id])"/>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="3" class="text-center">No Data Found!</td>
        </tr>
    @endif
    <script>
        function showCountryCRUDIframe(id, src) {
            const iframe = parent.document.querySelector(`#${id}`);
            iframe.src = src;
            iframe.classList.remove('hidden');
        }
    </script>
</x-admin.iframe.countries_cities.layout>

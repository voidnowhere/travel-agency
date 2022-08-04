<x-admin.iframe.countries_cities.layout
    title="countries" iframe-id-to-show="{{ \App\Iframes\CountryIframe::$iframeCUId }}"
    :route="route('admin.countries.create')">
    @if($countries->count() > 0)
        @foreach($countries as $country)
            <tr class="focus:bg-blue-50 border-b-2 border-b-blue-400 hover:bg-blue-50"
                tabindex="{{ $country->id }}"
            >
                <td class="py-3 px-6 hover:cursor-pointer"
                    onclick="focusTableTr({{ $country->id }}); loadCitiesIframe('{{ route('admin.cities', ['country' => $country]) }}');"
                >{{ $country->name }}</td>
                <td class="text-center py-3 px-6">
                    <input type="checkbox" class="w-4 h-4" disabled {{ ($country->is_active) ? 'checked' : '' }}>
                </td>
                <td class="flex justify-center py-3 px-6">
                    <x-svg.crud.edit
                        class="w-6 h-6 hover:cursor-pointer"
                        on-click="showCountryCityCUIframe('{{ \App\Iframes\CountryIframe::$iframeCUId }}', '{{ route('admin.countries.country.edit', ['country' => $country->id])}}')"/>
                    <x-svg.crud.delete
                        class="w-6 h-6 hover:cursor-pointer"
                        on-click="submitDelete('{{ \App\Iframes\CountryIframe::$iframeDId }}', '{{ route('admin.countries.country.delete', ['country' => $country->id]) }}')"/>
                </td>
            </tr>
        @endforeach
        <script>
            function focusTableTr(tabindex) {
                document.querySelectorAll('tr').forEach(tr => {
                    tr.classList.remove('bg-blue-50');
                });
                document.querySelector(`tr[tabindex="${tabindex}"]`).classList.add('bg-blue-50');
            }

            function loadCitiesIframe(src) {
                parent.document.getElementById('{{ \App\Iframes\CityIframe::$parentIframeId }}').src = src;
            }
        </script>
    @else
        <tr>
            <td colspan="3" class="text-center">No Data Found!</td>
        </tr>
    @endif
</x-admin.iframe.countries_cities.layout>

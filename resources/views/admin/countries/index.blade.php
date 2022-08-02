<x-admin.iframe.countries_cities.layout
    title="Countries" iframe-id-to-show="{{ \App\Iframes\CountryIframe::$iframeId }}"
    :route="route('admin.countries.create')">
    @if($countries->count() > 0)
        @foreach($countries as $country)
            <tr class="focus:bg-blue-50 border-b-2 border-b-blue-400 hover:bg-blue-50"
                tabindex="{{ $loop->iteration }}"
            >
                <td class="py-3 px-6 hover:cursor-pointer"
                    onclick="unfocusTableTrs(); focusTableTr({{ $loop->iteration }}); showCitiesIframe('{{ route('admin.cities', ['country' => $country]) }}');"
                >{{ $country->name }}</td>
                <td class="text-center py-3 px-6">
                    <input type="checkbox" class="w-4 h-4" disabled {{ ($country->is_active) ? 'checked' : '' }}>
                </td>
                <td class="flex justify-center py-3 px-6">
                    <x-svg.crud.edit
                        class="w-6 h-6 hover:cursor-pointer"
                        on-click="showCountryCRUDIframe('{{ \App\Iframes\CountryIframe::$iframeId }}', '{{ route('admin.countries.country.edit', ['country' => $country->id])}}')"/>
                    <x-svg.crud.delete class="w-6 h-6 hover:cursor-pointer"
                                       :form-action="route('admin.countries.country.edit', ['country' => $country->id])"/>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="3" class="text-center">No Data Found!</td>
        </tr>
    @endif
    <script>
        function unfocusTableTrs() {
            document.querySelectorAll('tr').forEach(tr => {
                tr.classList.remove('bg-blue-50');
            });
        }

        function focusTableTr(tabindex) {
            document.querySelector(`tr[tabindex="${tabindex}"]`).classList.add('bg-blue-50');
        }

        function showCountryCRUDIframe(id, src) {
            const iframe = parent.document.querySelector(`#${id}`);
            iframe.src = src;
            iframe.classList.remove('hidden');
        }

        function showCitiesIframe(src) {
            const iframe_cities = parent.document.querySelector('#iframe_cities');
            iframe_cities.src = src;
        }
    </script>
</x-admin.iframe.countries_cities.layout>

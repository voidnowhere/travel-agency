<x-admin.iframe.layout title="Countries">
    <x-table.layout>
        <x-table.thead :columns="['Name', 'Active']" :iframe-c-u-id="\App\Iframes\CountryIframe::$iframeCUId"
                       :route-create="route('admin.countries.create')"/>
        <x-table.tbody :count="$countries->count()">
            @foreach($countries as $country)
                <tr class="border-b-2 border-b-blue-400 hover:bg-blue-50"
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
                            :iframe-c-u-id="\App\Iframes\CountryIframe::$iframeCUId"
                            :route-u="route('admin.countries.country.edit', ['country' => $country->id])"/>
                        <x-svg.crud.delete
                            :iframe-d-id="\App\Iframes\CountryIframe::$iframeDId"
                            :route-d="route('admin.countries.country.delete', ['country' => $country->id])"/>
                    </td>
                </tr>
            @endforeach
            <x-table.js_focus_tr/>
            <script>
                function loadCitiesIframe(src) {
                    parent.document.getElementById('{{ \App\Iframes\CityIframe::$parentIframeId }}').src = src;
                }
            </script>
        </x-table.tbody>
    </x-table.layout>
    <x-admin.iframe.js.show_cu_iframe/>
    <x-admin.iframe.js.load_d_iframe/>
</x-admin.iframe.layout>

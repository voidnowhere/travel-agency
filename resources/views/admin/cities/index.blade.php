@php
    $columns = ['Name', 'Order', 'Active'];
@endphp
<x-admin.iframe.layout title="Countries">
    <x-table.layout>
        <x-table.thead :columns="$columns" :iframe-c-u-id="\App\Iframes\CityIframe::$iframeCUId"
                       :route-create="route('admin.cities.create', ['country' => $country_id])"/>
        <x-table.tbody :count="$cities->count()" :columns-count="count($columns)">
            @foreach($cities as $city)
                <tr class="border-b-2 border-b-blue-400 hover:bg-blue-50">
                    <td class="py-3 px-6 hover:cursor-pointer">{{ $city->name }}</td>
                    <td class="text-center py-3 px-6">{{ $city->order_by }}</td>
                    <td class="text-center py-3 px-6">
                        <input type="checkbox" class="w-4 h-4" disabled @checked($city->is_active)>
                    </td>
                    <td class="flex justify-center py-3 px-6">
                        <x-svg.crud.edit
                            :iframe-c-u-id="\App\Iframes\CityIframe::$iframeCUId"
                            :route-u="route('admin.cities.city.edit', ['city' => $city->id])"/>
                        <x-svg.crud.delete
                            :iframe-d-id="\App\Iframes\CityIframe::$iframeDId"
                            :route-d="route('admin.cities.city.delete', ['city' => $city->id])"/>
                    </td>
                </tr>
            @endforeach
        </x-table.tbody>
    </x-table.layout>
    <x-admin.iframe.js.show_cu_iframe/>
    <x-admin.iframe.js.load_d_iframe/>
</x-admin.iframe.layout>

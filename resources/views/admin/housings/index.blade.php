@php
    $columns = ['Name', 'Active', 'Residence', 'Category', 'Description', 'Max', 'Order'];
@endphp
<x-admin.iframe.layout title="Housings">
    <x-table.layout>
        <x-table.thead
            :columns="$columns"
            :iframe-c-u-id="\App\Iframes\HousingIframe::$iframeCUId"
            :route-create="route('admin.housings.create')"/>
        <x-table.tbody :count="$housings->count()" :columns-count="count($columns)">
            @foreach($housings as $housing)
                <tr @class(['border-b-2 border-b-blue-400', 'bg-blue-50' => $loop->even])>
                    <td class="py-3 px-6">{{ $housing->name }}</td>
                    <td class="text-center py-3 px-6">
                        <input type="checkbox" class="w-4 h-4" disabled @checked($housing->is_active)>
                    </td>
                    <td class="py-3 px-6">{{ $housing->residence->name }}</td>
                    <td class="py-3 px-6">{{ $housing->category->name }}</td>
                    <td class="py-3 px-6 min-w-[450px]">{{ $housing->description }}</td>
                    <td class="py-3 px-6 text-center">{{ $housing->for_max }}</td>
                    <td class="py-3 px-6 text-center">{{ $housing->order_by }}</td>
                    <td class="py-3 px-6">
                        <div class="flex justify-center">
                            <x-svg.crud.edit
                                :iframe-c-u-id="\App\Iframes\HousingIframe::$iframeCUId"
                                :route-u="route('admin.housings.housing.edit', ['housing' => $housing->id])"/>
                            <x-svg.crud.delete
                                :iframe-d-id="\App\Iframes\HousingIframe::$iframeDId"
                                :route-d="route('admin.housings.housing.delete', ['housing' => $housing->id])"/>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-table.tbody>
    </x-table.layout>
    <x-admin.iframe.js.show_cu_iframe/>
    <x-admin.iframe.js.load_d_iframe/>
</x-admin.iframe.layout>

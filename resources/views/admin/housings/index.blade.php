<x-admin.iframe.layout title="Housings">
    <x-table.layout>
        <x-table.thead
            :columns="['Name', 'Active', 'Residence', 'Category', 'Description', 'Max', 'Order']"
            :iframe-c-u-id="\App\Iframes\HousingIframe::$iframeCUId"
            :route-create="route('admin.housings.create')"/>
        <x-table.tbody :count="$housings->count()" :columns-count="7">
            @foreach($housings as $housing)
                <tr class="border-b-2 border-b-blue-400 {{ ($loop->even) ? 'bg-blue-50' : '' }}"
                    tabindex="{{ $housing->id }}"
                >
                    <td class="py-3 px-6">{{ $housing->name }}</td>
                    <td class="text-center py-3 px-6">
                        <input type="checkbox" class="w-4 h-4" disabled {{ ($housing->is_active) ? 'checked' : '' }}>
                    </td>
                    <td class="py-3 px-6">{{ $housing->residence->name }}</td>
                    <td class="py-3 px-6">{{ $housing->category->name }}</td>
                    <td class="py-3 px-6 min-w-[450px]">{{ $housing->description }}</td>
                    <td class="py-3 px-6 text-center">{{ $housing->for_max }}</td>
                    <td class="py-3 px-6 text-center">{{ $housing->order_by }}</td>
                    <td class="py-3 px-6">
                        <div class="flex">
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

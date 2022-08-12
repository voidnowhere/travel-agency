@php
    $columns = ['Name', 'Order', 'Active'];
@endphp
<x-admin.iframe.layout title="Residence Categories">
    <x-table.layout>
        <x-table.thead :columns="$columns"
                       :iframe-c-u-id="\App\Iframes\ResidenceCategoryIframe::$iframeCUId"
                       :route-create="route('admin.residence.categories.create')"/>
        <x-table.tbody :count="$residenceCategories->count()" :columns-count="count($columns)">
            @foreach($residenceCategories as $category)
                <tr @class(['border-b-2 border-b-blue-400', 'bg-blue-50' => $loop->even])>
                    <td class="py-3 px-6">{{ $category->name }}</td>
                    <td class="py-3 px-6 text-center">{{ $category->order_by }}</td>
                    <td class="text-center py-3 px-6">
                        <input type="checkbox" class="w-4 h-4" disabled @checked($category->is_active)>
                    </td>
                    <td class="flex justify-center py-3 px-6">
                        <x-svg.crud.edit
                            :iframe-c-u-id="\App\Iframes\ResidenceCategoryIframe::$iframeCUId"
                            :route-u="route('admin.residence.categories.category.edit', ['category' => $category->id])"/>
                        <x-svg.crud.delete
                            :iframe-d-id="\App\Iframes\ResidenceCategoryIframe::$iframeDId"
                            :route-d="route('admin.residence.categories.category.delete', ['category' => $category->id])"/>
                    </td>
                </tr>
            @endforeach
        </x-table.tbody>
    </x-table.layout>
    <x-admin.iframe.js.show_cu_iframe/>
    <x-admin.iframe.js.load_d_iframe/>
</x-admin.iframe.layout>

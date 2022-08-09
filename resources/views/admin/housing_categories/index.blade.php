<x-admin.iframe.layout title="Housing Categories">
    <x-table.layout>
        <x-table.thead :columns="['Name', 'Order', 'Active']"
                       :iframe-c-u-id="\App\Iframes\HousingCategoryIframe::$iframeCUId"
                       :route-create="route('admin.housing.categories.create')"/>
        <x-table.tbody :count="$housingCategories->count()" :columns-count="3">
            @foreach($housingCategories as $category)
                <tr class="border-b-2 border-b-blue-400 {{ ($loop->even) ? 'bg-blue-50' : '' }}"
                    tabindex="{{ $category->id }}"
                >
                    <td class="py-3 px-6">{{ $category->name }}</td>
                    <td class="py-3 px-6 text-center">{{ $category->order_by }}</td>
                    <td class="text-center py-3 px-6">
                        <input type="checkbox" class="w-4 h-4" disabled {{ ($category->is_active) ? 'checked' : '' }}>
                    </td>
                    <td class="flex justify-center py-3 px-6">
                        <x-svg.crud.edit
                            :iframe-c-u-id="\App\Iframes\HousingCategoryIframe::$iframeCUId"
                            :route-u="route('admin.housing.categories.category.edit', ['category' => $category->id])"/>
                        <x-svg.crud.delete
                            :iframe-d-id="\App\Iframes\HousingCategoryIframe::$iframeDId"
                            :route-d="route('admin.housing.categories.category.delete', ['category' => $category->id])"/>
                    </td>
                </tr>
            @endforeach
        </x-table.tbody>
    </x-table.layout>
    <x-admin.iframe.js.show_cu_iframe/>
    <x-admin.iframe.js.load_d_iframe/>
</x-admin.iframe.layout>

<x-admin.iframe.layout title="Residences">
    <x-table.layout>
        <x-table.thead
            :columns="['Name', 'Active', 'City', 'Category', 'Description', 'Website', 'Email', 'Contact', 'Tax', 'Order']"
            :iframe-c-u-id="\App\Iframes\ResidenceIframe::$iframeCUId"
            :route-create="route('admin.residences.create')"/>
        <x-table.tbody :count="$residences->count()" :columns-count="10">
            @foreach($residences as $residence)
                <tr class="border-b-2 border-b-blue-400 {{ ($loop->even) ? 'bg-blue-50' : '' }}"
                    tabindex="{{ $residence->id }}"
                >
                    <td class="py-3 px-6">{{ $residence->name }}</td>
                    <td class="text-center py-3 px-6">
                        <input type="checkbox" class="w-4 h-4" disabled {{ ($residence->is_active) ? 'checked' : '' }}>
                    </td>
                    <td class="py-3 px-6">{{ $residence->city->country->name . ', ' . $residence->city->name }}</td>
                    <td class="py-3 px-6">{{ $residence->category->name }}</td>
                    <td class="py-3 px-6 min-w-[450px]">{{ $residence->description }}</td>
                    <td class="py-3 px-6">
                        <a href="{{ $residence->website }}" class="underline" target="_blank">{{ $residence->name }}</a>
                    </td>
                    <td class="py-3 px-6">{{ $residence->email }}</td>
                    <td class="py-3 px-6">{{ $residence->contact }}</td>
                    <td class="py-3 px-6">{{ $residence->tax }}</td>
                    <td class="py-3 px-6 text-center">{{ $residence->order_by }}</td>
                    <td class="py-3 px-6">
                        <div class="flex">
                            <x-svg.crud.edit
                                :iframe-c-u-id="\App\Iframes\ResidenceIframe::$iframeCUId"
                                :route-u="route('admin.residences.residence.edit', ['residence' => $residence->id])"/>
                            <x-svg.crud.delete
                                :iframe-d-id="\App\Iframes\ResidenceIframe::$iframeDId"
                                :route-d="route('admin.residences.residence.delete', ['residence' => $residence->id])"/>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-table.tbody>
    </x-table.layout>
    <x-admin.iframe.js.show_cu_iframe/>
    <x-admin.iframe.js.load_d_iframe/>
</x-admin.iframe.layout>

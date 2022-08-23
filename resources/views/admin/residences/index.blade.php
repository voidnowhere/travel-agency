@php
    $columns = ['Name', 'Active', 'City', 'Category', 'Description', 'Email', 'Contact', 'Tax', 'Order'];
@endphp
<x-admin.iframe.layout title="Residences">
    <x-table.layout>
        <x-table.thead
            :columns="$columns"
            :iframe-c-u-id="\App\Iframes\ResidenceIframe::$iframeCUId"
            :route-create="route('admin.residences.create')"/>
        <x-table.tbody :count="$residences->count()" :columns-count="count($columns)">
            @foreach($residences as $residence)
                <tr @class(['border-b-2 border-b-blue-400', 'bg-blue-50' => $loop->even])>
                    <td class="py-3 px-6">
                        <a href="{{ $residence->website }}" class="underline" target="_blank">{{ $residence->name }}</a>
                    </td>
                    <td class="text-center py-3 px-6">
                        <input type="checkbox" class="w-4 h-4" disabled @checked($residence->is_active)>
                    </td>
                    <td class="py-3 px-6">{{ $residence->city->country->name . ', ' . $residence->city->name }}</td>
                    <td class="py-3 px-6">{{ $residence->category->name }}</td>
                    <td class="py-3 px-6 min-w-[450px]">{{ $residence->description }}</td>
                    <td class="py-3 px-6">
                        <a href="mailto:{{ $residence->email }}">{{ $residence->email }}</a>
                    </td>
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

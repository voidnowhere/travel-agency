@php
    $columns = ['Name', 'Order', 'Active'];
@endphp
<x-admin.iframe.layout title="Housing Formulas">
    <x-table.layout>
        <x-table.thead :columns="$columns"
                       :iframe-c-u-id="\App\Iframes\HousingFormulaIframe::$iframeCUId"
                       :route-create="route('admin.housing.formulas.create')"/>
        <x-table.tbody :count="$housingFormulas->count()" :columns-count="count($columns)">
            @foreach($housingFormulas as $formula)
                <tr @class(['border-b-2 border-b-blue-400', 'bg-blue-50' => $loop->even])>
                    <td class="py-3 px-6">{{ $formula->name }}</td>
                    <td class="py-3 px-6 text-center">{{ $formula->order_by }}</td>
                    <td class="text-center py-3 px-6">
                        <input type="checkbox" class="w-4 h-4" disabled @checked($formula->is_active)>
                    </td>
                    <td class="flex justify-center py-3 px-6">
                        <x-svg.crud.edit
                            :iframe-c-u-id="\App\Iframes\HousingFormulaIframe::$iframeCUId"
                            :route-u="route('admin.housing.formulas.formula.edit', ['formula' => $formula->id])"/>
                        <x-svg.crud.delete
                            :iframe-d-id="\App\Iframes\HousingFormulaIframe::$iframeDId"
                            :route-d="route('admin.housing.formulas.formula.delete', ['formula' => $formula->id])"/>
                    </td>
                </tr>
            @endforeach
        </x-table.tbody>
    </x-table.layout>
    <x-admin.iframe.js.show_cu_iframe/>
    <x-admin.iframe.js.load_d_iframe/>
</x-admin.iframe.layout>

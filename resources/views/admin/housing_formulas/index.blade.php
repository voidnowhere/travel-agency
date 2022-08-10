<x-admin.iframe.layout title="Housing Formulas">
    <x-table.layout>
        <x-table.thead :columns="['Name', 'Order', 'Active']"
                       :iframe-c-u-id="\App\Iframes\HousingFormulaIframe::$iframeCUId"
                       :route-create="route('admin.housing.formulas.create')"/>
        <x-table.tbody :count="$housingFormulas->count()" :columns-count="3">
            @foreach($housingFormulas as $formula)
                <tr class="border-b-2 border-b-blue-400 {{ ($loop->even) ? 'bg-blue-50' : '' }}"
                    tabindex="{{ $formula->id }}"
                >
                    <td class="py-3 px-6">{{ $formula->name }}</td>
                    <td class="py-3 px-6 text-center">{{ $formula->order_by }}</td>
                    <td class="text-center py-3 px-6">
                        <input type="checkbox" class="w-4 h-4" disabled {{ ($formula->is_active) ? 'checked' : '' }}>
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

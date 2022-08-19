@php
    $columns = ['Residence', 'Housing', 'Formula', 'Type', 'One price', 'One extra price', 'Min nights', 'Weekend', 'Kid bed', 'Extra bed'];
@endphp
<x-admin.iframe.layout title="Housing Prices">
    <x-table.layout>
        <x-table.thead
            :columns="$columns"
            :iframe-c-u-id="\App\Iframes\HousingPriceIframe::$iframeCUId"
            :route-create="route('admin.housing.prices.create')"/>
        <x-table.tbody :count="$housingPrices->count()" :columns-count="count($columns)">
            @foreach($housingPrices as $housingPrice)
                <tr @class(['border-b-2 border-b-blue-400', 'bg-blue-50' => $loop->even])>
                    <td class="py-3 px-6 text-center">{{ $housingPrice->housing->residence->name }}</td>
                    <td class="py-3 px-6 text-center">{{ $housingPrice->housing->name }}</td>
                    <td class="py-3 px-6 text-center">{{ $housingPrice->formula->name }}</td>
                    <td class="py-3 px-6 text-center">{{ $housingPrice->type_SHML }}</td>
                    <td class="py-3 px-6 text-center">{{ $housingPrice->for_one_price }}</td>
                    <td class="py-3 px-6 text-center">{{ $housingPrice->for_one_extra_price }}</td>
                    <td class="py-3 px-6 text-center">{{ $housingPrice->min_nights }}</td>
                    <td class="py-3 px-6">
                        <div class="flex justify-center items-center space-x-1">
                            <span>{{ $housingPrice->weekend_price }}</span>
                            <input type="checkbox" class="w-4 h-4" disabled @checked($housingPrice->weekend_is_active)>
                        </div>
                    </td>
                    <td class="py-3 px-6">
                        <div class="flex justify-center items-center space-x-1">
                            <span>{{ $housingPrice->kid_bed_price }}</span>
                            <input type="checkbox" class="w-4 h-4" disabled @checked($housingPrice->kid_bed_is_active)>
                        </div>
                    </td>
                    <td class="py-3 px-6">
                        <div class="flex justify-center items-center space-x-1">
                            <span>{{ $housingPrice->extra_bed_price }}</span>
                            <input type="checkbox" class="w-4 h-4"
                                   disabled @checked($housingPrice->extra_bed_is_active)>
                        </div>
                    </td>
                    <td class="py-3 px-6">
                        <div class="flex justify-center">
                            <x-svg.crud.edit
                                :iframe-c-u-id="\App\Iframes\HousingPriceIframe::$iframeCUId"
                                :route-u="route('admin.housing.prices.price.edit', ['price' => $housingPrice->id])"/>
                            <x-svg.crud.delete
                                :iframe-d-id="\App\Iframes\HousingPriceIframe::$iframeDId"
                                :route-d="route('admin.housing.prices.price.delete', ['price' => $housingPrice->id])"/>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-table.tbody>
    </x-table.layout>
    <x-admin.iframe.js.show_cu_iframe/>
    <x-admin.iframe.js.load_d_iframe/>
</x-admin.iframe.layout>

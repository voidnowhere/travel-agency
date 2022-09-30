@php
    $columns = ['From', 'To', 'For', 'Status', 'Price', 'Residence', 'Housing', 'Max', 'Formula'];
@endphp
<x-admin.iframe.layout title="Orders" :load-alpinejs="true">
    <x-table.layout>
        <x-table.thead :columns="$columns" :iframe-c-u-id="\App\Iframes\OrderIframe::$iframeCUId"
                       :route-create="route('admin.orders.create', ['user' => $user_id])"/>
        <x-table.tbody :count="$orders->count()" :columns-count="count($columns)">
            @foreach($orders as $order)
                <tr @class(['border-b-2 border-b-blue-400', 'bg-blue-50' => $loop->even])>
                    <td class="text-center py-3 px-6">{{ $order->date_from->toDateString() }}</td>
                    <td class="text-center py-3 px-6">{{ $order->date_to->toDateString() }}</td>
                    <td class="text-center py-3 px-6">{{ $order->for_count }}</td>
                    @if($order->status === \App\Enums\OrderStatuses::Processed->value)
                        <td class="text-center py-3 px-6">{{ $order->status }}</td>
                        <td class="text-center py-3 px-6 cursor-pointer"
                            onclick="showCUIframe('{{ \App\Iframes\OrderIframe::$priceDetailIframeId }}', '{{ route('admin.orders.order.details', ['order' => $order]) }}')">
                            <span class="border-b-blue-400 border-b-2">{{ $order->price_details_sum_price }}</span>
                        </td>
                    @else
                        <td class="text-center py-3 px-6" colspan="2" x-data="{ open: false }" @mouseout="open = false"
                            @mouseover="open = true">
                            <div class="relative">
                                <span>{{ $order->status }}</span>
                                <span x-show="open" style="display: none;"
                                      class="mt-12 py-2 w-[400px] border-2 border-blue-400 rounded-xl bg-blue-100 shadow-lg absolute left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                                    {{ $order->statusDetails->first()->description }}
                                </span>
                            </div>
                        </td>
                    @endif
                    <td class="text-center py-3 px-6">{{ $order->housing->residence->name }}</td>
                    <td class="text-center py-3 px-6">{{ $order->housing->name }}</td>
                    <td class="text-center py-3 px-6">{{ $order->housing->for_max }}</td>
                    <td class="text-center py-3 px-6">{{ $order->formula->name }}</td>
                    <td class="flex justify-center p-3 mr-2">
                        <x-svg.crud.edit
                            :iframe-c-u-id="\App\Iframes\OrderIframe::$iframeCUId"
                            :route-u="route('admin.orders.order.edit', ['order' => $order->id])"/>
                    </td>
                </tr>
            @endforeach
        </x-table.tbody>
    </x-table.layout>
    <x-admin.iframe.js.show_cu_iframe :iframe-id-to-c-lose="\App\Iframes\OrderIframe::$priceDetailIframeId"/>
</x-admin.iframe.layout>

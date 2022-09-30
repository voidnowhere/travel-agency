@php
    $columns = ['From To', 'Price'];
@endphp
<x-admin.iframe.layout title="Orders">
    <x-table.layout>
        <x-table.thead :columns="$columns" :iframe-c-u-id="\App\Iframes\UserOrderIframe::$iframeCUId"
                       :route-create="route('orders.create')"/>
        <x-table.tbody :count="$orders->count()" :columns-count="count($columns)">
            @foreach($orders as $order)
                <tr @class(['border-b-2 border-b-blue-400', 'bg-blue-50' => $loop->even])>
                    <td class="py-3 px-6 flex flex-col sm:flex-row justify-center items-center sm:space-x-1">
                        <span>{{ $order->date_from->toDateString() }}</span>
                        <span>{{ $order->date_to->toDateString() }}</span>
                    </td>
                    @if($order->status === \App\Enums\OrderStatuses::Unavailable->value)
                        <td class="text-center py-3 px-6">{{ $order->status }}</td>
                    @else
                        <td class="text-center py-3 px-6 cursor-pointer"
                            onclick="showCUIframe('{{ \App\Iframes\OrderIframe::$priceDetailIframeId }}', '{{ route('orders.order.details', ['order' => $order]) }}')">
                            <span class="border-b-blue-400 border-b-2">{{ $order->price_details_sum_price }}</span>
                        </td>
                    @endif
                    <td class="w-[37px]">
                        <x-svg.crud.edit
                            :iframe-c-u-id="\App\Iframes\UserOrderIframe::$iframeCUId"
                            :route-u="route('orders.order.edit', ['order' => $order->id])"/>
                    </td>
                </tr>
            @endforeach
        </x-table.tbody>
    </x-table.layout>
    <x-admin.iframe.js.show_cu_iframe/>
</x-admin.iframe.layout>

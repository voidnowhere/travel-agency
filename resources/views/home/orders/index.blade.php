@php
    $columns = ['From To', 'Price'];
@endphp
<x-admin.iframe.layout title="Orders">
    <x-table.layout>
        <x-table.thead :columns="$columns" :iframe-c-u-id="\App\Iframes\OrderIframe::$iframeCUId"
                       :route-create="route('orders.create')"/>
        <x-table.tbody :count="$orders->count()" :columns-count="count($columns)">
            @foreach($orders as $order)
                <tr @class(['border-b-2 border-b-blue-400', 'bg-blue-50' => $loop->even])>
                    <td class="py-3 px-6 flex flex-col sm:flex-row justify-center items-center sm:space-x-1">
                        <span>{{ $order->date_from->toDateString() }}</span>
                        <span>{{ $order->date_to->toDateString() }}</span>
                    </td>
                    <td class="text-center py-3 px-6">
                        {{ (($order->status === \App\Enums\OrderStatuses::Unavailable->value) ? $order->status : $order->price_details_sum_price) }}
                    </td>
                    <td class="w-[37px]">
                        <x-svg.crud.edit
                            :iframe-c-u-id="\App\Iframes\OrderIframe::$iframeCUId"
                            :route-u="route('orders.order.edit', ['order' => $order->id])"/>
                    </td>
                </tr>
            @endforeach
        </x-table.tbody>
    </x-table.layout>
    <x-admin.iframe.js.show_cu_iframe/>
</x-admin.iframe.layout>

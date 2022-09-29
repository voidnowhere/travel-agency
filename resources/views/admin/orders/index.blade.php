@php
    $columns = ['From', 'To', 'For', 'Status', 'Price', 'Residence', 'Housing', 'Max', 'Formula'];
@endphp
<x-admin.iframe.layout title="Orders">
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
                        <td class="text-center py-3 px-6">{{ $order->price_details_sum_price }}</td>
                    @else
                        <td class="text-center py-3 px-6" colspan="2">{{ $order->status }}</td>
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
    <x-admin.iframe.js.show_cu_iframe/>
</x-admin.iframe.layout>

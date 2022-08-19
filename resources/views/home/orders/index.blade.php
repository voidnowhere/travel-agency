@php
    $columns = ['From', 'To', 'For', 'Residence', 'Housing', 'Formula', 'Price'];
@endphp
<x-admin.iframe.layout title="Orders">
    <x-table.layout>
        <x-table.thead :columns="$columns" :iframe-c-u-id="\App\Iframes\OrderIframe::$iframeCUId"
                       :route-create="route('orders.create')"/>
        <x-table.tbody :count="$orders->count()" :columns-count="count($columns)">
            @foreach($orders as $order)
                <tr @class(['border-b-2 border-b-blue-400 ', 'bg-blue-50' => $loop->even])>
                    <td class="text-center py-3 px-6">{{ $order->date_from->toDateString() }}</td>
                    <td class="text-center py-3 px-6">{{ $order->date_to->toDateString() }}</td>
                    <td class="text-center py-3 px-6">{{ $order->for_count }}</td>
                    <td class="py-3 px-6 text-center hover:cursor-pointer">
                        <a class="underline" target="_blank"
                           href="{{ $order->residence->website }}">{{ $order->residence->name }}</a>
                    </td>
                    <td class="text-center py-3 px-6">{{ $order->housing->name }}</td>
                    <td class="text-center py-3 px-6">{{ $order->formula->name }}</td>
                    <td class="text-center py-3 px-6">
                        {{ (($order->status === \App\Enums\OrderStatuses::Unavailable->value) ? $order->status : $order->price()) }}
                    </td>
                    <td class="flex justify-center py-3 px-6">
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

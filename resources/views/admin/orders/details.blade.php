@php
    $columns = ['Type', 'From', 'To', 'Price'];
@endphp
<x-admin.iframe.layout title="Order Price Details">
    <div class="p-2 border-2 border-blue-400 rounded-xl bg-blue-100 shadow-lg h-full">
        <div class="flex justify-between mb-2">
            <h1 class="font-semibold">Price details</h1>
            <x-svg.close :iframe-id-to-close="\App\Iframes\OrderIframe::$priceDetailIframeId"/>
        </div>
        <x-table.layout>
            <x-table.thead :columns="$columns"/>
            <x-table.tbody :count="$priceDetails->count()" :columns-count="count($columns)">
                @foreach($priceDetails as $priceDetail)
                    <tr @class(['border-b-2 border-b-blue-400', 'bg-blue-50' => $loop->even])>
                        <td class="text-center py-3 px-6">{{ $priceDetail->type }}</td>
                        <td class="text-center py-3 px-6">{{ $priceDetail->date_from }}</td>
                        <td class="text-center py-3 px-6">{{ $priceDetail->date_to }}</td>
                        <td class="text-center py-3 px-6">{{ $priceDetail->price }}</td>
                    </tr>
                @endforeach
            </x-table.tbody>
        </x-table.layout>
    </div>
</x-admin.iframe.layout>

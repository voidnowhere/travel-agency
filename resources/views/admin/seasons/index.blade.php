@php
    $columns = ['Type', 'From', 'To', 'Description', 'Active'];
    $columnsCount = count($columns);
@endphp
<x-admin.iframe.layout title="Seasons">
    <x-table.layout>
        <x-table.thead :columns="$columns"
                       :iframe-c-u-id="\App\Iframes\SeasonIframe::$iframeCUId"
                       :route-create="route('admin.seasons.create')"/>
        <x-table.tbody :count="$seasonsCount" :columns-count="$columnsCount">
            @foreach($fourSeasons as $name => $seasons)
                @forelse ($seasons as $season)
                    <tr @class(['border-b-2 border-b-blue-400', 'bg-blue-50' => $loop->even])>
                        @if($loop->first)
                            <th rowspan="{{ $loop->count }}">{{ $name }}</th>
                        @endif
                        <td class="py-3 px-6 text-center">{{ $season->date_from }}</td>
                        <td class="py-3 px-6 text-center">{{ $season->date_to }}</td>
                        <td class="py-3 px-6">{{ $season->description }}</td>
                        <td class="text-center py-3 px-6">
                            <input type="checkbox" class="w-4 h-4" disabled @checked($season->is_active)>
                        </td>
                        <td class="py-3 px-6">
                            <div class="flex justify-center">
                                <x-svg.crud.edit
                                    :iframe-c-u-id="\App\Iframes\SeasonIframe::$iframeCUId"
                                    :route-u="route('admin.seasons.season.edit', ['season' => $season->id])"/>
                                <x-svg.crud.delete
                                    :iframe-d-id="\App\Iframes\SeasonIframe::$iframeDId"
                                    :route-d="route('admin.seasons.season.delete', ['season' => $season->id])"/>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr class="border-b-2 border-b-blue-400">
                        <th>{{ $name }}</th>
                        <td colspan="{{ $columnsCount }}" class="text-center">No Data Found!</td>
                    </tr>
                @endforelse
            @endforeach
        </x-table.tbody>
    </x-table.layout>
    <x-admin.iframe.js.show_cu_iframe/>
    <x-admin.iframe.js.load_d_iframe/>
</x-admin.iframe.layout>

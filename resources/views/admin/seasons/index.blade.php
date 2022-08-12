@php
    // seasons
    $specialSeasonsCount = $specialSeasons->count();
    $highSeasonsCount = $highSeasons->count();
    $mediumSeasonsCount = $mediumSeasons->count();
    $lowSeasonsCount = $lowSeasons->count();
    $seasonsCount = $specialSeasonsCount + $highSeasonsCount + $mediumSeasonsCount + $lowSeasonsCount;
    // columns
    $columns = ['Type', 'From', 'To', 'Description', 'Active'];
    $columnsCount = count($columns);
@endphp
<x-admin.iframe.layout title="Seasons">
    <x-table.layout>
        <x-table.thead :columns="$columns"
                       :iframe-c-u-id="\App\Iframes\SeasonIframe::$iframeCUId"
                       :route-create="route('admin.seasons.create')"/>
        <x-table.tbody :count="$seasonsCount" :columns-count="$columnsCount">
            @if($specialSeasonsCount > 0)
                @foreach($specialSeasons as $specialSeason)
                    <tr class="border-b-2 border-b-blue-400 {{ ($loop->even) ? 'bg-blue-50' : '' }}">
                        @if($loop->first)
                            <th rowspan="{{ $specialSeasonsCount }}">{{ \App\Enums\SeasonTypes::Special->name }}</th>
                        @endif
                        <td class="py-3 px-6 text-center">{{ $specialSeason->date_from }}</td>
                        <td class="py-3 px-6 text-center">{{ $specialSeason->date_to }}</td>
                        <td class="py-3 px-6">{{ $specialSeason->description }}</td>
                        <td class="text-center py-3 px-6">
                            <input type="checkbox" class="w-4 h-4" disabled @checked($specialSeason->is_active)>
                        </td>
                        <td class="py-3 px-6">
                            <div class="flex justify-center">
                                <x-svg.crud.edit
                                    :iframe-c-u-id="\App\Iframes\SeasonIframe::$iframeCUId"
                                    :route-u="route('admin.seasons.season.edit', ['season' => $specialSeason])"/>
                                <x-svg.crud.delete
                                    :iframe-d-id="\App\Iframes\SeasonIframe::$iframeDId"
                                    :route-d="route('admin.seasons.season.delete', ['season' => $specialSeason])"/>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <th>{{ \App\Enums\SeasonTypes::Special->name }}</th>
                    <td colspan="{{ $columnsCount }}" class="text-center">No Data Found!</td>
                </tr>
            @endif
            @if($highSeasonsCount > 0)
                @foreach($highSeasons as $highSeason)
                    <tr class="border-b-2 border-b-blue-400 {{ ($loop->even) ? 'bg-blue-50' : '' }}">
                        @if($loop->first)
                            <th rowspan="{{ $highSeasonsCount }}">{{ \App\Enums\SeasonTypes::High->name }}</th>
                        @endif
                        <td class="py-3 px-6 text-center">{{ $highSeason->date_from }}</td>
                        <td class="py-3 px-6 text-center">{{ $highSeason->date_to }}</td>
                        <td class="py-3 px-6">{{ $highSeason->description }}</td>
                        <td class="text-center py-3 px-6">
                            <input type="checkbox" class="w-4 h-4" disabled @checked($highSeason->is_active)>
                        </td>
                        <td class="py-3 px-6">
                            <div class="flex justify-center">
                                <x-svg.crud.edit
                                    :iframe-c-u-id="\App\Iframes\SeasonIframe::$iframeCUId"
                                    :route-u="route('admin.seasons.season.edit', ['season' => $highSeason])"/>
                                <x-svg.crud.delete
                                    :iframe-d-id="\App\Iframes\SeasonIframe::$iframeDId"
                                    :route-d="route('admin.seasons.season.delete', ['season' => $highSeason])"/>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <th>{{ \App\Enums\SeasonTypes::High->name }}</th>
                    <td colspan="{{ $columnsCount }}" class="text-center">No Data Found!</td>
                </tr>
            @endif
            @if($mediumSeasonsCount > 0)
                @foreach($mediumSeasons as $mediumSeason)
                    <tr class="border-b-2 border-b-blue-400 {{ ($loop->even) ? 'bg-blue-50' : '' }}">
                        @if($loop->first)
                            <th rowspan="{{ $mediumSeasonsCount }}">{{ \App\Enums\SeasonTypes::Medium->name }}</th>
                        @endif
                        <td class="py-3 px-6 text-center">{{ $mediumSeason->date_from }}</td>
                        <td class="py-3 px-6 text-center">{{ $mediumSeason->date_to }}</td>
                        <td class="py-3 px-6">{{ $mediumSeason->description }}</td>
                        <td class="text-center py-3 px-6">
                            <input type="checkbox" class="w-4 h-4" disabled @checked($mediumSeason->is_active)>
                        </td>
                        <td class="py-3 px-6">
                            <div class="flex justify-center">
                                <x-svg.crud.edit
                                    :iframe-c-u-id="\App\Iframes\SeasonIframe::$iframeCUId"
                                    :route-u="route('admin.seasons.season.edit', ['season' => $mediumSeason])"/>
                                <x-svg.crud.delete
                                    :iframe-d-id="\App\Iframes\SeasonIframe::$iframeDId"
                                    :route-d="route('admin.seasons.season.delete', ['season' => $mediumSeason])"/>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <th>{{ \App\Enums\SeasonTypes::Medium->name }}</th>
                    <td colspan="{{ $columnsCount }}" class="text-center">No Data Found!</td>
                </tr>
            @endif
            @if($lowSeasonsCount > 0)
                @foreach($lowSeasons as $lowSeason)
                    <tr class="border-b-2 border-b-blue-400 {{ ($loop->even) ? 'bg-blue-50' : '' }}">
                        @if($loop->first)
                            <th rowspan="{{ $lowSeasonsCount }}">{{ \App\Enums\SeasonTypes::Low->name }}</th>
                        @endif
                        <td class="py-3 px-6 text-center">{{ $lowSeason->date_from }}</td>
                        <td class="py-3 px-6 text-center">{{ $lowSeason->date_to }}</td>
                        <td class="py-3 px-6">{{ $lowSeason->description }}</td>
                        <td class="text-center py-3 px-6">
                            <input type="checkbox" class="w-4 h-4" disabled @checked($lowSeason->is_active)>
                        </td>
                        <td class="py-3 px-6">
                            <div class="flex justify-center">
                                <x-svg.crud.edit
                                    :iframe-c-u-id="\App\Iframes\SeasonIframe::$iframeCUId"
                                    :route-u="route('admin.seasons.season.edit', ['season' => $lowSeason])"/>
                                <x-svg.crud.delete
                                    :iframe-d-id="\App\Iframes\SeasonIframe::$iframeDId"
                                    :route-d="route('admin.seasons.season.delete', ['season' => $lowSeason])"/>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <th>{{ \App\Enums\SeasonTypes::Low->name }}</th>
                    <td colspan="{{ $columnsCount }}" class="text-center">No Data Found!</td>
                </tr>
            @endif
        </x-table.tbody>
    </x-table.layout>
    <x-admin.iframe.js.show_cu_iframe/>
    <x-admin.iframe.js.load_d_iframe/>
</x-admin.iframe.layout>

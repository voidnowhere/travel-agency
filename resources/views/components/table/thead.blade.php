@props(['columns', 'iframeCUId' => null, 'routeCreate' => null])
<thead class="text-white bg-blue-400">
@foreach($columns as $column)
    <th class="py-3 px-6">{{ $column }}</th>
@endforeach
@if($routeCreate && $iframeCUId)
    <th class="flex justify-center py-3 pr-3">
        <x-svg.crud.add
            class="w-6 h-6 hover:cursor-pointer"
            on-click="showCUIframe('{{ $iframeCUId }}', '{{ $routeCreate }}')"/>
    </th>
@endif
</thead>

@props(['title', 'iframeIdToShow', 'route'])
<x-admin.iframe.layout :title="$title">
    <div class="rounded-t-lg overflow-hidden">
        <table class="w-full">
            <thead class="text-white bg-blue-400">
            <th class="py-3 px-6 text-left">Name</th>
            <th class="py-3 px-6">Status</th>
            <th class="flex justify-center py-3 px-6">
                <x-svg.crud.add class="w-6 h-6 hover:cursor-pointer"
                                on-click="showCountryCRUDIframe('{{ $iframeIdToShow }}', '{{ $route }}')"/>
            </th>
            </thead>
            <tbody>
            {{ $slot }}
            </tbody>
        </table>
    </div>
</x-admin.iframe.layout>

@props(['title', 'iframeIdToShow', 'route'])
<x-admin.iframe.layout :title="$title">
    <div class="rounded-t-lg overflow-hidden">
        <table class="w-full">
            <thead class="text-white bg-blue-400">
            <th class="py-3 px-6 text-left">Name</th>
            <th class="py-3 px-6">Active</th>
            <th class="flex justify-center py-3 px-6">
                <x-svg.crud.add class="w-6 h-6 hover:cursor-pointer"
                                on-click="showCountryCityCUIframe('{{ $iframeIdToShow }}', '{{ $route }}')"/>
            </th>
            </thead>
            <tbody>
            {{ $slot }}
            </tbody>
        </table>
        <iframe id="{{ $iframeIdToShow }}"
                class="w-96 h-full absolute hidden top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></iframe>
        <script>
            function showCountryCityCUIframe(id, src) {
                const iframe = document.getElementById(id);
                iframe.src = src;
                iframe.classList.remove('hidden');
            }
        </script>
    </div>
</x-admin.iframe.layout>

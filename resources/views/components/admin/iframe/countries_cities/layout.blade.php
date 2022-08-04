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
        <script>
            function showCountryCityCUIframe(id, src) {
                let iframe = parent.document.getElementById(id);
                iframe.src = src;
                iframe.classList.remove('hidden');
            }

            function submitDelete(id, src) {
                let iframe = parent.document.getElementById(id);
                iframe.src = src;
            }
        </script>
    </div>
</x-admin.iframe.layout>

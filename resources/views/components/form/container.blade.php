@props(['title', 'iframeIdToClose'])
<main class="h-full flex items-center justify-center">
    <div class="p-2 border-2 border-blue-400 rounded-xl bg-blue-100 shadow-lg">
        <div class="flex justify-between mb-2">
            <h1 class="font-semibold">{{ $title }}</h1>
            <x-svg.close :iframe-id-to-close="$iframeIdToClose"/>
        </div>
        {{ $slot }}
    </div>
</main>

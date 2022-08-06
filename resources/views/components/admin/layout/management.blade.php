@props(['name', 'oneIframe' => true])
<x-admin.layout.base>
    <h1 class="mt-8 mb-10 text-center text-3xl">
        <span class="border-b-4 rounded-lg border-b-blue-400 font-semibold">{{ $name }}</span>
    </h1>
    <div class="h-full flex justify-center {{ (!$oneIframe) ? 'flex-col lg:flex-row' : '' }}">
        {{ $slot }}
    </div>
</x-admin.layout.base>

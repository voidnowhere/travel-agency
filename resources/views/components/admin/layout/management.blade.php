@props(['name'])
<x-admin.layout.base>
    <h1 class="mt-8 text-center text-3xl">
        <span class="border-b-4 rounded-lg border-b-blue-400 font-semibold">{{ $name }}</span>
    </h1>
    <div class="mt-9 h-full flex flex-col lg:flex-row">
        {{ $slot }}
    </div>
</x-admin.layout.base>

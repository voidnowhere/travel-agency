@props(['title', 'iframeIdToClose', 'countryOrCity' => null, 'patchMethod' => false])
<x-admin.iframe.layout :title="$title" body-class="h-screen flex items-center">
    <div class="pr-4 py-3 bg-blue-100 rounded-3xl border-2 border-blue-400">
        <div class="flex justify-end">
            <x-svg.close
                class="w-7 h-7 hover:cursor-pointer transition-all duration-100 rounded-full hover:border-2 hover:border-blue-500"
                :iframe-id-to-close="$iframeIdToClose"/>
        </div>
        <form method="post" class="space-x-4 space-y-5">
            @csrf
            @if($patchMethod)
                @method('PATCH')
            @endif
            <div class="space-x-4">
                <label
                    class="p-1 text-lg rounded border-b-2 border-b-blue-400 border-r-2 border-r-blue-400">Name</label>
                <input type="text" name="name" required value="{{ old('name') ?? $countryOrCity->name ?? '' }}"
                       class="p-1 bg-gray-100 border-2 focus:bg-gray-100 focus:outline-gray-500">
                @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="space-x-4">
                <label
                    class="p-1 text-lg rounded border-b-2 border-b-blue-400 border-r-2 border-r-blue-400">Status</label>
                <input type="checkbox" name="is_active"
                       class="w-4 h-4" {{ (old('is_active') ?? $countryOrCity->is_active ?? false) ? 'checked' : '' }}>
            </div>
            <div class="text-right">
                <button type="submit">
                <span
                    class="px-5 py-1 text-xl rounded-full hover:font-semibold bg-blue-400 hover:bg-blue-500 transition-all duration-100 hover:text-white"
                >
                    create
                </span>
                </button>
            </div>
        </form>
    </div>
</x-admin.iframe.layout>

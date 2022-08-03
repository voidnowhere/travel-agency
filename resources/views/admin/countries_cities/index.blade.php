<x-admin.layout.management name="Countries and Cities management">
    <iframe id="{{ \App\Iframes\CountryIframe::$parentIframeId }}" class="p-2 w-full grow"
            src="{{ route('admin.countries') }}"></iframe>
    <iframe id="{{ \App\Iframes\CityIframe::$parentIframeId }}" class="p-2 w-full grow"></iframe>
</x-admin.layout.management>

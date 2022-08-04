<x-admin.layout.management name="Countries and Cities management">
    <iframe id="{{ \App\Iframes\CountryIframe::$parentIframeId }}" class="p-2 w-full grow"
            src="{{ route('admin.countries') }}"></iframe>
    <iframe id="{{ \App\Iframes\CountryIframe::$iframeCUId }}"
            class="w-96 h-60 absolute hidden top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></iframe>
    <iframe id="{{ \App\Iframes\CountryIframe::$iframeDId }}" class="hidden"></iframe>
    <iframe id="{{ \App\Iframes\CityIframe::$parentIframeId }}" class="p-2 w-full grow"></iframe>
    <iframe id="{{ \App\Iframes\CityIframe::$iframeCUId }}"
            class="w-96 h-60 absolute hidden top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></iframe>
    <iframe id="{{ \App\Iframes\CityIframe::$iframeDId }}" class="hidden"></iframe>
</x-admin.layout.management>

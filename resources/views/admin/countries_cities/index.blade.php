<x-admin.layout.management name="Countries and Cities Management" :one-iframe="false">
    <iframe id="{{ \App\Iframes\CountryIframe::$parentIframeId }}" class="p-2 w-full grow"
            src="{{ route('admin.countries') }}"></iframe>
    <x-admin.iframe.cu.layout :id="\App\Iframes\CountryIframe::$iframeCUId" width-class="w-96" height-class="h-96"/>
    <x-admin.iframe.d.layout :id="\App\Iframes\CountryIframe::$iframeDId"/>
    <iframe id="{{ \App\Iframes\CityIframe::$parentIframeId }}" class="p-2 w-full grow"></iframe>
    <x-admin.iframe.cu.layout :id="\App\Iframes\CityIframe::$iframeCUId" width-class="w-96" height-class="h-96"/>
    <x-admin.iframe.d.layout :id="\App\Iframes\CityIframe::$iframeDId"/>
</x-admin.layout.management>

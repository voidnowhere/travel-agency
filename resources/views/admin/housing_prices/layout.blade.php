<x-admin.layout.management name="Housing Prices Management">
    <iframe id="{{ \App\Iframes\HousingPriceIframe::$parentIframeId }}" class="w-full"
            src="{{ route('admin.housing.prices') }}"></iframe>
    <x-admin.iframe.cu.layout :id="\App\Iframes\HousingPriceIframe::$iframeCUId"
                              width-class="w-2/3" height-class="h-screen"/>
    <x-admin.iframe.d.layout :id="\App\Iframes\HousingPriceIframe::$iframeDId"/>
</x-admin.layout.management>

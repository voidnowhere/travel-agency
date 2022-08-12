<x-admin.layout.management name="Housing Prices Management">
    <iframe id="{{ \App\Iframes\HousingPriceIframe::$parentIframeId }}" class="w-full"
            src="{{ route('admin.housing.prices') }}"></iframe>
    <iframe id="{{ \App\Iframes\HousingPriceIframe::$iframeCUId }}"
            class="w-2/3 h-screen absolute hidden top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></iframe>
    <iframe id="{{ \App\Iframes\HousingPriceIframe::$iframeDId }}" class="hidden"></iframe>
</x-admin.layout.management>

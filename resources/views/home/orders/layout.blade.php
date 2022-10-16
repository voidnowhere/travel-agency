<x-home.layout>
    <div class="flex justify-center grow pb-5 mt-5 sm:mt-0">
        <iframe id="{{ \App\Iframes\UserOrderIframe::$parentIframeId }}" class="px-2 md:px-0 w-full md:w-2/3 lg:w-1/2"
                src="{{ route('orders') }}"></iframe>
        <x-admin.iframe.cu.layout :id="\App\Iframes\UserOrderIframe::$iframeCUId"
                                  width-class="w-full md:w-2/3" height-class="h-full md:h-3/4"/>
        <iframe id="{{ \App\Iframes\OrderIframe::$priceDetailIframeId }}"
                class="absolute w-11/12 md:w-5/12 h-2/3 md:h-2/4 hidden top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></iframe>
    </div>
</x-home.layout>

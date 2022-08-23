<x-home.layout>
    <div class="flex justify-center grow pb-5">
        <iframe id="{{ \App\Iframes\OrderIframe::$parentIframeId }}" class="px-2 md:px-0 w-full md:w-2/3 lg:w-1/2"
                src="{{ route('orders') }}"></iframe>
        <x-admin.iframe.cu.layout :id="\App\Iframes\OrderIframe::$iframeCUId"
                                  width-class="w-full md:w-2/3"
                                  height-class="h-full md:h-3/4"/>
    </div>
</x-home.layout>

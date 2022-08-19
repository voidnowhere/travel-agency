<x-home.layout>
    <div class="flex justify-center grow pb-5">
        <iframe id="{{ \App\Iframes\OrderIframe::$parentIframeId }}" class="w-3/5"
                src="{{ route('orders') }}"></iframe>
        <x-admin.iframe.cu.layout :id="\App\Iframes\OrderIframe::$iframeCUId" width-class="w-2/3" height-class="h-2/3"/>
    </div>
</x-home.layout>

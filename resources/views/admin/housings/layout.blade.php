<x-admin.layout.management name="Housings Management">
    <iframe id="{{ \App\Iframes\HousingIframe::$parentIframeId }}" class="w-full"
            src="{{ route('admin.housings') }}"></iframe>
    <x-admin.iframe.cu.layout :id="\App\Iframes\HousingIframe::$iframeCUId"
                              width-class="w-2/3" height-class="h-screen"/>
    <x-admin.iframe.d.layout :id="\App\Iframes\HousingIframe::$iframeDId"/>
</x-admin.layout.management>

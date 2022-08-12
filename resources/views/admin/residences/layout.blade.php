<x-admin.layout.management name="Residences Management">
    <iframe id="{{ \App\Iframes\ResidenceIframe::$parentIframeId }}" class="w-full"
            src="{{ route('admin.residences') }}"></iframe>
    <x-admin.iframe.cu.layout :id="\App\Iframes\ResidenceIframe::$iframeCUId"
                              width-class="w-2/3" height-class="h-screen"/>
    <iframe id="{{ \App\Iframes\ResidenceIframe::$iframeDId }}" class="hidden"></iframe>
</x-admin.layout.management>

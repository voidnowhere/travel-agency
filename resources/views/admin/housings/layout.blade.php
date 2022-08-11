<x-admin.layout.management name="Housings Management">
    <iframe id="{{ \App\Iframes\HousingIframe::$parentIframeId }}" class="w-full"
            src="{{ route('admin.housings') }}"></iframe>
    <iframe id="{{ \App\Iframes\HousingIframe::$iframeCUId }}"
            class="w-2/3 h-screen absolute hidden top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></iframe>
    <iframe id="{{ \App\Iframes\HousingIframe::$iframeDId }}" class="hidden"></iframe>
</x-admin.layout.management>
